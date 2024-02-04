<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patient</title>
    <style>
        body{
            background-image: url('patientbg.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            width: 100%;
            height:100% ;
        }
        h1{
            padding: 15px;
            margin-left: 15px;
        }
        h3{
            padding: 15px;
            margin-left: 15px;
        }
        table{
            margin: auto;
            width: 750px;
            border-collapse: collapse;
            text-align: left;
        }
        th{
            
            background-color: rgba(216, 191, 216, 0.7);
            text-align: center;
            padding: 15px;
            width: 250px;
        }
        td{ 
            background-color: 	rgba(230, 230, 250, 0.6);
            padding: 15px;
            width: 500px;
        }

        .tableContainer{
            background-color: rgba(221, 160, 221, 0.3);
            margin: auto;
            margin-top: 50px;
            width: 1000px;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button{
            margin-left: 15%;
            padding: 10px 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: rgba(221, 160, 221, 0.7);
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

        $feilds = [
            "Name" => "patientName",
            "Phone Number" => "patientPhoneNum",
            "Email" => "patientEmail",
        ];
    ?>
    <div class="tableContainer">
        <h1>Patient</h1>
        <table>
    <?php
        foreach($feilds as $header => $feild){
            echo "<tr>";
            echo "<th>" . $header . "</th>";
            echo "<td>" . ($rowPersonal[$feild]). "</td>";
            echo "</tr>";
        }
    ?>
        </table>
        <br>
        <h1>Medical Info</h1>
        <table>
    <?php

        $feilds = [
            "Weight" => "patientWeight",
            "Height" => "patientHeight",
            "Blood Type" => "patientBloodType",
            "Allergies" => "patientAllergies",
        ];
        foreach($feilds as $header => $feild){
            echo "<tr>";
            echo "<th>" . $header . "</th>";
            echo "<td>" . (empty($rowMedical[$feild]) ? "<i>Unfilled<i>" : $rowMedical[$feild]). "</td>";
            echo "</tr>";
        }

        if($rowPersonal["status"] == "yes"){
            $sqlRoom = "SELECT * FROM rooms WHERE patientID = '$id'";
            $resultRoom = mysqli_query($conn, $sqlRoom);
            $rowRoom = mysqli_fetch_assoc($resultRoom);

            $feilds = [
                "Room ID" => "roomID",
                "Diagnosis" => "patientDiagnosis",
            ];
            foreach($feilds as $header => $feild){
                echo "<tr>";
                echo "<th>" . $header . "</th>";
                echo "<td>" . (empty($rowRoom[$feild]) ? "<i>None<i>" : $rowRoom[$feild]). "</td>";
                echo "</tr>";
            }
    }

    ?>
        </table>
        <br>
    <button onclick="location.href='editPatient.php?id=<?php echo $id; ?>'">Edit</button>
    </div>

</body>
</html>

