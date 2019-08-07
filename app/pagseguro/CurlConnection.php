<?php
/**
 * User:
 * Date: 01/08/2019
 * Time: 23:17
 */

namespace App\pagseguro;


class CurlConnection
{

    private $response;
    private $status;
    public function __construct()
    {
        if(!function_exists('curl_init')){
            throw  new \Exception("É necessário a biblioteca cURL.");
        }
    }


    private function connection($method,$url, $data = null){

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true);
        curl_setopt($ch, CURLOPT_HEADER,false);
        curl_setopt($ch,CURLOPT_HTTPHEADER,[
            'Content-Type: application/x-www-form-urlencoded',
            'charset=ISO-8859-1'
            ]);

        switch ( strtoupper($method)){
                case 'POST':
                    curl_setopt($ch,CURLOPT_POST,true);
                    curl_setopt($ch,CURLOPT_POSTFIELDS,
                        ($data != null) ? http_build_query($data,'','&') : "");
                    break;
                case 'GET':
                    curl_setopt($ch,CURLOPT_HTTPGET,true);
                    break;
        }

            $response =  curl_exec($ch);
            $error =  curl_errno($ch);
            $info   = curl_getinfo($ch);
            $errorMessage =curl_error($ch);

        curl_close($ch);

        $this->response = $response;
        $this->status = $info['http_code'];
        if($error != (int) 0){
            throw new \Exception('Erro conexão cURL'.$errorMessage);
        }
    }


    public function getResponse(){
        return $this->response;
    }

    public function getStatus(){
        return $this->status;
    }


    public function post($url, $data = null){
        return $this->connection('POST',$url,$data);
    }

    public function get($url){
        return $this->connection('GET',$url);
    }


}