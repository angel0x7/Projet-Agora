<?php
include 'db_connection.php';

$name = "Romeo Fondaneiche";
$email = "romeofondaneiche@gmail.com";
$password = password_hash("azer", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    echo "Utilisateur ajouté avec succès.";
} else {
    echo "Erreur lors de l'ajout de l'utilisateur.";
}

$stmt->close();
$conn->close();
?>
