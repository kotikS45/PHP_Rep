<?php
try{
    $dbh = new PDO('mysql:host=localhost:3308;dbname=base2', "root", "");
} catch (PDOException $e) {
    echo $e;
    exit();
}