<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Full height layout */
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
        body {
            background-image: url('../assets/img/bg.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
        }
        .wrapper {
            display: flex;
            height: 100vh;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(52, 58, 64, 0.8); /* Semi-transparent sidebar */
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background: #495057;
        }
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: rgba(52, 58, 64, 0.8); /* Semi-transparent header */
            color: white;
            padding: 15px;
            text-align: center;
        }
        .content {
            flex: 1;
            padding: 20px;
            background: rgba(248, 249, 250, 0.9); /* Light background for content */
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h3>Admin Dashboard</h3>
            </div>
            <div class="content">
                <h4>Welcome, Admin!</h4>
                <p>This is your admin panel where you can manage users, view reports, and configure settings.</p>
            </div>
        </div>
    </div>

</body>
</html>
