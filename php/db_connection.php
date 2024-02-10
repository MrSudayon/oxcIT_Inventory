<?php
session_start();

class Connection {
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $db_name = "db_oxychem";
    public $conn;

    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->db_name);
    }
}

class Register extends Connection {
    public function register($role, $user, $email, $pass, $conf_pass, $status) {

        $duplicate = mysqli_query($this->conn, "SELECT * FROM user_tbl WHERE username='$user' OR email='$email' ");

        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } 
        else {
            if($pass == $conf_pass) {
                $sql = mysqli_query($this->conn, "INSERT INTO user_tbl VALUES('', '$user', '$pass', '$role', 1)");
                return 1; // Registration Successs
            } 
            else {
                return 100; // passwords doesn't match
            }
        }

    }

}

class Login extends Connection {
    public $id;
    
    public function login($username, $email, $password) {
        $result = mysqli_query($this->conn, "SELECT * FROM user_tbl WHERE username = '$username' OR email = '$email'");
        $row = mysqli_fetch_assoc($result);
  
            if (mysqli_num_rows($result) > 0) {
                if ($password == $row["password"]){
                    $this -> id = $row["id"];
                    return 1; // Login successful
                }
                else {
                    return 10; // Wrong password
                }
            }
            else {
                return 100; // User not registered
            }
    }
    
    public function idUser() {
        return $this->id;
    }
}
  
class Select extends Connection {
    public function selectUserById($id) {
        $result = mysqli_query($this->conn, "SELECT * FROM user_tbl WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
}

?>