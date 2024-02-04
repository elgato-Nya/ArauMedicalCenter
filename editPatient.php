<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
    <style>
        body {
            background-color: #f2f2f2;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
        include('header.php');
        $id = $_GET['id'];

        $sqlPersonal = "SELECT * FROM patients WHERE patientID = '$id'";
        $resultPersonal = mysqli_query($conn, $sqlPersonal);
        $rowPersonal = mysqli_fetch_assoc($resultPersonal);

        $sqlMedical = "SELECT * FROM medicalinfo WHERE patientID = '$id'";
        $resultMedical = mysqli_query($conn, $sqlMedical);
        $rowMedical = mysqli_fetch_assoc($resultMedical);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST["update"]) == true){
                $weight = filter_input(INPUT_POST, 'patientWeight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $height = filter_input(INPUT_POST, 'patientHeight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $bloodType = filter_input(INPUT_POST, 'patientBloodType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $allergies = filter_input(INPUT_POST, 'patientAllergies', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $error = false;
                 

                if(empty($weight) || empty($height) || empty($bloodType) || empty($allergies)){
                    echo "Please fill all the feilds.";
                    $error = true;
                }else if(!preg_match("/^\d{1,3}(\.\d{1,2})?$/",$height)){
                    echo "Please enter a valid height.";
                    $error = true;
                }else if(!preg_match("/^\d{1,3}(\.\d{1,2})?$/",$weight)){
                    echo "Please enter a valid weight.";
                    $error = true;
                }else if(!preg_match("/^[a-zA-Z +-]*$/",$bloodType)){
                    echo "Please enter a valid blood type.";
                    $error = true;
                }else if($rowPersonal["status"] == "yes"){
                    $roomID = filter_input(INPUT_POST, 'roomID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $diagnosis = filter_input(INPUT_POST, 'patientDiagnosis', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if(empty($roomID) || empty($diagnosis)){
                        echo "Please fill all the feilds.";
                        $error = true;
                    } else if (!preg_match("/^\d{3}-\d$/", $roomID)) {
                        echo "Please enter room ID in the correct format (e.g. 101-1).";
                        $error = true;
                    }
                }
                

                if($error == false){
                    $sql= "INSERT IGNORE INTO medicalinfo (patientID) VALUES ('$id')";
                    mysqli_query($conn, $sql);
                    
                    $updateMedicalInfoSql = "UPDATE medicalinfo SET 
                    patientWeight = '$weight', 
                    patientHeight = '$height', 
                    patientBloodType = '$bloodType', 
                    patientAllergies = '$allergies' 
                    WHERE patientID = '$id'";
                    if($rowPersonal["status"] == "yes"){
                        try{
                        $updateRoomSql = "UPDATE rooms SET roomID = '$roomID', patientDiagnosis = '$diagnosis' WHERE patientID = '$id'";
                        }catch(mysqli_sql_exception ){
                            echo "The room you enter does not seem to exist.";
                        }
                    }

                    try{
                        mysqli_query($conn, $updateMedicalInfoSql);
                        if($rowPersonal["status"] == "yes"){
                            mysqli_query($conn, $updateRoomSql);
                        }
                        header("location: success.php?type=editPatient");
                    }catch(mysqli_sql_exception ){
                        echo "It seems like your bed is already occupied. Please choose another one";
                    }
                }
            }
        }

    ?>
        <h1>Edit report for <?php echo $rowPersonal['patientName'] ?></h1>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">

        <h1>Medical Info</h1>
        <table>
    <?php

        $feilds = [
            "Weight" => "patientWeight",
            "Height" => "patientHeight",
            "Blood Type" => "patientBloodType",
            "Allergies" => "patientAllergies",
        ];
        foreach($feilds as $title => $feild){
            echo "<tr>";
            echo "<th>" . $title . "</th>";
            echo "<td><input type='text' name='" . $feild . "' value='" . (empty($rowMedical[$feild]) ? "Unfilled" : $rowMedical[$feild]). "'></td>";
            echo "</tr>";
        }
        
        if($rowPersonal["status"] == "no"){
            echo "<td><input type='submit' name='add' value='Add Room'></td>";

            if(isset($_POST["add"])){
                try{
                $statusChangeSql = "UPDATE patients SET status = 'yes' WHERE patientID = '$id'";
                mysqli_query($conn, $statusChangeSql);
                $addRoomSql = "INSERT INTO rooms (patientID) VALUES ('$id')";
                mysqli_query($conn, $addRoomSql);
                echo '<script>window.location.href="editPatient.php?id=' . $id . '";</script>';
                } catch (mysqli_sql_exception) {
                    echo "Error: " . $sqlMedical . "<br>" . $conn->error;
                }
            }
        } 
        
        if($rowPersonal["status"] == "yes"){
            $sqlRoom = "SELECT * FROM rooms WHERE patientID = '$id'";
            $resultRoom = mysqli_query($conn, $sqlRoom);
            $rowRoom = mysqli_fetch_assoc($resultRoom);

            $feilds = [
                "Room ID" => "roomID",
                "Diagnosis" => "patientDiagnosis",

            ];
            foreach($feilds as $title => $feild){
                echo "<tr>";
                echo "<th>" . $title . "</th>";
                echo "<td><input type='text' name='" . $feild . "' value='" . (empty($rowRoom[$feild]) ? "Unfilled" : $rowRoom[$feild]). "'></td>";
                echo "</tr>";
            }
        
            echo "<td><input type='submit' name='delete' value='Delete'></td>";

            if(isset($_POST["delete"])){
                $deleteRoomSql = "DELETE FROM rooms WHERE patientID = '$id'";
                mysqli_query($conn, $deleteRoomSql);

                $addRoomSql = "UPDATE patients SET status = 'no' WHERE patientID = '$id'";
                mysqli_query($conn, $addRoomSql);
                echo '<script>window.location.href="success.php?type=delete";</script>';
            }
        }

    ?>
            <br>
                <td><input type="submit" name="update" value="update"></td>
        </form>  
    </table>
    
</body>
</html>