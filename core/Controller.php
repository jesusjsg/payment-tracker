<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\View;

class Controller
{
    public function __construct(
        public View $view = new View(),
        public string $model = '',
    ) {}

    public function loadModel(string $model): void
    {
        $url = 'models/' . $model . '.php';
        if (file_exists($url)) {
            require_once $url;

            $modelName = $model;
            $this->model = new $modelName();
        }
    }

    public function existsPost(array $params): bool
    {
        foreach ($params as $param) {
            if (!isset($_POST[$param])) {
                print_r('Dont exist the param of existsPost ->' . $param);
                return false;
            }
        }
        return true;
    }

    public function existsGet(array $params): bool
    {
        foreach ($params as $param) {
            if (!isset($_GET[$param])) {
                print_r('Dont exist the param of existsGet -> ' . $param);
                return false;
            }
        }
        return true;
    }

    public function redirect(string $route, array $alerts): void
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

    public function getPost(string $name): string
    {
        return $_POST[$name];
    }

    public function getGet(string $name): string
    {
        return $_GET[$name];
    }
}