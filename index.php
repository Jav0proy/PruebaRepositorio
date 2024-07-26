<?php
include('conexion/conexion.php'); //Se conecta a la base de datos, que esta en la carpeta de conexion y en el archivo de conexion.php.
//$con= connection();
//$sql="SELECT  * from mtEquipoTransporte";
//$query= mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>BUSCADOR</title>
</head>
<body>

    <h1> Placas Activas </h1>

    <div class="container">
        <form action="index.php" method="POST" class="form1">
            <div class="mb-4">
                Buscar Placa
        <input type="text" class="form-text" id="busca" name="busca" size="30" maxlength="30"> 
        <input type="submit" class="btn btn-primary" name="search" id="search" value="Buscar">
            </div>
        </form> 
        <!-- Formulario para hacer la busqueda por medio del metodo POST-->
        <?php
        if ($_POST['search']){
        // Tomamos el valor ingresado
        $buscar = $_POST['busca'];

        if(empty($buscar)){
            echo "No se ha ingresado una cadena a buscar";
        }else{
            
            $con= connection();
           $sql="SELECT t.eqtrans_placa,a.consumo_saldo_actual,c.cliente_des_oficial,a.id_equipo_transporte,a.consumo_kilometraje_inicial,a.consumo_kilometraje_final
                FROM auxiliares.mtEquipoTransportePrueba as t
                inner join auxiliares.mtConsumoGasolinaPrueba as a
                on a.id_equipo_transporte=t.id_equipo_transporte
						LEFT JOIN tesoreria.gsCat_Cliente c
						on a.id_cliente_cve=c.id_cliente_cve
                 WHERE t.eqtrans_status ='A'
                 AND t.eqtrans_placa like '%$buscar%'
                 GROUP BY t.eqtrans_placa
                 ORDER BY t.eqtrans_placa,c.cliente_des_oficial ";
                
                //Query para mostrar todos los campos que queremos deacuerdo a la busqueda inicial, la busqueda se hace por num de placa. y se mandara por medio del id_consumo
            $query= mysqli_query($con, $sql);
            $totalRegistros = mysqli_num_rows($query);

            if($totalRegistros == 0){
                echo "No hay registros";
            }else{
                $row= mysqli_fetch_assoc($query);
                //echo "Total registros encontrados: $totalRegistros de placa: $buscar ";
                ?>
                <?php }
        }
                ?>
                </div>
                <div class="container">
            <div class="row">
            <div class="col-sm-9">
            <form action="consumos.php" method="POST"> 
            <h2>Placas Encontradas</h2>
            <table class="tabla">
            <thead>
                <tr>
                    <th>Placas Activas</th>
                    <th> Id Equipo Transporte</th>
                    <th>Sucursal Asignada</th>
                    <th>Consumo Saldo Actual</th>
                    <th>Kilometraje Inicial</th>
                    <th>Kilometraje Final</th>
                     <th> Ver Consumos </th> 
                </tr>
            </thead>
            <tbody class="contenido">
                <tr>
                <th><?php echo $row['eqtrans_placa'] ?> </th>
                <th><?php echo $row['id_equipo_transporte'] ?> </th>
                <th><?php echo $row['cliente_des_oficial'] ?> </th>
                <th><?php echo $row['consumo_saldo_actual'] ?> </th>
                <th><?php echo $row['consumo_kilometraje_inicial'] ?> </th>
                <th><?php echo $row['consumo_kilometraje_final'] ?> </th>
                <th> <a href="consumos.php?id_equipo_transporte=<?php echo $row['id_equipo_transporte'] ?>">Consumos</a></th>
                </tr>
            </tbody>
        </table>
    </div>
    </form>
    <?php }
    $con= connection();
           $sql="SELECT t.eqtrans_placa,a.consumo_saldo_actual,c.cliente_des_oficial,a.id_equipo_transporte,a.consumo_kilometraje_inicial,a.consumo_kilometraje_final
            FROM auxiliares.mtEquipoTransportePrueba as t
            inner join auxiliares.mtConsumoGasolinaPrueba as a
            on a.id_equipo_transporte=t.id_equipo_transporte
						LEFT JOIN tesoreria.gsCat_Cliente c
						on a.id_cliente_cve=c.id_cliente_cve
            WHERE t.eqtrans_status ='A'
            GROUP BY t.eqtrans_placa
            ORDER BY t.eqtrans_placa,c.cliente_des_oficial ";
            $query= mysqli_query($con, $sql);
            $totalRegistros = mysqli_num_rows($query);

            if($totalRegistros == 0  ){
                echo "No hay registros";        
            }else{
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
        <h2>Informacion Registrada</h2>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Placas Activas</th>
                    <th> Id Equipo Transporte</th>
                    <th>Sucursal Asignada</th>
                    <th>Consumo Saldo Actual</th>
                    <th>Kilometraje Inicial</th>
                    <th>Kilometraje Final</th>
                     <th> Ver Consumos </th> 
                </tr>
            </thead>
            <tbody class="contenido">
                <tr>
                <?php while($row= mysqli_fetch_array($query)):?>
                <th><?php echo $row['eqtrans_placa'] ?> </th>
                <th><?php echo $row['id_equipo_transporte'] ?> </th>
                <th><?php echo $row['cliente_des_oficial'] ?> </th>
                <th><?php echo $row['consumo_saldo_actual'] ?> </th>
                <th><?php echo $row['consumo_kilometraje_inicial'] ?> </th>
                <th><?php echo $row['consumo_kilometraje_final'] ?> </th>
                <th> <a href="consumos.php?id_equipo_transporte=<?php echo $row['id_equipo_transporte'] ?>">Consumos</a></th>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
</body>
</html>