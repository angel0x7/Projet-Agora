<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Gestion du Compte - La famille</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    session_start();// Démarre la session PHP
    if (!isset($_SESSION['user_id'])) {// Vérifie si l'utilisateur est connecté
        header("Location: login.php");
        exit();
    }
    ?>

    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Gestion du Compte</h2>
        <form action="account_update.php" method="POST">
            <div class="form-group">
                <label for="notifications">Préférences de notification</label>
                <select class="form-control" id="notifications" name="notifications">
                    <option value="all">Recevoir toutes les notifications</option>
                    <option value="email">Seulement par email</option>
                    <option value="sms">Seulement par SMS</option>
                    <option value="none">Ne pas recevoir de notifications</option>
                </select>
            </div>
            <div class="form-group">
                <label for="security">Sécurité du compte</label>
                <input type="password" class="form-control" id="security" name="security" placeholder="Mot de passe actuel" required>
                <input type="password" class="form-control mt-2" id="new_security" name="new_security" placeholder="Nouveau mot de passe">
            </div>
            <button type="submit" class="btn btn-primary"><a ref="account_update.php">Mettre à jour</a></button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
