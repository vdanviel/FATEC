<?php
namespace App\Controller;

use App\Model\Usuario;
use App\Repository\UsuarioRepository;

class UsuarioController {
    private $repository;
    private $model;

    public function __construct(UsuarioRepository $repository, Usuario $model) {
        $this->repository = $repository;
        $this->model = $model;
    }

    public function create(array $data) {


        try {

            //validação
            if (!isset($data['nome'], $data['email'], $data['senha'], $data['nascimento'])) {
                
                http_response_code(400);
                return json_encode(['error' => 'Preencha todos os campos.']);

            }

            $usuario = $this->model;

            $usuario->set('nome', $data['nome']);
            $usuario->set('email', $data['email']);
            $usuario->set('senha', $data['senha']);
            $usuario->set('datanascimento', $data['nascimento']);

            $create = $this->repository->cadastrar_usuario($usuario);

            if (isset($create['error'])) {
                return json_encode(['error' => $create['error']]);
            }

            if ($create == true) {
                http_response_code(201);
                return json_encode(['success' => 'Usuário cadastrado com sucesso!']);
            }else {
                http_response_code(400);
                return json_encode(['error' => 'Não foi possível criar o usuário.']);
            }
            

        } catch (\Exception $th) {
            return $th;
        }

    }

    public function list() {

        try {
            
            $usuarios = $this->repository->listar_usuarios();

            http_response_code(200);
            echo json_encode($usuarios);

        } catch (\Exception $th) {
            return $th;
        }


    }

    public function read($id) {

        try {
            
            //validação
            if (!isset($id)) {

                http_response_code(400);
                return json_encode(['error' => 'Preencha todos os campos.']);

            }

            $produto = $this->model;

            $produto->set('id', $id);

            $read = $this->repository->achar_usuario($produto);

            if (isset($read['error'])) {
                return json_encode(['error' => $read['error']]);
            }

            http_response_code(200);
            echo json_encode($read);

        } catch (\Exception $th) {
            return $th;
        }

    }

    public function update($data) {
        try {
            //validação
            if (!isset($data['nome'], $data['email'], $data['senha'], $data['nascimento'])) {
                
                http_response_code(400);
                return json_encode(['error' => 'Preencha todos os campos.']);

            }
    
            $usuario = $this->model;

            $usuario->set('nome', $data['nome']);
            $usuario->set('email', $data['email']);
            $usuario->set('senha', $data['senha']);
            $usuario->set('datanascimento', $data['nascimento']);
    
            $update = $this->repository->atualizar_usuario($usuario);
    
            if ($update === true) {
                http_response_code(200);
                return json_encode(['success' => 'Usuário atualizado com sucesso!']);
            } else {
                http_response_code(400);
                return json_encode(['error' => 'Não foi possível atualizar o usuário.']);
            }
            
        } catch (\Exception $th) {
            return $th;
        }
    }

    public function delete($id) {

        try {
            
            //validação
            if (!isset($id)) {
                
                http_response_code(400);
                return json_encode(['error' => 'Preencha todos os campos.']);

            }

            $usuario = $this->model;

            $usuario->set('id', $id);

            $delete = $this->repository->deletar_usuario($usuario);

            if (isset($delete['error'])) {
                return json_encode(['error' =>$delete['error']]);
            }

            if ($delete == true) {
                http_response_code(200);
                return json_encode(['success' => 'Usuário deletado com sucesso!']);
            }else {
                http_response_code(400);
                return json_encode(['error' => 'Não foi possível deletar o usuário.']);
            }

        } catch (\Exception $th) {
            return $th;
        }

    }
}
