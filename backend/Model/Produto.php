<?php
namespace App\Model;

class Produto {
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $quantidade;
    private $categoria;

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
