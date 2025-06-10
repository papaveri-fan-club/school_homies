<?php include "../priv/include/start.inc"; ?>
<?php include "../priv/include/connessione.inc"; ?>
<?php session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classifica - School Homies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/scoreboard.css">
    <link rel="stylesheet" href="styles/sidebar.css"> 
    <link rel="stylesheet" href="styles/backgroundStyle.css"> 
    <link rel="stylesheet" href="styles/index.css">
    <!-- RIMUOVI <link rel="stylesheet" href="styles/backgroundStyle.js"> -->
    <!-- Considera di unificare gli stili della sidebar e dei pulsanti per evitare duplicazioni -->
</head>
<body>
    <button class="button button--hamburger hamburger-menu"> 
        <i class="fas fa-bars icon"></i>
    </button>
    <div class="layout-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-book"></i>
                <!-- <img src="path/to/your/logo.png" alt="School Homies Logo"> -->
            </div>
            <a href="index.php" class="menu-item">
                <i class="fas fa-home icon"></i> Home
            </a>
            <a href="index.php?type_post=1" class="menu-item">
                <i class="fas fa-hashtag icon"></i> Post
            </a>
            <a href="index.php?type_post=3" class="menu-item">
                <i class="fas fa-book-open icon"></i> Appunti
            </a>
            <a href="index.php?type_post=2" class="menu-item">
                <i class="fas fa-calendar-alt icon"></i> Eventi
            </a>
            <a href="scoreboard.php" class="menu-item is-active"> 
                <i class="fas fa-trophy icon"></i> Classifica
            </a>
            <?php if (isset($_SESSION['email'])): ?>
            <a href="./profile.php?id_user=<?= $_SESSION['id_user']?>" style="text-decoration: none; color: inherit;">
                <div class="user-profile"> <!-- Mantieni .user-profile se ha stili specifici non da bottone -->
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
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header School Homies -->
            <div class="header-section">
                <div class="header-content">
                    <div>
                        <div class="header-title">
                            <i class="fa-solid fa-book"></i> School Homies
                        </div>
                        <div class="header-subtitle">Connettiti con i tuoi compagni di scuola</div>
                    </div>
                    <!-- Potresti voler aggiungere una barra di ricerca o altri elementi qui -->
                </div>
            </div>
            <!-- Sfondo con testo a mattoni -->
            <div class="background-text" id="background-text"></div>
            <div class="scoreboard-container">
                <div class="scoreboard-title">
                    <i class="fas fa-trophy"></i> Classifica
                </div>
                <?php
                // ... (codice PHP per la classifica invariato) ...
                include "../priv/include/connessione.inc";

                // Ottieni il numero di post per utente
                $sql_posts = "SELECT id_user, COUNT(id_post) AS post_count FROM posts GROUP BY id_user";
                $result_posts = $conn->query($sql_posts);
                $post_counts = [];
                if ($result_posts) {
                    while ($row = $result_posts->fetch_assoc()) {
                        $post_counts[$row['id_user']] = (int)$row['post_count'];
                    }
                }

                // Ottieni il numero di commenti per utente
                $sql_comments = "SELECT id_user, COUNT(id_comment) AS comment_count FROM comments GROUP BY id_user";
                $result_comments = $conn->query($sql_comments);
                $comment_counts = [];
                if ($result_comments) {
                    while ($row = $result_comments->fetch_assoc()) {
                        $comment_counts[$row['id_user']] = (int)$row['comment_count'];
                    }
                }

                // Unisci i punteggi
                $users_scores = [];
                $user_ids = array_unique(array_merge(array_keys($post_counts), array_keys($comment_counts)));
                foreach ($user_ids as $id_user) {
                    $users_scores[$id_user] = [
                        'total' => (isset($post_counts[$id_user]) ? $post_counts[$id_user] : 0) + (isset($comment_counts[$id_user]) ? $comment_counts[$id_user] : 0)
                    ];
                }

                // Ordina per punteggio totale decrescente
                uasort($users_scores, function($a, $b) {
                    return $b['total'] <=> $a['total'];
                });

                if (count($users_scores) > 0) {
                    echo '<table class="scoreboard-table">
                            <thead> <!-- Aggiunto thead per semantica -->
                            <tr>
                                <th>#</th>
                                <th>Utente</th>
                                <th>Punteggio</th>
                            </tr>
                            </thead>
                            <tbody>'; // Aggiunto tbody per semantica
                    $pos = 1;
                    foreach ($users_scores as $user_id => $score) {
                        // Recupera nome e cognome dell'utente
                        $userQ = $conn->prepare("SELECT name, surname FROM users WHERE id_user = ? LIMIT 1");
                        $userQ->bind_param("i", $user_id);
                        $userQ->execute();
                        $resultUser = $userQ->get_result();
                        $user = $resultUser && $resultUser->num_rows > 0 ? $resultUser->fetch_assoc() : ['name' => 'Sconosciuto', 'surname' => ''];
                        $userQ->close();
                        
                        // Medaglie per i primi 3
                        $medal = '';
                        if ($pos == 1) $medal = '<span class="medal gold">👑</span>';
                        elseif ($pos == 2) $medal = '<span class="medal silver">🥈</span>';
                        elseif ($pos == 3) $medal = '<span class="medal bronze">🥉</span>';
                        // Avatar
                        $avatar = '<img class="score-avatar" src="https://ui-avatars.com/api/?name=' . urlencode($user['name'].' '.$user['surname']) . '&background=6a11cb&color=fff&bold=true" alt="avatar">';
                        // Riga
                        echo '<tr class="score-row'.($pos <= 3 ? ' top3' : '').'">
                                <td>' . $medal . ($pos > 3 ? $pos : '') . '</td>
                                <td>' . $avatar . '<span class="score-name">' . htmlspecialchars($user['name'] . ' ' . $user['surname']) . '</span></td>
                                <td><span class="score-points">' . $score['total'] . '</span></td>
                              </tr>';
                        $pos++;
                    }
                    echo '</tbody></table>'; // Chiuso tbody
                } else {
                    echo '<p style="text-align:center; color:#888;">Nessun dato disponibile.</p>';
                }
                $conn->close(); // Chiudi la connessione
                ?>
            </div>
        </div>
    </div>
    <script>
        // Funzione per generare dinamicamente le righe di sfondo
        function generateBackgroundRows() {
            const backgroundText = document.getElementById('background-text');
            if (!backgroundText) return; // Esci se l'elemento non esiste
            const windowHeight = window.innerHeight;
            const rowHeight = 90; // Altezza della riga + margine
            const rowsNeeded = Math.ceil(windowHeight / rowHeight) + 1; // Aggiungi una riga extra per sicurezza
            
            backgroundText.innerHTML = ''; // Pulisci le righe esistenti

            for (let i = 0; i < rowsNeeded; i++) {
                const row = document.createElement('div');
                row.className = 'text-row';
                
                // Durata animazione casuale per un effetto più vario
                const baseDuration = i % 2 === 0 ? 60 : 70; // Durate base diverse per righe pari/dispari
                const durationVariation = Math.random() * 20 - 10; // Variazione di +/- 10s
                const duration = Math.max(40, baseDuration + durationVariation); // Minimo 40s
                row.style.animationDuration = `${duration}s`;
                
                // Determina la direzione dell'animazione
                row.style.animationName = i % 2 === 0 ? 'scrollLeft' : 'scrollRight';

                const screenWidth = window.innerWidth;
                const brickWidth = 250; // Larghezza approssimativa di un "brick" inclusi i margini
                const bricksNeeded = Math.ceil((screenWidth * 2) / brickWidth) + 2; // *2 per la larghezza doppia della riga, +2 per sicurezza

                for (let j = 0; j < bricksNeeded; j++) {
                    const brick = document.createElement('span');
                    brick.className = 'brick';
                    brick.textContent = 'SCHOOL HOMIES'; // Testo del brick
                    
                    // Opacità casuale per testo e sfondo del brick
                    const textOpacity = 0.15 + (Math.random() * 0.2); // Tra 0.15 e 0.35
                    brick.style.color = `rgba(255, 255, 255, ${textOpacity})`;
                    
                    const bgOpacity = 0.03 + (Math.random() * 0.1); // Tra 0.03 e 0.13
                    brick.style.backgroundColor = `rgba(255, 255, 255, ${bgOpacity})`;
                    
                    row.appendChild(brick);
                }
                backgroundText.appendChild(row);
            }
        }

        // Rigenera allo scroll e al resize
        window.addEventListener('load', generateBackgroundRows);
        window.addEventListener('resize', generateBackgroundRows);
        // Non è necessario sidebar.js se la sidebar è sempre visibile e l'hamburger gestisce solo la versione mobile (non implementata qui)
    </script>
    <!-- Assicurati che backgroundStyle.js sia incluso correttamente come script se necessario -->
    <!-- Esempio: <script src="styles/backgroundStyle.js"></script> -->
    <?php include "../priv/include/end.inc"; ?>
</body>
</html>