<?php
require '../config/connection.php';
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] !== 'sitter'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

require('../includes/sitter_panel.php');

$sitter_id = $_SESSION['id'];

/* UPDATE STATUS */
if(isset($_GET['id']) && isset($_GET['status'])){
    $booking_id = (int)$_GET['id'];
    $status = strtolower(trim($_GET['status']));

    if(in_array($status, ['accepted','rejected'])){
        mysqli_query($conn,"
            UPDATE books 
            SET status='$status'
            WHERE id=$booking_id 
            AND sitter_id=$sitter_id
        ");
    }

    header("Location: booking.php");
    exit;
}

/* FETCH BOOKINGS */
$result = mysqli_query($conn,"
    SELECT 
        b.id,
        b.start_date,
        b.start_time,
        b.end_date,
        b.end_time,
        b.status,

        c.id AS child_id,
        c.name AS child_name,

        p.id AS parent_id,
        p.name AS parent_name

    FROM books b
    JOIN children c ON b.child_id = c.id
    JOIN parents p ON c.parent_id = p.id
    WHERE b.sitter_id = $sitter_id
    ORDER BY b.start_date DESC, b.start_time DESC
");
?>

<link rel="stylesheet" href="../css/booking.css">

<div class="main-content">
<div class="table-container">
<h2>My Booking Requests</h2>

<?php if(mysqli_num_rows($result) > 0): ?>
<table>
<tr>
<th>S.N</th>
<th>Parent</th>
<th>Child</th>
<th>Schedule</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php $i=1; while($row=mysqli_fetch_assoc($result)): 
$status = strtolower($row['status']);
if(empty($status)) $status='pending';

$start = date("d M Y, h:i A", strtotime($row['start_date'].' '.$row['start_time']));
$end   = date("d M Y, h:i A", strtotime($row['end_date'].' '.$row['end_time']));
?>

<tr>
<td><?= $i++ ?></td>

<!-- Parent -->
<td>
<strong><?= htmlspecialchars($row['parent_name']) ?></strong><br>
<a href="view_parent.php?id=<?= $row['parent_id'] ?>" class="profile-link">
View Profile
</a>
</td>

<!-- Child -->
<td>
<strong><?= htmlspecialchars($row['child_name']) ?></strong><br>
<a href="view_child.php?id=<?= $row['child_id'] ?>" class="profile-link">
View Profile
</a>
</td>

<!-- Schedule -->
<td>
<?= $start ?><br>to<br><?= $end ?>
</td>

<!-- Status -->
<td>
<span class="status <?= $status ?>">
<?= ucfirst($status) ?>
</span>
</td>

<!-- Action -->
<td>
<?php if($status==='pending'): ?>
<a href="?id=<?= $row['id'] ?>&status=accepted" class="btn accept">Accept</a>
<a href="?id=<?= $row['id'] ?>&status=rejected" class="btn reject">Reject</a>
<?php else: ?>
-
<?php endif; ?>
</td>
</tr>

<?php endwhile; ?>
</table>
<?php else: ?>
<p>No booking requests.</p>
<?php endif; ?>

</div>
</div>