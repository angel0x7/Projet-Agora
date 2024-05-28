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
    $stmt = $conn->prepare("SELECT name, email, address, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name, $email, $address, $profile_picture);
    $stmt->fetch();
    $stmt->close();

    // Récupérer les informations des cartes de l'utilisateur
    $stmt = $conn->prepare("SELECT id, card_number, expiry_date FROM user_cards WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cards = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    ?>
    
    <div class="container mt-5">
        <h2>Modifier le Profil</h2>
        <form action="profile_update_process.php" method="POST" enctype="multipart/form-data" id="profileForm">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            </div>
            
            <h3>Cartes enregistrées</h3>
            <div id="cardContainer">
                <?php foreach ($cards as $card): ?>
                    <div class="card-container" data-card-id="<?php echo htmlspecialchars($card['id']); ?>">
                        <div class="card">
                            <img class="chip" src="./img/chip.svg"/>
                            <img class="contactless" src="./img/wifi-signal.svg"/>
                            <img class="visa" src="./img/visa.svg"/>
                            <p class="card-number">
                                <input type="text" class="form-control" name="card_number[]" value="<?php echo htmlspecialchars($card['card_number']); ?>" pattern="[0-9]*" placeholder="Numéro de carte" maxlength="16" required>
                            </p>
                            <div class="arrow"></div>
                            <p class="card-name"><?php echo htmlspecialchars($name); ?></p>
                            <p class="card-expire">
                                <input type="text" class="form-control" name="expiry_date[]" value="<?php echo substr(htmlspecialchars($card['expiry_date']), 0, 2) . substr(htmlspecialchars($card['expiry_date']), 2); ?>" placeholder="Date d'expiration (MM/YY)">
                            </p>
                        </div>
                        <button type="button" class="btn btn-danger remove-card">Supprimer</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-primary" id="addCardButton">Ajouter une carte</button>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add card button functionality
            $("#addCardButton").click(function() {
                var cardHtml = `
                    <div class="card-container">
                        <div class="card">
                            <img class="chip" src="./img/chip.svg"/>
                            <img class="contactless" src="./img/wifi-signal.svg"/>
                            <img class="visa" src="./img/visa.svg"/>
                            <p class="card-number">
                            <input type="text" class="form-control" name="card_number[]" pattern="[0-9]*" placeholder="Numéro de carte" maxlength="16" required>

                            </p>
                            <div class="arrow"></div>
                            <p class="card-name"><?php echo htmlspecialchars($name); ?></p>
                            <p class="card-expire">
                                <input type="text" class="form-control" name="expiry_date[]" placeholder="Date d'expiration (MM/YY)">
                            </p>
                        </div>
                        <button type="button" class="btn btn-danger remove-card">Supprimer</button>
                    </div>
                `;
                $("#cardContainer").append(cardHtml);
            });

            // Remove card button functionality
            $(document).on("click", ".remove-card", function() {
                var cardContainer = $(this).closest(".card-container");
                var cardId = cardContainer.data("card-id");

                if (cardId) {
                    $.ajax({
                        url: 'remove_card.php',
                        type: 'POST',
                        data: { card_id: cardId },
                        success: function(response) {
                            try {
                                var jsonResponse = JSON.parse(response);
                                if (jsonResponse.success) {
                                    cardContainer.remove();
                                } else {
                                    alert('Erreur lors de la suppression de la carte.');
                                }
                            } catch (e) {
                                alert('Erreur lors de la suppression de la carte.');
                            }
                        },
                        error: function() {
                            alert('Erreur lors de la suppression de la carte.');
                        }
                    });
                } else {
                    cardContainer.remove();
                }
            });
        });
    </script>


</body>
</html>
