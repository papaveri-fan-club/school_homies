<link href="path/to/local/bootstrap.min.css" rel="stylesheet">

<!-- Includi jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Includi Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<?php
if ($resultPosts->num_rows > 0): ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Data</th>
                <th>Titolo</th>
                <th>Descrizione</th>
                <th>Autore</th>
                <th>Commenti</th>
            </tr>    
        </thead>    
        <tbody>
            <?php while ($postRow = $resultPosts->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($postRow['date']) ?></td>
                    <td><?= htmlspecialchars($postRow['title']) ?></td>
                    <td>
                        <?= htmlspecialchars($postRow['description']) ?>
                        <?php if ($postRow['type_post'] == 2): ?>
                            <br>Data evento: <?= htmlspecialchars($postRow['date_event']) ?>
                            <?php include "./takeData/takePartecipants.php"; ?>
                            <br>Partecipanti:
                            <?php while ($partecipantRow = $partecipantResult->fetch_assoc()): ?>
                                <?= htmlspecialchars($partecipantRow['name']) ?> <?= htmlspecialchars($partecipantRow['surname']) ?>;
                            <?php endwhile; ?>    
                            <form class="partecipateForm" method="post">
                                <input type="hidden" name="id_event" value="<?= $postRow['id_post'] ?>">
                                <input type="hidden" name="id_partecipant" value="<?= $_SESSION['id_user'] ?>">
                                <button>Partecipa</button>
                            </form>    

                            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Successo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>    
                                        </div>    
                                        <div class="modal-body">
                                            I tuoi dati sono stati inviati correttamente!
                                        </div>    
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                        </div>    
                                    </div>    
                                </div>    
                            </div>    

                        <?php elseif ($postRow['type_post'] == 3): ?>
                            <br>Extra field 3: <?= htmlspecialchars($postRow['extra_field_3']) ?>
                        <?php endif; ?>    
                    </td>    
                    <td><?= htmlspecialchars($postRow['name']) ?></td>
                    <td>
                        <?php include "./takeData/showData/showComments.php"; ?>
                        <?php include "./form/formComment.php"; ?>
                    </td>    
                </tr>    
            <?php endwhile; ?>    
        </tbody>    
    </table>    
<?php else: ?>
    <p>Nessun post presente.</p>
<?php endif; ?>    


<script>
$(document).ready(function() {
    // Quando il form viene inviato
    // When the form is submitted
    $(document).on("submit", ".partecipateForm", function(e) {
        e.preventDefault(); // Evita il comportamento di submit normale

        var formData = $(this).serialize(); // Raccogli i dati del form

        // Esegui una richiesta AJAX
        $.ajax({
            url: "./gestionePost/addPartecipantEvent.php", // Il file PHP che gestisce l'elaborazione del form
            method: "POST", // Metodo di invio dei dati
            data: formData, // Dati del form
            success: function(response) {
                // Se il server risponde con successo
                // Mostra la modale di successo
                $('#successModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert("There was an error processing the form.");
                alert("C'è stato un errore nel processamento del form.");
            }
        });
    });
});

</script>