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

    $idUser = filter_var($data->idUser, FILTER_VALIDATE_INT);

    // all data exists

    if (!empty($idUser)) {

        $animal = new Animal();

        $anim = $animal->getUserAnimaux($idUser);


        $UserAnimaux = array();
        foreach ($anim as $key => $value) {
            $st = array(
                "id" => $anim[$key]["id"],
                "type" => $anim[$key]["type"],
                "name" => $anim[$key]["name"],
                "race" => $anim[$key]["race"],
                "gender" => $anim[$key]["gender"],
                "description" => $anim[$key]["description"],
                "forSale" => $anim[$key]["forSale"],
                "url" => $anim[$key]["url"],
                "age" => $anim[$key]["age"],
                "price" => $anim[$key]["price"],
                "idUser" => $anim[$key]["idUser"]
            );

            array_push($UserAnimaux, $st);
        }

        http_response_code(200);

        echo json_encode(array(

            "status" => 1,
            "userAnimaux" => $UserAnimaux,
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
