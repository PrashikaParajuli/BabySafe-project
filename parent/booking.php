<?php
require '../config/connection.php';
session_start();

// Only allow logged-in parents
if(!isset($_SESSION['id']) || $_SESSION['role']!=='parent'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

$id = $_SESSION['id'];
require('../includes/parent_panel.php');

$error = "";

// Handle Add Booking Form
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $child_id = mysqli_real_escape_string($conn, $_POST['child_id']);
    $sitter_id = mysqli_real_escape_string($conn, $_POST['sitter_id']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);

    $start_datetime = strtotime($start_date.' '.$start_time);
    $end_datetime   = strtotime($end_date.' '.$end_time);
    $now = time();

    // Validation
    if($start_datetime < $now){
        $error = "Start date/time cannot be in the past.";
    } elseif($end_datetime <= $start_datetime){
        $error = "End date/time must be after start date/time.";
    }

    if(empty($error)){
        // Insert booking, status defaults to 'pending' in ENUM column
        $query = "INSERT INTO books (child_id, sitter_id, start_date, start_time, end_date, end_time)
                  VALUES ('$child_id','$sitter_id','$start_date','$start_time','$end_date','$end_time')";
        mysqli_query($conn, $query);
        header("Location: booking.php");
        exit;
    }
}

// Fetch parent's children
$children_result = mysqli_query($conn, "SELECT * FROM children WHERE parent_id = $id AND status='approved'");
$children = mysqli_fetch_all($children_result, MYSQLI_ASSOC);

// Fetch approved sitters
$sitters_result = mysqli_query($conn, "SELECT * FROM sitters WHERE is_verified=1 AND status=1");
$sitters = mysqli_fetch_all($sitters_result, MYSQLI_ASSOC);

// Fetch all bookings
$bookings_result = mysqli_query($conn, "
    SELECT b.*, c.name AS child_name, s.name AS sitter_name
    FROM books b
    JOIN children c ON b.child_id = c.id
    JOIN sitters s ON b.sitter_id = s.id
    WHERE c.parent_id = $id
    ORDER BY b.start_date DESC, b.start_time DESC
");
$bookings = mysqli_fetch_all($bookings_result, MYSQLI_ASSOC);
?>

<!-- Include CSS -->
<link rel="stylesheet" href="../css/booking.css">

<div class="main-content">

    <div class="form-container">
        <?php if(!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <h2>Book a Sitter</h2>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Child</label>
                    <select name="child_id" required>
                        <option value="">Select Child</option>
                        <?php foreach($children as $child): ?>
                        <option value="<?= $child['id'] ?>"><?= htmlspecialchars($child['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sitter</label>
                    <select name="sitter_id" required>
                        <option value="">Select Sitter</option>
                        <?php foreach($sitters as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label>Start Time</label>
                    <input type="time" name="start_time" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" required>
                </div>
                <div class="form-group">
                    <label>End Time</label>
                    <input type="time" name="end_time" required>
                </div>
            </div>

            <button type="submit" class="btn">Book Sitter</button>
        </form>
    </div>

    <div class="table-container">
        <h3>My Bookings</h3>
        <?php if(count($bookings) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Child</th>
                    <th>Sitter</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bookings as $index => $b): ?>
                <?php
                    $start_datetime = date("d M Y, h:i A", strtotime($b['start_date'].' '.$b['start_time']));
                    $end_datetime   = date("d M Y, h:i A", strtotime($b['end_date'].' '.$b['end_time']));
                    
                    // Use ENUM value directly
                    $status_text = strtolower(trim($b['status']));
                    if(empty($status_text)) $status_text = 'pending';
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($b['child_name']) ?></td>
                    <td><?= htmlspecialchars($b['sitter_name']) ?></td>
                    <td><?= $start_datetime ?></td>
                    <td><?= $end_datetime ?></td>
                    <td>
                        <span class="status <?= $status_text ?>"><?= ucfirst($status_text) ?></span>
                    </td>
                    <td>
                        <?php if($status_text == 'pending'): ?>
                            <a href="edit_booking.php?id=<?= $b['id'] ?>" class="edit-btn">Edit</a>
                            <a href="cancel_booking.php?id=<?= $b['id'] ?>" class="cancel-btn" onclick="return confirm('Cancel this booking?')">Cancel</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>No bookings yet.</p>
        <?php endif; ?>
    </div>
</div>