<?php
require '../config/connection.php';
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] !== 'parent'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

$id = $_SESSION['id'];
require('../includes/parent_panel.php');

$bookings = mysqli_query($conn,"
SELECT books.id bid, sitters.name sitter
FROM books
JOIN children ON books.child_id=children.id
JOIN sitters ON books.sitter_id=sitters.id
WHERE children.parent_id=$parent_id AND books.status=1
AND books.id NOT IN (SELECT booked_id FROM reviews)
");

if($_SERVER['REQUEST_METHOD']=='POST'){
    mysqli_query($conn,"INSERT INTO reviews(comment,rating,booked_id)
        VALUES('{$_POST['comment']}','{$_POST['rating']}','{$_POST['booked_id']}')");
}
?>