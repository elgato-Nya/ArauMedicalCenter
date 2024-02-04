<?php   

    $db_server = "localhost";   
    $db_username = "root";
    $db_password = "";
    $db_name = "hospitaldb";
    $conn = "";

    try{
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);
    }
    catch(mysqli_sql_exception){
        die("Connection failed: " . mysqli_connect_error());
        echo "<br>";
    }
?>






    <!-- try{
        $conn = new PDO("mysql:host=$db_server;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connection Successful";}
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    } -->