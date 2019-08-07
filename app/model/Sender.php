<?php

namespace App\model;


class Sender
{
    const SENDER = 'SENDER';
    private $name;

    private $cpf;

    private $areaCode;

    private  $phone;

    private $email;

    private  $address;


    /**
     * Sender constructor.
     * @param $name
     * @param $cpf
     * @param $areaCode
     * @param $phone
     * @param $email
     * @param $addres
     */
    public function __construct($name, $cpf, $areaCode, $phone, $email, $address = null)
    {
        $this->name = $name;
        $this->cpf = $cpf;
        $this->areaCode = $areaCode;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * @param mixed $areaCode
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAddress():Address
    {
        return $this->address;
    }

    /**
     * @param mixed $addres
     */
    public function setAddress( Address $address)
    {
        $this->address = $address;
    }


    public function getData(){
        $dataArray = [
            'senderName'=> $this->getName(),
            'senderCPF'=> $this->getCpf(),
            'senderAreaCode'=>$this->getAreaCode(),
            'senderPhone'=> $this->getPhone(),
            'senderEmail' => $this->getEmail()
        ];
        return $dataArray;
    }

    public static function getSenderFromSession():Sender{
        return  $_SESSION[Sender::SENDER];
}

    public static function checkSenderExist(){
       return  array_key_exists(Sender::SENDER,$_SESSION) == true && isset($_SESSION[Sender::SENDER]) == true;



    }




}