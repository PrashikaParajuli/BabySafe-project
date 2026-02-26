<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Parent Dashboard</title>

    <link rel="stylesheet" href="/Babysafe/css/users/dashboard.css">
    <link rel="stylesheet" href="../css/users/children.css">
    <link rel="stylesheet" href="../css/users/booking.css">
    <link rel="stylesheet" href="../users/review.css">
    <link rel="stylesheet" href="/babysafe/css/form.css">
    <link rel="stylesheet" href="/Babysafe/css/address.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h2>Parent Panel</h2>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="/babysafe/parent/dashboard.php" class="<?= $current=='dashboard.php'?'active':'' ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="/babysafe/parent/booking.php" class="<?= $current=='booking.php'?'active':'' ?>">
                    <i class="fas fa-user-plus"></i> Book Sitter
                </a>
            </li>

           <li>
                <a href="/babysafe/parent/children.php" 
                class="<?= ($current=='children.php' || $current=='edit_child.php') ? 'active' : '' ?>">
                    <i class="fas fa-child"></i> My Children
                </a>
            </li>

             <li>
                <a href="/babysafe/auth/is_auth/parents/personal.php" 
                class="<?= ($current=='personal.php' || $current=='address.php'|| $current=='document.php' )?'active':'' ?>">
                    <i class="fas fa-child"></i> Verification
                </a>
            </li>

            <li>
                <a href="/babysafe/parent/review.php" class="<?= $current=='review.php'?'active':'' ?>">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </li>

            <li>
                <a href="/Babysafe/auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </aside>