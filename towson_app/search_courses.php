<?php
include 'db_connection.php';
include 'header.php';

$db = connectDB();
$search = $_GET['search'] ?? '';
$query = $db->prepare("SELECT course_id, course_name FROM course WHERE course_name LIKE :search OR course_id LIKE :search");
$query->execute([':search' => "%$search%"]);
$courses = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Search Courses</h2>
<form method="GET">
    <input type="text" name="search" placeholder="Search by ID or name" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<ul>
<?php foreach ($courses as $course): ?>
    <li>
        <?= htmlspecialchars($course['course_id']) ?> - <?= htmlspecialchars($course['course_name']) ?>
        <a href="view_course.php?course_id=<?= urlencode($course['course_id']) ?>">View Details</a>
    </li>
<?php endforeach; ?>
</ul>
<a href="index.php">Return to Home Page</a>
<button onclick="history.back()" class="go-back-button">← Go Back</button>
<?php include 'footer.php'; ?>
