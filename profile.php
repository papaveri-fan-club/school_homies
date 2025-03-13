<?php
session_start();
include "./include/connessione.inc"; // Assicurati di avere una connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
include "./takeData/takeUserData/takeUserInfo.php"; // Recupera le informazioni dell'utente

// Recupera i post dell'utente
//include "./gestioneUtenti/takeUserData/takeUserPosts.php";

// Recupera i commenti dell'utente con le informazioni sui post associati
include "./takeData/takeUserData/takeUserComments.php";
?>
<?php include "./include/start.inc"; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Profilo Utente</title>
</head>
<style>
    .post {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }

    .comment {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

<body>
    <h1>Profilo di <?php echo htmlspecialchars($userInfoResult['email']); ?></h1>
    <a href='gestioneUtenti/logout.php'>Logout</a>
    <h2>Biografia</h2>
    <form method="post" action="updateBio.php">
        <textarea name="bio" rows="5" cols="50"><?php echo htmlspecialchars($userInfoResult['bio']); ?></textarea>
        <button type="submit">Aggiorna Biografia</button>
    </form>

    <h2>I tuoi post</h2>
    <?php
    include "./takeData/takeUserData/takeUserPosts.php";
    include "./takedata/showData/showPosts.php";
    ?>

    <h2>I tuoi commenti</h2>
    <?php while ($comment = $commentsResult->fetch_assoc()): ?>
        <div class="comment">
            <form method="post" action="gestionePost/deleteComment.php" style="display:inline;">
                <small>Post associato: </small></br>
                <div class="post">
                    <?php echo htmlspecialchars($comment['pTitle']); ?>
                    </br><?php echo htmlspecialchars($comment['description']); ?>
                </div>

                <p>commento: <?php echo htmlspecialchars($comment['text']); ?></p>
                <input type="hidden" name="id_comment" value="<?php echo $comment['id_comment']; ?>">
                <button type="submit">Cancella</button>
            </form>

        </div>
    <?php endwhile; ?>
</body>
<?php include "./include/end.inc"; ?>

</html>