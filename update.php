<?php
include('conexion/conexion.php');
$con= connection();

//Se crean las variables y se traen los datos por medio del metedo $_GET.
$consumo=$_GET['id_consumo'];
$ticket=$_GET['consumo_no_ticket'];
$consumo_anterior=$_GET['consumo_saldo_anterior'];
$consumo_importe=$_GET['consumo_importe'];
$consumo_saldo_actual=$_GET['consumo_saldo_actual'];
$num_placa=$_GET['eqtrans_placa'];

$sql="SELECT a.id_consumo,t.eqtrans_placa,a.consumo_saldo_anterior,a.consumo_importe,a.consumo_no_ticket
from mtConsumoGasolinaPrueba as a
inner join mtEquipoTransportePrueba as t
on a.id_equipo_transporte=t.id_equipo_transporte
WHERE a.id_consumo='$consumo'";

//Query para traer y mostrar los datos de la base de datos,tal cual el nombre de los campos que la base, lo hacemos con la pk de id_consumo
$query= mysqli_query($con, $sql);
$row= mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Actualizar información</title>
</head>
<body>
<div class="container">
        <?php
        $con= connection();
        
        $equipo=$_GET['id_equipo_transporte'];
        $equipo_transporte=$_POST['id_equipo_transporte'];
        $ticket=$_GET['consumo_no_ticket'];
        $consumo_anterior=$_GET['consumo_saldo_anterior'];
        $consumo_importe=$_GET['consumo_importe'];
        $consumo_saldo_actual=$_GET['consumo_saldo_actual'];
        $num_placa=$_GET['eqtrans_placa'];
        $hora=$_GET['consumo_hora_reg'];
        $consumo=$_GET['id_consumo'];
        
        #Detalle de consumo
        $sql="SELECT id_equipo_transporte,consumo_no_ticket,consumo_saldo_anterior,consumo_importe,consumo_saldo_actual,id_consumo
        FROM mtConsumoGasolinaPrueba
        where id_consumo= '$consumo'";
       
                //Query para mostrar todos los campos que queremos deacuerdo a la busqueda inicial, la busqueda se hace por num de placa. y se mandara por medio del id_consumo
            $query= mysqli_query($con, $sql);
            $totalRegistros = mysqli_num_rows($query);

            if($totalRegistros == 0  ){
                echo "No hay registros";        
            }else{

                $row= mysqli_fetch_assoc($query);
               // echo " <h4>Total registros encontrados : $totalRegistros de placa : $num_placa </h4>";
        ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
            <form action="editar.php" method="POST"> 
        <h2>Consumos Registrados</h2>
        <table class="tabla">
            <thead>
                <tr>
                    <!--<th>Placa</th>-->
                    <th>Id Consumo </th>
                    <th>Consumo saldo anterior </th>
                    <th>Consumo Importe </th>
                    <th>Consumo Saldo actual </th>
                    <!--<th>Consumo Hora </th>-->
                    <th></th>
                </tr>
            </thead>
            <tbody class="contenido">
                <tr>
                <th>
                    <input name="consumo" type="text" readonly value="<?php echo $row['id_consumo'] ?>"></th>
                <!--<th><input name="placa" type="text" value="<?php echo $row['eqtrans_placa'] ?>" ></th>-->
                <th><input name="consumo_anterior" type="text" readonly value="<?php echo $row['consumo_saldo_anterior'] ?>"></th>
                <th><input name="consumo_importe" type="text" id="consumoimporte" value="<?php echo $row['consumo_importe'] ?>"></th>
                <th><input name="consumo_saldo_actual" type="text" readonly value="<?php if($row['consumo_saldo_actual']=== null)
                    echo "0.00";
                else 
                echo $row['consumo_saldo_actual'] ?>"></th>
                <th>
                    <input type="hidden" name="consumo" value="<?php echo $row['id_consumo']?>">
                    <input class="form-control" type="submit" onclick="location.reload()" value="Guardar">
                    <!--<a href="editar.php?id_consumo=<?php echo $row['id_consumo'] ?>">Guardar</a></th>-->
                </tr>
            </tbody>
        </table>
    </div>
    </form>
    <?php } 
     $equipo=$_GET['id_equipo_transporte'];
    $sql="SELECT id_equipo_transporte,consumo_no_ticket,consumo_saldo_anterior,consumo_importe,consumo_saldo_actual,id_consumo
    FROM mtConsumoGasolinaPrueba
    where id_consumo >= '$consumo'
    and id_equipo_transporte = '$equipo'
    order by id_consumo";

    $query= mysqli_query($con, $sql);
    $totalRegistros = mysqli_num_rows($query);

    if($totalRegistros == 0  ){
        echo "No hay registros";        
    }else{
    ?>
    <div>Detalle de consumos anteriores</div>
    <div class="container">
        <form action="editar.php" method="POST">
        <table class="tabla">
            <thead>
                <tr>
                    <!--<th>Placa</th>-->
                    <th>Id Consumo </th>
                    <th>Consumo saldo anterior </th>
                    <th>Consumo Importe </th>
                    <th>Consumo Saldo actual </th>
                    <!--<th>Consumo Hora </th>-->
                    <th></th>
                </tr>
            </thead>
            <tbody class="contenido">
                <tr><?php while($row= mysqli_fetch_array($query)):?>
                <th><input name="consumo" type="text" readonly value="<?php echo $row['id_consumo'] ?>"></th>
                <!--<th><input name="placa" type="text" value="<?php echo $row['eqtrans_placa'] ?>" ></th>-->
                <th><input name="consumo_anterior" readonly type="text" id="consumo_anterior" value="<?php echo $row['consumo_saldo_anterior'] ?>"></th>
                <th><input name="consumo_importe" type="text" id="consumo_importe" value="<?php echo $row['consumo_importe'] ?>"></th>
                <th><input name="consumo_actual" type="text" readonly id="consumo_actual" value="<?php if($row['consumo_saldo_actual']=== null)
                    echo "0.00";
                else
                echo $row['consumo_saldo_actual']?>"></th>
                <!--<th> <a href="editar.php?id_consumo=<?php echo $row['id_consumo'] ?>">Guardar</a></th>-->
                </tr>
                <tr>
                <?php 
                for($i=0; $i < count($row); $i++){
                 // echo $row[$i].'<br/>';
                }
               // foreach ($row as $valor){
               //     echo $valor.'<br/>';
               // }
                $consumo_saldo_actual = $row['consumo_saldo_actual'];
                $consumo_saldo_anterior = $row['consumo_saldo_anterior'];
                $importeActualizadoActual =$row['consumo_saldo_anterior']-$row['consumo_importe'];
                $recargo0= 0;
                $recargo1= $consumo_saldo_actual-$importeAnterior;

                $importeAnterior =$row['consumo_saldo_anterior'] + $recargo;
                $cosumoImporte=$row['consumo_importe'];

                //$recargo2="";
                echo" ConsumoActual0Anterior: $consumo_saldo_actual <br>";
                echo "ConsumoActualActualizado: $importeActualizadoActual <br>";
                //echo "recargo"
                //echo "nuevoRecargo:$recargo1 <br>";
                echo "nuevoImporteAnterior: $consumo_saldo_anterior<br>";
                //echo "nuevoImporteActualizado: $importeActualizadoActual <br>";

               // for ($i =1; $i <= $row; $i++){
               // } 
                ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <script>
            document.getElementById("importe").addEventListener("change"),calcularConsumo();
            function calcularConsumo(){
                print ;

            }
                    
                        //var consumoAnterior = $("#consumo_anterior").val();
                        //var consumoImporte = $("#consumo_anterior").val();
                        //var consumoActual = $("#consumo_actual").val();
                       // var recargo1 =$("#consumo_anterior"-"#consumo_actual").val() ;
        </script>
    </div>
    </form>
    <?php } ?>
</div>
</body>
</html>