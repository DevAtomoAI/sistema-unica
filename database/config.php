<?php
    header('Content-Type: text/html; charset=utf-8');

    $dbHost = 'localhost:3306';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'sistema_unica';

    $connectionDB = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
?>