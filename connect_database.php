<?php

$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';


try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8");
} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
