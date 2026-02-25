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
require_once '../../../config/connection.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $spouse = mysqli_real_escape_string($conn, $_POST['spouse']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   

    // Validation
    if(empty($name)){ 
        $errors['name'] = "Full Name is required";
    }

    if(empty($dob)){
        $errors['dob'] = "Date of Birth is required";
    } 

    if(!empty($dob) && !preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $dob)) {
        $errors['dob'] = "Date of Birth must be in YYYY-MM-DD format";
    }

    if(empty($occupation)){

        $errors['occupation'] = "Occupation is required";
    }
    if(empty($age)){
        $errors['age'] = "Age is required";
    }

    if(!empty($age) && !is_numeric($age)){
        $errors['age'] = "Age must be a number";
    }

    if(empty($gender)){
        $errors['gender'] = "Gender is required";
    }

    // If no errors, insert into database
    if(empty($errors)) {
        $id = $_SESSION['id'];

        // Escape values for SQL
        $name = mysqli_real_escape_string($conn, $name);
        $dob = mysqli_real_escape_string($conn, $dob);
        $occupation = mysqli_real_escape_string($conn, $occupation);
        $age = mysqli_real_escape_string($conn, $age);
        $phone = mysqli_real_escape_string($conn, $phone);
        $gender = mysqli_real_escape_string($conn, $gender);

        if(empty($errors)) {
            $_SESSION['parents'] = [
                'name' => $name,
                'dob' => $dob,
                'occupation' => $occupation,
                'spouse' => $spouse,
                'age' => $age,
                'gender' => $gender
            ];
            header("Location: /babysafe/auth/is_auth/address.php");
            exit;
        } 
    }


}
?>

<div class="main-content">

<div class="form-container">
    <h2>Personal Information</h2>
    <form method="POST" id="personalForm">
        <div class="form-row">
            <div class="form-group">
                <label>Name <span class="required">*</span></label>
                <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required placeholder="Full Name">
                <?php if(isset($errors['name'])): ?><p class="error-message"><?= $errors['name'] ?></p><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Date of Birth <span class="required">*</span></label>
                <input type="date" name="dob" value="<?= htmlspecialchars($dob ?? '') ?>">
                <?php if(isset($errors['dob'])): ?><p class="error-message"><?= $errors['dob'] ?></p><?php endif; ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Occupation <span class="required">*</span></label>
                <input type="text" name="occupation" value="<?= htmlspecialchars($occupation ?? '') ?>" placeholder="Doctor">
                <?php if(isset($errors['occupation'])): ?><p class="error-message"><?= $errors['occupation'] ?></p><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Spouse (optional)</label>
                <input type="text" name="spouse" value="<?= htmlspecialchars($spouse ?? '') ?>" placeholder="Spouse Name">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Age <span class="required">*</span></label>
                <input type="text" name="age" value="<?= htmlspecialchars($age ?? '') ?>" placeholder="35">
                <?php if(isset($errors['age'])): ?><p class="error-message"><?= $errors['age'] ?></p><?php endif; ?>
            </div>

            <div class="form-group">
               <?php $gender = htmlspecialchars($gender ?? ''); ?>

            <label>Gender <span class="required">*</span></label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="male" <?= $gender === 'male' ? 'selected' : '' ?>>Male</option>
                <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Female</option>
                <option value="other" <?= $gender === 'other' ? 'selected' : '' ?>>Other</option>
            </select>
                <?php if(isset($errors['gender'])): ?><p class="error-message"><?= $errors['gender'] ?></p><?php endif; ?>
            </div>
        </div>

        <a href="address.php"><button class="btn">Next</button></a>
    </form>
</div>

</div>

    <script>
        document.getElementById("verificationPersonal").onsubmit = function () {

            // get input values
            var name = document.getElementById("name").value;
            var dob = document.getElementById("dob").value;
            var occupation = document.getElementById("occupation").value;
            var age = document.getElementById("age").value;
            

            // gender (radio button)
            var male = document.getElementById("male").checked;
            var female = document.getElementById("female").checked;
            var other = document.getElementById("other").checked;

            // clear old error messages
            document.getElementById("nameError").innerHTML = "";
            document.getElementById("dobError").innerHTML = "";
            document.getElementById("occupationError").innerHTML = "";
            document.getElementById("ageError").innerHTML = "";
            document.getElementById("genderError").innerHTML = "";

            var hasError = false;

            // name check
            if (name == "") {
                document.getElementById("nameError").innerHTML = "Full Name is required";
                hasError = true;
            }

            // dob check
            if (dob == "") {
                document.getElementById("dobError").innerHTML = "Date of Birth is required";
                hasError = true;
            }

            // occupation check
            if (occupation == "") {
                document.getElementById("occupationError").innerHTML = "Occupation is required";
                hasError = true;
            }

            // age check
            if (age == "") {
                document.getElementById("ageError").innerHTML = "Age is required";
                hasError = true;
            }

            // gender check
            if (male == false && female == false && other == false) {
                document.getElementById("genderError").innerHTML = "Gender is required";
                hasError = true;
            }

            // if error exists, stop form submit
            if (hasError == true) {
                return false;
            }

            // no error → form submits
            return true;
        };


    </script>
    
</body>
</html>