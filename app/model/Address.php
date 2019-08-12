<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 02/08/2019
 * Time: 01:21
 */
namespace App\model;

use App\pagseguro\PagSeguroModel;

class Address
{

    const SHIPPING_TYPE = 0;

    const BILLING_TYPE = 1;

    const  PERSONAL_TYPE  = 2;

    private  $street;

    private $number;

    private  $complement;

    private $district;

    private $postalCode;

    private $city;

    private  $state;

    private $country;

    private $type;

    /**
     * @return mixed
     */
    public function getType():int
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }

    /**
     * Address constructor.
     * @param $street
     * @param $number
     * @param $complement
     * @param $district
     * @param $postalCode
     * @param $city
     * @param $state
     * @param $country
     */
    public function __construct($street = null, $number = null, $complement = null, $district = null, $postalCode = null, $city = null, $state = null, $country = 'BRA')
    {
        $this->street = $street;
        $this->number = $number;
        $this->complement = $complement;
        $this->district = $district;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @param mixed $complement
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
    }

    /**
     * @return mixed
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param mixed $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


    public function getDataPagSeguro($useful = null):array{
        switch ($this->getType()){
            case Address::SHIPPING_TYPE:
                $prefix = PagSeguroModel::SHIPPING_PREFIX;
                break;
            case Address::BILLING_TYPE:
                $prefix = PagSeguroModel::BILLING_PREFIX;
                break;
            default:
                $prefix = "";
        }
        $dataArray = [
            $prefix.'Street' => $this->getStreet(),
            $prefix.'Number' => $this->getNumber(),
            $prefix.'Complement' =>$this->getComplement(),
            $prefix.'District' =>$this->getDistrict(),
            $prefix.'PostalCode' =>$this->getPostalCode(),
            $prefix.'City' =>$this->getCity(),
            $prefix.'State' =>$this->getState(),
            $prefix.'Country' =>$this->getCountry()

        ];

        return $dataArray;
    }



}