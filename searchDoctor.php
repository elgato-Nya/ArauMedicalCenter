<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{ 
            background-image: url('searchD.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            width: 100%;
            height:100% ;
        }
        h1{
            margin-top: 5%;
            margin-left: 20%;
            padding: 15px;
        }
        form {
            text-align: center;
            padding: 15px;
            margin-left: 15px;
        }

        input[type=text] {
            width: 60%;
            font-size: 18px;
            padding: 11px;
            border: 1px solid #ddd;}

        #doctorName {
            width: 60%;
            font-size: 18px;
            padding: 11px;
            border: 1px solid #ddd;}

        #doctorList {
            list-style-type: none;
            padding: 0;
            margin: 0;}

        #doctorList a {
            text-align: center;
            padding: 12px;
            text-decoration: none;
            color: black;
            display: block;}

        #doctorList a:hover{ 
            cursor: pointer;
            background-color: rgba(176, 224, 230, 0.4);}

        #none{
            text-align: center;
            margin-left: 20%;
            width: 60%;
            background-color: rgba(240, 255, 255, 0.6);
            padding: 12px;}

        .doctor{
            font-size: 20px;
            width:60%;
            margin-left:20%;}

        input[type=submit]{
            background-color: #4CAF50;
            font-size: 15px;
            border: none;
            border-radius: 4px;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;}
    </style>
</head> 
<body>
    <?php include('header.php'); ?>
    <h1>Search Doctor</h1>
    <form action="searchDoctor.php" method="post">
        <input type="text" name="doctorName" id="doctorName" placeholder="Enter doctor name" onkeyup="searchFunction()" >
        <input type="submit" value="Search"><br>
    </form>
    <br><br>
    <ul id="doctorList">
        <?php
            $doctorData = array(); 
            $doctorSql = "SELECT * FROM staffs WHERE staffType = 'doctor'";
            $doctorResult = mysqli_query($conn, $doctorSql);
            while($doctorRow = mysqli_fetch_assoc($doctorResult)){
                $doctorData[] = $doctorRow; 
            }

            if(isset($_POST["doctorName"]) == true){
                $doctorName = $_POST["doctorName"];
                $searchSql = "SELECT * FROM staffs WHERE staffName LIKE '%$doctorName%' AND staffType = 'doctor'";
                $searchResult = mysqli_query($conn, $searchSql);

                if(mysqli_num_rows($searchResult) == 0){
                    echo "<div id='none'>";
                    echo "<h3>We are sorry but it seems like there is no doctor named ".$doctorName."</h3>";
                    echo "</div>";
                }else if(mysqli_num_rows($searchResult) > 0){
                    while($searchRow = mysqli_fetch_assoc($searchResult)){
                        echo "<tr><a class='doctor' id='" . $searchRow['staffID'] . "' onclick='goToDoctorPHP(this.id)'>" . 
                        $searchRow['staffName'] . "</a></tr><br>";
                    }
                }
            }
            
            
        ?>
    </ul>
             
    <script>
        
        function goToDoctorPHP(id){
            let doctorID = id;
            <?php $_SESSION['doctorID'] = "<script>doctorID</script>"; ?>
            window.location.href = "doctor.php?id=" + id;
        };
                    
    </script>
</body>
</html>

