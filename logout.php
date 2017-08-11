<?php
session_start();
//выход из регистрации
unset ($_SESSION['reg_success']);
//выход из авторизации
unset ($_SESSION['login']);
unset ($_SESSION['password']);
unset ($_SESSION["name"]);
unset ($_SESSION["family"]);
session_destroy();
header("Location: " . $_SERVER['HTTP_REFERER']);