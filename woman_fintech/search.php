<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Interogare pentru căutare
$query = "SELECT * FROM members 
          WHERE first_name LIKE :search 
          OR last_name LIKE :search 
          OR profession LIKE :search 
          OR company LIKE :search";
$stmt = $db->prepare($query);
$stmt->execute([':search' => '%' . $searchQuery . '%']);
?>

<h2>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>

<div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="col-md-4">
            <div class="card member-card">
                <?php if (!empty($row['profile_image'])): ?>
                    <img src="<?php echo htmlspecialchars($row['profile_image']); ?>" class="card-img-top profile-img" alt="Profile Image">
                <?php else: ?>
                    <img src="uploads/default-profile.png" class="card-img-top profile-img" alt="Default Profile Image">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h5>
                    <p class="card-text">
                        <strong>Profession:</strong> <?php echo htmlspecialchars($row['profession']); ?><br>
                        <strong>Company:</strong> <?php echo htmlspecialchars($row['company']); ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include_once "includes/footer.php"; ?>
