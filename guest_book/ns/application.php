<?php
namespace Ns;

Class Application{

//ctrs
    function Emul__Ctr_Add(){
        $data = $_POST;
        //$data = $_GET;
        //print_r($data);
        //exit();
        //checks
            //name
        $err = [];
        if($this->check__Str_Name(@$data['name']) === true){
            $data['name'] = $this->guard__Str($data['name']);
        }else{ $err['name'] = true; }
            //email
        if($this->check__Str_Email(@$data['email']) === true){
            $data['email'] = $this->guard__Str($data['email']);
        }else{ $err['email'] = true; }
            //comment
        if($this->check__Str_Comment(@$data['comment']) === true){
            $data['comment'] = $this->guard__Str($data['comment']);
        }else{ $err['comment'] = true; }

        foreach ($err as $k=>$v){
            if($v === true){
                return false;
            }
        }
        //save
        $db = new \Ns\Database();
        try{
            $stmt = $db->execute(
                "INSERT INTO comments (name,email,msg) VALUES (?,?,?)",
                [$data['name'],$data['email'],$data['comment']],true);
            if($stmt){
                //tmp
                $data['id'] = $stmt;
                //tmp END
                return [
                    'status' => true,
                    'body' => $data
                ];
            }
        }catch(\PDOException $e){ return false; }
        return false;
    }

    function Emul__Ctr_Delete(){
        //print_r('delete');
        $data = $_POST;
        $answer = false;
        if(@isset( $data['id'] )){
            if( (int) $data['id'] > 0){
                $db = new \Ns\Database();
                $stmt = $db->execute(
                    "DELETE FROM comments WHERE `id` = {$data['id']}"
                );
                if($stmt){
                    $answer = [
                        'status' => true,
                        'body' => ''
                    ];
                }
            }
        }
        return $answer;
    }

    function Emul__Ctr_Update(){
        $db = new \Ns\Database();
        $stmt = $db->execute(
            "UPDATE comments_two SET status='1', updated_at = ".time()." WHERE id = 1"
        );
        print_r('Result: '.$stmt);
    }

    //model emul
    function getData__All(){
        $db = new \Ns\Database();
        return $db->query("SELECT * FROM `comments` ORDER BY `id` DESC");
    }

//service
    //guard
    public function guard__Str($str = null){
        if($str != null){
            $str = trim($str); //устраняем пробелы из начала и конца строки пробелами
            //$str = strip_tags($str); //strip_tags - Удаляет HTML и PHP-теги из строки
            $str = htmlspecialchars($str); //преобразуем специальные символы в HTML-сущности
                //<a href='url'>Test</a>  = &lt;a href=&#039;url&#039;&gt;Test&lt;/a&gt;
            return $str;
        }
        return false;
    }

    //check
    public function check__Str_Comment($str = null){
        if($str != null){
            if( mb_strlen( trim( $str ) ) > 2 ){ return true; }
        }
        return false;
    }

    public function check__Str_Email($str = null){
        if($str != null){
            $str = trim($str);
            if(mb_strlen($str) >= 7 && mb_strlen($str) <= 128){
                if(filter_var($str, FILTER_VALIDATE_EMAIL)){
                    return true;
                }
            }
        }
        return false;
    }

    public function check__Str_Name($str = null){
        if($str != null){
            $result = preg_match('/^[a-zа-яёА-ЯЁ\s\-]{3,20}+$/ui', trim($str),$arr);
            if((int) $result > 0){return true;}
        }
        return false;
    }

    //ajax
    function Check__Ajax(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }
       return false;
    }

    //header
    public function setHeader($code = false){
        if($code != false){
            switch ($code){
                case 404 :
                    header("HTTP/1.1 404 Not Found");
                    exit('Здесь ничего нет');
                    break;
                case 403 :
                    header('HTTP/1.0 403 Forbidden');
                    exit('Ошибка доступа');
                    break;
                default : break;
            }
        }
    }

}