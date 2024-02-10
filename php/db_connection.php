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
    public function register($role, $user, $email, $pass, $conf_pass) {

        $duplicate = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE username='$user' OR email='$email' ");

        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } 
        else {
            if($pass == $conf_pass) {
                $sql = "INSERT INTO users_tbl VALUES('', '$user', '$email', '$pass', '$role', 1)";
                mysqli_query($this->conn, $sql);
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
    
    public function login($usernameemail, $password) {
        $result = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE username = '$usernameemail' OR email = '$usernameemail'");
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
            if(mysqli_num_rows($result) > 0) {
                if($password == $row["password"]) {
                    $this -> id = $row["id"];

                    if($role == 'admin') {
                        return 1; // Login as admin
                    } else {
                        return 2; // Login as user
                    }
                    // } else {

                    // }
                        
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
        $result = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
}

?>