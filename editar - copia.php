<?php
include('conexion/conexion.php');
$con= connection();
//$consumo_saldo_actual=$_POST['consumo_saldo_actual'];

$consumo = $_POST['id_consumo'];

//print_r($_POST);

$i=0;
    foreach($_POST['id_consumo'] as $consumos){
        
    $consumo_importe= $_POST['saldo_importe'][$i];
    $consumo_anterior=$_POST['saldo_anterior'][$i];
    $consumo_saldo_actual=$_POST['saldo_actual'][$i];

    //$saldo_actual_tarjeta =$_POST['tar_saldo_actual'][$i];

    $i++;
 
    //$sql= "UPDATE mtConsumoGasolinaPrueba SET 
    //consumo_importe='$consumo_importe',consumo_saldo_anterior='$consumo_anterior',consumo_saldo_actual='$consumo_saldo_actual'
    //WHERE id_consumo='$consumos'";  
    $query= mysqli_query($con, $sql);

    /* 
    UPDATE mtConsumoGasolinaPrueba g
		INNER JOIN mtTarjetaPrueba mt
		on 
		g.id_equipo_transporte=mt.id_equipo_transporte
		SET 
    g.consumo_importe='$consumo_importe',g.consumo_saldo_anterior='$consumo_anterior',g.consumo_saldo_actual='$consumo_saldo_actual',mt.tar_saldo_actual=''
    WHERE id_consumo='$consumos';
    */


    }
?>
<!DOCTYPE html>
<html lang="en"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="0; URL=http://pru-dev.corprama.com.mx/javierjp/Buscar_placa_tarjeta/index.php" />
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <title></title>
</head>
<body>
    <div>
        <!--<h1>Datos Actualizados</h1>-->
    </div>
</body>
</html>