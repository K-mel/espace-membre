<?php 
// class avec les fonctions qui permettent de valider les données et afficher les messages

class Validator{

    
    private $data;
    private $errors = [];

    public function __construct($data){
        $this->data = $data;
    }

    //permet de vérifier si le champ existe sinon retourner NULL
    private function getField($field){
        if(!isset($this->data[$field])){
            return null;
        }
        return $this->data[$field];
    }

    //vérifie si les informations entrées sont correct
    public function isAlpha($field, $errorMsg){
        if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))){
            //affiche le message d'erreur
            $this->errors[$field] = $errorMsg;
        }
    }

    //vérifie que la donnée n'existe pas déjà dans la base de données
    public function isUniq($field, $db, $table, $errorMsg){
        $record = $db->query("SELECT id FROM $table WHERE $field = ?", [$this->getField($field)])->fetch();
        if($record){
            //affiche le message d'erreur
            $this->errors[$field] = $errorMsg;
        }

    }

    //vérifie si l'email est valide'
    public function isEmail ($field, $errorMsg){
        if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
            //affiche le message d'erreur
            $this->errors[$field] = $errorMsg;
        }
    }

    //Confirmation du mot de passe pour l'inscription et le changement de mot de passe
    public function isConfirmed($field, $errorMsg = ''){
        $value = $this->getField($field);
        if(empty($value) || $value != $this->getField($field . '_confirm')){
            //affiche le message d'erreur
            $this->errors[$field] = $errorMsg;
        }
    }

    //Permet de valider toutes les données
    public function isValid(){
        return empty($this->errors);

    }

    //permet de stocker les erreurs
    public function getErrors()
    {
        return $this->errors;

    }


}