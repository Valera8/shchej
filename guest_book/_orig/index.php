<?php
//errors
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//autoload
spl_autoload_register(function($class){
    $path = dirname(__FILE__)."/".strtolower( str_replace("\\","/",$class) );
    spl_autoload($path);
});
$app = new \Ns\Application();
switch ($_SERVER['REQUEST_URI']){
    case '/' :
        $data = $app->getData__All();
        require_once 'template.php';
        break;
    case '/add':
        if($app->Check__Ajax()){
            exit(json_encode( $app->Emul__Ctr_Add() ));
        }else{ $app->setHeader(403); }
    default:
        $app->setHeader(404);
}



