<?php
require '../config/connection.php';
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role']!=='parent'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

$parent_id = $_SESSION['id']; // mattching the parent and session id 
$id = $_GET['id'];

$page = 'children'; // now the page become children

require('../includes/parent_panel.php');

$query = mysqli_query($conn,
    "SELECT * FROM children 
     WHERE id='$id' AND parent_id='$parent_id'"
);

$child = mysqli_fetch_assoc($query);

if(!$child || $child['status'] !== 'rejected'){
    header("Location: children.php");
    exit;
}

$error = "";

/* UPDATE LOGIC  of child */
if($_SERVER['REQUEST_METHOD']=='POST'){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $dob = mysqli_real_escape_string($conn,$_POST['dob']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $allergies = mysqli_real_escape_string($conn,$_POST['allergies']);
    $special_needs = mysqli_real_escape_string($conn,$_POST['special_needs']);
    $interests = mysqli_real_escape_string($conn,$_POST['interests']);
    $certificate_type = mysqli_real_escape_string($conn,$_POST['certificate_type']);

    $image = $child['image'];
    $certificate_path = $child['certificate_path'];

    /* Image Update */
    if(!empty($_FILES['image']['name'])){
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image");
    }

    /* Certificate Update */
    if(!empty($_FILES['certificate']['name'])){

        $allowed = ['pdf','jpg','jpeg','png'];
        $file_ext = strtolower(pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION));

        if(in_array($file_ext,$allowed)){
            $certificate_path = time().'_'.$_FILES['certificate']['name'];
            move_uploaded_file($_FILES['certificate']['tmp_name'], "../uploads/$certificate_path");
        } else {
            $error = "Invalid certificate file type!";
        }
    }

    if(empty($error)){

        mysqli_query($conn,"UPDATE children SET
            name='$name',
            dob='$dob',
            gender='$gender',
            allergies='$allergies',
            special_needs='$special_needs',
            interests='$interests',
            image='$image',
            certificate_type='$certificate_type',
            certificate_path='$certificate_path',
            status='pending'
            WHERE id='$id' AND parent_id='$parent_id'
        ");

        header("Location: children.php");
        exit;
    }
}
?> 
<!-- edit ghareko so html body chaidaiina already children ma xa  -->

<div class="main-content">

    <div class="form-container">

        <!-- Back Button -->
        <div style="margin-bottom:15px;">
            <a href="children.php" style="text-decoration:none;color:#1f3f4b;font-weight:600;">
                ← Back
            </a>
        </div>

        <h2>Edit Child & Re-Apply</h2>

        <?php if(!empty($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" 
                           value="<?= $child['name'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" 
                           value="<?= $child['dob'] ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="0" <?= $child['gender']==0?'selected':'' ?>>Male</option>
                        <option value="1" <?= $child['gender']==1?'selected':'' ?>>Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Allergies</label>
                    <input type="text" name="allergies" 
                           value="<?= $child['allergies'] ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Special Needs</label>
                    <input type="text" name="special_needs" 
                           value="<?= $child['special_needs'] ?>">
                </div>

                <div class="form-group">
                    <label>Interests</label>
                    <input type="text" name="interests" 
                           value="<?= $child['interests'] ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Certificate Type</label>
                    <select name="certificate_type" required>
                        <option value="birth" <?= $child['certificate_type']=='birth'?'selected':'' ?>>Birth Certificate</option>
                        <option value="adoption" <?= $child['certificate_type']=='adoption'?'selected':'' ?>>Adoption Certificate</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Change Certificate</label>
                    <input type="file" name="certificate">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Change Image</label>
                    <input type="file" name="image">
                </div>
            </div>

            <button type="submit" class="btn">
                Update & Re-Apply
            </button>

        </form>
    </div>
</div>