<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <style>
        #container{
            background-color: #F9F6EE;
            margin: auto;
            width: 500px;
            border-radius: 10px;
            padding: 10px;
        }
        input[type=text], input[type=password]{
            position: relative;
            margin-left: 25%;
            padding: 15px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type=submit]{ margin-left: 37%; }

        input[type=radio]{ margin-top: 20px; }

        #staffButton{ margin-left: 40%; }

        p{
            margin-left: 25%;
            margin-bottom: 0;
        }
        
    </style>
</head>
<body>
    
    <?php
    include("database.php");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username) || empty($password) || empty($userType)) {
            $_SESSION["message"] = "Please fill all the fields";
        }else if(!empty($username) && !empty($password) && !empty($userType)){
            if(isset($userType) && $userType == "staff"){
                $staffSql = "SELECT * FROM staffs WHERE staffUsername = '$username'";
                $staffResult = mysqli_query($conn, $staffSql);
                $staffRow = mysqli_fetch_assoc($staffResult);
                if ($staffRow == null) {
                    $_SESSION["message"] = "Incorrect username or password or you are not a staff here";
                }else if(!password_verify($password, $staffRow["staffPassword"])){
                    $_SESSION["message"] = "Incorrect username or password";
                } else if ($staffRow != null && password_verify($password, $staffRow["staffPassword"])) {
                    $_SESSION["loggedin"] = "yes";
                    $_SESSION["id"] = $staffRow["staffID"];
                    $_SESSION["username"] = $username;
                    $_SESSION["name"] = $staffRow["staffName"];
                    $_SESSION["userType"] = "staff";
                    header("location: index.php");
                }
            }else if(isset($userType) && $userType == "patient"){
                $patientSql = "SELECT * FROM patients WHERE patientUsername = '$username'";
                $patientResult = mysqli_query($conn, $patientSql);
                $patientRow = mysqli_fetch_assoc($patientResult);
                if ($patientRow == null) {
                    $_SESSION["message"] = "Incorrect username or password";
                }else if(!password_verify($password, $patientRow["patientPassword"])){ 
                    $_SESSION["message"] = "Incorrect username or password";
                }else if ($patientRow != null && password_verify($password, $patientRow["patientPassword"])) {
                    $_SESSION["loggedin"] = "yes";
                    $_SESSION["id"] = $patientRow["patientID"];
                    $_SESSION["username"] = $username;
                    $_SESSION["name"] = $patientRow["patientName"];
                    $_SESSION["userType"] = "patient";
                    header("location: index.php");
                }
            }
            
        }
        if(isset($_SESSION["message"]) == true) {
            echo '<p>' . $_SESSION["message"] . '</p>';
            $_SESSION["message"] = null;
        }
    }
    ?>
    <div id="container">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" >
        <input type="radio" name="userType" value="staff">
        <label for="staff">Staff</label>
        <input type="radio" name="userType" value="patient">
        <label for="patient">Patient</label><br><br>
        <p>Username</p><br>
        <input type="text" name="username" placeholder="Username"><br>
        <p>Password</p><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="submit" value="Login">
        <button type="button" onclick="window.location.href='signup.php'">Sign Up</button>
    </form>
    </div>
</body>
</html>
