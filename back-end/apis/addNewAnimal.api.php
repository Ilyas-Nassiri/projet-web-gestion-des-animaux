<?php
ini_set("display_errors", 1);
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Content-Type:application/json;");
header("Content-Type:application/json; Charset:UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // include database and class animaux
    include_once("../config/database.php");
    include_once("../classes/Animaux.php");

    $animal = new Animal();

    $inputs_data = file_get_contents("php://input");
    $data = json_decode($inputs_data);

    if (
        !empty($data->type) && !empty($data->name)
        && !empty($data->race) && !empty($data->age) && !empty($data->gender) && !empty($data->description)
        && !empty($data->url) && !empty($data->forSale) && !empty($data->price) && !empty($data->idUser)
    ) {
        $type = filter_var($data->type, FILTER_SANITIZE_STRING);
        $name = filter_var($data->name, FILTER_SANITIZE_STRING);
        $race = filter_var($data->race, FILTER_SANITIZE_STRING);
        $age = filter_var($data->age, FILTER_SANITIZE_STRING);
        $gender = filter_var($data->gender, FILTER_SANITIZE_STRING);
        $description = filter_var($data->description, FILTER_SANITIZE_STRING);
        $url = filter_var($data->url, FILTER_SANITIZE_STRING);
        $forSale = filter_var($data->forSale, FILTER_SANITIZE_STRING);
        $price = filter_var($data->price, FILTER_SANITIZE_STRING);
        $idUser = filter_var($data->idUser, FILTER_VALIDATE_INT);

        $animal->set_All(NULL, $type, $name, $race, $gender, $description, $forSale, $url, $age, $price, $idUser);

        if ($animal->new_animal()) {
            http_response_code(200);

            echo json_encode(array(

                "status" => 1,
                "message" => "created successfully"
            ));
        } else {
            http_response_code(500);

            echo json_encode(array(

                "status" => 0,
                "message" => "failed to save new Animal !"
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
