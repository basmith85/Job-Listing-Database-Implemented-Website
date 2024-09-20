<?php
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];

    if ($userType === 'user') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];

        // Insert user data into the database for applicants
        $sql = "INSERT INTO users (username, password, firstname, lastname, phone) VALUES ('$username', '$password', '$firstname', '$lastname', '$phone')";
    } else if ($userType === 'company') {
        $companyName = $_POST['c_name'];
        $location = $_POST['location'];
        $industry = $_POST['industry'];

        // Insert user data into the database for companies
        $sql = "INSERT INTO companies (c_username, c_password, c_name, location, industry) VALUES ('$username', '$password', '$companyName', '$location', '$industry')";
    }

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: login.php?registered=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
