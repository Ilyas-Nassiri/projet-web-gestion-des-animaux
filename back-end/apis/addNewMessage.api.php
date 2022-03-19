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
    include_once("../classes/message.php");

    $msg = new Message();
    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);
    if (
        !empty($data->message) && !empty($data->date) && !empty($data->idUser) && !empty($data->room)
    ) {
        $mess = filter_var($data->message, FILTER_SANITIZE_STRING);
        $date = filter_var($data->date, FILTER_SANITIZE_STRING);
        $idUser = filter_var($data->idUser, FILTER_VALIDATE_INT);
        $room = filter_var($data->room, FILTER_SANITIZE_STRING);
        $msg->Set_All($mess, $date, $idUser, $room);
        if ($msg->new_Message()) {
            http_response_code(200);

            echo json_encode(array(

                "status" => 1,
                "message" => "created successfully"
            ));
        } else {
            http_response_code(500);

            echo json_encode(array(

                "status" => 0,
                "message" => "failed to save new message !"
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
