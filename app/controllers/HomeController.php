<?php
namespace App\controllers;



use App\model\ImageManager;
use App\model\UserService;
use App\Services\Database;

use Delight\Auth\Auth;
use Delight\Auth\Role;
use League\Plates\Engine;

class HomeController extends Controller{

    private $userService,$imageManager;

    public function __construct(UserService $userService,ImageManager $imageManager)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->imageManager=$imageManager;
    }
//Main page:
    public function index()
    {
      $loggedId=$this->auth->getUserId();
      $admin=$this->auth->hasAllRoles(Role::ADMIN);
      $users=$this->userService->getAllFromTables();

      if($this->auth->isLoggedIn()){
            echo $this->view->render('home', ['users'   =>  $users,'admin'=>$admin,'loggedId'=>$loggedId]);
        }else{
            redirect('login');
        }
    }

}