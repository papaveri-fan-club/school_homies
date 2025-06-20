<link rel="stylesheet" href="styles/index.css">
<form class="commentForm" action="../priv/gestionePost/addComment.php" method="post">
    <input type="hidden" name="id_post" value="<?php echo $postRow['id_post']; ?>">
    <label for="comment">Commento</label>
    <input type="text" name="comment" id="text" placeholder="Inserisci un commento" class="form-control mb-2">
    <button type="submit" class="btn btn-twitter">Aggiungi Commento</button>
</form>