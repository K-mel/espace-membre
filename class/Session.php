<?php
//Gère la session_start - pour avoir accès à la session

class Session{

    //design pattern
    static $instance;

    //Permet de gérer à quel moment il faut appeler la session_start
    static function getInstance(){
        if(!self::$instance){
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function __construct(){

        session_start();

    }

    //Permet de définir un message flash
    public function setFlash($key, $message){
        $_SESSION['flash'][$key] = $message;

    }

    //Obtenir les messages flash en mémoire
    public function hasFlashes(){
        return isset($_SESSION['flash']);

    }

    //renvoie tous les messages flash
    public function getFlashes(){
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }

    //Permet d'écrire dans la session
    public function write($key, $value){
        $_SESSION[$key] = $value;

    }

    //Permet de lire dans la session
    public function read($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    //Permet de supprimer la session 
    public function delete($key){
        unset($_SESSION[$key]);
    }
}