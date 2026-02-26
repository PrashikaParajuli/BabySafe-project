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

$parent_id = (int)$_GET['id'];

/* ================= SECURITY CHECK ================= */
$check = mysqli_query($conn,"
    SELECT p.*
    FROM parents p
    JOIN children c ON p.id = c.parent_id
    JOIN books b ON c.id = b.child_id
    WHERE p.id = $parent_id
    AND b.sitter_id = $sitter_id
    LIMIT 1
");

if(mysqli_num_rows($check) == 0){
    die("Access Denied");
}

$parent = mysqli_fetch_assoc($check);

/* ================= CHILDREN DATA ================= */
$children = mysqli_query($conn,"
    SELECT *
    FROM children
    WHERE parent_id = $parent_id
");
?>

<link rel="stylesheet" href="../css/booking.css">

<main class="main-content">

    <!-- ================= PARENT PROFILE ================= -->
    <div class="profile-card">
        <div class="left">
            <img src="../uploads/<?= $parent['image'] ?? 'default.png'; ?>" class="avatar">

            <div>
                <h2><?= htmlspecialchars($parent['name']) ?></h2>
                <p><?= htmlspecialchars($parent['email']) ?></p>

                <?php if ($parent['is_verified'] == 1): ?>
                    <span class="badge verified">✔ Verified</span>
                <?php else: ?>
                    <span class="badge not-verified">Not Verified</span>
                <?php endif; ?>

                <span class="badge parent">Parent</span>
            </div>
        </div>

        <div class="stats">

            <div class="stat">
                <h3><?= htmlspecialchars($parent['phone'] ?? 'N/A') ?></h3>
                <p>Phone</p>
            </div>

            <div class="stat">
                <h3><?= htmlspecialchars($parent['address'] ?? 'N/A') ?></h3>
                <p>Address</p>
            </div>

            <div class="stat">
                <h3>
                    <?= isset($parent['created_at']) 
                        ? date("d M Y", strtotime($parent['created_at'])) 
                        : 'N/A' ?>
                </h3>
                <p>Joined</p>
            </div>

        </div>
    </div>


    <!-- ================= CHILDREN SECTION ================= -->
    <div class="table-container">
        <h3>Children Profiles</h3>

        <?php if(mysqli_num_rows($children) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Allergies</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
               <?php while($child = mysqli_fetch_assoc($children)): ?>
                <tr>
                    <td>
                        <img src="../uploads/<?= $child['image'] ?? 'default.png' ?>" 
                            style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
                    </td>
                    <td><?= htmlspecialchars($child['name']) ?></td>
                    <td>
                        <?php 
                        if(!empty($child['age'])){
                            echo htmlspecialchars($child['age']);
                        } elseif(!empty($child['dob'])) {
                            $dob = new DateTime($child['dob']);
                            $today = new DateTime();
                            echo $dob->diff($today)->y;
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($child['gender'] ?? 'N/A') ?></td>
                    <td>
                        <?= isset($child['dob']) ? date("d M Y", strtotime($child['dob'])) : 'N/A' ?>
                    </td>
                    <td><?= htmlspecialchars($child['allergies'] ?? 'None') ?></td>
                    <td><?= htmlspecialchars($child['notes'] ?? 'None') ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>