<?php
//Incluimos la conexión a la BBDD
require_once"config/db_connect.php";

try{
    //Preparamos la consulta pidiéndo que selecciones todos los campos de la tabla tasks ordenadas por id de manera descendiente
    $stmt = $pdo->prepare("SELECT * FROM tasks ORDER BY id ASC");

    //Ejecutamos la consulta
    $stmt->execute();

    //Obtenemos las tareas como un array asociativo
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e){
    echo "Error al obtener las tareas " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Lista de Tareas</h2>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Estado</th>
        </tr>

        <?php foreach ($tareas as $tarea): ?>
        <tr>
            <td><?= htmlspecialchars($tarea['id']) ?></td>
            <td><?= htmlspecialchars($tarea['task']) ?></td>
            <td>
                <?= $tarea['status'] ? 'Completado' : 'Pendiente' ?>
            </td>
            <td>
            <a href="actions/delete.php?id=<?= $tarea['id']; ?>">Eliminar tarea</a>
            </td>
            <td>
            <a href="views/edit.php?id=<?= $tarea['id']; ?>">Editar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="views/create.php">Crear una tarea</a></p>
</body>
</html>