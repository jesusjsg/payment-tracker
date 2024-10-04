<?php

namespace App\Core;

use App\Core\View;

class Controller
{
    public $view;
    public $model;

    public function __construct()
    {
        $this->view = new View();
    }

    public function loadModel($model)
    {
        $url = 'models/' . $model . '.php';
        if (file_exists($url)) {
            require_once $url;

            $modelName = $model;
            $this->model = new $modelName();
        }
    }

    public function existsPost($params)
    {
        foreach ($params as $param) {
            if (!isset($_POST[$param])) {
                print_r('Dont exist the param of existsPost ->' . $param);
                return false;
            }
        }
        return true;
    }

    public function existsGet($params)
    {
        foreach ($params as $param) {
            if (!isset($_GET[$param])) {
                print_r('Dont exist the param of existsGet -> ' . $param);
                return false;
            }
        }
        return true;
    }

    public function redirect($route, $alerts)
    {
        $data = [];
        $params = '';

        foreach ($alerts as $key => $alert) {
            array_push($data, $key . '=' . $alert);
        }
        $params = join('&', $data);

        if ($params != '') {
            $params = '?' . $params;
        }

        header('Location: ' . URL . $route . $params);
    }

    public function getPost($name)
    {
        return $_POST[$name];
    }

    public function getGet($name)
    {
        return $_GET[$name];
    }
}