<?php

use function src\slimConfiguration;
use App\Controllers\UserController;
use App\Controllers\IngredienteController;
use App\Controllers\ProdutoController;
use App\Controllers\VendaController;
use App\Action\HomeAction;

$app = new \Slim\App(slimConfiguration());

$app->get('/', HomeAction::class . ':getLandingPage');
$app->get('/home', HomeAction::class . ':getHome');
$app->get('/admin', HomeAction::class . ':getAdmin');

//Rotas - Usuários
$app->get('/usuarios', UserController::class . ':getUser');
$app->get('/deletarUser', UserController::class . ':deleteUser');
$app->get('/novoUsuario', UserController::class . ':novoUser');
$app->post('/novoUsuario', UserController::class . ':insertUser');
$app->get('/cadastro', UserController::class . ':cadUser');
$app->post('/cadastro', UserController::class . ':cadastroUser');
$app->get('/atualizarUser', UserController::class . ':selectUser');
$app->post('/atualizarUser', UserController::class . ':updateUser');
$app->get('/login', UserController::class . ':log');
$app->post('/login', UserController::class . ':login');
$app->get('/logout', UserController::class . ':logout');
$app->get('/cadastrar-endereco', UserController::class . ':cadEnd');
$app->post('/cadastrar-endereco', UserController::class . ':cadastroEnd');
$app->get('/deletarEnd', UserController::class . ':deleteEnd');
$app->get('/enderecos', UserController::class . ':getEndereco');
$app->get('/editar-endereco', UserController::class . ':formEditEnd');
$app->post('/editar-endereco', UserController::class . ':editarEnd');

//Rotas - Ingredientes
$app->get('/ingredientes', IngredienteController::class . ':getIngrediente');
$app->get('/add-ingrediente', IngredienteController::class . ':formIngrediente');
$app->post('/add-ingrediente', IngredienteController::class . ':addIngrediente');
$app->get('/deletar-ingrediente', IngredienteController::class . ':deleteIngrediente');
$app->get('/editar-ingrediente', IngredienteController::class . ':formEditIngrediente');
$app->post('/editar-ingrediente', IngredienteController::class . ':editarIngrediente');

//Rotas - Bebidas
$app->get('/add-bebida', ProdutoController::class . ':formBebida');
$app->post('/add-bebida', ProdutoController::class . ':addBebida');
$app->get('/bebidas', ProdutoController::class . ':getBebida');
$app->get('/deletar-bebida', ProdutoController::class . ':deleteBebida');
$app->get('/editar-bebida', ProdutoController::class . ':formEditBebida');
$app->post('/editar-bebida', ProdutoController::class . ':editarbebida');

//Rotas - Pão
$app->get('/add-pao', IngredienteController::class . ':formPao');
$app->post('/add-pao', IngredienteController::class . ':addPao');
$app->get('/paes', IngredienteController::class . ':getPao');
$app->get('/deletar-pao', IngredienteController::class . ':deletePao');
$app->get('/editar-pao', IngredienteController::class . ':formEditPao');
$app->post('/editar-pao', IngredienteController::class . ':editarPao');

//Rotas - Lanches
$app->get('/lanches', ProdutoController::class . ':getLanche');
$app->get('/add-lanche', ProdutoController::class . ':formLanche');
$app->post('/add-lanche', ProdutoController::class . ':addLanche');
$app->get('/deletar-lanche', ProdutoController::class . ':deleteLanche');

//Rotas - Porção
$app->get('/porcoes', ProdutoController::class . ':getPorcao');
$app->get('/add-porcao', ProdutoController::class . ':formPorcao');
$app->post('/add-porcao', ProdutoController::class . ':addPorcao');
$app->get('/deletar-porcao', ProdutoController::class . ':deletePorcao');

//Rota - Estoque
$app->get('/estoque', ProdutoController::class . ':getEstoque');

$app->get('/cardapio', VendaController::class . ':getCardapio');
$app->get('/carrinho', VendaController::class . ':getCarrinho');
$app->get('/add-beb-carrinho', VendaController::class . ':addBebidaCarrinho');
$app->get('/add-lan-carrinho', VendaController::class . ':addLancheCarrinho');
$app->get('/add-porc-carrinho', VendaController::class . ':addPorcaoCarrinho');

$app->get('/finalizar-pedido', VendaController::class . ':finalizar');
$app->get('/fazer-pedido', VendaController::class . ':pedir');

$app->get('/remover-bebida', VendaController::class . ':removerBebida');
$app->get('/remover-lanche', VendaController::class . ':removerLanche');
$app->get('/remover-porcao', VendaController::class . ':removerPorcao');


//Rotas - Venda
$app->get('/pedidos', VendaController::class . ':getPedidos');
$app->get('/detalhes-pedido', VendaController::class . ':getDetalhes');
$app->get('/detalhes', VendaController::class . ':getDetalhesCliente');
$app->get('/relatorio', VendaController::class . ':getRelatorio');
$app->get('/meus-pedidos', VendaController::class . ':getMyPedidos');

/*
//Rotas - Porções
$app->get('/editar-porcao', ProdutoController::class . ':formEditPorcao');
$app->post('/editar-porcao', ProdutoController::class . ':editarPorcao');

//Rotas - Lanches
$app->get('/editar-lanche', ProdutoController::class . ':formEditLanche');
$app->post('/editar-lanche', ProdutoController::class . ':editarlanche');

*/