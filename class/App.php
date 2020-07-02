<?php 

class APP{

    //variable static
    static $db = null;

    //Permet de se connecter à la base de données avec les identifiants "App::getDatabase()"
    //l'initialisation ne se fait que la première fois.
    static function getDatabase(){
        if(!self::$db){
            self::$db = new Database('root', '', 'dashboard');
        }
        return self::$db;
    }

    //bloquer la connexion à l'espace membre depuis l'URL 
    //Factory - Renvoie toujours la même instance
    static function getAuth(){
        return new Auth(Session::getInstance(), ['restriction_msg' => "Vous n'êtes pas autorisé à accéder à cette page"]);

    }

    //redirection vers une page web après une action de l'utilisateur
    static function redirect($page){
        header("Location: $page");
        exit();
    }


}