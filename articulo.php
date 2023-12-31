<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="./css/articulo.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/article.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <?php require './php/header.php' ?>
    <?php require './php/aside.php' ?>
    <section class="publicacion">
        <?php require './php/publication.php' ?>
    </section>
    <?php require './php/latest.php'?>

    <section class="articulosSection">
        <h3 class="texto">Tambien podria interesarte:</h3>
        <?php
        $cantidad = $conn->prepare("SELECT id FROM `Producto` WHERE id!=:id AND mail!=:mail");
        $cantidad->bindParam('id', $_GET['id']);
        if (isset($_SESSION['mail'])) {
            $mail = $_SESSION['mail'];
        } else {
            $mail = "-";
        }
        $cantidad->bindParam('mail', $mail);
        $cantidad->execute();
        $idProductos = $cantidad->fetchAll(PDO::FETCH_ASSOC);
        $numbers = array();
        array_push($numbers, random_int(1, ($cantidad->rowCount() - 1)));
        for ($i = 0; $i < 7; $i++) {
            $newNum = random_int(1, ($cantidad->rowCount() - 1));
            array_push($numbers, $newNum);
        }




        for ($i = 0; $i < 8; $i++) {
            $records = $conn->prepare("SELECT id,titulo,precio,categoria FROM `Producto` WHERE id=:id");
            $records->bindParam('id', $idProductos[$numbers[$i]]['id']);
            $records->execute();
            $elementos = $records->fetch(PDO::FETCH_ASSOC);

        ?>
            <a href="./articulo.php?id=<?= $elementos['id'] ?>" class="aPublicacion">
                <article class="elemento">
                    <img src="./img/placeholder.png" alt="Imagen del articulo" class="imgArticulo">
                    <div>
                        <h4 class="tPublicacion"><?= $elementos['titulo'] ?></h4>
                        <h6 class="tPublicacion"><?= $elementos['categoria'] ?></h6>
                        <h3 class="tPublicacion">$<?= $elementos['precio'] ?></h3>
                    </div>
                </article>
            </a>
        <?php } ?>
    </section>

</body>

</html>
<?php require './php/addLatest.php' ?>