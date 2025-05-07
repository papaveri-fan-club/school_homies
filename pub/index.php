<?php include "../priv/include/start.inc"; ?>
<?php include "../priv/include/connessione.inc"; ?>
<?php session_start(); ?>

<style>
    /* Aggiungi questo al tuo CSS esistente */
    .layout-container {
        display: flex;
        width: 100%;
        margin: 0;
    }
    
    .sidebar {
        width: 250px;
        padding: 20px 0;
        position: sticky;
        top: 0;
        height: 100vh;
    }
    
    .main-content {
        flex: 1;
        padding: 20px;
        border-left: 1px solid #e1e8ed;
        border-right: 1px solid #e1e8ed;
    }
    
    .menu-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin: 0 15px 5px 15px;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: bold;
        color: #0f1419;
        transition: all 0.2s;
    }
    
    .menu-item:hover {
        background-color: #e8f5fe;
        color:rgb(242, 150, 29);
    }
    
    .menu-item i {
        margin-right: 15px;
        font-size: 1.3rem;
    }
    
    .active-menu {
        color:rgb(242, 150, 29);
    }
    
    .logo {
        font-size: 1.8rem;
        color: rgb(242, 150, 29);
        margin-bottom: 30px;
        padding-left: 15px;
    }
    
    .post-button {
        background-color:rgb(242, 150, 29);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 12px 20px;
        font-size: 1rem;
        font-weight: bold;
        width: calc(100% - 30px);
        margin: 20px 15px 0 15px;
        cursor: pointer;
    }
    
    .user-profile {
        display: flex;
        align-items: center;
        margin-top: auto;
        padding: 10px;
        border-radius: 25px;
        position: absolute;
        bottom: 20px;
        left: 15px;
        right: 15px;
    }
    
    .user-profile:hover {
        background-color: #e8f5fe;
    }
    
    /* Nuovo stile per la sezione header */
    .header-section {
        background-color: white;
        padding: 15px 20px;
        border-bottom: 1px solid #e1e8ed;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    
    .header-content {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .header-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .header-subtitle {
        color: #657786;
        font-size: 0.9rem;
    }
</style>

<div class="layout-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-book"></i>
            <img onclick="hihihiha()" src="hihihiha/download.jpg">
        </div>
        
        <a href="index.php" class="menu-item active-menu">
            <i class="fas fa-home"></i> Home
        </a>
        
        <a href="index.php?type_post=1" class="menu-item">
            <i class="fas fa-hashtag"></i> Post
        </a>

        <a href="index.php?type_post=3" class="menu-item">
            <i class="fas fa-bell"></i> Appunti
        </a>

        <a href="index.php?type_post=2" class="menu-item">
            <i class="fas fa-envelope"></i> Eventi
        </a>
        
        <?php if (isset($_SESSION['email'])): ?>
            <button type="button" class="post-button" data-toggle="modal" data-target="#postModal">
                Posta
            </button>
            
            <a href="./profile.php?id_user=<?= $_SESSION['id_user']?>" style="text-decoration: none; color: inherit;">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name'].'+'.$_SESSION['surname']) ?>" 
                         style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                    <div>
                        <strong><?= htmlspecialchars($_SESSION['name']) ?></strong>
                        <div style="color: #657786; font-size: 0.9rem;">@<?= htmlspecialchars(strtolower(str_replace(' ', '', $_SESSION['name']))) ?></div>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    </div>
    
    <!-- Contenuto principale -->
    <div class="main-content">
        <!-- Nuova sezione header -->
        <div class="header-section">
            <div class="header-content">
                <div class="header-title">Welcome to School Homies</div>
                <div class="header-subtitle">Connettiti con i tuoi compagni di scuola</div>
            </div>
        </div>

        <!-- Barra di ricerca -->
        <div style="margin-bottom: 20px;">
            <form method="GET" action="index.php">
                <input type="text" name="search" placeholder="Cerca nei post.." 
                       style="width: 100%; padding: 10px; border: 1px solid #e1e8ed; border-radius: 25px;">
                <button type="submit" style="display: none;">Cerca</button>
            </form>
        </div>
        
        <!-- Mostra i risultati della ricerca o i post normali -->
        <div style="padding-top: 20px;">
            <?php if (isset($_SESSION['email'])): ?>
                <div style="margin-bottom: 20px;">
                    <h2>Benvenuto <?= htmlspecialchars($_SESSION['name']) ?> <?= htmlspecialchars($_SESSION["surname"]) ?></h2>
                </div>
                
                <?php include 'form/formPost.php'; ?>
                <!-- Il resto del tuo contenuto -->
                <?php
                    if (isset($_GET['type_post'])) {
                        $type_post = intval($_GET['type_post']);
                        include '../priv/takeData/takePosts.php'; // Nuovo file per filtrare i post
                        include './showData/showPosts.php';
                    } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
                        include '../priv/takeData/searchPosts.php';
                        include './showData/showPosts.php';
                    } else {
                        include '../priv/takeData/takeposts.php';
                        include './showData/showPosts.php';
                    }
                ?>
                
            <?php else: ?>
                <div style="padding: 20px; background: white; border-radius: 15px; margin-bottom: 20px;">
                    <p>Devi effettuare il login per accedere a questa pagina.</p>
                    <a href='login.php' class="btn-twitter">Login</a>
                    <a href='registrazione.php' class="btn-twitter-outline">Registrati</a>
                </div>
                <?php die(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    function hihihiha() {
        alert("HIHIHIHA");
    }

    document.querySelectorAll('.add-to-folder-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Impedisce il comportamento predefinito del form

            const formData = new FormData(this);
            const postId = this.getAttribute('data-post-id');

            fetch('../../priv/gestionePost/addToFolder.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message); // Mostra il messaggio in un pop-up
                if (data.status === 'success') {
                    document.getElementById('folderPopup-' + postId).style.display = 'none'; // Chiudi il pop-up
                    this.reset(); // Resetta il form
                }
            })
            .catch(error => {
                console.error(error);
                alert('Si è verificato un errore durante l\'operazione.');
            });
        });
    });
</script>

<?php include "../priv/include/end.inc"; ?>