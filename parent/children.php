<?php
require '../config/connection.php';
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role']!=='parent'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

$id = $_SESSION['id'];
require('../includes/parent_panel.php');
$error = "";

// Handle Add Child Form
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $allergies = mysqli_real_escape_string($conn, $_POST['allergies']);
    $special_needs = mysqli_real_escape_string($conn, $_POST['special_needs']);
    $interests = mysqli_real_escape_string($conn, $_POST['interests']);

  $image = 'default.png';
    if(isset($_FILES['image']) && $_FILES['image']['name']){
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image");
    }

    /* ---- Certificate Upload ---- */
    $certificate_type = mysqli_real_escape_string($conn, $_POST['certificate_type']);
    $certificate_path = null;

    if(isset($_FILES['certificate']) && $_FILES['certificate']['name']){

        $allowed = ['pdf','jpg','jpeg','png'];  // allowed file type 
        $file_ext = strtolower(pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION));

        if(in_array($file_ext, $allowed)){  // checking file type

            $certificate_path = time().'_'.$_FILES['certificate']['name'];
            move_uploaded_file($_FILES['certificate']['tmp_name'], "../uploads/$certificate_path");

        } else {

            $error = "Invalid certificate file type! Only PDF, JPG, JPEG, PNG allowed.";

        }
    }


    $status = 'pending';

    if(empty($error)){

        $query = "INSERT INTO children 
        (name, dob, gender, image, certificate_type, certificate_path, parent_id, status) 
        VALUES 
        ('$name','$dob','$gender','$image','$certificate_type','$certificate_path','$id','pending')";

        mysqli_query($conn, $query);

        header("Location: children.php");
        exit();
    }
}

// Fetch all children for this parent
$children_result = mysqli_query($conn, "SELECT * FROM children WHERE parent_id = $id");
$children = mysqli_fetch_all($children_result, MYSQLI_ASSOC);

// Check if any child is rejected
$rejected_child = false;
foreach($children as $child){
    if($child['status'] === 'rejected'){
        $rejected_child = true;
        break;
    }
}
?>

<div class="main-content">

    <div class="form-container">
        <!-- erroe message for the file type -->
        <?php if(!empty($error)): ?> 
    <div class="error-message">
        <?= $error ?>
    </div>
    <?php endif; ?>
    <h2>Add Child</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Allergies</label>
                <input type="text" name="allergies">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Special Needs</label>
                <input type="text" name="special_needs">
            </div>
            <div class="form-group">
                <label>Interests</label>
                <input type="text" name="interests">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Certificate Type</label>
                <select name="certificate_type" required>
                    <option value="birth">Birth Certificate</option>
                    <option value="adoption">Adoption Certificate</option>
                </select>
            </div>

            <div class="form-group">
                <label >Upload Certificate</label>
                <input type="file" name="certificate" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
    </div>

        <button type="submit" class="btn">Add Child</button>
    </form>
</div>

    <div class="table-container">
        <h3>My Children</h3>
        <?php if(count($children) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Image</th>
                    <th>Certificate</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Allergies</th>
                    <th>Special Needs</th>
                    <th>Interests</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($children as $index => $child): ?>
                <tr>
                    <td><?= $index+1 ?></td>
                    <td>
                        <img src="../uploads/<?= $child['image'] ?>" style="width:50px;height:50px;border-radius:50%;" alt="child">
                    </td>
                   <td>
                        <?= ucfirst($child['certificate_type']) ?>
                        <br>
                        <?php if($child['certificate_path']): ?>
                            <a href="../uploads/<?= $child['certificate_path'] ?>" target="_blank">View</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($child['name']) ?></td>
                    <td><?= htmlspecialchars($child['dob']) ?></td>
                    <td><?= $child['gender']==0?'Male':'Female' ?></td>
                    <td><?= htmlspecialchars($child['allergies']) ?></td>
                    <td><?= htmlspecialchars($child['special_needs']) ?></td>
                    <td><?= htmlspecialchars($child['interests']) ?></td>
                    <td>
                        <?php
                            $status_class = 'pending';
                            if($child['status'] === 'approved') $status_class = 'accepted';
                            if($child['status'] === 'rejected') $status_class = 'rejected';
                        ?>
                        <span class="status <?= $status_class ?>"><?= ucfirst($child['status']) ?></span>
                    </td>
                    <td>
                        <?php if($child['status'] === 'rejected'): ?>
                            <a href="edit_child.php?id=<?= $child['id'] ?>" class="edit-btn">
                                Edit & Re-Apply
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>No children added yet.</p>
        <?php endif; ?>
    </div>

    <?php if($rejected_child): ?>
        <div style="padding:15px;background:#f8d7da;color:#721c24;border-radius:8px;margin-top:20px;">
            One or more of your children have been rejected. You cannot book a sitter until the issue is resolved.
        </div>
    <?php endif; ?>
</div>