<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 07/08/2019
 * Time: 09:01
 */

namespace App\pagseguro;


abstract class PagSeguroModel
{
    const SENDER_PREFIX  = 'sender';

    const ITEM_PREFIX = 'item';

    const SHIPPING_PREFIX = 'shippingAddress';

    const  BILLING_PREFIX = 'billingAddress';

    abstract public function getData($useful = null):array ;
}