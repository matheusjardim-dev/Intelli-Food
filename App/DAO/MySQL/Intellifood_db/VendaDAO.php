<?php
namespace App\DAO\MySQL\Intellifood_db;

use App\Controllers\VendaController;
use App\Models\MySQL\Intellifood_db\VendaModel;
use PDO;

class VendaDAO extends Conexao
{
    public function __construct() {
        parent::__construct();
    }

    public function getCardapio(): array { 
        $bebidas = $this->pdo->query('SELECT
        bebida.idbebida as id,
        bebida.nome as nome,
        bebida.qtd_bebida as qtd,  
        bebida.preco as preco
        FROM bebida')->fetchAll(\PDO::FETCH_OBJ);
       return $bebidas;
       
    }

    public function getPorcoes(): array { 
        $porcoes = $this->pdo->query('SELECT
        porcao.idporcao as id,
        porcao.nome as nome,  
        porcao.preco as preco
        FROM porcao')->fetchAll(\PDO::FETCH_OBJ);
       return $porcoes;
       
    }

    public function getLanche(): array { 
        $lanches = $this->pdo->query('SELECT
        lanche.idlanche as id,
        lanche.nome as nome,  
        lanche.preco as preco
        FROM lanche')->fetchAll(\PDO::FETCH_OBJ);
       return $lanches;
    }

    public function getCartBebida($iduser): array { 
        $statement = $this->pdo->prepare('SELECT
        carrinho.idcarrinho as id, 
        carrinho.bebida_idbebida as idbebida,
        bebida.nome as bebida,
        bebida.qtd_bebida as quantidade,
        bebida.preco as preco
        FROM carrinho INNER JOIN bebida ON carrinho.bebida_idbebida = idbebida WHERE usuarios_idusuarios = :iduser');

        $statement->execute([
            'iduser'=>$iduser
        ]);

        $bebida = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $bebida;
    }

    public function getCartLanche($iduser): array { 
        $statement = $this->pdo->prepare('SELECT
        carrinho.idcarrinho as id, 
        carrinho.lanche_idlanche as idlanche,
        lanche.nome as lanche,
        lanche.preco as preco,
        lanche.tipo_pao_idtipo_pao as pao
        FROM carrinho INNER JOIN lanche ON carrinho.lanche_idlanche = idlanche WHERE usuarios_idusuarios = :iduser');

        $statement->execute([
            'iduser'=>$iduser
        ]);

        $lanche = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $lanche;
    }

    public function getCartPorcao($iduser): array { 
        $statement = $this->pdo->prepare('SELECT
        carrinho.idcarrinho as id, 
        carrinho.porcao_idporcao as idporcao,
        porcao.nome as porcao,
        porcao.preco as preco
        FROM carrinho INNER JOIN porcao ON carrinho.porcao_idporcao = idporcao WHERE usuarios_idusuarios = :iduser');

        $statement->execute([
            'iduser'=>$iduser
        ]);

        $porcao = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $porcao;
    }

    public function addBebidaCarrinho($iduser, $idbebida) { 
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.carrinho  (idcarrinho, usuarios_idusuarios, bebida_idbebida /*, lanche_idlanche, porcao_idporcao*/) VALUES (:idcarrinho, :iduser, :idbebida /*, :idlanche, :idporcao*/)');

        $statement->execute([
            'idcarrinho'=>$iduser,
            'idbebida'=>$idbebida,
            'iduser'=>$iduser
        ]);
    }

    public function addLancheCarrinho($iduser, $idlanche) { 
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.carrinho  (idcarrinho, usuarios_idusuarios, lanche_idlanche /*, lanche_idlanche, porcao_idporcao*/) VALUES (:idcarrinho, :iduser, :idlanche /*, :idlanche, :idporcao*/)');

        $statement->execute([
            'idcarrinho'=>$iduser,
            'idlanche'=>$idlanche,
            'iduser'=>$iduser
        ]);
    }

    public function addPorcaoCarrinho($iduser, $idporcao) { 
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.carrinho  (idcarrinho, usuarios_idusuarios, porcao_idporcao /*, lanche_idlanche, porcao_idporcao*/) VALUES (:idcarrinho, :iduser, :idporcao /*, :idlanche, :idporcao*/)');

        $statement->execute([
            'idcarrinho'=>$iduser,
            'idporcao'=>$idporcao,
            'iduser'=>$iduser
        ]);
    }

    public function getMyPedidos($iduser): array { 
        
        $statement = $this->pdo->prepare('SELECT * from intellifood_db.pedido
        where usuarios_idusuarios = :id order by data_hora desc');

        $statement->execute([
            'id'=>$iduser
        ]);

        $pedidos = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $pedidos;
    }

    public function getPedidos(): array { 
        
        $statement = $this->pdo->query('SELECT * from intellifood_db.pedido order by data_hora desc');

        $pedidos = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $pedidos;
    }

    public function getRelatorio(): array { 
        
        $statement = $this->pdo->query('SELECT * FROM intellifood_db.pedido 
        WHERE data_hora > (NOW() - INTERVAL 1 DAY); data_hora desc');

        $pedidos = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $pedidos;
    }

    public function getDetalhesLanche($idpedido): array { 
        
        $statement = $this->pdo->prepare('SELECT 
        pedido_has_lanche.lanche_idlanche as id, 
        lanche.nome as lanche 
        from intellifood_db.pedido_has_lanche inner join lanche on idlanche = lanche_idlanche  
        where pedido_idpedido = :idpedido');

        $statement->execute([
            'idpedido'=>$idpedido
        ]);

        $lanches = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $lanches;
    }

    public function getDetalhes($idpedido): array { 
        
        $statement = $this->pdo->prepare('SELECT 
        pedido.preco_total as preco, 
        pedido.endereco_idendereco as idend, 
        endereco.endereco as ende 
        from intellifood_db.pedido inner join endereco on idendereco = endereco_idendereco  
        where idpedido = :idpedido');

        $statement->execute([
            'idpedido'=>$idpedido
        ]);

        $pedido = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $pedido;
    }

    public function getDetalhesBebida($idpedido): array { 
        
        $statement = $this->pdo->prepare('SELECT 
        pedido_has_bebida.bebida_idbebida as id, 
        bebida.nome as bebida 
        from intellifood_db.pedido_has_bebida inner join bebida on idbebida = bebida_idbebida  
        where pedido_idpedido = :idpedido');

        $statement->execute([
            'idpedido'=>$idpedido
        ]);

        $bebidas = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $bebidas;
    }

    public function getDetalhesPorcao($idpedido): array { 
        
        $statement = $this->pdo->prepare('SELECT 
        pedido_has_porcao.porcao_idporcao as id, 
        porcao.nome as porcao 
        from intellifood_db.pedido_has_porcao inner join porcao on idporcao = porcao_idporcao  
        where pedido_idpedido = :idpedido');

        $statement->execute([
            'idpedido'=>$idpedido
        ]);

        $porcoes = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $porcoes;
    }

    public function removerBebida($id, $idbebida): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.carrinho WHERE usuarios_idusuarios = :id AND bebida_idbebida = :idbebida');
        $statement->execute([
            'id'=>$id, 
            'idbebida'=>$idbebida
        ]);
    }
    
    public function removerLanche($id, $idlanche): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.carrinho WHERE usuarios_idusuarios = :id AND lanche_idlanche = :idlanche');
        $statement->execute([
            'id'=>$id, 
            'idlanche'=>$idlanche
        ]);
    }

    public function removerPorcao($id, $idporcao): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.carrinho WHERE usuarios_idusuarios = :id AND porcao_idporcao = :idporcao');
        $statement->execute([
            'id'=>$id, 
            'idporcao'=>$idporcao
        ]);
    }

    //MELHORIA FUTURA
    public function pedir($iduser, $end, $preco, $bebidas, $lanches, $porcao){
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.pedido (usuarios_idusuarios, preco_total, data_hora, endereco_idendereco)
        VALUES(:user, :preco, now(), :endereco)');
        
        $statement->execute([
            'user'=>$iduser,
            'preco'=>$preco, 
            'endereco'=>$end  
        ]);

        $pedido = $this->pdo->lastInsertId();
        $_SESSION['idpedido'] = $pedido;


        foreach ($bebidas as $bebida){ 
            $idbebida = $bebida->idbebida;
            $this->addBebidaPedido($pedido, $idbebida);
        }

        foreach ($lanches as $lanche){ 
            $idlanche = $lanche->idlanche;
            $this->addLanchePedido($pedido, $idlanche);
        }

        foreach ($porcao as $porcao){ 
            $idporcao = $porcao->idporcao;
            $this->addPorcaoPedido($pedido, $idporcao);
        }
    
    }  

    public function addBebidaPedido( $pedido, $idbebida): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.pedido_has_bebida (pk_pedido_bebida, pedido_idpedido, bebida_idbebida, qtd)
        VALUES(null, :pedido, :bebida, :qtd)');

        $statement->execute([
            'pedido'=>$pedido,
            'bebida'=>$idbebida,
            'qtd'=>1
        ]);

    }  

    public function addLanchePedido( $pedido, $idlanche): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.pedido_has_lanche (pk_pedido_lanche, pedido_idpedido, lanche_idlanche, qtd)
        VALUES(null, :pedido, :lanche, :qtd)');

        $statement->execute([
            'pedido'=>$pedido,
            'lanche'=>$idlanche,
            'qtd'=>1
        ]);

    } 

    public function addPorcaoPedido( $pedido, $idporcao): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.pedido_has_porcao (pk_pedido_porcao, pedido_idpedido, porcao_idporcao, qtd)
        VALUES(null, :pedido, :porcao, :qtd)');

        $statement->execute([
            'pedido'=>$pedido,
            'porcao'=>$idporcao,
            'qtd'=>1
        ]);

    }  
//
    public function estoqueBebida($qtd, $idbebida): void {

        $statement = $this->pdo->prepare('UPDATE intellifood_db.bebida
        SET qtd_bebida = :qtd_bebida WHERE idbebida = :id');

        $statement->execute([
            'qtd_bebida'=>$qtd,
            'id'=>$idbebida
        ]);
    }
//
    public function ingredientesLanche($idlanche): array {

        $statement = $this->pdo->prepare('SELECT * FROM intellifood_db.lanche_has_ingredientes WHERE lanche_idlanche = :id');
        $statement->execute([
            'id'=>$idlanche
        ]);
        $ingredientes = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $ingredientes;
    }

    public function ingredientesPorcao($idporcao): array {

        $statement = $this->pdo->prepare('SELECT * FROM intellifood_db.porcao_has_ingredientes WHERE porcao_idporcao = :id');
        $statement->execute([
            'id'=>$idporcao
        ]);
        $ingredientes = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $ingredientes;
    }

    public function selectIngrediente($idingrediente) {
    
        $statement = $this->pdo->prepare('SELECT qtd_ingrediente 
        FROM intellifood_db.ingredientes WHERE idingredientes = :id');

        $statement->execute(['id'=>$idingrediente]);

        $qtd = $statement->fetch(\PDO::FETCH_OBJ);

        return $qtd;
    }

    public function paesLanche($idpao) {
    
        $statement = $this->pdo->prepare('SELECT qtd_pao 
        FROM intellifood_db.tipo_pao WHERE idtipo_pao = :id');

        $statement->execute(['id'=>$idpao]);

        $qtd = $statement->fetch(\PDO::FETCH_OBJ);

        return $qtd;
    }

    public function estoquePao($qtd, $idpao): void {

        $statement = $this->pdo->prepare('UPDATE intellifood_db.tipo_pao
        SET qtd_pao = :qtd WHERE idtipo_pao = :id');

        $statement->execute([
            'qtd'=>$qtd,
            'id'=>$idpao
        ]);
    }

    public function estoqueIngredientes($qtd, $idingrediente): void {

        $statement = $this->pdo->prepare('UPDATE intellifood_db.ingredientes
        SET qtd_ingrediente = :qtd WHERE idingredientes = :id');

        $statement->execute([
            'qtd'=>$qtd,
            'id'=>$idingrediente
        ]);
    }

    public function getBebida($idbebida): array { 
        $statement = $this->pdo->prepare('SELECT
        carrinho.bebida_idbebida as idbebida,
        bebida.nome as bebida,
        bebida.qtd_bebida as quantidade
        FROM carrinho INNER JOIN bebida ON carrinho.bebida_idbebida = idbebida WHERE bebida_idbebida = :id');

        $statement->execute([
            'id'=>$idbebida
        ]);

        $bebida = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $bebida;
    }

}