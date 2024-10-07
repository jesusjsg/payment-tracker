<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class LoginController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
    }

    public function render()
    {
        $this->view->render('login/index');
    }
}