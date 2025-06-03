<?php include "../priv/include/start.inc"; ?>
<?php include "../priv/include/connessione.inc"; ?>
<?php session_start(); ?>

<!-- Link Bootstrap CSS (se non già in start.inc) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- I TUOI CSS -->
<link rel="stylesheet" href="styles/sidebar.css"> <!-- Assicurati che il percorso sia corretto -->
<link rel="stylesheet" href="styles/index.css"> <!-- Il nuovo file CSS per la pagina index -->
<link rel="stylesheet" href="styles/backgroundStyle.css"> <!-- Link al CSS dello sfondo animato -->

<!-- ...eventuali altri tag <head> come meta, title, ecc., se non gestiti da start.inc -->
<!-- Se start.inc non chiude </head>, fallo qui -->
</head> 

<body>
    <!-- Sfondo con testo a mattoni -->
    <div class="background-text" id="background-text"></div>
    
    <button class="hamburger-menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="layout-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-book"></i>
                <img class="hihihiha"  src="hihihiha/download.jpg" alt="School Homies Logo">
                <img class="hihihiha"  src="../priv/uploads/images/anneclank.jpg" alt="School Homies Logo">
            </div>
            
            <a href="index.php" class="menu-item <?= !isset($_GET['type_post']) && !isset($_GET['search']) ? 'active-menu' : '' ?>">
                <i class="fas fa-home"></i> Home
            </a>
            
            <a href="index.php?type_post=1" class="menu-item <?= isset($_GET['type_post']) && $_GET['type_post'] == 1 ? 'active-menu' : '' ?>">
                <i class="fas fa-hashtag"></i> Post
            </a>

            <a href="index.php?type_post=3" class="menu-item <?= isset($_GET['type_post']) && $_GET['type_post'] == 3 ? 'active-menu' : '' ?>">
                <i class="fas fa-book-open"></i> Appunti
            </a>

            <a href="index.php?type_post=2" class="menu-item <?= isset($_GET['type_post']) && $_GET['type_post'] == 2 ? 'active-menu' : '' ?>">
                <i class="fas fa-calendar-alt"></i> Eventi
            </a>
            <a href="scoreboard.php" class="menu-item">
                <i class="fas fa-trophy"></i> Classifica
            </a>
            
            <?php if (isset($_SESSION['email'])): ?>
                <button type="button" class="post-button" data-bs-toggle="modal" data-bs-target="#postModal">
                    <i class="fas fa-pen"></i> Crea nuovo post
                </button>
                
                <a href="./profile.php?id_user=<?= $_SESSION['id_user']?>" style="text-decoration: none; color: inherit;">
                    <div class="user-profile">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name'].'+'.$_SESSION['surname']) ?>" 
                             style="width: 45px; height: 45px; border-radius: 50%; margin-right: 12px;">
                        <div>
                            <strong><?= htmlspecialchars($_SESSION['name']) ?> <?= htmlspecialchars($_SESSION['surname']) ?></strong>
                            <div style="color: #657786; font-size: 0.9rem;">@<?= htmlspecialchars(strtolower(str_replace(' ', '', $_SESSION['name']))) ?></div>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Contenuto principale -->
        <div class="main-content">
            <!-- Header unificato con barra di ricerca -->
            <div class="header-section">
                <div class="header-content">
                    <div>
                        <div class="header-title">
                            <i class="fa-solid fa-book"></i> School Homies
                        </div>
                        <div class="header-subtitle">Connettiti con i tuoi compagni di scuola</div>
                    </div>
                    
                    <div class="search-container">
                        <form method="GET" action="index.php">
                            <input type="text" name="search" placeholder="Cerca nei post..." class="search-input">
                            <button type="submit" style="display: none;">Cerca</button> <!-- Bottone nascosto per invio con Enter -->
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Banner di benvenuto -->
            <?php if (isset($_SESSION['welcome']) && $_SESSION['welcome'] === true): ?>
                <div id="welcome-banner" class="alert alert-welcome">
                    Benvenuto <?= htmlspecialchars($_SESSION['name']) ?>
                </div>
                <?php unset($_SESSION['welcome']); ?>
            <?php endif; ?>
            
            <!-- Contenitore dei post -->
            <div class="posts-container">
                <?php if (isset($_SESSION['email'])): ?>
                    <?php include 'form/formPost.php'; ?>      
                    <?php
                        if (isset($_GET['type_post'])) {
                            $type_post = intval($_GET['type_post']);
                            include '../priv/takeData/takePosts.php';
                            include './showData/showPosts.php';
                        } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
                            include '../priv/takeData/searchPosts.php'; // Assicurati che questo script gestisca la ricerca
                            include './showData/showPosts.php';
                        } else { // Pagina Home di default
                            include '../priv/takeData/takePosts.php';
                            include './showData/showPosts.php';
                        }
                    ?>
                    
                <?php else: ?>
                    <div class="message-box">
                        <p>Devi effettuare il login per accedere a questa pagina.</p>
                        <div style="margin-top: 15px;">
                            <a href='login.php' class="btn-twitter">Login</a>
                            <a href='registrazione.php' class="btn-twitter-outline">Registrati</a>
                        </div>
                    </div>
                    <?php // die(); // Non usare die() qui se vuoi che il resto della pagina (es. footer) venga renderizzato ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- SCRIPT JS -->
    <!-- Bootstrap JS Bundle (se non già in end.inc o start.inc) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Il tuo script sidebar.js (se non già in end.inc o start.inc) -->
    <script src="styles/sidebar.js"></script> <!-- Assicurati che il percorso sia corretto -->
    <!-- Script per l'animazione dello sfondo -->
    <script src="styles/backgroundStyle.js"></script> <!-- MODIFICATO PER PUNTARE AL FILE CORRETTO -->
    
    <script>
        // Funzione vuota, puoi rimuoverla se non usata
        // function hihihiha() {
        // }

        // Script per form "add-to-folder" (potrebbe essere meglio in un file JS separato)
        document.querySelectorAll('.add-to-folder-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const postId = this.getAttribute('data-post-id'); // Assicurati che questo attributo esista sul form

                fetch('../../priv/gestionePost/addToFolder.php', { // Verifica il percorso
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then((data) => {
                    alert(data.message); // Considera di usare un popup più elegante
                    if (data.status === 'success') {
                        // Assicurati che 'folderPopup-' + postId esista e sia il modo corretto per chiudere
                        const popup = document.getElementById('folderPopup-' + postId);
                        if (popup) {
                            popup.style.display = 'none';
                        }
                        this.reset();
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    alert('Si è verificato un errore durante l\'operazione.');
                });
            });
        });
    </script>

    <script>
        // Script per il banner di benvenuto
        document.addEventListener('DOMContentLoaded', function() {
            const banner = document.getElementById('welcome-banner');
            if (banner) {
                setTimeout(() => {
                    banner.classList.add('fade-out');
                    // Rimuovi l'elemento dal DOM dopo che l'animazione è finita
                    setTimeout(() => banner.remove(), 600); // 600ms è la durata di fadeOut
                }, 3000); // Il banner scompare dopo 3 secondi
            }
        });
    </script>
    
<?php include "../priv/include/end.inc"; ?>