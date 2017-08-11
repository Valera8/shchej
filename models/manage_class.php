<?php
require_once "database_class.php";
//require_once "config_class.php";
class Manage {
    private $db;
    public function __construct($db) {
        $this->db = new DataBase();
    }
    /*Зная username получить поле userID в таблице*/
    public function getId($login)
    {
        return $this->db->getField('users', "userID", "username", $login);
    }
    /*Зная username получить поле email в таблице*/
    public function getEmail($login)
    {
        return $this->db->getField('users', "email", "username", $login);
    }
    /*Зная username получить поле photo в таблице*/
    public function getPhoto($login)
    {
        return $this->db->getField('users', "photo", "username", $login);
    }
    /*Зная username получить поле family в таблице*/
    public function getFamily($login)
    {
        return $this->db->getField('users', "family", "username", $login);
    }
    /*Зная username получить поле name в таблице*/
    public function getName($login)
    {
        return $this->db->getField('users', "name", "username", $login);
    }
    /*Зная id получить поле email в таблице comments*/
    public function getEmailReply($id)
    {
        return $this->db->getFieldId ('comments', "email", "id", $id);
    }
    /*Зная id получить поле name в таблице comments*/
    public function getNameReply($id)
    {
        return $this->db->getFieldId ('comments', "name", "id", $id);
    }
    /*Проверить на существование логина в таб. rche_users*/
    public function isExistsUser($login)
    {
        return $this->isExist("username", $login);
    }
    /*Проверить на существование email в таб. rche_users*/
    public function isExistsEmail($email)
    {
        return $this->isExist("email", $email);
    }
    /*По некоему полю проверить существует ли значение данного поля в таблице users*/
    private function isExist($field, $value)
    {
        return $this->db->isExists('users', $field, $value);
    }
}