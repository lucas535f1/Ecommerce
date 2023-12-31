<?php
session_start();
require 'config.php';
if (!isset($_SESSION['nombre'])) {
    header("Location: ./iniciarSesion.php");
}
$query = $conn->prepare("INSERT INTO `Carrito`(`mail`, `id`) VALUES ( :mail,:id )");
$query->bindParam('mail',$_SESSION['mail']);
$query->bindParam('id',$_POST['id']);
$query->execute();
?>