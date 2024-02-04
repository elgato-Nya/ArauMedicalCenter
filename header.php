<?php 
    session_start();
    include("database.php");
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        *{ 
          box-sizing: border-box;
          margin: 0;
          padding: 0; }

        body{ font-family: Arial, Helvetica, sans-serif; }

        #linkContainer{
            list-style-type: none;
            position: sticky;
            margin: 0;
            overflow: hidden;
            top: 0;
            z-index: 9999;}

        .fixed {
            position: fixed;
            top: 0;
            width: 100%;}

        .link{ float: left; }

        .link a{
            color: black;
            display:inline-block;
            padding: 20px 15px 20px 15px;
            text-decoration: none;}
            
        .link :hover{ 
            background-color: rgba(255, 248, 220, 0.5); 
            border-radius: 3px;}

    </style>
</head>
<body>
    <ul id="linkContainer" class="fixed">
        <li class="link"><a href="index.php">Home</a></li>
        <li class="link"><a href="searchDoctor.php">Search Doctor</a></li>
        <?php
            if(isset($_SESSION["loggedin"]) == true) {
                if($_SESSION["userType"] == "staff"){
                    echo "<li class='link'><a href='searchPatient.php'>Search Patient</a></li>";
                }else if($_SESSION["userType"] == "patient"){
                    echo " <li class='link'><a href='appoinment.php'>Appoinment</a></li>";
                }
            }
            
            if(isset($_SESSION["loggedin"]) != "yes") {
                echo " <li class='link'><a href='appoinment.php'>Appoinment</a></li>";                
                echo "<li class='link' style='float:right'><a href='login.php'>Log In</a></li>";
            }else if(isset($_SESSION["loggedin"]) == "yes") {
                    echo"<li class='link'><a href='profile.php'>My Profile</a></li>";
                    echo "<li class='link' style='float:right'><a href='logout.php'>Log Out</a></li>";
                }

            ?>
        <li class="link"><a href="aboutUs.php">About Us</a></li>
    </ul>

    <?php
        if(isset($_SESSION["message"]) == true) {
            echo '<p>' . $_SESSION["message"] . '</p>';
            $_SESSION["message"] = null;
        }
        
    ?>
    <script>

        let navbar = document.getElementById("linkContainer");
        let sticky = navbar.offsetTop;

        window.addEventListener('scroll', function() {
            if (window.pageYOffset === 0) {
                navbar.style.transition = "background-color 0.5s ease";
                navbar.style.backgroundColor = "transparent";
            } else {
                navbar.style.transition = "background-color 0.5s ease";
                navbar.style.backgroundColor = "rgba(255, 245, 238, 0.5)";
            }
        })
        
    </script>

    


</body>
</html>
