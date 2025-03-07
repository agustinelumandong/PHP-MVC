<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Middleware\AuthMiddleware;

class UserController extends Controller {
    private AuthMiddleware $auth;

    public function __construct() {
        $this->auth = new AuthMiddleware();
    }

    public function login(): void {
        $this->auth->guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getPostData();
            $user = User::findByEmail($data['email']);

            if ($user && $user->verifyPassword($data['password'])) {
                session_start();
                $_SESSION['user_id'] = $user->id;
                $this->redirect('/');
            } else {
                $data = ['error' => 'Invalid credentials'];
                $this->render('user/login', $data);
            }
        } else {
            $this->render('user/login');
        }
    }

    public function register(): void {
        $this->auth->guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getPostData();
            
            if ($data['password'] !== $data['password_confirm']) {
                $this->render('user/register', ['error' => 'Passwords do not match']);
                return;
            }

            if (User::findByEmail($data['email'])) {
                $this->render('user/register', ['error' => 'Email already exists']);
                return;
            }

            $user = User::create($data);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user->id;
                $this->redirect('/');
            } else {
                $this->render('user/register', ['error' => 'Registration failed']);
            }
        } else {
            $this->render('user/register');
        }
    }

    public function profile(): void {
        $this->auth->handle();
        $user = User::findById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getPostData();
            if ($user->update($data)) {
                $this->redirect('/profile');
            } else {
                $this->render('user/profile', ['user' => $user, 'error' => 'Update failed']);
            }
        } else {
            $this->render('user/profile', ['user' => $user]);
        }
    }

    public function logout(): void {
        $this->auth->handle();
        session_start();
        session_destroy();
        $this->redirect('/login');
    }

    public function show(int $id): void {
        $user = User::findById($id);
        if ($user) {
            $this->render('user/show', ['user' => $user]);
        } else {
            throw new \Exception('User not found', 404);
        }
    }
}