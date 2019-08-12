<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 07/08/2019
 * Time: 15:46
 */

namespace App\pagseguro;


 class PagSeguroLogs{
    
    public static function save($logid,$content){
        $path = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'logs';
        if(!file_exists($path)){
                mkdir($path,0777,true);
        }
        $path.= DIRECTORY_SEPARATOR.$logid.'.xml';
        $fileHandler = fopen($path,'w+');
        fwrite($fileHandler,$content);
        fclose($fileHandler);

    }

}