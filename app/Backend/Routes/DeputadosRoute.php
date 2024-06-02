<?php

namespace App\Deputados;
require "../../vendor/autoload.php";

use App\Controller\DeputadosController;
use App\Model\Deputados;

$deputados = new Deputados();

header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: * ' );
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Cache-Control: no-cache, no-store, must-revalidate');

$body = json_decode(file_get_contents('php://input'), true);
$id = isset($_GET['id']) ? $_GET['id'] : '';
switch($_SERVER["REQUEST_METHOD"]){
    case "POST";
        $deputados->setNome($body['nome']);
        $deputados->setSexo($body['sexo']);
        $deputados->setPartido($body['partido']);
        $deputados->setEmail($body['email']);
        $deputados->setCep($body['cep']);
        $deputados->setCidade($body['cidade']);
        $deputados->setBairro($body['bairro']);
        $deputados->setRua($body['rua']);
        $deputados->setLatitude($body['latitude']);
        $deputados->setLongitude($body['longitude']);
        
        $deputadosController = new DeputadosController($deputados);
        $resultado = $deputadosController->inserir();
        echo json_encode(['status' => $resultado]);
    break;
    case "GET";
        $deputadosController = new DeputadosController($deputados);
        if(!isset($_GET['id'])){
            $resultado = $deputadosController->buscarTodos();
            if(!$resultado){
                echo json_encode(["status" => false, "Deputados" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                exit;
            }else{
                echo json_encode(["status" => true, "Deputados" => $resultado]);
                exit;
            }
        }else{
            $resultado = $deputadosController->buscarId($id);
            if(!$resultado){
                echo json_encode(["status" => false, "Deputados" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                exit;
            }else{
                echo json_encode(["status" => true, "Deputados" => $resultado[0]]);
                exit;
            }
        }
    break;
    case "PUT";
        $deputados->setNome($body['nome']);
        $deputados->setSexo($body['sexo']);
        $deputados->setPartido($body['partido']);
        $deputados->setEmail($body['email']);
        $deputados->setCep($body['cep']);
        $deputados->setCidade($body['cidade']);
        $deputados->setBairro($body['bairro']);
        $deputados->setRua($body['rua']);
        $deputados->setLatitude($body['latitude']);
        $deputados->setLongitude($body['longitude']);
        
        $deputadosController = new DeputadosController($deputados);
        $resultado = $deputadosController->atualizarId(intval($_GET['id']));
        echo json_encode(['status' => $resultado]);
    break;
    case "DELETE";
        $deputadosController = new DeputadosController($deputados);
        $resultado = $deputadosController->excluir(intval($_GET['id']));
        echo json_encode(['status' => $resultado]);
    break;  
}