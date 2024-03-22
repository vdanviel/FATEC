<?php
namespace App\Controller;

use App\Model\Produto;
use App\Repository\ProdutoRepository;

class ProdutoController {
    private $repository;
    private $model;

    public function __construct(ProdutoRepository $repository, Produto $model) {
        $this->repository = $repository;
        $this->model = $model;
    }
    
    public function create(array $data) {


        try {

            //validação
            if (!isset($data['nome'], $data['descricao'], $data['preco'], $data['quantidade'], $data['categoria'])) {
                
                http_response_code(400);
                return json_encode(['error' => 'Preencha todos os campos.']);

            }

            $produto = $this->model;

            $produto->set('nome', $data['nome']);
            $produto->set('descricao', $data['descricao']);
            $produto->set('preco', floatval($data['preco']));
            $produto->set('quantidade', $data['quantidade']);
            $produto->set('categoria', $data['categoria']);

            $create = $this->repository->cadastrar_produto($produto);

            if (isset($create['error'])) {
                return json_encode(['error' =>$create['error']]);
            }

            if ($create == true) {
                http_response_code(201);
                return json_encode(['success' => 'Produto cadastrado com sucesso!']);
            }else {
                http_response_code(400);
                return json_encode(['error' => 'Não foi possível criar o produto.']);
            }
            

        } catch (\Exception $th) {
            return $th;
        }

    }

    public function list() {

        try {
            
            $produtos = $this->repository->listar_produto();

            http_response_code(200);
            echo json_encode($produtos);

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

            $read = $this->repository->achar_produto($produto);

            if (isset($read['error'])) {
                return json_encode(['error' =>$read['error']]);
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
            if (!isset($data['id'], $data['nome'], $data['descricao'], $data['preco'], $data['quantidade'], $data['categoria'])) {
                http_response_code(400);
                return json_encode(['error' => 'Preencha todos os campos.']);
            }
    
            $produto = $this->model;
    
            $produto->set('id', $data['id']);
            $produto->set('nome', $data['nome']);
            $produto->set('descricao', $data['descricao']);
            $produto->set('preco', floatval($data['preco']));
            $produto->set('quantidade', $data['quantidade']);
            $produto->set('categoria', $data['categoria']);
    
            $update = $this->repository->atualizar_produto($produto);
    
            if ($update === true) {
                http_response_code(200);
                return json_encode(['success' => 'Produto atualizado com sucesso!']);
            } else {
                http_response_code(400);
                return json_encode(['error' => 'Não foi possível atualizar o produto.']);
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

            $produto = $this->model;

            $produto->set('id', $id);

            $delete = $this->repository->deletar_produto($produto);

            if (isset($delete['error'])) {
                return json_encode(['error' =>$delete['error']]);
            }

            if ($delete == true) {
                http_response_code(200);
                return json_encode(['success' => 'Produto deletado com sucesso!']);
            }else {
                http_response_code(400);
                return json_encode(['error' => 'Não foi possível deletar o produto.']);
            }

        } catch (\Exception $th) {
            return $th;
        }

    }
}
