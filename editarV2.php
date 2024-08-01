<?php
include('conexion/conexion.php');
$con= connection();

//$consumo_importe= $_POST['consumo_importe'];
//$consumo_anterior=$_POST['consumo_anterior'];
//$consumo_saldo_actual=$_POST['consumo_saldo_actual'];

$consumo = $_POST['id_consumo'];

print_r($_POST);

$i=0;

foreach($_POST['id_consumo']){
    
    $consumo_importe= $_POST['saldo_importe'][$i];
    $consumo_anterior=$_POST['saldo_anterior'][$i];
    $consumo_saldo_actual=$_POST['saldo_actual'][$i];
    $i++;
    $sql="UPDATE  mtConsumoGasolinaPrueba SET consumo_importe='$consumo_importe',consumo_anterior='$consumo_anterior',consumo_saldo_actual='$consumo_saldo_actual'
    WHERE id_consumo='$consumo'";
    $query= mysqli_query($con, $sql);
}

//$tarjeta_saldo =$_POST['tar_saldo_actual'];
//$id_equipo_transporte=$_POST['id_equipo_transporte'];
//$sql="UPDATE  mtTarjetaPrueba SET tar_saldo_actual='$tarjeta_saldo'
//WHERE id_equipo_transporte='$id_equipo_transporte'";
//$query= mysqli_query($con, $sql);

?>