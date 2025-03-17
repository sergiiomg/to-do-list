<?php
//Incluimos la conexión a la BBDD
require_once"config/db_connect.php";

//Número de tareas por página
$tareas_por_pagina = 5;
//Obtenemos y almacenamos el número total de tareas existentes
$total_tareas_stmt = $pdo->query("SELECT COUNT(*) FROM tasks");
$total_tareas = $total_tareas_stmt->fetchColumn();

//Calculamos el número de páginas necesarias
$total_paginas = ceil($total_tareas / $tareas_por_pagina);
//Obtenemos el número de página actual
$pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
//Aseguramos que el número de página actual esté dentro del rango válido
$pagina_actual = max(1, min($pagina_actual, $total_paginas));

$desplazamiento = ($pagina_actual - 1) * $tareas_por_pagina;

try{
    //Preparamos la consulta pidiéndo que seleccione todos los campos de la tabla tasks ordenadas por id de manera descendiente y que lo haga con 
    //los límites establecidos
    $stmt = $pdo->prepare("SELECT * FROM tasks ORDER BY id DESC LIMIT :limite OFFSET :desplazamiento");

    //Le damos a :limite el valor de $tareas_por_pagina
    $stmt->bindValue(':limite', $tareas_por_pagina, PDO::PARAM_INT);

    //Le damos a :desplazamiento el valor de $desplazamiento
    $stmt->bindValue(':desplazamiento', $desplazamiento, PDO::PARAM_INT);

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
    <link rel="stylesheet" href="css/main.css">
    <title>Lista de Tareas</title>
</head>
<body>
<div id="container">
    <div id="container2">
        <div id="container3">
            <div id="container4">
                <h1>Lista de Tareas</h1>
                <table border="0" id="tabla">
                    <tr>
                        <th>Descripción</th>
                        <th>Estado</th>
                    </tr>

                    <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?= htmlspecialchars($tarea['task']) ?></td>
                        <td>
                            <?= $tarea['status'] ? 'Completado' : 'Pendiente' ?>
                        </td>
                        <td>
                            <button><a href="actions/delete.php?id=<?= $tarea['id']; ?>">Eliminar</a></button>
                        </td>
                        <td>
                            <button><a href="views/edit.php?id=<?= $tarea['id']; ?>">Editar</a></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <div id="paginacion">
                    <?php if ($pagina_actual > 1): ?>
                        <a href="?page=<?= $pagina_actual - 1 ?>">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="?page=<?= $i ?>" class="<?= ($i == $pagina_actual) ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($pagina_actual < $total_paginas): ?>
                        <a href="?page=<?= $pagina_actual + 1 ?>">Siguiente</a>
                    <?php endif; ?>
                </div>
            
                <button><a href="views/create.php">Crear una tarea</a></button>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>