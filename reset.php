<?php require 'inc/modifPassword.php';?>

<?php require 'inc/header.php'; ?>

    <h1>Réinitialiser mon mot de passe</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" />
        </div>
        <div class="form-group">
            <label for="">Confirmation du nouveau mot de passe</label>
            <input type="password" name="password_confirm" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">Réinitialiser votre mot de passer</button>
    </form>

<?php require 'inc/footer.php'; ?>