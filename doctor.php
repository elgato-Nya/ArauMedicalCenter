<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{ 
            background-image: url('doctorbg.png');
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
            background-color: 	rgba(173, 216, 230, 0.6);
            text-align: center;
            padding: 15px;
            width: 250px;
        }
        td{
            background-color: rgba(175, 238, 238, 0.6);
            padding: 15px;
            width: 500px;
        }
  
        label {
            background-color: rgba(224, 255, 255, 0.9);
            font-size: 20px;
            padding: 12px;
            border-radius: 4px;
            display: inline-block;}
        .tableContainer{
            margin: auto;
            width: 1000px;
            padding: 20px;
            background-color: rgba(255, 248, 220, 0.5);
            border-radius: 5px;
            border: 1px solid #ddd;
        }

    </style>
</head>
<body>
    <?php      include('header.php'); ?>

    <h1 style="text-align: center; padding: 20px;">Doctor Profile</h1>
    <div class="tableContainer">

    <?php
   
        $id = $_GET['id'];

        $sqlPersonal = "SELECT * FROM staffs WHERE staffID = '$id'";
        $resultPersonal = mysqli_query($conn, $sqlPersonal);
        $rowPersonal = mysqli_fetch_assoc($resultPersonal);

        $sqlDoctor = "SELECT * FROM doctorinfo WHERE staffID = '$id'";
        $resultDoctor = mysqli_query($conn, $sqlDoctor);
        $rowDoctor = mysqli_fetch_assoc($resultDoctor);

        $fields = [
            "Name" => "staffName",
            "Phone Number" => "staffPhoneNum",
            "Email" => "staffEmail",
        ];
        ?>
    <table>
        <h3>Personal Information</h3>

        <?php
        foreach($fields as $header => $field){
            echo "<tr>";
            echo "<th>" . $header . "</th>";
            echo "<td>" . ($rowPersonal[$field]). "</td>";
            echo "</tr>";
        }

        $fields = [
            "Specialty" => "specialty",
            "Education" => "education",
            "Qualification" => "qualification",
        ];
        ?>

    </table>     
    <table>
        <h3 style="margin-top: 30px;">Profession Information</h3>

        <?php
        foreach($fields as $header => $field){
            echo "<tr>";
            echo "<th>" . $header . "</th>";
            echo "<td>" . (empty($rowDoctor[$field]) ? "Unfilled" : ($rowDoctor[$field])). "</td>";
            echo "</tr>";
        }
    ?>
    </table>
    </div>

</body>
</html>
