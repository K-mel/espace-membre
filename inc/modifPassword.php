<?php 
require 'inc/autoload.php';

if(isset($_GET['id']) && isset($_GET['token'])){
    $auth = App::getAuth();
    $db = App::getDatabase();
    $user = $auth->checkResetToken($db, $_GET['id'], $_GET['token']);
    
    if($user){
        if(!empty($_POST)){
            $validator = new Validator($_POST);
            $validator->isConfirmed('password');
            if($validator->isValid()){
                $password = $auth->hashPassword($_POST['password']);
                $db->query('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?', [$password, $_GET['id']]);
                $auth->connect($user);
                Session::getInstance()->setFlash('success' , 'Votre mot de passe a bien été modifié');
                App::redirect('account.php');
            }
        }
        }else{
       Session::getInstance()->setFlash('danger' , "Ce token n'est pas valide");
       App::redirect('login.php');
    }
    }else{
    App::redirect('login.php');
}