<?php

class Users extends Database
{

    // properties
    private $userName;
    private $LastName;
    private $FirstName;
    private $email;
    private $role;
    private $password;
    private $phone;
    private $photo;








    // getters and setters
    public function setAll($userName = NULL, $LastName = Null, $FirstName = Null, $email, $role, $password, $phone = NULL, $photo = NULL)
    {
        $this->userName = $userName;
        $this->LastName = $LastName;
        $this->FirstName = $FirstName;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
        $this->phone = $phone;
        $this->photo = $photo;
    }

    public function getAll()
    {

        return array(
            'userName' => $this->userName,
            'LastName' => $this->LastName,
            'FirstName' => $this->FirstName,
            'email' => $this->email,
            'role' => $this->role,
            'password' => $this->password,
            'phone' => $this->phone,
            'photo' => $this->photo
        );
    }

    // constructor
    public function __construct()
    {

        $this->table = "users";
    }

    // handle users api
    public function new_user()
    {

        $query = "INSERT INTO " . $this->table . " (userName,LastName,FirstName,Email,Role,Password,Phone,Photo) VALUES (:userName,:lastName,:firstName,:email,:role,:password,:phone,:photo)";
        $prepared_user = $this->connect()->prepare($query);
        $prepared_user->bindParam(':userName', $this->userName);
        $prepared_user->bindParam(':lastName', $this->LastName);
        $prepared_user->bindParam(':firstName', $this->FirstName);
        $prepared_user->bindParam(':email', $this->email);
        $prepared_user->bindParam(':role', $this->role);
        $prepared_user->bindParam(':password', $this->password);
        $prepared_user->bindParam(':phone', $this->phone);
        $prepared_user->bindParam(':photo', $this->photo);

        if ($prepared_user->execute()) {
            return true;
        }

        return false;
    }

    // get user for login operation
    public function get_user_forLogin()
    {

        $query = "SELECT * FROM " . $this->table . " WHERE Email = ? AND Password = ? AND Role=?";

        $prepared_email = $this->connect()->prepare($query);
        $prepared_email->execute([$this->email, $this->password, $this->role]);
        if ($prepared_email->rowCount()) {

            return $prepared_email->fetch();
        } else {
            return array();
        }
    }
    //get info user 
    public function getUserInfo($id)
    {

        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";

        $prepared_email = $this->connect()->prepare($query);
        $prepared_email->execute([$id]);
        if ($prepared_email->rowCount()) {

            return $prepared_email->fetch();
        } else {
            return array();
        }
    }
    // forget password (update)
    public function updatePassword($phone, $password)
    {

        $query = "UPDATE " . $this->table . " SET Password = :pass WHERE Phone = :phone";
        $prepared = $this->connect()->prepare($query);
        $prepared->bindParam(":pass", $password);
        $prepared->bindParam(":phone", $phone);
        if ($prepared->execute()) {

            return true;
        }

        return false;
    }
}
