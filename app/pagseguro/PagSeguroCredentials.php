<?php

namespace App\pagseguro;


class PagSeguroCredentials
{
    private $credencial = [];
    public function __construct($email,$token)
    {
        $this->credencial = [
            "email" =>$email ,
            "token" =>$token
        ];
    }

    public function getHttpQuery(){
       return http_build_query($this->credencial);
    }
}