<?php
namespace App\DAO\MySQL\Intellifood_db;

use App\Models\MySQL\Intellifood_db\UserModel;
use PDO;

class UserDAO extends Conexao
{
    public function __construct() {
        parent::__construct();

    }

    public function getAllUsers(): array { 
        $users = $this->pdo->query('SELECT
        usuarios.idusuarios as id,
        usuarios.nome as nome,
        usuarios.cpf as cpf,
        usuarios.email as email,
        usuarios.telefone as telefone,
        nivel.desc_nivel as nivel
    FROM usuarios
    INNER JOIN nivel ON usuarios.nivel_idnivel = idnivel order by nivel_idnivel')->fetchAll(\PDO::FETCH_OBJ);

       return $users;
    }

    public function getAllEnd($iduser): array { 
        
        $statement = $this->pdo->prepare('SELECT
        endereco.idendereco as id,
        endereco.cep as cep,
        endereco.endereco as endereco,
        usuarios.nome as usuario
        FROM endereco
        INNER JOIN usuarios ON endereco.usuarios_idusuarios = idusuarios where idusuarios = :id ');

        $statement->execute([
            'id'=>$iduser
        ]);

        $enderecos = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $enderecos;
    }

    public function insertUser(UserModel $user): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.usuarios VALUES(null, :cpf, :nome, :telefone, :email, :senha, :nivel, 3)');

        $statement->execute([
            'cpf'=>$user->getCPF(),
            'nome'=>$user->getNome(),
            'telefone'=>$user->getTelefone(),
            'email'=>$user->getEmail(),
            'senha'=>$user->getSenha(),
            'nivel'=>$user->getNivel()

        ]);
    }

    public function cadastroUser(UserModel $user): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.usuarios VALUES(null, :cpf, :nome, :telefone, :email, :senha, 4, 3)');

        $statement->execute([
            'cpf'=>$user->getCPF(),
            'nome'=>$user->getNome(),
            'telefone'=>$user->getTelefone(),
            'email'=>$user->getEmail(),
            'senha'=>$user->getSenha()

        ]);
    }
 
    public function cadastroEnd(UserModel $user): void {
        $statement = $this->pdo->prepare('INSERT INTO intellifood_db.endereco 
        (cep, endereco, usuarios_idusuarios) VALUES(:cep, :endereco, :id )');

        $statement->execute([
            'endereco'=>$user->getEndereco(),
            'cep'=>$user->getCEP(),
            'id'=>$user->getId()
        ]);
    }

    public function selectEnd(UserModel $userModel): array {
    
        $statement = $this->pdo->prepare('SELECT idendereco, cep, endereco
        FROM intellifood_db.endereco WHERE idendereco = :id');
        
        $statement->execute(['id'=>$userModel->getId()]);
        $endereco = $statement->fetch(\PDO::FETCH_ASSOC);

        return $endereco;
    }

    public function editarEnd($user): void {

        $statement = $this->pdo->prepare('UPDATE intellifood_db.endereco
        SET endereco = :endereco, cep = :cep  WHERE idendereco = :id');

        $statement->execute([
            'endereco'=>$user->getEndereco(),
            'cep'=>$user->getCEP(),
            'id'=>$user->getId()
        ]);
    }
    
    public function deleteUser($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.usuarios WHERE idusuarios = :id');
        $statement->execute(['id'=>$id]);
    }
/*
    public function apagarPedidoBebida($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.pedido_has_bebida WHERE usuarios_idusuarios = :id');
        $statement->execute(['id'=>$id]);
        $this->apagarPedidoLanche($id);
    }

    public function apagarPedidoLanche($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.pedido_has_lanche WHERE usuarios_idusuarios = :id');
        $statement->execute(['id'=>$id]);
        $this->apagarPedidoPorcao($id);
    }

    public function apagarPedidoPorcao($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.pedido_has_porcao WHERE usuarios_idusuarios = :id');
        $statement->execute(['id'=>$id]);
        $this->apagarPedido($id);
    }

    public function apagarPedido($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.pedido WHERE usuarios_idusuarios = :id');
        $statement->execute(['id'=>$id]);
        $this->apagarEnd($id);
    }
 */
    public function apagarEnd($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.endereco WHERE usuarios_idusuarios = :id');
        $statement->execute(['id'=>$id]);
        $this->deleteUser($id);
    }


    public function deleteEnd($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.endereco WHERE idendereco = :id');
        $statement->execute(['id'=>$id]);
    }

    public function selectUser(UserModel $userModel): array {
    
        $statement = $this->pdo->prepare('SELECT idusuarios, cpf, nome, telefone, email, nivel_idnivel FROM intellifood_db.usuarios 
        WHERE idusuarios = :id');
        $statement->execute(['id'=>$userModel->getId()]);
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function updateUser(UserModel $usuario): void {

        $statement = $this->pdo->prepare('UPDATE intellifood_db.usuarios SET cpf = :cpf, nome = :nome, telefone = :telefone, 
        email = :email, nivel_idnivel = :nivel WHERE idusuarios = :id');

        $statement->execute([
            'cpf'=>$usuario->getCPF(),
            'nome'=>$usuario->getNome(),
            'telefone'=>$usuario->getTelefone(),
            'email'=>$usuario->getEmail(),
            'nivel'=>$usuario->getNivel(),
            'id'=>$usuario->getId()
        ]);
    }

    public function loginUser(UserModel $user) {
        $statement = $this->pdo->prepare('SELECT * FROM intellifood_db.usuarios WHERE email = :email');
        $statement->execute([
            'email'=>$user->getEmail()
        ]);
        
        $registro = $statement->rowCount();
        if ($registro != 1) {
            return false;
        } else {
            $dados = $statement->fetch(\PDO::FETCH_ASSOC);
            return $dados;
        }  
        
    }

    public function excluirCart($id): void {
        $statement = $this->pdo->prepare('DELETE FROM intellifood_db.carrinho WHERE idcarrinho = :id');
        $statement->execute(['id'=>$id]);
    }

}