<?php
session_start();
include 'db_connection.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Récupérer les données de l'utilisateur
$user_type = $user['user_type']; // Extraire le type d'utilisateur
$stmt->close();

// Vérifier si l'utilisateur est connecté et s'il est administrateur
if (!isset($_SESSION['user_id']) || $user_type !== 'administrateur') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accepter'])) {
        $userId = $_POST['user_id'];

        // Mettre à jour le type d'utilisateur dans la base de données pour accepter la demande
        $stmt = $conn->prepare("UPDATE users SET user_type = 'vendeur' WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        // Supprimer la demande de la table des demandes de vendeur
        $stmt = $conn->prepare("DELETE FROM demande_vendeur WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        header("Location: gestion_Vendeur.php");
        exit();
    } elseif (isset($_POST['refuser'])) {
        $userId = $_POST['user_id'];

        // Supprimer la demande de la table des demandes de vendeur
        $stmt = $conn->prepare("DELETE FROM demande_vendeur WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        header("Location: gestion_Vendeur.php");
        exit();
    }
} else {
    header("Location: gestion_Vendeur.php");
    exit();
}
?>
