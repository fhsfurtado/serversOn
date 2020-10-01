<?php
    try{
        $bd = new PDO('mysql:host=localhost;dbname=logoservers', "root", "");
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo 'ERRO: ', $e->getMessage();
    }
?>
