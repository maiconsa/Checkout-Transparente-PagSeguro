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
        array_push($this->products,$product);
    }

    public  function removeProduct(Product $product){
        unset($this->products[$product]);
    }


    public function getItems(){
        return $this->products;
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
        return  $_SESSION[Cart::CART];
    }

    public static function checkExistInSession()
    {
        return  array_key_exists(Cart::CART,$_SESSION) == true && isset($_SESSION[Cart::CART]) == true;
    }

    public static function removeFromSession()
    {
        unset($_SESSION[Sender::SENDER]);
    }


    public function getData($useful = null): array
    {
        $dataArray = array();
        foreach ($this->products as $key =>$value){
           $dataArray = $dataArray + $this->castingToProduct($value)->getData($key+1);
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
}