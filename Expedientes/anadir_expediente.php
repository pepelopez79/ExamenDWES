<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Expediente</title>
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
            <p><h2>Añadir Expediente</h2></p>
            <?php
                // Función para sanizitar y validar los campos
                function test_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                // Verificar si se envió el formulario de expedientes
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    include '../config.php';

                    // Obtener y sanizar los datos del formulario
                    $email = test_input($_POST["email"]);
                    $apellido1 = test_input($_POST["apellido1"]);
                    $apellido2 = test_input($_POST["apellido2"]);
                    $nombre = test_input($_POST["nombre"]);
                    $fotografia = test_input($_FILES["fotografia"]["name"]);
                    $expediente = test_input($_POST["expediente"]);
                    $nif = test_input($_POST["nif"]);
                    $telefono = test_input($_POST["telefono"]);

                    // Procesar la imagen si se ha subido una nueva
                    $fotografiaArchivo = $_FILES["fotografia"];

                    // Verificar si se subió la imagen sin errores
                    if ($fotografiaArchivo["error"] == 0) {
                        // Asegúrate de que el directorio de subida existe y tiene los permisos adecuados
                        $directorioSubida = '../Images/';
                        $nombreArchivo = basename($fotografiaArchivo["name"]);
                        $rutaCompleta = $directorioSubida . $nombreArchivo;

                        // Mueve el archivo temporal a la ubicación deseada
                        if (move_uploaded_file($fotografiaArchivo["tmp_name"], $rutaCompleta)) {
                            // Consultar la base de datos para añadir el expediente
                            $consulta = $conexion->prepare("INSERT INTO expedientes (email, apellido1, apellido2, nombre, fotografia, expediente, nif, telefono) VALUES (:email, :apellido1, :apellido2, :nombre, :fotografia, :expediente, :nif, :telefono)");
                            $consulta->bindParam(':email', $email);
                            $consulta->bindParam(':apellido1', $apellido1);
                            $consulta->bindParam(':apellido2', $apellido2);
                            $consulta->bindParam(':nombre', $nombre);
                            $consulta->bindParam(':fotografia', $nombreArchivo);
                            $consulta->bindParam(':expediente', $expediente);
                            $consulta->bindParam(':nif', $nif);
                            $consulta->bindParam(':telefono', $telefono);
                            $consulta->execute();

                            echo '<div class="alert alert-success" role="alert">';
                            echo 'Expediente añadido correctamente.';
                            echo '</div>';
                        } else {
                            throw new Exception("Error al añadir el nuevo expediente.");
                        }
                    } else {
                        throw new Exception("Error al subir la imagen: " . $fotografiaArchivo["error"]);
                    }
                }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Campos del formulario -->
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="apellido1">Apellido 1:</label>
                    <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                </div>
                <div class="form-group">
                    <label for="apellido2">Apellido 2:</label>
                    <input type="text" class="form-control" id="apellido2" name="apellido2" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="fotografia">Fotografía:</label>
                    <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="expediente">Expediente:</label>
                    <input type="text" class="form-control" id="expediente" name="expediente" required>
                </div>
                <div class="form-group">
                    <label for="nif">NIF:</label>
                    <input type="text" class="form-control" id="nif" name="nif" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>
                <!-- Botón de envío -->
                <button type="submit" class="btn btn-primary" style="margin-bottom:50px">Añadir Expediente</button>
            </form>
        </div>
    </div>
</body>
</html>