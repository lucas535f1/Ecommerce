<?php
session_start();
require './php/config.php';

if (!isset($_SESSION['nombre'])) {
    header("Location: ./iniciarSesion.php");
}

$query = $conn->prepare("SELECT `id`, `mail`,`titulo`,`descripcion`,`categoria`,`precio`  FROM `Producto` WHERE id=:id AND mail=:mail LIMIT 1");
$query->bindParam('id', $_GET['id']);
$query->bindParam('mail', $_SESSION['mail']);
$query->execute();
$datos = $query->fetch(PDO::FETCH_ASSOC);

if (!$query->rowCount() == 1) {
    header("Location: ./iniciarSesion.php");
}

if (!empty($_POST['titulo']) && !empty($_POST['precio'])) {
    if (strlen($_POST['titulo']) <= 32) {
        if (strlen($_POST['descripcion']) <= 2040) {
            if (1 <= $_POST['precio'] && $_POST['precio'] <= 99999999999) {
                $editar = $conn->prepare("UPDATE `Producto` SET `titulo`=:titulo,`descripcion`=:descripcion,`precio`=:precio,`categoria`=:categoria WHERE id=:id");
                $editar->bindParam('id', $_GET['id']);
                $editar->bindParam('titulo', $_POST['titulo']);
                $editar->bindParam('descripcion', $_POST['descripcion']);
                $editar->bindParam('categoria', $_POST['categoria']);
                $precio = intval($_POST['precio'], 10);
                $editar->bindParam('precio', $precio);
                $editar->execute();
                header("Location: ./miCuenta.php");
            } else {
                $msg = "Precio (min:1 max: 99999999999)";
            }
        } else {
            $msg = "Descripcion demasiado larga (max: 2048)";
        }
    } else {
        $msg = "Titulo demasiado largo (max: 32)";
    }
}
if (isset($msg)) {
    echo "<script>alert('$msg')</script>";
}









?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Merca Livre - Editar Publicacion</title>
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
        <h2>Editar publicacion</h2>
        <form action="./editar.php?id=<?= $_GET['id'] ?>" method="POST" id="editarForm">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Titulo</label>
                <input type="text" class="form-control" maxlength="32" id="formGroupExampleInput2" name="titulo" value="<?= $datos['titulo'] ?>">
            </div>
            <label for="formGroupExampleInput2" class="form-label">Descripción</label>
            <div class="form-floating" style="margin-bottom: 10px !important;">
                <textarea class="form-control" maxlength="2048" id="floatingTextarea" name="descripcion" form="editarForm"><?= $datos['descripcion'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Categoria</label>
                <select class="form-select" aria-label="Default select example" name="categoria">
                    <option value="<?= $datos['categoria'] ?>"><?= $datos['categoria'] ?></option>
                    <option value="Comestibles">Comestibles</option>
                    <option value="Juguetes">Juguetes</option>
                    <option value="Ropa">Ropa</option>
                    <option value="Deportes">Deportes</option>
                    <option value="Autos">Autos</option>
                    <option value="Electrodomesticos">Electrodomesticos</option>
                    <option value="Informatica">Informatica</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Precio</label>
                <input type="number" min="1" max="99999999999" class="form-control" id="formGroupExampleInput2" name="precio" value="<?= $datos['precio'] ?>">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-primary" type="button">Editar</button>
            </div>
        </form>
        <a href="./miCuenta.php" style="text-decoration: none !important;">
            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-outline-danger" type="button" style=" margin-top: 15px;">Cancelar</button>
            </div>
        </a>
    </section>
</body>

</html>