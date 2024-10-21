<?php

namespace Byuufx\Kangu;

class Kangu{

    use Connection;

    const API_URL = 'https://portal.kangu.com.br/tms/transporte';

    public $token = '';
    public $connection = null;

    /**
     * @param string $token
     *
     * @throws \Exception
     */
    public function __construct($token){

        if(empty($token)){
            throw new \Exception('Token Kangu não informado');
        }

        $this->token = $token;
        
    }
}