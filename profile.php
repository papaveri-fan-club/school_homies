<?php
session_start();
include "./include/connessione.inc";

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
include "./takeData/takeUserData/takeUserInfo.php";
include "./takeData/takeUserData/takeUserComments.php";
?>
<?php include "./include/start.inc"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Profilo Utente</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, rgb(134, 47, 216), rgb(13, 159, 216));
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        
        .main-container {
            width: 100%;
            max-width: 900px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .profile-card {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            position: relative;
        }
        
        .profile-header {
            margin-bottom: 20px;
        }
        
        .profile-header h1 {
            color: #333;
            font-size: 2.2rem;
            margin-bottom: 5px;
        }
        
        .profile-email {
            color: #666;
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .section {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .section h2 {
            color: #444;
            margin-bottom: 20px;
            font-size: 1.6rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            display: inline-block;
        }
        
        .bio-content {
            margin: 20px 0;
            line-height: 1.6;
            color: #555;
            text-align: center;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s;
            margin: 10px 5px;
            display: inline-block;
        }
        
        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .post, .comment {
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin: 15px auto;
            border-radius: 10px;
            background-color: #f9f9f9;
            max-width: 700px;
            text-align: left;
        }
        
        .folder-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .folder-item {
            background-color: #f0f7ff;
            border: 1px solid #d0e3ff;
            padding: 15px;
            border-radius: 10px;
            min-width: 200px;
            text-align: center;
        }
        
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 90%;
            max-width: 500px;
            text-align: center;
        }
        
        .popup h3 {
            color: #444;
            margin-bottom: 20px;
            font-size: 1.4rem;
        }
        
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        textarea, input[type="text"], select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .btn-group {
            margin-top: 20px;
        }
        
        .no-content {
            color: #777;
            font-style: italic;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Riquadro profilo in alto -->
        <div class="profile-card">
            <a href='gestioneUtenti/logout.php' class="logout-btn">Logout</a>
            <div class="profile-header">
                <h1>Profilo di <?php echo htmlspecialchars($userInfoResult['name'] ?? $userInfoResult['email']); ?></h1>
                <div class="profile-email"><?php echo htmlspecialchars($userInfoResult['email']); ?></div>
            </div>
            
            <div class="bio-content">
                <h2>Biografia</h2>
                <p><?php echo nl2br(htmlspecialchars($userInfoResult['bio'] ?? 'Nessuna biografia inserita')); ?></p>
                <button class="btn" onclick="openPopup()">Aggiorna Biografia</button>
            </div>
        </div>

        <!-- Sezione cartelle -->
        <div class="section">
            <h2>Gestione Cartelle</h2>
            <button class="btn" onclick="openFolderPopup()">Crea Nuova Cartella</button>
            
            <div class="folder-list">
                <?php
                $query = "SELECT name, type FROM folders WHERE id_user = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id_user);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0): ?>
                    <?php while ($folder = $result->fetch_assoc()): ?>
                        <div class="folder-item">
                            <strong><?php echo htmlspecialchars($folder['name']); ?></strong><br>
                            <span>Tipo: <?php echo htmlspecialchars($folder['type']); ?></span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-content">Non hai ancora creato nessuna cartella.</p>
                <?php endif; ?>
                <?php $stmt->close(); ?>
            </div>
        </div>

        <!-- Sezione post -->
        <div class="section">
            <h2>I tuoi Post</h2>
            <?php
            include "./takeData/takeUserData/takeUserPosts.php";
            include "./takedata/showData/showPosts.php";
            ?>
        </div>

        <!-- Sezione commenti -->
        <div class="section">
            <h2>I tuoi Commenti</h2>
            <?php if ($commentsResult->num_rows > 0): ?>
                <?php while ($comment = $commentsResult->fetch_assoc()): ?>
                    <div class="comment">
                        <form method="post" action="gestionePost/deleteComment.php">
                            <small>Post associato: </small>
                            <div class="post">
                                <strong><?php echo htmlspecialchars($comment['pTitle']); ?></strong><br>
                                <?php echo htmlspecialchars($comment['description']); ?>
                            </div>
                            <p>Commento: <?php echo htmlspecialchars($comment['text']); ?></p>
                            <input type="hidden" name="id_comment" value="<?php echo $comment['id_comment']; ?>">
                            <button type="submit" class="btn">Cancella Commento</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-content">Non hai ancora pubblicato commenti.</p>
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
                <button type="submit" class="btn">Salva</button>
                <button type="button" class="btn" onclick="closePopup()" style="background-color: #95a5a6;">Chiudi</button>
            </div>
        </form>
    </div>

    <!-- Pop-up cartella -->
    <div class="popup-overlay" id="folder-popup-overlay"></div>
    <div class="popup" id="folder-popup">
        <h3>Crea Nuova Cartella</h3>
        <form method="post" action="addFolder.php">
            <input type="text" id="folder-name" name="folder_name" placeholder="Nome cartella" required>
            <select id="folder-type" name="folder_type" required>
                <option value="" disabled selected>Seleziona tipo</option>
                <option value="public">Pubblica</option>
                <option value="private">Privata</option>
            </select>
            <div class="btn-group">
                <button type="submit" class="btn">Crea</button>
                <button type="button" class="btn" onclick="closeFolderPopup()" style="background-color: #95a5a6;">Annulla</button>
            </div>
        </form>
    </div>

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
</body>
<?php include "./include/end.inc"; ?>
</html>