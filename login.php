<?php
include "./include/start.inc";
?>

<h4>Login</h4>

<form action="gestioneUtenti/loginUser.php" method="POST">

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>

  </div>
  <button type="submit" class="btn btn-primary">Accedi</button>

</form>

<?php include "./include/end.inc"; ?>