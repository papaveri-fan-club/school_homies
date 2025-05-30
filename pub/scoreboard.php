<?php include "../priv/include/start.inc"; ?>
<?php include "../priv/include/connessione.inc"; ?>
<?php session_start(); ?>

    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap'); */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .layout-container {
            display: flex;
            min-height: 100vh;
        }
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
            color: white;
        }
        .menu-item i {
            margin-right: 15px;
            font-size: 1.3rem;
            width: 24px;
            text-align: center;
        }
        .active-menu {
            color: #6a11cb;
            background-color: rgba(29, 104, 242, 0.1);
        }
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
        .main-content {
            flex: 1;
            width: calc(100% - 280px);
            position: relative;
        }
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
            background-clip: text;
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
        .scoreboard-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 500px;
            max-width: 95vw;
            margin: 100px auto 0 auto;
            position: relative;
            z-index: 1;
        }
        .scoreboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: #6a11cb;
            text-align: center;
            margin-bottom: 30px;
        }
        /* Scoreboard styles */
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
        /* Stile tabella classifica accattivante */
        .scoreboard-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            font-size: 1.08rem;
            background: transparent;
        }
        .scoreboard-table th {
            background: #f3f6fa;
            color: #6a11cb;
            font-weight: 700;
            padding: 12px 8px;
            border-radius: 10px 10px 0 0;
            border: none;
            text-align: left;
        }
        .scoreboard-table tr.score-row {
            background: #f7f9fa;
            transition: box-shadow 0.2s;
        }
        .scoreboard-table tr.score-row.top3 {
            background: linear-gradient(90deg,rgba(107, 17, 203, 0.23) 0%,rgba(37, 116, 252, 0.41) 100%);
            font-weight: 600;
            box-shadow: 0 2px 10px 0 rgba(106,17,203,0.08);
            border-radius: 10px;
        }
        .scoreboard-table tr.score-row td:first-child {
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
        }
        .scoreboard-table tr.score-row td:last-child {
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }
        .scoreboard-table tr.score-row:nth-child(even):not(.top3) {
            background: #f0f3fa;
        }
        .scoreboard-table td {
            padding: 12px 8px;
            border: none;
            vertical-align: middle;
        }
        .score-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            margin-right: 12px;
            vertical-align: middle;
            border: 2px solid #e1e8ed;
            background: #fff;
        }
        .score-name {
            vertical-align: middle;
            font-weight: 500;
            color: #222;
        }
        .score-points {
            background: linear-gradient(135deg,rgb(106, 17, 203) 0%,rgb(37, 117, 252) 100%);
            color: #fff;
            padding: 6px 18px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.08rem;
            box-shadow: 0 1px 4px rgba(106,17,203,0.08);
        }
        .medal {
            font-size: 1.3em;
            vertical-align: middle;
            margin-right: 6px;
        }
        .medal.gold { color: #FFD700; }
        .medal.silver { color: #C0C0C0; }
        .medal.bronze { color: #CD7F32; }
    </style>
    <link rel="stylesheet" href="styles/sidebar.css">
    <script src="styles/sidebar.js"></script>
<body>
    <button class="hamburger-menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="layout-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-book"></i>
                <img class="hihihiha" src="hihihiha/download.jpg" alt="School Homies Logo">
                <img class="hihihiha" src="../priv/uploads/images/anneclank.jpg" alt="School Homies Logo">
            </div>
            <a href="index.php" class="menu-item">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="index.php?type_post=1" class="menu-item">
                <i class="fas fa-hashtag"></i> Post
            </a>
            <a href="index.php?type_post=3" class="menu-item">
                <i class="fas fa-book-open"></i> Appunti
            </a>
            <a href="index.php?type_post=2" class="menu-item">
                <i class="fas fa-calendar-alt"></i> Eventi
            </a>
            <a href="scoreboard.php" class="menu-item active-menu">
                <i class="fas fa-trophy"></i> Classifica
            </a>
            <?php if (isset($_SESSION['email'])): ?>
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
                </div>
            </div>
            <!-- Sfondo con testo a mattoni -->
            <div class="background-text" id="background-text"></div>
            <div class="scoreboard-container">
                <div class="scoreboard-title">
                    <i class="fas fa-trophy"></i> Classifica
                </div>
                <?php
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
                            <tr>
                                <th>#</th>
                                <th>Utente</th>
                                <th>Punteggio</th>
                            </tr>';
                    $pos = 1;
                    foreach ($users_scores as $user_id => $score) {
                        // Recupera nome e cognome dell'utente
                        $userQ = $conn->query("SELECT name, surname FROM users WHERE id_user = $user_id LIMIT 1");
                        $user = $userQ && $userQ->num_rows > 0 ? $userQ->fetch_assoc() : ['name' => 'Sconosciuto', 'surname' => ''];
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
                    echo '</table>';
                } else {
                    echo '<p style="text-align:center; color:#888;">Nessun dato disponibile.</p>';
                }
                ?>
            </div>
        </div>
    </div>
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
</body>
</html>