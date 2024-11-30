<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$professionsQuery = "SELECT DISTINCT profession FROM members WHERE profession IS NOT NULL AND profession != ''";
$professionsStmt = $db->prepare($professionsQuery);
$professionsStmt->execute();
$professions = $professionsStmt->fetchAll(PDO::FETCH_ASSOC);

$orderBy = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$professionFilter = isset($_GET['profession']) ? $_GET['profession'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM members WHERE 1";
$params = [];

if (!empty($professionFilter)) {
    $query .= " AND profession = ?";
    $params[] = $professionFilter;
}

$query .= " ORDER BY $orderBy DESC LIMIT $limit OFFSET $offset";
$stmt = $db->prepare($query);
$stmt->execute($params);

$totalQuery = "SELECT COUNT(*) as total FROM members WHERE 1";
if (!empty($professionFilter)) {
    $totalQuery .= " AND profession = ?";
}
$totalStmt = $db->prepare($totalQuery);
$totalStmt->execute($params);
$totalMembers = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
$imagesFilePath = '.\\images\\';
?>

<h2>Members Directory</h2>

<a href="members.php?sort=first_name" class="btn btn-info">Sort by Name</a>
<a href="members.php?sort=created_at" class="btn btn-info">Sort by Date</a>

<form method="GET" class="mb-4">
    <select name="profession" onchange="this.form.submit()" class="form-control">
        <option value="">All Professions</option>
        <?php foreach ($professions as $profession): ?>
            <option value="<?php echo htmlspecialchars($profession['profession']); ?>" 
                <?php if ($professionFilter === $profession['profession']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($profession['profession']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="col-md-4">
            <div class="card member-card">
                <?php if (!empty($row['profile_image'])): ?>
                    <img src="<?php echo $imagesFilePath . htmlspecialchars($row['profile_image']); ?>" class="card-img-top profile-img" alt="Profile Image">
                <?php else: ?>
                    <img src="uploads/default-profile.png" class="card-img-top profile-img" alt="Default Profile Image">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h5>
                    <p class="card-text">
                        <strong>Profession:</strong> <?php echo htmlspecialchars($row['profession']); ?><br>
                        <strong>Company:</strong> <?php echo htmlspecialchars($row['company']); ?>
                    </p>
                    <a href="edit_member.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_member.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<div class="pagination">
    <?php for ($i = 1; $i <= ceil($totalMembers / $limit); $i++): ?>
        <a href="members.php?page=<?php echo $i; ?>&profession=<?php echo urlencode($professionFilter); ?>&sort=<?php echo $orderBy; ?>" class="btn btn-light"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

<?php
include_once "includes/footer.php";
?>
