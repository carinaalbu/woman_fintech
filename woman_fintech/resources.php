<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$typeFilter = isset($_GET['type']) ? $_GET['type'] : '';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Construire interogare dinamică
$query = "SELECT * FROM resources WHERE 1";
$params = [];
$filePath = '.\\';

// $filePath = '.\\articles\\';

if (!empty($typeFilter)) {

    if($typeFilter === 'has_download_permission') {
        $query .= " AND has_download_permission = ?";
        $params[] = '1';
    } else {
        $query .= " AND type = ?";
        $params[] = $typeFilter;
    }
}
if (!empty($searchQuery)) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = '%' . $searchQuery . '%';
    $params[] = '%' . $searchQuery . '%';
}

$query .= " ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Afișarea resurselor -->
 <div class="resource-content">
<form method="GET" class="form-inline">
    <div style="display: flex; justify-content: space-between; width: 100%;" class="containerx">
        <div>
            <input style="margin-left: 5px;" class="form-control mr-sm-2" type="text" name="search" placeholder="Search resources..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <select class="form-control mr-sm-2" name="type">
                <option value="">All Types</option>
                <option value="article" <?php if ($typeFilter === 'article') echo 'selected'; ?>>Article</option>
                <option value="video" <?php if ($typeFilter === 'video') echo 'selected'; ?>>Video</option>
                <option value="podcast" <?php if ($typeFilter === 'podcast') echo 'selected'; ?>>Podcast</option>
                <option value="has_download_permission" <?php if ($typeFilter === 'has_download_permission') echo 'selected'; ?>>Downloadable</option>
            </select>
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        <div class="elem 2">
            <a class="btn" href="add_resource.php">Upload</a>
        </div>
    </div>
   
</form>

<div class="row" style="padding: 15px 5px;">
    <?php foreach ($resources as $resource): ?>
        <div class="col-md-4">
            <div class="thumb-nail-card card member-card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($resource['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($resource['description']); ?></p>
                    <?php if ($resource['type'] === 'article' && !$resource['has_download_permission']): ?>
                        <a href="<?php echo $filePath . $resource['link'] . $resource['fileName'] . '.txt' ?>" class="btn btn-primary" target="_blank">View</a>
                    <?php endif; ?>
                    <?php if ($resource['type'] === 'article' && $resource['has_download_permission']): ?>
                        <button class="btn" onclick="window.location.href='<?php echo 'download.php?' . 'file=' . $resource['fileName'] ?>'">Download File</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
   
</div>
</div>