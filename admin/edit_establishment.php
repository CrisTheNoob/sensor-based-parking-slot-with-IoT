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

// Get establishment details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT name, authorized_personnel, location FROM establishments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $establishment = $result->fetch_assoc();
    $stmt->close();

    if (!$establishment) {
        echo "<script>alert('Establishment not found!'); window.location='establishment.php';</script>";
        exit();
    }
} else {
    header("Location: establishment.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $authorized_personnel = $conn->real_escape_string($_POST['authorized_personnel']);
    $location = $conn->real_escape_string($_POST['location']);

    $stmt = $conn->prepare("UPDATE establishments SET name = ?, authorized_personnel = ?, location = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $authorized_personnel, $location, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Establishment updated successfully!'); window.location='establishment.php';</script>";
    } else {
        echo "<script>alert('Error updating establishment.');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Establishment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Edit Establishment</div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Establishment Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($establishment['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Authorized Personnel</label>
                                <input type="text" class="form-control" name="authorized_personnel" value="<?php echo htmlspecialchars($establishment['authorized_personnel']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" value="<?php echo $establishment['location']; ?>" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="establishment.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
