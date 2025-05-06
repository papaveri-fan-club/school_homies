<?php
session_start();
include "..//include/connessione.inc"; // Connessione al database

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
$query = "SELECT id_folder FROM folders WHERE id_user = ? AND name = ?";
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

// Recupera gli appunti associati alla cartella
$query = "SELECT p.title, p.description 
          FROM posts p
          INNER JOIN foldersnotes fn ON p.id_post = fn.id_post
          WHERE fn.id_folder = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_folder);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Appunti in <?php echo htmlspecialchars($folder_name); ?></title>
</head>
<body>
    <h1>Appunti in "<?php echo htmlspecialchars($folder_name); ?>"</h1>
    <a href="../../pub/profile.php">Torna al profilo</a>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($note = $result->fetch_assoc()): ?>
                <li>
                    <strong><?php echo htmlspecialchars($note['title']); ?>:</strong>
                    <p><?php echo nl2br(htmlspecialchars($note['description'])); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Non ci sono appunti in questa cartella.</p>
    <?php endif; ?>
    <?php $stmt->close(); ?>
</body>
</html>