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
$query = "SELECT first_name, last_name, email, profession, company FROM members WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$memberId]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);

// If the user doesn't exist in the database, redirect to login
if (!$member) {
    header('Location: login.php');
    exit();
}

// Update the profile if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $profession = $_POST['profession'];
    $company = $_POST['company'];

    // Update the user in the `members` table
    $updateQuery = "UPDATE members SET first_name = ?, last_name = ?, email = ?, profession = ?, company = ? WHERE id = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->execute([$first_name, $last_name, $email, $profession, $company, $memberId]);

    echo "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            margin-top: 50px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
        }
        .profile-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container profile-container">
        <h2>Edit Profile</h2>
        <form method="POST">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($member['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo htmlspecialchars($member['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($member['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="profession">Profession</label>
                <input type="text" name="profession" id="profession" class="form-control" value="<?php echo htmlspecialchars($member['profession']); ?>" required>
            </div>
            <div class="form-group">
                <label for="company">Company</label>
                <input type="text" name="company" id="company" class="form-control" value="<?php echo htmlspecialchars($member['company']); ?>" required>
            </div>
            <button type="submit" class="btn btn-block">Save Changes</button>
        </form>
    </div>

    <!-- Add Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
