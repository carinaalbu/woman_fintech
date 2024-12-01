<?php
session_start();
include_once "config/database.php";
include_once "includes/header.php";


// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You must be an admin to add a job.");
}

// Get the form data
$title = $_POST['title'];
$description = $_POST['description'];
$company = $_POST['company'];
$location = $_POST['location'];
$category = $_POST['category'];
$experience_level = $_POST['experience_level'];

// Create a database connection
$database = new Database();
$db = $database->getConnection();

// Insert the job into the jobs table
$query = "INSERT INTO jobs (title, description, company, location, category, experience_level) 
          VALUES (:title, :description, :company, :location, :category, :experience_level)";

$stmt = $db->prepare($query);

// Bind the parameters to the query
$stmt->bindParam(':title', $title);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':company', $company);
$stmt->bindParam(':location', $location);
$stmt->bindParam(':category', $category);
$stmt->bindParam(':experience_level', $experience_level);

// Execute the query
if ($stmt->execute()) {
    echo "Job added successfully! <a href='add_job.php'>Add another job</a>";
} else {
    echo "There was an error adding the job. Please try again.";
}
?>
