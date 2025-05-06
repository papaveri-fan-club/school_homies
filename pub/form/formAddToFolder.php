<?php
include '../priv/takeData/takeUserData/takeFolders.php';
// Ripristina il puntatore dei risultati di $resultFolders
mysqli_data_seek($resultFolders, 0);
?>
<button id="openPopup-<?php echo $postRow['id_post']; ?>">Aggiungi alla cartella</button>

<div id="folderPopup-<?php echo $postRow['id_post']; ?>" style="display:none;">
    <form class="add-to-folder-form" data-post-id="<?php echo $postRow['id_post']; ?>">
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

// Gestione invio form tramite AJAX
document.querySelectorAll('.add-to-folder-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const postId = this.getAttribute('data-post-id');

        fetch('../../priv/gestionePost/addToFolder.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Errore nella risposta del server.');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message); // Mostra il messaggio in un pop-up
            if (data.status === 'success') {
                document.getElementById('folderPopup-' + postId).style.display = 'none';
            }
        })
        .catch(error => {
            console.error(error);
            alert('Si è verificato un errore durante l\'operazione.');
        });
    });
});
</script>