<!--ESPACE MEMBRE-->

<?php require 'inc/verifPassword.php'; ?>
<?php require 'inc/header.php';?>

<h1 style="color:black;" >Bonjour <?= $_SESSION['auth']->username; ?> </h1>
    
    <p>Adresse email : <?= $_SESSION['auth']->email; ?></p>

    <form action="" method="POST">
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Changer de mot de passe"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="password_confirm" placeholder="Confirmation du mot de passe"/>
        </div>
        <button class="btn btn-primary">Changer mon mot de passe</button>
    </form>

    <!--ajout d'un widget calendly pour gérer les rendez-vous-->

    <div class="calendly-inline-widget" data-url="https://calendly.com/majorelle/<?= $_SESSION['auth']->statut; ?>?hide_event_type_details=1" style="min-width:320px;height:630px;"></div>

<?php require 'inc/footer.php'; ?>