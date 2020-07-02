<?php 

require 'inc/autoload.php';

//CONNEXION A L'ESPACE MEMBRE
//AJOUT DE COOKIES "SE SOUVENIR DE MOI"

$auth = App::getAuth();
$db = App::getDatabase();
$auth->connectFromCookie($db);

if($auth->user()){
   App::redirect('account.php');
}

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    $user = $auth->login($db, $_POST['username'], $_POST['password'], isset($_POST['remember']));
    $session = Session::getInstance();
    if($user){
        $session->setFlash('success', 'Vous êtes maintenant connecté');
        App::redirect('account.php');
    }else{
        $session->setFlash('danger', 'identifiant ou mot de passe incorrecte');
    }
}
