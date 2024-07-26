<?php
include('conexion/conexion.php');
$con= connection();

$consumo= $_POST['consumo'];
$consumo_importe= $_POST['consumo_importe'];
$consumo_anterior=$_POST['consumo_anterior'];
$consumo_saldo_actual=$_POST['consumo_saldo_actual'];

echo $sql="UPDATE  mtConsumoGasolinaPrueba SET consumo_importe='$consumo_importe'
WHERE id_consumo='$consumo'";

$query= mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Editar</title>
</head>
<body>
    <h1>Datos Actualizados</h1>
    <form action="#" method="POST">

    </form>
</body> 
</html>