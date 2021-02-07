<?php
session_start();
//выход из регистрации
unset ($_SESSION['reg_success']);
//выход из авторизации
unset ($_SESSION['login']);
unset ($_SESSION['password']);
unset ($_SESSION["name"]);
unset ($_SESSION["family"]);
unset ($_SESSION["name_ya"]);
unset ($_SESSION["login_ya"]);
unset ($_SESSION["email_ya"]);
unset ($_SESSION["avatar_id"]);
unset ($_SESSION["avatar_empty"]);
session_destroy();
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;