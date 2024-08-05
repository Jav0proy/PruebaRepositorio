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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
        <div class="col-sm-9">
            <!--<form action="editar.php" method="POST">-->
            <form action="editar.php" method="POST">
                <h2>Consumos Registrados</h2>
                <table class="tabla" id="tableDatos">
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
                    <tbody class="container">
                        <div class="container">
                            <tr>
                                <th>
                                    <input class="contenido" id="id_consumo" name="id_consumo[]" type="text" readonly
                                        value="<?php echo $row['id_consumo'] ?>">
                                </th>
                                <th><input name="saldo_anterior[]" id="saldo_anterior" type="text" readonly
                                        value="<?php echo $row['consumo_saldo_anterior'] ?>">
                                </th>
                                <th><input name="saldo_importe[]" id="saldo_importe"  type="text" placeholder="ingresa importe"
                                        onchange="calcularConsumo()" value="<?php echo $row['consumo_importe'] ?>">
                                </th>
                                <th><input name="saldo_actual[]" id="saldo_actual" type="text" readonly value="<?php if($row['consumo_saldo_actual']=== null) 
                                    echo "0.00";
                                    else 
                                    echo $row['consumo_saldo_actual'] ?>"></th>
                                <th>
                                    <input type="hidden" name="consumo" value="<?php echo $row['id_consumo']?>">
                                    <input class="form-control" type="submit" value="Guardar">
                                </th>
                            </tr>
                        </div>
                    </tbody>
                </table>
        </div>

        <?php } 
     $equipo=$_GET['id_equipo_transporte'];
    $sql="SELECT id_equipo_transporte,consumo_no_ticket,consumo_saldo_anterior,consumo_importe,consumo_saldo_actual,id_consumo
    FROM mtConsumoGasolinaPrueba
    where id_consumo >'$consumo'
    and id_equipo_transporte = '$equipo'
    order by id_consumo";

    $query= mysqli_query($con, $sql);
    $totalRegistros = mysqli_num_rows($query);

    if($totalRegistros == 0  ){
        //echo "No hay registros";        
    }else{
    ?>
        <h2>Detalle de consumos anteriores</h2> 
        <div class="container">
            <div class="col-sm-9">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Id Consumo </th>
                            <th>Consumo saldo anterior </th>
                            <th>Consumo Importe </th>
                            <th>Consumo Saldo actual </th>
                            <!--<th>Recarga</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <div class="container">
                            <tr><?php while($row= mysqli_fetch_array($query)):?>
                                <th><input class="consumo" name="id_consumo[]" type="text"
                                        id="<?php echo $row['id_consumo'] ?>" readonly
                                        value="<?php echo $row['id_consumo'] ?>"></th>
                                <th><input name="saldo_anterior[]" readonly type="text"
                                        id="consumo_anterior_<?php echo $row['id_consumo'] ?>"
                                        value="<?php echo $row['consumo_saldo_anterior'] ?>"></th>
                                <th><input name="saldo_importe[]" readonly type="text"
                                        id="consumo_importe_<?php echo $row['id_consumo'] ?>"
                                        value="<?php echo $row['consumo_importe'] ?>">
                                </th>
                                <th><input name="saldo_actual[]" type="text" readonly
                                        id="consumo_actual_<?php echo $row['id_consumo'] ?>" value="<?php if($row['consumo_saldo_actual']=== null)echo "0.00";
                                else
                                echo $row['consumo_saldo_actual']?>"></th>
                                <!--<th> <a href="editar.php?id_consumo=<?php echo $row['id_consumo'] ?>">Guardar</a></th>
                                 <th>
                                   <th> <input name="recarga[]" type="text" id= "recarga_<?php echo $row['id_consumo'] ?>" value ="0">
                                </th>-->
                            </tr> 
                            <?php endwhile; ?>
                        </div>
                    </tbody>
                </table>
                </div>

        </div>
        </form>
        <?php } ?>
    </div>
    <script>
                function calcularConsumo() {
    // Obtener valores y convertirlos a números
    const importeAnterior = parseFloat(document.getElementById("saldo_importe").value) || 0;
    const saldoAnterior = parseFloat(document.getElementById("saldo_anterior").value) || 0;
    const actualAnterior = parseFloat(document.getElementById("saldo_actual").value) || 0;

    // Calcular saldo actualizado
    const saldoActualizado = saldoAnterior - importeAnterior;
    const saldoActualRedondeado = parseFloat(saldoActualizado.toFixed(2));

    // Actualizar el saldo actual en el DOM
    document.getElementById("saldo_actual").value = saldoActualRedondeado;

    // Procesar elementos con clase 'consumo'
    const contenido = document.getElementsByClassName("consumo");

    Array.from(contenido).forEach(element => {
        const id_consumo = element.getAttribute("id");

        const consumoAnterior = parseFloat(document.getElementById("consumo_anterior_" + id_consumo).value) || 0;
        const consumoImporte = parseFloat(document.getElementById("consumo_importe_" + id_consumo).value) || 0;
        const consumoActual = parseFloat(document.getElementById("consumo_actual_" + id_consumo).value) || 0;

        // Calcular recargo
        var recargo = consumoAnterior - actualAnterior;
        const recargoRedondeado = parseFloat(recargo.toFixed(2));
        //alert("recargo:"+recargo);
        // Actualizar consumo
        const consumoAnteriorActualizado = recargoRedondeado + saldoActualRedondeado;
        const consumoAnteriorRedondeado = parseFloat(consumoAnteriorActualizado.toFixed(2));
        const consumoActualRedondeado = parseFloat((consumoAnteriorRedondeado - consumoImporte).toFixed(2));
        
        // Actualizar el DOM
        document.getElementById("consumo_anterior_" + id_consumo).value = consumoAnteriorRedondeado;
        document.getElementById("consumo_actual_" + id_consumo).value = consumoActualRedondeado;
        //document.getElementById("recarga_" + id_consumo).value = recargoRedondeado;

        /*const Anterior = parseFloat(document.getElementById("consumo_anterior_" + id_consumo).value) || 0;
        //const Importe = parseFloat(document.getElementById("consumo_importe_" + id_consumo).value) || 0;
        const Actual = parseFloat(document.getElementById("consumo_actual_" + id_consumo).value) || 0;

        var recargoNuevo = Anterior-Actual;

        document.getElementById("recarga_" + id_consumo).value = recargoNuevo;*/
         let recargo2 =recargoRedondeado;
         recargo2=consumoAnteriorActualizado-consumoActual;
        //alert("recargo:"+recargo2);
        console.log(recargo2);

    });
}
 </script>
</body>

</html>