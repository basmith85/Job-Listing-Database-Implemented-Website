<?php include('db_config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listing Company</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-container a:hover {
            background-color: #0056b3;
        }

        .company-info {
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Job Expedition</h1>
        <nav>
            <a href="login.php">Login</a> | <a href="register.php">Register</a>
        </nav>
    </header>

    <main>
        <div class="company-info">
            <h2>About Us</h2>
            <p><strong>About:</strong> Job Expedition is dedicated to connecting talented individuals with top companies.</p>
            <p style="text-align: center;"><strong>Ready to find your future job?</strong></p>
        </div>

        <div class="btn-container">
            <a href="register.php">Get Started</a>
        </div>
    </main>

    <?php $conn->close(); ?>
</body>
</html>
