<?php
require_once '../config.php';
require_once '../paginacion.php';

function obtenerResultadosExpedientes($conexion, $sql) {
    try {
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['resultados' => $resultados];
    } catch (PDOException $ex) {
        return ['error' => "La consulta no pudo realizarse correctamente (" . $ex->getMessage() . ')'];
    }
}

try {
    // Consulta para la tabla EXPEDIENTES
    $sqlExpedientes = "SELECT * FROM expedientes";

    // Realiza la consulta a la base de datos para EXPEDIENTES
    $resultadosExpedientes = obtenerResultadosExpedientes($conexion, $sqlExpedientes);

    if (isset($resultadosExpedientes['error'])) {
        echo '<div class="alert alert-danger">' . $resultadosExpedientes['error'] . '</div>';
    } else {
        echo '<table class="table table-striped" id="pdfTableExpedientes">';
        echo '<tr><th>ID</th><th>Email</th><th>Apellido1</th><th>Apellido2</th><th>Nombre</th><th>Fotografía</th><th>Expediente</th><th>NIF</th><th>Teléfono</th></tr>';
        foreach ($resultadosExpedientes['resultados'] as $fila) {
            echo '<tr>';
            echo '<td>' . $fila['id'] . '</td>';
            echo '<td>' . $fila['email'] . '</td>';
            echo '<td>' . $fila['apellido1'] . '</td>';
            echo '<td>' . $fila['apellido2'] . '</td>';
            echo '<td>' . $fila['nombre'] . '</td>';
            echo '<td>' . $fila['fotografia'] . '</td>';
            echo '<td>' . $fila['expediente'] . '</td>';
            echo '<td>' . $fila['nif'] . '</td>';
            echo '<td>' . $fila['telefono'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

} catch (PDOException $ex) {
    echo '<div class="alert alert-danger">' . "La consulta no pudo realizarse correctamente (" . $ex->getMessage() . ')</div>';
    die();
}
?>