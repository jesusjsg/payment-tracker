<?php

namespace App\Libs;

class ErrorMessage
{
    //login errors
    const ERROR_LOGIN_AUTH = "KAM79CzRSvuvMU1s3hc4";
    const ERROR_LOGIN_AUTH_EMPTY = "5X3sotOCiXnmZTn0UhCA";
    const ERROR_LOGIN_AUTH_INVALID = "ilJuvWjlQNnl5tFDdjdn";

    private $errorList = [];

    public function __construct()
    {
        $this->errorList = [
            ErrorMessage::ERROR_LOGIN_AUTH => "Hubo un problema al iniciar sesion.",
            ErrorMessage::ERROR_LOGIN_AUTH_EMPTY => "Todos los campos son necesarios.",
            ErrorMessage::ERROR_LOGIN_AUTH_INVALID => "Usuario o clave erroneos.",
        ];
    }

    public function get($hash)
    {
        return $this->errorList[$hash];
    }
}