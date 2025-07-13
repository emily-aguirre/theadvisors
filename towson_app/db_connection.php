<?php
function connectDB() {
    $db_path = __DIR__ . '/db/courses.db';
    if (!file_exists($db_path)) {
        die("Database file not found at db/courses.db");
    }
    try {
        $db = new PDO('sqlite:' . $db_path);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
