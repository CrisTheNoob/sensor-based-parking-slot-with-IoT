<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../includes/conn.php'; // Database connection

    // Retrieve and sanitize user input
    $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
    $password = trim($_POST['password']);

    // Validate input fields
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../index.php");
        exit();
    }

    // Fetch user data from the database
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, verify password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Successful login, start a secure session
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged_in'] = true;

            // Redirect to dashboard
            header("Location: ../dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
        }
    } else {
        $_SESSION['error'] = "User not found.";
    }

    // Close database connection
    $stmt->close();
    $conn->close();

    // Redirect back to login page with error message
    header("Location: ../index.php");
    exit();
}
?>
