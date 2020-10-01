<?php
    /*function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }*/
    require_once('connect.php');
    $alert=NULL;
    $qtde = NULL;
    $i = NULL;
    $nomePorta = NULL;
    $porta = NULL;
    
    if(isset($_POST)){
        $hostname=$_POST['inputHostname'];
        $ip=$_POST['inputIP'];
        $stmt = $bd->prepare('INSERT INTO tb_internal_servers(id_creator,hostname,ip_address,status_server) VALUES (1,:hostname,:ip,1)');
        $stmt->bindParam(':hostname',$hostname);
        $stmt->bindParam(':ip',$ip);
        $stmt->execute();
        $stmt = $bd->prepare('SELECT id_server FROM tb_internal_servers WHERE hostname = :hostname AND ip_address = :ip');
        $stmt->bindParam(':hostname',$hostname);
        $stmt->bindParam(':ip',$ip);
        $stmt->execute();
        $server = $stmt->fetch();
        if($_POST['qtdeAdd']>=0){
            $qtde = $_POST['qtdeAdd']-1;
            for($i=0;$i<=$qtde;$i++){
                $nomePorta = $_POST['hiddenDataNome'.$i];
                $porta = $_POST['dataPorta'.$i];
                $id = $server['id_server'];
                $stmt = $bd->prepare('INSERT INTO tb_ports(id_server,port_name,port) VALUES (:id,:nomePorta,:port)');
                $stmt->bindParam(':id',$id);
                $stmt->bindParam(':nomePorta',$nomePorta);
                $stmt->bindParam(':port',$porta);
                $stmt->execute();
            }
        }
        header('Location: index.php?status=add_ok');
    } else{
        header('Location: index.php?status=add_fail');
    }
?>