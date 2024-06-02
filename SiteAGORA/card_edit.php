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
            top: 78%;
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

    // Vérifiez si l'ID de la carte est défini dans l'URL
    if (!isset($_GET['card_id'])) {
        // Redirigez l'utilisateur vers une autre page s'il n'y a pas d'ID de carte dans l'URL
        exit();
    }

    $card_id = $_GET['card_id'];

    $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();

    // Préparer et exécuter la requête SQL pour récupérer les détails du produit à modifier
    $stmt = $conn->prepare("SELECT * FROM user_cards WHERE id = ?");
    $stmt->bind_param("i", $card_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $card = $result->fetch_assoc();
    }
  
    $stmt->close();
    $conn->close();
    ?>

    <div class="container mt-5">
        <h2>Modifier la Carte</h2>
        <form action="card_update.php" method="POST" enctype="multipart/form-data" id="profileForm">
            <h3>Carte sélectionnée</h3>
            <div id="cardContainer">
                <input type="hidden" name="card_id" value="<?php echo htmlspecialchars($card_id); ?>">
                <div class="form-group">
                    <label for="card_type">Type de carte</label>
                    <select class="form-control" id="card_type" name="card_type" required>
                        <option value="Visa" <?php if($card['card_type'] == "Visa") echo "selected"; ?>>Visa</option>
                        <option value="MasterCard" <?php if($card['card_type'] == "MasterCard") echo "selected"; ?>>MasterCard</option>
                        <option value="American Express" <?php if($card['card_type'] == "American Express") echo "selected"; ?>>American Express</option>
                        <option value="PayPal" <?php if($card['card_type'] == "PayPal") echo "selected"; ?>>PayPal</option>
                    </select>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img class="chip" src="./img/chip.svg"/>
                        <img class="contactless" src="./img/wifi-signal.svg"/>
                        <img class="visa" src="./img/visa.svg"/>
                        <p class="card-number">
                            <input type="nombre" class="form-control" id="card_number" name="card_number" value="<?php echo htmlspecialchars($card['card_number']); ?>" pattern="[0-9]*" placeholder="Numéro de carte" maxlength="16" required>
                        </p>
                        <div class="arrow"></div>
                        <p class="card-name"><?php echo htmlspecialchars($name); ?></p>
                        <p class="card-expire">
                            <input type="nombre" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo substr(htmlspecialchars($card['expiry_date']), 0, 2) . substr(htmlspecialchars($card['expiry_date']), 2); ?>" placeholder="Date d'expiration (MM/YY)" maxlength="5">
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="securityCode">Code de sécurité</label>
                    <input type="nombre" class="form-control" id="security_code" name="security_code" value="<?php echo htmlspecialchars($card['security_code']); ?>" placeholder="Code de sécurité (3 ou 4 chiffres)" maxlength="4" required>
                </div>
            </div>
            
            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Partie JavaScript pour l'ajout et la suppression de la carte -->
</body>
</html>
