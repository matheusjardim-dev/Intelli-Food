<?php
namespace App\DAO\MySQL\Intellifood_db;

use App\Models\MySQL\Intellifood_db\ProdutoModel;

class ProdutoDAO extends Conexao
{
    public function __construct() {
        parent::__construct();
    }

    public function getAllBebidas(): array { 
        $bebidas = $this->pdo->query('SELECT
        bebida.idbebida as id,
        bebida.nome as nome,  
        bebida.qtd_bebida as quantidade,
        bebida.preco as preco
    FROM bebida')->fetchAll(\PDO::FETCH_OBJ);
       return $bebidas;
    }

    public function getAllLanches(): array { 
        $lanches = $this->pdo->query('SELECT
        lanche.idlanche as id,
        lanche.nome as lanche,  
        tipo_pao.tipo as pao,
        lanche.preco as preco
    FROM lanche 
    INNER JOIN tipo_pao ON lanche.tipo_pao_idtipo_pao = idtipo_pao order by tipo_pao_idtipo_pao')->fetchAll(\PDO::FETCH_OBJ);
       return $lanches;
    }

    public function getAllPorcoes(): array { 
        $porcoes = $this->pdo->query('SELECT
        porcao.idporcao as id,
        porcao.nome as porcao,  
        porcao.preco as preco
    FROM porcao')->fetchAll(\PDO::FETCH_OBJ);
       return $porcoes;
    }

    public function getAllIngredientes(): array { 
        $ingredientes = $this->pdo->query('SELECT
        ingredientes.idingredientes as id,
        ingredientes.nome as nome,
        ingredientes.qtd_ingrediente as qtd
    FROM ingredientes')->fetchAll(\PDO::FETCH_OBJ);
       return $ingredientes;
    }

    public function getAllPaes(): array { 
        $paes = $this->pdo->query('SELECT
        tipo_pao.idtipo_pao as id,
        tipo_pao.tipo as tipo,  
        tipo_pao.qtd_pao as qtd
    FROM tipo_pao')->fetchAll(\PDO::FETCH_OBJ);
       return $paes;
    }
    
    public function addBebida(ProdutoModel $bebida): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.bebida
        VALUES(null, :nome, :qtd_Bebida, :preco)');

        $statement->execute([
            'qtd_Bebida'=>$bebida->getQtdBebida(),
            'nome'=>$bebida->getNomeBebida(),
            'preco'=>$bebida->getPrecoBebida()
        ]);
    }

    public function addLanche(ProdutoModel $produto, $ingrediente, $qtd): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.lanche
        VALUES(null, :nome, :tipo, :preco)');

        $statement->execute([
            'tipo'=>$produto->getTipoPao(),
            'nome'=>$produto->getNomelanche(),
            'preco'=>$produto->getPrecolanche()
        ]);

        $last_id = $this->pdo->lastInsertId();
        $this->insertLanche($last_id, $ingrediente, $qtd);
    }

    public function insertLanche($last_id, array $ingrediente, array $qtd): void {
        foreach ($ingrediente as $ing) {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.lanche_has_ingredientes (lanche_idlanche, ingredientes_idingredientes, quantidade)
        VALUES(:lanche, :ingrediente, :qtd)');

        $statement->execute([
            'lanche'=>$last_id,
            'ingrediente'=>$ing[0]++,
            'qtd'=>$qtd[0]++
        ]);
        }
    }

    public function deleteBebida($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.bebida WHERE idbebida = :id');
        $statement->execute(['id'=>$id]);
    }

    public function selectBebida(ProdutoModel $produtoModel): array {
    
        $statement = $this->pdo->prepare('SELECT idbebida, nome, qtd_bebida, preco
        FROM intellifood_db.bebida WHERE idbebida = :id');
        
        $statement->execute(['id'=>$produtoModel->getIdBebida()]);
        $bebida = $statement->fetch(\PDO::FETCH_ASSOC);

        return $bebida;
    }

    public function editarBebida($produto): void {

        $statement = $this->pdo->prepare('UPDATE intellifood_db.bebida
        SET qtd_bebida = :qtd_bebida, nome = :nome, preco = :preco  WHERE idbebida = :id');

        $statement->execute([
            'qtd_bebida'=>$produto->getQtdBebida(),
            'nome'=>$produto->getNomeBebida(),
            'preco'=>$produto->getPrecoBebida(),
            'id'=>$produto->getIdBebida()
        ]);
    }

    public function addPorcao(ProdutoModel $porcao, $ingrediente, $qtd_ingrediente): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.porcao (idporcao, nome, preco)
        VALUES(null, :nome, :preco)');

        $statement->execute([
            'nome'=>$porcao->getNomePorcao(),
            'preco'=>$porcao->getPrecoPorcao()
        ]);

        $last_id = $this->pdo->lastInsertId();
        $this->insertPorcao($last_id, $ingrediente, $qtd_ingrediente);  
    }

    public function insertPorcao($last_id, $ingrediente, $qtd_ingrediente): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.porcao_has_ingredientes (porcao_idporcao, ingredientes_idingredientes, quantidade)
        VALUES(:porcao, :ingrediente, :qtd_ingrediente)');

        $statement->execute([
            'porcao'=>$last_id,
            'ingrediente'=>$ingrediente,
            'qtd_ingrediente'=>$qtd_ingrediente
        ]);
    }

    public function deletePorcao($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.porcao_has_ingredientes 
        WHERE porcao_idporcao = :id');
        $statement->execute(['id'=>$id]);
        $this->deletarPorcao($id);  
    }

    public function deletarPorcao($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.porcao
        WHERE idporcao = :id');
        $statement->execute(['id'=>$id]); 
    }

    public function deletelanche($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.lanche_has_ingredientes 
        WHERE lanche_idlanche = :id');
        $statement->execute(['id'=>$id]);
        $this->deletarlanche($id);  
    }

    public function deletarlanche($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.lanche
        WHERE idlanche = :id');
        $statement->execute(['id'=>$id]); 
    }


}