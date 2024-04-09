<?php
namespace App\Repository;

use App\Database\Database;
use App\Model\Produto;

class ProdutoRepository {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function cadastrar_produto(Produto $produto){

        try {
            
            //recuperando dados definidos...
            $nome = $produto->get('nome');
            $preco = $produto->get('preco');
            $descricao = $produto->get('descricao');
            $categoria = $produto->get('categoria');
            $quantidade = $produto->get('quantidade');

            //validando se porduto já existe..
            $existe = $this->conn->prepare("SELECT * FROM produtos WHERE nome = :nome");

            $existe->bindParam(':nome', $nome);

            $existe->execute();

            $produto = $existe->fetch(\PDO::FETCH_ASSOC);

            if(is_array($produto)) return ['error' => 'produto_existe'];

            $stmt = $this->conn->prepare("INSERT INTO produtos(nome,preco,descricao,categoria,quantidade) VALUES(:nome,:preco,:desc,:cate,:qnt)");


            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':desc', $descricao);
            $stmt->bindParam(':cate', $categoria);
            $stmt->bindParam(':qnt', $quantidade);

            return $stmt->execute();

        } catch (\Throwable | \Exception | \PDOException $th) {
            
            return ['error' => $th->getMessage()];

        }

    }

    public function listar_produto(){

        try {
            
            $stmt = $this->conn->prepare("SELECT * FROM produtos");

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\Throwable | \Exception | \PDOException $th) {
            
            return ['error' => $th->getMessage()];

        }
    }

    public function achar_produto(Produto $produto){

        try {
            
            $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE id = :id");

            $id = $produto->get('id');

            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\Throwable | \Exception | \PDOException $th) {
            
            return ['error' => $th->getMessage()];

        }

    }

    public function atualizar_produto(Produto $produto){
        try {
            $stmt = $this->conn->prepare("UPDATE produtos SET nome = :nome, preco = :preco, descricao = :desc, categoria = :cate, quantidade = :qnt WHERE id = :id");
    
            $id = $produto->get('id');
            $nome = $produto->get('nome');
            $preco = $produto->get('preco');
            $descricao = $produto->get('descricao');
            $categoria = $produto->get('categoria');
            $quantidade = $produto->get('quantidade');
    
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':desc', $descricao);
            $stmt->bindParam(':cate', $categoria);
            $stmt->bindParam(':qnt', $quantidade);
    
            return $stmt->execute();
        } catch (\Throwable | \Exception | \PDOException $th) {
            return ['error' => $th->getMessage()];
        }
    }

    public function deletar_produto(Produto $produto){

        try {
            
            $stmt = $this->conn->prepare("DELETE FROM produtos WHERE id = :id");

            $id = $produto->get('id');

            $stmt->bindParam(':id', $id);

            return $stmt->execute();

        } catch (\Throwable | \Exception | \PDOException $th) {
            
            return ['error' => $th->getMessage()];

        }

    }
}    
