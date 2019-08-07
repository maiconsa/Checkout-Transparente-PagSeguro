<?php

require_once ('vendor/autoload.php');

use  \App\PageBuilder;
use  \App\pagseguro\PagSeguroSession;
use  \App\pagseguro\PagSeguroTransaction;
use   \App\pagseguro\PagSeguroCredentials;
use     \App\model\Sender;
use     \App\pagseguro\PagSeguroConfig;

//Inicia a sessão caso estiver habilitada. mas ainda não foi iniciada
if(session_status() === PHP_SESSION_NONE ){
    session_start();
}
PagSeguroConfig::init('your email','your token');
PagSeguroConfig::setMode(true);

$app = new \Slim\Slim();


$app->get('/',function () use ($app){
    if(Sender::checkSenderExist()){
        $app->redirect('/payment');
    }else{
        $app->redirect('/create/sender');
    }


});

$app->get('/payment',function ()use ($app){
    if(!Sender::checkSenderExist()){
        $app->redirect("/");
    }
        $page = new PageBuilder();
        $page->draw('payment');


});

$app->get('/create/sender',function() use($app){
    $page = new PageBuilder();
    $page->draw('personal-information');
});

$app->post('/create/sender',function () use($app){
        $sender = new Sender($_POST['name'],$_POST['cpf'],$_POST['areaCode'],$_POST['phone'],$_POST['email']);

        $address = new \App\model\Address();
        $address->setCity($_POST['city']);
        $address->setComplement($_POST['complement']);
        $address->setCountry($_POST['country']);
        $address->setState($_POST['state']);
        $address->setNumber($_POST['number']);
        $address->setDistrict($_POST['district']);
        $address->setStreet($_POST['street']);
        $address->setPostalCode($_POST['postalCode']);

        $sender->setAddress($address);

        $_SESSION[Sender::SENDER] = $sender;

        $app->redirect('/payment');

});

$app->get('/sender/unregister',function () use ($app){
    unset($_SESSION[Sender::SENDER]);
    $app->redirect('/');
});

$app->get('/boleto',function() use ($app){
    if(!Sender::checkSenderExist()){
        $app->redirect("/");
    }
    $page = new PageBuilder();
    $page->draw('boleto-payment');

});

$app->post('/session',function () use ($app){
    Sender::checkSenderExist();
    $pagsession = new PagSeguroSession(PagSeguroConfig::getCredentials());
    $_SESSION[PagSeguroSession::SESSION_ID] = $pagsession->executeService();
    echo $_SESSION[PagSeguroSession::SESSION_ID];

});

$app->get('/credit',function(){
    Sender::checkSenderExist();
    $page = new PageBuilder();

    $page->draw('credito-payment');
});
$app->post('/credit/transaction',function()use ($app){
    Sender::checkSenderExist();
    $data = [
        'paymentMode'=>'default',
        'paymentMethod'=>'creditCard',
        'receiverEmail'=>'maicon-s-a@hotmail.com',
        'currency'=>'BRL',
        'extraAmount'=>'0.00',
        'itemId1'=>'0001',
        'itemDescription1'=>'Notebook Prata',
        'itemAmount1'=>'500.00',
        'itemQuantity1'=>'1',
        'notificationURL'=> 'https://sualoja.com.br/notifica.html',
        'reference'=>'REF1234',
        'noInterestInstallmentQuantity' => 3,

        'shippingAddressRequired' => 'true',
        'shippingType'=>'3',
        'shippingCost'=>'0.00'

    ];
    foreach ($_POST as $key => $value){
        if($key == 'creditCardHolderBirthDate'){
            $date = new DateTime($value);
            $data[$key] = $date->format('d/m/Y');
        }else{
            $data[$key] = $value;
        }

    }

    $sender = Sender::getSenderFromSession();

    $senderData = $sender->getData();
    $address = $sender->getAddress();

    $shippingData = $address->getData(\App\model\Address::SHIPPING);
    $billingData = $address->getData(\App\model\Address::BILlING);

    $data = $data + $senderData + $shippingData  + $billingData;

    $transaction = new PagSeguroTransaction(PagSeguroConfig::getCredentials());
     $response = $transaction->executeService($data);
    var_dump($response);
});

$app->get('/debit',function(){
    Sender::checkSenderExist();
    $page = new PageBuilder();
    $page->draw('debito-payment');
});




$app->run();





