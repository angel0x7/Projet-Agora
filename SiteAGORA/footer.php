
<style>
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

    footer {
        display: flex;
        animation: fadeIn 1s ease;
        justify-content: center;
    }
</style>

<footer>
    <a class="nav-link" href="faq.php">FAQ</a>
    <a class="nav-link" href="privacy_policy.php">Politique de Confidentialité</a>
    <a class="nav-link" href="terms.php">Conditions Générales d'Utilisation</a>
</footer>
