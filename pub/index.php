<?php include "../priv/include/start.inc"; ?>
<?php include "../priv/include/connessione.inc"; ?>
<?php session_start(); ?>

<!-- Aggiorna i link Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Stile base e reset */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%) fixed no-repeat;
        color: #0f1419;
        position: relative;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
    
    /* Layout principale */
    .layout-container {
        display: flex;
        min-height: 100vh;
        position: relative;
        background-color: transparent;
    }
    
    /* Sidebar migliorata */
    .sidebar {
        width: 280px;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        padding: 15px 0;
        background-color: #fff;
        border-right: 1px solid #e1e8ed;
        overflow-y: auto;
        z-index: 200;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    
    /* Logo e immagine */
    .logo {
        display: flex;
        align-items: center;
        padding: 0 20px 20px 20px;
        margin-bottom: 15px;
        border-bottom: 1px solid #f0f3f5;
    }
    
    .logo i {
        font-size: 1.8rem;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-right: 10px;
    }
    
    .logo img {
        height: 35px;
        width: auto;
        cursor: pointer;
    }

    /* Voci del menu */
    .menu-item {
        display: flex;
        align-items: center;
        padding: 14px 15px;
        margin: 5px 12px;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f1419;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .menu-item:hover {
        background-color: #e8f5fe;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        transform: translateX(2px);
        color: white;
    }
    
    .menu-item i {
        margin-right: 15px;
        font-size: 1.3rem;
        width: 24px;
        text-align: center;
    }
    
    .active-menu {
        color: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        background-color: rgba(29, 104, 242, 0.1);
    }
    
    /* Pulsante di post */
    .post-button {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 14px 20px;
        font-size: 1.1rem;
        font-weight: bold;
        width: calc(100% - 24px);
        margin: 20px 12px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        box-shadow: 0 2px 5px rgba(106, 17, 203, 0.3);
    }
    
    .post-button:hover {
        opacity: 0.9;
    }
    
    /* Profilo utente */
    .user-profile {
        display: flex;
        align-items: center;
        padding: 12px;
        margin: 15px 12px;
        border-radius: 15px;
        background-color: #f7f9fa;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    
    .user-profile:hover {
        background-color: #e8f5fe;
    }
    
    /* Area principale del contenuto */
    .main-content {
        flex: 1;
        margin-left: 280px;
        width: calc(100% - 280px);
        background-color: transparent;
    }
    
    /* Header migliorato */
    .header-section {
        background-color: rgba(255, 255, 255, 0.98);
        padding: 15px 25px;
        border-bottom: 1px solid #e1e8ed;
        position: fixed;
        top: 0;
        left: 280px;
        right: 0;
        z-index: 150;
        backdrop-filter: blur(5px);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        height: auto;
        display: flex;
        align-items: center;
    }
    
    .header-content {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .header-title {
        font-size: 1.6rem;
        font-weight: bold;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        background-clip: text; /* Standard property for compatibility */
        -webkit-text-fill-color: transparent;
        display: flex;
        align-items: center;
    }
    
    .header-title i {
        margin-right: 10px;
    }
    
    .header-subtitle {
        color: #657786;
        font-size: 1rem;
    }
    
    /* Barra di ricerca */
    .search-container {
        width: 300px;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 20px;
        border: 1px solid #e1e8ed;
        border-radius: 25px;
        font-size: 1rem;
        background-color: #f7f9fa;
        transition: all 0.2s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #6a11cb;
        background-color: #fff;
        box-shadow: 0 0 0 2px rgba(106, 17, 203, 0.2);
    }
    
    /* Area dei post */
    .posts-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 120px 20px 20px 20px; /* Spazio extra per l'header fisso */
        background-color: transparent;
    }
    
    /* Area di benvenuto */
    .welcome-area {
        margin-bottom: 25px;
        padding: 15px 0;
        border-bottom: 1px solid #e1e8ed;
    }
    
    /* Pulsanti di login */
    .btn-twitter {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        margin-right: 10px;
        display: inline-block;
    }
    
    .btn-twitter-outline {
        background: transparent;
        color: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        padding: 9px 19px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #6a11cb;
        display: inline-block;
    }
    
    /* Messaggi di notifica o login */
    .message-box {
        padding: 25px;
        background: white;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        text-align: center;
    }

    .hihihiha {
        border-radius: 100%;
        transition: all 10s ease;
        
    }
    
    .hihihiha:hover {
        transform: scale(5);
        transition: all 0.3s ease;
        animation: ruota 1s infinite linear;
    }
    @keyframes ruota {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    /* Stile per il pulsante "like" */
    .like-button {
        color: #6a11cb;
        transition: color 0.3s;
    }

    .like-button:hover {
        color: #2575fc;
    }

    /* Sfondo a mattoni stile login */
    .background-text {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: -1;
        overflow: hidden;
    }
    .text-row {
        position: relative;
        height: 70px;
        margin-bottom: 20px;
        display: flex;
        white-space: nowrap;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        width: 200%;
    }
    .text-row:nth-child(odd) {
        animation-name: scrollLeft;
        animation-duration: 60s;
    }
    .text-row:nth-child(even) {
        animation-name: scrollRight;
        animation-duration: 80s;
    }
    .brick {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 10px 30px;
        margin: 0 20px;
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 6px;
        color: rgba(255, 255, 255, 0.3);
        font-weight: 600;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .text-row:nth-child(1) { animation-duration: 60s; }
    .text-row:nth-child(3) { animation-duration: 75s; }
    .text-row:nth-child(5) { animation-duration: 65s; }
    .text-row:nth-child(7) { animation-duration: 70s; }
    .text-row:nth-child(9) { animation-duration: 80s; }
    .text-row:nth-child(2) { animation-duration: 80s; }
    .text-row:nth-child(4) { animation-duration: 65s; }
    .text-row:nth-child(6) { animation-duration: 70s; }
    .text-row:nth-child(8) { animation-duration: 75s; }
    .text-row:nth-child(10) { animation-duration: 60s; }
    @keyframes scrollLeft {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    @keyframes scrollRight {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }
    /* Stile per il banner di benvenuto */
    .alert-welcome {
        position: fixed;
        top: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #2575fc 0%, #6a11cb 100%);
        color: #fff;
        padding: 18px 40px;
        border-radius: 25px;
        font-size: 1.15rem;
        font-weight: 600;
        box-shadow: 0 4px 16px rgba(37,117,252,0.15);
        z-index: 3000;
        opacity: 0.97;
        animation: fadeIn 0.5s;
    }
    @keyframes fadeIn {
        from { opacity: 0; top: 0;}
        to { opacity: 0.97; top: 30px;}
    }

    .fade-out {
        animation: fadeOut 0.6s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        100% { opacity: 0; }
    }

    .alert-welcome.fade-out {
        opacity: 0;
        transition: opacity 0.6s;
    }

    .alert-info, .alert-welcome {
        background: #2575fc;
        color: #fff;
        border-radius: 20px;
        /* ...altro stile come sopra... */
    }

    @media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        position: fixed;
        z-index: 2000;
        width: 250px;
        transition: transform 0.3s ease;
    }

    .sidebar.sidebar-open {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0;
        width: 100%;
    }

    .hamburger-menu {
        display: flex; /* Mostra il pulsante hamburger */
    }
}

/* Nascondi il pulsante hamburger su schermi grandi */
.hamburger-menu {
    display: none;
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 3000;
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
</style>

<body>
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
                            <button type="submit" style="display: none;">Cerca</button>
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
                            include '../priv/takeData/searchPosts.php';
                            include './showData/showPosts.php';
                        } else {
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
                    <?php die(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function hihihiha() {
            
        }

        document.querySelectorAll('.add-to-folder-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const postId = this.getAttribute('data-post-id');

                fetch('../../priv/gestionePost/addToFolder.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then((data) => {
                    alert(data.message);
                    if (data.status === 'success') {
                        document.getElementById('folderPopup-' + postId).style.display = 'none';
                        this.reset();
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Si è verificato un errore durante l\'operazione.');
                });
            });
        });
    </script>

    <script>
        // Funzione per generare dinamicamente le righe di sfondo
        function generateBackgroundRows() {
            const backgroundText = document.getElementById('background-text');
            const windowHeight = window.innerHeight;
            const rowHeight = 90;
            const rowsNeeded = Math.ceil(windowHeight / rowHeight) + 1;
            backgroundText.innerHTML = '';
            for (let i = 0; i < rowsNeeded; i++) {
                const row = document.createElement('div');
                row.className = 'text-row';
                const duration = i % 2 === 0 ?
                    65 + (i * 2) % 15 :
                    75 + (i * 3) % 15;
                row.style.animationDuration = `${duration}s`;
                const screenWidth = window.innerWidth;
                const brickWidth = 300;
                const bricksNeeded = Math.ceil((screenWidth * 2) / brickWidth) + 2;
                for (let j = 0; j < bricksNeeded; j++) {
                    const brick = document.createElement('span');
                    brick.className = 'brick';
                    brick.textContent = 'SCHOOL HOMIES';
                    const opacity = 0.2 + (Math.random() * 0.2);
                    brick.style.color = `rgba(255, 255, 255, ${opacity})`;
                    const bgOpacity = 0.05 + (Math.random() * 0.15);
                    brick.style.backgroundColor = `rgba(255, 255, 255, ${bgOpacity})`;
                    row.appendChild(brick);
                }
                backgroundText.appendChild(row);
            }
        }
        window.addEventListener('load', generateBackgroundRows);
        window.addEventListener('resize', generateBackgroundRows);
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const banner = document.getElementById('welcome-banner');
    if (banner) {
        setTimeout(() => {
            banner.classList.add('fade-out');
            setTimeout(() => banner.remove(), 600);
        }, 3000);
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const hamburgerMenu = document.querySelector('.hamburger-menu');

    // Aggiungi evento click per aprire/chiudere la sidebar
    hamburgerMenu.addEventListener('click', function () {
        sidebar.classList.toggle('sidebar-open');
    });

    // Chiudi la sidebar quando si clicca fuori
    document.addEventListener('click', function (event) {
        if (!sidebar.contains(event.target) && !hamburgerMenu.contains(event.target)) {
            sidebar.classList.remove('sidebar-open');
        }
    });
});
//script per far apparire il bottone hamburger 
    document.addEventListener('DOMContentLoaded', function () {
        const hamburgerMenu = document.querySelector('.hamburger-menu');
        const sidebar = document.querySelector('.sidebar');

        // Mostra il pulsante hamburger su schermi piccoli
        if (window.innerWidth <= 768) {
            hamburgerMenu.style.display = 'flex';
        } else {
            hamburgerMenu.style.display = 'none';
        }

        // Aggiungi evento resize per mostrare/nascondere il pulsante hamburger
        window.addEventListener('resize', function () {
            if (window.innerWidth <= 768) {
                hamburgerMenu.style.display = 'flex';
            } else {
                hamburgerMenu.style.display = 'none';
                sidebar.classList.remove('sidebar-open'); // Chiudi la sidebar se aperta
            }
        });
    });
</script>

<?php include "../priv/include/end.inc"; ?>