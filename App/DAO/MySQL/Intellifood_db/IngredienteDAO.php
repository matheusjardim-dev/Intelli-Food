<?php
namespace App\DAO\MySQL\Intellifood_db;

use App\Models\MySQL\Intellifood_db\IngredienteModel;

class IngredienteDAO extends Conexao
{
    public function __construct(){
        parent::__construct();

    }

    public function getAllIngredientes(): array { 
        $ingredientes = $this->pdo->query('SELECT
        ingredientes.idingredientes as id,
        ingredientes.nome as nome,  
        ingredientes.qtd_ingrediente as quantidade
    FROM ingredientes')->fetchAll(\PDO::FETCH_OBJ);
       return $ingredientes;
    }

    public function getAllPaes(): array { 
        $paes = $this->pdo->query('SELECT
        tipo_pao.idtipo_pao as id,
        tipo_pao.tipo as tipo,  
        tipo_pao.qtd_pao as quantidade
    FROM tipo_pao')->fetchAll(\PDO::FETCH_OBJ);
       return $paes;
    }
    
    public function addIngrediente(IngredienteModel $ingrediente): void
    {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.ingredientes 
        VALUES(null, :nome, :qtd_ingrediente)');

        $statement->execute([
            'qtd_ingrediente'=>$ingrediente->getQtdIngrediente(),
            'nome'=>$ingrediente->getNome()
        ]);
    }

    public function addPao(IngredienteModel $ingrediente): void
    {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.tipo_pao 
        VALUES(null, :tipo, :qtd_pao)');

        $statement->execute([
            'tipo'=>$ingrediente->getTipoPao(),
            'qtd_pao'=>$ingrediente->getQtdIngrediente()
        ]);
    }

    public function deleteIngrediente($id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.ingredientes WHERE idingredientes = :id');
        $statement->execute(['id'=>$id]);
    }

    public function deletePao($id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.tipo_pao WHERE idtipo_pao = :id');
        $statement->execute(['id'=>$id]);
    }

    public function selectIngrediente(IngredienteModel $ingredienteModel): array {
    
        $statement = $this->pdo->prepare('SELECT idingredientes, nome, qtd_ingrediente 
        FROM intellifood_db.ingredientes WHERE idingredientes = :id');

        $statement->execute(['id'=>$ingredienteModel->getId()]);
        $ingrediente = $statement->fetch(\PDO::FETCH_ASSOC);

        return $ingrediente;
    }


    public function editarIngrediente(IngredienteModel $ingrediente): void {

        $statement = $this->pdo->prepare('UPDATE intellifood_db.ingredientes 
        SET qtd_ingrediente = :qtd_ingrediente, nome = :nome  WHERE idingredientes = :id');

        $statement->execute([
            'qtd_ingrediente'=>$ingrediente->getQtdIngrediente(),
            'nome'=>$ingrediente->getNome(),
            'id'=>$ingrediente->getId()
        ]);
    }

    public function selectPao(IngredienteModel $ingredienteModel): array {
    
        $statement = $this->pdo->prepare('SELECT idtipo_pao, tipo, qtd_pao 
        FROM intellifood_db.tipo_pao WHERE idtipo_pao = :id');
        
        $statement->execute(['id'=>$ingredienteModel->getId()]);
        $pao = $statement->fetch(\PDO::FETCH_ASSOC);

        return $pao;
    }

    public function editarPao(IngredienteModel $ingrediente): void {

        $statement = $this->pdo->prepare('UPDATE intellifood_db.tipo_pao
        SET qtd_pao = :qtd_pao, tipo = :tipo  WHERE idtipo_pao = :id');

        $statement->execute([
            'qtd_pao'=>$ingrediente->getQtdIngrediente(),
            'tipo'=>$ingrediente->getTipoPao(),
            'id'=>$ingrediente->getId()
        ]);
    }
    
}