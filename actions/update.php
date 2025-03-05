<?php
//Nos conectamos a la BBDD
require_once "../config/db_connect.php";

//Verificamos que el formulario ha sido enviado correctamente
if(isset($_POST["id"], $_POST["task"], $_POST["status"])){
    //Convertimos el ID a un número entero
    $id = intval($_POST["id"]);

    //Limpiamos los posibles espacios en blanco al principio y al final de la descripcion
    $task = htmlspecialchars(trim($_POST["task"]));

    //Convertimos el estado a numero entero
    $status = intval($_POST["status"]);

    try{
        //Preparamos la consulta para actualizar la tarea
        $stmt = $pdo->prepare("UPDATE tasks SET task = ?, status = ? WHERE id = ?");

        //Ejecutamos la consulta con los nuevos datos
        $stmt->execute([$task, $status, $id]);

        //Redirigimos a la página principal
        header("Location: ../index.php");
        exit();
    } catch(PDOException $e){
        die("Error al actualizar la tarea: " . $e->getMessage());
    }
} else{
    //Si no se reciben datos, redirigimos a la página principal
    header("Location: ../index.php");
    exit();
}