<?php
namespace App\Controllers;

use App\Models\MySQL\Intellifood_db\VendaModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\Intellifood_db\VendaDAO;
use App\DAO\MySQL\Intellifood_db\UserDAO;
use App\Action\Action as Action;

final class VendaController extends Action{

    public function getCardapio(Request $request, Response $response, array $vars): Response {
        $vendaDAO = new VendaDAO();
        $vars['page'] = 'cardapio';
        $vars['bebidas'] = $vendaDAO->getCardapio();
        $vars['lanches'] = $vendaDAO->getLanche();
        $vars['porcoes'] = $vendaDAO->getPorcoes();
        //
        
        return $this->view->render($response, 'template.phtml'  , $vars);
    }

    public function getCarrinho(Request $request, Response $response, array $vars): Response {
        $iduser = $_SESSION['id'];
        $vars['page'] = 'carrinho';
        $vendaDAO = new VendaDAO();
        $vars['bebida'] = $vendaDAO->getCartBebida($iduser);
        $vars['lanche'] = $vendaDAO->getCartLanche($iduser);
        $vars['porcao'] = $vendaDAO->getCartPorcao($iduser);

        return $this->view->render($response, 'template.phtml'  , $vars);
    }

    public function addBebidaCarrinho(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $idbebida = filter_var($data['idbebida'], FILTER_SANITIZE_NUMBER_INT);
        $iduser = $_SESSION['id'];

        $vendaDAO = new VendaDAO();
        $vendaDAO->addBebidaCarrinho($iduser, $idbebida);
        
        $vars['bebidas'] = $vendaDAO->getCardapio();
        $vars['lanches'] = $vendaDAO->getLanche();
        $vars['porcoes'] = $vendaDAO->getPorcoes();
        $vars['success'] = 'Adicionado ao carrinho';
        $vars['page'] = 'cardapio'; 
        return $this->view->render($response, 'template.phtml', $vars);
 
    }

    public function addPorcaoCarrinho(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $idporcao = filter_var($data['idporcao'], FILTER_SANITIZE_NUMBER_INT);
        $iduser = $_SESSION['id'];

        $vendaDAO = new VendaDAO();
        $vendaDAO->addporcaoCarrinho($iduser, $idporcao);
        
        $vars['bebidas'] = $vendaDAO->getCardapio();
        $vars['lanches'] = $vendaDAO->getLanche();
        $vars['porcoes'] = $vendaDAO->getPorcoes();
        $vars['success'] = 'Adicionado ao carrinho';
        $vars['page'] = 'cardapio'; 
        return $this->view->render($response, 'template.phtml', $vars);
 
    }

    public function addLancheCarrinho(Request $request, Response $response, array $vars): Response {
        $data = $request->getQueryParams();
        $idlanche = filter_var($data['idlanche'], FILTER_SANITIZE_NUMBER_INT);
        $iduser = $_SESSION['id'];

        $vendaDAO = new VendaDAO();
        $vendaDAO->addlancheCarrinho($iduser, $idlanche);
        
        $vars['bebidas'] = $vendaDAO->getCardapio();
        $vars['lanches'] = $vendaDAO->getLanche();
        $vars['porcoes'] = $vendaDAO->getPorcoes();
        $vars['success'] = 'Adicionado ao carrinho';
        $vars['page'] = 'cardapio'; 
        return $this->view->render($response, 'template.phtml', $vars);
 
    }
    //erro: tabela 'cardapio' não existe - solução: alterar comando para tabela 'carrinho';

    public function getPedidos(Request $request, Response $response, array $vars): Response {

        $vars['page'] = 'pedidos';
        $vendaDAO = new VendaDAO();
        $vars['pedidos'] = $vendaDAO->getPedidos();

        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function getRelatorio(Request $request, Response $response, array $vars): Response {

        $vars['page'] = 'relatorio';
        $vendaDAO = new VendaDAO();
        $vars['dados'] = $vendaDAO->getRelatorio();

        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function getDetalhes(Request $request, Response $response, array $vars): Response {
        $vendaDAO = new VendaDAO();
        $data = $request->getQueryParams();
        $idpedido = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        
        
        $vars['lanches'] = $vendaDAO->getDetalhesLanche($idpedido);
        $vars['bebidas'] = $vendaDAO->getDetalhesBebida($idpedido);
        $vars['porcoes'] = $vendaDAO->getDetalhesPorcao($idpedido);
        $vars['pedido'] = $vendaDAO->getDetalhes($idpedido);

        $vars['page'] = 'detalhes';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function getDetalhesCliente(Request $request, Response $response, array $vars): Response {
        $vendaDAO = new VendaDAO();
        $data = $request->getQueryParams();
        $idpedido = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        
        
        $vars['lanches'] = $vendaDAO->getDetalhesLanche($idpedido);
        $vars['bebidas'] = $vendaDAO->getDetalhesBebida($idpedido);
        $vars['porcoes'] = $vendaDAO->getDetalhesPorcao($idpedido);
        $vars['pedido'] = $vendaDAO->getDetalhes($idpedido);

        $vars['page'] = 'detalhesCliente';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function getMyPedidos(Request $request, Response $response, array $vars): Response {
        $iduser = $_SESSION['id'];
        $vars['page'] = 'meus-pedidos';
        $vendaDAO = new VendaDAO();
        $vars['pedidos'] = $vendaDAO->getMyPedidos($iduser);

        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function finalizar(Request $request, Response $response, array $vars): Response {
        $iduser = $_SESSION['id'];
        $userDAO = new UserDAO();
        $vendaDAO = new VendaDAO();
        //
        $vars['page'] = 'finalizar-pedido';
        $vars['enderecos'] = $userDAO->getAllEnd($iduser);
        //
        $vars['bebida'] = $vendaDAO->getCartBebida($iduser);
        $vars['lanche'] = $vendaDAO->getCartLanche($iduser);
        $vars['porcao'] = $vendaDAO->getCartPorcao($iduser);
    
        return $this->view->render($response, 'template.phtml', $vars);
    }

    //OBSERVAÇÃO:
    //CORREÇÃO EM ATUALIZÇÕES FUTURAS;
    public function pedir(Request $request, Response $response, array $vars){
        $iduser = $_SESSION['id'];
        $vendaDAO = new VendaDAO();
        //
        $data = $request->getQueryParams();
        $end = filter_var($data['endereco'], FILTER_SANITIZE_NUMBER_INT);
        $preco = $_SESSION['total'];
        $bebidas = $vendaDAO->getCartBebida($iduser);
        $lanche = $vendaDAO->getCartLanche($iduser);
        $porcao = $vendaDAO->getCartPorcao($iduser);
        //
        $pedido = $vendaDAO->pedir($iduser, $end, $preco, $bebidas, $lanche, $porcao);
        $this->atualizarEstoque();
        //
        $vars['pedidos'] = $vendaDAO->getMyPedidos($iduser);
        $vars['page'] = 'meus-pedidos';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function atualizarEstoque(){
        $iduser = $_SESSION['id'];
        $vendaDAO = new VendaDAO();
        //
        $bebidas = $vendaDAO->getCartBebida($iduser);
        $lanches = $vendaDAO->getCartLanche($iduser);
        $porcao = $vendaDAO->getCartPorcao($iduser);
        //
        if (isset($bebidas)){
            foreach ($bebidas as $bebida) {
                $idbebida = $bebida->idbebida;
                $estoque = $vendaDAO->getBebida($idbebida);
                foreach ($estoque as $item) {
                    $qtd_estoque = $item->quantidade;
                    $qtd = $qtd_estoque - 1; 
                    $vendaDAO->estoqueBebida($qtd, $idbebida);
                }
            } 
        }

        if (isset($lanches)){
            foreach ($lanches as $lanche) {
                $idlanche = $lanche->idlanche;
                $idpao = $lanche->pao;

                $ingredientes = $vendaDAO->ingredientesLanche($idlanche);
                $pao = $vendaDAO->paesLanche($idpao);
                $estoque_pao = $pao->qtd_pao;
                $qtd_pao = $estoque_pao - 1;

                $vendaDAO->estoquePao($qtd_pao, $idpao);

                //
                foreach ($ingredientes as $ingrediente) {
                    $idingrediente = $ingrediente->ingredientes_idingredientes;
                    $qtd_ing = $ingrediente->quantidade;
                    //
                    $estoque = $vendaDAO->selectIngrediente($idingrediente);
                    $quantidade = $estoque->qtd_ingrediente;
                    $qtd = $quantidade - $qtd_ing;
                    //
                    $vendaDAO->estoqueIngredientes($qtd, $idingrediente);
                }
            }
        }

        if (isset($porcao)){
            foreach ($porcao as $porcao) {
                $idporcao = $porcao->idporcao;
                $ingredientes = $vendaDAO->ingredientesPorcao($idporcao);
                //
                foreach ($ingredientes as $ingrediente) {
                    $idingrediente = $ingrediente->ingredientes_idingredientes;
                    $qtd_ing = $ingrediente->quantidade;
                    //
                    $estoque = $vendaDAO->selectIngrediente($idingrediente);
                    $quantidade = $estoque->qtd_ingrediente;
                    $qtd = $quantidade - $qtd_ing;
                    //
                    $vendaDAO->estoqueIngredientes($qtd, $idingrediente);
                }
            }
        }

    }

    public function removerBebida(Request $request, Response $response, array $vars){
        $id = $_SESSION['id'];
        $vendaDAO = new VendaDAO();
        //
        $data = $request->getQueryParams();
        $idbebida = filter_var($data['idbebida'], FILTER_SANITIZE_NUMBER_INT);
        $vendaDAO->removerBebida($id, $idbebida);

        $this->getCarrinho($request, $response, $vars);
    }

    public function removerLanche(Request $request, Response $response, array $vars){
        $id = $_SESSION['id'];
        $vendaDAO = new VendaDAO();
        //
        $data = $request->getQueryParams();
        $idlanche = filter_var($data['idlanche'], FILTER_SANITIZE_NUMBER_INT);
        $vendaDAO->removerLanche($id, $idlanche);

        $this->getCarrinho($request, $response, $vars);
    }

    public function removerPorcao(Request $request, Response $response, array $vars){
        $id = $_SESSION['id'];
        $vendaDAO = new VendaDAO();
        //
        $data = $request->getQueryParams();
        $idporcao = filter_var($data['idporcao'], FILTER_SANITIZE_NUMBER_INT);
        $vendaDAO->removerporcao($id, $idporcao);

        $this->getCarrinho($request, $response, $vars);
    }
}