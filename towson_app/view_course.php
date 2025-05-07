<?php
include 'db_connection.php';
include 'header.php';

$db = connectDB();
$course_id = $_GET['course_id'] ?? '';
$query = $db->prepare("SELECT * FROM course WHERE course_id = :course_id");
$query->execute([':course_id' => $course_id]);
$course = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="course-container">
    <h2>Course Details</h2>
    <?php if ($course): ?>
        <p><strong>ID:</strong> <?= htmlspecialchars($course['course_id']) ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($course['course_name']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($course['course_desc']) ?></p>
        <p><strong>Major ID:</strong> <?= htmlspecialchars($course['major_id']) ?></p>
        <?php if ($course['prereq_id']): ?>
            <p><strong>Prerequisite:</strong>
                <a href="view_course.php?course_id=<?= urlencode($course['prereq_id']) ?>">
                    <?= htmlspecialchars($course['prereq_id']) ?>
                </a>
            </p>
        <?php else: ?>
            <p><strong>Prerequisite:</strong> None</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Course not found.</p>
    <?php endif; ?>
    <a href="index.php">Return to Home Page</a>
    <button onclick="history.back()" class="go-back-button">← Go Back</button>
</div>

<?php include 'footer.php'; ?>
