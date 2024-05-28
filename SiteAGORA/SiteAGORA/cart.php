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
        <table class="table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Item 1</td>
                    <td>
                        <input type="number" class="form-control quantity" value="1" min="1">
                    </td>
                    <td>
                        <span class="old-price text-muted"></span>
                        <span class="new-price">100€</span>
                    </td>
                    <td class="total">
                        <span class="old-total text-muted"></span>
                        <span class="new-total">100€</span>
                    </td>
                    <td><button class="btn btn-danger">Supprimer</button></td>
                </tr>
                <!-- Répétez pour plus d'articles -->
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
                    <span id="old-grand-total" class="text-muted"></span>
                    <span id="new-grand-total">Total: 100€</span>
                </h4>
                <button class="btn btn-success">Passer à la caisse</button>
            </div>
        </div>
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
                    var quantity = $(this).find(".quantity").val();
                    if (quantity < 0) {
                        quantity = 1; // Set quantity to 1 if negative value is entered
                        $(this).find(".quantity").val(quantity);
                    }
                    var newPrice = $(this).find(".new-price").text();
                    var itemTotal = quantity * parseFloat(newPrice);
                    $(this).find(".total .new-total").text(itemTotal.toFixed(2) + "€");
                    total += itemTotal;
                });
                $("#new-grand-total").text("Total: " + total.toFixed(2) + "€");
            }

            // Calculate total on page load
            calculateTotal();

            // Calculate total when quantity changes
            $(".quantity").change(function(){
                calculateTotal();
            });

            // Apply promo code
            $(".apply-promo").click(function(){
                var promoCode = $("#promoCode").val();
                if (promoCode === "SALUT" && !promoUsed) { // Vérifier si le code promo est valide et n'a pas été utilisé
                    // Apply 10% discount if promo code is "SALUT"
                    $(".table tbody tr").each(function(){
                        var oldPrice = $(this).find(".new-price").text();
                        var newPrice = parseFloat(oldPrice) * 0.9; // 10% discount
                        $(this).find(".old-price").text(oldPrice).wrap("<del></del>");
                        $(this).find(".new-price").text(newPrice.toFixed(2) + "€");
                        var oldTotal = $(this).find(".total .new-total").text();
                        var newTotal = parseFloat(oldTotal.replace("€", "")) * 0.9;
                        $(this).find(".total .old-total").text(oldTotal).wrap("<del></del>");
                        $(this).find(".total .new-total").text(newTotal.toFixed(2) + "€");
                    });
                    calculateTotal(); // Recalculate total
                    promoUsed = true; // Marquer le code promo comme utilisé
                } else {
                    alert("Invalid promo code or code already used!");
                }
            });
        });
    </script>

</body>
</html>