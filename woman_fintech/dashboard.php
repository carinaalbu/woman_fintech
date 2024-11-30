<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

// Număr total de membri
$totalMembersQuery = "SELECT COUNT(*) as total FROM members";
$totalMembersStmt = $db->prepare($totalMembersQuery);
$totalMembersStmt->execute();
$totalMembers = $totalMembersStmt->fetch(PDO::FETCH_ASSOC)['total'];

// Distribuția pe profesii
$professionDistributionQuery = "SELECT profession, COUNT(*) as count FROM members GROUP BY profession";
$professionDistributionStmt = $db->prepare($professionDistributionQuery);
$professionDistributionStmt->execute();
$professionDistribution = $professionDistributionStmt->fetchAll(PDO::FETCH_ASSOC);

// Membri noi pe lună
$newMembersQuery = "
    SELECT MONTH(created_at) as month_number, COUNT(*) as count 
    FROM members 
    GROUP BY month_number 
    ORDER BY month_number";
$newMembersStmt = $db->prepare($newMembersQuery);
$newMembersStmt->execute();
$newMembers = $newMembersStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h2>Dashboard</h2>

<!-- Total membri -->
<p><strong>Număr total de membri:</strong> <?php echo $totalMembers; ?></p>

<!-- Distribuția pe profesii -->
<h3>Distribuția pe profesii</h3>
<ul>
    <?php foreach ($professionDistribution as $profession): ?>
        <li><?php echo htmlspecialchars($profession['profession']); ?>: <?php echo $profession['count']; ?></li>
    <?php endforeach; ?>
</ul>
<?php
$months = [
    1 => 'Ianuare', 2 => 'Februarie', 3 => 'Martie', 4 => 'Aprilie', 
    5 => 'Mai', 6 => 'Iunie', 7 => 'Iulie', 8 => 'August', 
    9 => 'Septembrie', 10 => 'Octombrie', 11 => 'Noiembrie', 12 => 'Decembrie'
];
?>

<!-- Membri noi pe lună -->
<h3>Membri noi pe lună</h3>
<ul>
<?php foreach ($newMembers as $member): ?>
        <li><?php echo $months[$member['month_number']]; ?>: <?php echo $member['count']; ?> new members</li>
    <?php endforeach; ?>
</ul>

<?php include_once "includes/footer.php"; ?>
