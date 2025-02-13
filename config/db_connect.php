<?php

//Configuramos los datos de la BBDD
$host = 'localhost';
$dbname = 'todolist_db';
$username = 'root';
$password = '';

try{
    //Creamos la conexión con PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    //Configuramos opciones de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    echo "Conexión exitosa a la base de datos.";
} catch(PDOException $e){
    //Si hay un error de conexión, detenemos la ejecución y mostramos la descripción del error
    die("Error de conexión: " . $e->getMessage());
}