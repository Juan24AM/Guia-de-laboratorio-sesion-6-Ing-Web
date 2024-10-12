<?php

include_once 'conexion.php';
$sql_leer = 'SELECT * FROM usuarios';
$gsent = $pdo->prepare($sql_leer);
$gsent->execute();
$resultado = $gsent->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <table>
            <tr>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Edad</td>
                <td>Sexo</td>
            </tr>
            <?php foreach($resultado as $dato): ?>
            <tr>
                <td><?php echo $dato['Nombres'] ?></td>
                <td><?php echo $dato['Apellidos'] ?></td>
                <td><?php echo $dato['Edad'] ?></td>
                <td><?php echo $dato['Sexo'] ?></td>
            </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>
</html>