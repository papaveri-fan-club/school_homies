<?php
session_start();
include "../priv/include/connessione.inc"; // Assicurati di avere una connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_GET['id_user'] ?? $_SESSION['id_user']; // Ottieni l'ID dell'utente da visualizzare, di default l'ID dell'utente loggato
include "../priv/takeData/takeUserData/takeUserInfo.php"; // Recupera le informazioni dell'utente

// Recupera i post dell'utente
//include "./gestioneUtenti/takeUserData/takeUserPosts.php";

// Recupera i commenti dell'utente con le informazioni sui post associati
include "../priv/takeData/takeUserData/takeUserComments.php";
?>
<?php include "../priv/include/start.inc"; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Profilo Utente</title>
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

        /* Stile per il pop-up */
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: 1px solid #ccc;
            padding: 20px;
            background-color: white;
            z-index: 1000;
        }

        .popup-overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <h1>Profilo di <?php echo htmlspecialchars($userInfoResult['email']); ?></h1>
    <a href='../priv/gestioneUtenti/logout.php'>Logout</a>
    <h2>Biografia</h2>
    <p><?php echo nl2br(htmlspecialchars($userInfoResult['bio'] ?? '')); ?></p>
    <?php if($_SESSION['id_user'] == $id_user): ?>
            <button onclick="openPopup()">Aggiorna Biografia</button>

            <!-- Pop-up per aggiornare la biografia -->
            <div class="popup-overlay" id="popup-overlay"></div>
            <div class="popup" id="popup">
                <h3>Aggiorna Biografia</h3>
                <form method="post" action="updateBio.php">
                    <textarea name="bio" rows="5" cols="50"><?php echo htmlspecialchars($userInfoResult['bio'] ?? ''); ?></textarea>
                    <button type="submit">Salva</button>
                    <button type="button" onclick="closePopup()">Chiudi</button>
                </form>
            </div>
    <?php endif; ?>

    <?php
    // Controlla se l'utente ha i permessi per creare una cartella
    if ($_SESSION['id_user'] == $id_user): ?>
        <button onclick="openFolderPopup()">Crea Cartella</button>

        <!-- Pop-up per creare una cartella -->
        <div class="popup-overlay" id="folder-popup-overlay"></div>
        <div class="popup" id="folder-popup">
            <h3>Crea Cartella</h3>
            <form method="post" action="../priv/gestionePost/createFolder.php">
                <input type="text" name="folder_name" placeholder="Nome della cartella" required>
                <select name="type_folder">
                    <option value="private">Privata</option>
                    <option value="public">Pubblica</option>
                </select>
                <button type="submit">Crea</button>
                <button type="button" onclick="closeFolderPopup()">Chiudi</button>
            </form>
        </div>
    <?php endif; ?>

<h2>Le cartelle di <?= $userInfoResult['name']?></h2>
<?php
include '../priv/takeData/takeUserData/takeFolders.php';

if ($resultFoldersUser->num_rows > 0): ?>
    <ul>
        <?php while ($folder = $resultFoldersUser->fetch_assoc()): ?>
            <li>
                <a href="../priv/gestionePost/viewFolder.php?folder_name=<?php echo urlencode($folder['name']); ?>&id_user=<?php echo $id_user; ?>">
                    <strong>Nome:</strong> <?php echo htmlspecialchars($folder['name']); ?>
                </a>
                <br>
                <strong>Tipo:</strong> 
                <?php echo htmlspecialchars($folder['type']); ?>
                <?php if ($folder['type'] === 'private'): ?>
                    <span style="color: red;">(Privata)</span>
                <?php else: ?>
                    <span style="color: green;">(Pubblica)</span>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>Non hai ancora creato nessuna cartella.</p>
<?php endif; ?>

    <h2>I post di <?= $userInfoResult['name']?></h2>
    <?php
    include "../priv/takeData/takeUserData/takeUserPosts.php";
    include "./showData/showPosts.php";   
?>
    <h2>I commenti di <?= $userInfoResult['name']?></h2>
    <?php while ($comment = $commentsResult->fetch_assoc()): ?>
        <div class="comment">
            <form method="post" action="../priv/gestionePost/deleteComment.php" style="display:inline;">
                <small>Post associato: </small></br>
                <div class="post">
                    <?php echo htmlspecialchars($comment['pTitle']); ?>
                    </br><?php echo htmlspecialchars($comment['description']); ?>
                </div>

                <p>commento: <?php echo htmlspecialchars($comment['text']); ?></p>
                <input type="hidden" name="id_comment" value="<?php echo $comment['id_comment']; ?>">
                <?php
                  if($_SESSION['id_user'] == $id_user){
                    echo "<button type='submit'>Cancella</button>";
                  }?>
            </div>
        </div>
    <?php endwhile; ?>

    <script>
        function openPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('popup-overlay').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('popup-overlay').style.display = 'none';
        }

        function openFolderPopup() {
            document.getElementById('folder-popup').style.display = 'block';
            document.getElementById('folder-popup-overlay').style.display = 'block';
        }

        function closeFolderPopup() {
            document.getElementById('folder-popup').style.display = 'none';
            document.getElementById('folder-popup-overlay').style.display = 'none';
        }
    </script>
<?php include "../priv/include/end.inc"; ?>
</body>

</html>