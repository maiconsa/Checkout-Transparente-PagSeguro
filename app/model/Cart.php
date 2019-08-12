<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 07/08/2019
 * Time: 08:44
 */

namespace App\model;


use App\pagseguro\PagSeguroModel;
use App\Sessionable;

class Cart extends PagSeguroModel implements Sessionable
{
    const CART = "CART";

    private $products = [];

    public function addProduct(Product $product){
        $findedProd = $this->searchProduct($product->getId());
        if($findedProd == null){
             array_push($this->products,$product);
        }else{
            $findedProd = $this->castingToProduct($findedProd);
            $findedProd->addQuantity($product->getQuantity());
        }
    }

    public  function removeProduct(Product $product){
        unset($this->products[$product]);
    }


    public function getItems(){
        return $this->products;
    }

    public function getData():array{
        $data = [];
        foreach ($this->products as $object){
            array_push($data,$this->castingToProduct( $object)->getData());
                }
        return $data;
    }

    public function clear(){
        foreach ($this->products as $value){
            unset($value);
        }
        unset($this->products);
        $this->products = [];
    }

    public function setToSession()
    {
       $_SESSION[Cart::CART] = $this;
    }

    public static function getFromSession():Cart
    {   
                return $_SESSION[Cart::CART];
    }

    public static function checkExistInSession():bool
    {
        return  array_key_exists(Cart::CART,$_SESSION) == true && isset($_SESSION[Cart::CART]) == true;
    }

    public static function removeFromSession()
    {
        unset($_SESSION[Sender::SENDER]);
    }

    
    public function getDataPagSeguro($useful = null): array
    {
        $dataArray = array();
        foreach ($this->products as $key =>$value){
           $dataArray = $dataArray + $this->castingToProduct($value)->getDataPagSeguro($key+1);
        };
        return $dataArray;
    }


    public function getTotalAmount(){
        $totalAmount = 0;
        foreach ($this->products as $key =>$value){
            $totalAmount += $this->castingToProduct($value)->getTotalAmount();
        };
        return $totalAmount;
    }

    private function  castingToProduct($object):Product{
        return $object;
    }


    public function searchProduct($id){
        foreach($this->products as $key =>$value){ 
            $product = $this->castingToProduct($value);
            if($id == $product->getId()){
               return $product;
            }         
        };
        return null;
    }

}