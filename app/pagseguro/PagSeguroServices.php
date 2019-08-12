<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 02/08/2019
 * Time: 00:24
 */

namespace App\pagseguro;


abstract class PagSeguroServices
{

    private $credential;

    public function __construct(PagSeguroCredentials $credentials)
    {
        $this->credential = $credentials;
    }

    /**
     * @return PagSeguroCredentials
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * @param PagSeguroCredentials $credential
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
    }


    public function getServiceUrl(){
        return PagSeguroConfig::getWSBaseUrl();
    }
    
    abstract public function executeService($data = null);



}