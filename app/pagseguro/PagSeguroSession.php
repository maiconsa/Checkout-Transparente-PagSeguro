<?php

namespace App\pagseguro;



class PagSeguroSession extends PagSeguroServices
{
    private $url;

    const SERVICE_NAME = 'sessions';
    const SESSION_ID = 'SESSIONID';

    public function getServiceUrl()
    {
        return parent::getServiceUrl().PagSeguroSession::SERVICE_NAME."?".$this->getCredential()->getHttpQuery();
    }

public function executeService($data = null)
    {
        $conn = new CurlConnection();
        $conn->post($this->getServiceUrl(),$data);
        $response = $conn->getResponse();
        if ($conn->getStatus() === 200) {
            $object = simplexml_load_string($response);
            $id = $object->id;
            return (string)$id;
        }else {
            throw new \Exception('Erro ao obter id de sessão');
        }


    }


}