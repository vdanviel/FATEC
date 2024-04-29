<?php

require '../vendor/autoload.php';

header('Content-Type: application/json');

$verb = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

$key = 'secret_key';

switch ($verb) {
    case 'POST':
        
        if (isset($data['email'], $data['password']) && $data['email'] == 'email@email.com' && $data['password'] == 'password') {

            $payload = [
                'iss' => 'example.org',
                'aud' => 'example.com',
                'iat' => 1356999524,
                'nbf' => 1357000000,
                'sub' => 'id',
                'exp' => time() + (60 * 1)//um minuto
            ];        

            $jwt = Firebase\JWT\JWT::encode($payload, $key, 'HS256');

            echo json_encode(
                [
                    'token' => $jwt,
                    'status' => true
                ]
            );

        }else{
            echo "invalid credentials.";
        }

        break;

        case 'GET':

            try {
                $decoded = Firebase\JWT\JWT::decode($data['jwt'], new Firebase\JWT\Key($key, 'HS256'));
                
                echo json_encode($decoded);

            } catch (\Throwable $th) {
                
                echo $th->getMessage();

            }

            break;
    
    default:
        
        echo 'none';

        break;
}