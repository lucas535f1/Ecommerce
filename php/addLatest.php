<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['mail']) && $_SESSION['mail']!= $publicacion['mail']) {
    require './php/config.php';

    $query = $conn->prepare("SELECT `id` FROM `UltimosVistos` WHERE mail=:mail ORDER BY fecha ASC");
    $query->bindParam('mail', $_SESSION['mail']);
    $query->execute();
    $vistos = $query->fetchAll(PDO::FETCH_ASSOC);

    $repetido = $conn->prepare("SELECT `id` FROM `UltimosVistos` WHERE mail=:mail AND id=:id ORDER BY fecha ASC");
    $repetido->bindParam('mail', $_SESSION['mail']);
    $repetido->bindParam('id', $_GET['id']);
    $repetido->execute();
    if ($repetido->rowCount() == 0) {
        if ($query->rowCount() == 5) {
            $remove = $conn->prepare("DELETE FROM `UltimosVistos` WHERE id=:id ");
            $remove->bindParam('id', $vistos[0]['id']);
            $remove->execute();
        }

        $add = $conn->prepare("INSERT INTO `UltimosVistos`(`id`, `mail`) VALUES (:id,:mail)");
        $add->bindParam('id', $_GET['id']);
        $add->bindParam('mail', $_SESSION['mail']);
        $add->execute();
    }
}
