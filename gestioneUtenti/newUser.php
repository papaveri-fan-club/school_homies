<?php

include "../include/connessione.inc";

$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$user_type = $_POST['user_type'];

// Controlla se l'email è già presente nel database
$stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Email già presente, mostra un messaggio di errore e reindirizza alla pagina di login
    echo "<script>alert('L\'email è già registrata. Per favore, usa un\'altra email o accedi.');</script>";
    echo "<script>window.location.href = '../login.php';</script>";
} else {
    // Cripta la password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Email non presente, inserisci il nuovo utente
    $stmt = $conn->prepare("INSERT INTO users (email, password, name, surname, user_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $hashed_password, $name, $surname, $user_type);
    $stmt->execute();

    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;

    header("location:../index.php");
    exit();
}

include "../include/connessione.inc";

?>