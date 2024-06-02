<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Récupérer les cartes de l'utilisateur
$stmt = $conn->prepare("SELECT id, card_number FROM user_cards WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$cards = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Récupérer les adresses de livraison de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM livraison WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$addresses = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Vérifier si le prix total a été envoyé depuis la page cart.php
if(isset($_GET['total_price'])) {
    $totalPrice = $_GET['total_price'];
} else {
    // Rediriger vers la page du panier si le prix total n'est pas disponible
    header("Location: cart.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Checkout</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Passer à la caisse</h2>
        <form action="process_checkout.php" method="POST">
            <div class="form-group">
                <label for="card_id">Choisir une carte</label>
                <select class="form-control" id="card_id" name="card_id" required>
                    <?php foreach ($cards as $card): ?>
                    <option value="<?php echo $card['id']; ?>"><?php echo '**** **** **** ' . substr($card['card_number'], -4); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="address_id">Choisir une adresse de livraison</label>
                <select class="form-control" id="address_id" name="address_id" required>
                    <?php foreach ($addresses as $address): ?>
                    <option value="<?php echo $address['id']; ?>">
                        <?php echo htmlspecialchars($address['adresse_ligne1']) . ', ' . htmlspecialchars($address['ville']) . ', ' . htmlspecialchars($address['code_postal']) . ', ' . htmlspecialchars($address['pays']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <h4>Total à payer: <?php echo $totalPrice; ?>€</h4>
            <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
            <button type="submit" class="btn btn-success">Confirmer l'achat</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
