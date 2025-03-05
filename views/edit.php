<?php
//Nos conectamos a la BBDD
require_once "../config/db_connect.php";

//Verificamos que se ha recibido un ID
if(isset($_GET["id"])){
    //Lo convertimos a un número entero (para evitar inyecciones) y lo guardamos en una variable
    $id = intval($_GET["id"]);

    //Obtenemos los datos de la tarea
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    //Ejecutamos la consulta
    $stmt->execute([$id]);
    //Hacemos que la tarea obtenida se convierta en un array asociativo
    $tarea = $stmt->fetch(PDO::FETCH_ASSOC);

    //Si no existe esa tarea, redirigimos a la página principal
    if(!$tarea){
        header("Location: ../index.php");
        exit();
    }

} else{
    header("Location: ..index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar tarea</title>
</head>
<body>
    <h2>Editar tarea</h2>
    <form action="../actions/update.php" method="POST">
        <!--Enviar el ID de la tarea oculto-->
        <input type="text" name="id" value="<?= $tarea['id']; ?>" hidden>

        <!--Nueva descripción-->
        <label for="task">Descripción:</label>
        <input type="text" name="task" value="<?= htmlspecialchars($tarea['task']); ?>" required>

        <!--Selector para el estado de la tarea-->
        <label for="status">Estado:</label>
        <select name="status">
            <option value="0" <?= $tarea['status'] == 0 ? 'selected' : ''; ?>>Pendiente</option>
            <option value="1" <?= $tarea['status'] == 1 ? 'selected' : ''; ?>>Completada</option>
        </select>

        <!-- Botón para actualizar -->
        <button type="submit">Guardar Cambios</button>
    </form>
    <!-- Botón para cancelar -->
    <a href="../index.php">Cancelar</a>
</body>
</html>