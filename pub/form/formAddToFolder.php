<?php
// Questo blocco recupera le cartelle dell'utente una sola volta.
// Assicurati che la variabile di connessione $conn sia disponibile qui.
$user_folders_for_modal = [];
if (isset($_SESSION['id_user'])) {
    $current_user_id = $_SESSION['id_user'];
    $folder_query = $conn->prepare("SELECT id_folder, name, type FROM folders WHERE id_user = ? ORDER BY name ASC");
    $folder_query->bind_param("i", $current_user_id);
    $folder_query->execute();
    $result = $folder_query->get_result();
    while ($row = $result->fetch_assoc()) {
        $user_folders_for_modal[] = $row;
    }
    $folder_query->close();
}
?>

<!-- Stile CSS per il popup. È identico a quello che avevi già. -->
<style>
    .folder-modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(20, 23, 26, 0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); align-items: center; justify-content: center; animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .folder-modal .dialog { width: 100%; max-width: 400px; margin: 1rem; }
    .folder-modal .modal-content { background-color: #ffffff; border-radius: 16px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); overflow: hidden; }
    .folder-modal .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #e9ecef; }
    .folder-modal .modal-title { font-size: 1.1rem; font-weight: 600; color: #333; }
    .folder-modal .modal-title i { color: #6a11cb; margin-right: 10px; }
    .folder-modal .close-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background-color: #f0f2f5; border: none; border-radius: 50%; color: #6c757d; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; }
    .folder-modal .close-btn:hover { background-color: #e2e6ea; color: #343a40; }
    .folder-modal .modal-body { padding: 20px; }
    .folder-modal .form-group label { font-weight: 500; margin-bottom: 8px; display: block; color: #555; font-size: 0.9rem; }
    .folder-modal .form-control { display: block; width: 100%; padding: 10px 12px; font-size: 1rem; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; }
    .folder-modal .modal-footer { padding: 16px 20px; border-top: 1px solid #e9ecef; background-color: #f8f9fa; text-align: right; }
    .folder-modal .btn { padding: 10px 25px; font-weight: 600; border-radius: 50px; transition: all 0.3s ease; border: none; cursor: pointer; }
    .folder-modal .btn-primary { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white; }
    .folder-modal .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3); }
</style>

<!-- Popup generico a tutto schermo, con un ID statico -->
<div id="globalFolderModal" class="folder-modal">
    <div class="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-folder-plus"></i> Aggiungi a cartella</h5>
                <button type="button" class="close-btn" id="globalFolderModalCloseBtn" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form action="../priv/gestionePost/addToFolder.php" method="POST">
                <div class="modal-body">
                    <!-- Questo input nascosto riceverà l'ID del post da JavaScript -->
                    <input type="hidden" name="id_post" id="modal_post_id_input" value="">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                    <div class="form-group">
                        <label for="modal_folder_select">Seleziona cartella:</label>
                        <select name="folder" id="modal_folder_select" class="form-control" required>
                            <?php foreach ($user_folders_for_modal as $folder): ?>
                                <option value="<?= $folder['id_folder'] ?>"><?= htmlspecialchars($folder['name']) ?> (<?= htmlspecialchars($folder['type']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Conferma</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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

// Apertura modal per il popup specifico del post
document.querySelectorAll('[id^="openPopup-"]').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const postId = this.id.split('-')[1];
        document.getElementById('modal_post_id_input').value = postId; // Imposta l'ID del post nel campo nascosto
        openModal('globalFolderModal');
    });
});

// Chiusura modal globale
document.getElementById('globalFolderModalCloseBtn').addEventListener('click', function() {
    closeModal('globalFolderModal');
});
</script>
