<?php
namespace App\model;




use Delight\Auth\Auth;
use Delight\Auth\Role;

class Registration{

    private $auth, $database,$selector,$token;

    public function __construct(Auth $auth, QueryBuilder $database)
    {
        $this->auth = $auth;
        $this->database=$database;
    }

    public function make($email,$password,$username){
        try {
            $userId = $this->auth->register($email,$password,$username, function ($selector, $token) {
                //echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                $this->selector=$selector;
                $this->token=$token;
            });
            $this->database->update('users',['roles_mask'=>Roles::USER],'id=:id',$userId);
           return $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error(['Invalid email address']);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error(['Invalid password']);
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            flash()->error(['User already exists']);
        }
       catch (\Delight\Auth\TooManyRequestsException $e) {
           flash()->error(['Too many requests']);

       }
        return redirect('/register');
    }

    public function verify()
    {
        $this->auth->confirmEmail($this->selector,$this->token);

    }


}