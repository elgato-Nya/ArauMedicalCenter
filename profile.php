<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <style>
            body{
                background-image: url('profilebg2.jpg');
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                width: 100%;
                height:100% ;
            }
            h1{
                text-align: center;
                padding: 20px;
            }
            .tableContainer{
                margin: auto;
                width: 1000px;
                padding: 20px;
                background-color: rgba(152, 251, 152, 0.5);
                border-radius: 5px;
                border: 1px solid #ddd;
            }
            table{
                margin: auto;
                width: 750px;
                border: none;
                border-collapse: collapse;
                text-align: left;
            }
            .title{
                text-align: center;
                padding: 20px;
            }
            .table{
                margin: auto;
                width: 750px;
                border: none;
                text-align: left;
            }

            th{
                background-color: rgba(128, 128, 0, 0.7);
                text-align: center;
                padding: 15px;
                width: 250px;

            }
            td{
                background-color: rgba(154, 205, 50, 0.7);
                padding: 15px;
                width: 500px;
            }
            h2{
                background-color: rgba(107, 142, 35, 0.7);
                padding: 20px;
            }
            button{
                color: aliceblue;
                background-color: rgba(85, 107, 47, 0.9);
                padding: 10px 20px;
                margin: 20px;
                margin-left: 15%;
                border-radius: 5px;
                border: 1px solid rgba(154, 205, 50, 0.7);
            }

  

        </style>
</head>
<body>
    <?php include('header.php');
    if($_SESSION["loggedin"] == "yes"){
        $username = $_SESSION["username"];
        $userType = $_SESSION["userType"];
        if($userType=="patient"){
            if(isset($_SESSION["edited"]) && $_SESSION["edited"] == "yes"){
                unset($_SESSION["edited"]);
                $personalInfoSql = "SELECT * FROM patients WHERE patientUsername = '$_SESSION[username]'";
            }else{
                $personalInfoSql = "SELECT * FROM patients WHERE patientUsername = '$username'";
            }            
                $personalInfoResult = mysqli_query($conn, $personalInfoSql);
                $personalInfoRow = mysqli_fetch_assoc($personalInfoResult);
                
                $patientID = $personalInfoRow["patientID"];
                $medicalInfoSql = "INSERT IGNORE INTO medicalinfo (patientID) VALUES ('$patientID')";
                mysqli_query($conn, $medicalInfoSql);

                $medicalInfoSql = "SELECT * FROM medicalinfo WHERE patientID = '$patientID'";
                $medicalInfoResult = mysqli_query($conn, $medicalInfoSql);
                $medicalInfoRow = mysqli_fetch_assoc($medicalInfoResult);
                echo "<h1> Welcome " . $_SESSION["name"] . "</h1>";
                
        }else if($userType=="staff"){
            $personalInfoSql = "SELECT * FROM staffs WHERE staffUsername = '$username'";
            $personalInfoResult = mysqli_query($conn, $personalInfoSql);
            $personalInfoRow = mysqli_fetch_assoc($personalInfoResult);

            $staffID = $personalInfoRow["staffID"];
            $doctorInfoSql = "INSERT IGNORE INTO doctorinfo (staffID) VALUES ('$staffID')";
            mysqli_query($conn, $doctorInfoSql);

            $doctorInfoSql = "SELECT * FROM doctorinfo WHERE staffID = '$staffID'";
            $doctorInfoResult = mysqli_query($conn, $doctorInfoSql);
            $doctorInfoRow = mysqli_fetch_assoc($doctorInfoResult);
            echo "<h1> Welcome " . $_SESSION["name"] . "</h1>";
        }
    }else{  header("location: login.php");  }
    ?>
    <div class="tableContainer">
    <div class="table">
        <h2 class="title">Personal Information</h2> 
        <table>
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
                echo "<td>" . (empty($personalInfoRow) ? "<i>Unfilled.</i>" : $personalInfoRow[$field]) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <?php   $title = ($userType == "patient") ? "Medical Information" : "Doctor Information";   ?>

        <h2 class="title"><?php echo $title; ?></h2>
        <div class="table">
            <table>
            <?php 
                if ($userType == "patient"){ 
                    $fields = [
                        "Height" => "patientHeight",
                        "Weight" => "patientWeight",
                        "Blood Type" => "patientBloodType",
                    ];

                    foreach ($fields as $label => $field) {
                        echo "<tr>";
                        echo "<th>$label </th>";
                        echo "<td>" . (empty($medicalInfoRow) ? "<i>Unfilled.</i>" : $medicalInfoRow[$field]) . (($label == "Weight") ? " kg" : (($label == "Height") ? " cm" : "")) . "</td>";
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
                        echo "<td>" . (empty($doctorInfoRow) ? "<i>Unfilled.</i>" : $doctorInfoRow[$field]) . "</td>";
                        echo "</tr>";
                    }
                }
            ?>
            </table>
        </div>
    </div>
        
        <button onclick="location.href='edit.php'">Edit Table</button>
    </div>
    
</body>
</html>
