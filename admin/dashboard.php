<?php
session_start();
require_once('../config/connection.php');

// ---------------- PAGE SETUP ----------------
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// ---------------- DASHBOARD DATA ----------------

// --- Parents Stats ---
$total_parents    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM parents"))['total'];
$verified_parents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM parents WHERE is_verified=1"))['total'];
$blocked_parents  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM parents WHERE is_verified=0"))['total'];
$new_parents      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM parents WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)"))['total'];

// --- Sitters Stats ---
$total_sitters    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM sitters"))['total'];
$verified_sitters = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM sitters WHERE is_verified=1"))['total'];
$blocked_sitters  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM sitters WHERE status=0"))['total'];
$new_sitters      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM sitters WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)"))['total'];

// --- Bookings Stats ---
$pending_bookings   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM books WHERE status=2"))['total'];
$completed_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM books WHERE status=1"))['total'];
$cancelled_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM books WHERE status=0"))['total'];

// --- Revenue ---
$revenue = $completed_bookings * 1000; // Rs 1000 per completed booking

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/Babysafe/css/admin/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="dashboard">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h2>Admin Panel</h2>
        </div>

        <ul class="sidebar-menu">
            <li><a href="dashboard.php?page=dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="dashboard.php?page=parents"><i class="fas fa-users"></i> Parents</a></li>
            <li><a href="dashboard.php?page=sitters"><i class="fas fa-user-tie"></i> Sitters</a></li>
            <li><a href="dashboard.php?page=bookings"><i class="fas fa-book"></i> Bookings</a></li>
        </ul>
    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="main-content">

        <!-- ---------------- DASHBOARD CARDS ---------------- -->
        <?php if($page == 'dashboard'): ?>
            <div class="cards">

                <!-- Parents -->
                <div class="card"><h3>Total Parents</h3><p><?php echo $total_parents; ?></p></div>
                <div class="card"><h3>Verified Parents</h3><p><?php echo $verified_parents; ?></p></div>
                <div class="card"><h3>New Parents</h3><p><?php echo $new_parents; ?></p></div>
                <div class="card"><h3>Blocked Parents</h3><p><?php echo $blocked_parents; ?></p></div>

                <!-- Sitters -->
                <div class="card"><h3>Total Sitters</h3><p><?php echo $total_sitters; ?></p></div>
                <div class="card"><h3>Verified Sitters</h3><p><?php echo $verified_sitters; ?></p></div>
                <div class="card"><h3>New Sitters</h3><p><?php echo $new_sitters; ?></p></div>
                <div class="card"><h3>Blocked Sitters</h3><p><?php echo $blocked_sitters; ?></p></div>

                <!-- Bookings -->
                <div class="card"><h3>Pending Bookings</h3><p><?php echo $pending_bookings; ?></p></div>
                <div class="card"><h3>Completed Bookings</h3><p><?php echo $completed_bookings; ?></p></div>
                <div class="card"><h3>Cancelled Bookings</h3><p><?php echo $cancelled_bookings; ?></p></div>

                <!-- Revenue -->
                <div class="card"><h3>Revenue</h3><p>Rs <?php echo $revenue; ?></p></div>

            </div>
        <?php endif; ?>


        <!-- ---------------- PARENTS TABLE ---------------- -->
        <?php if($page == 'parents'): 
            $parents = mysqli_query($conn, "SELECT * FROM parents ORDER BY created_at DESC");
        ?>
        <div class="table-container">
            <h3>All Parents</h3>
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Verified</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sn=1; while($row = mysqli_fetch_assoc($parents)): ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['is_verified'] ? 'Yes' : 'No'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>


        <!-- ---------------- SITTERS TABLE ---------------- -->
        <?php if($page == 'sitters'): 
            $sitters = mysqli_query($conn, "SELECT * FROM sitters ORDER BY created_at DESC");
        ?>
        <div class="table-container">
            <h3>All Sitters</h3>
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Available</th>
                        <th>Verified</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sn=1; while($row = mysqli_fetch_assoc($sitters)): ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['is_available'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $row['is_verified'] ? 'Yes' : 'No'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>


        <!-- ---------------- BOOKINGS TABLE ---------------- -->
        <?php if($page == 'bookings'): 
            $bookings = mysqli_query($conn, "
                SELECT books.*, parents.name AS parent_name, sitters.name AS sitter_name
                FROM books
                JOIN children ON books.child_id = children.id
                JOIN parents ON children.parent_id = parents.id
                JOIN sitters ON books.sitter_id = sitters.id
                ORDER BY books.created_at DESC
            ");
        ?>
        <div class="table-container">
            <h3>All Bookings</h3>
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Parent</th>
                        <th>Sitter</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sn=1; while($row = mysqli_fetch_assoc($bookings)): ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['parent_name']; ?></td>
                            <td><?php echo $row['sitter_name']; ?></td>
                            <td><?php echo date("Y-m-d", strtotime($row['start_date'])); ?></td>
                            <td>
                                <?php
                                    echo $row['status'] == 0 ? "Cancelled" : 
                                         ($row['status'] == 1 ? "Completed" : "Pending");
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

    </main>
</div>

</body>
</html>