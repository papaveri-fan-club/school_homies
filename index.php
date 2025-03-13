<?php include "./include/start.inc"; ?>
<h1>Welcome to School Homies</h1>
<?php
session_start();
if (isset($_SESSION['email'])) {
    echo "<h2>Benvenuto " . $_SESSION['name'] . " " . $_SESSION["surname"] . "</h2>";
    echo "<a href='profile.php'>Il tuo profilo</a>";
    echo "</br>";
    include 'form/formPost.php';
    echo ' <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postModal">Crea un nuovo post</button>';
} else {
    echo "Devi effettuare il login per accedere a questa pagina.</br>";
    echo "<a href='login.php'>Login</a> </br>";
    echo "<a href='registrazione.php'>Registrati</a></br>";
    die();
}


//show post
include "./takeData/takeposts.php";
include "./takeData/showData/showPosts.php";
?>
</body>
<?php include "./include/end.inc"; ?>

</html>