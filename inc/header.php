<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="dashboard, espace membre" content="Site d'espace membre studio majorelle">
    <meta name="Camel Benmoussa" content="espace membre">
    <link rel="icon" href="../../favicon.ico">
    

    <title>Studio Majorelle</title>

  <!-- Bootstrap core CSS -->
   <link href="css/app.css" rel="stylesheet">
  <link href="css/logo.css" rel="stylesheet">
  </head>

  <body>

    <nav id="navbar" class="navbar navbar-inverse">
    <div> 
    
    </div>
      <div class="container">
      
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
          <a class="navbar-brand" href="#" style="font-size:2.5em;">Studio Majorelle</a>
        </div>
        
          <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

              <?php if(isset($_SESSION['auth'])): ?>
                <li  ><a href="logout.php">Se déconnecter</a></li>
              <?php else: ?>
                <li><a href="register.php">S'inscrire</a></li>
                <li ><a href="login.php">Se connecter</a></li>
              <?php endif; ?>
            </ul>
          </div><!--/.nav-collapse -->
      </div>
    </nav>

<div id="form" class="container">

<!--fait apparaître les erreurs-->
<?php if(Session::getInstance()->hasFlashes()): ?>
  <?php foreach(Session::getInstance()->getFlashes() as $type => $message): ?>
    <div class="alert alert-<?= $type; ?>">
      <?= $message; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
      
