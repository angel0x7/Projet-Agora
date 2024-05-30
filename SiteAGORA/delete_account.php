<?php
session_start();
include 'db_connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
