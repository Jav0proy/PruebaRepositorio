<?php

function connection(){
$server = "sabd.corprama.com.mx";
$nom_base = "auxiliares";
$usuario = "sistemasses";
$password = "2021.Pr0dS3rvs";

$connect = mysqli_connect($server,$usuario,$password);

    mysqli_select_db($connect,$nom_base);
    return $connect;  
};
?>