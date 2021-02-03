<?php

namespace Ns;

Class Database{
    private $link;

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        $config = require_once 'config.php';

        //echo $config['db_name'];
        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];
        try{
            $this->link = new \PDO($dsn, $config['username'], $config['password']);
        }catch(\PDOException $e){
            exit('Не могу соединиться с бд. Хьюстон, у нас пробелемы =(');
        }
        return $this;
    }

    public function execute($sql, $params = null,$getLast = false){
        $sth = $this->link->prepare($sql);
        if(!$getLast){
            return $sth->execute( ( $params != null ) ? $params : NULL );
        }
        $sth->execute( ( $params != null ) ? $params : NULL );
        return $this->link->lastInsertId();
    }

    /* public function execute($sql, $params = null){
        $sth = $this->link->prepare($sql);
        return $sth->execute( ( $params != null ) ? $params : NULL );
    } */

    public function query($sql){
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC );
        if($result === false){
            return [];
        }
        return $result;
    }
}


//$rows = $db->query("SELECT * FROM `comments`");
