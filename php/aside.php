<aside>
    <div class="d-grid gap-2">
        <a href="./publicar.php"><button type="button" class="btn btn-primary publicar" style="margin: 0 51px">Publicar</button></a>
        <?php
        if (isset($_SESSION['nombre'])) {
        ?>
            <a href="./miCuenta.php"><button type="button" class="btn btn-primary publicar" style="margin: 0 45px; margin-top: 20px;">Mi cuenta</button></a>
        <?php
        }
        ?>
        <div class="d-grid gap-2">
            <h4 class=" tituloCategorias">Categorias</h4>
            <ul class="list-group categorias">
                <li class="list-group-item"><a href="./?categoria=Comestibles">Comestibles</a></li>
                <li class="list-group-item"><a href="./?categoria=Juguetes">Juguetes</a></li>
                <li class="list-group-item"><a href="./?categoria=Ropa">Ropa</a></li>
                <li class="list-group-item"><a href="./?categoria=Deportes">Deportes</a></li>
                <li class="list-group-item"><a href="./?categoria=Autos">Autos</a></li>
                <li class="list-group-item"><a href="./?categoria=Electrodomesticos">Electrodomesticos</a></li>
                <li class="list-group-item"><a href="./?categoria=Informatica">Informatica</a></li>
                <li class="list-group-item"><a href="./?categoria=Otros">Otros</a></li>
            </ul>
</aside>