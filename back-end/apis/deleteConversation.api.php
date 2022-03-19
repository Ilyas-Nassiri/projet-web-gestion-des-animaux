<?php
ini_set("display_errors", 1);
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Content-Type:application/json;");
header("Content-Type:application/json; Charset:UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once("../config/database.php");
    include_once("../classes/conversation.php");

    $conversation = new Conversation();
    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);
    if (
        !empty($data->room)
    ) {
        $room = filter_var($data->room, FILTER_SANITIZE_STRING);

        if ($conversation->deleteConversation($room)) {
            http_response_code(200);

            echo json_encode(array(

                "status" => 1,
                "message" => "deleted successfully"
            ));
        } else {
            http_response_code(500);

            echo json_encode(array(

                "status" => 0,
                "message" => "failed to delete conversation !"
            ));
        }
    } else {

        http_response_code(204); // NO DATA

        echo json_encode(array(

            "status" => 0,
            "message" => "All data needed !"
        ));
    }
} else {
    http_response_code(503);

    echo json_encode(array(

        "status" => 0,
        "message" => "Access Denied"
    ));
}
