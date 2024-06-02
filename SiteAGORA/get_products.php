<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

// Récupérer l'ID de l'utilisateur
$userId = $_SESSION['user_id'];

// Préparer et exécuter la requête SQL pour récupérer les produits de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Afficher les produits
while ($row = $result->fetch_assoc()) {
    echo '<div class="col-md-4">';
    echo '<div class="card mb-4" id="item' . htmlspecialchars($row['id']) . '">';

    // Vérifier s'il y a plusieurs images pour ce produit
    $stmt_images = $conn->prepare("SELECT * FROM product_images WHERE product_id = ?");
    $stmt_images->bind_param("i", $row['id']);
    $stmt_images->execute();
    $images_result = $stmt_images->get_result();

    if ($images_result->num_rows > 1) {
        // Afficher un carrousel
        echo '<div id="carousel' . htmlspecialchars($row['id']) . '" class="carousel slide" data-ride="carousel">';
        echo '<div class="carousel-inner">';

        $first = true;
        while ($image_row = $images_result->fetch_assoc()) {
            echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
            echo '<img src="' . htmlspecialchars($image_row['image_path']) . '" class="d-block w-100" alt="' . htmlspecialchars($row['name']) . '">';
            echo '</div>';
            $first = false;
        }

        echo '</div>';
        echo '<a class="carousel-control-prev" href="#carousel' . htmlspecialchars($row['id']) . '" role="button" data-slide="prev">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="sr-only">Previous</span>';
        echo '</a>';
        echo '<a class="carousel-control-next" href="#carousel' . htmlspecialchars($row['id']) . '" role="button" data-slide="next">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '<span class="sr-only">Next</span>';
        echo '</a>';
        echo '</div>';
    } else {
        // Afficher l'image unique du produit
        if ($images_result->num_rows === 1) {
            $image_row = $images_result->fetch_assoc();
            echo '<img src="' . htmlspecialchars($image_row['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
        }
    }

    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
    echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
    echo '<p class="card-text">Prix: ' . htmlspecialchars($row['price']) . '€</p>';
    echo '<div class="choix" style="display: flex; justify-content: space-between;">';
    // Lien pour supprimer le produit
    echo '<a href="delete_product.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-danger">Supprimer</a>';
    // Lien pour modifier le produit (vers une page de modification)
    echo '<a href="edit_product.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Modifier</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

$stmt->close();
$conn->close();
?>
