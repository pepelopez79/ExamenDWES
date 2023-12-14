<?php
try {
    $dbHost = 'localhost';
    $dbName = 'bdexpedientes';
    $dbUser = 'root';
    $dbPass = '';

    $conexion = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mensaje de conexión exitosa
    echo '<div class="alert alert-success" role="alert">';
    echo 'Conexión exitosa a la base de datos';
    echo '</div>';
} catch (PDOException $ex) {
    // Mensaje de conexión fallida
    echo '<div class="alert alert-danger" role="alert">';
    echo 'No se pudo conectar a la base de datos. Error: ' . $ex->getMessage();
    echo '</div>';
}
?>