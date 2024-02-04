<!DOCTYPE html>
<html lang="en">
<head>
    <title>About us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('blur-hospital.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        h1, h2 {
            font-size: 25px;
            color: #333;
            text-align: center;
            margin-top: 20px;
        }


        p {
            text-align: justify;            
            line-height: 1.5;
            margin: 20px 0;
            padding: 0 20px;
        }

        .tableContainer {
            width: 750px;
            margin: auto;
            padding: 25px 30px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: rgba(220, 220, 220, 0.5);
        }

        tr:hover {
            background-color: rgba(128, 128, 128, 0.7);
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <h1 style= "font-size: 40px;">About Us</h1>
    
    <h2>Our History</h2>
    <p>Here, we are committed to providing compassionate and high-quality healthcare services to our community. 
        With a dedicated team of skilled professionals, state-of-the-art facilities, 
        and a patient-centered approach, we strive to ensure the well-being and comfort of every individual who walks through our doors. 
        Our mission is to deliver excellence in healthcare, focusing on innovation, integrity, 
        and personalized care, to meet the diverse needs of our patients and their families. 
        Here, your health and satisfaction are our top priorities.</p>
    <h2>Operation Hours</h2>
    <div class="tableContainer">
    <table>
        <tr>
            <th style="font-size: 20px;">Day</th>
            <th style="font-size: 20px;">Operating Hours</th>
        </tr>
        <tr>
            <td>Monday</td>
            <td>4:00 AM - 2:30 AM</td>
        </tr>
        <tr>
            <td>Tuesday</td>
            <td>4:00 AM - 2:30 AM</td>
        </tr>
        <tr>
            <td>Wednesday</td>
            <td>4:00 AM - 2:30 AM</td>
        </tr>
        <tr>
            <td>Thursday</td>
            <td>4:00 AM - 2:30 AM</td>
        </tr>
        <tr>
            <td>Friday</td>
            <td>4:00 AM - 2:30 AM</td>
        </tr>
        <tr>
            <td>Saturday</td>
            <td>6:00 AM - 1:00 AM</td>
        </tr>
        <tr>
            <td>Sunday</td>
            <td>6:00 AM - 1:00 AM</td>
        </tr>
    </table>
    <p>*Our emergency unit will be open 24/7</p>
    </div>
</body>
</html>