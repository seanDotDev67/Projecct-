<?php
    $host = "127.0.0.1";
    $port = "3307";
    $db = "marketing_system";
    $usern = "root";
    $pass = "";

    $dsn = "mysql:host=$host;port=$port;dbname=$db";
    try{
        $pdo = new PDO($dsn, $usern, $pass);
       // echo "connected na yahh";
    }catch(PDOException $e){
        die("Database Error: ".$e.getMessage());
    }

?>