<?php
namespace App\Controller;

use App\Model\Usuario;
use App\Repository\UsuarioRepository;

class UsuarioController {
    private $repository;

    public function __construct(UsuarioRepository $repository) {
        $this->repository = $repository;
    }
    public function login($data) {
        if (!isset($data->email, $data->senha)) {
            http_response_code(400);
            echo json_encode(["error" => "Email e senha são necessários para o login."]);
            return;
        }
    
        $usuario = $this->repository->getUsuarioByEmail($data->email);
        if ($usuario && password_verify($data->senha, $usuario['senha'])) {
            unset($usuario['senha']);
            http_response_code(200);
            echo json_encode(["message" => "Login bem-sucedido.", "usuario" => $usuario]);
        } else {
            http_response_code(401); 
            echo json_encode(["error" => "Email ou senha inválidos."]);
        }
    }
    
    public function create($data) {
        if (!isset($data->nome, $data->email, $data->senha)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos para a criação do usuário."]);
            return;
        }
        
        $usuarioExistente = $this->repository->getUsuarioByEmail($data->email);
        if ($usuarioExistente) {
            http_response_code(409);
            echo json_encode(["error" => "Um usuário com esse e-mail já existe."]);
            return;
        }
        $usuario = new Usuario();
        $usuario->setNome($data->nome)->setEmail($data->email)->setSenha($data->senha);

        if ($this->repository->insertUsuario($usuario)) {
            http_response_code(201);
            echo json_encode(["message" => "Usuário criado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao criar usuário."]);
        }
    }

    public function read($id = null) {
        if ($id) {
            $result = $this->repository->getUsuarioById($id);
            unset($result['senha']);
            $status = $result ? 200 : 404;
        } else {
            $result = $this->repository->getAllUsuarios();
            foreach ($result as &$usuario) {
                unset($usuario['senha']);
            }
            unset($usuario);
            $status = !empty($result) ? 200 : 404;
        }

        http_response_code($status);
        echo json_encode($result ?: ["message" => "Nenhum usuário encontrado."]);
    }

    public function update($data) {
        if (!isset($data->usuario_id, $data->nome, $data->email, $data->senha)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos para atualização do usuário."]);
            return;
        }

        $usuario = new Usuario();
        $usuario->setUsuarioId($data->usuario_id)->setNome($data->nome)->setEmail($data->email)->setSenha($data->senha);

        if ($this->repository->updateUsuario($usuario)) {
            http_response_code(200);
            echo json_encode(["message" => "Usuário atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao atualizar usuário."]);
        }
    }

    public function delete($id) {
        if ($this->repository->deleteUsuario($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Usuário excluído com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao excluir usuário."]);
        }
    }
}
