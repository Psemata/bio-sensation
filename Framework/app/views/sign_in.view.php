<?php
    $title = "BioSensation - Se connecter";
    require_once('partials/header.php')
?>
</head>
<body>
  <!-- Top part -->
  <header>
    <div id="headingDiv">
      <img id="websiteIcon" src="app/views/img/leaf.png" alt="Website icon">
      <h1>Se connecter</h1>
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
    <!-- Connection form -->
    <form id="sign_in" action=<?= urlencode("signin")?> method="post">
      <!-- User's email -->
      <div id="email-form" class="form-group">
        <label class="labelForm" for="email">Entrez votre adresse email :</label>
        <input type="email" id="email" class="form-control" name="email" placeholder="exemple@xyz.ch">
      </div>

      <!-- User's password -->
      <div id="pwd-form" class="form-group">
        <label class="labelForm" for="pwd">Mot de passe : </label>
        <input type="password" id="password" class="form-control" name="password">
      </div>

      <!-- Submit -->
      <div id="button-submit" class="form-group">
        <input id="buttonForm" type="submit" value="Connexion" class="btn btn-secondary form">
      </div>
    </form>
  </main>

  <!-- Bottom part -->
  <footer>
    <span id="createAccount">
      Si vous n'avez pas de compte : <a href=<?= urlencode("signup")?>>Crées-en un</a>
    </span>  
  </footer>

<?php 
  require_once('partials/footer.php')
?>
