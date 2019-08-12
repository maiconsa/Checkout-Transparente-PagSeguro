<?php

require_once ('./vendor/autoload.php');

use  \App\PageBuilder;
use  \App\pagseguro\PagSeguroSession;
use  \App\pagseguro\PagSeguroTransaction;
use  \App\model\Sender;
use  \App\pagseguro\PagSeguroConfig;
use  \App\model\Product;
use \App\model\Cart;

//Inicia a sessão caso estiver habilitada. mas ainda não foi iniciada
if(session_status() === PHP_SESSION_NONE ){
    session_start();
}
PagSeguroConfig::init('YOUR EMAIL,'YOUR TOKEN');
PagSeguroConfig::setMode(true);

$app = new \Slim\Slim();

$app->get('/test',function(){
   
});

$app->get('/',function () use ($app){
    $page = new PageBuilder();
    $page->draw('home',["item-menu" => 0]);

});

$app->get('/payment',function ()use ($app){

        $page = new PageBuilder();
        $page->draw('payment',["item-menu" => 0]);


});

$app->get('/create/sender',function() use($app){
    $page = new PageBuilder();
    $page->draw('personal-information',["item-menu" => 1]);
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

        $sender->setToSession();

        $app->redirect('/create/sender');


});

$app->get('/sender/unregister',function () use ($app){
    Sender::removeFromSession();
    $app->redirect('/');
});

$app->get('/boleto',function() use ($app){

    $page = new PageBuilder();
    $page->draw('bolet-payment');

});

$app->post('/session',function () use ($app){

    $pagsession = new PagSeguroSession(PagSeguroConfig::getCredentials());
    $_SESSION[PagSeguroSession::SESSION_ID] = $pagsession->executeService();
    echo $_SESSION[PagSeguroSession::SESSION_ID];

});

$app->get('/credit',function(){
    $page = new PageBuilder();
    $page->draw('credit-payment');
});


$app->post('/credit/transaction',function()use ($app){

     if(Sender::checkExistInSession() == false){
        $app->redirect("/create/sender");
    }else {
         
        $data = PagSeguroConfig::getDefaults() ;
         foreach ($_POST as $key => $value) {
             if ($key == 'creditCardHolderBirthDate') {
                 $date = new DateTime($value);
                 $data[$key] = $date->format('d/m/Y');
             } else {
                 $data[$key] = $value;
             }
         }
         $sender = Sender::getFromSession();
         $cart = Cart::getFromSession();
         $address = $sender->getAddress();
         $senderData = $sender->getDataPagSeguro();
         $address->setType(\App\model\Address::SHIPPING_TYPE);
         $shippingData = $address->getDataPagSeguro();
         $address->setType(\App\model\Address::BILLING_TYPE);
         $billingData = $address->getDataPagSeguro();

         $itemsData = $cart->getDataPagSeguro();

         $data = $data + $itemsData + $senderData + $shippingData + $billingData;
        
         $transaction = new PagSeguroTransaction(PagSeguroConfig::getCredentials());
         $response = $transaction->executeService($data);
        
    
     }

});

$app->post('/cart/totalAmount',function(){
    echo Cart::getFromSession()->getTotalAmount();

});

$app->get('/debit',function(){
    $page = new PageBuilder();
    $page->draw('debit-payment');
});


$app->get('/cart',function (){
    $data = [];
    if(Cart::checkExistInSession()){
        $cart = Cart::getFromSession();
        $data  = $cart->getData();
    }
 
    $page = new PageBuilder();
    $page->draw('cart',["items" => $data]);
 

});

$app->get('/cart/clear',function() use ($app){ 
    if(Cart::checkExistInSession()){
        $cart = Cart::getFromSession();
        $cart->clear();

        $app->redirect('/cart');
    }
});
$app->get('/cart/add/:id',function ($id) use ($app){

    if(Cart::checkExistInSession()){
        $cart = Cart::getFromSession();
    }else{
        $cart = new Cart();
    }
    switch($id){
        case 1:
        $cart->addProduct(new Product($id,'Xiomi Redmi',500.00 ,1));
        break;
        case 2:
        $cart->addProduct(new Product($id,'Motorola One Vision',1649.00 ,1));
        break;
        case 3:
        $cart->addProduct(new Product($id,'Motorola Moto G7',849.00 ,1));
        break;
    }
 
    $cart->setToSession();

    $app->redirect('/cart');

});



$app->run();




