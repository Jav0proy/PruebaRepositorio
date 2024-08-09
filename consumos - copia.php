<?php
include('conexion/conexion.php'); //Se conecta a la base de datos, que esta en la carpeta de conexion y en el archivo de conexion.php.


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Consumos</title>
</head>
<body>
    <div class="container" style="display: block;">
        <form action="index.php" method="POST" class="#">
        </form> 
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
        $id_consumo=$_GET['id_consumo'];

        $sql="SELECT a.id_equipo_transporte,a.consumo_no_ticket,a.consumo_saldo_anterior,a.consumo_importe,a.consumo_saldo_actual,a.id_consumo,t.eqtrans_placa
        FROM mtConsumoGasolinaPrueba a
        inner join mtEquipoTransportePrueba as t
            on a.id_equipo_transporte=t.id_equipo_transporte
        where a.id_equipo_transporte= '$equipo'
        order by a.id_consumo";

                //Query para mostrar todos los campos que queremos deacuerdo a la busqueda inicial, la busqueda se hace por num de placa. y se mandara por medio del id_consumo
            $query= mysqli_query($con, $sql);
            $totalRegistros = mysqli_num_rows($query);
            if($totalRegistros == 0  ){
                // echo "No hay registros";
                
            }else{
                 //echo " <h4> Placa : $num_placa </h4>";
            }
        ?>
        <div class="container" id="" style=" 'display: block;' ">
        <?php echo "<h2> Consumos Registrados De La Placa: ' $num_placa '</h2> "?>
        <div>
        <table class="table">
                <tr>
                    <!-- <th>Placa</th> -->
                    <th>Id Consumo</th>
                    <th>Consumo no Ticket </th>
                    <th>Consumo saldo anterior </th>
                    <th>Consumo Importe </th> 
                    <th>Consumo Saldo actual </th>
                    <th></th>
                    
                </tr>
                <tr>
                <?php while($row= mysqli_fetch_array($query)):?>
                <!--<th><?php echo $row['eqtrans_placa'] ?> </th>-->
                <th><?php echo $row['id_consumo'] ?> </th>
                <th><?php echo $row['consumo_no_ticket'] ?> </th>
                <th><?php echo $row['consumo_saldo_anterior'] ?> </th>
                <th><?php echo $row['consumo_importe'] ?> </th> 
                <th><?php if($row['consumo_saldo_actual']=== null)
                    echo "0.00";
                else
                echo $row['consumo_saldo_actual'] ?> </th>
                <th></th>
                <th> <a href="update.php?id_consumo=<?php echo $row['id_consumo'] ?>&id_equipo_transporte=<?php echo $row['id_equipo_transporte'] ?> "> Editar </a></th>
                </tr>
                <?php endwhile; ?> 
        </table>
        </div> 
    </div>
</body>
</html>