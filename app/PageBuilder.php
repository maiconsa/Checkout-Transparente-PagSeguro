<?php

namespace App;

use App\pagseguro\PagSeguroConfig;
use Rain\Tpl;

class PageBuilder extends Tpl
{
    private $useDefaultHeaderFooter = true;

    public function __construct($tpl_dir = 'views/',$cache_dir = 'views_cache/',$debug = false)
    {
        Tpl::configure(['tpl_dir'=>$tpl_dir, 'cache_dir' =>$cache_dir,'debug'=>$debug]);


        if($this->useDefaultHeaderFooter === true){
                $this->draw('header',['stc' => PagSeguroConfig::getSTCUrl()]);
        }
    }
    public function __destruct()
    {
        if($this->useDefaultHeaderFooter === true){
            $this->draw('footer');
        }
    }

    public function setDefaultHeaderFooter($defaults){
        $this->useDefaultHeaderFooter = $defaults;
    }

    public function draw($templateFilePath,$data = [], $toString = FALSE)
    {
        $this->assignData($data);
        return parent::draw($templateFilePath, $toString);
    }

    public function assignData($data)
    {
        foreach ($data as $key => $value){
            parent::assign($key, $value);
        }
    }


}