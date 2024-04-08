<?php
namespace App\Model;

class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $datanascimento;

    public function set($who,$value): bool
    {

        $this->$who = $value;

        return true;

    }

    public function get($who)
    {

        return $this->$who;

    }

}
