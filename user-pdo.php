
<?php 

class Userpdo 
{

    //ATTRIBUTS
    private $_id;
    public  $login;
    public  $email;
    //public $password;
    public  $firstname;
    public  $lastname;
    public $database;
    public $data;


    //CONSTRUCTEUR

    public function __construct() {
        session_start();

        try {
            $this->database = new PDO('mysql:host=localhost;dbname=classes;charset=utf8;port=3307', 'root', '');
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

         /*mysqli_connect("localhost", "root", "", "classes", 3307);*/
        $request = $this->database->prepare('SELECT * FROM utilisateurs');
        $request->execute(array());
        $data = $this->data;
        $this->data = $request->fetchAll();
        var_dump($this->data);
    }
    
    //MÉTHODES 
    public function register($login, $password, $email, $firstname, $lastname) {
        $this->login =      $login;
        $this->email =      $email;
        /*$this->password =*/   $password;
        $this->firstname =  $firstname;
        $this->lastname =   $lastname;

        $loginOk = false;

        foreach ($this->data as $user) { 
                            
            //une condition dans le cas ou le login existe déjà 
            if ( $login == $user[1] ) { 

                echo "le login est déja pris</br>";
                
                $loginOk = false;
                break;
            } else {
                $loginOk = true;
            }

        }

            

        if ( $loginOk ) { 
            //$sql = "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$login','$password','$email','$firstname','$lastname')";
            $request = $this->database->prepare("INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
            $request->execute(array($login, $password, $email, $firstname, $lastname));
            echo "utilisateur créé avec succes!";
        }
        
        // nous retourne un tabbleau avec les info de l'utilisateur qui vient de s'inscrire.
        /*$sqlselect = "SELECT `login`, `password`, `email`, `firstname`, `lastname` FROM utilisateurs WHERE `login` = '$login'";
        $request = $this->database->query($sqlselect);
        return $request->fetch_assoc();*/

        
    }

    public function connect($login, $password) {

        $this->login = $login;
        /*$this->password =*/ $password;
        $logged = false;
        foreach ($this->data as $user) { //je lis le contenu de la table $con de la BDD
    
            if ($login === $user[1] &&
            $password === $user[2]) {
                //echo "vous etes connecter</br>"; 
                
                $_SESSION['login'] = $login;

                $logged = true;
                break;
            } else {
                //echo "erreur dans le mdp ou login</br>";
                $logged = false;
            }
        }
        if($logged) {
            echo "vous etes connecté";
        } else {
            echo "erreur dans le mdp ou login</br>";
        }
    }

    public function disconnect() {
        session_destroy();
        echo "vous êtes déconnecté";
        
    }

    public function delete() {

        if (!empty($_SESSION['login'])) {

        $this->login = $_SESSION['login'];
        $request = $this->database->prepare("DELETE FROM `utilisateurs` WHERE `login` = (?)");
        $request->execute(array($this->login));
        echo "votre compte à été supprimé";
        session_destroy();

        }
    
    }

    public function update($login, $password, $email, $firstname, $lastname) {

        $this->login =      $login;
        $this->email =      $email;
        /*$this->password =*/   $password;
        $this->firstname =  $firstname;
        $this->lastname =   $lastname;
        $logged_user = $_SESSION['login'];

        /*$sql_update = "UPDATE `utilisateurs` SET `login` = '$login' , `password` = '$password' , `email` = '$email' , 
        `firstname` = '$firstname' , `lastname` = '$lastname' WHERE `utilisateurs`.`login` = '$logged_user'";*/
        $this->database->query($sql_update);
    }

    public function isConnected() {
         
        if (isset($_SESSION['login'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllInfos() {
        $this->login = $_SESSION['login'];
        $sql = "SELECT * FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        var_dump($this->data);
        return $this->data;
        
    }

    public function getLogin() {
        $this->login = $_SESSION['login'];
        $sql = "SELECT `login` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        $this->login = $this->data['login'];
        return $this->login;
        
    
    }

    public function getEmail() {

        $this->login = $_SESSION['login'];
        $sql = "SELECT `email` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        $this->email = $this->data['email'];
        return $this->email;
    }

    public function getFirstname() {

        $this->login = $_SESSION['login'];
        $sql = "SELECT `firstname` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        $this->firstname = $this->data['firstname'];
        return $this->firstname;
    }

    public function getLastname() {

        $this->login = $_SESSION['login'];
        $sql = "SELECT `lastname` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        $this->lastname = $this->data['lastname'];
        return $this->lastname;
    }

}

$utilisateur = new Userpdo;
//$utilisateur->register('wry', 'muda', 'dio.brando@mudaluda.com', 'Dio', 'Brando');
//$utilisateur->connect('Bigorneau', 'ada');
//$utilisateur->disconnect();
$utilisateur->delete();
//$utilisateur->update('CRF','umbrella','chris.redfield@RE.com','chris','redfield');
//$utilisateur->getAllInfos()['password'];
//$utilisateur->getLogin();
//$utilisateur->getEmail();
//$utilisateur->getFirstname();
//$utilisateur->getLastname();
//$utilisateur->isConnected();

