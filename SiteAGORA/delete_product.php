<?php
include 'db_connection.php';

// Vérifier si l'ID du produit est passé en paramètre d'URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Récupérer les chemins des images associées au produit
    $imageStmt = $conn->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
    $imageStmt->bind_param("i", $productId);
    $imageStmt->execute();
    $imageResult = $imageStmt->get_result();

    // Supprimer les images du serveur
    while ($imageRow = $imageResult->fetch_assoc()) {
        $imagePath = $imageRow['image_path'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Récupérer les chemins des vidéos associées au produit
    $videoStmt = $conn->prepare("SELECT video_path FROM product_videos WHERE product_id = ?");
    $videoStmt->bind_param("i", $productId);
    $videoStmt->execute();
    $videoResult = $videoStmt->get_result();

    // Supprimer les vidéos du serveur
    while ($videoRow = $videoResult->fetch_assoc()) {
        $videoPath = $videoRow['video_path'];
        if (file_exists($videoPath)) {
            unlink($videoPath);
        }
    }

    // Supprimer les avis associés au produit
    $stmt = $conn->prepare("DELETE FROM reviews WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    // Supprimer les entrées de commandes associées au produit
    $stmt = $conn->prepare("DELETE FROM order_items WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    // Supprimer les enchères associées au produit
    $stmt = $conn->prepare("DELETE FROM bids WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    // Supprimer le produit lui-même
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    // Rediriger vers une page de confirmation ou de retour
    header("Location: my_product.php");
    exit();
} else {
    // Rediriger si l'ID du produit n'est pas spécifié
    header("Location: my_product.php");
    exit();
}

$stmt->close();
$conn->close();
?>
