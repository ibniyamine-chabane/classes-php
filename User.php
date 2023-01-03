
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
            echo '<table border>
                            <thead>
                                <th>login</th>
                                <th>email</th>
                                <th>password</th>
                                <th>firstname</th>
                                <th>lastname</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>'.$login.'</td>
                                    <td>'.$email.'</td>
                                    <td>'.$password.'</td>
                                    <td>'.$firstname.'</td>
                                    <td>'.$lastname.'</td>
                                </tr>
                            </tbody>
                      </table>';    
        }

        
    }

    public function connect($login, $password) {

        $this->login = $login;
        $this->password = $password;

        foreach ($this->data as $user) { //je lis le contenu de la table $con de la BDD
    
            if ($login === $user[1] &&
            $password === $user[2]) {
                //echo "vous etes connecter"; // test pour afficher si on est connecté 
                
                //$_SESSION['login'] = $login;

                $logged = true;
                break;
            } else {
                $message = "erreur dans le mdp ou login";
            }
        }
    }

    public function disconnect() {

    }

    public function delete() {

    }

    public function update() {

    }

    public function isConnected() {
         
    }

    public function getAllInfos() {

    }

    public function getLogin() {

    }

    public function getEmail() {

    }

    public function getFirstname() {

    }

    public function getLastname() {

    }

}

$utilisateur = new User;
$utilisateur->register('elmachotoro', 'toto', 'toto@titi.com', 'tonio', 'santana');
