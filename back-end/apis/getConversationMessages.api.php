<?php

ini_set("display_errors", 1);

header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: POST");
header("Content-Type:application/json; Charset:UTF-8");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // include database and class animaux
    include_once("../config/database.php");
    include_once("../classes/message.php");


    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);


    $room = filter_var($data->room, FILTER_VALIDATE_INT);

    // all data exists

    if (!empty($room)) {

        $msg = new Message();

        $messages = $msg->getMessagesConversation($room);


        $msgsConversation = array();
        foreach ($messages as $key => $value) {
            $st = array(
                "idMessage" => $messages[$key]["idMessage"],
                "message" => $messages[$key]["message"],
                "date" => $messages[$key]["date"],
                "idUser" => $messages[$key]["idUser"],
                "room" => $messages[$key]["room"]
            );

            array_push($msgsConversation, $st);
        }

        http_response_code(200);

        echo json_encode(array(

            "status" => 1,
            "conversationMessages" => $msgsConversation,
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
