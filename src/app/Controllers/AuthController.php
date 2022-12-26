<?php
namespace App\Controllers;

use App\Models\User;
use App\View;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        return View::make('login');
    }
    public function showRegisterPage()
    {
        return View::make('register');
    }
    public function register()
    {
        $postedData = $_POST;
        if( User::where('username', $postedData['username'])->first() )
        {
            $data['error'] = "Username is already in use. Please try another one";
            return View::make('register', $data);
        }
        
        $user = new User();
        $user->name = $postedData['name'];
        $user->username = $postedData['username'];
        $user->password = md5($postedData['password']);
        
        $user->save();
        $user->authenticate();
        $this->redirect("/");
    }
    public function logout()
    {
        User::logout();
        $this->redirect("/login");
    }
    public function login()
    {
        $postedData = $_POST;
        $username = $postedData['username'];
        $password = md5($postedData['password']);
        if( User::attemptLogin($username, $password) )
        {
            return $this->redirect("/");
        }
        return $this->redirect("/login");
    }
}
