<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "parking_system_db"); // Change database credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin details
$username = $_SESSION['username'];
$sql = "SELECT * FROM admin WHERE username='$username'";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();

// Handle password update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if (password_verify($current_password, $admin['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_pass_sql = "UPDATE admin SET password='$hashed_password' WHERE username='$username'";
            
            if ($conn->query($update_pass_sql)) {
                echo "<script>alert('Password updated successfully!');</script>";
            } else {
                echo "<script>alert('Error updating password');</script>";
            }
        } else {
            echo "<script>alert('New passwords do not match');</script>";
        }
    } else {
        echo "<script>alert('Incorrect current password');</script>";
    }
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
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
        body {
            background-image: url('../assets/img/bg.jpg');
            background-size: cover;
            background-position: center;
        }
        .wrapper {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: rgba(52, 58, 64, 0.8);
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
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: rgba(52, 58, 64, 0.8);
            color: white;
            padding: 15px;
            text-align: center;
        }
        .content {
            flex: 1;
            padding: 20px;
            background: rgba(248, 249, 250, 0.9);
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <?php include 'header.php'; ?>

        <div class="main-content">
            <div class="header">
                <h3>Admin Dashboard</h3>
            </div>
            <div class="content">
                <h4>Welcome, <?php echo htmlspecialchars($admin['username']); ?>!</h4>

                <!-- Change Password Form -->
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        Change Password
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-success" name="change_password">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
