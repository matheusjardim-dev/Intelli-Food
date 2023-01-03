<?php
namespace App\Models\MySQL\Intellifood_db;

final class ProdutoModel {
    private $id_bebida;
    private $nome_bebida;
    private $qtd_bebida;
    private $preco_bebida;

    private $id_lanche;
    private $nome_lanche;
    private $tipo_pao;
    private $preco_lanche;

    private $id_porcao;
    private $nome_porcao;
    private $qtd;
    private $preco_porcao;

    /**
     * @param mixed $id_bebida
     */
    public function setIdBebida($id_bebida): ProdutoModel
    {
        $this->id_bebida = $id_bebida;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdBebida(): int
    {
        return $this->id_bebida;
    }

    /**
     * @param mixed $id_lanche
     */
    public function setIdLanche($id_lanche): ProdutoModel
    {
        $this->id_lanche = $id_lanche;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdLanche(): int
    {
        return $this->id_lanche;
    }

    /**
     * @param mixed $nome_bebida
     */
    public function setNomeBebida($nome_bebida): ProdutoModel
    {
        $this->nome_bebida = $nome_bebida;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomeBebida(): string
    {
        return $this->nome_bebida;
    }

    /**
     * @param mixed $nome_lanche
     */
    public function setNomelanche($nome_lanche): ProdutoModel
    {
        $this->nome_lanche = $nome_lanche;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomeLanche(): string
    {
        return $this->nome_lanche;
    }

    /**
     * @param mixed $preco_bebida
     */
    public function setPrecoBebida($preco_bebida): ProdutoModel
    {
        $this->preco_bebida = $preco_bebida;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrecoBebida(): string
    {
        return $this->preco_bebida;
    }
    
    /**
     * @param mixed $preco_lanche
     */
    public function setPrecoLanche($preco_lanche): ProdutoModel
    {
        $this->preco_lanche = $preco_lanche;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrecoLanche(): string
    {
        return $this->preco_lanche;
    }


    /**
     * @param mixed $qtd_bebida
     */
    public function setQtdBebida($qtd_bebida): ProdutoModel
    {
        $this->qtd_bebida = $qtd_bebida;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtdBebida(): int
    {
        return $this->qtd_bebida;
    }

    /**
     * @param mixed $tipo_pao
     */
    public function setTipoPao($tipo_pao): ProdutoModel
    {
        $this->tipo_pao = $tipo_pao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoPao(): int
    {
        return $this->tipo_pao;
    }



    /**
     * @param mixed $qtd
     */
    public function setQtdPorcao($qtd): ProdutoModel
    {
        $this->qtd = $qtd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtdPorcao(): int
    {
        return $this->qtd;
    }

     /**
     * @param mixed $nome_porcao
     */
    public function setNomePorcao($nome_porcao): ProdutoModel
    {
        $this->nome_porcao = $nome_porcao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomePorcao(): string
    {
        return $this->nome_porcao;
    }

     /**
     * @param mixed $preco_porcao
     */
    public function setPrecoPorcao($preco_porcao): ProdutoModel
    {
        $this->preco_porcao = $preco_porcao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrecoPorcao(): string
    {
        return $this->preco_porcao;
    }

}
