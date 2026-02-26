<?php
require '../config/connection.php';
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] !== 'sitter'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

require('../includes/sitter_panel.php');

$sitter_id = $_SESSION['id'];

if(!isset($_GET['id'])){
    header("Location: booking.php");
    exit;
}

$child_id = (int)$_GET['id'];

/* SECURITY CHECK */
$query = mysqli_query($conn,"
    SELECT c.*
    FROM children c
    JOIN books b ON c.id = b.child_id
    WHERE c.id=$child_id
    AND b.sitter_id=$sitter_id
    LIMIT 1
");

if(mysqli_num_rows($query)==0){
    die("Access Denied");
}

$child = mysqli_fetch_assoc($query);
?>

<link rel="stylesheet" href="../css/profile.css">

<div class="main-content">
    <div class="profile-card">

        <div class="profile-header">
            <img src="../uploads/<?= $child['image'] ?? 'default.png' ?>" class="profile-img">
            <div>
                <h2><?= htmlspecialchars($child['name']) ?></h2>
                <p class="role">Child Profile</p>
            </div>
        </div>

        <div class="profile-body">

            <div class="info-box">
                <h4>Age</h4>
                <p><?= htmlspecialchars($child['age'] ?? 'N/A') ?></p>
            </div>

            <div class="info-box">
                <h4>Gender</h4>
                <p><?= htmlspecialchars($child['gender'] ?? 'N/A') ?></p>
            </div>

            <div class="info-box">
                <h4>Date of Birth</h4>
                <p>
                    <?= isset($child['dob']) ? date("d M Y", strtotime($child['dob'])) : 'N/A' ?>
                </p>
            </div>

            <div class="info-box">
                <h4>Allergies</h4>
                <p><?= htmlspecialchars($child['allergies'] ?? 'None') ?></p>
            </div>

            <div class="info-box">
                <h4>Special Notes</h4>
                <p><?= htmlspecialchars($child['notes'] ?? 'None') ?></p>
            </div>

            <div class="info-box">
                <h4>Registered On</h4>
                <p>
                    <?= isset($child['created_at']) ? date("d M Y", strtotime($child['created_at'])) : 'N/A' ?>
                </p>
            </div>

        </div>

        <div class="profile-footer">
            <a href="booking.php" class="btn-back">← Back to Bookings</a>
        </div>

    </div>
</div>