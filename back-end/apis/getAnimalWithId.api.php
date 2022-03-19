<?php

ini_set("display_errors", 1);

header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: POST");
header("Content-Type:application/json; Charset:UTF-8");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // include database and class Animaux
    include_once("../config/database.php");
    include_once("../classes/Animaux.php");


    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);



    $id = $data->id;

    $id = filter_var($data->id, FILTER_VALIDATE_INT);

    // all data exists

    if (!empty($id)) {

        $animal = new Animal();

        $anim = $animal->getAnimalInfo($id);


        $info = array();

        $st = array(
            "id" => $anim["id"],
            "type" => $anim["type"],
            "name" => $anim["name"],
            "race" => $anim["race"],
            "gender" => $anim["gender"],
            "description" => $anim["description"],
            "forSale" => $anim["forSale"],
            "url" => $anim["url"],
            "age" => $anim["age"],
            "price" => $anim["price"],
            "idUser" => $anim["idUser"]
        );

        array_push($info, $st);

        http_response_code(200);

        echo json_encode(array(

            "status" => 1,
            "animal" => $info,
            "message" => "data has been bred successfully ..!"
        ));
    }
} else {

    http_response_code(513);

    echo json_encode(array(

        "status" => 0,
        "message" => "Access Denied"
    ));
}
