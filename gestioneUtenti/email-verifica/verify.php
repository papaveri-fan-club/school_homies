<?php
require 'config.php';

if (!isset($_GET['token'])) {
    header("Location: error.html");
    exit;
}

$token = $_GET['token'];

$stmt = $pdo->prepare("SELECT * FROM email_verifications WHERE token = ? AND expires_at > NOW()");
$stmt->execute([$token]);
$verification = $stmt->fetch();

if ($verification) {
    $user_id = $verification['user_id'];

    // Attiva utente
    $pdo->prepare("UPDATE users SET is_verified = 1 WHERE id = ?")->execute([$user_id]);

    // Rimuove token
    $pdo->prepare("DELETE FROM email_verifications WHERE user_id = ?")->execute([$user_id]);

    header("Location: success.html");
} else {
    header("Location: error.html");
}
?>
