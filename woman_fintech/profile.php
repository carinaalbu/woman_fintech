<?php
session_start();
include_once "config/database.php";
include_once "includes/header.php";


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Get the logged-in user's details from the `members` table
$memberId = $_SESSION['user_id'];
$query = "SELECT first_name, last_name, email, profession, company, role FROM members WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$memberId]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);

// If the user doesn't exist in the database, redirect to login
if (!$member) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Optional CSS link -->
</head>
<body>
    <div class="profile-container">
        <h2>User Profile</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($member['first_name']) . ' ' . htmlspecialchars($member['last_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($member['email']); ?></p>
        <p><strong>Profession:</strong> <?php echo htmlspecialchars($member['profession']); ?></p>
        <p><strong>Company:</strong> <?php echo htmlspecialchars($member['company']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($member['role']); ?></p>

        <!-- Optionally allow the user to edit their profile -->
        <a href="edit_profile.php" class="btn">Edit Profile</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
