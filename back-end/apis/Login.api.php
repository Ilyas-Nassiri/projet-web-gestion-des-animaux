<?php

// display errors messages
ini_set("display_errors", 1);

header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: POST");
header("Content-Type:application/json; Charset:UTF-8");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // include database
    include_once("../config/database.php");
    include_once("../config/jwt.php");
    include_once("../classes/users.php");

    // create new user from class users
    $user = new Users();

    $inputs_data = file_get_contents("php://input");

    $data = json_decode($inputs_data);


    // check if the are all data
    if (!empty($data->email) && !empty($data->password && !empty($data->role))) {

        $email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($data->password, FILTER_SANITIZE_STRING);
        $role = filter_var($data->role, FILTER_SANITIZE_STRING);


        // hashing password with  sha256 algo
        $password = hash("sha256", $password);
        // set all necessary credentials 
        $user->setAll(NULL, NULL, NULL, $email, $role, $password, NULL, NULL);

        $user_data = $user->get_user_forLogin();

        if (!empty($user_data)) {

            // using jwt 
            $jwt = new CrJwt($user_data);

            $jwt_token = $jwt->encode_User_data();


            http_response_code(200);
            echo json_encode(array(

                "status" => 1,
                "jwt_token" => $jwt_token,
                "message" => "user logged in successfuly !"
            ));

            exit();
        }


        // else ( user enters invalid credentials )
        http_response_code(204);

        echo json_encode(array(
            "status" => 0,
            "message" => "email or password incorrect !"
        ));
    } else {

        http_response_code(206);

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
