<?php
session_start();
require './php/config.php';

if (!isset($_SESSION['nombre'])) {
    header("Location: ./iniciarSesion");
}
if (isset($_SESSION['nombre'])) {
    if (!empty($_POST['titulo']) && !empty($_POST['precio'])) {
        if (strlen($_POST['titulo']) <= 32) {
            if (strlen($_POST['descripcion']) <= 2047) {
                $query = $conn->prepare("INSERT INTO `Producto`( `mail`, `titulo`, `descripcion`, `precio`, `categoria`) VALUES ( :mail, :titulo, :descripcion, :precio , :categoria)");
                $query->bindParam('mail', $_SESSION['mail']);
                $query->bindParam('titulo', $_POST['titulo']);
                $query->bindParam('descripcion', $_POST['descripcion']);
                $precio = intval($_POST['precio'], 10);
                $query->bindParam('precio', $precio);
                $query->bindParam('categoria', $_POST['categoria']);
                if ($query->execute()) {
                    $query = $conn->prepare("SELECT id FROM Producto ORDER BY id DESC LIMIT 1");
                    $query->execute();
                    $id = $query->fetch(PDO::FETCH_ASSOC);
                    header("Location: ./articulo.php?id={$id['id']}");
                } else {
                    $msg =  'Error sql';
                }
            } else {
                $msg =  'Descripción demasiada larga (max: 255)';
            }
        } else {
            $msg =  'Titulo demasiado largo (max: 32)';
        }

        if (isset($msg)) {
            echo "<script>alert('$msg')</script>";
        }
    }
} else {
    header('Location: /iniciarSesion.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Merca Livre - Publicar</title>--
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
        <h2>Publicar</h2>
        <form action="./publicar.php" method="POST">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Titulo</label>
                <input type="text" maxlength="32" class="form-control" id="formGroupExampleInput2" name="titulo">
            </div>
            <label for="formGroupExampleInput2" class="form-label">Descripción</label>
            <div class="form-floating" style="margin-bottom: 10px !important;">
                <textarea class="form-control" maxlength="2048" id="floatingTextarea" name="descripcion"></textarea>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Categoria</label>
                <select class="form-select" aria-label="Default select example" name="categoria">
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
                <input type="number" min="1" max="99999999999" class="form-control" id="formGroupExampleInput2" name="precio">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-primary" type="button">Publicar</button>
            </div>
        </form>
    </section>
</body>

</html>