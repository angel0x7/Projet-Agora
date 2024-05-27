<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    if ($stmt === false) {
        die('Erreur de préparation de la requête : ' . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $name, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        echo "Mot de passe haché récupéré : " . $hashed_password . "<br>";
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            header("Location: index.php");
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Email incorrect.";
    }
    $stmt->close();
    $conn->close();
}
?>
