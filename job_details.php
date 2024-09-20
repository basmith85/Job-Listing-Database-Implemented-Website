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

// Fetch job details from the database based on the provided job ID
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $sql = "SELECT jobs.id, jobs.title, companies.location AS job_location, jobs.description, jobs.salary, companies.c_name AS company_name
            FROM jobs
            INNER JOIN companies ON jobs.company_id = companies.id
            WHERE jobs.id = '$job_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        // Job not found, redirect to job listings page
        header("Location: job_listings.php");
        exit();
    }
} else {
    // Job ID not provided, redirect to job listings page
    header("Location: job_listings.php");
    exit();
}

// Handle job application form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply'])) {
    $user_id = $_SESSION['user_id'];
    $application_date = date("Y-m-d H:i:s"); // Current date and time

    // Insert job application into the database
    $sql = "INSERT INTO applicants (job_id, user_id, application_date) VALUES ('$job_id', '$user_id', '$application_date')";
    if ($conn->query($sql) === TRUE) {
        $application_success = true;
    } else {
        $application_error = "Error applying to job: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
</head>
<body>
    <header>
        <h1>Job Details</h1>
        <p><?php echo $welcome_message; ?></p>
    </header>

    <div class="job-details-container">
        <!-- Job details display -->
        <h2><?php echo $job['title']; ?></h2>
        <p><strong>Company:</strong> <?php echo $job['company_name']; ?></p>
        <p><strong>Location:</strong> <?php echo $job['job_location']; ?></p>
        <p><strong>Description:</strong> <?php echo $job['description']; ?></p>
        <p><strong>Salary:</strong> <?php echo $job['salary']; ?></p>

        <!-- Job application form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $job_id; ?>" method="POST">
            <input type="hidden" name="apply" value="apply">
            <input type="submit" value="Apply Now">
        </form>

        <?php
        // Display application success message
        if (isset($application_success) && $application_success) {
            echo "<p>Application submitted successfully!</p>";
        }

        // Display application error message
        if (isset($application_error)) {
            echo "<p>Error: $application_error</p>";
        }
        ?>
    </div>

</body>
</html>
