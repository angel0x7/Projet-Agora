<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    // Vérifier si l'élément est déjà dans le panier
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND item_id = ?");
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($existing_quantity);
    if ($stmt->fetch()) {
        // Mettre à jour la quantité existante
        $new_quantity = $existing_quantity + $quantity;
        $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND item_id = ?");
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $item_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Ajouter un nouvel élément au panier
        $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("iii", $user_id, $item_id, $quantity);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
    $stmt->close();
    $conn->close();

    header("Location: cart.php");
}
?>
