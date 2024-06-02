<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'header.php';
include 'db_connection.php';

$user_id = $_SESSION['user_id'];
$livraison_id = isset($_GET['id']) ? $_GET['id'] : null;

// Initialiser les variables pour stocker les données de l'adresse de livraison
$adresse_ligne1 = '';
$adresse_ligne2 = '';
$ville = '';
$code_postal = '';
$pays = '';
$numero_telephone = '';

// Si un ID de livraison est fourni dans l'URL, récupérer les détails de l'adresse de livraison
if ($livraison_id) {
    $stmt = $conn->prepare("SELECT * FROM Livraison WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $livraison_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $livraison = $result->fetch_assoc();
    $stmt->close();

    // Vérifier si une adresse de livraison correspondante a été trouvée
    if (!$livraison) {
        echo "Adresse de livraison non trouvée.";
        exit();
    }

    // Remplir les variables avec les données de l'adresse de livraison
    $adresse_ligne1 = $livraison['adresse_ligne1'];
    $adresse_ligne2 = $livraison['adresse_ligne2'];
    $ville = $livraison['ville'];
    $code_postal = $livraison['code_postal'];
    $pays = $livraison['pays'];
    $numero_telephone = $livraison['numero_telephone'];
}

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $adresse_ligne1 = $_POST['adresse_ligne1'];
    $adresse_ligne2 = $_POST['adresse_ligne2'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];
    $numero_telephone = $_POST['numero_telephone'];

    // Si un ID de livraison est fourni dans l'URL, mettre à jour l'adresse de livraison existante
    if ($livraison_id) {
        $stmt = $conn->prepare("UPDATE Livraison SET adresse_ligne1 = ?, adresse_ligne2 = ?, ville = ?, code_postal = ?, pays = ?, numero_telephone = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $adresse_ligne1, $adresse_ligne2, $ville, $code_postal, $pays, $numero_telephone, $livraison_id);
    } else {
        // Sinon, insérer une nouvelle adresse de livraison pour l'utilisateur actuel
        $stmt = $conn->prepare("INSERT INTO Livraison (user_id, adresse_ligne1, adresse_ligne2, ville, code_postal, pays, numero_telephone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $user_id, $adresse_ligne1, $adresse_ligne2, $ville, $code_postal, $pays, $numero_telephone);
    }

    // Exécuter la requête préparée
    if ($stmt->execute()) {
        if ($livraison_id) {
            echo "Adresse de livraison mise à jour avec succès.";
        } else {
            echo "Nouvelle adresse de livraison ajoutée avec succès.";
        }
        $stmt->close();
        $conn->close();
        header("Location: manage_livraison.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout ou de la mise à jour de l'adresse de livraison.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - <?php echo $livraison_id ? 'Modifier' : 'Ajouter'; ?> une Adresse de Livraison</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2><?php echo $livraison_id ? 'Modifier' : 'Ajouter'; ?> une Adresse de Livraison</h2>
        <form method="post">
            <div class="form-group">
                <label for="adresse_ligne1">Adresse Ligne 1</label>
                <input type="text" class="form-control" id="adresse_ligne1" name="adresse_ligne1" value="<?php echo htmlspecialchars($adresse_ligne1); ?>" required>
            </div>
            <div class="form-group">
                <label for="adresse_ligne2">Adresse Ligne 2</label>
                <input type="text" class="form-control" id="adresse_ligne2" name="adresse_ligne2" value="<?php echo htmlspecialchars($adresse_ligne2); ?>">
            </div>
            <div class="form-group">
                <label for="ville">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" value="<?php echo htmlspecialchars($ville); ?>" required>
            </div>
            <div class="form-group">
                <label for="code_postal">Code Postal</label>
                <input type="text" class="form-control" id="code_postal" name="code_postal" value="<?php echo htmlspecialchars($code_postal); ?>" required>
            </div>
            <div class="form-group">
                <label for="pays">Pays</label>
                <input type="text" class="form-control" id="pays" name="pays" value="<?php echo htmlspecialchars($pays); ?>" required>
            </div>
            <div class="form-group">
                <label for="numero_telephone">Numéro de Téléphone</label>
                <input type="text" class="form-control" id="numero_telephone" name="numero_telephone" value="<?php echo htmlspecialchars($numero_telephone); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $livraison_id ? 'Modifier' : 'Ajouter'; ?> Adresse</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
