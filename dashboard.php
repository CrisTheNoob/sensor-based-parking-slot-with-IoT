<?php
session_start();
require 'includes/conn.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['error'] = "You must log in first!";
    header("Location: index.php");
    exit();
}

// Fetch establishments
$establishmentsQuery = "SELECT * FROM establishments";
$establishmentsResult = $conn->query($establishmentsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parking Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-image: url('assets/img/bg.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: rgba(0, 123, 255, 0.8);
            color: white;
            padding: 15px;
            text-align: center;
        }
        .container {
            padding: 30px 15px;
            flex-grow: 1;
        }
        .card {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
            color: black;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: rgba(0, 123, 255, 0.8);
            color: white;
            border-radius: 12px 12px 0 0;
            font-size: 18px;
        }
        .status-badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
        }
        .available {
            background: #28a745;
            color: white;
        }
        .occupied {
            background: #dc3545;
            color: white;
        }
        .icon {
            font-size: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h2><i class="fas fa-parking"></i> Parking Availability</h2>
    </div>

    <div class="container">
        <div class="row">
            <?php while ($establishment = $establishmentsResult->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow p-3">
                        <div class="card-header">
                            <i class="fas fa-building icon"></i> <?= htmlspecialchars($establishment['name']); ?>
                        </div>
                        <div class="card-body">
                            <p><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> <?= htmlspecialchars($establishment['location']); ?></p>

                            <!-- Fetch Parking Slots for Each Establishment -->
                            <?php
                            $establishment_id = $establishment['id'];
                            $parkingQuery = "SELECT * FROM parking_slots WHERE establishments_id = $establishment_id";
                            $parkingResult = $conn->query($parkingQuery);
                            ?>

                            <h6><i class="fas fa-car"></i> Parking Slots:</h6>
                            <ul class="list-group">
                                <?php while ($slot = $parkingResult->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= htmlspecialchars($slot['slot_name']); ?>
                                        <span class="status-badge <?= ($slot['status'] == 'Available') ? 'available' : 'occupied'; ?>">
                                            <?= htmlspecialchars($slot['status']); ?>
                                        </span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>
