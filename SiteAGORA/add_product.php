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
$categorySell = $_POST['category_sell'];

// Convertir la valeur de end_time en format MySQL datetime
$endDateTimeFormatted = date('Y-m-d H:i:s', strtotime($endTime));

// Inclure le fichier de connexion à la base de données
include 'db_connection.php';

// Préparer et exécuter la requête SQL pour insérer le produit
$stmt = $conn->prepare("INSERT INTO products (user_id, name, description, price, category, end_time, category_sell_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issdssi", $userId, $productName, $productDescription, $productPrice, $productCategory, $endDateTimeFormatted, $categorySell);

if ($stmt->execute()) {
    $productId = $stmt->insert_id; // Récupérer l'ID du produit inséré
    $stmt->close();

    // Traitement des images
    $targetDir = "img/"; // Répertoire de destination pour enregistrer les images
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $uploadSuccess = true;

    foreach ($_FILES['productImages']['name'] as $key => $fileName) {
        $imageTmpName = $_FILES['productImages']['tmp_name'][$key];
        $fileSize = $_FILES['productImages']['size'][$key];
        $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $targetFile = $targetDir . basename($fileName);

        // Renommer le fichier pour éviter les conflits de noms
        $counter = 1;
        while (file_exists($targetFile)) {
            $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . $counter . '.' . $imageFileType;
            $targetFile = $targetDir . $fileName;
            $counter++;
        }

        // Vérifier la taille du fichier
        if ($fileSize > 500000) {
            echo json_encode(['success' => false, 'message' => 'Désolé, votre fichier est trop grand.']);
            $uploadSuccess = false;
            break;
        }

        // Autoriser certains formats de fichiers
        if (!in_array($imageFileType, $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.']);
            $uploadSuccess = false;
            break;
        }

        // Déplacer le fichier téléchargé vers le répertoire des images
        if (move_uploaded_file($imageTmpName, $targetFile)) {
            // Insérer l'image dans la base de données
            $imageStmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
            $imageStmt->bind_param("is", $productId, $targetFile);
            $imageStmt->execute();
            $imageStmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Désolé, une erreur s\'est produite lors du téléchargement de votre fichier.']);
            $uploadSuccess = false;
            break;
        }
    }

    if ($uploadSuccess) {
        // Rediriger vers une page de confirmation ou de retour
        header("Location: my_product.php");
        exit();
    } else {
        // Supprimer le produit si une erreur s'est produite lors du téléchargement des images
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du produit: ' . $stmt->error]);
}

$conn->close();
?>
