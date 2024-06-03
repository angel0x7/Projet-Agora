<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Commandes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Vos Commandes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Numéro de Commande</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Montant</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemple de commande -->
                <tr>
                    <td>123456</td>
                    <td>01/01/2023</td>
                    <td>Livrée</td>
                    <td>100€</td>
                    <td><a href="order_detail.php?order_id=123456" class="btn btn-primary">Détails</a></td>
                </tr>
                <!-- Répétez pour plus de commandes -->
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
