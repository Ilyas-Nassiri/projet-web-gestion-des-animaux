<?php
ini_set("display_errors", 1);
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Content-Type:application/json;");
header("Content-Type:application/json; Charset:UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // include database and class conversation
    include_once("../config/database.php");
    include_once("../classes/conversation.php");
    //instant of class conversation
    $conversation = new Conversation();
    // Reads entire file into a string
    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);
    //verification data 
    // data not empty
    if (
        !empty($data->room) && !empty($data->idUserA) && !empty($data->idUserB)
    ) {
        $room = filter_var($data->room, FILTER_SANITIZE_STRING);
        $idUserA = filter_var($data->idUserA, FILTER_VALIDATE_INT);
        $idUserB = filter_var($data->idUserB, FILTER_VALIDATE_INT);
        $conversation->set_All($room, $idUserA, $idUserB);
        // add new user
        if ($conversation->new_conversation()) {
            http_response_code(200); // ok or success

            echo json_encode(array(

                "status" => 1,
                "message" => "created successfully"
            ));
        } else {
            http_response_code(500); // Internal Server Error 

            echo json_encode(array(

                "status" => 0,
                "message" => "failed to save new user !"
            ));
        }
    } else // data empty
    {

        http_response_code(204); // No Content

        echo json_encode(array(

            "status" => 0,
            "message" => "All data needed !"
        ));
    }
} else {
    http_response_code(503); //Service Unavailable

    echo json_encode(array(

        "status" => 0,
        "message" => "Access Denied"
    ));
}
