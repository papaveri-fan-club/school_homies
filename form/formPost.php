<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .btn-primary {
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 10px;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .modal-content {
            border-radius: 20px;
        }
    </style>
</head>
<body>    
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true" style="border-radius: 20px;">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">Crea un nuovo post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../gestionePost/addPost.php" method="POST">
                        <div class="form-group">
                            <label for="title">Titolo</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Inserisci il titolo" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrizione</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Scrivi la descrizione..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Aggiungi post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
