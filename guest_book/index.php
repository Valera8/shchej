<?php
//errors
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//phpinfo();exit();

//autoload
spl_autoload_register(function($class){
    $path = dirname(__FILE__)."/".strtolower( str_replace("\\","/",$class) );
    //print_r($path."<br>");
    spl_autoload($path);
});
$app = new \Ns\Application();

$showGet = false;
if($app->Check__Ajax()){
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $showGet = true;
        exit(json_encode( $app->Emul__Ctr_Add() ));
    }
}
if($showGet){
    exit(json_encode( $app->Emul__Ctr_Add() ));
}else{
    switch ($_SERVER['REQUEST_URI']){
        case '/' :
            $data = $app->getData__All();
            require_once 'template.php';
            break;
        case '/add':
            if($app->Check__Ajax()){
                exit(json_encode( $app->Emul__Ctr_Add() ));
            }else{ $app->setHeader(403); }
        case '/edit':
            $app->Emul__Ctr_Update();
            //просто для примера
            break;
        case '/delete':
            if($app->Check__Ajax()){
                exit(json_encode( $app->Emul__Ctr_Delete() ));
            }else{ $app->setHeader(403); }
        default:
            $app->setHeader(404);
    }
}



