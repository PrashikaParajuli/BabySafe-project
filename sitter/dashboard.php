<?php
require '../config/connection.php';
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] !== 'sitter'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

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
    mysqli_query($conn, "SELECT COUNT(*) AS pending FROM books WHERE sitter_id = $id AND status = 2")
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

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sitter Dashboard</title>

    <!-- SITTER DASHBOARD CSS -->
    <link rel="stylesheet" href="/Babysafe/css/users/dashboard.css">

    <!-- FONT AWESOME ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h2>Sitter Panel</h2>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="#">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-calendar-check"></i> My Bookings
                </a>
            </li>

            <li>
                <a href="../auth/is_auth/sitters/personal.php">
                    <i class="fas fa-user-check"></i> Verification
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </li>

            <li>
                <a href="../auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

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

                <?php while($row = mysqli_fetch_assoc($upcoming_result)) { ?>
                <tr>
                    <td><?php echo $row['parent_name']; ?></td>
                    <td><?php echo $row['child_name']; ?></td>
                    <td><?php echo date("d M Y", strtotime($row['start_date'])); ?></td>
                    <td>
                        <?php
                        if($row['status'] == 2){
                            echo "<span class='status pending'>Pending</span>";
                        }elseif($row['status'] == 1){
                            echo "<span class='status accepted'>Accepted</span>";
                        }else{
                            echo "<span class='status rejected'>Rejected</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($row['status'] == 2){ ?>
                            <a class="btn accept" href="update_booking.php?id=<?php echo $row['id']; ?>&status=1">Accept</a>
                            <a class="btn reject" href="update_booking.php?id=<?php echo $row['id']; ?>&status=0">Reject</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>

    </main>

</div>

</body>
</html>
