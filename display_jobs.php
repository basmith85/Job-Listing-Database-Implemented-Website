<?php include('db_config.php');

$sql = "SELECT * FROM jobs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Available Jobs</h1>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['title']} - {$row['description']} - Salary: {$row['salary']}</li>";
    }
    echo "</ul>";
} else {
    echo "No jobs available";
}

$conn->close();
?>
