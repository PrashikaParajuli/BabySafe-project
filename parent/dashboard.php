<?php
session_start();
require '../config/connection.php';

if(!isset($_SESSION['id']) || $_SESSION['role'] !== 'parent'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

require('../includes/parent_panel.php');
$id = $_SESSION['id'];

/* PARENT INFO */
$parent = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM parents WHERE id = $id")
);

/* TOTAL BOOKINGS */
$booking_data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total_bookings 
                         FROM books b
                         JOIN children c ON b.child_id = c.id
                         WHERE c.parent_id = $id")
);

/* PENDING BOOKINGS */
$pending_data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS pending 
                         FROM books b
                         JOIN children c ON b.child_id = c.id
                         WHERE c.parent_id = $id AND b.status = 2")
);

/* TOTAL CHILDREN */
$children_data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total_children 
                         FROM children WHERE parent_id = $id")
);

/* RECENT BOOKINGS */
$recent_result = mysqli_query($conn, "
    SELECT b.*, s.name AS sitter_name, c.name AS child_name
    FROM books b
    JOIN sitters s ON b.sitter_id = s.id
    JOIN children c ON b.child_id = c.id
    WHERE c.parent_id = $id
    ORDER BY b.start_date DESC
    LIMIT 5
");
?>

<!-- MAIN CONTENT -->
<main class="main-content">

    <!-- PROFILE CARD -->
    <div class="profile-card">
        <div class="left">
            <img src="../uploads/<?php echo $parent['image'] ?? 'default.png'; ?>" class="avatar">
            <div>
                <h2><?php echo $parent['name']; ?></h2>
                <p><?php echo $parent['email']; ?></p>

                <?php if($parent['is_verified'] == 1){ ?>
                    <span class="badge verified">✔ Verified</span>
                <?php } else { ?>
                    <span class="badge not-verified">Not Verified</span>
                <?php } ?>

                <span class="badge parent">Parent</span>
            </div>
        </div>

        <div class="stats">
            <div class="stat">
                <h3><?= $booking_data['total_bookings']; ?></h3>
                <p>Total Bookings</p>
            </div>
            <div class="stat">
                <h3><?= $pending_data['pending']; ?></h3>
                <p>Pending</p>
            </div>
            <div class="stat">
                <h3><?= $children_data['total_children']; ?></h3>
                <p>Children</p>
            </div>
        </div>
    </div>

    <!-- RECENT BOOKINGS -->
    <div class="table-container">
        <h3>Recent Bookings</h3>

        <table>
            <tr>
                <th>Sitter</th>
                <th>Child</th>
                <th>Start Date</th>
                <th>Status</th>
                <th>Review</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($recent_result)) { ?>
            <tr>
                <td><?= $row['sitter_name']; ?></td>
                <td><?= $row['child_name']; ?></td>
                <td><?= date("d M Y", strtotime($row['start_date'])); ?></td>
                <td>
                    <?php
                        if($row['status'] == 2)
                            echo "<span class='status pending'>Pending</span>";
                        elseif($row['status'] == 1)
                            echo "<span class='status accepted'>Accepted</span>";
                        else
                            echo "<span class='status rejected'>Rejected</span>";
                    ?>
                </td>
                <td>
                    <?php if($row['status'] == 1){ ?>
                        <a class="btn review" href="review.php?book_id=<?= $row['id']; ?>">
                            Review
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</main>

</div> <!-- dashboard -->

</body>
</html>