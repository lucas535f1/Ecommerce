<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['mail'])) {
    $records = $conn->prepare("SELECT Producto.id, Producto.titulo, Producto.categoria, Producto.precio FROM Producto INNER JOIN UltimosVistos ON Producto.id=UltimosVistos.id WHERE UltimosVistos.mail=:mail ORDER BY UltimosVistos.fecha DESC");
    $records->bindParam('mail', $_SESSION['mail']);
    $records->execute();
    $ultimos = $records->fetchAll(PDO::FETCH_ASSOC);
?>
    <section class="ultimoSection">
        <div class="cabezal">
            <h3>Ultimos vistos:</h3>
        </div>
        <?php foreach ($ultimos as $items) { ?>
            <a href="./articulo.php?id=<?= $items['id'] ?>" class="aPublicacion">
                <article class="elemento">
                    <img src="./img/placeholder.png" alt="Imagen del articulo" class="imgArticulo">
                    <div>
                        <h4 class="tPublicacion"><?= $items['titulo'] ?></h4>
                        <h6 class="tPublicacion"><?= $items['categoria'] ?></h6>
                        <h3 class="tPublicacion">$<?= $items['precio'] ?></h3>
                    </div>
                </article>
            </a>
    <?php }
    } ?>

    </section>