<?php
include "./include/connessione.inc";

$stmtPosts = $conn->prepare("SELECT p.id_post, p.type_post, p.date, p.title, p.description, p.date_event, u.name from users as u, posts as p WHERE p.id_user=u.id_user");
$stmtPosts->execute();
$resultPosts = $stmtPosts->get_result();

include "./include/connessione.inc";
?>