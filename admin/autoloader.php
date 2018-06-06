<?php

function loader($class){
    $filename = $class . ".php";
    $file = '../klase/' . $filename;
    if (!file_exists($file)){
        return false;
    }
    include $file;
}


spl_autoload_register('loader');





?>