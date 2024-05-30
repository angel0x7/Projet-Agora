<?php
session_start();
include 'db_connection.php';

// Vérifier si le formulaire est soumis pour mettre à jour le produit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données nécessaires sont fournies
    if (isset($_POST['product_id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'], $_POST['end_time'], $_POST['category_sell'])) {
        $productId = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = (float)$_POST['price'];
        $category = $_POST['category'];
        $endTime = $_POST['end_time'];
        $categorySell = $_POST['category_sell']; // Nouveau champ pour la catégorie de vente

        // Préparer et exécuter la requête SQL pour mettre à jour le produit
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, end_time=?, category_sell_id=? WHERE id=?");
        $stmt->bind_param("ssdssii", $name, $description, $price, $category, $endTime, $categorySell, $productId);

        if ($stmt->execute()) {
            // Vérifier si une nouvelle image est téléchargée
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $image = $_FILES['image'];
                $imageName = $image['name'];
                $imageTmpName = $image['tmp_name'];
                $imageType = $image['type'];
                $imageError = $image['error'];

                // Vérifier le type de fichier image
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($imageType, $allowedTypes)) {
                    // Déplacer l'image téléchargée vers le dossier des images
                    $uploadDir = 'img/';
                    $uploadPath = $uploadDir . basename($imageName);
                    if (move_uploaded_file($imageTmpName, $uploadPath)) {
                        // Mettre à jour le chemin de l'image dans la base de données
                        $stmt = $conn->prepare("UPDATE products SET image_path=? WHERE id=?");
                        $stmt->bind_param("si", $uploadPath, $productId);
                        $stmt->execute();
                    } else {
                        echo "Erreur lors du téléchargement de l'image.";
                        exit();
                    }
                } else {
                    echo "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                    exit();
                }
            }

            // Rediriger vers la page de détail du produit
            header("Location: my_product.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour du produit.";
            exit();
        }
    } else {
        echo "Veuillez remplir tous les champs requis.";
        exit();
    }
} else {
    // Rediriger si le formulaire n'est pas soumis
    header("Location: my_product.php");
    exit();
}

$conn->close();
?>
