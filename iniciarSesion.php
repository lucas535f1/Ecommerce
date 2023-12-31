<?php
session_start();
require './php/config.php';

if (isset($_SESSION['nombre'])) {
    header("Location: ./");
}

if (!empty($_POST['mail']) && !empty($_POST['contrasena'])) {
    $query = $conn->prepare("SELECT * FROM `Usuarios` WHERE `mail` = :mail LIMIT 1");
    $query->bindParam('mail', $_POST['mail']);
    if ($query->execute()) {
        $usuario = $query->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['contrasena'], $usuario['password'])) {
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['mail'] = $usuario['mail'];
            $_SESSION['esAdmin'] = $usuario['esAdmin'];
            var_dump($_SESSION);
            header('Location: /');
        } else {
            $msg =  'Contraseña incorrecta';
        }
    } else {
        $msg =  'Error sql';
    }
    if (isset($msg)) {
        echo "<script>alert('$msg')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Merca Livre - Iniciar sesion</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/sesion.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <?php require './php/header.php' ?>

    <section class=".caja">
        <h2>Iniciar Sesion</h2>
        <form action="./iniciarSesion.php" method="POST">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Mail</label>
                <input type="text" class="form-control" id="formGroupExampleInput2" name="mail">
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Constraseña</label>
                <input type="password" class="form-control" id="formGroupExampleInput2" name="contrasena">
            </div>
            <!-- <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-primary" style="margin: 10px 168.45px;">Iniciar Sesion</button>
            </div> -->
            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-primary" type="button">Iniciar Sesion</button>
            </div>
        </form>
        <h5 class="noTiene">No tiene una cuenta? <a href="./registrarse.php">Registrarse</a></h5>
    </section>
</body>

</html>