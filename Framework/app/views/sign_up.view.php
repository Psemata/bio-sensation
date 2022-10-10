<?php
    $title = "BioSensation - Création de compte";
    require_once('partials/header.php')
?>
</head>
<body>
  <!-- Top part -->
  <header>
    <div id="headingDiv">
      <img id="websiteIcon" src="app/views/img/leaf.png" alt="Website icon">
      <h1>Créer un compte</h1>
    </div>
  </header>

  <main>
    <!-- Error message -->
    <?php
    if($data != []) {
    ?>
      <div class="alert alert-danger" role="alert">
        <?=$data[0];?>
      </div>
    <?php
    }
    ?>
    <!-- Sign up form -->
    <form id="sign_up" action=<?= urlencode("signup"); ?> method="POST">
      <!-- User's pseudo -->
      <div id="pseudo-form" class="form-group">
        <label class="labelForm" for="username">Entrez votre nom d'utilisateur :</label>
        <input type="text" id="username" class="form-control" name="username" placeholder="Xxx_Jean_xxX">
      </div>
      
      <!-- User's email -->
      <div id="email-form" class="form-group">
        <label class="labelForm" for="email">Entrez votre adresse email :</label>
        <input type="email" id="email" class="form-control" name="email" placeholder="exemple@xyz.ch">
      </div>
      
      <!-- User's password -->
      <div id="password-form" class="form-group">
        <label class="labelForm" for="password">Entrez votre mot de passe : </label>
        <input type="password" id="password" class="form-control" name="password">
      </div>

      <!-- Password confirmation -->
      <div id="password-form" class="form-group">
        <label class="labelForm" for="password_confirmation">Réentrez votre mot de passe : </label>
        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
      </div>

      <!-- Submit -->
      <div id="button-submit" class="form-group">
        <input id="buttonForm" type="submit" value="Confirmer" class="btn btn-secondary form">
      </div>      
    </form>
  </main>

  <!-- Bottom part -->
  <footer>
    <span id="connect">
      Si vous avez déjà un compte : <a href=<?= urlencode("signin"); ?> >Connectez-vous</a>
    </span>
  </footer>
<?php 
  require_once('partials/footer.php') 
?>