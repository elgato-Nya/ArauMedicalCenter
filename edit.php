<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            text-align: left;
        }

        input[type=text] {
            width: 100%;
            font-size: 18px;
            margin: 10px 0;
            padding: 11px;
            border: none;
            border-bottom: 1px solid black;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php 
        include('database.php');
        session_start();  
        if($_SESSION["loggedin"] == "yes"){
            $username = $_SESSION["username"];
            $userType = $_SESSION["userType"];
            if($userType=="patient"){

                $personalInfoSql = "SELECT * FROM patients WHERE patientUsername = '$username'";
                $personalInfoResult = mysqli_query($conn, $personalInfoSql);
                $personalInfoRow = mysqli_fetch_assoc($personalInfoResult);
                
                $patientID = $personalInfoRow["patientID"];

                $medicalInfoSql = "SELECT * FROM medicalinfo WHERE patientID = '$patientID'";
                $medicalInfoResult = mysqli_query($conn, $medicalInfoSql);
                $medicalInfoRow = mysqli_fetch_assoc($medicalInfoResult);
            }else if($userType=="staff"){

                $personalInfoSql = "SELECT * FROM staffs WHERE staffUsername = '$username'";
                $personalInfoResult = mysqli_query($conn, $personalInfoSql);
                $personalInfoRow = mysqli_fetch_assoc($personalInfoResult);

                $staffID = $personalInfoRow["staffID"];

                $doctorInfoSql = "SELECT * FROM doctorinfo WHERE staffID = '$staffID'";
                $doctorInfoResult = mysqli_query($conn, $doctorInfoSql);
                $doctorInfoRow = mysqli_fetch_assoc($doctorInfoResult);
            }
        }else{  header("location: login.php");  }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST["update"])) {
                $newName = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $newUsername = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $newPhoneNumber = filter_input(INPUT_POST, 'Phone_Number', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $newAddress = filter_input(INPUT_POST, 'Address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $newEmail = filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL);

                if ($userType == "patient") {
                    $newHeight = filter_input(INPUT_POST, 'Height', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $newWeight = filter_input(INPUT_POST, 'Weight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $newAllergies = filter_input(INPUT_POST, 'Allergies', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                } else if ($userType == "staff") {
                    $newSpecialty = filter_input(INPUT_POST, 'Specialty', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $newEducation = filter_input(INPUT_POST, 'Education', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $newQualification = filter_input(INPUT_POST, 'Qualification', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
            }

            $_SESSION["error"] = false;


        
            if($newName == "" || $newUsername == "" || $newPhoneNumber == "" || $newAddress == "" || $newEmail == "" || 
            ($userType == "patient" && ($newHeight == "" || $newWeight == "")) || 
            ($userType == "staff" && ($newSpecialty == "" || $newEducation == "" || $newQualification == ""))){
                echo "<script>alert('Please fill in all the information.')</script>";
                $_SESSION["error"] = true;
            }else if(!preg_match("/^[a-zA-Z ]*$/",$newName)){
                echo "<script>alert('Only letters and white space allowed for name.')</script>";
                $_SESSION["error"] = true;
            }else if(!preg_match("/^[0-9]{10,11}$/",$newPhoneNumber)){
                echo "<script>alert('Phone number must be in the format xxxxxxxxxx.')</script>";
                $_SESSION["error"] = true;
            }else if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
                echo "<script>alert('Invalid email format.')</script>";
                $_SESSION["error"] = true;
            }if($userType == "patient"){
                    if(!preg_match("/^\d{1,3}(\.\d{1,2})?$/",$newHeight)){
                        echo "<script>alert('Height must be in the format xxx.')</script>";
                        $_SESSION["error"] = true;
                    }else if(!preg_match("/^\d{1,3}(\.\d{1,2})?$/", $newWeight)) {
                        echo "<script>alert('Weight must be in the format xx or xxx or xx.xx.')</script>";
                        $_SESSION["error"] = true;
                    }
            }

            if($_SESSION["error"] == false){                
                if($userType == "patient"){
                    $updatePersonalInfoSql = "UPDATE patients SET 
                    patientName = '$newName',
                    patientUsername = '$newUsername',
                    patientPhoneNum = '$newPhoneNumber',
                    patientAddress = '$newAddress',
                    patientEmail = '$newEmail'
                    WHERE patientID = '$patientID'";

                    $updateMedicalInfoSql = "UPDATE medicalinfo SET 
                    patientHeight = '$newHeight',
                    patientWeight = '$newWeight'
                    WHERE patientID = '$patientID'"; 
                }else if($userType == "staff"){
                    $updatePersonalInfoSql = "UPDATE staffs SET 
                    staffName = '$newName',
                    staffUsername = '$newUsername',
                    staffPhoneNum = '$newPhoneNumber',
                    staffAddress = '$newAddress',
                    staffEmail = '$newEmail'
                    WHERE staffUsername = '$username'";

                    $updateDoctorInfoSql = "UPDATE doctorinfo SET
                    specialty = '$newSpecialty',
                    education = '$newEducation',
                    qualification = '$newQualification'
                    WHERE staffID = '$staffID'";
                }
            }
            if($_SESSION["error"] == false){
                
                try {
                    mysqli_query($conn, $updatePersonalInfoSql);
                    ($userType == "patient" ? mysqli_query($conn, $updateMedicalInfoSql) : mysqli_query($conn, $updateDoctorInfoSql));
                    $_SESSION["edited"] = "yes";
                    $_SESSION["username"] = $newUsername;
                    header("location: success.php?type=edit");        
                } catch(mysqli_sql_exception $e) {
                    echo "The username has already been taken.";
                }
                
            }
        }
    ?>
    
    <h1>Edit Profile</h1>
    <form  action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
    
    <table>
        <tr> <th>Personal Information</th> </tr>
        <?php
        $fields = [
                "Name" => $userType == "patient" ? "patientName" : "staffName",
                "Username" => $userType == "patient" ? "patientUsername" : "staffUsername",
                "Phone Number" => $userType == "patient" ? "patientPhoneNum" : "staffPhoneNum",
                "Address" => $userType == "patient" ? "patientAddress" : "staffAddress",
                "Email" => $userType == "patient" ? "patientEmail" : "staffEmail"
            ];

        foreach ($fields as $label => $field) {
            echo "<tr>";
            echo "<th>$label </th>";
            echo "<td><input type='text' name='$label' placeholder='$label' value='" . (empty($personalInfoRow) ? $label : $personalInfoRow[$field]) . "' ?></td>";
            echo "</tr>";
        }
        ?>
        <tr> <th>Medical Information</td> </tr>
        <?php
        if ($userType == "patient"){
            $fields = [
                "Height" => "patientHeight",
                "Weight" => "patientWeight",
                "Allergies" => "patientAllergies",
            ];
            foreach ($fields as $label => $field) {
                echo "<tr>";
                echo "<th>$label" . (($label == "Weight") ? " (kg)" : (($label == "Height") ? " (cm)" : "")) . "</th>";
                echo "<td><input type='text' name='$label' placeholder='$label' value='" . (empty($medicalInfoRow) ? $label : $medicalInfoRow[$field]) . "'></td>";
                echo "</tr>";
            }
            }else if($userType == "staff"){
                $fields = [
                    "Specialty" => "specialty",
                    "Education" => "education",
                    "Qualification" => "qualification",
                ];
                foreach ($fields as $label => $field) {
                    echo "<tr>";
                    echo "<th>$label </th>";
                    echo "<td><input type='text' name='$label' placeholder='$label' value='" . (empty($doctorInfoRow) ? $label : $doctorInfoRow[$field]) . "'></td>";
                    echo "</tr>";
                }
            }
        ?>
        <tr>
            <td><input type="submit" name="update" value="Update"></td>
        </tr>
    </table>
    </form>
</body>
</html>
