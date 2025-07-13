<?php
include 'db_connection.php';
include 'header.php';

$db = connectDB();
$search = $_GET['search'] ?? '';
$query = $db->prepare("SELECT major_id, major_name FROM major WHERE major_name LIKE :search OR major_id LIKE :search");
$query->execute([':search' => "%$search%"]);
$majors = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Search Majors</h2>
<form method="GET">
    <input type="text" name="search" placeholder="Search by ID or name" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<ul>
<?php foreach ($majors as $major): ?>
    <li>
        <?= htmlspecialchars($major['major_id']) ?> - <?= htmlspecialchars($major['major_name']) ?>
        <a href="view_major.php?major_id=<?= urlencode($major['major_id']) ?>">View Details</a>
    </li>
<?php endforeach; ?>
</ul>
<button onclick="history.back()" class="go-back-button">← Go Back</button>
<?php include 'footer.php'; ?>
