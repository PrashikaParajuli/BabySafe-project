<?php
session_start();
require '../config/connection.php';

if (!isset($_SESSION['id']) || strtolower($_SESSION['role']) !== 'parent') {
    header("Location: /Babysafe/auth/login.php");
    exit;
}

$parent_id = $_SESSION['id'];
require('../includes/parent_panel.php');

if (!isset($_GET['book_id'])) {
    die("Invalid booking.");
}

$booking_id = (int) $_GET['book_id'];

/* ================= CHECK BOOKING ================= */
$booking_query = mysqli_query($conn, "
    SELECT b.*, s.name AS sitter_name, c.parent_id
    FROM books b
    JOIN sitters s ON b.sitter_id = s.id
    JOIN children c ON b.child_id = c.id
    WHERE b.id = $booking_id
    AND b.status = 'accepted'
");

if (mysqli_num_rows($booking_query) == 0) {
    die("You can only review accepted bookings.");
}

$booking = mysqli_fetch_assoc($booking_query);

/* Make sure this booking belongs to logged parent */
if ($booking['parent_id'] != $parent_id) {
    die("Unauthorized access.");
}

/* ================= CHECK DUPLICATE ================= */
$check = mysqli_query($conn, "
    SELECT * FROM reviews WHERE booked_id = $booking_id
");

if (mysqli_num_rows($check) > 0) {
    die("You already reviewed this booking.");
}

/* ================= SUBMIT ================= */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $rating = (float) $_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    if ($rating < 1 || $rating > 5) {
        die("Invalid rating.");
    }

    mysqli_query($conn, "
        INSERT INTO reviews (comment, rating, booked_id)
        VALUES ('$comment', $rating, $booking_id)
    ");

    header("Location: dashboard.php");
    exit;
}
?>

<link rel="stylesheet" href="../css/booking.css">

<div class="review-card">
    <h3>Review for <?= htmlspecialchars($booking['sitter_name']) ?></h3>

    <form method="POST">

        <label>Rating</label>
        <div class="star-rating">
            <input type="radio" name="rating" value="5" id="star5" required>
            <label for="star5">★</label>

            <input type="radio" name="rating" value="4" id="star4">
            <label for="star4">★</label>

            <input type="radio" name="rating" value="3" id="star3">
            <label for="star3">★</label>

            <input type="radio" name="rating" value="2" id="star2">
            <label for="star2">★</label>

            <input type="radio" name="rating" value="1" id="star1">
            <label for="star1">★</label>
        </div>

        <label>Comment</label>
        <textarea name="comment" rows="4" required></textarea>

        <button type="submit" class="btn review-submit">
            Submit Review
        </button>

    </form>
</div>