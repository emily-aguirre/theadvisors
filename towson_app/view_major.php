<?php
include 'db_connection.php';
include 'header.php';

$db = connectDB();
$major_id = $_GET['major_id'] ?? '';
$query = $db->prepare("SELECT * FROM course WHERE major_id = :major_id");
$query->execute([':major_id' => $major_id]);
$courses = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Courses in Major: <?= htmlspecialchars($major_id) ?></h2>
<ul>
<?php foreach ($courses as $course): ?>
    <li>
        <a href="view_course.php?course_id=<?= urlencode($course['course_id']) ?>">
            <?= htmlspecialchars($course['course_id']) ?> - <?= htmlspecialchars($course['course_name']) ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
<a href="index.php">Return to Home Page</a>
<?php include 'footer.php'; ?>
