<?php
class Animal extends Database
{
    // properties
    private $id;
    private $type;
    private $name;
    private $race;
    private $age;
    private $gender;
    private $description;
    private $url;
    private $forSale;
    private $price;
    private $idUser;

    //Setters and getters

    public function
    set_All(
        $id = NULL,
        $type = NULL,
        $name = NULL,
        $race = NULL,
        $gender = NULL,
        $description = NULL,
        $forSale = NULL,
        $url = NULL,
        $age = NULL,
        $price = NULL,
        $idUser = NULL
    ) {

        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->race = $race;
        $this->age = $age;
        $this->gender = $gender;
        $this->description = $description;
        $this->url = $url;
        $this->forSale = $forSale;
        $this->price = $price;
        $this->idUser = $idUser;
    }
    public function get()
    {
        return array(
            "type" => $this->type,
            "name" => $this->name,
            "race" => $this->race,
            "forSale" => $this->forSale,
            "description" => $this->description,
            "gender" => $this->gender,
            "url" => $this->url,
            "age" => $this->age,
            "price" => $this->price,
            "idUser" => $this->idUser
        );
    }



    public function __construct()
    {

        $this->table = "Animal";
    }

    // add new animal to database
    public function new_animal()
    {

        $query = "INSERT INTO " . $this->table . " (type,name,race,age,gender,description,forSale,url,price,idUser) VALUES (:type,:name,:race,:age,:gender,:description,:forSale,:url,:price,:idUser)";
        $prepared_Animal = $this->connect()->prepare($query);
        $prepared_Animal->bindParam(':type', $this->type);
        $prepared_Animal->bindParam(':name', $this->name);
        $prepared_Animal->bindParam(':race', $this->race);
        $prepared_Animal->bindParam(':age', $this->age);
        $prepared_Animal->bindParam(':gender', $this->gender);
        $prepared_Animal->bindParam(':description', $this->description);
        $prepared_Animal->bindParam(':url', $this->url);
        $prepared_Animal->bindParam(':forSale', $this->forSale);
        $prepared_Animal->bindParam(':price', $this->price);
        $prepared_Animal->bindParam(':idUser', $this->idUser);
        if ($prepared_Animal->execute()) {
            return true;
        }

        return false;
    }
    //get All Pets with likes
    public function GetAll()
    {
        $query = "SELECT A.* , count(L.idPet) as nbrLikes FROM " . $this->table . " A LEFT JOIN likes L on A.id=L.idPet Group BY A.id";
        $prepared_Animaux = $this->connect()->prepare($query);
        $prepared_Animaux->execute();
        if ($prepared_Animaux->rowCount()) {
            return $prepared_Animaux->fetchAll();
        } else {
            return array();
        }
    }
    // get pet info 
    public function getAnimalInfo($id)
    {

        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";

        $prepared_animal = $this->connect()->prepare($query);
        $prepared_animal->execute([$id]);
        if ($prepared_animal->rowCount()) {

            return $prepared_animal->fetch();
        } else {
            return array();
        }
    }
    // get user pets 
    public function getUserAnimaux($idUser)
    {

        $query = "SELECT * FROM " . $this->table . " WHERE idUser = ?";

        $prepared_animal = $this->connect()->prepare($query);
        $prepared_animal->execute([$idUser]);
        if ($prepared_animal->rowCount()) {

            return $prepared_animal->fetchAll();
        } else {
            return array();
        }
    }
    // get pets liked by user 
    public function GetPetsLikesByUser($idUser)
    {
        $query = "SELECT A.* FROM " . $this->table . " A join likes L on L.idPet=A.id join users U on U.id=L.idUser WHERE U.id=?";
        $prepared_Animaux = $this->connect()->prepare($query);
        $prepared_Animaux->execute([$idUser]);
        if ($prepared_Animaux->rowCount()) {
            return $prepared_Animaux->fetchAll();
        } else {
            return array();
        }
    }
}
