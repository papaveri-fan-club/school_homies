<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit();
}

$id_user = $_GET['id_user'];
$folder_name = $_GET['folder_name'] ?? '';

if (empty($folder_name)) {
    echo "Cartella non specificata.";
    exit();
}

// Recupera l'ID della cartella
$query = "SELECT id_folder, type FROM folders WHERE id_user = ? AND name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $id_user, $folder_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Cartella non trovata.";
    exit();
}

$folder = $result->fetch_assoc();
$id_folder = $folder['id_folder'];
$folder_type = $folder['type'] ?? 'public';

// Recupera gli appunti associati alla cartella
$query = "SELECT p.id_post, p.title, p.description 
          FROM posts p
          INNER JOIN foldersnotes fn ON p.id_post = fn.id_post
          WHERE fn.id_folder = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_folder);
$stmt->execute();
$result = $stmt->get_result();

// Recupera il nome dell'utente proprietario della cartella
$query_user = "SELECT name, email FROM users WHERE id_user = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $id_user);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user_info = $user_result->fetch_assoc();
$user_name = $user_info['name'] ?? $user_info['email'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appunti in <?php echo htmlspecialchars($folder_name); ?></title>
    <link rel="stylesheet" href="../../pub/styles/viewFolder.css">
    <link rel="stylesheet" href="../../pub/styles/index.css">
    <link rel="stylesheet" href="../../pub/styles/backgroundStyle.css">
    <link rel="stylesheet" href="../../pub/styles/button.css">
</head>
<body>
    <div class="background-text" id="background-text"></div>

    <a href="../../pub/profile.php?id_user=<?php echo $id_user; ?>" class="back-btn">⬅️ Torna al profilo</a>
    
    <div class="main-container" style="width: 100%; max-width: 900px; margin: 0 auto;">
        <!-- Intestazione della cartella -->
        <div class="folder-card">
            <div class="folder-header">
                <h1>Cartella "<?php echo htmlspecialchars($folder_name); ?>"</h1>
                <div class="folder-owner">di <?php echo htmlspecialchars($user_name); ?></div>
            </div>
            
            <div class="folder-type-badge folder-<?php echo $folder_type; ?>">
                <?php echo $folder_type === 'private' ? 'Cartella Privata' : 'Cartella Pubblica'; ?>
            </div>
        </div>

        <!-- Sezione appunti -->
        <div class="notes-section">
            <h2>Appunti</h2>
            
            <?php if ($result->num_rows > 0): ?>
                <ul class="note-list">
                    <?php while ($note = $result->fetch_assoc()): ?>
                        <li class="note-item">
                            <div class="note-title">
                                <!-- MODIFICA: Il titolo ora è un link e la descrizione è stata rimossa -->
                                <a href="../../pub/viewPost.php?id_post=<?php echo $note['id_post']; ?>" class="note-title-link">
                                    <?php echo htmlspecialchars($note['title']); ?>
                                </a>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="no-notes">Non ci sono appunti in questa cartella.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php 
    $stmt->close();
    $stmt_user->close();
    ?>
    <script src="../../pub/styles/backgroundStyle.js"></script>
</body>
</html>