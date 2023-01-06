
<?php 

class User 
{

    //ATTRIBUTS
    private $_id;
    public  $login;
    public  $email;
    public  $firstname;
    public  $lastname;
    public $database;
    public $data;


    //CONSTRUCTEUR

    public function __construct() {

        session_start();
        $this->database = mysqli_connect("localhost", "root", "", "classes", 3307);
        $request = $this->database->query('SELECT * FROM utilisateurs');
        $data = $this->data;
        $this->data = $request->fetch_all(MYSQLI_BOTH);
        echo "<h1 style='color:red;font-family:monospace;font-size:30px;text-align:center'>
        la classe 'User' a été instancié, message depuis le contructeur</h1>";
    }
    
    //MÉTHODES 
    public function register($login, $password, $email, $firstname, $lastname) {

        $this->login =      $login;
        $this->email =      $email;
        $password;
        $this->firstname =  $firstname;
        $this->lastname =   $lastname;
        $loginOk = false;

        foreach ($this->data as $user) { 
                            
            //une condition dans le cas ou le login existe déjà 
            if ( $this->login == $user[1] ) { 

                echo "le login est déja pris</br>";
                $loginOk = false;
                break;

            } else {
                $loginOk = true;
            }
        }

        if ( $loginOk ) { 
            $sql = "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$this->login','$password','$this->email','$this->firstname','$this->lastname')";
            $this->database->query($sql);
        }
                
    }


    public function connect($login, $password) {

        $this->login = $login;
        $password;
        $logged = false;

        foreach ($this->data as $user) { 
    
            if ($this->login === $user[1] && $password === $user[2]) {
                   
                $_SESSION['login'] = $login;
                $logged = true;
                break;
            } else {
                $logged = false;
            }
        }

        if( $logged ) {
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

        $this->login = $_SESSION['login'];
        $sql = "DELETE FROM `utilisateurs` WHERE `login` = '$this->login'";
        $this->database->query($sql);
        echo "votre compte à été supprimé";
        session_destroy();
    }

    public function update($login, $password, $email, $firstname, $lastname) {

        $this->login =      $login;
        $this->email =      $email;
        $password;
        $this->firstname =  $firstname;
        $this->lastname =   $lastname;
        $logged_user = $_SESSION['login'];

        $sql_update = "UPDATE `utilisateurs` SET `login` = '$this->login' , `password` = '$password' , `email` = $this->$email' , 
        `firstname` = '$this->firstname' , `lastname` = '$this->lastname' WHERE `utilisateurs`.`login` = '$logged_user'";
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

$utilisateur = new User;
//$utilisateur->register('Bigorneau', 'ada', 'leon.s.ken@RE.com', 'leon', 'kennedy');
//$utilisateur->connect('CRF', 'umbrella');
//$utilisateur->disconnect();
//$utilisateur->delete();
//$utilisateur->update('CRF','umbrella','chris.redfield@RE.com','chris','redfield');
//$utilisateur->getAllInfos();
//$utilisateur->getLogin();
//$utilisateur->getEmail();
//$utilisateur->getFirstname();
//echo $utilisateur->getLastname();
//$utilisateur->isConnected();

