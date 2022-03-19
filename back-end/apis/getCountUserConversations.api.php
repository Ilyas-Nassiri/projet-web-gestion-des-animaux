<?php

ini_set("display_errors", 1);

header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: POST");
header("Content-Type:application/json; Charset:UTF-8");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // include database and class animaux
    include_once("../config/database.php");
    include_once("../classes/conversation.php");


    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);


    $idUser = filter_var($data->idUser, FILTER_VALIDATE_INT);

    // all data exists

    if (!empty($idUser)) {

        $conversation = new Conversation();

        $convs = $conversation->getCountConversations($idUser);


        $UserCountConvers = array();
        $st = array(
            "nbrConversations" => $convs["nbrConversations"]
        );
        array_push($UserCountConvers, $st);


        http_response_code(200);

        echo json_encode(array(

            "status" => 1,
            "nombreConversations" => $UserCountConvers,
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
