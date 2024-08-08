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
    <div class="container" style="display: block;" id="">
        <?php
        $con= connection();
        
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
    <div class="container" id="" style=" 'display: block;' ">
        <div class="col-sm-10">
            <!--<form action="editar.php" method="POST">-->
            <form action="editar.php" method="POST">
                <h2>Consumos Registrados</h2>
                <table class="tabla" id="tableDatos">
                    <thead>
                        <tr>
                            <!--<th>Placa</th>-->
                            <th align="center">Id Consumo </th>
                            <th align="center">Consumo saldo anterior </th>
                            <th align="center" >Consumo Importe </th>
                            <th align="center">Consumo Saldo actual </th>
                            <!--<th>Consumo Hora </th>-->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="container" align="center">
                        <tr align="right">
                            <th align="right">
                                <input class="contenido" id="id_consumo" name="id_consumo[]" type="text" readonly
                                    value="<?php echo $row['id_consumo'] ?>">
                            </th>
                            <th align="right" ><input  name="saldo_anterior[]" id="saldo_anterior" type="text" readonly
                                    value="<?php echo $row['consumo_saldo_anterior'] ?>">
                            </th>
                            <th align="right"><input name="saldo_importe[]" id="saldo_importe" type="text"
                                    placeholder="ingresa importe" onchange="calcularConsumo()"
                                    value="<?php echo $row['consumo_importe'] ?>">
                            </th>
                            <th align="right"><input name="saldo_actual[]" id="saldo_actual" type="text" readonly value="<?php if($row['consumo_saldo_actual']=== null) 
                                    echo "0.00";
                                    else 
                                    echo $row['consumo_saldo_actual'] ?>"></th>
                            <th align="right">
                                <input type="hidden" name="consumo" value="<?php echo $row['id_consumo']?>">
                                <input class="btn btn-primary" type="submit" value="Guardar">
                            </th>
                        </tr>
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
        <h2>Detalle de Consumos Posteriores</h2>
        <div class="container" id="" style=" 'display: block;' ">
            <div class="col-sm-9">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id Consumo </th>
                            <th>Consumo saldo anterior </th>
                            <th>Consumo Importe </th>
                            <th>Consumo Saldo actual </th>
                            <th>Recarga</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <tr><?php while($row= mysqli_fetch_array($query)):?>
                            <th><input class="consumo" name="id_consumo[]" type="text" id="<?php echo $row['id_consumo'] ?>" readonly
                                    value="<?php echo $row['id_consumo'] ?>"></th>
                            <th><input name="saldo_anterior[]" readonly type="text" id="consumo_anterior_<?php echo $row['id_consumo'] ?>"
                                    value="<?php echo $row['consumo_saldo_anterior'] ?>"></th>
                            <th><input name="saldo_importe[]" readonly type="text" id="consumo_importe_<?php echo $row['id_consumo'] ?>"
                                    value="<?php echo $row['consumo_importe'] ?>">
                            </th>
                            <th><input name="saldo_actual[]" type="text" readonly
                                    id="consumo_actual_<?php echo $row['id_consumo'] ?>" value="<?php if($row['consumo_saldo_actual']=== null)echo "0.00";
                                else
                                echo $row['consumo_saldo_actual']?>"></th>
                            <!--<th> <a href="editar.php?id_consumo=<?php echo $row['id_consumo'] ?>">Guardar</a></th>
                                 <th>-->
                            <th> <input name="recarga[]" type="text" id="recarga_<?php echo $row['id_consumo'] ?>" value="0">
                            </th>
                            <!--<th>
                                <input type="text" id="renglonAnterior_<?php echo $row['id_consumo'] ?>" value="0">
                            </th>-->
                        </tr>
                        <?php endwhile; ?>
                </table>
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

            let valoresPorPosicion=[];
            let valoresPorPosicion2=[];

            Array.from(contenido).forEach((element,index) => {

                const id_consumo = element.getAttribute("id");

                const consumoAnterior = parseFloat(document.getElementById("consumo_anterior_" + id_consumo).value) || 0;
                const consumoImporte = parseFloat(document.getElementById("consumo_importe_" + id_consumo).value) || 0;
                const consumoActual = parseFloat(document.getElementById("consumo_actual_" + id_consumo).value) || 0;
                //const recargo= parseFloat(document.getElementById("recarga_" + id_consumo).value) || 0;
                // Actualizar consumo
                const recargo = consumoAnterior - actualAnterior;
                const recargoRedondeado = parseFloat(recargo.toFixed(2));
                const consumoAnteriorActualizado = recargoRedondeado + saldoActualRedondeado;
                const consumoAnteriorRedondeado = parseFloat(consumoAnteriorActualizado.toFixed(2));
                const consumoActualRedondeado = parseFloat((consumoAnteriorRedondeado - consumoImporte).toFixed(2));

                // Almacenar el valor en el array según la posición
                 valoresPorPosicion[index] = consumoActualRedondeado;
                 valoresPorPosicion2[index] = consumoAnteriorActualizado;

                // Calcular recargo
                const rec2=consumoAnteriorActualizado-consumoActualRedondeado;
                const rec2Red = parseFloat(rec2.toFixed(2));
                    if (index >0) {
                    const consumoAnterior = valoresPorPosicion[index -1] ;
                    const consumoActual = valoresPorPosicion2[index-1];
                    const diferencia = parseFloat(valoresPorPosicion2[index]-valoresPorPosicion[index -1 ]);

                    //console.log(`Diferencia entre el registro en posición ${index} y el registro en posición ${index - 1}: ${diferencia.toFixed(2)}`);
                    const diFinal=parseFloat(diferencia.toFixed(2))
                    document.getElementById("recarga_" + id_consumo).value=diFinal; 
                   }else{
                   const recargo = consumoAnterior - actualAnterior;
                   document.getElementById("recarga_" + id_consumo).value=recargo; 

                   //console.log(consumoAnterior,consumoActual);
                   console.log('Valores almacenados por posición:', valoresPorPosicion);
                   console.log('Valores almacenados por posición:', valoresPorPosicion2);
                   
                     /* if (index > 0) {
                    // const previousId = `consumo_actual_${index - 1}`;
                      const consumoAnterior = elementoAnterior[previousId] || 0; // Obtener el valor del registro anterior

                     // Realizar la operación deseada
                   const diferencia = consumoAnterior-consumoActual;
                   console.log(previousId);
                   console.log(`Diferencia entre el registro ${index} y el registro ${index - 1}: ${diferencia.toFixed(2)}`);
                 }*/
                        // Input Nuevoo
                //const saldoAnterior = parseFloat(document.getElementById("consumo_importe_" + id_consumo).value);
                //const saldo = (consumoAnterior - saldoAnterior);
                //let saldoInput = parseFloat(document.getElementById("consumo_actual_" + id_consumo).value);
                //saldoInput =saldo;

                /*
                if (elementoAnterior) {
             // Obtener valores del elemento anterior
                 const id_anterior = elementoAnterior.getAttribute("id");
                 const consumoAnterior = parseFloat(document.getElementById("consumo_actual_" + id_anterior).value) || 0;

                  // Aquí puedes usar el índice
                     //console.log(`Posición del registro: ${index}`);
                     ///
                     // Realizar la operación con el registro anterior
                    const diferencia = consumoAnteriorRedondeado - consumoActualRedondeado;
                    console.log(`indice ${index}  indiceanterior ${index - 1}:`)

                    //console.log(`Diferencia entre el registro ${index} y el registro ${index - 1}: ${diferencia.toFixed(2)}`);
                    }
                //let renglonAnterior = parseFloat(document.getElementById("renglonAnterior_" + id_consumo).value);
                //renglonAnterior = saldoInput;
                // ** 
                /*if(id_consumo >=1){
                    const recargo = consumoAnterior - actualAnterior;
                    //console.log(recargo);
                    console.log(`Recargo para id_consumo ${id_consumo} en posición ${index}: ${recargo}`);
    
                }else{ 
                    const recargo = consumoAnterior - consumoActualRedondeado; 
                    //console.log(recargo);
                    console.log(`Recargo para id_consumo ${id_consumo} en posición ${index}: ${recargo}`);
                }
                
                let id=`${id_consumo}`;
                let ant=`${consumoAnteriorActualizado}`;
                let con=`${consumoActualRedondeado}`; 
                console.log("Idconsumo: "+id,ant,con);*/ 

                // Actualizar el DOM  
                //document.getElementById("renglonAnterior_" + id_consumo).value = recargoRedondeado; 
                   }
                document.getElementById("consumo_anterior_" + id_consumo).value = consumoAnteriorRedondeado;
                document.getElementById("consumo_actual_" + id_consumo).value = consumoActualRedondeado;
                   
            });
        }
        </script>
</body>

</html>