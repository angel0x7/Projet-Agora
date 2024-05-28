<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $notifications = $_POST['notifications'];
    $security = password_hash($_POST['security'], PASSWORD_DEFAULT);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE users SET notifications = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $notifications, $security, $user_id);

    if ($stmt->execute()) {
        header("Location: account.php");
    } else {
        echo "Erreur lors de la mise à jour du compte.";
    }
    $stmt->close();
    $conn->close();
}
?>
