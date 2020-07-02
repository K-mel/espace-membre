<?php

require 'inc/autoload.php';

//DECONNEXION

App::getAuth()->logout();

Session::getInstance()->setFlash('success', "Vous êtes maintenant déconnecté");

App::redirect('login.php');

