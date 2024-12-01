<?php
include_once "includes/header.php";

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. You must be an admin to view this page.");
}
?>

<h2>Add New Job</h2>
<form method="POST" action="save_job.php">
    <input type="text" name="title" placeholder="Job Title" required>
    <textarea name="description" placeholder="Job Description" required></textarea>
    <input type="text" name="company" placeholder="Company Name" required>
    <input type="text" name="location" placeholder="Location">
    
    <select name="category" required>
        <option value="IT">IT</option>
        <option value="Marketing">Marketing</option>
        <option value="Finance">Finance</option>
    </select>

    <select name="experience_level" required>
        <option value="Entry">Entry</option>
        <option value="Mid">Mid</option>
        <option value="Senior">Senior</option>
    </select>

    <button type="submit">Add Job</button>
</form>
