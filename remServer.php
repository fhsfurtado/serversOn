<?php
    /*function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }*/
    require_once('connect.php');
    $alert=NULL;

    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $stmt = $bd->prepare('UPDATE tb_internal_servers SET status_server = 0 WHERE id_server = :id ');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        header('Location: index.php?status=rem_ok');
    } else{
        header('Location: index.php?status=rem_fail');
    }    
?>