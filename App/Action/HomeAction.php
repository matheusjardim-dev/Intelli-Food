<?php
namespace App\Action;

final class HomeAction extends Action
{

    public function getHome($request, $response)
    {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'home';
        return $this->view->render($response, 'template.phtml', $vars);
    }

    public function getLandingPage($request, $response)
    {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'landing_page';
        
        return $this->view->render($response, 'template.phtml', $vars);
    }

    /*public function getContact($request, $response)
    {
        $vars['title'] = 'Página de Contato';
        $vars['page'] = 'Contato';
        return $this->view->render($response, 'template.phtml', $vars);
    }
*/
    public function getAdmin($request, $response)
    {
        $vars['title'] = 'Intelli Food';
        $vars['page'] = 'admin';
        return $this->view->render($response, 'template.phtml', $vars);
    }

}