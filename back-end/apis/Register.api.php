<?php

ini_set("display_errors", 1);
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Content-Type:application/json;");
header("Content-Type:application/json; Charset:UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//header("Content-Type: text/html; charset=UTF-8"); //for html & text 
//header("Content-Type: multipart/form-data; boundary=something"); //for files like images , pdf and son

header("Access-Control-Allow-Headers: *");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // include database
    include_once("../config/database.php");
    include_once("../classes/users.php");


    $user = new Users();

    $inputs_data = file_get_contents("php://input");

    $data = json_decode($inputs_data);

    // check if the are all data
    if (!empty($data->userName) && !empty($data->LastName) && !empty($data->FirstName) && !empty($data->email) && !empty($data->role) && !empty($data->password) && !empty($data->phone) && !empty($data->photo)) {
        $userName = filter_var($data->userName, FILTER_SANITIZE_STRING);
        $LastName = filter_var($data->LastName, FILTER_SANITIZE_STRING);
        $FirstName = filter_var($data->FirstName, FILTER_SANITIZE_STRING);
        $email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($data->password, FILTER_SANITIZE_STRING);
        $role = filter_var($data->role, FILTER_SANITIZE_STRING);
        $phone = filter_var($data->phone, FILTER_SANITIZE_STRING);
        $photo = filter_var($data->photo, FILTER_SANITIZE_STRING);


        // hashing password with  sha256 algo
        $password = hash("sha256", $password);



        // set all necessary credentials 
        $user->setAll($userName, $LastName, $FirstName, $email, $role, $password, $phone, $photo);

        if ($user->new_user()) {

            http_response_code(200);

            echo json_encode(array(

                "status" => 1,
                "message" => "created successfully"
            ));
        } else {

            http_response_code(500);

            echo json_encode(array(

                "status" => 0,
                "message" => "failed to save new user !"
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
