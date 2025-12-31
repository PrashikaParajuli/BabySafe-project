<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    


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

        <div class="role-toggle">
            <button class="role-btn border">I'm a Parent</button>
            <button class="role-btn border">I'm a Sitter</button>
        </div>

        <form class="register_form" action="" method="post">
            <div class="input-area">
                <label for="email"><i class="fa-solid fa-envelope"></i>Email 
                    <span class="required">*</span>
                </label><br>
                <input type="text" name="email" id="email" required><br>
            </div>
            
            <div class="input-area">
                <label for="phone"><i class="fa-solid fa-phone"></i>Phone 
                    <span class="required">*</span>
                </label><br>
                <input type="number" name="phone" id="phone" required><br>
            </div>

            <div class="input-area">
                <label for="password"><i class="fa-solid fa-lock"></i>Password 
                    <span class="required">*</span>
                </label><br>
                <input type="password" name="password" id="password" required><br>
            </div>

            <div class="input-area">
                <label for="confirm_password"><i class="fa-solid fa-lock"></i>Confirm Password
                    <span class="required">*</span>
                </label><br>
                <input type="password" name="confirm_password" id="confirm_password" required><br>
            </div>    

             <div class="input-area">
                 <label>
                        <input class="checkbox"  type="checkbox" required>
                        <span>I agree to the terms of Service and Privacy Policy.</span>
                    </label><br>
                </div>   
                
                <div class="input-area">
                    <button class="submit-btn crt-btn border" type="submit">Create Account</button>
                    <p> <small>Already have an account? <a href="login.php">Sign in</a></small></p>
                </div>
            </form>
    </div>
</body>
</html>