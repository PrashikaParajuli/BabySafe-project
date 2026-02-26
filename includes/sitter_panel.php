<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sitter Dashboard</title>

    <link rel="stylesheet" href="/Babysafe/css/users/dashboard.css">
    <link rel="stylesheet" href="/Babysafe/css/users/booking.css">
    <link rel="stylesheet" href="/Babysafe/css/form.css">
    <link rel="stylesheet" href="/Babysafe/css/address.css">
    <link rel="stylesheet" href="/Babysafe/css/document.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h2>Sitter Panel</h2>
        </div>

        <ul class="sidebar-menu">

            <!-- Dashboard -->
            <li>
                <a href="/Babysafe/sitter/dashboard.php"
                class="<?= $current=='dashboard.php'?'active':'' ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <!-- My Bookings -->
            <li>
                <a href="/Babysafe/sitter/bookings.php"
                class="<?= $current=='bookings.php'?'active':'' ?>">
                    <i class="fas fa-calendar-check"></i> My Bookings
                </a>
            </li>

            <!-- Verification -->
            <li>
                <a href="/Babysafe/auth/is_auth/sitters/personal.php"
                class="<?= ($current=='personal.php' || $current=='address.php'|| $current=='document.php') ? 'active':'' ?>">
                    <i class="fas fa-user-check"></i> Verification
                </a>
            </li>

            <!-- Reviews -->
            <li>
                <a href="/Babysafe/sitter/reviews.php"
                class="<?= $current=='reviews.php'?'active':'' ?>">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </li>

            <!-- Logout -->
            <li>
                <a href="/Babysafe/auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>

        </ul>
    </aside>