<?php
try {
    $username = 'root';
    $password = '';
    $host = 'localhost';
    $dbname = 'mangement_stu';
    $connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $username, $password);
} catch (Exception $e) {
    echo $e->getMessage();
}
