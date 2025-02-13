<?php 
require_once "../config/db_connect.php";

//Verificamos que la solicitud es de tipo POST.
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $task = trim($_POST["task"]);

    //Verificamos que la descripción no está vacía.
    if(!empty($task)){
        try{
            //Insertamos los datos en la BBDD
            $stmt = $pdo->prepare("INSERT INTO tasks (task, status) VALUES (:task, 0)");
            //Le damos el valor de task a :task
            $stmt->bindParam(":task", $task);
            $stmt->execute();

            //Redirigimos al usuario a read.php para que vea la lista de tareas.
            header("Location: ../views/read.php");
            exit();

        } catch(PDOException $e){
            die("Error al guardar la tarea " . $e->getMessage());
        }
        
    } else{
        die ("Error: La descripción no puede estar vacía.");
    }

} else{
    header("Location: ../views/read.php");
    exit();
}