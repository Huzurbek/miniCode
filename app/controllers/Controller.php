<?php
namespace App\controllers;


use App\model\QueryBuilder;
use App\model\Roles;
use Delight\Auth\Auth;
use League\Plates\Engine;
use PDO;

class Controller{

    protected $auth;
    protected $view;
    protected $database;

    public function __construct()
    {
        //$this->auth = components(Auth::class);
        global $container;
        $this->auth=$container->get(Auth::class);
        $this->view=$container->get(Engine::class);
        $this->database=$container->get(QueryBuilder::class);

    }


    function checkForAccess()
   {
        if($this->auth->hasRole(Roles::USER)) {
           return header("Location: /");
            exit;
            //return redirect('/');
        }
   }


}