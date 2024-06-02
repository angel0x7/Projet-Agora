<?php
include 'db_connection.php';

// Récupérer l'ID de l'adresse à supprimer
$idAdresse = $_GET['id'];

// Mettre à jour les commandes pour supprimer la référence à cette adresse
$sql_update_orders = "UPDATE orders SET address_id = NULL WHERE address_id = $idAdresse";
if ($conn->query($sql_update_orders) === TRUE) {
    // Requête SQL pour supprimer une adresse de livraison
    $sql = "DELETE FROM livraison WHERE id=$idAdresse";
    
    if ($conn->query($sql) === TRUE) {
        echo "Adresse de livraison supprimée avec succès.";
        $conn->close();
        header("Location: manage_livraison.php");
    } else {
        echo "Erreur lors de la suppression de l'adresse de livraison : " . $conn->error;
    }
} else {
    echo "Erreur lors de la mise à jour des commandes : " . $conn->error;
}

$conn->close();
?>
