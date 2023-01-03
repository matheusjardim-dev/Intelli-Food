<?php
namespace App\Models\MySQL\Intellifood_db;

final class UserModel {
    private $id;
    private $cpf;
    private $nome;
    private $nivel;
    private $telefone;
    private $email;
    private $senha;
    private $endereco;
    private $qtd_end;
    private $cep;

    /**
     * @param mixed $id
     */
    public function setId($id): UserModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCPF(): string
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCPF($cpf): UserModel
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome): UserModel
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed    
     */
    public function getNivel(): int
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     */
    public function setNivel($nivel): UserModel
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelefone(): string
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone): UserModel
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): UserModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSenha(): string
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha): UserModel
    {
        $this->senha = $senha;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndereco(): string
    {
        return $this->endereco;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco): UserModel
    {
        $this->endereco = $endereco;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtd_end(): string
    {
        return $this->qtd_end;
    }

    /**
     * @param mixed $qtd_end
     */
    public function setQtd_end($qtd_end): UserModel
    {
        $this->qtd_end = $qtd_end;
        return $this;
    }

     /**
     * @return mixed
     */
    public function getCEP(): string
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCEP($cep): UserModel
    {
        $this->cep = $cep;
        return $this;
    }


}
