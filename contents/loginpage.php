<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
      <h1 class="mb-4">Login</h1>
      <!--<form action="login" method="POST">-->
      <form action=<?php echo($baseurl."index.php/login/")?> method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Nutzername oder Email:</label>
          <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Passwort:</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="rememberMe">
          <label class="form-check-label" for="rememberMe">Angemeldet bleiben</label>
        </div>
        <button type="submit" class="btn btn-primary">Einloggen</button><br>
        <?php echo('<a href="'.$baseurl.'index.php/resetpassword" class="btn btn-link">Passwort vergessen?</a>');?>
        <?php echo('<a href="'.$baseurl.'index.php/register" class="btn btn-link">Registrieren</a>');?>
      </form>
    </div>
  </div>
</div>
<?php

?>


