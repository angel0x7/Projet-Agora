<?php
include 'db_connection.php';

// Vérifier si l'ID du produit est passé en paramètre d'URL
if(isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Récupérer le chemin de l'image associée au produit
    $stmt = $conn->prepare("SELECT image_path FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image_path'];

        // Supprimer l'image du serveur
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Supprimer les avis associés au produit
        $stmt = $conn->prepare("DELETE FROM reviews WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        // Supprimer les entrées de commandes associées au produit
        $stmt = $conn->prepare("DELETE FROM order_items WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        // Supprimer les ventes aux enchères associées au produit
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
        // Rediriger si le produit n'est pas trouvé
        header("Location: my_product.php");
        exit();
    }
} else {
    // Rediriger si l'ID du produit n'est pas spécifié
    header("Location: my_product.php");
    exit();
}

$stmt->close();
$conn->close();
?>
