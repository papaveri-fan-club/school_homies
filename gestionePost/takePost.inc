<?php
include "./include/connessione.inc";

$stmtPost = $conn->prepare("SELECT p.id_post, p.date,p.title,p.description,u.name from users as u, posts as p WHERE p.id_user=u.id_user");
$stmtPost->execute();
$resultPost = $stmtPost->get_result();

include "./include/connessione.inc";
?>