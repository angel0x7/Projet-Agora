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
$mot_passe = $_POST['mot_passe'];
$address = $_POST['address'];

// Initialiser les chemins de fichier pour les images
$profile_picture_path = null;
$background_image_path = null;

// Gérer la photo de profil
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $profile_picture_tmp = $_FILES['profile_picture']['tmp_name'];
    $profile_picture_name = basename($_FILES['profile_picture']['name']);
    $profile_picture_path = "img/" . $profile_picture_name;

    // Déplacer le fichier téléchargé vers le dossier cible
    move_uploaded_file($profile_picture_tmp, $profile_picture_path);
} else {
    // Utiliser l'image de profil existante si aucune nouvelle image n'est téléchargée
    $profile_picture_path = $_POST['existing_profile_picture'];
}

// Gérer l'image de fond
if (isset($_FILES['background_image']) && $_FILES['background_image']['error'] === UPLOAD_ERR_OK) {
    $background_image_tmp = $_FILES['background_image']['tmp_name'];
    $background_image_name = basename($_FILES['background_image']['name']);
    $background_image_path = "img/" . $background_image_name;

    // Déplacer le fichier téléchargé vers le dossier cible
    move_uploaded_file($background_image_tmp, $background_image_path);
} else {
    // Utiliser l'image de fond existante si aucune nouvelle image n'est téléchargée
    $background_image_path = $_POST['existing_background_image'];
}

// Mise à jour des informations de l'utilisateur dans la base de données
$stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, address = ?, profile_picture = ?, password = ?, background_image = ? WHERE id = ?");
$stmt->bind_param("ssssssi", $username, $email, $address, $profile_picture_path, $mot_passe, $background_image_path, $user_id);

if ($stmt->execute()) {
    header("Location: profile.php?update_success=1");
} else {
    echo "Erreur lors de la mise à jour du profil : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
