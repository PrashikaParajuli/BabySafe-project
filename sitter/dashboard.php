<?php
require '../config/connection.php';
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] !== 'sitter'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}
require('../includes/sitter_panel.php');
$id = $_SESSION['id'];

/* SITTER INFO */
$sitter = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM sitters WHERE id = $id")
);

/* TOTAL BOOKINGS */
$booking_data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total_bookings FROM books WHERE sitter_id = $id")
);

/* PENDING BOOKINGS */
$pending_data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS pending FROM books WHERE sitter_id = $id AND status = 'pending'")
);

/* AVERAGE RATING */
$rating_data = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT AVG(r.rating) AS avg_rating
        FROM reviews r
        JOIN books b ON r.booked_id = b.id
        WHERE b.sitter_id = $id
    ")
);
$average_rating = round($rating_data['avg_rating'],1);

/* UPCOMING BOOKINGS */
$upcoming_result = mysqli_query($conn, "
    SELECT b.*, c.name AS child_name, p.name AS parent_name
    FROM books b
    JOIN children c ON b.child_id = c.id
    JOIN parents p ON c.parent_id = p.id
    WHERE b.sitter_id = $id
    ORDER BY b.start_date ASC
    LIMIT 5
");
?>
    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- PROFILE CARD -->
        <div class="profile-card">
            <div class="left">
                <img src="../uploads/<?php echo $sitter['image'] ?? 'default.png'; ?>" class="avatar">
                <div>
                    <h2><?php echo $sitter['name']; ?></h2>
                    <p><?php echo $sitter['email']; ?></p>
                    <?php if($sitter['is_verified'] == 1){ ?>
                        <span class="badge verified">✔ Verified</span>
                    <?php } else { ?>
                        <span class="badge not-verified">Not Verified</span>
                    <?php } ?>
                    <span class="badge sitter"> Sitter</span>
                </div>
            </div>

            <div class="stats">
                <div class="stat">
                    <h3><?php echo $booking_data['total_bookings']; ?></h3>
                    <p>Total Bookings</p>
                </div>
                <div class="stat">
                    <h3><?php echo $pending_data['pending']; ?></h3>
                    <p>Pending</p>
                </div>
                <div class="stat">
                    <h3><?php echo $average_rating ?: 0; ?></h3>
                    <p>Rating</p>
                </div>
            </div>
        </div>

        <!-- UPCOMING BOOKINGS -->
        <div class="table-container">
            <h3>Upcoming Bookings</h3>

            <table>
                <tr>
                    <th>Parent</th>
                    <th>Child</th>
                    <th>Start Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php while($row = mysqli_fetch_assoc($upcoming_result)) { 
                    $status = strtolower($row['status'] ?? 'pending'); // ENUM value
                    $status_class = [
                        'pending'=>'pending',
                        'accepted'=>'accepted',
                        'rejected'=>'rejected'
                    ][$status] ?? 'pending';
                ?>
                <tr>
                    <td><?php echo $status==='accepted' ? htmlspecialchars($row['parent_name']) : '-'; ?></td>
                    <td><?php echo $status==='accepted' ? htmlspecialchars($row['child_name']) : '-'; ?></td>
                    <td><?php echo date("d M Y", strtotime($row['start_date'])); ?></td>
                    <td>
                        <span class="status <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span>
                    </td>
                    <td>
                        <?php if($status==='pending'){ ?>
                            <a class="btn accept" href="update_booking.php?id=<?php echo $row['id']; ?>&status=accepted">Accept</a>
                            <a class="btn reject" href="update_booking.php?id=<?php echo $row['id']; ?>&status=rejected">Reject</a>
                        <?php } else { echo '-'; } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>

    </main>

</div>

</body>
</html>