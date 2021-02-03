<?php
require_once "config_class.php";
/*Класс для базы данных*/
class DataBase
{
    private $config;
    public $mysqli;/*идентификатор соединения*/
    public function __construct ()
    {
        $this->config = new Config();
    /*и подключаемся к базе данных*/
        $this->mysqli = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->db);
        $this->mysqli->query("SET NAMES 'utf8'");
    }
/*Функция отправляет запросы и возвращает ответы*/
    private function query ($query)
    {
        return $this->mysqli->query ($query);
    }
/*Выборка--$fields-список полей, который нужно извлечь в таблице с икрементом по умолчанию $id = 'userID'*/
    public function select ($table_name, $fields, $where = "", $order = "", $up = true, $limit = "", $id = 'userID')
    {
    /*составляем запрос. Перебираем все поля*/
        for ($i = 0; $i < count($fields); $i++)
        {
        /*При условии, что это не является скобочками, не является звездочкой (все поля) тогда заменяем $fields на `$fields` */
            if ((strpos($fields[$i], "(") === false) && ($fields[$i] != "*")) $fields[$i] = "`" . $fields[$i] . "`";
        }
    /*Превращаем этот массив в строку*/
        $fields = implode(",", $fields);
    /*создаем имя таблицы*/
        $table_name = $this->config->db_prefix . $table_name;
    /*Если сортировка не задана, сортируем по $id ---!!!!*/
        if (!$order) $order = "ORDER BY `$id`";
        else
        {
            if ($order != "RAND()")
            {
                $order = "ORDER BY `$order`";
                if (!$up) $order .= " DESC";
            }
            /*Если требуются случайные записи:*/
            else $order = "ORDER BY $order";
        }
        if ($limit) $limit = "LIMIT $limit";
        /*Если префикс указан, то запрос такой:*/
        if ($where) $query = "SELECT $fields FROM $table_name WHERE $where $order $limit";
        else $query = "SELECT $fields FROM $table_name $order $limit";
        $result_set = $this->query($query);
        if (!$result_set) return false;
        /*Этот запрос преобразовать в двумерный массив*/
        $i = 0;
        while ($row = $result_set->fetch_assoc())
        {
            $data[$i] = $row;
            $i++;
        }
        $result_set->close();
        return $data; /*Вместо $result_set возвращаем двумерный массив, т.к. с ним проще работать*/
    }
/*Добавлять записи*/
    public function insert ($table_name, $new_values)
    {
        $table_name = $this->config->db_prefix . $table_name;
        $query = "INSERT INTO $table_name (";
        foreach ($new_values as $field => $value) $query .= "`" . $field . "`,";
        $query = substr($query, 0, -1); /*Обрезать последнюю запятую*/
        $query .= ") VALUES (";
        foreach ($new_values as $value) $query .= "'" . addslashes($value) . "',";
        $query = substr($query, 0, -1);
        $query .= ")";
        return $this->query($query);
    }
    /*Добавлять юзеров в таблицу _users*/
    public function regUser($family, $name, $login, $email, $password, $photo)
    {
        $new_values = ['family'=> $family, 'name' => $name, 'username' => $login, 'email' => $email, 'password' => $password, 'photo' => $photo];
        $result = $this->insert('users', $new_values );
        return $result == true;
    }
    /*Проверка логина и пароля*/
    public function checkUser ($login, $password)
    {
        if (($login == "") || ($password == ""))
        {
            return false;
        }
        $result_set = $this->mysqli->query("SELECT password FROM rch_users WHERE username = '$login'");
        $user = $result_set->fetch_assoc();
        $real_pass = $user['password'];
        return $real_pass == $password;
    }
    //  Проверка логина на существование в БД
    public function checkLogin ($login)
    {
        $login = $this->mysqli->real_escape_string(trim($_POST['login']));
        $res = $this->mysqli->query("SELECT username FROM rch_users WHERE username = '$login'");
        $row = $res->fetch_assoc();
        $real_log = $row['username'];
        return $real_log == $login;
    }
    //  Проверка email на существование в БД
    public function checkEmail ($email)
    {
        $email = $this->mysqli->real_escape_string(trim($_POST['email']));
        $res = $this->mysqli->query("SELECT `email` FROM `rch_users` WHERE `email` = '$email'");
        $row = $res->fetch_assoc();
        $real_email = $row['email'];
        return $real_email == $email;
    }
    //  Проверка логина на корректность
    public function validLogin ($login) {
        if ($this->isContainQuotes($login)) return false;
        /*Проверяем наличие хотя бы одной буквы*/
        if (preg_match("/^\d*S/", $login)) return false;
        return true;
    }
    /*Проверяет на наличие в строке кавычек*/
    private function isContainQuotes($string)
    {
        $array = array("\"", "'", "`", "quot;", "&apos;");
        foreach ($array as $key => $value)
        {
            if (strpos($string, $value) !== false) return true;
        }
        return false;
    }
    //  Проверка email на корректность
    public function validEmail ($email) {
        if ($this->isContainQuotes($email)) return false;
        return true;
    }
    /*Проверить на корректность*/
    public function validText($string)
    {
        return $this->validString($string, $this->config->min_text, $this->config->max_text);
    }
    /*Проверка на валидность строки*/
    private function validString($string, $min_length, $max_length)
    {
        if (!is_string($string)) return false;
        if (strlen($string) < $min_length) return false;
        if (strlen($string) > $max_length) return false;
        return true;
    }
    private function isIntNumber ($number)
    {
        if (!is_int($number) && !is_string($number)) return false;
        if (!preg_match("/^-?(([1-9][0-9]*|0))$/", $number)) return false;
        return true;
    }
    /*Проверка на неотрицательность числа*/
    public function isNoNegativeInteger($number)
    {
        if (!$this->isIntNumber($number)) return false;
        if ($number < 0) return false;
        return true;
    }
/*Обновление записей. $upd_fields - поля, которые обновляем и $where - предикат условия, по которому обновляем*/
//    private function update($table_name, $upd_fields, $where)
//    {
//        $table_name = $this->config->db_prefix . $table_name;
//        $query = "UPDATE $table_name SET";
//        foreach ($upd_fields as $field => $value) $query .= "`$field` = '" . addslashes($value) . "',";
//       $query = substr($query, 0, -1);
//        if ($where)
//        {
//            $query .= " WHERE $where";
//            return $this->query($query);
//        }
//        else return false;
//    }
///*Удаление записи по определенному условию*/
//    public function delete ($table_name, $where = "")
//    {
//        $table_name = $this->config->db_prefix . $table_name;
//        if ($where)
//        {
//            $query = "DELETE FROM $table_name WHERE$where";
//        }
//        else return false;
//    }
///*Очищение таблицы*/
//    public function deleteAll ($table_name)
//    {
//        $table_name = $this->config->db_prefix . $table_name;
//        $query = "TRUNCATE TABLE `$table_name`";
//    }
/*Возвращать значение поля по заданному значению другого поля в этой же таблице $field_out - поле вернуть, $field_in - поле известно, $value_in - значение этого поля, с икрементом userID*/
    public function getField ($table_name, $field_out, $field_in, $value_in)
    {
    /*Это поле должно быть уникальным*/
        $data = $this->select ($table_name, array($field_out), "`$field_in` = '" . addslashes($value_in) . "'", $id = 'userID'); /* "`$field_in` = '" . addslashes($value_in) . "'" - это WHERE. $data - двумерный массив со всеми данными*/
        if (count($data) != 1) return false;
        return $data[0][$field_out];
    }
    /*Возвращать значение поля по заданному значению другого поля в этой же таблице $field_out - поле вернуть, $field_in - поле известно, $value_in - значение этого поля, с икрементом id*/
    public function getFieldId ($table_name, $field_out, $field_in, $value_in)
    {
        /*Это поле должно быть уникальным*/
        $data = $this->select ($table_name, array($field_out), "`$field_in` = '" . addslashes($value_in) . "'", $id = 'id'); /* "`$field_in` = '" . addslashes($value_in) . "'" - это WHERE. $data - двумерный массив со всеми данными*/
        if (count($data) != 1) return false;
        return $data[0][$field_out];
    }
/* Получение поля, зная id*/
    public function getFieldOnID ($table_name, $id, $field_out)
    {
    /*Существует ли данное id в данной таблице*/
        if (!$this->existsID ($table_name, $id))
        {
            return false;
        }
        return $this->getField($table_name, $field_out, "id", $id);
    }
/*Получает все записи по определенному полю*/
    public function getAllOnField($table_name, $field, $value, $order, $up)
    {
        return $this->select($table_name, array("*"), "`$field` = '" . addslashes($value) . "'", $order, $up);
    }
/*Получение всех записей из таблицы*/
    public function getAll($table_name, $order, $up)
    {
        return$this->select($table_name, array("*"), "", $order, $up);
    }
/*Возвращать запись целиком по id*/
    public function getElementOnID ($table_name, $id)
    {
        if (!$this->existsID ($table_name, $id))
        {
            return false;
        }
        $arr = $this->select($table_name, array("*"), "`id` = '$id'");
        return $arr[0];
    }
/*Проверка на существование определенной записи в некоторой таблице c икрементом userID*/
    public function isExists ($table_name, $field, $value)
    {
        $data = $this->select($table_name, array("userID"), "`$field` = '" . addslashes($value) . "'");
        if (count($data) === 0) return false;
        return true;
    }

    private function existsID ($table_name, $id)
    {
        if (!$this->valid->validID($id)) return false;
        /*Получаем запись*/
        $data = $this->select($table_name, array("id"), "`id` = '" . addslashes($id) . "'");
        if (count($data) === 0) return false;
        return true;
    }

/*Удалить запись по id*/
//    public function deleteOnID ($table_name, $id)
//    {
//        if (!$this->existsID ($table_name, $id))
//        {
//            return false;
//        }
//        return $this->delete($table_name, "`id` = '$id");
//    }
///*Изменить значение определенного поля*/
//    public function setField ($table_name, $field, $value, $field_in, $value_in) /*Поле изменить $field*/
//    {
//        return $this->update($table_name, array($field => $value), "`$field_in` = '" . addslashes($value_in) . "' ");
//    }
///*То же по id*/
//    public function setFieldOnID ($table_name, $id, $field, $value)
//    {
//        if (!$this->existsID ($table_name, $id))
//        {
//            return false;
//        }
//        return $this->setField($table_name, $field, $value, "id", $id);
//    }
/*Возвращать случайные записи в определенном количестве*/
//    public function getRandomElements ($table_name, $count)
//    {
//        return $this->select($table_name, array("*"), "", "RAND()", true, $count);
//    }
///*Узнать количество записей в таблице c икрементом id*/
//    public function getCount ($table_name)
//    {
//        $data = $this->select($table_name, array("COUNT(`id`)"));
//        return $data[0]["COUNT(`id`)"];
//    }
/*Последний (максимальный) ID в таблице c икрементом id
    public function getId ($table_name)
    {
        $data = $this->select($table_name, array("id"), $id = 'id');
        $last = array_pop($data);
        return $last["id"];
    } */
    public function getLastID ($table_name)
    {
        $data = $this->select($table_name, array("MAX(`id`)"), $order = "id", $id = 'id');
        return $data[0]["MAX(`id`)"];
    }
///*Максимальное значение у заданного поля в заданной табилице*/
//    public function getMax ($table_name, $field)
//    {
//        $data = $this->select($table_name, array($field));
//        $max = max ($data);
//        return $max["$field"];
//    }
/*Поиск*/
//    public function search($table_name, $words, $fields)
//    {
//        $words = mb_strtolower($words);
//        $words = trim($words);
//        $words = quotemeta($words);
//        if ($words == "") return false;
//        $where = "";
//        $arraywords = explode(" ", $words);
//        $logic = "OR"; /*чтобы было хотя бы одно из слов поиска*/
//        foreach ($arraywords as $key => $value)
//        {
//            if (isset($arraywords[$key - 1])) $where .= $logic;
//            for ($i =0; $i < count($fields); $i++)
//            {
//                $where .= "`" . $fields[$i] . "` LIKE '%" . addslashes($value) . "%'";
//                if (($i + 1) != count($fields)) $where .= " OR";
//            }
//        }
//        $results = $this->select($table_name, array("*"), $where);
//        if (!$results) return false;
//    /*Сделаем релеватность*/
//        $k = 0;
//        $data = array();
//        for ($i =0; $i < count($results); $i++) /*цикл по данным*/
//        {
//            for ($j =0; $j < count($fields); $j++) /*цикл по полям*/
//            {
//                $results[$i][$fields[$j]] = mb_strtolower(strip_tags($results[$i][$fields[$j]]));
//            }
//            $data[$k] = $results[$i];
//            $data[$k]["relevant"] = $this->getRelevantForSearch($results[$i], $fields, $words); /*getRelevantForSearch - Получить релеватные данные для поиска*/
//            $k++;
//        }
//        $data = $this->orderResultSearch($data, "relevant"); /*Сортировка по полю relevant */
//        return $data;
//    }
//
//    private function getRelevantForSearch($result, $fields, $words) /*Количество совпадение в $result по всем полям $fields слова $words*/
//    {
//        $relevant = 0;
//        $arraywords = explode(" ", $words);
//        for ($i =0; $i < count($fields); $i++)
//        {
//            for ($j = 0; $j < count($arraywords); $j++)
//            {
//                $relevant += substr_count($result[$fields[$i]], $arraywords[$j]);
//            }
//        }
//        return $relevant;
//    }
//    private function orderResultSearch($data, $order)
//    {
//        for ($i = 0; $i < count($data) - 1; $i++)
//        {
//            $k = $i;
//            for ($j = $i + 1; $j < count($data); $j++) /*ищем максимальное значение каждой итерации и максимальный элемент перетаскиваем в левую часть*/
//            {
//                if ($data[$j][$order] > $data[$k][$order]) $k = $j;
//            }
//            $temp = $data[$k];
//            $data[$k] = $data[$i];
//            $data[$i] = $temp; /*замена местами*/
//        }
//        return $data;
//    }
        /*Уничтожение объекта*/
    public function __destruct()
    {
        if ($this->mysqli) $this->mysqli->close();
    }
}