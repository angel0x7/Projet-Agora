<?php
session_start();
include 'db_connection.php';

// Vérifiez si l'ID de l'article est passé en paramètre d'URL
if (isset($_GET['id'])) {
    // Récupérez l'ID de l'article depuis l'URL
    $itemId = $_GET['id'];
    $_SESSION['product_id'] = $itemId; // Définissez la variable de session

    // Préparez et exécutez la requête SQL pour récupérer les détails de l'article
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérez les détails de l'article
        $row = $result->fetch_assoc();
        $itemName = htmlspecialchars($row['name']);
        $itemDescription = htmlspecialchars($row['description']);
        $itemPrice = htmlspecialchars($row['price']);
        $itemImage = htmlspecialchars($row['image_path']);
        $itemUserId = (int)$row['user_id']; // ID de l'utilisateur qui a ajouté l'article
        $endTime = $row['end_time']; // Heure de fin de la vente aux enchères
        $categorySellId = $row['category_sell_id']; // Récupérer la valeur de category_sell_id
    } else {
        // Affichez un message si l'article n'est pas trouvé
        echo "Aucun article trouvé avec cet identifiant.";
        exit(); // Arrêtez le script
    }

    // Fermez la requête
    $stmt->close();
} else {
    // Affichez un message si l'ID de l'article n'est pas fourni dans l'URL
    echo "L'identifiant de l'article n'est pas fourni.";
    exit(); // Arrêtez le script
}

// Vérifiez si le mode de vente est "Meilleure Vente" (category_sell_id = 1)
if ($categorySellId == 1) {
    // Affichez l'interface de vente aux enchères
    include 'interface_encheres.php';
} else if ($categorySellId == 2)  {
    // Affichez l'interface de négociation
    include 'interface_negociation.php';
}else if ($categorySellId == 3) {
    // Affichez l'interface de vente rapide
    include 'interface_vente_rapide.php';
}

// Fermez la connexion à la base de données
$conn->close();
?>
