<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Account | BabySafe</title>
    <link rel="stylesheet" href="/babysafe/css/auth/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="wrapper signin-wrapper">
        <h2>Welcome Back !</h2>
        <p class="subtitle">Sign into your BabySafe</p>
        <br>
        <div>
            <form class="login_form" action="" method="post">
                <div class="input-area">
                    <label for="email"><i class="fa-solid fa-envelope"></i>Email <span class="required">*</span>
                    </label><br>
                    <input type="text" name="email" id="email"><br>
                </div>

                <div class="input-area">  
                    <label for="password"><i class="fa-solid fa-lock"></i>Password <span class="required">*</span>
                    </label><br>
                    <input type="password" name="password" id="password"><br>
                </div>

                <!-- <div class="input-area">
                    <label>
                        <input class="checkbox"  type="checkbox">
                        <span >Remember Me</span>
                    </label><br> -->

                <div class="frg-pass">
                    <a href="forgot_pass.php" class="frg-pass">Forgot Password?</a><br>
                </div>

                    <div class="input-area">
                        <button class="submit-btn signin-btn border">Sign In</button>
                        <p><small>Don't have an account? <a href="register.php">Sign Up</a></small></p>
                    </div>
                
            </form>
        </div>
</body>
</html>