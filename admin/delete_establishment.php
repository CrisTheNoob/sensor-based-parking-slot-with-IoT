<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "parking_system_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM establishments WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Establishment deleted successfully!'); window.location='establishment.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to delete establishment.'); window.location='establishment.php';</script>";
    }
    
    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location='admin_dashboard.php';</script>";
}

// Close connection
$conn->close();
?>
