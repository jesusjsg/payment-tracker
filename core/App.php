<?php

namespace App\Core;

use App\Controllers\ErrorController;
use App\Controllers\LoginController;

class App
{
    function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if (empty($url[0])) {
            error_log('No hay ningun controlador');
            $fileController = 'controllers/LoginController.php';
            require_once $fileController;
            $controller = new LoginController();
            $controller->loadModel('LoginController'); // controller class is called here
            $controller->render();
            return false;
        }

        $fileController = 'controllers/' . $url[0] . '.php';

        if (file_exists($fileController)) {
            require_once $fileController;
            $controller = new $url[0];
            $controller->loadModel($url[0]);

            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    if (isset($url[2])) {
                        // without params
                        $numberParam = count($url) - 2;
                        $params = [];

                        for ($i = 0; $i < $numberParam; $i++) {
                            array_push($params, $url[$i + 2]);
                        }
                        $controller->{$url[1]}($params);
                    } else {
                        // don't have any param
                        $controller->{$url[1]}();
                    }
                } else {
                    // error, the method don't exist
                    $controller = new ErrorController();
                    $controller->render();
                }
            } else {
                $controller->render();
            }
        } else {
            // error, the file don't exist
            $controller = new ErrorController();
            $controller->render();
        }
    }
}
