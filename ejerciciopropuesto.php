<?php
include_once 'conexion.php';

// Definir variables para los filtros, por defecto mostrar todo
$estado_civil = isset($_POST['estado_civil']) ? $_POST['estado_civil'] : '';
$empleo = isset($_POST['empleo']) ? $_POST['empleo'] : '';

// Construir la consulta SQL dinámica
$sql_leer = 'SELECT * FROM personas WHERE 1=1';

// Aplicar filtro por estado civil si está seleccionado
if ($estado_civil) {
    $sql_leer .= ' AND estado_civil = :estado_civil';
}

// Aplicar filtro por empleo si está seleccionado
if ($empleo !== '') {
    $sql_leer .= ' AND empleo = :empleo';
}

// Ordenar siempre por estado civil y empleo
$sql_leer .= ' ORDER BY estado_civil, empleo DESC';

$gsent = $pdo->prepare($sql_leer);

// Vincular parámetros en caso de filtros
if ($estado_civil) {
    $gsent->bindParam(':estado_civil', $estado_civil);
}
if ($empleo !== '') {
    $gsent->bindParam(':empleo', $empleo, PDO::PARAM_INT);
}

$gsent->execute();
$resultado = $gsent->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Personas</title>
</head>
<body>
    <h2>Filtrar Personas</h2>
    <form method="POST" action="">
        <!-- Filtro por Estado Civil -->
        <label for="estado_civil">Estado Civil:</label>
        <select name="estado_civil" id="estado_civil">
            <option value="">Todos</option>
            <option value="Casado" <?php if($estado_civil == 'Casado') echo 'selected'; ?>>Casado</option>
            <option value="Soltero" <?php if($estado_civil == 'Soltero') echo 'selected'; ?>>Soltero</option>
        </select>

        <!-- Filtro por Empleo -->
        <label for="empleo">Empleo:</label>
        <select name="empleo" id="empleo">
            <option value="">Todos</option>
            <option value="1" <?php if($empleo === '1') echo 'selected'; ?>>Empleado</option>
            <option value="0" <?php if($empleo === '0') echo 'selected'; ?>>Desempleado</option>
        </select>

        <!-- Botón para aplicar filtros -->
        <button type="submit">Buscar</button>
    </form>

    <h2>Resultados</h2>
    <div>
        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Estado Civil</th>
                <th>Empleo</th>
                <th>Profesión</th>
            </tr>
            <?php if(count($resultado) > 0): ?>
                <?php foreach($resultado as $dato): ?>
                <tr>
                    <td><?php echo $dato['nombre'] ?></td>
                    <td><?php echo $dato['apellido'] ?></td>
                    <td><?php echo $dato['estado_civil'] ?></td>
                    <td><?php echo $dato['empleo'] ? 'Empleado' : 'Desempleado'; ?></td>
                    <td><?php echo $dato['nombre_empleo'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No se encontraron resultados.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>