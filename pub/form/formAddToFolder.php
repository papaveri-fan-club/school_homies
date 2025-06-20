<?php
if (!isset($resultFolders) || !$resultFolders instanceof mysqli_result) {
    echo "Errore: Nessuna cartella disponibile.";
    return;
}

mysqli_data_seek($resultFolders, 0);
?>

<!-- Icona del bookmark -->
<button class="action-btn add-to-folder-btn" id="openPopup-<?php echo $postRow['id_post']; ?>" title="Aggiungi a cartella">
    <i class="far fa-bookmark"></i>
</button>

<!-- Popup a tutto schermo -->
<div id="folderPopup-<?php echo $postRow['id_post']; ?>" class="folder-modal" style="display: none;">
    <div class="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-folder-plus"></i> Aggiungi a cartella
                </h5>
                <button type="button" class="close-btn" onclick="closeModal('folderPopup-<?php echo $postRow['id_post']; ?>')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../priv/gestionePost/addToFolder.php" method="POST" class="folder-form">
                    <input type="hidden" name="id_post" value="<?php echo $postRow['id_post']; ?>">
                    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                    
                    <div class="form-group">
                        <label for="folderSelect-<?php echo $postRow['id_post']; ?>">Seleziona cartella:</label>
                        <?php if ($resultFolders->num_rows > 0): ?>
                            <select name="folder" id="folderSelect-<?php echo $postRow['id_post']; ?>" class="form-control" required>
                                <?php while ($folderRow = $resultFolders->fetch_assoc()): ?>
                                    <option value="<?= $folderRow['id_folder'] ?>">
                                        <?= htmlspecialchars($folderRow['name']) ?> (<?= htmlspecialchars($folderRow['type']) ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        <?php else: ?>
                            <div class="alert alert-info">Nessuna cartella disponibile</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="modal-footer" style="justify-content: center;">
                        <?php if ($resultFolders->num_rows > 0): ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Conferma
                            </button>
                        <?php else: ?>
                            <a href="createFolder.php" class="btn btn-secondary">
                                <i class="fas fa-folder-plus"></i> Crea cartella
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Apertura modal
document.getElementById('openPopup-<?php echo $postRow['id_post']; ?>').addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    openModal('folderPopup-<?php echo $postRow['id_post']; ?>');
});

// Funzioni globali per gestire i modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'block';
    document.body.classList.add('modal-open'); // Rimuoviamo overflow: hidden
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
    document.body.classList.remove('modal-open'); // Rimuoviamo overflow: hidden
}
</script>
