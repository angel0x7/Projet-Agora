<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {// Vérifie si la requête est de type POST et si l'utilisateur est connecté
    $notifications = $_POST['notifications'];// Récupère la préférence de notification depuis le formulaire
    $security = password_hash($_POST['security'], PASSWORD_DEFAULT);
    $user_id = $_SESSION['user_id'];// Récupère l'identifiant de l'utilisateur à partir de la session
// Prépare une déclaration SQL pour mettre à jour les informations de l'utilisateur
    $stmt = $conn->prepare("UPDATE users SET notifications = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $notifications, $security, $user_id);

    if ($stmt->execute()) {
        header("Location: account.php");// Redirige vers la page de compte si la mise à jour a réussi
    } else {
        echo "Erreur lors de la mise à jour du compte. Votre compte n'a pas été trouvé.";
    }
    $stmt->close();// Ferme la déclaration préparée
    $conn->close();// Ferme la connexion à la base de données
}
?>
