<?php
    define("HOSTNAME","localhost");
    define("USERNAME","root");
    define("PASSWORD","");
    define("DATABASE","marketing_system");

    $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    if(!$conn){
       die("". mysqli_connect_error());
    }else{
    
    }
?>