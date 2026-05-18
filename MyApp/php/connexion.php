<?php 
    include_once "pdo_agile.php";
    echo '<meta charset="utf-8"> ';
        

    $db_username = "root";
    $db_password = ""; //
    $db = "mysql:host=localhost;dbname=maliste;charset=UTF8";
  
  
    $conn = OuvrirConnexionPDO($db,$db_username,$db_password); 
    define("CONN",$conn);


?>