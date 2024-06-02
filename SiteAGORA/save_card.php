<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $card_type = $_POST['card_type'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $security_code = $_POST['security_code'];

    // Insérer les données de la carte dans la base de données
    $stmt = $conn->prepare("INSERT INTO user_cards (user_id, card_type, card_number, expiry_date, security_code) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $card_type, $card_number, $expiry_date, $security_code);
    if ($stmt->execute()) {
        echo "La carte a été ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de la carte.";
    }
    $stmt->close();
    $conn->close();
}
?>
