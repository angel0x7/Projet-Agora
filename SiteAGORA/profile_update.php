<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $password, $user_id);

    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name;
        header("Location: profile.php");
    } else {
        echo "Erreur lors de la mise à jour du profil.";
    }
    $stmt->close();
    $conn->close();
}
?>
