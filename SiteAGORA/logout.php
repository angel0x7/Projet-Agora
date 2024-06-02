<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    // Si l'utilisateur est connecté, supprimer la session
    session_unset();
    session_destroy();
}

// Rediriger l'utilisateur vers la page de connexion
header("Location: login.php");
exit();
?>
