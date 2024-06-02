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
            // Gérer les nouvelles images
            if (!empty($_FILES['image']['name'][0])) {
                $imageFiles = $_FILES['image'];
                $imagePaths = [];

                foreach ($imageFiles['tmp_name'] as $key => $tmpName) {
                    $imageName = $imageFiles['name'][$key];
                    $imageType = $imageFiles['type'][$key];
                    $imageError = $imageFiles['error'][$key];

                    // Vérifier le type de fichier image
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($imageType, $allowedTypes)) {
                        $uploadDir = 'img/';
                        $uploadPath = $uploadDir . basename($imageName);
                        if (move_uploaded_file($tmpName, $uploadPath)) {
                            $imagePaths[] = $uploadPath;
                        } else {
                            echo "Erreur lors du téléchargement de l'image.";
                            exit();
                        }
                    } else {
                        echo "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                        exit();
                    }
                }

                // Supprimer les anciennes images de la base de données
                $deleteImagesStmt = $conn->prepare("DELETE FROM product_images WHERE product_id=?");
                $deleteImagesStmt->bind_param("i", $productId);
                $deleteImagesStmt->execute();

                // Insérer les nouvelles images dans la base de données
                $insertImagesStmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                foreach ($imagePaths as $imagePath) {
                    $insertImagesStmt->bind_param("is", $productId, $imagePath);
                    $insertImagesStmt->execute();
                }
            }

            // Gérer la nouvelle vidéo
            if (!empty($_FILES['video']['name'])) {
                $video = $_FILES['video'];
                $videoName = $video['name'];
                $videoTmpName = $video['tmp_name'];
                $videoType = $video['type'];
                $videoError = $video['error'];

                // Vérifier le type de fichier vidéo
                $allowedTypes = ['video/mp4', 'video/mpeg', 'video/quicktime'];
                if (in_array($videoType, $allowedTypes)) {
                    $uploadDir = 'img/';
                    $uploadPath = $uploadDir . basename($videoName);
                    if (move_uploaded_file($videoTmpName, $uploadPath)) {
                        // Mettre à jour le chemin de la vidéo dans la base de données
                        $updateVideoStmt = $conn->prepare("INSERT INTO product_videos (product_id, video_path) VALUES (?, ?)");
                        $updateVideoStmt->bind_param("is", $productId, $uploadPath);
                        $updateVideoStmt->execute();
                    } else {
                        echo "Erreur lors du téléchargement de la vidéo.";
                        exit();
                    }
                } else {
                    echo "Seuls les fichiers vidéo de type MP4, MPEG et QuickTime sont autorisés.";
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
