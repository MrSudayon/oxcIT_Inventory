<?php
session_start();

include 'functions.php';
include 'assetsController.php';

class Connection {
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $db_name = "db_oxychem";
    public $conn;

    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->db_name);
        if(mysqli_connect_error()) {
            die ("Connection Failed: ".mysqli_error($this->conn));
        }
    }
}

class AddItems extends Connection {
    public function addEmployee($name, $division, $location) { 
        $duplicate = mysqli_query($this->conn, "SELECT * FROM employee_tbl WHERE name LIKE '%$name' AND name LIKE '$name%' AND name LIKE '%$name%'");
        
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            $query = "INSERT INTO employee_tbl (id, name, division, location, status)
                                VALUES ('','$name', '$division', '$location', 1)";

            $result = mysqli_query($this->conn, $query);
            if($result) { 
                return 1; //Success
            } else {
                return 100; //Store Failed
            }
        }
    }

    // Add Asset Item
    public function addAssetItem($name) {
        $duplicate = mysqli_query($this->conn, "SELECT * FROM category_tbl WHERE assetType LIKE '%$name%'");
        
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            $query = "INSERT INTO category_tbl (id, assetType, status)
                                VALUES ('','$name', 1)";

            $result = mysqli_query($this->conn, $query);
            if($result) { 
                return 1; //Success
            } else {
                return 100; //Store Failed
            }
        }
    }

    // Add Division
    public function addDivision($name) {
        $duplicate = mysqli_query($this->conn, "SELECT * FROM dept_tbl WHERE name LIKE '$name'");
        
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            $query = "INSERT INTO dept_tbl (id, name, status)
                                VALUES ('','$name', 1)";

            $result = mysqli_query($this->conn, $query);
            if($result) { 
                return 1; //Success
            } else {
                return 100; //Store Failed
            }
        }
    }

    // Add Location
    public function addLocation($name) {
        $duplicate = mysqli_query($this->conn, "SELECT * FROM loc_tbl WHERE name LIKE '$name'");
        
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            $query = "INSERT INTO loc_tbl (id, name, status)
                                VALUES ('','$name', 1)";

            $result = mysqli_query($this->conn, $query);
            if($result) { 
                return 1; //Success
            } else {
                return 100; //Store Failed
            }
        }
    }
}
class Register extends Connection {
    public function register($role, $user, $email, $pass, $conf_pass) {

        $duplicate = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE username='$user' OR email='$email' ");

        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
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

        if(mysqli_num_rows($result) > 0) {
            if($password == $row["password"]) {
                $this -> id = $row["id"];
                $role = $row["role"];
                
                if($role == 'admin') {
                    return 1; // Login as admin
                } else {
                    return 2; // Login as user
                }  
            } else {
                return 10; // Wrong password
            }
        } else {
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

class get_All_User extends Connection {
    public function selectAllUser() {
        $sql = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE status=1");
        while($res = mysqli_fetch_assoc($sql)) {
            $users[] = $res;
        }
        return $users;
    }
    public function selectAllEmp() {
        $sql = mysqli_query($this->conn, "SELECT * FROM employee_tbl WHERE status=1");
        while($res = mysqli_fetch_assoc($sql)) {
            $users[] = $res;
        }
        return $users;
    }
}

?>