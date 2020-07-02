<?php 


require_once 'inc/autoload.php';

//S'INSCRIRE

if(!empty($_POST)){
    
    $errors = array();

    $db = App::getDatabase();
 
    $validator = new Validator($_POST);

    //VERIFICATION DU PSEUDO
    $validator->isAlpha('username', "Votre pseudo n'est pas valide (alphanumérique)");
    if($validator->isValid()){
        $validator->isUniq('username', $db,'users', 'Ce pseudo est déjà pris');
    }

    //VERIFICATION DE L'EMAIL
    $validator->isEmail('email', "Votre email n'est pas valide");
    if($validator->isValid()){
        $validator->isUniq('email', $db,'users', 'Cet email est déjà utilisé pour un autre compte');
    }

    //VERIFICATION DU MOT DE PASSE
    $validator->isConfirmed('password', "Vous devez entrer un mot de passe valide");
        if($validator->isValid()){
        App::getAuth()->register($db, $_POST['username'], $_POST['password'], $_POST['email'] );
        Session::getInstance()->setFlash('success', 'un email de confirmation vous a été envoyé pour valider votre compte');
        App::redirect('login.php');
    }else{
        $errors = $validator->getErrors();
    }
}