<?php
namespace App\Model;
class Usuario {
    private $usuario_id;
    private $nome;
    private $email;
    private $senha;

    public function getUsuarioId(){
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id): self{
        $this->usuario_id = $usuario_id;

        return $this;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome): self{
        $this->nome = $nome;

        return $this;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email): self{
        $this->email = $email;

        return $this;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha): self {
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        return $this;
    }
}
