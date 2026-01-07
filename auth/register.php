<?php
$errors = [];
require_once '../config/connection.php';
session_start();
if(isset($_SESSION['id'])){
    // header("Location: /dashboard/");

}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string ($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'] ?? '';

    // checking who is trying register (parent or sitter)
    if(empty($role)){
        $errors['role'] = "Please Select Parent or Sitter.";    
    }
    elseif ($role === 'parent') {
        $table ='parents';
    } elseif ($role === 'sitter') {
        $table ='sitters';
    }
    
    /* Email Validates */
    if (empty($email)) {
        $errors['email'] = "Email is required";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    /* checks phone length  */
    if (empty($phone)) {
        $errors['phone'] = "Phone is required";
    }elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors['phone'] = "Phone number must be 10 digits.";
    }

     /* password validates */
     if (empty($password)) {
        $errors['password'] = "Password is required";
    }elseif (
        strlen($password) < 8 ||
        !preg_match("/[A-Z]/", $password) ||
        !preg_match("/[a-z]/", $password) ||
        !preg_match("/[0-9]/", $password) ||
        !preg_match("/[\W]/", $password)
    ){
        $errors['password'] = "The passowrd must be 8 character and contain upper case, lower case, special character and number.";
    }

    elseif($password!==$confirm_password){
        $errors["confirm_password"] = "Password and confirm password doesn't match.";
    }
     // error na vayea si database ma janxa
        if (empty($errors)) {
            
            //checking wheather user email already exists or not
            $sql = "SELECT * FROM $table WHERE email='".$email."' LIMIT 1";
            $result =  mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result)){
                $errors['email']= "Email already exists";
            }else{
                $password= password_hash($password, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO $table(email, phone, password) VALUES('$email', '$phone', '$password')";
                $result = mysqli_query($conn, $sql);
                
                if($result){
                    echo "Account created successfully";
                }else{
                    echo "Insert failed: " . mysqli_error($conn);
                }
            }
        }  
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account | BabySafe</title>
    <link rel="stylesheet" href="/babysafe/css/auth/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="wrapper signin-wrapper">
        <h2>Create Your account</h2>
        <p class="subtitle">Join BabySafe Today!!</p>
        <?php if (isset($errors['role'])): ?>
        <p class="errors"><br><?php echo  $errors['role']; ?></p>
        <?php endif; ?>
        <div class="role-toggle">
            <button type="button" class="role-btn border" onclick="set_role('parent');">I'm a Parent</button>
            <button type="button" class="role-btn border"  onclick="set_role('sitter');">I'm a Sitter</button>
        </div>
        
        <form class="register_form" action="" method="post">
            <div class="input-area">
                <input type="hidden" name="role" id="role">

                <label for="email"><i class="fa-solid fa-envelope"></i>Email 
                <span class="required">*</span>
                </label><br>
                <input type="text" name="email" id="email" required  ><br>
                <?php if (isset($errors['email'])): ?>
                <p class="errors"><?php echo $errors['email'] ; ?></p>
                <?php endif; ?>
            </div>
        
            <div class="input-area">
                <label for="phone"><i class="fa-solid fa-phone"></i>Phone 
                <span class="required">*</span>
                </label><br>
                <input type="text" name="phone" id="phone" maxlength="10" required ><br>
                <?php if (isset($errors['phone'])): ?>
                <p class="errors"><?php echo $errors['phone']; ?></p>
                <?php endif; ?>
            </div>
        
            <div class="input-area">
                <label for="password"><i class="fa-solid fa-lock"></i>Password 
                    <span class="required">*</span>
                </label><br>
                <input type="password" name="password" id="password" required  ><br>
                <?php if (isset($errors['password'])): ?>
                <p class="errors"><?php echo $errors['password']; ?></p>
                <?php endif; ?>
            </div>

            <div class="input-area">
                <label for="confirm_password"><i class="fa-solid fa-lock"></i>Confirm Password
                <span class="required">*</span>
            </label><br>
            <input type="password" name="confirm_password" id="confirm_password" required  ><br>
            <?php if (isset($errors['confirm_password'])): ?>
            <p class="errors"><?php echo $errors['confirm_password']; ?></p>
             <?php endif; ?>
            </div>    

            <div class="input-area">
                <label>
                    <input class="checkbox"  type="checkbox" required>
                    <span>I agree to the terms of Service and Privacy Policy.</span>
                </label><br>
            </div>   

            <div class="input-area">
                <button class="submit-btn border" type="submit">Create Account</button>
                <p> <small>Already have an account? <a href="login.php">Sign in</a></small></p>
            </div>
        </form>
    </div>
</body>
<script src="/babysafe/js/auth/script.js"></script>
</html>