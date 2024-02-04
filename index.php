<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>

    <style>
        .slides{ display: none;}

        img{ 
            width: 100%;
            height: 1000px; 
            vertical-align: middle; }

        .slideshow{ 
            position: relative;
            width: 100%;
            margin: auto; }

        .slideshow img{ width: 100%; }

        .prev, .next{ 
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            transform: translateY(-50%);
            user-select: none;
            border-radius: 0 3px 3px 0; }

        .next{ right: 0;
                border-radius: 3px 0 0 3px; }
        .prev {
            cursor: pointer;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            user-select: none;
        }
                
        .prev:hover, .next:hover{ background-color: rgba(0,0,0,0.8); }

        .header-text-container {
            position: absolute;
            right: 15%;
            bottom: 50%;
            left: 5%;
            background-color: rgba(0,0,0,0.5);
            padding: 8px 12px;
            text-align: left;
            color: #f2f2f2;
        }

        .header {
            font-size: 75px;
        }

        .text {
            font-size: 40;
            margin: 8px -12px;
        }

        .dot{ cursor: pointer;  
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease; }
        
        .active, .dot:hover{ background-color: #717171; }

        .fade{ 
            animation-name: fade;
            animation-duration: 1.5s; }

        @keyframes fade{
            from{ opacity: .4; }
            to{ opacity: 1; }
        }

        @media only screen and (max-width: 300px){
            .prev, .next, .text{ font-size: 11px; }
        }
    </style>
</head>
<body>
<?php include('header.php');  ?> 

    <div class="slideshow">
    <div class="slides fade" style="margin-top: -60px">
        <img src="hospital building 1.jpg">
        <div class="header-text-container">
            <div class="header">Welcome to our hospital.</div>
            <div class="text">We are here to serve you.</div>
        </div>
    </div>
    <div class="slides fade" style="margin-top: -60px">
        <img src="facilities.jpg">
        <div class="header-text-container">
            <div class="header">World class facilities.</div>
            <div class="text">We design all of our facilites carefully to fulfill our belavod patient and guest necessity</div>
        </div>
    </div>
    <div class="slides fade" style="margin-top: -60px">
        <img src="hospital medicine 1.jpg">
        <div class="header-text-container">
            <div class="header">Well develop drugs and medicine</div>
            <div class="text">We spent millions of dollar to research and develop all of our drug just to gain the best result for our patient</div>
        </div>
    </div>
    <div class="slides fade" style="margin-top: -60px">
        <img src="consult.jpg">
        <div class="header-text-container">
            <div class="header">Highly trained doctors.</div>
            <div class="text">Doctors here are full of experience and can always be rely on since we select the best out of the best to work here</div>
        </div>
    </div>
    <div class="slides fade" style="margin-top: -60px">
        <img src="emergency.jpg">
        <div class="header-text-container">
            <div class="header">Having an unexpected emergency?</div>
            <div class="text">We are here to help you. Our emergency service is open to public for 24 hours 7 days a week.</div>
        </div>
    </div>

        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span> 
        <span class="dot" onclick="currentSlide(2)"></span> 
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>

    </div>
    </div>

    <script>
        var slideIndex = 1;
        slideshow(slideIndex);

        function plusSlides(i){
            slideshow(slideIndex += i);
        }

        function currentSlide(i){
            slideshow(slideIndex = i);
        }

        function slideshow(i){
            var slides = document.getElementsByClassName("slides");
            var dots = document.getElementsByClassName("dot");
            if(i > slides.length){ slideIndex = 1 }
            if(i < 1){ slideIndex = slides.length }
            for(let j = 0; j < slides.length; j++){
                slides[j].style.display = "none";
            }
            for(let j = 0; j < dots.length; j++){
                dots[j].className = dots[j].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }
    </script>

    <?php include('footer.php'); ?>
</body>
</html>
