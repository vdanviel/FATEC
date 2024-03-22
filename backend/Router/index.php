<?php

require "../../vendor/autoload.php";

//chamando model de produto..
use \App\Model\Produto;
use \App\Repository\ProdutoRepository;
use \App\Controller\ProdutoController;

$verb = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents("php://input"), true);

switch ($verb) {
    case 'GET':
        
        if (isset($_GET['id'])) {
            
            $produto_repository = new ProdutoRepository;
            $produto = new Produto;
    
            echo (new ProdutoController($produto_repository, $produto))->read($_GET['id']);

        }else{

            $produto_repository = new ProdutoRepository;
            $produto = new Produto;
    
            echo (new ProdutoController($produto_repository, $produto))->list();

        }

        break;

    case 'POST':
        
        $data = json_decode(file_get_contents('php://input'),true);

        $produto_repository = new ProdutoRepository;
        $produto = new Produto;

        echo (new ProdutoController($produto_repository, $produto))->create($data);

        break;

    case 'PUT':
        
        $data = json_decode(file_get_contents('php://input'),true);

        $produto_repository = new ProdutoRepository;
        $produto = new Produto;

        echo (new ProdutoController($produto_repository, $produto))->update($data);

        break;

    case 'DELETE':

        $data = json_decode(file_get_contents('php://input'),true);

        $produto_repository = new ProdutoRepository;
        $produto = new Produto;

        echo (new ProdutoController($produto_repository, $produto))->delete($data['id']);

        break;
    
    default:
        echo json_encode(
            [
                'response' => [
                    'error' => 'Nao encontrado.'
                ]
            ]
        );
        break;
}