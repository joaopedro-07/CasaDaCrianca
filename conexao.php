<?php
    $dbhost="localhost";
    $dbuser="root";
    $dbpassword="";
    $dbname="db_casadacrianca";

    $conn = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname);
    
    if(!$conn){
        die("Falhou a conexão". mysqli_connect_error());
    }
?>