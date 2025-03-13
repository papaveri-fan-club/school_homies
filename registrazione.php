<?php
include "./include/start.inc";
?>

<h4>Registrazione nuovo utente</h4>

<form action="gestioneUtenti/newUser.php" method="POST" onsubmit="return validateForm()">
    
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>

  <div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  
  <div class="mb-3">
    <label for="surname" class="form-label">Cognome</label>
    <input type="text" class="form-control" id="surname" name="surname" required>
  </div>

  <div class="mb-3">
    <label class="form-label" for="user_type">Tipo Utente</label>
    <select class="form-select" name="user_type" aria-label="Default select example" required>
        <option selected value="normale">Studente</option>
        <option value="amministratore">Insegnante</option>
    </select>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>

  <div class="mb-3">
    <label for="confirm_password" class="form-label">Conferma Password</label>
    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
  </div>

  <button type="submit" class="btn btn-primary">Registrati</button>
</form>

<script>
function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    if (password !== confirmPassword) {
        alert("Le password non corrispondono.");
        return false;
    }
    return true;
}
</script>

<?php include "./include/end.inc"; ?>
