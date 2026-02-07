<?php
session_start();
if(!isset($_SESSION['id']) || $_SESSION['role'] !=='sitter'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitter Dashboard</title>
</head>
<body>
    <h2>Welcome to Sitter Dashboard</h2>

    <p>Click below to start verification:</p>

    <a href="../auth/is_auth/personal.php">
        <button>Start Verification</button>
    </a>
        
</body>
</html>