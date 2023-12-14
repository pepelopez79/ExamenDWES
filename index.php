<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Exame DWES</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Referencia a la CDN de la hoja de estilos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <!-- Enlace al archivo CSS externo -->
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <div class="container">
        <div class="text-center">
            <h2>Gestión de Expedientes</h2>
            <?php
                echo '<div class="list-group">';
                echo '<a href="Expedientes/listar_expedientes.php" class="list-group-item list-group-item-action">Listado de Estudiantes</a><br>';
                echo '<a href="Expedientes/anadir_expediente.php" class="list-group-item list-group-item-action">Añadir Expediente</a>';
                echo '<div class="text-center mt-3">';
                echo '</div>';
                echo '</div>';
            ?>
        </div>
    </div>
</body>
</html>