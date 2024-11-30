<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

// Selectează notificările necitite
$query = "SELECT * FROM notifications WHERE read_status = 0 ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Notifications</h2>

<ul>
    <?php foreach ($notifications as $notification): ?>
        <li><?php echo htmlspecialchars($notification['message']); ?> - <?php echo $notification['created_at']; ?></li>
    <?php endforeach; ?>
</ul>

<?php include_once "includes/footer.php"; ?>
