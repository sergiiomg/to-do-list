<?php
require_once "../config/db_connect.php";

//Verificamos si el ID de la tarea ha sido enviado por el método GET
if(isset($_GET["id"])){
    //Nos aseguramos que el ID obtenido es un número entero y lo guardamos en una variable
    $id = intval($_GET["id"]);


    try{
        //Preparamos la consulta SQL para eliminar la tarea
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");

        //Ejecutamos la consulta con el id obtenido
        $stmt->execute([$id]);

        //Redirigimos a la página principal despues de eliminar la tarea
        header("Location: ../index.php");
        //Detenemos el script después de la redirección
        exit();
    } catch(PDOException $e){
        // Mostramos un error si algo falla
        die("Error al eliminar la tarea" . $e->getMessage());
    }
} else{
    //Si no se recibe un ID, redirigimos a la página principal
    header("Location: ../index.php");
    exit();
}