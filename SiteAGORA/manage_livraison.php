<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'header.php';
include 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Récupérer les adresses de livraison de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM Livraison WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Gérer les Adresses de Livraison</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table {
            width: 107%;
        }
    </style>
</head>
<body>
    <div class="container mt-5" style="display: flex; flex-direction: row-reverse;">
        <div class="mt-4">
            <h2>Gérer les Adresses de Livraison</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Adresse 1</th>
                        <th>Adresse 2</th>
                        <th>Ville</th>
                        <th>Code Postal</th>
                        <th>Pays</th>
                        <th>Numéro de Téléphone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['adresse_ligne1']); ?></td>
                            <td><?php echo htmlspecialchars($row['adresse_ligne2']); ?></td>
                            <td><?php echo htmlspecialchars($row['ville']); ?></td>
                            <td><?php echo htmlspecialchars($row['code_postal']); ?></td>
                            <td><?php echo htmlspecialchars($row['pays']); ?></td>
                            <td><?php echo htmlspecialchars($row['numero_telephone']); ?></td>
                            <td>
                                <a href="update_adress.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Modifier</a>
                                <a href="delete_adress.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="add_adress.php" class="btn btn-success">Ajouter une Adresse</a>
        </div>
        
        <?php include 'nav_profile.php'; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
