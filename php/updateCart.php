    <h3 class="texto">Mi carrito</h3>
    <?php
    if (!isset($_SESSION)) session_start();
    require 'config.php';
    $query = $conn->prepare("SELECT Producto.id, Producto.titulo, Producto.categoria, Producto.precio, Carrito.fecha FROM Producto INNER JOIN Carrito ON Producto.id=Carrito.id WHERE Carrito.mail=:mail ORDER BY Carrito.fecha DESC");
    $query->bindParam('mail', $_SESSION['mail']);
    $query->execute();
    if ($query->rowCount() == 0) {
    ?>
        <h4 class="texto" style="text-align: center;">No hay articulos en el carrito</h4>

    <?php
    } else {
        $publicaciones = $query->fetchAll(PDO::FETCH_ASSOC);
        $total = 0;
        foreach ($publicaciones as $item) {
            $total += $item['precio'];
        }
    ?>

        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="./js/main.js"></script>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Imagen</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Fecha de agregacion</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($publicaciones as $elemento) {
                ?>
                    <tr>

                        <th><a href=./articulo.php?id=<?= $elemento['id'] ?> class="aTabla"><img src="./img/placeholder.png" class="previewIMG"></a></th>
                        <td><a href=./articulo.php?id=<?= $elemento['id'] ?> class="aTabla"><?= $elemento['titulo'] ?></a></td>
                        <td><?= $elemento['categoria'] ?></td>
                        <td>$<?= $elemento['precio'] ?></td>
                        <td><?= $elemento['fecha'] ?></td>
                        <td class="trash">
                            <button type="button" class="btn btn-danger" onclick="deleteCart(<?= $elemento['id'] ?>)" style="margin:auto;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
        </table>
        <div class="pie">
            <h4 class="coso"><?= $query->rowCount() ?> articulos</h4>
            <div>
            <h4 class="coso">Total: $<?= $total ?></h4>
            <a href="https://www.tenfield.com.uy/rampla-juniors-nacional/"><button type="button" class="btn btn-success">Comprar</button></a>
            </div>
        </div>
    <?php
    }
    ?>