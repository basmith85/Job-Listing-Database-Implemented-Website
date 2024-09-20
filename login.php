<?php
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if the user is a company or a regular user
    $user_type = $_POST['user_type'];

    if ($user_type === 'company') {
        $sql = "SELECT * FROM companies WHERE c_username = '$username' AND c_password = '$password'";
    } else {
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful, redirect to the appropriate dashboard
        session_start();
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
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login to Your Account</h1>
    <?php
    if (isset($_GET['registered']) && $_GET['registered'] == 1) {
        echo "<p>Registration successful! You can now log in.</p>";
    }
    ?>
    <form action="login_process.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <!-- User type selection -->
        <label for="user_type">Select User Type:</label>
        <select name="user_type" id="user_type">
            <option value="user">Applicant</option>
            <option value="company">Employer</option>
        </select><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
