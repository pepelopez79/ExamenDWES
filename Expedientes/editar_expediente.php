<?php
require_once '../config.php';

$msgResultado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $idExpediente = $_POST["idExpediente"];
        $nuevoEmail = $_POST["nuevoEmail"];
        $nuevoApellido1 = $_POST["nuevoApellido1"];
        $nuevoApellido2 = $_POST["nuevoApellido2"];
        $nuevoNombre = $_POST["nuevoNombre"];

        // Procesar la nueva imagen si se ha subido
        $nuevaImagen = $_FILES["nuevaImagen"];

        // Verificar si se subió la imagen sin errores
        if ($nuevaImagen["error"] == 0) {
            // Asegúrate de que el directorio de subida existe y tiene los permisos adecuados
            $directorioSubida = '../Images/';
            $nombreArchivo = basename($nuevaImagen["name"]);
            $rutaCompleta = $directorioSubida . $nombreArchivo;

            // Mueve el archivo temporal a la ubicación deseada
            if (move_uploaded_file($nuevaImagen["tmp_name"], $rutaCompleta)) {
                // Actualizar la información del expediente en la base de datos con la nueva imagen
                $consulta = $conexion->prepare("UPDATE expedientes SET email = :nuevoEmail, apellido1 = :nuevoApellido1, 
                    apellido2 = :nuevoApellido2, nombre = :nuevoNombre, fotografia = :nuevaImagen WHERE id = :idExpediente");
                $consulta->bindParam(':nuevoEmail', $nuevoEmail);
                $consulta->bindParam(':nuevoApellido1', $nuevoApellido1);
                $consulta->bindParam(':nuevoApellido2', $nuevoApellido2);
                $consulta->bindParam(':nuevoNombre', $nuevoNombre);
                $consulta->bindParam(':nuevaImagen', $nombreArchivo);
                $consulta->bindParam(':idExpediente', $idExpediente);
                $consulta->execute();

                $msgResultado = '<div class="alert alert-success">' . "Expediente actualizado correctamente." . '</div>';
                header("Location: listar_expedientes.php");
                exit();
            } else {
                throw new Exception("Error al subir la nueva imagen.");
            }
        } else {
            // No se subió una nueva imagen, solo actualiza los otros campos
            $consulta = $conexion->prepare("UPDATE expedientes SET email = :nuevoEmail, apellido1 = :nuevoApellido1, 
                apellido2 = :nuevoApellido2, nombre = :nuevoNombre WHERE id = :idExpediente");
            $consulta->bindParam(':nuevoEmail', $nuevoEmail);
            $consulta->bindParam(':nuevoApellido1', $nuevoApellido1);
            $consulta->bindParam(':nuevoApellido2', $nuevoApellido2);
            $consulta->bindParam(':nuevoNombre', $nuevoNombre);
            $consulta->bindParam(':idExpediente', $idExpediente);
            $consulta->execute();

            $msgResultado = '<div class="alert alert-success">' . "Expediente actualizado correctamente." . '</div>';
            header("Location: listar_expedientes.php");
            exit();
        }
    } catch (PDOException $ex) {
        $msgResultado = '<div class="alert alert-danger">' . "Error al actualizar el expediente: " . $ex->getMessage() . '</div>';
    } catch (Exception $ex) {
        $msgResultado = '<div class="alert alert-danger">' . $ex->getMessage() . '</div>';
    }
}

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
    <title>Editar Expediente</title>
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
            <p><h2>Editar Expediente</h2></p>
            <?php echo $msgResultado; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idExpediente" value="<?php echo $expediente['id']; ?>">
                <div class="form-group">
                    <label for="nuevoEmail">Nuevo Email:</label>
                    <input type="email" class="form-control" id="nuevoEmail" name="nuevoEmail" value="<?php echo $expediente['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nuevoApellido1">Nuevo Apellido1:</label>
                    <input type="text" class="form-control" id="nuevoApellido1" name="nuevoApellido1" value="<?php echo $expediente['apellido1']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nuevoApellido2">Nuevo Apellido2:</label>
                    <input type="text" class="form-control" id="nuevoApellido2" name="nuevoApellido2" value="<?php echo $expediente['apellido2']; ?>">
                </div>
                <div class="form-group">
                    <label for="nuevoNombre">Nuevo Nombre:</label>
                    <input type="text" class="form-control" id="nuevoNombre" name="nuevoNombre" value="<?php echo $expediente['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nuevaImagen">Nueva Fotografía:</label>
                    <input type="file" class="form-control" id="nuevaImagen" name="nuevaImagen" accept="image/*">
                </div>
                <!-- Otros campos del expediente -->
                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Guardar Cambios</button>
                <a href="listar_expedientes.php" class="btn btn-danger" style="margin-top: 10px; margin-left: 20px;">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>