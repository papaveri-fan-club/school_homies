<?php
$stmtFolders = $conn->prepare("SELECT f.id_folder, f.name, f.type FROM folders as f WHERE f.id_user = ?");
if(isset($id_user)) {
    $stmtFolders->bind_param("i", $id_user);
    $stmtFolders->execute();
    $resultFoldersUser = $stmtFolders->get_result();  
}
    $stmtFolders->bind_param("i", $_SESSION['id_user']);
    $stmtFolders->execute();
    $resultFolders = $stmtFolders->get_result(); 
?>