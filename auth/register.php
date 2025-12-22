<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account | BabySafe</title>
    <link rel="stylesheet" href="static\css\register.css">
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="wrapper signup-wrapper">
        <h2>Create Your account</h2>
        <p class="subtitle">Join BabySafe Today!!</p>

        <div class="role-toggle">
            <button class="role-btn active border">I'm a Parent</button>
            <button class="role-btn border">I'm a Sitter</button>
        </div>

        <form class="register_form" action="" method="post">
            <div class="input-area">
                <label><span><i class="fa-solid fa-envelope"></i></span>Email</label><br>
                <input type="text" name="email" id="email"><br>
            </div>
            
            <div class="input-area">
                <label><i class="fa-solid fa-phone"></i>Phone</label><br>
                <input type="number" name="phone" id="phone"><br>
            </div>

            <div class="input-area">
                <label><span><i class="fa-solid fa-lock"></i></span>Password</label><br>
                <input type="password" name="password" id="password" required><br>
            </div>

            <div class="input-area">
                <label><span><i class="fa-solid fa-lock"></i></span>Confirm Password</label><br>
                <input type="password" name="confirm_password" id="confirm_password" required><br>
            </div>    

             <div class="input-area">
                 <label>
                     <input class="checkbox"  type="checkbox" required>
                     <span >I agree to the terms of Service and Privacy Policy.</span>
                    </label><br>
                </div>   
                
                <div class="input-area">
                    <button class="submit-btn crt-btn border" type="submit">Create Account</button>
                    <p> <small>Already have an account? <a href="login.php">Sign in</a> </small></p>
                </div>
            </form>
    </div>
</body>
</html>