<?php
/**
 * 
 * Author: Maicon Alcântara
 * Date: 07/08/2019
 * Time: 10:02
 */

namespace App;
use App\pagseguro\PagSeguroModel;

 interface Sessionable
{
    public function setToSession();

    public static function getFromSession() ;

    public static function checkExistInSession();

    public static function removeFromSession();


}
