<?php

include "../vendor/autoload.php";
// JWT SECTION
use \Firebase\JWT\JWT;

class CrJwt
{

    use Payload;

    private $iss;  // issued by (generally host name we can specify or any information )
    private $iat;  // issued at (at wich time we have created , simply it will be current time )
    private $nbf;    // not before (means we will not be allow to use this token until this time ) 
    // & the next api token generator after this time 
    private $exp;    // expiration time (the expiration time for generated token ; default 1 hour)
    private $aud; // audiance
    private $user_arr_data; // authenitication user data


    // secret key & algo
    private static $secret_key = '5361696441697444726973734032303231';
    private static $algo = "4853353132";

    private static $jwt_token;

    // enocde 
    public function __construct($user_data)
    {

        $this->user_arr_data = $this->prepare_user_arr_data($user_data);


        $this->prepare();
        self::$secret_key = '5361696441697444726973734032303231';
        self::$algo = "4853353132";
        self::$secret_key = hex2bin(self::$secret_key);
        self::$algo = hex2bin(self::$algo);
    }


    public function encode_User_data()
    {

        // signature 
        $jwt = JWT::encode($this->payload_info(), self::$secret_key, self::$algo);

        return $jwt;
    }


    // decode 
    public static function decode_Constructor($token)
    {

        self::$jwt_token = $token;
        self::$secret_key = '5361696441697444726973734032303231';
        self::$algo = "4853353132";
        self::$secret_key = hex2bin(self::$secret_key);
        self::$algo = hex2bin(self::$algo);
    }

    public static function decode_User_data()
    {

        $decoded_data = JWT::decode(self::$jwt_token, self::$secret_key, array(self::$algo));

        return $decoded_data;
    }
}


trait Payload
{

    private function prepare_user_arr_data($user_data)
    {
  
        return array(
            'id' => $user_data["id"],
            'userName' => $user_data["userName"],
            "LastName" => $user_data["LastName"],
            "FirstName" => $user_data["FirstName"],
            "email" => $user_data["email"],
            "role" => $user_data["role"],
            "phone" => $user_data["phone"],
            "password" => $user_data["password"],
            "photo" => $user_data["photo"]
        );
    }

    private function prepare()
    {

        $this->iss = "localhost";
        $this->iat = time();
        $this->nbf = $this->iat + 10; // before 30 s
        $this->exp = $this->iat + 3000; // after one day
        $this->aud = "Users";  // users (means all users include 'client', 'admin' and 'supper Admin' )

    }

    private function payload_info()
    {

        return array(
            'iss' => $this->iss,
            'iat' => $this->iat,
            'nbf' => $this->nbf,
            'exp' => $this->exp,
            'aud' => $this->aud,
            'data' => $this->user_arr_data,
        );
    }
}
