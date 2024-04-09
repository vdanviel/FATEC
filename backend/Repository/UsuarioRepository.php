<?php
namespace App\Repository;

use App\Database\Database;
use App\Model\Usuario;

class UsuarioRepository {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function cadastrar_usuario(Usuario $usuario){

        try {
            
            
            $nome = $usuario->get('nome');
            $email = $usuario->get('email');
            $senha = password_hash($usuario->get('senha'), PASSWORD_DEFAULT);
            $nascimento = $usuario->get('datanascimento');

            //validando se porduto já existe..
            $existe = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

            $existe->bindParam(':email', $email);

            $existe->execute();

            $usuario = $existe->fetch(\PDO::FETCH_ASSOC);

            if(is_array($usuario)) return ['error' => 'usuario_existe'];

            $stmt = $this->conn->prepare("INSERT INTO users(nome,email,senha,datanascimento) VALUES(:nome,:email,:senha,:nascimento)");

            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':nascimento', $nascimento);

            return $stmt->execute();

        } catch (\Throwable | \Exception | \PDOException $th) {
            
            return ['error' => $th->getMessage()];

        }

    }

    public function listar_usuarios(){

        try {
            
            $stmt = $this->conn->prepare("SELECT id,nome,email,datanascimento FROM users");

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\Throwable | \Exception | \PDOException $th) {
            
            return ['error' => $th->getMessage()];

        }
    }

    public function achar_usuario(Usuario $usuario){

        try {
            
            $stmt = $this->conn->prepare("SELECT id,nome,email,datanascimento FROM users WHERE id = :id");

            $id = $usuario->get('id');

            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\Throwable | \Exception | \PDOException $th) {
            
            return ['error' => $th->getMessage()];

        }

    }

    public function atualizar_usuario(Usuario $usuario){
        try {

            $stmt = $this->conn->prepare("UPDATE users SET nome = :nome, email = :email, senha = :senha, datanascimento = :nascimento WHERE id = :id");
            
            $id = $usuario->get('id');
            $nome = $usuario->get('nome');
            $email = $usuario->get('email');
            $senha = password_hash($usuario->get('senha'), PASSWORD_DEFAULT);
            $nascimento = $usuario->get('datanascimento');

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':nascimento', $nascimento);
    
            return $stmt->execute();

        } catch (\Throwable | \Exception | \PDOException $th) {
            return ['error' => $th->getMessage()];
        }
    }

    public function deletar_usuario(Usuario $usuario){

        try {
            
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");

            $id = $usuario->get('id');

            $stmt->bindParam(':id', $id);

            return $stmt->execute();

        } catch (\Throwable | \Exception | \PDOException $th) {
            
            return ['error' => $th->getMessage()];

        }

    }
}    
