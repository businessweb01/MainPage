<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/";
    $videoFile = $_FILES["video"];
    $targetFile = $targetDir . basename($videoFile["name"]);

    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($videoFile["size"] > 500000000) { // 500 MB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = ["mp4", "avi", "mov", "wmv", "webm"];
    if(!in_array($videoFileType, $allowedFormats)) {
        echo "Sorry, only MP4, AVI, MOV, WMV, and WEBM files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($videoFile["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars(basename($videoFile["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agri-Learn Home Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-weight: 600;
        }
        body{
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            /* background-color: #f0f0f0; */
        }

        /* Logo styles */
        .logo-container h1 {
            font-size: clamp(1.5rem, 2vw, 2.5rem);
            color: #333;
        }

        /* Search container styles */
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Search input styles */
        .search-container input[type="text"] {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: clamp(1rem, 1.5vw, 1.5rem);
            width: 300px; /* Adjust width as needed */
            max-width: 100%;
            margin-right: 1rem;
        }

        /* Search icon styles */
        .search-container .bx-search {
            font-size: clamp(1.5rem, 2vw, 2.5rem);
            color: #666;
            cursor: pointer;
        }

        /* Modes container styles */
        .modes {
            display: flex;
            align-items: center;
        }

        /* Media query for smaller screens */
        @media screen and (max-width: 768px) {
            .search-container input[type="text"] {
                width: 200px;
                font-size: clamp(1rem, 2vw, 1.2rem);
            }
        }
        @media screen and (max-width: 300px) {
            .search-container input[type="text"] {
                width: 100px;
                font-size: clamp(0.8rem, 2vw, 1.2rem);
            }
        }
        nav {
            position: absolute;
            height: 450px;
            transition: all 0.5s ease;
            width: 70px;
            /* padding-top: 20px; */
            background: rgba(110, 110, 110, 0.25);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(17.3px);
            -webkit-backdrop-filter: blur(17.3px);
            border-top-right-radius:20px ;
            border-bottom-right-radius:20px;
            
          
        }

        nav.active {
            width: 200px;
            border-top-right-radius:20px ;
            border-bottom-right-radius:20px;
            background: rgba(110, 110, 110, 0.25);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(17.3px);
            -webkit-backdrop-filter: blur(17.3px);
            height: 450px;
            border-top-right-radius:20px ;   
            border-bottom-right-radius:20px;
            
        }

        nav #btn {
            position: absolute;
            top: .4rem;
            left: 10px;
            font-size: 1.5rem;
            cursor: pointer;
        }

        nav.active #btn {
            left: 90%;
        }

        nav ul {
            margin-left: 0.5rem;
            margin-top: 0.5rem;
            list-style: none;
        }

        nav ul li {
            margin-bottom: 10px;
        }

        nav ul li a {
            display: flex;
            align-items: center;
            color: black;
            text-decoration: none;
            padding: 10px;
        }

        nav.active ul li a:hover {
            background-color:none;
            width:fit-content;
            border-radius: 5px;
            scale: 1.2;
            transition: all 0.3s ease;

        }
        nav i:hover{
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        nav ul li a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        nav .nav-item {
            display: none;
            transition: all 0.5s ease;
        }

        nav.active .nav-item {
            display: inline;    
           
        }
        @media screen and (max-width: 768px) {
            nav{
                height: auto;
            }
            nav.active{
                width: 170px;
                height:auto;
            }
        }
        .vids > div {
            margin-bottom: 20px; /* Add margin-bottom to create vertical gap between items */
            margin-right: 20px; /* Add margin-right to create horizontal gap between items */
        }

        .embed-responsive-item {
            border: 2px solid #ccc; /* Example border style */
            border-radius: 5%; /* Optional: Add rounded corners */
            width: 100%;
            margin-right: 5%;
        }
        .burger-btn i {
            font-size: clamp(1.5rem, 2vw, 2.5rem);
        }.user {
            display: flex;
            font-size: clamp(1.5rem, 2vw, 2.5rem);
            gap: 3rem;
            margin-left: 5rem;
            
        }.grass{
            background: url('grass.jpg');
            background-size: contain;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .main-content {
            display: flex;
            align-items: flex-start; /* Align the content at the top */
            padding: 20px; /* Add padding for spacing */
        }
        .modes{
            margin-left: 20px;
            margin-right: 20px;
        }
        .toggle-input {
            display: none;
        }

        .toggle-label {
            width: 50px;
            height: 20px;
            position: relative;
            display: block;
            background: #fbfbfb;
            border-radius: 200px;
            box-shadow: inset 0px 5px 15px rgba(0, 0, 0, 0.4), inset 0px -5px 15px rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: 0.3s;
        }

        .toggle-label:after {
            content: "";
            width: 18px;
            height: 18px;
            position: absolute;
            top: 1.5px;
            left: 1px;
            background: linear-gradient(180deg, #ffcc89, #d8860b);
            border-radius: 18px;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.4);
            transition: 0.3s;
        }

        .toggle-input:checked + .toggle-label {
            background: #1B1C1E;
        }

        .toggle-input:checked + .toggle-label:after {
            left: calc(140% - 19px);
            transform: translateX(-100%);
            background: linear-gradient(180deg, #777, #3a3a3a);
        }
        .course-form {
            display: flex;
            flex-direction: column;
        }

        .form-row {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .form-row label {
            margin-bottom: 5px;
        }

        .form-row input {
            width: 100%; /* Make inputs take up full width */
            padding: 5px;
        }

        button[type="submit"] {
            margin-top: 10px;
            width: 100px;
        }.videos{
            margin-right:auto;
            margin-left:2.5rem;
            
        }


    </style>
</head>
<body>
    <div class="logo-container" style="margin-left: 1rem;">
        <h1 style="font-size: clamp(0.8rem, 2vw, 2.5rem);"><span class="grass">Agri</span>Learn</h1>
    </div>
<header>

    <div class="burger-btn">
        <i class='bx bx-menu' id="btn" style="font-size: 32px;"></i>
    </div>

    <div class="search-container">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' style="font-size:clamp(1.5rem, 2vw, 2.5rem); color:#1B1C1E"></i>
    </div>

    <div class="modes">
        <input type="checkbox" id="toggle" class="toggle-input">
        <label for="toggle" class="toggle-label"></label>
    </div>
     
</header>

<nav class="sidebar">
    <ul>
        <li>
            <a href="">
                <i class="bx bx-home" style="font-size: clamp(1.5rem, 2vw, 2rem);"></i>
                <span class="nav-item">Home</span>
            </a>
        </li>
        <li>
            <a href="">
            <i class='bx bx-user-circle' style="font-size: clamp(1.5rem, 2vw, 2rem);"></i>
                <span class="nav-item">Profile</span>
            </a>
        </li>
        <li>
            <a href="">
            <i class='bx bx-bell' style="font-size:clamp(1.5rem, 2vw, 2rem);"></i>
                <span class="nav-item">Notifications</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class="bx bx-book" style="font-size: clamp(1.5rem, 2vw, 2rem);"></i>
                <span class="nav-item">Enrolled</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class='bx bx-cart' style="font-size:clamp(1.5rem, 2vw, 2rem);"></i>
                <span class="nav-item">Purchase</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class='bx bx-receipt' style="font-size: clamp(1.5rem, 2vw, 2rem);"></i>
                <span class="nav-item">Transactions</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class='bx bx-exit' style="font-size: clamp(1.5rem, 2vw, 2rem);"></i>
                <span class="nav-item">Logout</span>
            </a>
           
        </li>
    </ul>
</nav>

<main class="main-content">
<div class="videos" >
<?php include('view.php'); ?>

</div>
</main>

<script>
const btn = document.querySelector('#btn');
const sidebar = document.querySelector('.sidebar');
const icons = document.querySelectorAll(".sidebar a i");
const navItems = document.querySelectorAll('nav ul li');
btn.onclick = function() {
    sidebar.classList.toggle('active');
    const isActive = sidebar.classList.contains('active');

};
document.body.style.backgroundImage = 'linear-gradient(180deg, #C8C1AC,#FFE794)';

const toggleInput = document.querySelector('.toggle-input');
toggleInput.addEventListener('change', function() {
    const isActive = sidebar.classList.contains('active');
    const nav = document.querySelector("nav");
    if (this.checked) {
        document.body.style.backgroundImage = 'linear-gradient(180.2deg, rgb(30, 33, 48) 6.8%, rgb(74, 98, 110) 131%)'; // Dark mode background color
        document.querySelector("h1").style.color = "white";
        document.querySelector("i").style.color = "white";
        document.querySelector(".nav-item").style.color = "white";
        document.querySelector(".bx-search").style.color = "white";
        document.querySelector(".bx-user-circle").style.color = "white";
        document.querySelector(".bx-home").style.color = "white";
        document.querySelector(".bx-book").style.color = "white";
        document.querySelector(".bx-bell").style.color = "white";
        document.querySelector(".bx-cart").style.color = "white";
        document.querySelector(".bx-receipt").style.color = "white";
        document.querySelector(".bx-exit").style.color = "white";
        document.querySelectorAll('.nav-item').forEach(item => {
            item.style.color = 'white';
        });
        if(isActive) {
            nav.classList.add('darkmode');
        }else{
            nav.classList.remove('darkmode');
        }
    } else {
        document.body.style.backgroundImage = 'linear-gradient(180deg, #C8C1AC,#FFE794)'; // Light mode background color
        document.querySelector("h1").style.color = "black";
        document.querySelector("i").style.color = "black";
        document.querySelector(".bx-search").style.color = "black";
        document.querySelector(".bx-user-circle").style.color = "black";
        document.querySelector(".bx-home").style.color = "black";
        document.querySelector(".bx-book").style.color = "black";
        document.querySelector(".bx-bell").style.color = "black";
        document.querySelector(".bx-cart").style.color = "black";
        document.querySelector(".bx-receipt").style.color = "black";
        document.querySelector(".bx-exit").style.color = "black";
        document.querySelector("nav").style.color = "black";
        document.querySelectorAll('.nav-item').forEach(item => {
            item.style.color = 'black';
        });
    }
});
</script>
</body>
</html>
