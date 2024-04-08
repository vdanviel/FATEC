<?php

require "../../vendor/autoload.php";

//MVC PRODUTO
use \App\Model\Produto;
use \App\Repository\ProdutoRepository;
use \App\Controller\ProdutoController;

//MVC USUARIO
use \App\Model\Usuario;
use \App\Repository\UsuarioRepository;
use \App\Controller\UsuarioController;

//HEADERS REGRAS DEFININDO
(new \App\Http\HttpHeader)->setDefaultHeaders();

//INFORMAÇÕES
$verb = $_SERVER['REQUEST_METHOD']; // O METODO REQUISITADO
$data = json_decode(file_get_contents("php://input"), true); // OS DADOS RECEBIDOS
$uri = rtrim($_SERVER['REQUEST_URI'], '/'); //A URL PARA SABER SE ESTÁ LIDANDO COM PRODUTO OU USUÁRIO

//PRODUTO
if ($uri == '/backend/router/produto' || (isset($_GET['id']) && $uri == '/backend/router/produto?id=' . $_GET['id'])) {
    
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
            
    
            $produto_repository = new ProdutoRepository;
            $produto = new Produto;
    
            echo (new ProdutoController($produto_repository, $produto))->create($data);
    
            break;
    
        case 'PUT':
    
            $produto_repository = new ProdutoRepository;
            $produto = new Produto;
    
            echo (new ProdutoController($produto_repository, $produto))->update($data);
    
            break;
    
        case 'DELETE':
    
    
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

}

//USUARIO
if ($uri == '/backend/router/usuario' || (isset($_GET['id']) && $uri == '/backend/router/usuario?id=' . $_GET['id'])) {
    
    switch ($verb) {
        
        case 'GET':
            
            if (isset($_GET['id'])) {

                $usuario_repository = new UsuarioRepository;
                $usuario = new Usuario;
        
                echo (new UsuarioController($usuario_repository, $usuario))->read($_GET['id']);
    
            }else{
    
                $usuario_repository = new UsuarioRepository;
                $usuario = new Usuario;
        
                echo (new UsuarioController($usuario_repository, $usuario))->list();
    
            }
    
            break;
    
        case 'POST':
    
            $usuario_repository = new UsuarioRepository;
            $usuario = new Usuario;
    
            echo (new UsuarioController($usuario_repository, $usuario))->create($data);
    
            break;
    
        case 'PUT':
        
    
            $usuario_repository = new UsuarioRepository;
            $usuario = new Usuario;
    
            echo (new UsuarioController($usuario_repository, $usuario))->update($data);
    
            break;
    
        case 'DELETE':

    
            $usuario_repository = new UsuarioRepository;
            $usuario = new Usuario;
    
            echo (new UsuarioController($usuario_repository, $usuario))->delete($data['id']);
    
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

}

//SE NÃO FOR NENHUM, SEM AÇÃO
if ($uri == '/backend/router') {
    
    echo "OK";

}