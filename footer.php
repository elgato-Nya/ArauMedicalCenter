<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
        }

        img{
            float: left;
        }

        .footer-logo {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .footer-text {

            color: #555;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .footer-contact {

            color: #555;
            font-size: 14px;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>

<footer>
    <div class="container">
        <div class="row">
            <div>
                <img src="hospital-logo.png" alt="Hospital Logo" class="footer-logo">
                <p class="footer-text">&copy; <?php echo date("Y"); ?> Hospital Name. All rights reserved.</p>
                <p class="footer-contact">Contact us: +1 123-456-7890</p>
                <p class="footer-contact">Email: info@hospitalname.com</p>
                <p class="footer-contact">Address: 123 Main Street, City, Country</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>