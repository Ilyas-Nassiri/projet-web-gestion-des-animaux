<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST");
header("Content-Type:application/json;");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // include database and class animaux
    include_once("../config/database.php");
    include_once("../classes/Animaux.php");

    $animal = new Animal();
    $animaux = $animal->GetAll();
    $anim = array();
    foreach ($animaux as $key => $value) {

        $st = array(
            "id" => $animaux[$key]["id"],
            "type" => $animaux[$key]["type"],
            "name" => $animaux[$key]["name"],
            "race" => $animaux[$key]["race"],
            "gender" => $animaux[$key]["gender"],
            "description" => $animaux[$key]["description"],
            "forSale" => $animaux[$key]["forSale"],
            "url" => $animaux[$key]["url"],
            "age" => $animaux[$key]["age"],
            "price" => $animaux[$key]["price"],
            "idUser" => $animaux[$key]["idUser"],
            "nbrLikes" => $animaux[$key]["nbrLikes"]
        );
        array_push($anim, $st);
    }

    http_response_code(200);

    echo json_encode(array(

        "status" => 1,
        "animaux" => $anim,
        "message" => "data has been bred successfully ..!"
    ));
} else {

    http_response_code(513);

    echo json_encode(array(

        "status" => 0,
        "message" => "Access Denied"
    ));
}
