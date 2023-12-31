<?php
session_start();
require './php/config.php';

if (isset($_SESSION['nombre'])) {
    header("Location: ./");
}

if (!empty($_POST['nombre']) && !empty($_POST['mail']) && !empty($_POST['contrasena'])) {
    if (strlen($_POST['nombre']) >= 3 && strlen($_POST['nombre']) <= 32) {
        if (strlen($_POST['contrasena']) >= 3 && strlen($_POST['contrasena']) <= 32) {
            if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                if ($_POST['contrasena'] == $_POST['contrasena2']) {
                    $query = $conn->prepare("SELECT * FROM `Usuarios` WHERE `mail` = :mail LIMIT 1");
                    $query->bindParam('mail', $_POST['mail']);
                    if ($query->execute()) {
                        if ($query->rowCount() == 1) {
                            $msg =  'ya existe un usuario con ese mail';
                        } else {
                            $nuevouser = $conn->prepare("INSERT INTO `Usuarios`(`nombre`, `mail`, `password`) VALUES (:nombre , :mail , :contrasena )");
                            $nuevouser->bindParam('nombre', $_POST['nombre']);
                            $nuevouser->bindParam('mail', $_POST['mail']);
                            $conEncryp = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                            $nuevouser->bindParam('contrasena', $conEncryp);
                            if ($nuevouser->execute()) {
                                $_SESSION['nombre'] = $_POST['nombre'];
                                $_SESSION['mail'] = $_POST['mail'];
                                header('Location: /');
                            } else {
                                $msg =  'Error sql:2';
                            }
                        }
                    } else {
                        $msg =  'Error sql';
                    }
                } else {
                    $msg =  'Las contraseñas no coinciden';
                }
            } else {
                $msg =  'Email invalido';
            }
        } else {
            $msg =  'Contraseña invalida (min: 4; max: 32)';
        }
    } else {
        $msg =  'Nombre invalido (min: 3; max: 32)';
    }

    if (isset($msg)) {
        echo "<script>alert('$msg')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Merca Livre - Registrarse</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/sesion.css">
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="./css/header.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <?php require './php/header.php' ?>
    <section class=".caja">
        <h2>Registrarse</h2>
        <form action="./registrarse.php" method="POST">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Nombre</label>
                <input type="text" minlength="3" maxlength="32" class="form-control" id="formGroupExampleInput2" name="nombre">
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Mail</label>
                <input type="email" class="form-control" id="formGroupExampleInput2" name="mail">
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Constraseña</label>
                <input type="password" class="form-control" minlength="3" maxlength="32" id="formGroupExampleInput2" name="contrasena">
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Confirme su contraseña</label>
                <input type="password" class="form-control" minlength="3" maxlength="32" id="formGroupExampleInput2" name="contrasena2">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-primary" type="button">Registrarse</button>
            </div>
        </form>
        <h5 class= "noTiene">Ya tiene una cuenta? <a href="./iniciarSesion.php">Iniciar Sesion</a></h5>
    </section>
</body>

</html>