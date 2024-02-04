
<!DOCTYPE html>
<html>
<head>
    <title>Search Patient</title>
    <style>
        body{ 
            background-image: url('searchP.jpg');
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

        #search {
            width: 60%;
            font-size: 18px;
            padding: 11px;
            border: 1px solid #ddd;}

        #patientList {
            list-style-type: none;
            padding: 0;
            margin: 0;}

        #patientList a {
            text-align: center;
            padding: 12px;
            text-decoration: none;
            color: black;
            display: block;}

        #patientList a:hover{ 
            background-color: rgba(102, 205, 170, 0.4);
            width: 60%;
            margin-left: 20%;
            cursor: pointer;}

        button[type=submit] {
            background-color: rgba(224, 255, 255, 0.9);
            font-size: 15px;
            padding: 12px;
            border-radius: 4px;
            display: inline-block;
            border: none;
            margin: 10px;
            cursor: pointer;}


    </style>
</head>
<body>
    <?php
        include('header.php');

        $sqlPatient = "SELECT * FROM patients";
        $resultPatient = mysqli_query($conn, $sqlPatient);
        $patientData = array();

        while($rowPatient = mysqli_fetch_assoc($resultPatient)){
            $patientData[] = $rowPatient;                  

            if ($rowPatient["status"] != "yes" && $rowPatient["status"] != "no") {
                $sqlStatus = "UPDATE patients SET status = 'no' WHERE patientID = " . $rowPatient["patientID"];
                $resultStatus = mysqli_query($conn, $sqlStatus);

            }
        }
    ?>
    <h1>Search Patient</h1>
    <form id="searchForm" method="POST">
        <input type="text" name="search" id="search" placeholder="Enter patient name">
        <button type="submit">Search</button><br>
    </form>

    <ul id="patientList">
        <?php
            if(isset($_POST["search"]) == true){
                $search = $_POST["search"];
                $searchSql = "SELECT * FROM patients WHERE patientName LIKE '%$search%'";
                $searchResult = mysqli_query($conn, $searchSql);

                if(mysqli_num_rows($searchResult) == 0){
                    echo "<tr><td colspan='2'>No patient found</td></tr>";
                }else if(mysqli_num_rows($searchResult) > 0){
                    while($searchRow = mysqli_fetch_assoc($searchResult)){
                        echo "<tr><a class='patient' id='" . $searchRow['patientID'] . "' onclick='goToPatientPHP(this.id)'>" . 
                        $searchRow['patientName'] . "</a></tr><br>";
                    }
                }
            }
        ?>
    </ul>

    <script>
        function goToPatientPHP(id){
            let patientID = id;
            window.location.href = "patient.php?id=" + id;
        };
    </script>
</body>
</html>
