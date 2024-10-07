<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Model;

class SessionController extends Model implements Controller
{
    private $userSession;
    private $username;
    private $userId;
    private $session;
    private $sites;
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }
}