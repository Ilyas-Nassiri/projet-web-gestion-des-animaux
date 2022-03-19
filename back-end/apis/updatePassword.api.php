<?php


ini_set("display_errors", 1);
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Content-Type:application/json;");
header("Content-Type:application/json; Charset:UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


	// include database and class users
	include_once("../config/database.php");
	include_once("../classes/users.php");
	$inputs_data = file_get_contents("php://input");
	$data = json_decode($inputs_data);


	$phone = filter_var($data->phone, FILTER_SANITIZE_STRING);
	$password = filter_var($data->password, FILTER_SANITIZE_STRING);

	$password = hash("sha256", $password);


	if (empty($phone) || empty($password)) {

		http_response_code(204);

		echo json_encode(array(
			"status" => 0,
			"message" => "all data nedeed"
		));
		exit();
	}

	// all data exists

	$user = new Users();

	if ($user->updatePassword($phone, $password)) {

		http_response_code(200);
		echo json_encode(array(
			"status" => 1,
			"message" => "success"
		));
	} else {

		http_response_code(410);
		echo json_encode(array(
			"status" => 0,
			"message" => "no credenials"
		));
	}
} else {


	http_response_code(505);

	echo json_encode(array(

		"status" => 0,
		"message" => "access denied"
	));
}
