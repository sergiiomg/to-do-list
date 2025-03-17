<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nueva Tarea</title>
    <link rel="stylesheet" href="../css/create.css">
</head>
<body>
    <div id="container">
        <h1>Añadir Nueva Tarea</h1>

        <form action="../actions/add.php" method="POST">
            <label for="task">Descripción:</label>
            <input type="text" name="task" required>
            
            <button type="submit">Agregar Tarea</button>
        </form>

        <br>
        <a href="../index.php">Volver a la Lista</a>
    </div>
</body>
</html>