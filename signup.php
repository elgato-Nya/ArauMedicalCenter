<?php include("database.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign up</title>
    <style>
        *{  box-sizing: border-box;  
            margin: 0;
            padding: 0; 
            background-color: #F9F6EE;
        }
        .heading,#pHeading,h1 {
            background-color: #BDB76B ;
        }
        #pHeading{
            padding-bottom: 2%;
        }
        input[type=text], input[type=password]{
            background-color: #FAF9F6;
            width: 70%;
            font-size: 18px;
            padding: 11px;
            margin-left: 5%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type=password]{
            width: 34.7%;
        }
        input[type=submit]{
            width: 46%;
            font-size: 18px;
            padding: 11px;
            margin-left: 17%;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
        }
        input[type=submit]:hover{
            background-color: #45a049;
            cursor: pointer;
        }
        h1{
            margin-left: 5%;
        }
        p{
            margin-left: 5%;
            margin-top: 2%;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="heading">
    <h1>Hospital Registration</h1>
    <p id="pHeading">Please fill in this form to create an account.</p>
    </div>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" >
        <p>Username</p>
        <input type="text" name="username" placeholder="Username"><br>
        <p style="float: left; margin-right: 11.6em;">Password</p>
        <p>Confirm Password</p>
        <input type="password" name="password" placeholder="Password">
        <input style="margin:0;" type="password" name="confirmPassword" placeholder="Confirm Password"><br>
        <p>Full Name</p>
        <input type="text" name="name" placeholder="Full Name"><br>
        <p>Phone Number</p>
        <input type="text" name="phoneNum" placeholder="Phone Number"><br>
        <p>IC Number</p>
        <input type="text" name="ICNum" placeholder="IC Number"><br>
        <p>Email Address</p>
        <input type="text" name="email" placeholder="Email"><br><br>
        <input type="submit" value="Sign up">
    </form>
    
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $phoneNum = filter_input(INPUT_POST, 'phoneNum', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICNum = filter_input(INPUT_POST, 'ICNum', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $error = false;

    if(empty($username) || empty($password) || empty($name) || empty($phoneNum) || empty($ICNum) || empty($email)){
        echo "Please fill all the fields";
    }else if($password != $_POST["confirmPassword"]){
        echo "Passwords do not match";
    }else{
        if(!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            echo "<p>Name must contain only alphabets and space.</p>";
            $error = true;
        }
        if(!preg_match("/^[0-9]{10,11}$/", $phoneNum)) {
            echo "<p>Phone Number must be between 11 to 12 digits.</p>";
            $error = true;
        }
        if(!preg_match("/[0-9]{6}-[0-9]{2}-[0-9]{4}/", $ICNum)) {
            echo "<p>IC. No must be in the format xxxxxx-xx-xxxx.</p>";
            $error = true;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>Email must be in the right format</p>";
            $error = true;
        }
    }
    if($error==true){
        echo "Failed to create user";
    }else if(!$error){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO patients (patientUsername, patientPassword, patientName, patientPhoneNum, patientICNum, patientEmail) 
        VALUES ('$username', '$hash', '$name', '$phoneNum', '$ICNum', '$email')";
        try{
            mysqli_query($conn, $sql);
            header("location: login.php");	
        }
        catch(mysqli_sql_exception){
            echo "This username has already been taken";
        }
            

    }
}

mysqli_close($conn);
?>