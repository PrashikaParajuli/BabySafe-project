<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['role'])){
    if($_SESSION['role']=='parent'){
            header("Location: /Babysafe/parent/dashboard.php");
            exit;
    }else{
        header("Location: /Babysafe/sitter/dashboard.php");
        exit;
    }

}
$errors = [];
require_once '../config/connection.php';
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        $role = $_POST['role'] ?? '';
        

        if ($role === 'parent') {
            $table ='parents';
        } else {
            $table ='sitters';
        }
        
        $sql ="SELECT * FROM $table WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
            
           
        if(mysqli_num_rows($result)){
            $user = mysqli_fetch_assoc($result);
            if(password_verify($password,$user['password'])){
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $role;

                if($role=='parent'){
                    header("Location: /Babysafe/parent/dashboard.php");
                    exit;
                }else{
                    header("Location: /Babysafe/sitter/dashboard.php");
                    exit;
                }
            }else{
                $errors["login"] = "Invalid Credentials";
            } 
        }else{
            $errors['login'] = "Account not Register";
        }

                    
}

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
        <div class="role-toggle">
            <button type="button" class="role-btn border active" onclick="set_role('parent',this);">I'm a Parent</button>
            <button type="button" class="role-btn border"  onclick="set_role('sitter',this);">I'm a Sitter</button>
        </div>
       
        <div>
            <form class="login_form" action="" method="post">
                <div class="input-area">
                    <input type="hidden" name="role" id="role" value="parent">
                    <label for="email"><i class="fa-solid fa-envelope"></i>Email <span class="required">*</span>
                    </label><br>
                    <input type="text" name="email" id="email" value="<?= htmlspecialchars($email ?? '') ?>"><br>
                </div>

                <div class="input-area">  
                    <label for="password"><i class="fa-solid fa-lock"></i>Password <span class="required">*</span>
                    </label><br>
                    <input type="password" name="password" id="password"><br>
                    <?php if (isset($errors['login'])): ?>
                    <p class="errors"><?php echo $errors['login']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="frg-pass">
                    <a href="forgot_pass.php" class="frg-pass">Forgot Password?</a><br>
                </div>

                <div class="input-area">
                    <button class="submit-btn signin-btn border">Sign In</button>
                    <p><small>Don't have an account? <a href="register.php">Sign Up</a></small></p>
                </div>
            
            </form>
        </div>
    </div>
    <script src="/babysafe/js/auth/script.js"></script>
</body>
</html>