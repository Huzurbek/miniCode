<?php
namespace App\controllers;


use App\model\ImageManager;
use App\model\Registration;

use App\model\Roles;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as validation;

class RegisterController extends Controller
{

    private $registration,$imageManager;

    public function __construct(Registration $registration, ImageManager $imageManager)
    {
        parent::__construct();
        $this->registration = $registration;
        $this->imageManager=$imageManager;
    }

    public function showForm()
    {
        echo $this->view->render('page_register');
    }

    public function register()
    {
        $userId = $this->registration->make($_POST['email'], $_POST['password'],'USERNAME');
        $this->registration->verify();
        $this->database->update('users',['roles_mask'=>Roles::USER],'id=:id',$userId);
        $this->database->insert('users_information',
            [
                'user_id' => $userId,
                'username'=>'USERNAME',
                'job_title' => 'Job Place',
                'phone' => 'User phone number',
                'address' => 'User address',
                'status' => 'success',
                'avatar' =>''

            ]);
        $this->database->insert('users_links',
            [
                'user_id' => $userId,
                'vk' => 'vk',
                'telegram' =>'telegram',
                'instagram' => 'instagram'
            ]);
        flash()->success('Регистрация успешна');
        return redirect('/login');

    }

}

