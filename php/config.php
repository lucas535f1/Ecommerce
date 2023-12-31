<?php

    $server = "localhost";
    $username = "lucas";
    $password = "poaAcademyLucas1#";
    $db = "lucas";

    try{
        $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    }catch (PDOException $e){
        die($e);
    }   

?>