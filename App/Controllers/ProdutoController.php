<?php
namespace App\Controllers;

use App\Models\MySQL\Intellifood_db\ProdutoModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\Intellifood_db\ProdutoDAO;
use App\Action\Action as Action;

final class ProdutoController extends Action{

    public function getBebida(Request $request, Response $response, array $vars): Response {
        $vars['page'] = 'bebidas'; 
        $produtoDAO = new ProdutoDAO();
        $vars['bebidas'] = $produtoDAO->getAllBebidas();
        //$_SESSION['qtd_bebida'] = $vars['bebidas']['quantidade'];
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function getEstoque(Request $request, Response $response, array $vars): Response {
        $vars['page'] = 'estoque'; 
        $produtoDAO = new ProdutoDAO();
        $vars['bebidas'] = $produtoDAO->getAllBebidas();
        $vars['ingredientes'] = $produtoDAO->getAllIngredientes();
        $vars['paes'] = $produtoDAO->getAllPaes();

        return $this->view->render($response, 'template.phtml', $vars);
    }
    
    public function formBebida(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'addBebida';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function addBebida(Request $request, Response $response, array $vars): Response {
        $data = $request->getParsedBody();
        $nome_bebida = filter_var($data['nome'], FILTER_SANITIZE_STRING);
        $qtd_bebida = filter_var($data['quantidade'], FILTER_SANITIZE_STRING);
        $preco_bebida = filter_var($data['preco'], FILTER_DEFAULT);

        $produtoDAO = new ProdutoDAO();
        $produto = new ProdutoModel();

        $produto->setQtdBebida($qtd_bebida)
                ->setNomeBebida($nome_bebida)
                ->setPrecoBebida($preco_bebida);

        $produtoDAO->addBebida($produto);

        
        //Success Message
        $vars['bebidas'] = $produtoDAO->getAllBebidas();
        $vars['title'] = 'Sucesso!';
        $vars['page'] = 'bebidas';
        $vars['success'] = 'Bebida cadastrado com sucesso!';
        return $this->view->render($response, 'template.phtml', $vars);

    }

    public function deleteBebida(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $produtoDAO = new ProdutoDAO();
        $vars['bebidas'] = $produtoDAO->deleteBebida($id);
        $vars['success'] = 'bebida Deletada';
    
        //Success Message
        $vars['bebidas'] = $produtoDAO->getAllbebidas();
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'bebidas'; 
        return $this->view->render($response, 'template.phtml', $vars); 
    }

    public function formEditBebida (Request $request, Response $response, array $vars): Response{
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $produtoModel = new ProdutoModel();
        $produtoDAO = new ProdutoDAO();
        $produtoModel->setIdBebida($id);

        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'editarBebida';
        $vars['bebida'] = $produtoDAO->selectBebida($produtoModel);
        
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function editarBebida(Request $request, Response $response, array $vars): Response {
      
            $data = $request->getParsedBody();
            $id = filter_var($data['id'], FILTER_SANITIZE_STRING);
            $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
            $qtd_bebida = filter_var($data['qtd'], FILTER_SANITIZE_STRING);
            $preco = filter_var($data['preco'], FILTER_SANITIZE_STRING);
            
            $produto = new ProdutoModel();
            $produtoDAO = new ProdutoDAO();

            $produto->setIdBebida($id)
                ->setQtdBebida($qtd_bebida)
                ->setPrecoBebida($preco)
                ->setNomeBebida($nome);

            $produtoDAO->editarBebida($produto);

            //Success Message
            $vars['bebidas'] = $produtoDAO->getAllBebidas();
            $vars['title'] = 'Intelli Food';
            $vars['page'] = 'bebidas';
            $vars['success'] = 'produto Atualizado';
            return $this->view->render($response, 'template.phtml', $vars);  

    }

    //Lanche
    public function getLanche(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'lanches'; 
        $produtoDAO = new ProdutoDAO();
        $vars['lanches'] = $produtoDAO->getAllLanches();
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function formLanche(Request $request, Response $response, array $vars): Response {
        $vars['page'] = 'addLanche';
        $produtoDAO = new ProdutoDAO();
        $vars['ingredientes'] = $produtoDAO->getAllIngredientes();
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function addLanche(Request $request, Response $response, array $vars): Response {
        $data = $request->getParsedBody();
        $nome_lanche = filter_var($data['nome'], FILTER_SANITIZE_STRING);
        $tipo_pao = filter_var($data['tipo'], FILTER_VALIDATE_INT);
        $ingrediente = [filter_var($data['ingrediente'], FILTER_VALIDATE_INT)];
        $qtd = [filter_var($data['qtd'], FILTER_VALIDATE_INT)];
        $preco_lanche = filter_var($data['preco'], FILTER_DEFAULT);

        $produtoDAO = new ProdutoDAO();
        $produto = new ProdutoModel();

        $produto->setTipoPao($tipo_pao)
                ->setNomeLanche($nome_lanche)
                ->setPrecoLanche($preco_lanche);

        $produtoDAO->addlanche($produto, $ingrediente, $qtd);

        
        //Success Message
        $vars['lanches'] = $produtoDAO->getAllLanches();
        $vars['page'] = 'lanches';
        $vars['success'] = 'Lanche cadastrado!';
        return $this->view->render($response, 'template.phtml', $vars);

    }
 
    public function deleteLanche(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $produtoDAO = new ProdutoDAO();
        $vars['lanches'] = $produtoDAO->deleteLanche($id);
    
        //Success Message
        $vars['lanches'] = $produtoDAO->getAllLanches();
        $vars['success'] = 'Lanche Deletado';
        $vars['page'] = 'lanches'; 
        return $this->view->render($response, 'template.phtml', $vars); 
    }

    //Porção
    public function getPorcao(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'porcoes'; 
        $produtoDAO = new ProdutoDAO();
        $vars['porcoes'] = $produtoDAO->getAllPorcoes();
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function formPorcao(Request $request, Response $response, array $vars): Response {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'addPorcao';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function addPorcao(Request $request, Response $response, array $vars) {
        $data = $request->getParsedBody();
        $nome_porcao = filter_var($data['nome'], FILTER_SANITIZE_STRING);
        $qtd_ingrediente = filter_var($data['quantidade'], FILTER_SANITIZE_STRING);
        $preco_porcao = filter_var($data['preco'], FILTER_DEFAULT);
        $ingrediente = filter_var($data['ingrediente'], FILTER_DEFAULT);

        $porcaoDAO = new ProdutoDAO();
        $porcao = new ProdutoModel();

        $porcao->setNomePorcao($nome_porcao)
               ->setPrecoPorcao($preco_porcao);

        $porcaoDAO->addPorcao($porcao, $ingrediente, $qtd_ingrediente);

        
        //Success Message
        $vars['porcoes'] = $porcaoDAO->getAllPorcoes();
        $vars['page'] = 'porcoes';
        $vars['success'] = 'Bebida cadastrado com sucesso!';
        return $this->view->render($response, 'template.phtml', $vars);

    }

    public function deletePorcao(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $produtoDAO = new ProdutoDAO();
        $vars['porcoes'] = $produtoDAO->deletePorcao($id);
        
        //Success Message
        $vars['porcoes'] = $produtoDAO->getAllPorcoes();
        $vars['page'] = 'porcoes'; 
        $vars['success'] = 'Porção Deletada';
        return $this->view->render($response, 'template.phtml', $vars); 
    }

//add tabela lanche - $lastId como parâmetro para outra função - $this...
}