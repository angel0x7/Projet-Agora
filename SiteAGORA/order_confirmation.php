<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$orderId = $_GET['order_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

if (!$orderId || !$userId) {
    echo "ID de commande ou ID utilisateur manquant.";
    exit();
}

// Démarrer une transaction
$conn->begin_transaction();

try {
    // Récupérer les informations de la commande
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête (orders): " . $conn->error);
    }
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$order) {
        throw new Exception("Commande non trouvée.");
    }

    // Récupérer les produits dans le panier de l'utilisateur
    $stmt = $conn->prepare("SELECT product_id FROM cart WHERE user_id = ?");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête (cart): " . $conn->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $cartResult = $stmt->get_result();
    $stmt->close();

    // Supprimer le contenu du panier de l'utilisateur
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête (cart): " . $conn->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
    
    // Supprimer les produits du panier et leurs fichiers associés
    while ($cartRow = $cartResult->fetch_assoc()) {
        $productId = $cartRow['product_id'];

        // Récupérer les chemins des images associées au produit
        $imageStmt = $conn->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
        if (!$imageStmt) {
            throw new Exception("Erreur de préparation de la requête (product_images): " . $conn->error);
        }
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
        $imageStmt->close();

        // Récupérer les chemins des vidéos associées au produit
        $videoStmt = $conn->prepare("SELECT video_path FROM product_videos WHERE product_id = ?");
        if (!$videoStmt) {
            throw new Exception("Erreur de préparation de la requête (product_videos): " . $conn->error);
        }
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
        $videoStmt->close();

        // Supprimer les avis associés au produit
        $stmt = $conn->prepare("DELETE FROM reviews WHERE product_id = ?");
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête (reviews): " . $conn->error);
        }
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        // Supprimer les enchères associées au produit
        $stmt = $conn->prepare("DELETE FROM bids WHERE product_id = ?");
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête (bids): " . $conn->error);
        }
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        // Supprimer le produit lui-même
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête (products): " . $conn->error);
        }
        $stmt->bind_param("i", $productId);
        $stmt->execute();
    }

    // Confirmer la transaction
    $conn->commit();
} catch (Exception $e) {
    // En cas d'erreur, annuler la transaction
    $conn->rollback();
    echo "Erreur lors de la confirmation de la commande : " . $e->getMessage();
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Confirmation de commande</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Confirmation de commande</h2>
        <p>Merci pour votre achat ! Votre commande a été passée avec succès.</p>
        <p>Numéro de commande : <?php echo htmlspecialchars($orderId); ?></p>
        <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
