<?php


namespace App\pagseguro;


final class PagSeguroConfig
{

    private static $defaults =[
            'paymentMode' => 'default',
            'receiverEmail' => 'maicon-s-a@hotmail.com',
            'currency' => 'BRL',
            'extraAmount' => '0.00',
            'notificationURL' => 'http://localhost/notification',
            'reference' => 'REF1234',
            'noInterestInstallmentQuantity' => 3,
            'shippingAddressRequired' => 'true',
            'shippingType' => '3',
            'shippingCost' => '0.00'
        ];
    

    const WS_SANDBOX_URL = 'https://ws.sandbox.pagseguro.uol.com.br';
    const WS_PRODUCTION_URL = 'https://ws.pagseguro.uol.com.br';

    const STC_SANBOX_URL = 'https://stc.sandbox.pagseguro.uol.com.br';
    const  STC_PRODUCTION_URL = 'https://stc.pagseguro.uol.com.br';

    const VERSION = '/v2/';

    private  static $inSandbox = false;

    private static $credentials;

    public static function init($email,$token){
        self::$credentials = new PagSeguroCredentials($email,$token);

        header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
    }

    public static function getCredentials(){
        return self::$credentials;
    }

    public  static function setMode($inSandBox){
        self::$inSandbox = $inSandBox;
    }

    public static function isSandBoxMode(){
        return self::$inSandbox === true;
    }

    public static function  getSTCUrl(){
        if(self::$inSandbox === true){
            return PagSeguroConfig::STC_SANBOX_URL;
        }else{
            return PagSeguroConfig::STC_PRODUCTION_URL;
        }
    }

    public static function getWSBaseUrl(){
        if(self::$inSandbox === true){
            return PagSeguroConfig::WS_SANDBOX_URL.PagSeguroConfig::VERSION;
        }else{
            return PagSeguroConfig::WS_PRODUCTION_URL.PagSeguroConfig::VERSION;
        }
    }

    public static function getDefaults(){
        return self::$defaults;
    }
}