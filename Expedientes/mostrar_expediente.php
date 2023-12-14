<?php
require_once '../config.php';

$msgResultado = "";
$idExpediente = $_GET["id"] ?? null;

try {
    $consultaExpediente = $conexion->prepare("SELECT * FROM expedientes WHERE id = :idExpediente");
    $consultaExpediente->bindParam(':idExpediente', $idExpediente);
    $consultaExpediente->execute();
    $expediente = $consultaExpediente->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    $msgResultado = '<div class="alert alert-danger">' . "Error al obtener información del expediente: " . $ex->getMessage() . '</div>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Expediente</title>
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
            <div class="col-auto">
            <a href="listar_expedientes.php" class="btn btn-primary" style="margin-left: 20px;">Volver al Listado de Estudiantes</a>
            </div>
        </div>
        <div class="text-center">
        <p><h2>Detalle de Expediente</h2></p>
        <?php echo $msgResultado; ?>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th># Expediente</th>
                        <td><?php echo $expediente['expediente']; ?></td>
                    </tr>
                    <tr>
                        <th>NIF</th>
                        <td><?php echo $expediente['nif']; ?></td>
                    </tr>
                    <tr>
                        <th>Apellido1</th>
                        <td><?php echo $expediente['apellido1']; ?></td>
                    </tr>
                    <tr>
                        <th>Apellido2</th>
                        <td><?php echo $expediente['apellido2']; ?></td>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <td><?php echo $expediente['nombre']; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $expediente['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono Móvil</th>
                        <td><?php echo $expediente['telefono']; ?></td>
                    </tr>
                    <tr>
                        <th>Fotografia</th>
                        <td><?php echo $expediente['fotografia']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <img src="../Images/<?php echo $expediente['fotografia']; ?>" alt="Fotografía" class="img-fluid" style="width: 350px; height: auto; border: 2px solid #ddd; border-radius: 8px; margin-bottom: 15px;">
            </div>
        </div>
    </div>
</div>
</body>
</html>