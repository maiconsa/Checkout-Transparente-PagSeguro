<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 02/08/2019
 * Time: 00:35
 */

namespace App\pagseguro;


class PagSeguroTransaction extends PagSeguroServices
{
    const SERVICE_NAME = 'transactions';


    public function getServiceUrl()
    {
        return parent::getServiceUrl().PagSeguroTransaction::SERVICE_NAME."?".$this->getCredential()->getHttpQuery();
    }

    public function executeService($data = null){
            $conn = new CurlConnection();
            $conn->post($this->getServiceUrl(),$data);
          $response  = $conn->getResponse();
            if ($conn->getStatus() === 200){
                return $response;
            }
            return $response;
    }
}