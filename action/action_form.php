<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../includes/conn.php'; // Database connection

    // Retrieve and sanitize form data
    $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $re_password = trim($_POST['re_password']);

    // Validate inputs
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[!@#$%^&*]/", $password)) {
        $errors[] = "Password must be at least 8 characters long and include at least one number and one special character.";
    }

    if ($password !== $re_password) {
        $errors[] = "Passwords do not match.";
    }

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

    // If no errors, proceed with registration
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: success.php");
            exit();
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }

    $conn->close();
}
?>
