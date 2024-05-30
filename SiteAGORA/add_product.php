<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$userId = $_SESSION['user_id'];
$productName = $_POST['productName'];
$productDescription = $_POST['productDescription'];
$productPrice = $_POST['productPrice'];
$productCategory = $_POST['productCategory'];
$endTime = $_POST['end_time'];
$categorySell = $_POST['category_sell']; // Nouveau champ pour la catégorie de vente

// Convertir la valeur de end_time en format MySQL datetime
$endDateTimeFormatted = date('Y-m-d H:i:s', strtotime($endTime));

// Traitement de l'image
$targetDir = "img/"; // Répertoire de destination pour enregistrer les images
$fileName = basename($_FILES["productImage"]["name"]); // Nom du fichier téléchargé
$targetFile = $targetDir . $fileName;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Renommer le fichier pour éviter les conflits de noms
$counter = 1;
while (file_exists($targetFile)) {
    $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . $counter . '.' . $imageFileType;
    $targetFile = $targetDir . $fileName;
    $counter++;
}

// Vérifier la taille du fichier
if ($_FILES["productImage"]["size"] > 500000) {
    echo json_encode(['success' => false, 'message' => 'Désolé, votre fichier est trop grand.']);
    exit();
}

// Autoriser certains formats de fichiers
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($imageFileType, $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.']);
    exit();
}

// Déplacer le fichier téléchargé vers le répertoire des images
if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
    echo json_encode(['success' => false, 'message' => 'Désolé, une erreur s\'est produite lors du téléchargement de votre fichier.']);
    exit();
}

// Inclure le fichier de connexion à la base de données
include 'db_connection.php';

// Préparer et exécuter la requête SQL pour insérer le produit
$stmt = $conn->prepare("INSERT INTO products (user_id, name, description, price, category, end_time, image_path, category_sell_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issdsssi", $userId, $productName, $productDescription, $productPrice, $productCategory, $endDateTimeFormatted, $targetFile, $categorySell);

if ($stmt->execute()) {
    // Rediriger vers une page de confirmation ou de retour
    header("Location: my_product.php");
    exit();
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du produit: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
