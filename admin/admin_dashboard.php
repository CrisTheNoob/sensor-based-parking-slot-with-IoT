<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "parking_system_db"); // Change credentials as needed

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch establishments and their parking slot details
$sql = "SELECT e.id AS establishment_id, 
               e.name AS establishment_name, 
               e.authorized_personnel, 
               e.location, 
               COUNT(p.id) AS total_slots,
               SUM(CASE WHEN p.status = 'available' THEN 1 ELSE 0 END) AS available_slots,
               SUM(CASE WHEN p.status = 'occupied' THEN 1 ELSE 0 END) AS occupied_slots
        FROM establishments e
        LEFT JOIN parking_slots p ON e.id = p.establishments_id
        GROUP BY e.id";
$result = $conn->query($sql);
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
            overflow-y: auto;
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
                <p>Manage registered establishments and parking slots below:</p>

                <div class="row">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['establishment_name']); ?></h5>
                                        <p class="card-text"><strong>Authorized Personnel:</strong> <?php echo htmlspecialchars($row['authorized_personnel']); ?></p>
                                        <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                                        <p class="card-text"><strong>Total Slots:</strong> <?php echo $row['total_slots']; ?></p>
                                        <p class="card-text"><strong>Available Slots:</strong> <?php echo $row['available_slots']; ?></p>
                                        <p class="card-text"><strong>Occupied Slots:</strong> <?php echo $row['occupied_slots']; ?></p>
                                        <a href="slots.php?establishment_id=<?php echo $row['establishment_id']; ?>" class="btn btn-primary">View Slots</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No registered establishments found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
