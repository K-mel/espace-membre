<?php 

require 'inc/autoload.php';

//RECUPERATION DU MOT DE PASSE AVEC L'ADRESSE EMAIL

if(!empty($_POST) && !empty($_POST['email'])){
    $db = App::getDatabase();
    $auth = App::getAuth();
    $session = Session::getInstance();
    
    if($auth->resetPassword($db, $_POST['email'])){
        $session->setFlash('success', "Les instructions du renvoi de votre mot de passe vous ont été envoyées par emails");
        App::redirect('login.php');
    }else{
        $session->setFlash('danger' , 'Aucun compte ne correspond à cet adresse');
    }
}