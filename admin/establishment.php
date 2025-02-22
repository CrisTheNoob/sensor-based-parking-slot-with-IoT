<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

// Database connection (Ensure this is before using $conn)
$conn = new mysqli("localhost", "root", "", "parking_system_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $slots = intval($_POST['slots']);
    $authorized_personnel = $_POST['authorized_personnel'];

    // Prepare and execute insertion for establishments
    $stmt = $conn->prepare("INSERT INTO establishments (name, location, authorized_personnel) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $location, $authorized_personnel);
    
    if ($stmt->execute()) {  // Execute only once
        $establishment_id = $stmt->insert_id;

        // Insert parking slots
        for ($i = 1; $i <= $slots; $i++) {
            $slot_name = "Slot " . $i;
            $conn->query("INSERT INTO parking_slots (establishments_id, slot_name) VALUES ($establishment_id, '$slot_name')");
        }

        echo "<script>alert('Establishment registered successfully!'); window.location='establishment.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to register establishment.');</script>";
    }

    $stmt->close();
}


// Close connection at the end
$conn->close();
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
            overflow-y: auto;
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
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-action {
            margin-right: 5px;
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
                <h4>Registered Establishments</h4>

                <!-- Add Establishment Button -->
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addEstablishmentModal">
                    + Register Establishment
                </button>

                <!-- Table -->
                <div class="table-container">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Establishment</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "parking_system_db");

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT id, name, location FROM establishments";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$row['name']}</td>
                                        <td>{$row['location']}</td>
                                        <td>
                                            <a href='edit_establishment.php?id={$row['id']}' class='btn btn-primary btn-sm btn-action'>Edit</a>
                                            <a href='delete_establishment.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No establishments found</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Establishment Modal -->
    <div class="modal fade" id="addEstablishmentModal" tabindex="-1" aria-labelledby="addEstablishmentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEstablishmentLabel">Register New Establishment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Establishment Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Authorized Personnel</label>
                            <input type="text" class="form-control" name="authorized_personnel" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Number of Parking Slots</label>
                            <input type="number" class="form-control" name="slots" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location :</label>
                            <input type="text" class="form-control" name="location" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
