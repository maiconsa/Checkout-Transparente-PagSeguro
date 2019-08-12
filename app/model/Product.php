<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 07/08/2019
 * Time: 08:25
 */

namespace App\model;


use App\pagseguro\PagSeguroModel;
use Rain\Tpl\Exception;

class Product extends PagSeguroModel
{
    private $id;

    private $description;

    private $amount;

    private $quantity;

    private $imgUrl;

    /**
     * @return mixed
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * @param mixed $imgUrl
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * Product constructor.
     * @param $description
     * @param $amount
     * @param $quantity
     */
    public function __construct($id,$description, $amount, $quantity)
    {
        $this->id = $id;
        $this->description = $description;
        $this->amount = $amount;
        $this->quantity = $quantity;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
       $f =  number_format($this->amount,2,'.','');
        return $f;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function addQuantity(int $quantity){
        $this->quantity+= $quantity;
    }

    public function getData():array{
        $data = [
            'id' => $this->getId(),
            'description' => $this->getDescription(),
            'amount' => $this->getAmount(),
            'quantity' =>$this->getQuantity()
        ];

        return $data;

    }

    public function getDataPagSeguro($useful = null):array{
        if($useful == null || strlen($useful) == 0){
            throw new Exception("You must pass a useful args as  '1', '2', '3'... -  useful value: $useful");
        }
        $prefix = PagSeguroModel::ITEM_PREFIX;
        $dataArray =[
            $prefix.'Id'.$useful => $this->getId(),
            $prefix.'Description'.$useful => $this->getDescription(),
            $prefix.'Amount'.$useful => $this->getAmount(),
            $prefix.'Quantity'.$useful => $this->getQuantity()
        ];

        return $dataArray;
    }

    public function getTotalAmount():float{
        return $this->getQuantity() * $this->getAmount();
    }


}