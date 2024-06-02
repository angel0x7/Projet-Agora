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
    <link rel="stylesheet" href="css/custom_styles.css">
    <style>
        .gestion-carte {
            width: 37%;
            height: 23%;
            margin: 20px;
        }
        ul {
            display: flex;
            flex-wrap: wrap;
        }
        .chip, .contactless, .visa {
            position: absolute;
        }
        .chip {
            top: 35%;
            left: 5%;
            height: 23%;
        }
        .contactless {
            top: 40%;
            left: 20%;
            height: 15%;
            transform: rotate(90deg);
        }
        .visa {
            bottom: -1%;
            right: 5%;
            height: 30%;
        }
        .card-container {
            margin-bottom: 25px;
            border-radius: 10px;
            width: 100%;
            max-width: 300px;
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
        .card-number, .card-name, .card-expire {
            position: absolute;
            font-family: sans-serif;
            color: white;
            text-shadow: 0px 0px 5px black;
        }
        .card-number {
            top: 60%;
            left: 5%;
            font-size: 1.2rem;
        }
        .arrow {
            position: absolute;
            top: 80%;
            left: 5%;
            width: 0; 
            height: 0; 
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent; 
            border-right:10px solid white; 
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
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        .card-expire {
            top: 87%;
            font-size: 0.8rem;
        }
        .card::before, .card::after {
            content: "";
            position: absolute;
            display: inline-block;
            background-color: white;
            opacity: 0.5;
        }
        .card::before {
            width: 50%;
            height: 5%;
            left: 0;
            top: 26%;
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
        }
        .card::after {
            width: 200px;
            height: 200px;
            right: -75px;
            top: -75px;
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

    </style>
</head>
<body>

<div class="container mt-5" style="display: flex; flex-direction: row-reverse;">
    <div class="container mt-4">
        <h2>Mes Cartes</h2>
        <!-- Affichage des cartes -->
        <div class="mt-4">
            <ul>
                <?php foreach ($cards as $card): ?>
                    <div class="gestion-carte" data-card-id="<?php echo $card['id']; ?>">
                        <div class="card-container">
                            <div class="card">
                                <li>
                                    <img class="chip" src="./img/chip.svg" alt="Chip"/>
                                    <img class="contactless" src="./img/wifi-signal.svg" alt="Contactless"/>
                                    <img class="visa" src="./img/visa.svg" alt="Visa"/>
                                    <p class="card-number">XXXX-XXXX-XXXX-<?php echo substr($card['card_number'], -4); ?></p>
                                    <div class="arrow"></div>
                                    <p class="card-name"><?php echo htmlspecialchars($name); ?></p>
                                    <p class="card-expire"><?php echo htmlspecialchars($card['expiry_date']); ?></p>
                                </li>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger remove-card">Supprimer</button>
                        <a href="card_edit.php?card_id=<?php echo $card['id']; ?>" class="btn btn-primary">Modifier la carte</a>
                    </div>
                <?php endforeach; ?>
            </ul>
        </div>

        <div id="newCardContainer"></div>
        
        <a href="add_card.php" class="btn btn-primary">Ajouter une carte</a>
    </div>
  
    <?php include 'nav_profile.php'; ?>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/custom_script.js"></script>
<script>
    $(document).ready(function() {
    
        // Supprimer une nouvelle carte
        $(document).on("click", ".remove-new-card", function() {
            $(this).closest(".new-card-container").remove();
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
                    beforeSend: function() {
                        return confirm("Êtes-vous sûr de vouloir supprimer cette carte ?");
                    },
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

        // Mettre à jour le numéro de carte affiché en temps réel
        $(document).on("input", ".card-number-input", function() {
            var cardNumber = $(this).val();
            var formattedCardNumber = 'XXXX-XXXX-XXXX-' + cardNumber.slice(-4);
            $(this).closest(".new-card-container").find(".card-number").text(formattedCardNumber);
        });
    });

</script>
</body>
</html>
