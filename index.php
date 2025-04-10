<?php include "./include/start.inc"; ?>
<?php session_start(); ?>

<style>
    /* Aggiungi questo al tuo CSS esistente */
    .layout-container {
        display: flex;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .sidebar {
        width: 250px;
        padding: 20px;
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
        margin-bottom: 5px;
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
        width: 100%;
        margin-top: 20px;
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
        </div>
        
        <a href="index.php" class="menu-item active-menu">
            <i class="fas fa-home"></i> Home
        </a>
        
        <a href="explore.php" class="menu-item">
            <i class="fas fa-hashtag"></i> Post
        </a>
        
        <a href="notifications.php" class="menu-item">
            <i class="fas fa-bell"></i> Appunti
        </a>
        
        <a href="messages.php" class="menu-item">
            <i class="fas fa-envelope"></i> Eventi
        </a>
        
        <?php if (isset($_SESSION['email'])): ?>
            <button type="button" class="post-button" data-toggle="modal" data-target="#postModal">
                Posta
            </button>
            
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name'].'+'.$_SESSION['surname']) ?>" 
                     style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                <div>
                    <strong><?= htmlspecialchars($_SESSION['name']) ?></strong>
                    <div style="color: #657786; font-size: 0.9rem;">@<?= htmlspecialchars(strtolower(str_replace(' ', '', $_SESSION['name']))) ?></div>
                </div>
            </div>
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
        
        <!-- Contenuto esistente -->
        <div style="padding-top: 20px;">
            <?php if (isset($_SESSION['email'])): ?>
                <div style="margin-bottom: 20px;">
                    <h2>Benvenuto <?= htmlspecialchars($_SESSION['name']) ?> <?= htmlspecialchars($_SESSION["surname"]) ?></h2>
                    <a href='profile.php'>Il tuo profilo</a>
                </div>
                
                <?php include 'form/formPost.php'; ?>
                
                <!-- Il resto del tuo contenuto -->
                <?php
                    //show post
                    include "./takeData/takeposts.php";
                    include "./takeData/showData/showPosts.php";
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

<?php include "./include/end.inc"; ?>