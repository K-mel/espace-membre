<?php

//Authentification pour accéder à la base de données
class Auth {

    //permet de changer le message pour la restriction
    private $options = [
        'restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page"
    ];

    private $session;

    
    public function __construct($session, $options = []){
        //array_merge pour fusionner les tableaux en un seul
       $this->options = array_merge($this->options, $options);
       $this->session = $session;
    }

    //chiffrement du mot de passe
    public function hashPassword($password){
        return password_hash($password, PASSWORD_BCRYPT);

    }

   //Permet de créer un nouvel utilisateur
    //Envoie d'un email pour la confirmation
    public function register($db, $username, $password, $email){
        $password = $this->hashPassword($password);
        $token = Str::random(60);
        $db->query("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?", [
            $username, 
            $password, 
            $email, 
            $token
        ]);
        $user_id = $db->lastInsertId();
        mail($email, "Confirmation de votre compte", "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://127.0.0.1/espace_membre/confirm.php?id=$user_id&token=$token");
    }

    //confirmer l'adresse email du nouveau membre et de son inscription par un token
    public function confirm($db, $user_id, $token){
        $user = $db->query('SELECT * FROM users WHERE id = ?', [$user_id])->fetch();
        if($user && $user->confirmation_token == $token){
            $db->query('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?', [$user_id]);
            $this->session->write('auth', $user);
            return true;
        } 
        return false;
       
    }

    //Permet de restreindre l'action de l'utilisateur et de le renvoyer vers une nouvelle page
    public function restrict(){
        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', $this->options['restriction_msg']);
            header('Location: login.php');
            exit();
        }
    }

    //Tester si l'utilisateur est connecté
    public function user(){
        if(!$this->session->read('auth')){
            return false;
        }
        return !$this->session->read('auth');
    }

    //Ecrit la clé auth pour l'utilisateur
    public function connect($user){
        $this->session->write('auth', $user);

    }

    //Gère les cookies - permet de sauvegarder les identifiants sur le navigateur
    public function connectFromCookie($db){
            
        if(isset($_COOKIE['remember']) && !$this->user()){
            $remember_token = $_COOKIE['remember'];
            $parts = explode('==', $remember_token);
            $user_id = $parts[0];
            $user = $db->query('SELECT * FROM users WHERE id = ?', [$user_id])->fetch();
           
            if($user){
                    $expected = $user_id . '//' . $user->$remember_token . sha1($user_id , 'marvelironman');
                    if($expected == $remember_token){
                        $this->connect($user);
                        setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                    }else{
                        setcookie('remember', NULL, -1);
                }
                    }else{
                    setcookie('remember', NULL, -1);
            }
        }

    }

    //tester si le login et le mot de passe sont les bons
    public function login ($db, $username, $password, $remember = false){
            $user = $db->query("SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL", ['username' => $username])->fetch();
            if(password_verify($password, $user->password)){
                $this->connect($user);    
                if($remember){
                    $this->remember($db, $user->id);
                }
                return $user;
                              
            }else{
                return false;
                
            }
        
    }

    //Gère la création et la sauvegarde des cookies 
    public function remember($db, $user_id){
        $remember_token = Str::random(250);
        $db->query("UPDATE users SET remember_token = ? WHERE id = ?", [$remember_token, $user_id]);
        setcookie('remember', $user_id . '//' . $remember_token . sha1($user_id, 'marvelironman'), time() + 60 * 60 * 24 * 7);
        
    }

    //se déconnecter
    public function logout(){
            
            setcookie('rememeber', NULL, -1);
            $this->session->delete('auth');
    }

    //Changer de mot de passe
    public function ResetPassword($db, $email){
            $user = $db->query("SELECT * FROM users WHERE  email = ? AND confirmed_at IS NOT NULL", [$email])->fetch();
            if($user){
              
                $reset_token = Str::random(60);
                $db->query('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?', [$reset_token, $user->id]);
                
                mail($_POST['email'], "Réinitialisation de votre mot de passe", "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://127.0.0.1/espace_membre/reset.php?id={$user->id}&token=$reset_token");
               
                return $user;
            }
            return false;
    }

    //vérifie la correspondance entre le token BDD et celui envoyé + l'id avec un délai de 30 minutes
    public function checkResetToken($db, $user_id, $token){
       return $db->query("SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)", [$user_id, $token])->fetch();
    }
}


