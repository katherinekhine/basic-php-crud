<?php
$db = new PDO('mysql:dbhost=localhost;dbname=basic_php_crud', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,

]);

if ($db == false) {
    die('Error: ' . mysqli_connect_error($db));
}
