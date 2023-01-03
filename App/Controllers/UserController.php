<?php
namespace App\Controllers;

use App\Models\MySQL\Intellifood_db\UserModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\Intellifood_db\UserDAO;
use App\Action\Action as Action;

final class UserController extends Action{

    public function getUser(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Usuários';
        $vars['page'] = 'users';
        $userDAO = new UserDAO();
        $vars['users'] = $userDAO->getAllUsers();

        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function novoUser(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Adicionar Usuário!';
        $vars['page'] = 'novoUser';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function cadUser(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'cadastroUser';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function getEndereco(Request $request, Response $response, array $vars): Response {
        if (!isset($_SESSION)) session_start();
        $iduser = $_SESSION['id'];
        $vars['page'] = 'enderecos';
        $userDAO = new UserDAO();
        $vars['enderecos'] = $userDAO->getAllEnd($iduser);

        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function deleteEnd(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        $iduser = $_SESSION['id'];
        $userDAO = new UserDAO();
        $vars['enderecos'] = $userDAO->deleteEnd($id);
       
        //Success Message
        $vars['enderecos'] = $userDAO->getAllEnd($iduser); 
        $vars['success'] = 'Endereço Deletado';
        $vars['page'] = 'enderecos'; 
        return $this->view->render($response, 'template.phtml', $vars); 
    }

    public function cadEnd(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Adicionar Endereço!';
        $vars['page'] = 'cadastroEnd';
        return $this->view->render($response, 'template.phtml', $vars);
    }
 
    public function cadastroEnd(Request $request, Response $response, array $vars): Response {
        if (!isset($_SESSION)) session_start();
        $data = $request->getParsedBody();
        $endereco = filter_var($data['endereco'], FILTER_SANITIZE_STRING);
        $cep = filter_var($data['cep'], FILTER_SANITIZE_STRING);
        $id = filter_var($data['id'], FILTER_SANITIZE_STRING);
        $iduser = $_SESSION['id'];
        if(empty($cep)) {
            $cep = "00000-000";
            return $cep;
        }

        $userDAO = new UserDAO();
        $user = new UserModel();
        $user->setId($id)
            ->setCEP($cep)
            ->setEndereco($endereco);


        $userDAO->cadastroEnd($user);

        //Success Message
        $vars['enderecos'] = $userDAO->getAllEnd($iduser);
        $vars['page'] = 'enderecos';
        $vars['success'] = 'Novo endereço inserido';
        return $this->view->render($response, 'template.phtml', $vars);
        /* 
        /erro: nome do campo da tabela inválido. 
        solução: correção do nome do campo.
        /Violação de restrição de integridade: 1452 Não é possível adicionar ou atualizar uma linha filho: uma restrição de chave estrangeira falha (`intellifood_db`.`endereco`, CONSTRAINT `fk_endereco_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios` `))
        solução: alterar a sintaxe do código de inserção;
        */
    }

    public function formEditEnd (Request $request, Response $response, array $vars): Response{
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $userModel = new UserModel();
        $userDAO = new UserDAO();
        $userModel->setId($id);

        $vars['page'] = 'editarEnd';
        $vars['endereco'] = $userDAO->selectEnd($userModel);
        
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function editarEnd(Request $request, Response $response, array $vars): Response {
        try {
            $data = $request->getParsedBody();
            $id = filter_var($data['id'], FILTER_SANITIZE_STRING);
            $cep = filter_var($data['cep'], FILTER_SANITIZE_STRING);
            $endereco = filter_var($data['end'], FILTER_SANITIZE_STRING);
            $iduser = $_SESSION['id'];
            $user = new userModel();
            $userDAO = new userDAO();

            $user->setId($id)
                ->setCEP($cep)
                ->setEndereco($endereco);

            $userDAO->editarEnd($user);

            //Success Message
            $vars['enderecos'] = $userDAO->getAllEnd($iduser);
            $vars['page'] = 'enderecos';
            $vars['success'] = 'Endereço Atualizado';
            return $this->view->render($response, 'template.phtml', $vars);  

        } catch (\PDOException $e){
            return 'Error -> ' . $e->getMessage();
        }
    }

    public function insertUser(Request $request, Response $response, array $vars): Response {
        $data = $request->getParsedBody();
        $cpf = filter_var($data['cpf'], FILTER_SANITIZE_STRING);
        $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
        $telefone = filter_var($data['telefone'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $nivel = filter_var($data['nivel'], FILTER_SANITIZE_STRING);
        $senha = filter_var($data['senha'], FILTER_SANITIZE_STRING);

        $hash = password_hash($senha, PASSWORD_BCRYPT);

        $userDAO = new UserDAO();
        $user = new UserModel();
        $user->setCPF($cpf)
            ->setNome($nome)
            ->setTelefone($telefone)
            ->setEmail($email)
            ->setNivel($nivel)
            ->setSenha($hash);
        $userDAO->insertUser($user);

        //Success Message
        $vars['users'] = $userDAO->getAllUsers();
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'users';
        $vars['success'] = 'Novo usuário inserido';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function cadastroUser(Request $request, Response $response, array $vars): Response {
        $data = $request->getParsedBody();
        $cpf = filter_var($data['cpf'], FILTER_SANITIZE_STRING);
        $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
        $telefone = filter_var($data['telefone'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_STRING);
        $senha = filter_var($data['senha'], FILTER_SANITIZE_STRING);

        $hash = password_hash($senha, PASSWORD_BCRYPT);

        $userDAO = new UserDAO();
        $user = new UserModel();
        $user->setCPF($cpf)
            ->setNome($nome)
            ->setTelefone($telefone)
            ->setEmail($email)
            ->setSenha($hash);
        $userDAO->cadastroUser($user);

        
        //Success Message
        $vars['users'] = $userDAO->getAllUsers();
        $vars['title'] = 'Cadastrado com sucesso!';
        $vars['page'] = 'login';
        $vars['success'] = 'Cadastrado com sucesso!';
        return $this->view->render($response, 'template.phtml', $vars);

    }

    public function deleteUser(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $userDAO = new UserDAO();
        $userDAO->apagarEnd($id);
       
        //Success Message
        $vars['users'] = $userDAO->getAllUsers(); 
        $vars['success'] = 'Usuário Deletado';
        $vars['page'] = 'users'; 
        return $this->view->render($response, 'template.phtml', $vars); 
    }
    
    public function selectUser(Request $request, Response $response, array $vars): Response{
        $dado = $request->getQueryParams();
        $id = filter_var($dado['id'], FILTER_SANITIZE_NUMBER_INT);

        $userModel = new UserModel();
        $userDAO = new UserDAO();
        $userModel->setId($id);
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'updateUser';
        $vars['user'] = $userDAO->selectUser($userModel);
        
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function updateUser(Request $request, Response $response, array $vars): Response {
        try {
            $data = $request->getParsedBody();
            $id = filter_var($data['id'], FILTER_SANITIZE_STRING);
            $cpfForm = filter_var($data['cpf'], FILTER_SANITIZE_STRING);
            $nomeForm = filter_var($data['nome'], FILTER_SANITIZE_STRING);
            $telefoneForm = filter_var($data['telefone'], FILTER_SANITIZE_STRING);
            $emailForm = filter_var($data['email'], FILTER_SANITIZE_STRING);
            $nivelForm = filter_var($data['nivel'], FILTER_SANITIZE_STRING);

            $usuario = new UserModel();
            $userDAO = new UserDAO();

            $usuario->setId($id)
                ->setCPF($cpfForm)
                ->setNome($nomeForm)
                ->setTelefone($telefoneForm)
                ->setEmail($emailForm)
                ->setNivel($nivelForm);
            $userDAO->updateUser($usuario);

            //Success Message
            $vars['users'] = $userDAO->getAllUsers();
            $vars['title'] = 'Intelli Food';
            $vars['page'] = 'users';
            $vars['success'] = 'Usuário Atualizado';
            return $this->view->render($response, 'template.phtml', $vars);  

        } catch (\PDOException $e){
            return 'Error -> ' . $e->getMessage();
        }
    }

    public function log(Request $request, Response $response, array $vars) : Response{
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'login';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function login(Request $request, Response $response, array $vars) {

        $data = $request->getParsedBody();
        $email = filter_var($data['email'], FILTER_SANITIZE_STRING);
        $senha = filter_var($data['senha'], FILTER_SANITIZE_STRING);

        $userDAO = new UserDAO();
        $user = new UserModel();

        $user->setEmail($email)
             ->setSenha($senha);

        $dados = $userDAO->loginUser($user);

        if ($dados == false) {
            $vars['page'] = 'login';
            $vars['erro'] = 'Usuário não encontrado';
            return $this->view->render($response, 'template.phtml', $vars); 
        }

        $this->validarUser($dados, $senha, $response, $vars);
        
    }

    public function validarUser($dados, $senha, $response, $vars){
        $hash = $dados['senha'];
        if (password_verify($senha, $hash)) {
            if (!isset($_SESSION)) session_start();

            $_SESSION['id'] = $dados['idusuarios'];
            $_SESSION['nome'] = $dados['nome'];
            $_SESSION['nivel'] = $dados['nivel_idnivel'];
            $_SESSION['qtd_end'] = $dados['qtd_end'];
            $_SESSION['loggedIn'] = true;

            // echo "Olá, ", $_SESSION['nome'],  $_SESSION['nivel'] ;

            $this->direcionamento($response, $vars);
        } else {
            //echo "email ou senha invalidos";
            $vars['page'] = 'login';
            $vars['warning'] = 'email ou senha inválidos';
            return $this->view->render($response, 'template.phtml', $vars);
        }
    }

    public function direcionamento(Response $response, array $vars): Response {
        if (!isset($_SESSION)) session_start();

        if ($_SESSION['nivel'] == 1){ 
        $vars['page'] = 'admin';
        return $this->view->render($response, 'template.phtml', $vars);
        } 
        else{ 
            if ($_SESSION['nivel'] == 2){ 
            $vars['page'] = 'admin';
            return $this->view->render($response, 'template.phtml', $vars);
            }                
            else { 
                if ($_SESSION['nivel'] == 3){ 
                $vars['page'] = 'admin';
                return $this->view->render($response, 'template.phtml', $vars);                    
            }
            else {
                if ($_SESSION['nivel'] == 4){ 
                $vars['page'] = 'home';
                return $this->view->render($response, 'template.phtml', $vars);
                }
            }
            }
            }
    }
   /* 
    /variével $dados indefinida; 
    solução: chamada da função 'validarUser';
    /Caso o usuário não exista, "Error: Return value of App\DAO\MySQL\Intellifood_db\UserDAO::loginUser() must be of the type array, none returned"
    solução: 
    /erro: direcionamento não funciona, uso incorreto do sinal '=';
    solução: usar '==';
    /erro: erro na verificação de nível;
    solução: substitui o operador '!=' por >;
*/

    public function logout(Request $request, Response $response, array $vars) : Response{
        $id = $_SESSION['id'];
        session_destroy(); 
        $vars['page'] = 'login';
        $userDAO = new UserDAO();
        $userDAO->excluirCart($id);

        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function isLoggedIn() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            return false;
        }
        return true;
    }
}