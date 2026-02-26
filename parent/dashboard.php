<?php
session_start();
require '../config/connection.php';

/* ================= SESSION CHECK ================= */
if (!isset($_SESSION['id']) || strtolower($_SESSION['role']) !== 'parent') {
    header("Location: /Babysafe/auth/login.php");
    exit;
}

require('../includes/parent_panel.php');
$id = (int) $_SESSION['id'];

/* ================= PARENT INFO ================= */
$parent = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM parents WHERE id = $id")
);

/* ================= TOTAL BOOKINGS ================= */
$booking_data = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT COUNT(*) AS total_bookings 
        FROM books b
        JOIN children c ON b.child_id = c.id
        WHERE c.parent_id = $id
    ")
);

/* ================= PENDING BOOKINGS ================= */
$pending_data = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT COUNT(*) AS pending 
        FROM books b
        JOIN children c ON b.child_id = c.id
        WHERE c.parent_id = $id AND b.status = 'pending'
    ")
);

/* ================= TOTAL CHILDREN ================= */
$children_data = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT COUNT(*) AS total_children 
        FROM children 
        WHERE parent_id = $id
    ")
);

/* ================= RECENT BOOKINGS ================= */
$recent_result = mysqli_query($conn, "
    SELECT b.*, s.name AS sitter_name, c.name AS child_name
    FROM books b
    JOIN sitters s ON b.sitter_id = s.id
    JOIN children c ON b.child_id = c.id
    WHERE c.parent_id = $id
    ORDER BY b.start_date DESC, b.start_time DESC
    LIMIT 5
");
?>

<link rel="stylesheet" href="../css/booking.css">

<main class="main-content">

    <!-- PROFILE CARD -->
    <div class="profile-card">
        <div class="left">
            <img src="../uploads/<?= $parent['image'] ?? 'default.png'; ?>" class="avatar">
            <div>
                <h2><?= htmlspecialchars($parent['name']) ?></h2>
                <p><?= htmlspecialchars($parent['email']) ?></p>

                <?php if ($parent['is_verified'] == 1): ?>
                    <span class="badge verified">✔ Verified</span>
                <?php else: ?>
                    <span class="badge not-verified">Not Verified</span>
                <?php endif; ?>

                <span class="badge parent">Parent</span>
            </div>
        </div>

        <div class="stats">
            <div class="stat">
                <h3><?= $booking_data['total_bookings'] ?? 0 ?></h3>
                <p>Total Bookings</p>
            </div>
            <div class="stat">
                <h3><?= $pending_data['pending'] ?? 0 ?></h3>
                <p>Pending</p>
            </div>
            <div class="stat">
                <h3><?= $children_data['total_children'] ?? 0 ?></h3>
                <p>Children</p>
            </div>
        </div>
    </div>

    <!-- RECENT BOOKINGS -->
    <div class="table-container">
        <h3>Recent Bookings</h3>

        <?php if (mysqli_num_rows($recent_result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Sitter</th>
                    <th>Child</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($recent_result)): 

                    $status_text = strtolower(trim($row['status'] ?? 'pending'));
                    if ($status_text == '') {
                        $status_text = 'pending';
                    }

                    $start_datetime = date("d M Y, h:i A", strtotime($row['start_date'].' '.$row['start_time']));
                    $end_datetime   = date("d M Y, h:i A", strtotime($row['end_date'].' '.$row['end_time']));
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['sitter_name']) ?></td>
                    <td><?= htmlspecialchars($row['child_name']) ?></td>
                    <td><?= $start_datetime ?></td>
                    <td><?= $end_datetime ?></td>

                    <td>
                        <span class="status <?= $status_text ?>">
                            <?= ucfirst($status_text) ?>
                        </span>
                    </td>

                    <td>
                        <?php if ($status_text === 'accepted'): ?>
                            <a class="btn review" href="review.php?book_id=<?= $row['id'] ?>">
                                Give Review
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>No bookings yet.</p>
        <?php endif; ?>
    </div>

</main>