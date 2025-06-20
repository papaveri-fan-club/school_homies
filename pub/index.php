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
                <img class="hihihiha"  src="priv/uploads/images/schoolHomieslogo.png" alt="School Homies Logo">
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
                        <form method="GET" action="index.php" class="input-container">
                            <input type="text" name="search" placeholder="Cerca nei post..." class="search-input input">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon">
                                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <rect fill="white"></rect> 
                                    <path d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782ZM9 11.5C9 10.1193 10.1193 9 11.5 9C12.8807 9 14 10.1193 14 11.5C14 12.8807 12.8807 14 11.5 14C10.1193 14 9 12.8807 9 11.5ZM11.5 7C9.01472 7 7 9.01472 7 11.5C7 13.9853 9.01472 16 11.5 16C12.3805 16 13.202 15.7471 13.8957 15.31L15.2929 16.7071C15.6834 17.0976 16.3166 17.0976 16.7071 16.7071C17.0976 16.3166 17.0976 15.6834 16.7071 15.2929L15.31 13.8957C15.7471 13.202 16 12.3805 16 11.5C16 9.01472 13.9853 7 11.5 7Z" clip-rule="evenodd" fill-rule="evenodd"></path> 
                                </g>
                            </svg>
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