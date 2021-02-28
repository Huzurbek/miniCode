<?php


namespace App\controllers;


use App\model\ImageManager;
use App\model\Roles;
use App\model\UserService;
use Delight\Auth\Role;

class UserController extends Controller
{
      private $userService,$imageManager;
    public function __construct(UserService $userService,ImageManager $imageManager )
    {
        parent::__construct();
        $this->userService = $userService;
        $this->imageManager = $imageManager;
    }

//Show Creat_User_Form:
    public function createForm()
    {
        if(!$this->auth->isLoggedIn()){redirect("login"); }
        echo $this->view->render('create_user');
    }

//Create New User:
    public function createUser(){

        try {
            $userId=$this->auth->admin()->createUser($_POST['email'], $_POST['password'], 'null');
            //$this->database->find('users',$userId);
            $this->database->update('users',['roles_mask'=>Roles::USER],'id=:id',$userId);
            $this->database->insert('users_information',
                [
                    'user_id' => $userId,
                    'username'=>$_POST['username'],
                    'job_title' => $_POST['job_title'],
                    'phone' => $_POST['phone'],
                    'address' => $_POST['address'],
                    'status' => set_status($_POST['status']),
                    'avatar' => $this->imageManager->uploadImage($_FILES['image'])

                ]);
            $this->database->insert('users_links',
                [
                    'user_id' => $userId,
                    'vk' => $_POST['vk'],
                    'telegram' => $_POST['telegram'],
                    'instagram' => $_POST['instagram']
                ]);
            flash()->success('Новый пользователь успешно добавлен');
            return redirect('/home');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            // invalid email address
            flash()->error(['Неправильный формат email']);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            // invalid password
            flash()->error(['Неправильный пароль']);
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            // user already exists
            flash()->error(['Пользователь уже существует']);
        }

       return redirect('/create');
    }

//Show Form of User's Information by Id:
    public function showUserForm($id){
        if(!$this->auth->isLoggedIn()){redirect("login"); }
        $user=$this->userService->getOneFromTables($id);

        echo $this->view->render('edit',['user'=>$user]);
    }

//Edit User's info and Redirect to MainPage:
    public function editUser($id){
        $data=[
            'username'=>$_POST['username'],
            'job_title'=>$_POST['job_title'],
            'phone'=>$_POST['phone'],
            'address'=>$_POST['address']];

        $this->database->update('users_information',$data,'users_information.user_id=:id',$id);
        flash()->success("Информация о пользователе успешно изменена");
        redirect('/home');
    }

//Show Form of Security(Change email and Password):
    public function showSecurity($id){
        if(!$this->auth->isLoggedIn()){redirect("login"); }
        $user=$this->database->find('users',$id);

        echo $this->view->render('security',['user'=>$user]);
    }

//Edit Security (email and password info) and Redirect to MainPage:
    public function editSecurity($id){
        $data=[
            'id'=>$id,
            'email'=>$_POST['email'], //user enters new email
            'password'=>password_hash($_POST['password'],PASSWORD_DEFAULT)
        ];
        $this->userService->changeSecurity($id,$data);
    }

//Delete User Redirect to MainPage:
    public function deleteUser($id){
        $loggedUser=$this->auth->getUserId();
        $admin=$this->auth->hasAllRoles(Role::ADMIN);
        if($loggedUser==$id||$id==$admin['id']){
               $this->userService->deleteUserbyID($id);
               $this->auth->logOut();
               redirect('/login');
           }else{
               $this->userService->deleteUserbyID($id);
               return redirect('/home');
           }
    }

//Show Form of Avatar:
    public function showAvatar($id){
        if(!$this->auth->isLoggedIn()){redirect("login"); }
        $user=$this->userService->getOneFromTables($id);
        echo $this->view->render('changeAvatar',['user'=>$user]);
    }
//Change Avatar:
    public function editAvatar($id){
        $data=['avatar'=>$this->imageManager->uploadImage($_FILES['image'])];
        $this->database->update('users_information',$data,'user_id=:id',$id);
        flash()->success("Аватар пользователя успешно изменен");
        redirect('/home');
    }
//Show Form of Status:
    public function showStatus($id){
        if(!$this->auth->isLoggedIn()){redirect("login"); }
        $status=[
            'success'=>'Онлайн',
            'warning'=>'Отошел',
            'danger'=>'Не беспокоить'
        ];
        $user=$this->userService->getOneFromTables($id);
        echo $this->view->render('status',['user'=>$user,'status'=>$status]);
    }
//Change Status and redirect to Mainpage:
    public function editStatus($id){
        $this->database->update('users_information',['status'=>set_status($_POST['status'])],'users_information.user_id=:id',$id);
        flash()->success("Статус пользователя успешно изменен");
        redirect('/home');
    }
//Show Profile:
    public function showProfile($id){
        if(!$this->auth->isLoggedIn()){redirect("login"); }
        $user=$this->userService->getOneFromTables($id);

        echo $this->view->render('profile',['user'=>$user]);
    }

}