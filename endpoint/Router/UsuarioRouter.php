<?php
require "../../vendor/autoload.php";

use App\Controller\UsuarioController;
use App\Http\HttpHeader;
use App\Repository\UsuarioRepository;

HttpHeader::setDefaultHeaders();

$repository = new UsuarioRepository(); 
$controller = new UsuarioController($repository);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}
$action = 'default'; 
if (isset($_GET['action'])) {
    $action = $_GET['action']; 
}
$data = json_decode(file_get_contents("php://input"));

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($action) {
            case 'login':
                $controller->login($data);
                break;
            default:
                $controller->create($data);
                break;
        }
        break;
    case 'GET':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller->read($id);
        break;
    case 'PUT':
        $controller->update($data);
        break;
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id === null) {
            HttpHeader::sendNotAllowedMethod();
        }
        $controller->delete($id);
        break;
    default:
        HttpHeader::sendNotAllowedMethod();
        break;
}
