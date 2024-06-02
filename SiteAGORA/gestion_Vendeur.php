<?php
session_start();
include 'db_connection.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Récupérer les données de l'utilisateur
$user_type = $user['user_type']; // Extraire le type d'utilisateur
$stmt->close();

// Vérifier si l'utilisateur est connecté et s'il est administrateur
if (!isset($_SESSION['user_id']) || $user_type !== 'administrateur') {
    header("Location: login.php");
    exit();
}

// Récupérer la liste des demandes de l'acheteur pour devenir vendeur
$stmt_demandes = $conn->prepare("SELECT * FROM demande_vendeur INNER JOIN users ON demande_vendeur.user_id = users.id");
$stmt_demandes->execute();
$result_demandes = $stmt_demandes->get_result();

// Récupérer la liste des utilisateurs ayant le statut de vendeur
$stmt_vendeurs = $conn->prepare("SELECT * FROM users WHERE user_type = 'vendeur'");
$stmt_vendeurs->execute();
$result_vendeurs = $stmt_vendeurs->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Demandes de Vendeur</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5" style="display: flex;flex-direction: row-reverse;justify-content: space-around;">
        <div class="mt-4">
            <h2>Gestion des Demandes de Vendeur</h2>

            <?php if ($result_demandes->num_rows > 0): ?>
            <h3>Demandes en attente</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Utilisateur</th>
                        <th>Nom Utilisateur</th>
                        <th>Email Utilisateur</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_demandes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <form method="post" action="traitement_demande.php">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                <button type="submit" name="accepter" class="btn btn-success">Accepter</button>
                                <button type="submit" name="refuser" class="btn btn-danger">Refuser</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Aucune demande de vendeur en attente.</p>
            <?php endif; ?>

            <?php if ($result_vendeurs->num_rows > 0): ?>
            <h3>Vendeurs actuels</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Utilisateur</th>
                        <th>Nom Utilisateur</th>
                        <th>Email Utilisateur</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_vendeurs->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <form method="post" action="traitement_demande.php">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="retirer_statut" class="btn btn-danger">Supprimer le vendeur</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Aucun vendeur actuellement.</p>
            <?php endif; ?>
        </div>
        <?php include 'nav_profile.php'; ?>

    </div>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
