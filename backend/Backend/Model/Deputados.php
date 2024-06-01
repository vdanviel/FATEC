<?php

namespace App\Model;

class Deputados {
    private int $id;
    private string $nome;
    private string $sexo;
    private string $partido;
    private string $email;
    private string $cep;
    private string $cidade;
    private string $bairro;
    private string $rua;
    private string $latitude;
    private string $longitude;

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome(string $nome) {
        $this->nome = $nome;
        return $this;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setSexo(string $sexo) {
        $this->sexo = $sexo;
        return $this;
    }

    public function getPartido() {
        return $this->partido;
    }

    public function setPartido(string $partido) {
        $this->partido = $partido;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
        return $this;
    }

    public function getCep() {
        return $this->cep;
    }

    public function setCep(string $cep) {
        $this->cep = $cep;
        return $this;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function setCidade(string $cidade) {
        $this->cidade = $cidade;
        return $this;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function setBairro(string $bairro) {
        $this->bairro = $bairro;
        return $this;
    }

    public function getRua() {
        return $this->rua;
    }

    public function setRua(string $rua) {
        $this->rua = $rua;
        return $this;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude(string $latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude(string $longitude) {
        $this->longitude = $longitude;
        return $this;
    }
}
