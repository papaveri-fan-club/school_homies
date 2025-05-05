<?php

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit();
}

// Se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user'];
    $id_post = $_POST['id_post'] ?? null;
    $id_folder = $_POST['folder'] ?? null;

    if (!$id_post || !$id_folder) {
        header('Location: ../profile.php?error=missing_data');
        exit();
    }

    // Inserisci nella tabella foldersnotes
    $query = "INSERT INTO foldersnotes (id_folder, id_post) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_folder, $id_post);

    if ($stmt->execute()) {
        header('Location: ../profile.php?success=post_added_to_folder');
    } else {
        header('Location: ../profile.php?error=add_failed');
    }

    $stmt->close();
    $conn->close();
    exit();
}

?>
<button id="openPopup-<?php echo $postRow['id_post']; ?>">Aggiungi alla cartella</button>

<div id="folderPopup-<?php echo $postRow['id_post']; ?>" style="display:none;">
    <form action="./../gestionePost/addToFolder.php" method="post">
        <input type="hidden" name="id_post" value="<?php echo $postRow['id_post']; ?>">
        <label for="folder">Seleziona una cartella:</label>
        <?php
        if ($resultFolders->num_rows > 0) {
            echo "<select name='folder' id='folder'>";
            while ($folderRow = $resultFolders->fetch_assoc()) {
                $folderName = htmlspecialchars($folderRow['name']);
                $folderType = htmlspecialchars($folderRow['type']);
                echo "<option value='" . $folderRow['id_folder'] . "'>" . $folderName . " (" . $folderType . ")</option>";
            }
            echo "</select>";
        } else {
            echo "Nessuna cartella presente.";
        }
        ?>
        <button type="submit">Aggiungi</button>
    </form>
</div>

<script>
document.getElementById('openPopup-<?php echo $postRow['id_post']; ?>').addEventListener('click', function() {
    document.getElementById('folderPopup-<?php echo $postRow['id_post']; ?>').style.display = 'block';
});
</script>