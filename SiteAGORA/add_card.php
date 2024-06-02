<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    include 'header.php';
    include 'db_connection.php';

    $user_id = $_SESSION['user_id'];  // Assurez-vous d'avoir cette ligne pour définir $user_id

    $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name);
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Profil Utilisateur</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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

        .card-container {
            margin-bottom: 25px;
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            position: relative;
            box-shadow: 0px 0px 10px 5px rgba(0,0,0,0.1); 
            border-bottom: 6px solid #2c3e50;
            border-right: 6px solid #2c3e50;
        }

        .card {
            background-color: rgb(52 73 94); 
            position: relative;
            padding-top: 60%;
            overflow: hidden;
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

        .new-card {
            background-color: rgb(52 73 94); 
            position: relative;
            padding-top: 60%;
            overflow: hidden;
            margin-bottom: 25px;
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            position: relative;
            box-shadow: 0px 0px 10px 5px rgba(0,0,0,0.1); 
            border-bottom: 6px solid #2c3e50;
            border-right: 6px solid #2c3e50;
        }
        .type, .security-code-input{
            width: 55%;
        }

    </style>
</head>
<body>

    <div class="container mt-5" style="display: flex; flex-direction: row-reverse;">
        <div class="container mt-4">
            <h2>Ma Nouvelle Carte</h2>
            <div class="new-card-container">
                <div class="form-group">
                    <label for="cardType">Type de carte</label>
                    <select class="form-control type" name="card_type[]" required>
                        <option value="Visa">Visa</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="American Express">American Express</option>
                        <option value="PayPal">PayPal</option>
                    </select>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img class="chip" src="./img/chip.svg"/>
                        <img class="contactless" src="./img/wifi-signal.svg"/>
                        <img class="visa" src="./img/visa.svg"/>
                        <p class="card-number">
                            <input type="nombre" class="form-control card-number-input" name="card_number[]" placeholder="Numéro de carte" maxlength="16" required>
                        </p>
                        <div class="arrow"></div>
                        <p class="card-name"><?php echo htmlspecialchars($name); ?></p>
                        <p class="card-expire">
                            <input type="nombre" class="form-control" name="expiry_date[]" placeholder="Date d'expiration (MM/YY)" required>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="securityCode">Code de sécurité</label>
                    <input type="nombre" class="form-control security-code-input" name="security_code[]" placeholder="Code de sécurité (3 ou 4 chiffres)" maxlength="4" required>
                </div>
                
                <button type="button" class="btn btn-danger remove-new-card">Supprimer</button>
                <button type="button" class="btn btn-primary validate-new-card">Valider</button>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            // Valider une nouvelle carte
            $(document).on("click", ".validate-new-card", function() {
                var cardContainer = $(this).closest(".new-card-container");
                var cardType = cardContainer.find("[name='card_type[]']").val();
                var cardNumber = cardContainer.find("[name='card_number[]']").val();
                var expiryDate = cardContainer.find("[name='expiry_date[]']").val();
                var securityCode = cardContainer.find("[name='security_code[]']").val();

                // Envoi des données au serveur via une requête AJAX
                $.ajax({
                    url: 'save_card.php', // URL du script serveur pour sauvegarder la carte
                    type: 'POST',
                    data: {
                        card_type: cardType,
                        card_number: cardNumber,
                        expiry_date: expiryDate,
                        security_code: securityCode
                    },
                    success: function(response) {
                        // Gérer la réponse du serveur ici
                        window.location.href = 'manege_card.php';
                    },
                    error: function() {
                        alert('Erreur lors de la sauvegarde de la carte.');
                    }
                });
            });

            // Supprimer une nouvelle carte
            $(document).on("click", ".remove-new-card", function() {
                $(this).closest(".new-card-container").remove();
                window.location.href = 'manege_card.php';
            });

            $(document).on("click", ".remove-card", function() {
                var cardContainer = $(this).closest(".gestion-carte");
                var cardId = cardContainer.data("card-id");

                if (cardId) {
                    console.log("Attempting to delete card with ID:", cardId);
                    $.ajax({
                        url: 'remove_card.php',
                        type: 'POST',
                        data: { card_id: cardId },
                        success: function(response) {
                            console.log("Response from server:", response);
                            try {
                                var jsonResponse = JSON.parse(response);
                                if (jsonResponse.success) {
                                    cardContainer.remove();
                                } else {
                                    alert(jsonResponse.message || 'Erreur lors de la suppression de la carte.');
                                }
                            } catch (e) {
                                console.error("Error parsing JSON response:", e);
                                alert('Erreur lors de la suppression de la carte.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error:", status, error);
                            alert('Erreur lors de la suppression de la carte.');
                        }
                    });
                } else {
                    console.warn("No card ID found. Removing card from UI only.");
                    cardContainer.remove();
                }
            });
        });
    </script>
</body>
</html>
