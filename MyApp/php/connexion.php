<?php
    include_once "pdo_agile.php";
   

    $db_username = "root";
    $db_password = "";
    $db = "mysql:host=localhost;dbname=maliste;charset=UTF8";
    

    $conn = OuvrirConnexionPDO($db, $db_username, $db_password);
    define("CONN", $conn);
?>
