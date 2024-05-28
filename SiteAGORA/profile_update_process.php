<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$address = $_POST['address'];
$profile_picture = $_FILES['profile_picture'];

// Mettre à jour les informations de l'utilisateur
$stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, address = ? WHERE id = ?");
$stmt->bind_param("sssi", $username, $email, $address, $user_id);
$stmt->execute();
$stmt->close();

// Gérer les cartes
$card_numbers = $_POST['card_number'];
$expiry_dates = $_POST['expiry_date'];

// Supprimer les cartes actuelles
$stmt = $conn->prepare("DELETE FROM user_cards WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

// Insérer les nouvelles cartes
$stmt = $conn->prepare("INSERT INTO user_cards (user_id, card_number, expiry_date) VALUES (?, ?, ?)");

foreach ($card_numbers as $index => $card_number) {
    $expiry_date = $expiry_dates[$index];
    $stmt->bind_param("iss", $user_id, $card_number, $expiry_date);
    $stmt->execute();
}

$stmt->close();
$conn->close();

header("Location: profile.php");
exit();
?>
