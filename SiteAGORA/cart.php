<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $userLoggedIn = false;
} else {
    $userLoggedIn = true;
    // Récupérer l'ID de l'utilisateur
    $userId = $_SESSION['user_id'];

    // Récupérer les articles du panier de l'utilisateur avec le prix du produit, l'image et le mode de paiement depuis la table du panier
    $stmt = $conn->prepare("
        SELECT products.id, products.name, cart.price AS price, 
               (SELECT image_path FROM product_images WHERE product_images.product_id = products.id LIMIT 1) AS image_path, 
               cart.quantity,
               products.category_sell_id
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Stocker les articles du panier dans un tableau
    $cartItems = [];
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Panier</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Votre Panier</h2>
        <?php if (!$userLoggedIn): ?>
            <div class="container mt-5">
                <p>Vous n'êtes pas connecté</p>
                <p class="mt-3">Vous avez déjà un compte ? <a href="login.php">Connexion</a></p>
                <p class="mt-3">Vous n'avez pas encore de compte ? <a href="signup.php">Inscription</a></p>
            </div>
        <?php else: ?>
            <?php if (count($cartItems) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Image</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>
                            <?php if ($item['image_path']): ?>
                            <img src="<?php echo htmlspecialchars($item['image_path']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 50px; height: 50px;">
                            <?php else: ?>
                            <span>Pas d'image</span>
                            <?php endif; ?>
                        </td>
                        <td class="total">
                            <span class="new-price"><?php echo number_format($item['price'], 2); ?>€</span>
                        </td>
                        <td>
                            <?php if ($item['category_sell_id'] == 3): ?>
                            <button class="btn btn-danger remove-item" data-product-id="<?php echo $item['id']; ?>">Supprimer</button>
                            <?php else: ?>
                            <button class="btn btn-secondary" disabled>Obligation de payer</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="promoCode">Code Promo</label>
                        <input type="text" class="form-control" id="promoCode">
                    </div>
                    <button class="btn btn-primary apply-promo">Appliquer</button>
                </div>
                <div class="col-md-6 text-right">
                    <h4>
                        <span id="new-grand-total">Total: <?php echo number_format(array_sum(array_column($cartItems, 'price')), 2); ?>€</span>
                    </h4>
                    <a href="checkout.php?total_price=<?php echo number_format(array_sum(array_column($cartItems, 'price')), 2); ?>" class="btn btn-success">Passer à la caisse</a>
                </div>
            </div>
            <?php else: ?>
            <p>Votre panier est vide.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            var promoUsed = false; // Variable pour vérifier si le code promo a été utilisé

            // Function to calculate total price
            function calculateTotal() {
                var total = 0;
                $(".table tbody tr").each(function(){
                    var newPrice = $(this).find(".new-price").text().replace("€", "");
                    total += parseFloat(newPrice);
                });
                $("#new-grand-total").text("Total: " + total.toFixed(2) + "€");
            }

            // Calculate total on page load
            calculateTotal();

            // Apply promo code
            $(".apply-promo").click(function(){
                var promoCode = $("#promoCode").val();
                if (promoCode === "SALUT" && !promoUsed) { // Vérifier si le code promo est valide et n'a pas été utilisé
                    // Apply 10% discount if promo code is "SALUT"
                    $(".table tbody tr").each(function(){
                        var oldPrice = $(this).find(".new-price").text();
                        var newPrice = parseFloat(oldPrice.replace("€", "")) * 0.9; // 10% discount
                        $(this).find(".new-price").text(newPrice.toFixed(2) + "€");
                    });
                    calculateTotal(); // Recalculate total
                    promoUsed = true; // Marquer le code promo comme utilisé
                } else {
                    alert("Code promo invalide ou déjà utilisé !");
                }
            });

            // Remove item from cart
            $(".remove-item").click(function(){
                var productId = $(this).data("product-id");
                $.post("remove_from_cart.php", { product_id: productId }, function(data) {
                    location.reload();
                });
            });
        });
    </script>
</body>
</html>
