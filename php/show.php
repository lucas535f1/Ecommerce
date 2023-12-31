<script>
    window.scrollTo(0, 0);
</script>
<?php

if (!isset($_GET['pagina'])) {
    $_GET['pagina'] = 1;
}
if (!isset($_POST['criterio'])) {
    $_POST['criterio'] = 'fecha';
}

if (!isset($_POST['orden'])) {
    $_POST['orden'] = 'DESC';
}


$criterio = $_POST['criterio'];
$orden = $_POST['orden'];
if ($orden == "DESC") {
    $isDESC = false;
} else {
    $isDESC = true;
}

$select['value'][0] = "fecha";
$select['value'][1] = "precio";
$select['value'][2] = "titulo";
$select['content'][0] = "Fecha";
$select['content'][1] = "Precio";
$select['content'][2] = "Titulo";


switch ($_POST['criterio']) {
    case "fecha":
        $selected[0] = 0;
        $selected[1] = 1;
        $selected[2] = 2;
        break;
    case "precio":
        $selected[0] = 1;
        $selected[1] = 0;
        $selected[2] = 2;
        break;
    case "titulo":
        $selected[0] = 2;
        $selected[1] = 0;
        $selected[2] = 1;
        break;
}

$url = "./";
if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    $url = $url . "?categoria=" . $_GET['categoria'];
    $urlPaginas = $url . "&pagina=";
} else {
    $categoria = "null";
    $urlPaginas = $url;
}

if (isset($_GET['categoria'])) {
    $urlPaginas = $url . "&pagina=";
} else {
    $urlPaginas = $url . "?pagina=";
}

if ($categoria != "null") {
    $cantidadSQL = $conn->prepare("SELECT `id` FROM `Producto` WHERE categoria=:categoria");
    $cantidadSQL->bindParam(':categoria', $categoria);
} else {
    $cantidadSQL = $conn->prepare("SELECT `id` FROM `Producto`");
}
$cantidadSQL->execute();
$cantidad = $cantidadSQL->rowCount();

if ($_GET['pagina'] == 1) {
    $valor = 0;
    if ($cantidad <= 25) {
        $mostrando = "Mostrando " . $cantidad . " resultados";
    } else {
        $mostrando = "Mostrando 25 resultados de " . $cantidad;
    }
} else {
    $valor = ($_GET['pagina'] * 25) - 25;
    if (($cantidad - $_GET['pagina'] * 25) < 0) {
        $mostrando = "Mostrando " . $_GET['pagina'] * 25 - $cantidad + 1 . " resultados de " . $cantidad;
    } else {

        $mostrando = "Mostrando 25 resultados de " . $cantidad;
    }
}
$urlCat = substr($url, 2);

if (isset($_GET['categoria'])) {
    $records = $conn->prepare("SELECT id,titulo,precio,categoria FROM `Producto` WHERE categoria=:categoria ORDER BY $criterio $orden");
    $records->bindParam(':categoria', $categoria);
} else {
    $records = $conn->prepare("SELECT `id`,`titulo`,`precio`,`categoria` FROM `Producto` ORDER BY $criterio $orden");
}
if (isset($msg)) {
    echo "<script>alert('$msg')</script>";
}
$records->execute();
$results = $records->fetchALL(PDO::FETCH_ASSOC);
?>
<div class="cantidad">
    <label><?= $mostrando ?></label>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
<div class="cabezal">
    <h3 class=" publicaciones">Publicaciones:</h3>
    <div class="cosoRaro">
        <form method="POST">
            <?php if (isset($_GET['categoria'])) { ?>
                <label for="formGroupExampleInput2" class="form-label">Filtro:</label>
                <a href="./">
                    <button type="button" class="btn btn-outline-secondary"><?= $_GET['categoria'] ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </button>
                </a> <?php } ?>
            <label for="formGroupExampleInput2" class="form-label">Ordenar por:</label>
            <select class="form-select criterio" name="criterio" id="criterio" onchange="prueba('<?= $urlCat ?>')" aria-label="Default select example">
                <option value="<?= $select['value'][$selected[0]] ?>"><?= $select['content'][$selected[0]] ?></option>
                <option value="<?= $select['value'][$selected[1]] ?>"><?= $select['content'][$selected[1]] ?></option>
                <option value="<?= $select['value'][$selected[2]] ?>"><?= $select['content'][$selected[2]] ?></option>
            </select>
            <div class="btn-group orden" name="orden" id="orden">
                <input type="radio" class="btn-check " name="orden" id="success-outlined" autocomplete="off" <?php if (!$isDESC) { ?> checked disabled <?php } ?> value="DESC" onclick="prueba('<?= $urlCat ?>')">
                <label class="btn btn-outline-secondary" for="success-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
                        <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707V12.5zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                    </svg>
                </label>

                <input type="radio" class="btn-check" name="orden" id="danger-outlined" autocomplete="off" value="ASC" <?php if ($isDESC) { ?> checked disabled <?php } ?> onclick="prueba('<?= $urlCat ?>')">
                <label class="btn btn-outline-secondary" for="danger-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                        <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"></path>
                    </svg>
                </label>
            </div>
        </form>
    </div>

</div>
</div>
<?php for ($f = $valor; $f < $valor + 25 & $f < $cantidad; $f++) { ?>
    <a href="./articulo.php?id=<?= $results[$f]['id'] ?>" class="aPublicacion">
        <article class="elemento">
            <img src="./img/placeholder.png" alt="Imagen del articulo" class="imgArticulo">
            <div>
                <h4 class="tPublicacion"><?= $results[$f]['titulo'] ?></h4>
                <h6 class="tPublicacion"><?= $results[$f]['categoria'] ?></h6>
                <h3 class="tPublicacion">$<?= $results[$f]['precio'] ?></h3>
            </div>
        </article>
    </a>
<?php }
$urlJs = substr($urlPaginas, 3);
if ($cantidad > 25) { ?>
    <div class="paginas">
        <?php for ($i = 1; $i <= ($cantidad / 25) + 1; $i++) {
            if ($_GET['pagina'] == $i) {
                $disabled = true;
            } else {
                $disabled = false;
            }
        ?>
            <button <?php if ($disabled) { ?>disabled class="btn btn-primary btn-sm" <?php } else { ?> class="btn btn-outline-primary btn-sm" <?php } ?>type="button" style="width: 30x;" onclick="pagina('<?= $criterio ?>','<?= $orden ?>','<?= $urlJs ?>','<?= $i ?>')"><?= $i ?></button>
        <?php } ?>
    </div>
<?php }
//  $msg = var_dump($_POST);
if (isset($msg)) {
    echo "<script>alert('$msg')</script>";
}
?>