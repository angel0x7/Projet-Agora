<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Modifier le Profil</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-container {
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            position: relative;
            box-shadow: 0px 0px 10px 5px rgba(0,0,0,0.1); 
            border-bottom: 6px solid #2c3e50;
            border-right: 6px solid #2c3e50;
            margin-bottom: 20px;
        }

        .card {
            background-color: rgb(52 73 94); 
            position: relative;
            padding-top: 60%;
            overflow: hidden;
            border-radius: 10px;
        }

        .chip {
            position: absolute;
            top: 35%;
            left: 5%;
            height: 23%;
        }

        .contactless {
            position: absolute;
            top: 40%;
            left: 20%;
            height: 15%;
            transform: rotate(90deg);
        }

        .visa {
            position: absolute;
            bottom: -1%;
            right: 5%;
            height: 30%;
        }

        .card-number {
            position: absolute;
            top: 60%;
            left: 5%;
            font-size: 2.5rem;
            font-family: sans-serif;
            color: white;
            text-shadow: 0px 0px 5px black;
        }

        .arrow {
            position: absolute;
            top: 80%;
            left: 5%;
            width: 0; 
            height: 0; 
            border-top: 20px solid transparent;
            border-bottom: 20px solid transparent; 
            border-right:17px solid white; 
        }

        .card-name, .card-expire {
            position: absolute;
            left: 10%;
            font-family: sans-serif;
            color: white;
            text-transform: uppercase;
            text-shadow: 0px 0px 3px black;
        }

        .card-name {
            top: 79%;
            font-size: 1.3rem;
        }

        .card-expire {
            top: 86%;
            font-size: 1rem;
        }

        .card::before {
            content: "";
            position: absolute;
            display: inline-block;
            background-color: white;
            width: 50%;
            height: 5%;
            left: 0;
            top: 26%;
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
            opacity: 0.5;
        }

        .card::after {
            content: "";
            position: absolute;
            display: block;
            background-color: white;
            width: 200px;
            height: 200px;
            right: -75px;
            top:-75px;
            border-radius: 50%;
            opacity: 0.05;
        }
    </style>
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
    
    <div class="container mt-5">
        <h2>Modifier le Profil</h2>
        <form action="profile_update_process.php" method="POST" enctype="multipart/form-data" id="profileForm">
            <div class="form-group">
                <label for="profile_picture">Nouvelle Photo de Profil:</label>
                <input type="file" class="form-control-file" id="profile_picture" name="profile_picture" accept="image/*">
                <?php if ($profile_picture): ?>
                    <div><img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Photo de Profil" width="100"></div>
                    <input type="hidden" name="existing_profile_picture" value="<?php echo htmlspecialchars($profile_picture); ?>">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="background_image">Nouvelle Image de Fond:</label>
                <input type="file" class="form-control-file" id="background_image" name="background_image" accept="image/*">
                <?php if ($background_image): ?>
                    <div><img src="<?php echo htmlspecialchars($background_image); ?>" alt="Image de Fond" width="100"></div>
                    <input type="hidden" name="existing_background_image" value="<?php echo htmlspecialchars($background_image); ?>">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="mot_passe">Mot de passe</label>
                <input type="password" class="form-control" id="mot_passe" name="mot_passe" value="<?php echo htmlspecialchars($mot_passe); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
