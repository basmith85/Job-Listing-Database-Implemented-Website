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

// Fetch job details from the database based on the provided job ID
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $sql_job = "SELECT jobs.id, jobs.title FROM jobs WHERE jobs.id = '$job_id'";
    $result_job = $conn->query($sql_job);
    if ($result_job->num_rows > 0) {
        $row_job = $result_job->fetch_assoc();
        $job_title = $row_job['title'];
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

// Fetch applicants for the specified job
$sql_applicants = "SELECT applicants.application_date, users.firstname, users.lastname, users.phone
                   FROM applicants
                   INNER JOIN users ON applicants.user_id = users.id
                   WHERE applicants.job_id = '$job_id'";
$result_applicants = $conn->query($sql_applicants);
$applicant_list = [];
if ($result_applicants->num_rows > 0) {
    while ($row_applicant = $result_applicants->fetch_assoc()) {
        $applicant_list[] = $row_applicant;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applicants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            margin-bottom: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .back-btn {
            margin-bottom: 20px;
        }

        .back-btn a {
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .back-btn a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Job Applicants for <?php echo $job_title; ?></h1>
        <p>Company: <?php echo $company_name; ?></p>
    </header>

    <div class="container">
        <!-- Back to dashboard button -->
        <div class="back-btn">
            <a href="company_dashboard.php">Back to Dashboard</a>
        </div>

        <!-- Applicant list -->
        <?php if (!empty($applicant_list)) : ?>
            <table border="1">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Application Date</th>
                </tr>
                <?php foreach ($applicant_list as $applicant) : ?>
                    <tr>
                        <td><?php echo $applicant['firstname']; ?></td>
                        <td><?php echo $applicant['lastname']; ?></td>
                        <td><?php echo $applicant['phone']; ?></td>
                        <td><?php echo $applicant['application_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No applicants found for this job.</p>
        <?php endif; ?>
    </div>
</body>
</html>