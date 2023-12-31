<?php
require './php/config.php';
if (!isset($_SESSION)) session_start();



$articulo = $conn->prepare("SELECT * FROM `Producto` WHERE id=:id  LIMIT 1");
$articulo->bindParam('id', $_GET['id']);
$articulo->execute();
if ($articulo->rowCount() == 0) {
    header('Location: /');
}
$publicacion = $articulo->fetch(PDO::FETCH_ASSOC);

$usuario = $conn->prepare("SELECT `nombre`FROM `Usuarios` WHERE mail=:mail LIMIT 1");
$usuario->bindParam('mail', $publicacion['mail']);
$usuario->execute();
$nombre = $usuario->fetch(PDO::FETCH_ASSOC);

$chart = $conn->prepare("SELECT `mail` FROM `Carrito` WHERE mail=:mail AND id=:id LIMIT 1");
$chart->bindParam('mail', $_SESSION['mail']);
$chart->bindParam('id', $_GET['id']);
$chart->execute();

$added=($chart->rowCount() == 1);
$owner=($publicacion['mail'] == $_SESSION['mail']);
?>
<script>
    document.title = "Merca Livre - <?= $publicacion['titulo'] ?>";
</script>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
<div>
    <div class="imgContenedor">
        <div class="imgSubcontenedor">
            <img src="./img/placeholder.png" alt="Imagen" class="imgPublicacion">
        </div>
    </div>
    <div class="informacion">
        <div>
            <h2 class="titulo"><?= $publicacion['titulo']; ?></h2>
            <h1 class="precio">$<?= $publicacion['precio']; ?></h1>
            <h4>Publicado por: <?= $nombre['nombre'] ?> </h4>
            <h6>Fecha publicacion:</h6>
            <h6><?= $publicacion['fecha'] ?></h6>
            <?php if ($owner) { ?>
                <a href="./miCuenta.php"><button type="button" class="btn btn-primary" style="margin: 0 51px">Mi cuenta</button></a>
                <?php } else {
                if ($added) { ?>
                    <a href="./carrito.php">
                        <button type="button" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                            </svg>
                            Ver carrito
                        </button>
                    </a>
                <?php } else { ?>
                    <a href="./carrito.php"><button type="button" class="btn btn-primary" onclick="addCart(<?= $_GET['id'] ?>)" style="margin: 0 51px">Añadir al carrito</button></a>
            <?php }
            } ?>
        </div>
    </div>
</div>
<div class="descripcion">
    <h3>Descripcion del Producto</h3>
    <p><?= $publicacion['descripcion'] ?></p>
</div>