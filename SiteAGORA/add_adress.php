<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'header.php';
include 'db_connection.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adresse_ligne1 = $_POST['adresse_ligne1'];
    $adresse_ligne2 = $_POST['adresse_ligne2'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];
    $numero_telephone = $_POST['numero_telephone'];

    $stmt = $conn->prepare("INSERT INTO Livraison (user_id, adresse_ligne1, adresse_ligne2, ville, code_postal, pays, numero_telephone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssis", $user_id, $adresse_ligne1, $adresse_ligne2, $ville, $code_postal, $pays, $numero_telephone);
    $stmt->execute();
    $stmt->close();

    $conn->close();
    header("Location: manage_livraison.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Ajouter une Adresse de Livraison</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Ajouter une Adresse de Livraison</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="adresse_ligne1">Adresse 1</label>
                <input type="text" class="form-control" id="adresse_ligne1" name="adresse_ligne1" required>
            </div>
            <div class="form-group">
                <label for="adresse_ligne2">Adresse 2</label>
                <input type="text" class="form-control" id="adresse_ligne2" name="adresse_ligne2">
            </div>
            <div class="form-group">
                <label for="ville">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" required>
            </div>
            <div class="form-group">
                <label for="code_postal">Code Postal</label>
                <input type="text" class="form-control" id="code_postal" name="code_postal" required>
            </div>
            <div class="form-group">
                <label for="pays">Pays</label>
                <input type="text" class="form-control" id="pays" name="pays" required>
            </div>
            <div class="form-group">
                <label for="numero_telephone">Numéro de Téléphone</label>
                <input type="text" class="form-control" id="numero_telephone" name="numero_telephone" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
