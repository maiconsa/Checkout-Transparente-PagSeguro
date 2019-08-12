<?php


namespace App\pagseguro;


use App\pagseguro\PagSeguroLogs;

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

           $code = -1;
            if ($conn->getStatus() === 200){
                     $object = simplexml_load_string($response);         
                    $code = $object->code;       
            }else{  
                $code = 'error_'.date('dmYHis');   
            }
            PagSeguroLogs::save($code,$response);     
            return $code;


    }
}