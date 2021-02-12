<?php
    spl_autoload_register('AutoLoad');
    function AutoLoad($clase){
        $direccion = "../clases/";
        $ext = ".class.php";
        $direccioncompleta = $direccion . $clase. $ext;
        if(!file_exists($direccioncompleta)){
            return false;
        }
        include_once $direccioncompleta;
    }

?> 