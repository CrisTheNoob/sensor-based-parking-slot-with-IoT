<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "parking_system_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an establishment_id is provided
if (!isset($_GET['establishment_id'])) {
    die("Invalid request.");
}

$establishment_id = intval($_GET['establishment_id']);

// Fetch establishment details
$establishment_sql = "SELECT name FROM establishments WHERE id = ?";
$stmt = $conn->prepare($establishment_sql);
$stmt->bind_param("i", $establishment_id);
$stmt->execute();
$establishment_result = $stmt->get_result();
$establishment = $establishment_result->fetch_assoc();

if (!$establishment) {
    die("Establishment not found.");
}

// Fetch parking slots for the establishment
$slots_sql = "SELECT slot_name, status FROM parking_slots WHERE establishments_id = ?";
$stmt = $conn->prepare($slots_sql);
$stmt->bind_param("i", $establishment_id);
$stmt->execute();
$slots_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Slots</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>Parking Slots for <?php echo htmlspecialchars($establishment['name']); ?></h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Slot Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($slots_result->num_rows > 0): ?>
                    <?php while ($slot = $slots_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($slot['slot_name']); ?></td>
                            <td>
                                <span class="badge <?php echo $slot['status'] == 'available' ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo htmlspecialchars($slot['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No parking slots found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
