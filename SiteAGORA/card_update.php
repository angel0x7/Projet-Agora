<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Vérifiez si les données POST sont présentes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si les données de mise à jour de la carte sont présentes
    if (isset($_POST['card_id'], $_POST['card_type'], $_POST['card_number'], $_POST['expiry_date'], $_POST['security_code'])) {
        $card_id = $_POST['card_id'];
        $card_type = $_POST['card_type'];
        $card_number = $_POST['card_number'];
        $expiry_date = $_POST['expiry_date'];
        $security_code = $_POST['security_code'];

        // Préparez et exécutez la requête de mise à jour
        $stmt = $conn->prepare("UPDATE user_cards SET card_type = ?, card_number = ?, expiry_date = ?, security_code = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssssii", $card_type, $card_number, $expiry_date, $security_code, $card_id, $user_id);

        if ($stmt->execute()) {
            // La mise à jour a réussi
            header("Location: manege_card.php");
            exit();
        } else {
            // La mise à jour a échoué
            // Gérer l'erreur ici, par exemple afficher un message à l'utilisateur
            echo "Erreur lors de la mise à jour de la carte : " . $stmt->errno . " - " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Les données de mise à jour de la carte sont manquantes
        // Gérer cette condition, par exemple afficher un message d'erreur ou rediriger l'utilisateur
        echo "Données de mise à jour de la carte manquantes.";
    }
}

$conn->close();
?>
