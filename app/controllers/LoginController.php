<?php
namespace App\controllers;

use App\model\Roles;
use Delight\Auth\Auth;
class LoginController extends Controller {

    public function showForm(){
        $this->checkForAccess();
        echo $this->view->render('page_login');
    }

    public function login(){

        try {
            $rememberDuration = null;
            if(isset($_POST['remember'])){
                // keep logged in for one year
                $rememberDuration = (int) (60 * 60 * 24 * 365.25);
            }

            $this->auth->login($_POST['email'], $_POST['password'],$rememberDuration);

            $this->checkIsBanned();
            //echo 'User is logged in';
             return redirect('/home');

        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error(['Wrong email address']);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error(['Wrong password']);
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error(['Email not verified']);
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error(['Too many requests']);
        }
        return redirect('/login');
    }

    public function logout(){
        $this->auth->logOut();
        return redirect('/');
    }

    public function checkIsBanned(){
        if ($this->auth->isBanned()) {
            flash()->error(['User has been banned']);
            $this->auth->logOut();
            return redirect('/');
        }
    }

}