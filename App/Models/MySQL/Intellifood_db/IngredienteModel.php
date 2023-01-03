<?php
namespace App\Models\MySQL\Intellifood_db;

final class IngredienteModel {
    private $id;
    private $nome;
    private $qtd_ingrediente;
    private $tipo_pao;

    /**
     * @param mixed $id
     */
    public function setId($id): IngredienteModel
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
     * @param mixed $nome
     */
    public function setNome($nome): IngredienteModel
    {
        $this->nome = $nome;
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
     * @param mixed $tipo_pao
     */
    public function setTipoPao($tipo_pao): IngredienteModel
    {
        $this->tipo_pao = $tipo_pao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoPao(): string
    {
        return $this->tipo_pao;
    }

    
    /**
     * @param mixed $qtd_ingrediente
     */
    public function setQtdIngrediente($qtd_ingrediente): IngredienteModel
    {
        $this->qtd_ingrediente = $qtd_ingrediente;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtdIngrediente(): int
    {
        return $this->qtd_ingrediente;
    }

}
