<?php require 'inc/connexionCookies.php';?>

<?php require 'inc/header.php'; ?>

    <h1 style="color:black;">Se connecter</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="">Pseudo ou email</label>
            <input type="text" name="username" class="form-control" />
        </div>
        <div class="form-group">
            <label  for="">Mot de passe <a style="color:black;" href="forget.php">(mot de passe oublié)</a> </label>
            <input type="password" name="password" class="form-control" />
        </div>
        <div class="form-group">
            <label>
            <input type="checkbox" name="remember" value="1"/>Se souvenir de moi
        </div>
        <button class="btn btn-primary">Se connecter</button>
    </form>

<?php require 'inc/footer.php'; ?>