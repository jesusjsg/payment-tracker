<?php

namespace App\Libs;

class SuccessMessage
{
    //login success
    const SUCCESS_NEW_USER = "KAM79CzRSvuvMU1s3hc4";

    private $successList = [];


    public function __construct()
    {
        $this->successList = [
            SuccessMessage::SUCCESS_NEW_USER => "El usuario se creo correctamente.",
        ];
    }

    public function get($hash)
    {
        return $this->successList[$hash];
    }

    public function existsKey($key)
    {
        if (array_key_exists($key, $this->successList)) {
            return true;
        }
    }
}