<?php
class Like extends Database
{
    // properties
    private $idUser;
    private $idPet;
    //Getters and setters
    public function Set_All($idPet = NULL, $idUser = NULL)
    {
        $this->idPet = $idPet;
        $this->idUser = $idUser;
    }
    public function Get_All()
    {
        return array(
            "idPet" => $this->idPet,
            "idUser" => $this->idUser
        );
    }

    public function __construct()
    {

        $this->table = "likes";
    }
    // add new like to Pets
    public function newLike()
    {
        $query = "INSERT INTO " . $this->table . " (idPet,idUser) VALUES (:idPet,:idUser)";
        $prepared_Like = $this->connect()->prepare($query);
        $prepared_Like->bindParam(':idPet', $this->idPet);
        $prepared_Like->bindParam(':idUser', $this->idUser);
        if ($prepared_Like->execute()) {
            return true;
        }

        return false;
    }
    // delete like from pet
    public function deleteLike($idPet, $idUser)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idPet=? and idUser=?";
        $prepared_del = $this->connect()->prepare($query);
        if ($prepared_del->execute([$idPet, $idUser])) {
            return true;
        }
        return false;
    }
}
