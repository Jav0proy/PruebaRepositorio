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
                        <tbody class="container">
                            <div class="container">
                                <tr>
                                    <th>
                                        <input class="contenido" id="id_consumo" name="id_consumo[]" type="text" readonly value="<?php echo $row['id_consumo'] ?>">
                                    </th>
                                    <th><input name="saldo_anterior[]" id="saldo_anterior" type="text" readonly value="<?php echo $row['consumo_saldo_anterior'] ?>">
                                    </th>
                                    <th><input name="saldo_importe[]" id="saldo_importe" type="text" onchange="calcularConsumo()" value="<?php echo $row['consumo_importe'] ?>">
                                    </th>
                                    <th><input name="saldo_actual[]" id="saldo_actual" type="text" readonly value="<?php if($row['consumo_saldo_actual']=== null) 
                                    echo "0.00";
                                    else 
                                    echo $row['consumo_saldo_actual'] ?>"></th>
                                    <th>
                                        <input type="hidden" name="consumo" value="<?php echo $row['id_consumo']?>">
                                        <input class="form-control" type="submit" onclick="location.reload()" value="Guardar">
                                    </th>
                                </tr>
                            </div>
                        </tbody>
                    </table>
            </div>
            </form>
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
        echo "No hay registros";        
    }else{
    ?>
            <div>Detalle de consumos anteriores</div>
            <div class="container">
                <form action="editar.php" method="POST">
                    <table class="tabla">
                        <thead>
                            <tr>
                                <th>Id Consumo </th>
                                <th>Consumo saldo anterior </th>
                                <th>Consumo Importe </th>
                                <th>Consumo Saldo actual </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="container">
                                <tr><?php while($row= mysqli_fetch_array($query)):?>
                                    <th><input class="consumo" name="id_consumo[]" type="text" id="<?php echo $row['id_consumo'] ?>" readonly value="<?php echo $row['id_consumo'] ?>"></th>
                                    <th><input name="saldo_anterior[]" readonly type="text" id="consumo_anterior_<?php echo $row['id_consumo'] ?>" value="<?php echo $row['consumo_saldo_anterior'] ?>"></th>
                                    <th><input name="saldo_importe[]" type="text" id="consumo_importe_<?php echo $row['id_consumo'] ?>" value="<?php echo $row['consumo_importe'] ?>">
                                    </th>
                                    <th><input name="saldo_actual[]" type="text" readonly id="consumo_actual_<?php echo $row['id_consumo'] ?>" value="<?php if($row['consumo_saldo_actual']=== null)echo "0.00";
                                else
                                echo $row['consumo_saldo_actual']?>"></th>
                                    <!--<th> <a href="editar.php?id_consumo=<?php echo $row['id_consumo'] ?>">Guardar</a></th>-->
                                </tr>
                                <?php endwhile; ?>
                            </div>
                        </tbody>
                    </table>
                    <script>
                        //funcion para recorrer y mostrar los datos dentro de los elementos 'getElementById y getElementsByClassName' llamada con el metodo Onchange.
                    function calcularConsumo() {
                        
                        var importeAnterior = document.getElementById("saldo_importe").value;
                        var saldoAnterior = document.getElementById("saldo_anterior").value;
                        var actualAnterior = document.getElementById("saldo_actual").value;
                        //Se crean las variables y se realiza operación, se le asigna el valor
                        var saldoActualizado =saldoAnterior-importeAnterior;
                        var nuevoActual = saldoActualizado;
                        //Se manda el dato actualizado por medio del metodo getElementById y se manda el id del input donde se realizo el cambio.
                        document.getElementById("saldo_actual").value = nuevoActual;
                        //Variable para usar en el metodo getElementsByClassName de acuerdo al nombre de la clase.
                        var contenido = document.getElementsByClassName("consumo");
                        //Bucle para ir iterando los elementos que tengan el nombre de la clase, recorrerlos e ir mostrando los datos.
                        for(var i =0; i < contenido.length; i++){
                            var id_consumo = contenido[i].getAttribute("id");
                            var consumoAnterior = document.getElementById("consumo_anterior_"+ id_consumo).value;
                            //alert(consumoAnterior);
                            var consumoImporte = document.getElementById("consumo_importe_"+ id_consumo).value;
                            //alert(consumoImporte);
                            var consumoActual = document.getElementById("consumo_actual_"+ id_consumo).value;
                            var recargo= consumoAnterior-actualAnterior;
                            var consumoAnteriorActualizado= recargo + nuevoActual;
                            var nuevoAnterior = consumoAnteriorActualizado;
                            nuevoImporte = consumoImporte;
                            var actualActualizado = nuevoAnterior-consumoImporte;
                            Math.round(actualActualizado * 100) / 100;
                            nuevoActual =actualActualizado;
                           document.getElementById("consumo_anterior_"+id_consumo).value =nuevoAnterior;
                           document.getElementById("consumo_actual_"+id_consumo).value =nuevoActual;

                        }

                        /*
                        var consumoAnterior = document.getElementById("contenido_anterior").value;
                        var consumoActual = document.getElementById("contenido_saldo").value;
                        var consumoImporte = document.getElementById("contenido_importe").value;

                        let consumoNuevo = document.getElementsByClassName("consumo");
                        for(var i =0; i < consumoNuevo.length; i++){
                        console.log(consumoNuevo[i].innerHTML);
                        var consumoAnteriorNuevo= document.getElementById("consumo_anterior_nuevo").value;
                        var consumoActualNuevo = document.getElementById("consumo_actual_nuevo").value;
                        var consumoImporteNuevo = document.getElementById("consumo_importe_nuevo").value;
                        var consumoActualizadoActual =  consumoAnterior-consumoImporte;
                        var consumoActualizadoImporte = consumoImporteNuevo;
                        var consumoActualizadoAnterior = recargo1+consumoActualizadoActual;
                        var recargo1 = consumoAnteriorNuevo-consumoActualizadoActual;
                        var ultimoConsumoActual = consumoAnteriorNuevo-consumoImporteNuevo;
                        }
                        */
                        /*
                         var consumos = Array.from(document.getElementsByClassName("consumo"));
                         consumos.forEach((elemento, index) => {
                             console.log('posicion ' + index + ':', elemento);
                             let consumo_anterior_nuevo = consumos[2].value;
                             let consumo_importe_nuevo = consumos[3].value;
                             let consumo_actual_nuevo = consumos[4].value;
                             let importe = (consumoAnterior-consumoImporte).toFixed(2);
                             let nuevoAnteriorConsumo = (consumo_anterior_nuevo-importe);
                             let nuevoImporteNuevo = consumo_importe_nuevo;
                             let nuevoActualNuevo = (consumo_anterior_nuevo - consumo_importe_nuevo);
                             parseFloat(consumo_anterior_nuevo);
                             parseFloat(nuevoAnteriorConsumo);
                             parseFloat(nuevoImporteNuevo);
                             console.log(parseFloat(nuevoActualNuevo));
                             console.log(parseFloat(importe));
                             alert(consumo_anterior_nuevo +" " + nuevoAnteriorConsumo + " " + nuevoImporteNuevo + " " + 
                             nuevoActualNuevo +" " + importe +" ");
                         }); 
                         /*
                             /* var consumoAnteriorNuevo= document.getElementById("consumo_anterior_nuevo").value;
                              var consumoActualNuevo = document.getElementById("consumo_actual_nuevo").value;
                              var consumoImporteNuevo = document.getElementById("consumo_importe_nuevo").value;*/
                        // alert(" Ant0  "+consumoAnterior + " Imprt0  " + consumoImporte + " Actu0  " + consumoActualizadoActual + " Ant1  " + consumoAnteriorNuevo + " Import1  " + consumoImporteNuevo + " Act1  " + consumoActualNuevo  
                        //     +" Ant1Actualizado "+consumoActualizadoAnterior +" Importe1  " +consumoActualizadoImporte +" Act1final  "+ultimoConsumoActual);


                    }
                    </script>
            </div>
            </form>
            <?php } ?>
        </div>
</body>

</html>