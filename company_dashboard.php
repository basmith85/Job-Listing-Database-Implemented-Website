<?php
session_start();

include('db_config.php');

if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch and display the company name
$company_id = $_SESSION['company_id'];
$sql_company = "SELECT c_name FROM companies WHERE id = '$company_id'";
$result_company = $conn->query($sql_company);
if ($result_company->num_rows > 0) {
    $row_company = $result_company->fetch_assoc();
    $company_name = $row_company['c_name'];
} else {
    $company_name = "Unknown";
}

// Initialize variables
$title = $description = $salary = '';
$error = '';

// Handle form submission to create a new job listing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];

    // Validate form data (you can add more validation if needed)
    if (empty($title) || empty($description) || empty($salary)) {
        $error = "Please fill in all fields.";
    } else {
        // Insert new job listing into the database
        $sql = "INSERT INTO jobs (title, description, salary, company_id) VALUES ('$title', '$description', '$salary', '$company_id')";
        if ($conn->query($sql) === TRUE) {
            // Job creation successful, redirect to company_dashboard.php to refresh the page
            header("Location: company_dashboard.php");
            exit();
        } else {
            $error = "Error creating job listing: " . $conn->error;
        }
    }
}

// Fetch and display current job listings for the company
$sql_jobs = "SELECT * FROM jobs WHERE company_id = '$company_id'";
$result_jobs = $conn->query($sql_jobs);
$job_listings = [];
if ($result_jobs->num_rows > 0) {
    while ($row_job = $result_jobs->fetch_assoc()) {
        $job_listings[] = $row_job;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }

        .button-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .button-container button {
            margin-left: 10px;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .job-tile {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
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

    <h1>Welcome, <?php echo $company_name; ?>!</h1>

    <h2>Create Job Listing</h2>
    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="title">Job Title:</label>
            <input type="text" name="title" id="title" required value="<?php echo htmlspecialchars($title); ?>">

            <label for="description">Job Description:</label>
            <textarea name="description" id="description" rows="5" required><?php echo htmlspecialchars($description); ?></textarea>

            <label for="salary">Salary:</label>
            <input type="text" name="salary" id="salary" required value="<?php echo htmlspecialchars($salary); ?>">

            <input type="submit" value="Create Job Listing">
        </form>
        <?php if ($error) : ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

    <h2>Current Job Listings</h2>
    <?php if (!empty($job_listings)) : ?>
        <?php foreach ($job_listings as $job) : ?>
            <div class="job-tile">
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
                <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                <p><a href="job_applicants.php?id=<?php echo $job['id']; ?>">View Applicants</a></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No job listings available.</p>
    <?php endif; ?>
</body>
</html>
