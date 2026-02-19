<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/babysafe/css/admin/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="#"><i class="fas fa-user-tie"></i> Sitters</a></li>
            <li><a href="#"><i class="fas fa-book"></i> Bookings</a></li>
            <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP NAV -->
        <div class="top-nav">
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class="fas fa-search"></i>
            </div>
            <div class="profile">
                <img src="https://via.placeholder.com/40" alt="Admin">
                <span>Admin</span>
            </div>
        </div>

        <!-- DASHBOARD CARDS -->
        <div class="cards">
            <div class="card">
                <h3>Total Users</h3>
                <p>120</p>
            </div>
            <div class="card">
                <h3>Total Sitters</h3>
                <p>35</p>
            </div>
            <div class="card">
                <h3>Bookings Today</h3>
                <p>10</p>
            </div>
            <div class="card">
                <h3>Revenue</h3>
                <p>$450</p>
            </div>
        </div>

        <!-- DATA TABLE -->
        <div class="table-container">
            <h3>Recent Bookings</h3>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User</th>
                        <th>Sitter</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#001</td>
                        <td>John Doe</td>
                        <td>Jane Smith</td>
                        <td>2026-02-20</td>
                        <td>Completed</td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Mary Jane</td>
                        <td>Emily Rose</td>
                        <td>2026-02-20</td>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <td>#003</td>
                        <td>Robert</td>
                        <td>Anna Bell</td>
                        <td>2026-02-19</td>
                        <td>Cancelled</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

</div>

</body>
</html>
