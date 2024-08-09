<?php
include('conexion/conexion.php');

// Conexión a la base de datos
$con = connection();

// Inicializar variables
$buscar = "";
$showSearchResults = false;

// Procesar formulario de búsqueda
if (isset($_POST['search'])) {
    $buscar = $_POST['busca'];

    if (!empty($buscar)) {
        $sql = "SELECT t.eqtrans_placa, a.consumo_saldo_actual, c.cliente_des_oficial, a.id_equipo_transporte, a.consumo_kilometraje_inicial, a.consumo_kilometraje_final
                FROM auxiliares.mtEquipoTransportePrueba AS t
                INNER JOIN auxiliares.mtConsumoGasolinaPrueba AS a
                ON a.id_equipo_transporte = t.id_equipo_transporte
                LEFT JOIN tesoreria.gsCat_Cliente c
                ON a.id_cliente_cve = c.id_cliente_cve
                WHERE t.eqtrans_status = 'A'
                AND t.eqtrans_placa LIKE '%$buscar%'
                GROUP BY t.eqtrans_placa
                ORDER BY t.eqtrans_placa, c.cliente_des_oficial";
        $query = mysqli_query($con, $sql);
        $totalRegistros = mysqli_num_rows($query);
        $showSearchResults = true;
    } else {
        echo "No se ha Ingresado Placa a Buscar"; 
    }
}

// Consulta para obtener todos los registros si no se está buscando
$sql = "SELECT t.eqtrans_placa, a.consumo_saldo_actual, c.cliente_des_oficial, a.id_equipo_transporte, a.consumo_kilometraje_inicial, a.consumo_kilometraje_final
        FROM auxiliares.mtEquipoTransportePrueba AS t
        INNER JOIN auxiliares.mtConsumoGasolinaPrueba AS a
        ON a.id_equipo_transporte = t.id_equipo_transporte
        LEFT JOIN tesoreria.gsCat_Cliente c
        ON a.id_cliente_cve = c.id_cliente_cve
        WHERE t.eqtrans_status = 'A'
        GROUP BY t.eqtrans_placa
        ORDER BY t.eqtrans_placa, c.cliente_des_oficial";
$queryAll = mysqli_query($con, $sql);
$totalRegistrosAll = mysqli_num_rows($queryAll);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>BUSCADOR</title>
</head>
<body>

    <h1> Buscar Placa Activa</h1> 
    <!-- Formulario de búsqueda -->
    <div class="container">
        <button class="btn btn-secondary mb-3" onclick="toggleSection('searchSection')">Buscar Placa</button>
        <div id="searchSection" style="display: none;">
            <form action="index.php" method="POST">
                <div class="mb-4">
                    <!--<h5>Buscar Placa</h5>-->
                    <input type="text" class="form-text" id="busca" name="busca" size="30" placeholder="Ingrese Placa a Buscar" maxlength="30" value="<?php echo $buscar; ?>">
                    <input type="submit" class="btn btn-primary" name="search" id="search" value="Buscar">
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados de la búsqueda -->
    <div class="container" id="searchResults" style="<?php echo $showSearchResults ? 'display: block;' : 'display: none;'; ?>">
        <h2> Placas Encontradas </h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Placas Activas</th>
                    <th>Id Equipo Transporte</th>
                    <th>Sucursal Asignada</th>
                    <th>Consumo Saldo Actual</th>
                    <th>Kilometraje Inicial</th>
                    <th>Kilometraje Final</th>
                    <th>Ver Consumos</th>
                </tr>
            </thead> 
            <tbody>
                <?php if ($showSearchResults && $totalRegistros > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?php echo $row['eqtrans_placa']; ?></td>
                            <td><?php echo $row['id_equipo_transporte']; ?></td>
                            <td><?php echo $row['cliente_des_oficial']; ?></td>
                            <td><?php echo $row['consumo_saldo_actual']; ?></td>
                            <td><?php echo $row['consumo_kilometraje_inicial']; ?></td>
                            <td><?php echo $row['consumo_kilometraje_final']; ?></td>
                            <td><a href="consumos.php?id_equipo_transporte=<?php echo $row['id_equipo_transporte']; ?>&eqtrans_placa=<?php echo $row['eqtrans_placa']; ?>">Consumos</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php elseif ($showSearchResults && $totalRegistros == 0): ?>
                    <tr>
                        <td colspan="7">No se encontraron registros</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Todos los registros -->
    <div class="container" id="registros" style="<?php echo !$showSearchResults ? 'display: block;' : 'display: none;'; ?>">
        <h2>Detalle Placas Activas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Placas Activas</th>
                    <th>Id Equipo Transporte</th>
                    <th>Sucursal Asignada</th>
                    <th>Consumo Saldo Actual</th>
                    <th>Kilometraje Inicial</th>
                    <th>Kilometraje Final</th>
                    <th>Ver Consumos</th> 
                </tr>
            </thead>
            <tbody>
                <?php if ($totalRegistrosAll > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($queryAll)): ?>
                        <tr>
                            <td><?php echo $row['eqtrans_placa']; ?></td>
                            <td><?php echo $row['id_equipo_transporte']; ?></td>
                            <td><?php echo $row['cliente_des_oficial']; ?></td>
                            <td><?php echo $row['consumo_saldo_actual']; ?></td>
                            <td><?php echo $row['consumo_kilometraje_inicial']; ?></td>
                            <td><?php echo $row['consumo_kilometraje_final']; ?></td>
                            <td><a href="consumos.php?id_equipo_transporte=<?php echo $row['id_equipo_transporte']; ?>&eqtrans_placa=<?php echo $row['eqtrans_placa']; ?>">Consumos</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay registros</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    function toggleSection(sectionId) {
        var section = document.getElementById(sectionId);
        if (section.style.display === "none") {
            section.style.display = "block";
        } else {
            section.style.display = "none";
        }
    }
    </script>
</body>
</html>
