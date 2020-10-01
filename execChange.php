<?php
    require('connect.php');
    require('isMobile.php');
    var_dump($_POST);
   
if(isset($_POST)){
        $hostname = $_POST['inputHostname'];
        $ip = $_POST['inputIP'];
        $idServer = $_POST['inputID'];
        $stmt = $bd->prepare('UPDATE tb_internal_servers SET hostname = :hostname, ip_address = :ip WHERE id_server = :id');
        $stmt->bindParam(':hostname',$hostname);
        $stmt->bindParam(':ip',$ip);
        $stmt->bindParam(':id',$idServer);
        $stmt->execute();
        $qtde =  $_POST['qtdeAdd'];
        $x = 0;
        $y = 0;
        $stmt = $bd->prepare('DELETE FROM tb_ports WHERE id_server = :id');
        $stmt->bindParam(':id',$idServer);
        $stmt->execute();
        while($x<$qtde){
            if(isset($_POST['hiddenDataNome'.$y])&&isset($_POST['hiddenDataPorta'.$y])){
                $stmt = $bd->prepare('INSERT INTO tb_ports (id_server,port_name,port) VALUES (:id,:port_name,:port)');
                $stmt->bindParam(':port_name',$_POST['hiddenDataNome'.$y]);
                $stmt->bindParam(':port',$_POST['hiddenDataPorta'.$y]);
                $stmt->bindParam(':id',$idServer);
                $stmt->execute();
                $x++;
            }
            $y++;
        }

        header('Location: index.php?status=edit_ok');
    } else{
        header('Location: index.php?status=edit_fail');
    }
?>