<?php
class DataBas
{
    private $link;
    public function __construct($server, $user, $password, $dbName)
    {
        $this->link = mysqli_connect($server, $user, $password, $dbName); // Открывает новое соединение с сервером MySQL и базой данных .
        if (!$this->link)
        {
            die('Ошибка подключения (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
    }

    public function Execute($sql)
    {
    /*запрос к базе данных на добавление записи*/
        mysqli_query($this->link, $sql);
    /* закрываем соединение */
        mysqli_close($this->link);
    }
}