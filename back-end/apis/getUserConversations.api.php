<?php

ini_set("display_errors", 1);

header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: POST");
header("Content-Type:application/json; Charset:UTF-8");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // include database and class conversation
    include_once("../config/database.php");
    include_once("../classes/conversation.php");


    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);


    $idUser = filter_var($data->idUser, FILTER_VALIDATE_INT);

    // all data exists

    if (!empty($idUser)) {

        $conversation = new Conversation();

        $convs = $conversation->getUserConversations($idUser);


        $userConversations = array();
        foreach ($convs as $key => $value) {
            $st = array(
                "room" => $convs[$key]["room"],
                "idUserA" => $convs[$key]["idUserA"],
                "idUserB" => $convs[$key]["idUserB"],
                "photoA" => $convs[$key]["photoA"],
                "photoB" => $convs[$key]["photoB"],
                "userNameA" => $convs[$key]["UserNameA"],
                "userNameB" => $convs[$key]["UserNameB"],
                "phoneA" => $convs[$key]["phoneA"],
                "phoneB" => $convs[$key]["phoneB"]
            );

            array_push($userConversations, $st);
        }

        http_response_code(200);

        echo json_encode(array(

            "status" => 1,
            "userConversations" => $userConversations,
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
