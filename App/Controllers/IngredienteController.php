<?php
namespace App\Controllers;

use App\Models\MySQL\Intellifood_db\IngredienteModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\Intellifood_db\IngredienteDAO;
use App\Action\Action as Action;

final class IngredienteController extends Action{

    public function getIngrediente(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'ingredientes'; 
        $ingredienteDAO = new IngredienteDAO();
        $vars['ingredientes'] = $ingredienteDAO->getAllIngredientes();
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function getPao(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'paes'; 
        $ingredienteDAO = new IngredienteDAO();
        $vars['paes'] = $ingredienteDAO->getAllPaes();
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function formIngrediente(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Adicionar Usuário!';
        $vars['page'] = 'addIngrediente';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function formPao(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Adicionar Pão!';
        $vars['page'] = 'addPao';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function addIngrediente(Request $request, Response $response, array $vars): Response {
        $data = $request->getParsedBody();
        $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
        $qtd_ingrediente = filter_var($data['quantidade'], FILTER_SANITIZE_STRING);

        $ingredienteDAO = new IngredienteDAO();
        $ingrediente = new IngredienteModel();

        $ingrediente->setQtdIngrediente($qtd_ingrediente)
                    ->setNome($nome);

        $ingredienteDAO->addIngrediente($ingrediente);

        
        //Success Message
        $vars['ingredientes'] = $ingredienteDAO->getAllIngredientes();
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'ingredientes';
        $vars['success'] = 'Ingrediente cadastrado com sucesso!';
        return $this->view->render($response, 'template.phtml', $vars);

    }

    public function addPao(Request $request, Response $response, array $vars): Response {
        $data = $request->getParsedBody();
        $tipo = filter_var($data['tipo'], FILTER_SANITIZE_STRING);
        $qtd_ingrediente = filter_var($data['quantidade'], FILTER_SANITIZE_STRING);

        $ingredienteDAO = new IngredienteDAO();
        $ingrediente = new IngredienteModel();

        $ingrediente->setQtdIngrediente($qtd_ingrediente)
                    ->setTipoPao($tipo);

        $ingredienteDAO->addPao($ingrediente);

        
        //Success Message
        $vars['paes'] = $ingredienteDAO->getAllPaes();
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'paes';
        $vars['success'] = 'Pão cadastrado com sucesso!';
        return $this->view->render($response, 'template.phtml', $vars);

    }
    
    public function deleteIngrediente(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $ingredienteDAO = new IngredienteDAO();
        $vars['ingredientes'] = $ingredienteDAO->deleteIngrediente($id);
        $vars['success'] = 'Ingrediente Deletado';
    
        //Success Message
        $vars['ingredientes'] = $ingredienteDAO->getAllingredientes();
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'ingredientes'; 
        return $this->view->render($response, 'template.phtml', $vars); 
    }

    public function deletePao(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $ingredienteDAO = new IngredienteDAO();
        $vars['paes'] = $ingredienteDAO->deletePao($id);
        $vars['success'] = 'Pão Deletado';
    
        //Success Message
        $vars['paes'] = $ingredienteDAO->getAllPaes();
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'paes'; 
        return $this->view->render($response, 'template.phtml', $vars); 
    }

    public function formEditIngrediente (Request $request, Response $response, array $vars): Response{
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $ingredienteModel = new IngredienteModel();
        $ingredienteDAO = new IngredienteDAO();
        $ingredienteModel->setId($id);
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'editarIngrediente';
        $vars['ingrediente'] = $ingredienteDAO->selectIngrediente($ingredienteModel);
        
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function editarIngrediente(Request $request, Response $response, array $vars): Response {
        try {
            $data = $request->getParsedBody();
            $id = filter_var($data['id'], FILTER_SANITIZE_STRING);
            $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
            $qtd_ingrediente = filter_var($data['qtd'], FILTER_SANITIZE_STRING);
            
            $ingrediente = new IngredienteModel();
            $ingredienteDAO = new IngredienteDAO();

            $ingrediente->setId($id)
                ->setQtdIngrediente($qtd_ingrediente)
                ->setNome($nome);

            $ingredienteDAO->editarIngrediente($ingrediente);

            //Success Message
            $vars['ingredientes'] = $ingredienteDAO->getAllIngredientes();
            $vars['title'] = 'Intelli Food';
            $vars['page'] = 'ingredientes';
            $vars['success'] = 'Ingrediente Atualizado';
            return $this->view->render($response, 'template.phtml', $vars);  

        } catch (\PDOException $e){
            return 'Error -> ' . $e->getMessage();
        }
    }

    public function formEditPao (Request $request, Response $response, array $vars): Response{
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $ingredienteModel = new IngredienteModel();
        $ingredienteDAO = new IngredienteDAO();
        $ingredienteModel->setId($id);
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'editarPao';
        $vars['pao'] = $ingredienteDAO->selectPao($ingredienteModel);
        
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function editarPao(Request $request, Response $response, array $vars): Response {
        try {
            $data = $request->getParsedBody();
            $id = filter_var($data['id'], FILTER_SANITIZE_STRING);
            $tipo = filter_var($data['tipo'], FILTER_SANITIZE_STRING);
            $qtd_pao = filter_var($data['qtd'], FILTER_SANITIZE_STRING);
            
            $ingrediente = new IngredienteModel();
            $ingredienteDAO = new IngredienteDAO();

            $ingrediente->setId($id)
                ->setQtdIngrediente($qtd_pao)
                ->setTipoPao($tipo);

            $ingredienteDAO->editarPao($ingrediente);

            //Success Message
            $vars['paes'] = $ingredienteDAO->getAllPaes();
            $vars['title'] = 'Intelli Food';
            $vars['page'] = 'paes';
            $vars['success'] = 'Ingrediente Atualizado';
            return $this->view->render($response, 'template.phtml', $vars);  

        } catch (\PDOException $e){
            return 'Error -> ' . $e->getMessage();
        }
    }
}