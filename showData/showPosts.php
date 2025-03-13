<?php
include "./gestionePost/takePost.inc";
if ($resultPost->num_rows > 0) {
    echo "<table class='table table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Data</th>";
    echo "<th>Titolo</th>";
    echo "<th>Descrizione</th>";
    echo "<th>Autore</th>";
    echo "<th>Commenti</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($postRow = $resultPost->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($postRow['date']) . "</td>";
        echo "<td>" . htmlspecialchars($postRow['title']) . "</td>";
        echo "<td>" . htmlspecialchars($postRow['description']) . "</td>";
        echo "<td>" . htmlspecialchars($postRow['name']) . "</td>";
        echo "<td>";
        include "./showData/showComments.php";
        include "./form/formComment.php";
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "Nessun post presente.";
}
?>