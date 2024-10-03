<?php

namespace App\Core;

use App\Libs\ErrorMessage;
use App\Libs\SuccessMessage;

class View 
{
    public $data;

    function __construct()
    {
        
    }

    public function render($name, $data = [])
    {
        $this->data = $data;
        $this->handleAlerts();

        require 'views/' . $name . '.php';
    }

    private function handleAlerts()
    {
        if (isset($_GET['success']) && isset($_GET['error'])) {
            //error
        } else if (isset($_GET['success'])) {
            $this->handleSuccess();
        } else if (isset($_GET['error'])) {
            $this->handleError();
        }
    }

    private function handleSuccess()
    {
        $hash = $_GET['success'];
        $success = new SuccessMessage();

        if ($success->existsKey($hash)) {
            $this->data['success'] = $success->get($hash);
        }
    }

    private function handleError()
    {
        $hash = $_GET['error'];
        $error = new ErrorMessage();

        if ($error->existsKey($hash)) {
            $this->data['error'] = $error->get($hash);
        }
    }

    public function showAlerts()
    {
        $this->showSuccess();
        $this->showErrors();
    }

    public function showSuccess()
    {
        if (array_key_exists('success', $this->data)) {
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Operación exitosa',
                    text: '" . $this->data['error'] . "',
                })
            </script>
            ";
        }

    }

    public function showErrors()
    {
        if (array_key_exists('error', $this->data)) {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrió un error',
                    text: '" . $this->data['error'] . "',
                })
            </script>
            ";
        }
    }

}