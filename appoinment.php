<!DOCTYPE html>
<html lang="en">
<head>
    <title>Appoinment</title>
    <style>
        </style>
        <style>
            body {
                background-image: url('appoinment.png');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                width: 100%;
                height: 100%;
            }

            .titleContainer {
                margin-left: -425px;
                text-align: center;
                margin-top: 50px;

            }

            h1 {
                color: #333;
                font-size: 40px;

            }

            #p1{
                margin-left: 65px;
                margin-bottom: 20px;
                font-size: 23px;
            }

            p {
                color: #666;
                font-size: 16px;
                margin-top: 15px;
                margin-bottom: -10px;
            }

            .content {
                background-color: #fff;
                width: 750px;
                padding: 25px 30px;
                margin: auto;
                border-radius: 5px;
            }

            form {
                margin-top: 20px;
            }

            label {
                display: block;
                margin-bottom: 5px;
            }

            input[type="date"], input[type="time"], input[type="text"] {
                font-size: 17px;
                width: 200px;
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 3px;
                margin-bottom: 10px;
            }
            
            input[type="text"] {
                width: 400px;
                padding-bottom:60px ;
            }

            button[type="submit"] {
                padding: 10px 20px;
                background-color: #333;
                color: #fff;
                border: none;
                border-radius: 3px;
                cursor: pointer;
            }

            button[type="submit"]:hover {
                background-color: #555;
            }
        </style>
    </head>

<body>

        
    <?php
        include('header.php');
        if($_SESSION["loggedin"] != "yes"){
        echo "<script>window.location.href='login.php';</script>";
       }

        $patientID = $_SESSION["id"];
        $checkAppoinmentSql = "SELECT * FROM appointment WHERE patientID = '$patientID'";
        $resultAppoinment = mysqli_query($conn, $checkAppoinmentSql);

        if(mysqli_num_rows($resultAppoinment) > 0){
            $_SESSION["appoinment"] = "yes";

            $rowAppoinment = mysqli_fetch_assoc($resultAppoinment);
            $appointmentDate = date("d/m/Y", strtotime($rowAppoinment["date"]));
            $appointmentTime1 = date("h:i A", strtotime($rowAppoinment["time1"]));
            $appointmentTime2 = date("h:i A", strtotime($rowAppoinment["time2"]));
        }else{
            $_SESSION["appoinment"] = "no";
        }
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if($_SESSION["appoinment"] == "yes"){
                if(isset($_POST["cancel"]) == true){
                    $sqlCancel = "DELETE FROM appointment WHERE patientID = '$patientID'";
                    $resultCancel = mysqli_query($conn, $sqlCancel);
                    echo "<script>window.location.href='success.php?type=cancel';</script>";
                }
            }if($_SESSION["appoinment"] == "no"){
                $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
                $time1 = filter_input(INPUT_POST, 'time1', FILTER_SANITIZE_SPECIAL_CHARS);
                $time2 = filter_input(INPUT_POST, 'time2', FILTER_SANITIZE_SPECIAL_CHARS);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

                $patient = $_SESSION["username"];
                $sqlPatient = "SELECT * FROM patients WHERE patientUsername = '$patient'";
                $resultPatient = mysqli_query($conn, $sqlPatient);
                $rowPatient = mysqli_fetch_assoc($resultPatient);
                $patientID = $rowPatient["patientID"];
                
                try{
                    $sqlAppoinment = "INSERT INTO appointment (patientID, date, time1, time2, description) VALUES ('$patientID', '$date', '$time1', '$time2', '$description')";
                    $resultAppoinment = mysqli_query($conn, $sqlAppoinment);
                    echo "<script>window.location.href='success.php?type=appoinment';</script>";
                }catch(mysqli_sql_exception){
                    echo "Sorry, you cant make more than one appoinment.";
                }            
                mysqli_close($conn);
            }   
        }
    ?>
    <?php 
        if($_SESSION["appoinment"] == "no"){
    ?>
    <div class="titleContainer">
        <h1>Appoinment</h1>
        <p id="p1">Make an appoinment with us!</p>
    </div>
    <div class="content">
        <form  action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <p for="date">Enter your desired date for the appoinment: </p><br>
            <input type="date" name="date" id="date" required><br>
            <p>Please enter your time range where we can contact you: </p><br>
            <label for="time1">From: </label>
            <input type="time" name="time1" id="time1" required><br>
            <label for="time2">To: </label>
            <input type="time" name="time2" id="time2" required><br>
            <p>Please brief us about your problem: </p><br>
            <input type="text" name="description" id="description" required><br>
            <button type="submit">Make Appoinment</button>
        </form>
    </div>
        <?php
            }else if($_SESSION["appoinment"] == "yes"){
        ?>
    <h1 class="titleContainer" style="margin-bottom: 15px;">Your appoinment</h1>
    <div class="content">
        <p>Date: <?php echo $appointmentDate ?></p>
        <p>Time: <?php echo $appointmentTime1 . " - " . $appointmentTime2 ?></p>
        <p>Description: <?php echo $rowAppoinment["description"] ?></p>
        <p>If you wish to cancel or redo your appoinment, please click the button below</p>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <button type="submit" name="cancel">Cancel Appoinment</button>
        </form>
        <?php
            }
        ?>
    </div>

</body>
</html>