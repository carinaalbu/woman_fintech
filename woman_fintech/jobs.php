<?php
include_once "config/database.php";
include_once "includes/header.php";
$database = new Database();
$db = $database->getConnection();

$filterCategory = isset($_GET['category']) ? $_GET['category'] : '';
$filterExperience = isset($_GET['experience_level']) ? $_GET['experience_level'] : '';

// Construire interogare dinamică pentru filtrare
$query = "SELECT * FROM jobs WHERE 1";
$params = [];

if (!empty($filterCategory)) {
    $query .= " AND category = ?";
    $params[] = $filterCategory;
}
if (!empty($filterExperience)) {
    $query .= " AND experience_level = ?";
    $params[] = $filterExperience;
}

$query .= " ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Jobs Board</h2>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="add_job.php" class="btn btn-success">Add New Job</a>
<?php endif; ?>
<!-- Formular pentru filtrare -->
<form method="GET" class="form-inline">
    <select name="category" class="form-control mr-sm-2">
        <option value="">All Categories</option>
        <option value="IT" <?php if ($filterCategory === 'IT') echo 'selected'; ?>>IT</option>
        <option value="Marketing" <?php if ($filterCategory === 'Marketing') echo 'selected'; ?>>Marketing</option>
        <option value="Finance" <?php if ($filterCategory === 'Finance') echo 'selected'; ?>>Finance</option>
    </select>

    <select name="experience_level" class="form-control mr-sm-2">
        <option value="">All Experience Levels</option>
        <option value="Entry" <?php if ($filterExperience === 'Entry') echo 'selected'; ?>>Entry</option>
        <option value="Mid" <?php if ($filterExperience === 'Mid') echo 'selected'; ?>>Mid</option>
        <option value="Senior" <?php if ($filterExperience === 'Senior') echo 'selected'; ?>>Senior</option>
    </select>

    <button type="submit" class="btn btn-primary">Filter</button>
</form>
<a href="add_job.php" class="btn btn-success">Add New Job</a>

<!-- Listare joburi -->
<div class="jobs-list">
    <?php foreach ($jobs as $job): ?>
        <div class="job-item">
            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
            <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($job['category']); ?></p>
            <p><strong>Experience Level:</strong> <?php echo htmlspecialchars($job['experience_level']); ?></p>
            <a href="job_details.php?id=<?php echo $job['id']; ?>" class="btn btn-info">View Details</a>
        </div>
    <?php endforeach; ?>
</div>
