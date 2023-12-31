<?php
session_start();
require 'config.php';
if (!isset($_SESSION['nombre'])) {
    header("Location: ./iniciarSesion.php");
}
$query = $conn->prepare("SELECT `id`, `mail` FROM `Producto` WHERE id=:id AND mail=:mail LIMIT 1");
$query->bindParam('id',$_POST['id']);
$query->bindParam('mail',$_SESSION['mail']);
$query->execute();
if($query->rowCount()==1){
    // echo $_POST['id'];
    $delete = $conn->prepare("DELETE FROM `Producto` WHERE id=:id");
    $delete->bindParam('id',$_POST['id']);
    $delete->execute();
}
?>