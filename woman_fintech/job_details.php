<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$jobId = isset($_GET['id']) ? $_GET['id'] : null;

if ($jobId === null) {
    die("Job ID is missing.");
}

$query = "SELECT * FROM jobs WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$jobId]);

$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    die("Job not found.");
}
?>

<h2><?php echo htmlspecialchars($job['title']); ?></h2>
<p><?php echo htmlspecialchars($job['description']); ?></p>
<p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
<p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>

<form method="POST">
    <textarea name="cover_letter" placeholder="Write your cover letter..." required></textarea>
    <button type="submit" class="btn btn-success">Apply Now</button>
</form>
