<!DOCTYPE html>
<html lang="en">
<head>
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
            margin-top: 0;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
        }

        .back-button button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .back-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            include('database.php');
            session_start();

            $type = $_GET['type'];

            if($type == "appointment"){
                echo "<h1>Appointment has been made.</h1>";
            }else if($type == "editPatient"){
                echo "<h1>Patient has been updated.</h1>";
            }else if($type == "cancel"){
                echo "<h1>Appointment has been cancelled.</h1>";
            }else if($type == "edit"){
                echo "<h1>Your profile has been updated.</h1>";
            }
        ?>

        <div class="back-button">
            <a href="index.php" style="text-decoration: none;">
                <button>
                    <span>&#8592;</span> Go Back
                </button>
            </a>
        </div>
    </div>

</body>
</html>