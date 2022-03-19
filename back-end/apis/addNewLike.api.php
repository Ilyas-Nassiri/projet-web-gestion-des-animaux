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
    include_once("../classes/Likes.php");
    //instant of class like
    $like = new Like();
    // Reads entire file into a string
    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);
    if (
        !empty($data->idPet) && !empty($data->idUser)
    ) {
        $idPet = filter_var($data->idPet, FILTER_VALIDATE_INT);
        $idUser = filter_var($data->idUser, FILTER_VALIDATE_INT);
        $like->Set_All($idPet, $idUser);
        if ($like->newLike()) {
            http_response_code(200); // ok or success

            echo json_encode(array(

                "status" => 1,
                "message" => "created successfully"
            ));
        } else {
            http_response_code(500); // Internal Server Error 

            echo json_encode(array(

                "status" => 0,
                "message" => "failed to save new like !"
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
