<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Babysafe/css/front_end/style.css">
    <link rel="stylesheet" href="/Babysafe/css/find_sitter.css">
    <link rel="stylesheet" href="/Babysafe/css/contact.css">
    <link rel="stylesheet" href="/Babysafe/css/about.css">
</head>
<body>
    <nav>
        <div class="logo border">
            <label><a href="index.php">BabySafe</label></a>  
            <!-- <img src="assets/logo.png" alt="BabySafe"> -->
        </div>
        <div class="nav-links">
            <ul>
                <li class="border"><a href="index.php">Home</a></li>
                <li class="border"><a href="find_sitters.php">Find A Sitter</a></li>
                <li class="border"><a href="contact.php">Contact Us</a></li>
                <li class="border"><a href="about.php">About Us</a></li>
            </ul>
        </div>
        <div class="nav-btns">
            <ul>
                <li>
                    <?php if(!isset($_SESSION['id'])): ?>
                    <a href="/Babysafe/auth/register.php"><button class="nav-register">Register</button></a>
                </li>
                <li>
                    <a href="/Babysafe/auth/login.php"><button class="nav-login">Login</button></a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>