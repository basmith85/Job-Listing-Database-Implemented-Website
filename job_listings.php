<?php
session_start();

include('db_config.php');

// Check if the user is logged in and the firstname session variable is set
if (isset($_SESSION['user_id']) && isset($_SESSION['firstname'])) {
    $firstname = $_SESSION['firstname'];
    $welcome_message = "Welcome, $firstname! Let's build a better tomorrow by finding you the perfect job.";
} else {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Initialize filter variables
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Fetch job listings from the database with filters
$sql = "SELECT jobs.id, jobs.title, companies.location AS job_location, jobs.salary, companies.c_name AS company_name
        FROM jobs
        INNER JOIN companies ON jobs.company_id = companies.id";

// Add filters if they are provided
if (!empty($keyword) || !empty($location)) {
    $sql .= " WHERE 1=1"; // Placeholder condition to append filters
    
    if (!empty($keyword)) {
        $sql .= " AND jobs.title LIKE '%$keyword%'"; // Add keyword filter
    }
    if (!empty($location)) {
        $sql .= " AND companies.location LIKE '%$location%'"; // Add location filter
    }
}

$result = $conn->query($sql);
$job_listings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $job_listings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <style>
        .job-tile {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .button-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .button-container button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <!-- Logout Button -->
        <form action="logout.php" method="POST">
            <input type="submit" value="Logout">
        </form>
        <!-- Account Info Button -->
        <a href="account_info.php"><button>Account Info</button></a>
    </div>
    <h1>Job Listings</h1>
    <p><?php echo $welcome_message; ?></p>
    
    <!-- Filter Form -->
    <form action="job_listings.php" method="GET">
        <label for="keyword">Keyword:</label>
        <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>">

        <label for="location">Location:</label>
        <input type="text" name="location" id="location" value="<?php echo $location; ?>">

        <input type="submit" value="Apply Filters">
    </form>

    <?php
    if (!empty($job_listings)) {
        foreach ($job_listings as $job) {
            echo "<div class='job-tile'>";
            echo "<h2><a href='job_details.php?id={$job['id']}'>{$job['title']}</a></h2>";
            echo "<p><strong>Company:</strong> {$job['company_name']}</p>";
            echo "<p><strong>Location:</strong> {$job['job_location']}</p>";
            echo "<p><strong>Salary:</strong> {$job['salary']}</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No job listings available.</p>";
    }
    ?>
</body>
</html>
