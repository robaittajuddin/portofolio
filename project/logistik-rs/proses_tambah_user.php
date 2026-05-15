<?php
session_start();
if (!isset($_SESSION["ses_username"]) || $_SESSION["ses_status"] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $departemen = $_POST['departemen'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    $conn = new mysqli("localhost", "root", "", "logistik");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if username or email already exists
    $check_sql = "SELECT * FROM user WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User or email already exists
        $_SESSION['message'] = "Username or Email already exists.";
        $_SESSION['message_type'] = 'danger';
    } else {
        // Insert the new user into the database
        $insert_sql = "INSERT INTO user (username, email, departemen, role, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssss", $username, $email, $departemen, $role, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "User added successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to add user.";
            $_SESSION['message_type'] = 'danger';
        }
    }

    // Close the connection
    $stmt->close();
    $conn->close();

    // Redirect back to the user management page with a message
    header("Location: tambah_user.php");
    exit();
}
?>
