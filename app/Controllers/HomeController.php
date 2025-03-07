<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
    public function index(): void {
        $data = [
            'title' => 'Welcome to MyApp',
            'description' => 'A simple MVC framework in PHP'
        ];
        $this->render('home/index', $data);
    }

    public function about(): void {
        $data = [
            'title' => 'About Us',
            'content' => 'This is the about page.'
        ];
        $this->render('home/about', $data);
    }

    public function contact(): void {
        $data = [
            'title' => 'Contact Us',
            'content' => 'Get in touch with us.'
        ];
        $this->render('home/contact', $data);
    }
}