
<?php 

class User 
{

    //ATTRIBUTS
    private $_id;
    public  $login;
    public  $email;
    public $password;
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
        $this->data = $request->fetch_all();
        var_dump($this->data);
    }
    
    //MÉTHODES 
    public function register($login, $password, $email, $firstname, $lastname) {
        $this->login =      $login;
        $this->email =      $email;
        $this->password =   $password;
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
            $sql = "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$login','$password','$email','$firstname','$lastname')";
            $this->database->query($sql);
        }
        
        // nous retourne un tabbleau avec les info de l'utilisateur qui vient de s'inscrire.
        /*$sqlselect = "SELECT `login`, `password`, `email`, `firstname`, `lastname` FROM utilisateurs WHERE `login` = '$login'";
        $request = $this->database->query($sqlselect);
        return $request->fetch_assoc();*/

        
    }

    public function connect($login, $password) {

        $this->login = $login;
        $this->password = $password;

        foreach ($this->data as $user) { //je lis le contenu de la table $con de la BDD
    
            if ($login === $user[1] &&
            $password === $user[2]) {
                echo "vous etes connecter</br>"; 
                
                $_SESSION['login'] = $login;

                $logged = true;
                break;
            } else {
                echo "erreur dans le mdp ou login</br>";
            }
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

    public function update() {

    }

    /*public function isConnected() {
         
        if (isset($_SESSION['login'])) {
            return true;
        } else {
            return false;
        }
    }*/

    public function getAllInfos() {
        $this->login = $_SESSION['login'];
        $sql = "SELECT * FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        var_dump($this->data);
        return $this->data;
        /*
        echo "<table border style='text-align: center;'>
                <thead>
                    <th>id</th>
                    <th>login</th>
                    <th>password</th>
                    <th>email</th>
                    <th>firstname</th>
                    <th>lastname</th>
                </thead>";
        
        foreach ($this->data as $user) {
            echo '<tr>
                    <td>'.$user[0].'</td>
                    <td>'.$user[1].'</td>
                    <td>'.$user[2].'</td>
                    <td>'.$user[3].'</td>
                    <td>'.$user[4].'</td>
                    <td>'.$user[5].'</td>
                  </tr>';
        }
        echo "</table>";*/
        
    }

    /*public function getLogin() {
        $this->login = $_SESSION['login'];
        $sql = "SELECT `login` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        $this->login = $this->data['login'];
        return $this->login;
        
    
    }*/

    /*public function getEmail() {

        $this->login = $_SESSION['login'];
        $sql = "SELECT `email` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        $this->email = $this->data['email'];
        return $this->email;
    }*/

    /*public function getFirstname() {

        $this->login = $_SESSION['login'];
        $sql = "SELECT `firstname` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        $this->firstname = $this->data['firstname'];
        return $this->firstname;
    }*/

    /*public function getLastname() {

        $this->login = $_SESSION['login'];
        $sql = "SELECT `lastname` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->query($sql);
        $this->data = $request->fetch_ASSOC();
        $this->lastname = $this->data['lastname'];
        return $this->lastname;
    }*/

}

$utilisateur = new User;
//$utilisateur->register('Bigorneau', 'ada', 'leon.s.ken@RE.com', 'leon', 'kennedy');
//$utilisateur->connect('elmachoto', 'toto');
//$utilisateur->disconnect();
//$utilisateur->delete();
//$utilisateur->getAllInfos();
//$utilisateur->getLogin();
//$utilisateur->getEmail();
//$utilisateur->getFirstname();
//$utilisateur->getLastname();
//$utilisateur->isConnected();

