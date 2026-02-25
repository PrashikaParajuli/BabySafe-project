<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role']!=='parent'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}


$id = $_SESSION['id'];
$page='Verification';
require('../../../includes/parent_panel.php');

$errors = [];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $doc = $_POST['doc'] ?? '';
    if($doc=='') $errors['doc']="Choose document";

    if(($doc=='citizenship'||$doc=='license')){
        if($_FILES['front']['name']=='') $errors['front']="Front required";
        if($_FILES['back']['name']=='') $errors['back']="Back required";
    }
    if($doc=='passport'){
        if($_FILES['passport']['name']=='') $errors['passport']="Passport required";
    }
    if($_FILES['photo']['name']=='') $errors['photo']="Photo required";

    if(empty($errors)){
        // Handle file uploads
        $front=$back=$passport=null;
        if($doc=='citizenship'||$doc=='license'){
            $front='upload/front_'.$_FILES['front']['name'];
            $back='upload/back_'.$_FILES['back']['name'];
            move_uploaded_file($_FILES['front']['tmp_name'],$front);
            move_uploaded_file($_FILES['back']['tmp_name'],$back);
        }
        if($doc=='passport'){
            $passport='upload/passport_'.$_FILES['passport']['name'];
            move_uploaded_file($_FILES['passport']['tmp_name'],$passport);
        }
        $photo='upload/photo_'.$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'],$photo);

        // Fetch session data
        $personal = $_SESSION['personal'];
        $address  = $_SESSION['address'];

        // Escape strings for mysqli
        $name = mysqli_real_escape_string($conn,$personal['name']);
        $dob = mysqli_real_escape_string($conn,$personal['dob']);
        $age = mysqli_real_escape_string($conn,$personal['age']);
        $occupation = mysqli_real_escape_string($conn,$personal['occupation']);
        $spouse = mysqli_real_escape_string($conn,$personal['spouse']);
        $gender = mysqli_real_escape_string($conn,$personal['gender']);

        $p_province = mysqli_real_escape_string($conn,$address['p_province']);
        $p_district = mysqli_real_escape_string($conn,$address['p_district']);
        $p_city = mysqli_real_escape_string($conn,$address['p_city']);
        $p_address = mysqli_real_escape_string($conn,$address['p_address']);

        $t_province = mysqli_real_escape_string($conn,$address['t_province']);
        $t_district = mysqli_real_escape_string($conn,$address['t_district']);
        $t_city = mysqli_real_escape_string($conn,$address['t_city']);
        $t_address = mysqli_real_escape_string($conn,$address['t_address']);

        $doc_type = mysqli_real_escape_string($conn,$doc);
        $front = mysqli_real_escape_string($conn,$front);
        $back = mysqli_real_escape_string($conn,$back);
        $passport = mysqli_real_escape_string($conn,$passport);
        $photo = mysqli_real_escape_string($conn,$photo);
        $status = 'pending';

        // Insert into database
        $sql = "INSERT INTO parents
        (name,dob,age,occupation,spouse,gender,
        p_province,p_district,p_city,p_address,
        t_province,t_district,t_city,t_address,
        doc_type,front,back,passport,photo,status)
        VALUES
        ('$name','$dob','$age','$occupation','$spouse','$gender',
        '$p_province','$p_district','$p_city','$p_address',
        '$t_province','$t_district','$t_city','$t_address',
        '$doc_type','$front','$back','$passport','$photo','$status')";

        if(mysqli_query($conn,$sql)){
            unset($_SESSION['personal'],$_SESSION['address']);
            echo "Verification submitted. Waiting for admin approval.";
        }else{
            echo "Error: ".mysqli_error($conn);
        }
    }
}
?>

<h2 class="doc-title">Upload Document</h2>

<form class="doc-form" action="" method="post" enctype="multipart/form-data">

    <div class="doc-input-field">
        <label>Select Document Type *</label>
        <select name="doc_type" onchange="showFields(this.value)">
            <option value="">-- Select --</option>
            <option value="citizenship">Citizenship</option>
            <option value="driving license">Driving License</option>
            <option value="passport">Passport</option>
        </select>
        <div class="doc-error"><?= $errors['doc'] ?? '' ?></div>
    </div>

    <div class="doc-front-back">
        <div class="doc-input-field">
            <label>Front *</label>
            <input type="file" name="front">
            <div class="doc-error"><?= $errors['front'] ?? '' ?></div>
        </div>
        <div class="doc-input-field">
            <label>Back *</label>
            <input type="file" name="back">
            <div class="doc-error"><?= $errors['back'] ?? '' ?></div>
        </div>
    </div>

    <div class="doc-passport">
        <div class="doc-input-field">
            <label>Passport *</label>
            <input type="file" name="passport">
            <div class="doc-error"><?= $errors['passport'] ?? '' ?></div>
        </div>
    </div>

    <div class="doc-input-field">
        <label>Upload Profile Photo *</label>
        <input type="file" name="photo">
        <div class="doc-error"><?= $errors['photo'] ?? '' ?></div>
    </div>

    <div>
        <button type="button" class="doc-btn doc-back-btn" onclick="history.back()">Back</button>
        <button type="submit" class="doc-btn">Submit</button>
    </div>

</form>

<script>
function showFields(value){
    document.querySelector('.doc-front-back').style.display = (value === 'citizenship' || value === 'driving license') ? 'flex' : 'none';
    document.querySelector('.doc-passport').style.display = (value === 'passport') ? 'flex' : 'none';
}
</script>

</body>
</html>