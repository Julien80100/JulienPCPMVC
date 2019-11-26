<?php
namespace Controllers;
use controllers\TacheController;
use controllers\UserController;


class IndexController extends Controller
{
    public function index($params)
    {
        echo $this->twig->render('accueil.html',[]);
    
    }
}