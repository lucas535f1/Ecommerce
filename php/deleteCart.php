<?php
session_start();
require 'config.php';
if (!isset($_SESSION['nombre'])) {
    header("Location: ./iniciarSesion.php");
}
$query = $conn->prepare("DELETE FROM `Carrito` WHERE id=:id AND mail=:mail");
$query->bindParam('id',$_POST['id']);
$query->bindParam('mail',$_SESSION['mail']);
$query->execute();
echo"se ejecuta";
?>