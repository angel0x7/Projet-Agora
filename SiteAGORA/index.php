<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        header {
            background-color: #5CB8FF;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .logo {
            width: 350px;
            height: auto;
            margin-right: 20px;
        }
        nav {
            background-color: #444;
            padding: 10px;
        }
        nav ul {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
            justify-content: center;
        }
        nav li {
            margin-right: 50px;
            border-radius: 5px;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: gray;
        }
        .section1 {
            flex-grow: 1;
            padding: 0;
            background-image: url('photopersonne1.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            margin-top: -176px;
        }
        .explore-button {
            background-color: #5CB8FF;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: absolute;
            bottom: 220px;
            margin-left: 350px;
        }
        .explore-button:hover {
            background-color: #479ace;
        }
        .section3 {
            flex-grow: 1;
            padding: 0;
            background-image: url('verife_article.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            margin-top: -350px;
        }
        footer {
            background-color: #333;
            padding: 20px;
            text-align: center;
        }
        footer a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        footer a:hover {
            background-color: #555;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        header, nav, footer {
            animation: fadeIn 1s ease;
        }
        h2 {
            color: white;
        }
        p {
            color: white;
        }
        .carousel-item {
            position: center;
			width: 600px; /* largeur précise */
    height: 400px; /* hauteur précise */
	
    left: 300px;
    border-radius: 10px;
        }
        .carousel-caption {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        .carousel-button {
            background-color: #5CB8FF;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .carousel-button:hover {
            background-color: #479ace;
        }
		.container-carousel {
    display: flex;
    justify-content: center;
}

.carousel {
    width: 80%; /* ajustez la largeur selon vos besoins */
    /* Vous pouvez également utiliser des valeurs spécifiques pour la largeur */
    /* width: 600px; */
    /* ou des valeurs en pourcentage */
    /* width: 80%; */
    margin-left: auto;
    margin-right: auto;
}
        .section2 {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background-color: gray;
            margin-top: -250px;
        }
        .section4 {
            background-color: gray;
            padding: 20px;
            margin-top: 0px;
        }
        .section2 .rectangle {
    margin: 10px; /* Réduire l'espace entre les rectangles */
    background-color: #f7f7f7;
    padding: 50px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 280px;
    height: 400px;
    display: inline-block;
    vertical-align: top;
}
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .col-md-3 {
            width: 23%;
            padding: 10px;
			
        }
        .rectangle h2 {
            font-weight: bold;
            margin-top: 0;
	    color:black;
        }
        .rectangle img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        .rectangle p {
            margin-bottom: 20px;
	    color:black;
        }
        .button {
            background-color: #5CB8FF;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #479ace;
        }
        /* Définition d'un container pour gérer l'affichage */
		.btn-1 {
            padding: 10px 20px;
            border-radius: 25px;
            background-color: #5CB8FF;
            color: white;
            border: none;
            cursor: pointer;
			margin-left: 400px; 
			
            transition: background-color 0.3s ease;
			text-decoration: none; /* Empêche la sous-lignement */
            display: inline-block; /* Ajoute le comportement de bloc pour pouvoir définir une largeur et une hauteur */
            margin-top: 450px; 
        }
        .btn-1:hover {
            background-color: #479ace;
        }

        /* Style du bouton 2 */
        .btn-2 {
            padding: 10px 20px;
            border-radius: 15px;
            background-color: #FF6F61;
            color: white;
            border: none;
            cursor: pointer;
			left:50px;
            transition: background-color 0.3s ease;
			text-decoration: none; /* Empêche la sous-lignement */
            display: inline-block; /* Ajoute le comportement de bloc pour pouvoir définir une largeur et une hauteur */
            margin-top: 50px; 
        }
        .btn-2:hover {
            background-color: #e86054;
        }

        /* Style du bouton 3 */
        .btn-3 {
            padding: 10px 20px;
            border-radius: 25px;
            background-color: #FFD166;
            color: white;
            border: none;
            cursor: pointer;
			margin-left: 500px;
            transition: background-color 0.3s ease;
			text-decoration: none; /* Empêche la sous-lignement */
            display: inline-block; /* Ajoute le comportement de bloc pour pouvoir définir une largeur et une hauteur */
            margin-top: 10px; 
        }
        .btn-3:hover {
            background-color: #f7c759;
        }

        /* Style du bouton 4 */
        .btn-4 {
            padding: 10px 20px;
            border-radius: 35px;
            background-color: #A0D2DB;
            color: white;
            border: none;
            cursor: pointer;
			
            transition: background-color 0.3s ease;
			
            
            
            
            
            
            text-decoration: none; /* Empêche la sous-lignement */
            display: inline-block; /* Ajoute le comportement de bloc pour pouvoir définir une largeur et une hauteur */
            margin-top: 10px; 
        }
        .btn-4:hover {
            background-color: #93c5cf;
        }
    </style>
</head>
<body>
    <!-- En-tête avec barre de navigation -->
    <header>
        <img src="agoralogo.png" alt="Logo Agora" class="logo">
    </header>
    <nav>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="browse.php">Tout Parcourir</a></li>
            <li><a href="#">Notifications</a></li>
            <li><a href="cart.php">Panier</a></li>
            <li><a href="account.php">Votre Compte</a></li>
        </ul>
    </nav>
    <!-- Section avec image de fond -->
    <section class="section1">
        <button class="explore-button">Explorer les articles de créateurs</button>
    </section>
	
    <section class="section3">
	<a href="page1.php" class="btn-1">Vétements</a>
   
    <a href="page2.php" class="btn-2">Mobilié</a><br>
    
    <br><a href="page3.php" class="btn-3">Bijoux</a>
   
    <a href="page4.php" class="btn-4">Electronique</a>
    
	</section>
    <!-- Carrousel de sélection du jour et ventes flash -->
    <section class="section2">
	<h2>Ventes flash</h2>
        	
        <div class="container">
            <div class="row">
                <div class="col-md-3"><br>
                    <div class="rectangle">
                        <h2>High-Tech</h2>
                        <img src="image1.jpg" alt="Image 1">
                        <p>Les meilleurs produits high-tech à petits prix</p>
                        <a href="high-tech.php" class="button">Voir plus</a>
                    </div>
                </div>
                <div class="col-md-3"><br>
                    <div class="rectangle">
                        <h2>Cuisine et maison : pépites à moins de 20€</h2>
                        <img src="image2.jpg" alt="Image 2">
                        <p>Découvrez nos meilleures ventes en cuisine et maison</p>
                        <a href="cuisine-maison.php" class="button">Voir plus</a>
                    </div>
                </div>
                <div class="col-md-3"><br>
                    <div class="rectangle">
                        <h2>Meilleures ventes dans cette catégorie</h2>
                        <img src="image3.jpg" alt="Image 3">
                        <p>Les produits les plus populaires de la semaine</p>
                        <a href="meilleures-ventes.php" class="button">Voir plus</a>
                    </div>
                </div>
                <div class="col-md-3"><br>
                    <div class="rectangle">
                        <h2>Jardin</h2>
                        <img src="image4.jpg" alt="Image 4">
                        <p>Tout pour votre jardin et vos plantes</p>
                        <a href="jardin.php" class="button">Voir plus</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="rectangle">
                        <h2>Les plus demandés dans Jeux vidéo</h2>
                        <img src="image5.jpg" alt="Image 5">
                        <p>Les jeux vidéo les plus populaires du moment</p>
                        <a href="jeux-video.php" class="button">Voir plus</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="rectangle">
                        <h2>Appareils électroménagers</h2>
                        <img src="image6.jpg" alt="Image 6">
                        <p>Tout pour votre cuisine et votre maison</p>
                        <a href="appareils-electromenagers.php" class="button">Voir plus</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="rectangle">
                        <h2>Téléphones portables reconditionnés</h2>
                        <img src="image7.jpg" alt="Image 7">
                        <p>Téléphones portables reconditionnés à petits prix</p>
                        <a href="telephones-portables.php" class="button">Voir plus</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="rectangle">
                        <h2>Nouveaux produits tendance</h2>
                        <img src="image8.jpg" alt="Image 8">
                        <p>Découvrez les nouveaux produits tendance</p>
                        <a href="nouveaux-produits.php" class="button">Voir plus</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section4">
	<h2>Sélection du jour</h2>
	<div id="carouselExampleIndicators" class="carousel slide container-carousel" data-ride="carousel">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="image1.jpg" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First Slide</h5>
                        <p>First slide description.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="image2.jpg" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second Slide</h5>
                        <p>Second slide description.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="image3.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Third Slide</h5>
                        <p>Third slide description.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
		</div>
    </section>
    <div class="chatbot">
        <header>
            <h2>Chatbot</h2>
            <span class="close-btn material-symbols-outlined">close</span>
        </header>
        <ul class="chatbox">
            <li class="chat incoming">
                <span class="material-symbols-outlined">smart_toy</span>
                <p>Hi there 👋
                How can I help you today?</p>
            </li>
        </ul>
        <form>
            <input type="text" id="user-input" placeholder="Type a message...">
            <button id="send-btn">Send</button>
        </form>
    </div>
    <style>
        .chatbot {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            width: 300px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .chatbot-icon {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            z-index: 1000;
        }
        .chatbot header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            border-bottom: 1px solid #333;
        }
        .chatbot header h2 {
            margin: 0;
        }
        .chatbox {
            padding: 20px;
        }
        .chat {
            margin-bottom: 20px;
        }
        .chat.incoming {
            text-align: left;
        }
        .chat.outgoing {
            text-align: right;
        }
        .chat span.material-symbols-outlined {
            font-size: 24px;
            margin-right: 10px;
        }
        .chat p {
            margin: 0;
        }
        form {
            margin-top: 20px;
        }
        #user-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        #send-btn {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        #send-btn:hover {
            background-color: #444;
        }
    </style>
    <script>
        const chatbotBtn = document.getElementById('chatbot-btn');
        const chatbotWindow = document.getElementById('chatbot-window');
        const chatbox = document.getElementById('chatbox');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');
        let conversation = [];
        chatbotBtn.addEventListener('click', () => {
            chatbotWindow.style.display = 'block';
        });
        sendBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const userInputValue = userInput.value.trim();
            if (userInputValue !== '') {
                conversation.push({
                    type: 'outgoing',
                    message: userInputValue
                });
                userInput.value = '';
                updateChatbox();
            }
        });
        function updateChatbox() {
            chatbox.innerHTML = '';
            conversation.forEach((message) => {
                const chatElement = document.createElement('li');
                chatElement.className = `chat ${message.type}`;
                chatElement.innerHTML = `
                    <span class="material-symbols-outlined">${message.type === 'outgoing' ? 'mart_toy' : 'person'}</span>
                    <p>${message.message}</p>
                `;
                chatbox.appendChild(chatElement);
            });
        }
        function respondToUser(message) {
            conversation.push({
                type: 'incoming',
                message: `Hi there! 👋
                I'm happy to help you with ${message}.`
            });
            updateChatbox();
        }
        // Make the chatbot button follow the user as they scroll
        window.addEventListener('scroll', () => {
            chatbotBtn.style.top = `${window.scrollY + 20}px`;
        });
        // Make the chatbot window follow the user as they scroll
        window.addEventListener('scroll', () => {
            chatbotWindow.style.top = `${window.scrollY + 20}px`;
        });
    </script>
    <!-- Section contact avec Google Maps -->
    <footer>
        <section class="container mt-5">
            <h2>Contactez-nous</h2>
            <p>Adresse : 123 Rue de l'Exemple, Paris, France</p>
            <p>Email : contact@agorafrancia.com</p>
            <p>Téléphone : +33 1 23 45 67 89</p>
            <div id="map" style="height: 400px;"></div>
        </section>
        <p>&copy; 2023 Agora Francia</p>
        <a href="#">Mentions légales</a>
        <a href="#">Politique de confidentialité</a>
    </footer>
    <!-- Fin du code HTML -->

    <!-- Script pour initialiser la carte Google Maps -->
    <script>
        function initMap() {
            var location = { lat: 48.8566, lng: 2.3522 }; // Coordonnées de Paris
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>
    <!-- Script pour charger Google Maps API avec votre clé -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
</body>
</html>
