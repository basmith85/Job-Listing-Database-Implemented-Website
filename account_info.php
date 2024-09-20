<?php
session_start();

// Include the database configuration file
include('db_config.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Query to fetch user information from the database based on the user ID
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    // Check for errors in the query
    if (!$result) {
        echo "Error: " . $conn->error;
    } else {
        // Check if user information is found
        if ($result->num_rows > 0) {
            // User information found, display it
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $phone = $row['phone'];

            // Display user information
            echo "<h1>Account Information</h1>";
            echo "<p><strong>Username:</strong> $username</p>";
            echo "<p><strong>Name:</strong> $firstname $lastname</p>";
            echo "<p><strong>Phone:</strong> $phone</p>";
        } else {
            // No user information found
            echo "<p>No user information available.</p>";
        }
    }
} else {
    // User ID not set in session
    echo "<p>User ID not set.</p>";
}
?>
