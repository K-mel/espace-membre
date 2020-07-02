<?php 
spl_autoload_register('app_autoload');

//autoloader (récupère une class pour la mettre dans un fichier)
function app_autoload($class){

    require "class/$class.php";

}