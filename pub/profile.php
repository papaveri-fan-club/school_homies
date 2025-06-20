<?php
session_start();
include "../priv/include/connessione.inc";

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_GET['id_user'] ?? $_SESSION['id_user']; // Ottieni l'ID dell'utente da visualizzare
include "../priv/takeData/takeUserData/takeUserInfo.php"; // Recupera le informazioni dell'utente
include "../priv/takeData/takeUserData/takeUserComments.php";
include "../priv/takeData/takeUserData/takeFolders.php";
include "../priv/takeData/takeUserData/takeUserPosts.php";
?>
<?php include "../priv/include/start.inc"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Utente</title>
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link CSS Personalizzati -->
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/backgroundStyle.css">
    <link rel="stylesheet" href="styles/index.css"> <!-- Per l'animazione di sfondo -->
    <!-- Rimosso il blocco <style> inline -->
</head>
<body>
    <div class="background-text" id="background-text"></div>

    <header class="profile-page-header">
        <a href="index.php" class="button button--primary">🏠 Home</a>
        <?php if ($_SESSION['id_user'] == $id_user): ?>
            <a href='../priv/gestioneUtenti/logout.php' class="button button--danger">Logout</a>
        <?php endif; ?>
    </header>
    
    <div class="main-container">
        <div class="profile-card">
            <?php // Il pulsante Logout è stato spostato nell'header in alto ?>
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore' && $_SESSION['id_user'] != $id_user): ?>
                <form method="post" action="../priv/gestioneUtenti/deleteUser.php" class="delete-user-form">
                    <input type="hidden" name="id_user" value="<?= $id_user; ?>">
                    <button type="submit" class="button button--danger">Elimina Account</button>
                </form>
            <?php endif; ?>
            <div class="profile-header">
                <h1>Profilo di <?php echo htmlspecialchars($userInfoResult['name'] ?? $userInfoResult['email']); ?></h1>
                <div class="profile-email"><?php echo htmlspecialchars($userInfoResult['email']); ?></div>
            </div>
            
            <div class="bio-content">
                <h2>Biografia</h2>
                <p><?php echo nl2br(htmlspecialchars($userInfoResult['bio'] ?? 'Nessuna biografia inserita')); ?></p>
                <?php if($_SESSION['id_user'] == $id_user): ?>
                    <button class="button button--secondary" onclick="openPopup()">Aggiorna Biografia</button> <!-- Applicate classi da button.css -->
                <?php endif; ?>
            </div>
        </div>

        <!-- Sezione cartelle -->
        <div class="section">
            <h2>Le cartelle di <?= htmlspecialchars($userInfoResult['name'])?></h2>
            
            <?php if($_SESSION['id_user'] == $id_user): ?>
                <button class="button button--primary" onclick="openFolderPopup()">Crea Cartella</button> <!-- Applicate classi da button.css -->
            <?php endif; ?>
            
            <?php if ($resultFoldersUser->num_rows > 0): ?>
                <div class="folder-list">
                    <?php while ($folder = $resultFoldersUser->fetch_assoc()): ?>
                        <div class="folder-item">
                            <a href="../priv/gestionePost/viewFolder.php?folder_name=<?= urlencode($folder['name']); ?>&id_user=<?= $id_user; ?>">
                                <strong><?= htmlspecialchars($folder['name']); ?></strong>
                            </a>
                            
                            <div class="folder-type <?= $folder['type'] === 'private' ? 'type-private' : 'type-public'; ?>">
                                <?= $folder['type'] === 'private' ? 'Privata' : 'Pubblica'; ?>
                            </div>

                            <?php if (isset($folder['id_user']) && ($folder['id_user'] == $_SESSION['id_user'] || (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore' && $folder['type'] === 'public' && $folder['id_user'] != $_SESSION['id_user']))): ?>
                                <form method="post" action="../priv/gestionePost/deleteFolder.php" style="display: inline;">
                                    <input type="hidden" name="id_folder" value="<?= $folder['id_folder']; ?>">
                                    <button type="submit" class="button button--danger button--small">Elimina</button> <!-- Applicate classi da button.css -->
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="no-content">Nessuna cartella creata.</p>
            <?php endif; ?>
        </div>

        <!-- Sezione post -->
        <div class="section">
            <h2>I post di <?= htmlspecialchars($userInfoResult['name'])?></h2>
            <?php include "./showData/showPosts.php"; ?>
        </div>

        <!-- Sezione commenti -->
        <div class="section">
            <h2>I commenti di <?= htmlspecialchars($userInfoResult['name']) ?></h2>
            <?php if ($commentsResult->num_rows > 0): ?>
                <?php while ($comment = $commentsResult->fetch_assoc()): ?>
                    <div class="comment">
                        <p><strong>Post associato:</strong> <?= htmlspecialchars($comment['pTitle']) ?></p>
                        <p><?= htmlspecialchars($comment['text']) ?></p>
                        <form method="post" action="../priv/gestionePost/deleteComment.php">
                            <input type="hidden" name="id_comment" value="<?= $comment['id_comment'] ?>">
                            <?php if ($_SESSION['id_user'] == $id_user || (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore')): ?>
                                <button type="submit" class="button button--danger button--small">Elimina Commento</button> <!-- Applicate classi da button.css -->
                            <?php endif; ?>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-content">Nessun commento pubblicato.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pop-up biografia -->
    <div class="popup-overlay" id="popup-overlay"></div>
    <div class="popup" id="popup">
        <h3>Aggiorna Biografia</h3>
        <form method="post" action="updateBio.php">
            <textarea name="bio" placeholder="Scrivi qualcosa su di te..."><?php echo htmlspecialchars($userInfoResult['bio'] ?? ''); ?></textarea>
            <div class="btn-group">
                <button type="submit" class="button button--primary">Salva</button> <!-- Applicate classi da button.css -->
                <button type="button" class="button button--secondary" onclick="closePopup()">Chiudi</button> <!-- Applicate classi da button.css, rimosso style inline -->
            </div>
        </form>
    </div>

    <!-- Pop-up cartella -->
    <div class="popup-overlay" id="folder-popup-overlay"></div>
    <div class="popup" id="folder-popup">
        <h3>Crea Nuova Cartella</h3>
        <form id="addFolderForm">
            <input type="text" name="folder_name" id="folder_name" placeholder="Nome della cartella" required>
            <select name="type_folder" id="type_folder">
                <option value="private">Privata</option>
                <option value="public">Pubblica</option>
            </select>
            <div class="btn-group">
                <button type="submit" class="button button--primary">Crea</button> <!-- Applicate classi da button.css -->
                <button type="button" class="button button--secondary" onclick="closeFolderPopup()">Chiudi</button> <!-- Applicate classi da button.css, rimosso style inline -->
            </div>
        </form>
        <div id="message"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
            document.getElementById('message').textContent = '';
            document.getElementById('message').className = '';
        }

        // Gestione del form con AJAX
        document.getElementById('addFolderForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('../priv/gestionePost/addFolder.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('message');
                if (data.success) {
                    messageDiv.textContent = data.message;
                    messageDiv.className = 'message-success';
                    setTimeout(() => {
                        closeFolderPopup();
                        location.reload();
                    }, 1500);
                } else {
                    messageDiv.textContent = data.message;
                    messageDiv.className = 'message-error';
                }
            })
            .catch(error => {
                console.error('Errore:', error);
            });
        });

        function deleteFolder(idFolder) {
            if (confirm("Sei sicuro di voler eliminare questa cartella?")) {
                fetch('../priv/gestionePost/deleteFolder.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id_folder: idFolder })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                });
            }
        }

        // La funzione generateBackgroundRows() e i relativi event listener sono stati rimossi da qui.
        // Assicurati che siano presenti in styles/backgroundStyle.js e che il file sia incluso.
    </script>
    <!-- Includi backgroundStyle.js se la funzione generateBackgroundRows è stata spostata lì -->
    <script src="styles/backgroundStyle.js"></script>
<?php include "../priv/include/end.inc"; ?>
</body>
</html>
