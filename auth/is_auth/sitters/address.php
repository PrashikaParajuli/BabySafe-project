<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: /Babysafe/auth/login.php");
    exit;

}
$errors = [];
require_once '../../../config/connection.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $p_province =  mysqli_real_escape_string($conn, $_POST['p_province' ?? '']);
    $p_district =  mysqli_real_escape_string($conn, $_POST['p_district' ?? '']);
    $p_city =  mysqli_real_escape_string($conn, $_POST['p_city' ?? '']);
    $p_ward =  mysqli_real_escape_string($conn, $_POST['p_ward' ?? '']);
    $p_tole =  mysqli_real_escape_string($conn, $_POST['p_tole' ?? '']);
    $t_province =  mysqli_real_escape_string($conn, $_POST['t_province' ?? '']);
    $t_district =  mysqli_real_escape_string($conn, $_POST['t_district' ?? '']);
    $t_city =  mysqli_real_escape_string($conn, $_POST['t_city' ?? '']);
    $t_ward =  mysqli_real_escape_string($conn, $_POST['t_ward' ?? '']);
    $t_tole =  mysqli_real_escape_string($conn, $_POST['t_tole' ?? '']);


    if (empty($p_province)) {
    $errors['p_province'] = "Province is required";
    }

    if (empty($p_district)) {
    $errors['p_district'] = "District is required";
    }

    if (empty($p_city)) {
    $errors['p_city'] = "City is required";
    }

    if (empty($p_ward)) {
    $errors['p_ward'] = "Ward is required";
    }

    if (empty($p_tole)) {
    $errors['p_tole'] = "Tole is required";
    }

    if (empty($t_province)) {
    $errors['t_province'] = "Province is required";
    }

    if (empty($t_district)) {
    $errors['t_district'] = "District is required";
    }

    if (empty($t_city)) {
    $errors['t_city'] = "City is required";
    }

    if (empty($t_ward)) {
    $errors['t_ward'] = "Ward is required";
    }

    if (empty($t_tole)) {
    $errors['t_tole'] = "Tole is required";
    }

    if(empty($errors)){
        $id = $_SESSION['id'];
        $sql = "INSERT INTO sitters(
        p_province, p_district, p_city, p_ward, p_tole,
        t_province, t_district, t_city, t_ward, t_tole
    ) VALUES (
        '$p_province', '$p_district', '$p_city', '$p_ward', '$p_tole',
        '$t_province', '$t_district', '$t_city', '$t_ward', '$t_tole'
    )";

    if (mysqli_query($conn, $sql)) {
        header("Location: document.php");
        exit;
    } else {
        echo "Database error: " . mysqli_error($conn);
    }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address | BabySafe</title>
    <link rel="stylesheet" href="/babysafe/css/admin/form.css">
</head>
<body>
    <h2>Address Information</h2>
    <form method="POST">
        <h3>Permanant Address</h3>

        <div class="input-field">
            <label for="p_province">Province*</label><br>
            <input type="text" id="p_province" name="p_province" value="<?= htmlspecialchars($p_province ?? '') ?>">
            <?php if (isset($errors['p_province'])): ?>
            <p class="errors"><?php echo $errors['p_province'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="p_district">District*</label><br>
            <input type="text" id="p_district" name="p_district" value="<?= htmlspecialchars($p_district ?? '') ?>">
            <?php if (isset($errors['p_district'])): ?>
            <p class="errors"><?php echo $errors['p_district'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="p_city">City*</label><br>
            <input type="text" id="p_city" name="p_city" value="<?= htmlspecialchars($p_city ?? '') ?>">
            <?php if (isset($errors['p_city'])): ?>
            <p class="errors"><?php echo $errors['p_city'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="p_ward">Ward No.*</label><br>
            <input type="number" id="p_ward" name="p_ward" value="<?= htmlspecialchars($p_ward ?? '') ?>">
            <?php if (isset($errors['p_ward'])): ?>
            <p class="errors"><?php echo $errors['p_ward'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="p_tole">Tole*</label><br>
            <input type="text" id="p_tole" name="p_tole" value="<?= htmlspecialchars($p_tole ?? '') ?>">
            <?php if (isset($errors['p_tole'])): ?>
            <p class="errors"><?php echo $errors['p_tole'] ; ?></p>
            <?php endif; ?>
        </div>

        <h3>Temporary Address</h3>
        <div class="input-field">
            <label for="t_province">Province*</label><br>
            <input type="text" id="t_province" name="t_province" value="<?= htmlspecialchars($t_province ?? '') ?>">
            <?php if (isset($errors['t_province'])): ?>
            <p class="errors"><?php echo $errors['t_province'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="t_district">District*</label><br>
            <input type="text" id="t_district" name="t_district" value="<?= htmlspecialchars($t_district ?? '') ?>">
            <?php if (isset($errors['t_district'])): ?>
            <p class="errors"><?php echo $errors['t_district'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="t_city">City*</label><br>
            <input type="text"  id="t_city" name="t_city" value="<?= htmlspecialchars($t_city ?? '') ?>">
            <?php if (isset($errors['t_city'])): ?>
            <p class="errors"><?php echo $errors['t_city'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="t_ward">Ward No.*</label><br>
            <input type="number" id="t_ward"  name="t_ward" value="<?= htmlspecialchars($t_ward ?? '') ?>">
            <?php if (isset($errors['t_ward'])): ?>
            <p class="errors"><?php echo $errors['t_ward'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="t_tole">Tole*</label><br>
            <input type="text" id="t_tole" name="t_tole" value="<?= htmlspecialchars($t_tole ?? '') ?>">
            <?php if (isset($errors['t_tole'])): ?>
            <p class="errors"><?php echo $errors['t_tole'] ; ?></p>
            <?php endif; ?>
        </div>

        <!-- Back button -->
         <div>
            <button type="button" onclick="history.back()">Back</button>
        </div>

        <!-- Next button --> 
        <div>
            <button type="submit">Next</button>
        </div>
        
    </form>
</body>
</html>