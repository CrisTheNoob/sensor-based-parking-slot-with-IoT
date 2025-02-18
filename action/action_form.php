<?php
session_start();
include '../includes/conn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $re_password = trim($_POST['re_password']);

    $errors = [];

    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate password strength
    if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[!@#$%^&*]/", $password)) {
        $errors[] = "Password must be at least 8 characters long and include at least one number and one special character.";
    }

    // Check if passwords match
    if ($password !== $re_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Check if username or email already exists
        $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $errors[] = "Username or Email already exists.";
        }
        $check_stmt->close();
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header("Location: ../index.php");
            exit();
        } else {
            $errors[] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Store errors in session and redirect
    $_SESSION['errors'] = $errors;
    header("Location: ../create_account.php");
    exit();
}
?>
