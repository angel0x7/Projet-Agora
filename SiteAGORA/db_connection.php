<?php
$servername = "localhost";  // Nom du serveur MySQL
$username = "root";  // Nom d'utilisateur MySQL
$password = "root";  // Mot de passe MySQL
$dbname = "agora_francia";  // Nom de la base de données

// Crée la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
} 
?>


