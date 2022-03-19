<?php
ini_set("display_errors", 1);
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Content-Type:application/json;");
header("Content-Type:application/json; Charset:UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // include database and class Likes
    include_once("../config/database.php");
    include_once("../classes/Likes.php");
    
    $like = new Like();
    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);
    if (
        !empty($data->idPet) && !empty($data->idUser)
    ) {
        $idPet = filter_var($data->idPet, FILTER_VALIDATE_INT);
        $idUser = filter_var($data->idUser, FILTER_VALIDATE_INT);

        if ($like->deleteLike($idPet, $idUser)) {
            http_response_code(200);

            echo json_encode(array(

                "status" => 1,
                "message" => "deleted successfully"
            ));
        } else {
            http_response_code(500);

            echo json_encode(array(

                "status" => 0,
                "message" => "failed to delete like !"
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
