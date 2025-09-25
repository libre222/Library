<?php
include '../classes/database.php';
$error = [];
$isValid = true;
$pdo = null;

try {
    $db = new Database();
    $pdo = $db->connect();
} catch (PDOException $e) {
    echo "<p style='color:red;'>Database connection error: " . htmlspecialchars($e->getMessage()) . "</p>";
    $isValid = false;
}
require_once "../classes/book.php";
$bookobj = new BOOK();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: viewbook.php");
    exit();
}

if ($isValid && $bookobj->isbookExist($id)) {
    try {
        if ($bookobj->deleteBook($id)) {
            header("Location: viewbook.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error deleting book.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    header("Location: viewbook.php");
    exit();
}
?>
