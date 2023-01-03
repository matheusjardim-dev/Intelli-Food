<?php 
namespace App\Functions;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class RandomFunctions {

    public function isLoggedIn ()  {
        if (!isset($_SESSION)) session_start();

        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
        session_destroy(); 
        header('Location: /login');
        exit;
        }
    }

    public function DirectUserAten () {
        if (!isset($_SESSION)) session_start();

        if ($_SESSION['nivel'] >= 4) {    
            header('Location: /home');
            exit;
        }
    }

    public function DirectAdm () {
        if (!isset($_SESSION)) session_start();

        if ($_SESSION['nivel'] >= 4) {    
            header('Location: /home');
            exit;
        }

        if ($_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 3) {    
            header('Location: /admin');
            exit;
          }
    }

    public function DirectGer () {
        if (!isset($_SESSION)) session_start();

        if ($_SESSION['nivel'] >= 4) {    
            header('Location: /home');
            exit;
        }

        if ($_SESSION['nivel'] == 3) {    
            header('Location: /admin');
            exit;
        }
    }
/*
    public function DirectAten () {
        if (!isset($_SESSION)) session_start();

        if ($_SESSION['nivel'] >= 4) {    
            header('Location: /home');
            exit;
        }

        if ($_SESSION['nivel'] == 3) {    
            header('Location: /admin');
            exit;
        }
    }
 */

}

?>