<?php
require_once '../config.php';

// Mensaje que indicará al usuario si la eliminación se realizó correctamente o no
$msgResultado = "";

// Verificar si se envió una solicitud POST para eliminar el expediente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idExpediente = $_POST["idExpediente"];

    try {
        // Consultar la base de datos para eliminar el expediente
        $consultaEliminar = $conexion->prepare("DELETE FROM expedientes WHERE id = :idExpediente");
        $consultaEliminar->bindParam(':idExpediente', $idExpediente);
        $consultaEliminar->execute();

        // Cambiar el mensaje de éxito antes de redirigir
        $msgResultado = '<div class="alert alert-success">' . "Expediente eliminado correctamente." . '</div>';
        
        // Redirigir al usuario al listado de expedientes
        header("Location: listar_expedientes.php");
    } catch (PDOException $ex) {
        // Manejar errores de consulta a la base de datos
        $msgResultado = '<div class="alert alert-danger">' . "Error al eliminar el expediente: " . $ex->getMessage() . '</div>';
    }
}

// Obtener el ID del expediente desde la URL
$idExpediente = $_GET["id"] ?? null;

// Consultar la base de datos para obtener la información del expediente
try {
    $consultaExpediente = $conexion->prepare("SELECT * FROM expedientes WHERE id = :idExpediente");
    $consultaExpediente->bindParam(':idExpediente', $idExpediente);
    $consultaExpediente->execute();
    $expediente = $consultaExpediente->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    // Manejar errores de consulta a la base de datos
    $msgResultado = '<div class="alert alert-danger">' . "Error al obtener información del expediente: " . $ex->getMessage() . '</div>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Expediente</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Referencia a la CDN de la hoja de estilos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <!-- Enlace al archivo CSS externo -->
    <link rel="stylesheet" href="../CSS/estilos.css">
</head>
<body>
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <a href="../index.php" class="btn btn-primary" style="width: 80px;">Inicio</a>
            </div>
        </div>
        <div class="text-center">
        <p><h2>Eliminar Expediente</h2></p>
        <?php echo $msgResultado; ?>
        <form action="" method="post">
            <input type="hidden" name="idExpediente" value="<?php echo $expediente['id']; ?>">
            <p>¿Estás seguro de que deseas eliminar el expediente con Número de Expediente <?php echo $expediente['expediente']; ?>?</p>
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="listar_expedientes.php" class="btn btn-primary" style="margin-left: 20px;">Cancelar</a>
        </form>
    </div>
</div>
</body>
</html>