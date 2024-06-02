<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Profil Utilisateur</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    include 'header.php';
    include 'db_connection.php';

    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT name, email, address, profile_picture, password, background_image FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name, $email, $address, $profile_picture, $mot_passe, $background_image);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    ?>

    <div class="container mt-5" style="display: flex; flex-direction: row-reverse;">
        <div class="container mt-4" style=" background-image: url('<?php echo htmlspecialchars($background_image); ?>'); background-size: cover; background-position: center;">
            <h2>Profil Utilisateur</h2>
            <div class="form-group">
                <label for="profile_picture">Photo de profil</label>
                <?php if ($profile_picture): ?>
                    <div class="mt-2">
                        <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" style="max-width: 100px;">
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($name); ?>" disabled>
            </div>
        
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="email">Mot de passe</label>
                <input type="email" class="form-control" id="mot_passe" name="mot_passe" value="<?php echo htmlspecialchars($mot_passe); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" disabled>
            </div>
            <a href="profile_edit.php" class="btn btn-primary">Modifier le Profil</a>
        </div>
       
      
        <?php include 'nav_profile.php'; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
