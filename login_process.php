<?php
session_start(); 

include('db_config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    if ($user_type === 'company') {
        $sql = "SELECT * FROM companies WHERE c_username = '$username' AND c_password = '$password'";
    } else {
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];

        if ($user_type === 'company') {
            $_SESSION['company_id'] = $row['id']; // Assuming 'id' is the company's ID in the companies table
            header("Location: company_dashboard.php");
        } else {
            $_SESSION['firstname'] = $row['firstname'];
            header("Location: job_listings.php");
        }
        exit();
    } else {
        // Login failed, redirect back to the login page with an error message
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: login.php");
        exit();
    }
}
?>
