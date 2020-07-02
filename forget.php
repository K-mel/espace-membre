<!--MOT DE PASSE OUBLIE-->

<?php require 'inc/forgetPassword.php';?>

<?php require 'inc/header.php'; ?>

    <h1>Mot de passe oublié</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">ENVOYER</button>
    </form>

<?php require 'inc/footer.php'; ?>