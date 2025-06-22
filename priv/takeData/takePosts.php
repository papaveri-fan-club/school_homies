<?php

// Controlla se il parametro type_post è impostato
if (isset($type_post)) {
    // Se il tipo è "Appunti", includi anche il tipo 4
    if ($type_post == 3) {
        $stmtPosts = $conn->prepare("SELECT p.*, u.name, u.surname, u.user_type 
                                     FROM posts p 
                                     JOIN users u ON p.id_user = u.id_user
                                     WHERE p.type_post IN (3, 4)
                                     order by p.id_post desc
                                     limit 10"
                                     );
    } else {
        $stmtPosts = $conn->prepare("SELECT p.*, u.name, u.surname, u.user_type 
                                     FROM posts p 
                                     JOIN users u ON p.id_user = u.id_user
                                     WHERE p.type_post = ?
                                     order by p.id_post desc
                                     limit 10"
                                     );
        $stmtPosts->bind_param("i", $type_post);
    }
} else {
    // Se il parametro type_post non è impostato, mostra tutti i post
    $stmtPosts = $conn->prepare("SELECT p.*, u.name, u.surname, u.user_type 
                                 FROM posts p 
                                 JOIN users u ON p.id_user = u.id_user
                                 order by p.id_post desc
                                 limit 10");
}

$stmtPosts->execute();
$resultPosts = $stmtPosts->get_result();
?>