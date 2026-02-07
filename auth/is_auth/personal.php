<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: /Babysafe/auth/login.php");
    exit;

}
$errors = [];
require_once '../../config/connection.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = trim($_POST['name'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $occupation = trim($_POST['occupation'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $gender = $_POST['gender'] ?? '';

    // Validation
    if(empty($name)){ 
        $errors['name'] = "Full Name is required";}
    if(empty($dob)){
        $errors['dob'] = "Date of Birth is required";
    } 
    if(!empty($dob) && !preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $dob)) {
        $errors['dob'] = "Date of Birth must be in YYYY-MM-DD format";
    }
    if(empty($occupation)) $errors['occupation'] = "Occupation is required";
    if(empty($age)) $errors['age'] = "Age is required";
    if(!empty($age) && !is_numeric($age)) $errors['age'] = "Age must be a number";
    if(empty($phone)) $errors['phone'] = "Phone number is required";
    if(!empty($phone) && !preg_match('/^\d{10}$/', $phone)) $errors['phone'] = "Phone must be 10 digits";
    if(empty($gender)) $errors['gender'] = "Gender is required";

    // If no errors, insert into database
    if(empty($errors)) {
        $user_id = $_SESSION['id'];

        // Escape values for SQL
        $name = mysqli_real_escape_string($conn, $name);
        $dob = mysqli_real_escape_string($conn, $dob);
        $occupation = mysqli_real_escape_string($conn, $occupation);
        $age = mysqli_real_escape_string($conn, $age);
        $phone = mysqli_real_escape_string($conn, $phone);
        $gender = mysqli_real_escape_string($conn, $gender);

        $sql = "INSERT INTO user_verification (user_id, name, dob, occupation, age, phone, gender) 
                VALUES ('$user_id', '$name', '$dob', '$occupation', '$age', '$phone', '$gender')";

        if(mysqli_query($conn, $sql)) {
            $_SESSION['verification'] = [
                'name' => $name,
                'dob' => $dob,
                'occupation' => $occupation,
                'age' => $age,
                'phone' => $phone,
                'gender' => $gender
            ];
            header("Location: address.php");
            exit;
        } else {
            $errors['database'] = "Failed to save data: " . mysqli_error($conn);
        }
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification | BabySafe</title>
</head>
<body>
    <!-- Step 1 of Verification -->
    <h2>Personal Information</h2>
    <form  method="post">
        <div class="input-field">
            <label for="name">Full Name</label><br>
            <input type="text" name="name" placeholder="Full Name"><br>
        </div>

        <div class="input-field">
            <label for="dob">Date of Birth</label><br>
            <input type="text" name="dob" placeholder="2050-5-8"><br>
        </div>

        <div class="input-field">
            <label for="occupation">Occupation</label><br>
            <input type="text" name="occupation" placeholder="Doctor"><br>
        </div>

        <div class="input-field">
            <label for="age">Age</label><br>
            <input type="text" name="age" placeholder="35"><br>
        </div>

        <div class="input-field">
            <label for="phone">Phone</label><br>
            <input type="number" name="phone" placeholder="9800000000" >
        </div>

        <div class="input-field">
            <label>Gender</label><br>

            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label>

            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>

            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Other</label>
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