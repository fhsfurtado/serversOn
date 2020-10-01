
<?php
    $advice = NULL;
    $msg = NULL;
    if(isset($_GET['status'])){
        $status = $_GET['status'];
        if($status == 'add_ok'){
            $advice = '<div class="alert alert-success" role="alert"> Servidor adicionado com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
        if($status == 'add_fail'){
            $advice = '<div class="alert alert-danger" role="alert"> Ops! Ocorreu algum erro... <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
        if($status == 'rem_ok'){
            $advice = '<div class="alert alert-warning" role="alert"> Servidor inativado com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
        if($status == 'rem_fail'){
            $advice = '<div class="alert alert-danger" role="alert"> Ops! Ocorreu algum erro... <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
        if($status == 'edt_ok'){
            $advice = '<div class="alert alert-success" role="alert"> Servidor editado com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
        if($status == 'edt_fail'){
            $advice = '<div class="alert alert-danger" role="alert"> Ops! Ocorreu algum erro... <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
    }
//require('session.php');
require('isMobile.php');
header("Refresh: 120; url=index.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Status dos Servidores</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Fabio Henrique Silva furtado" content="">

    <link rel="shortcut icon" href="http://www.logos-ma.com.br/portal/imagem/favicon.gif" type="image/x-icon" />
    <!-- jQuery Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Page level plugin CSS-->
    <link rel="stylesheet" type="text/css" href="vendor/DataTables/datatables.min.css"/>
 
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">

    <style type="text/css">
        body{
            background: #ddd9ce;
        }
        nav{
            background-color: red;
            height: 80px;
        }
        #sidebar{
            background: #ADADAD;
        }
        #content{
            text-align: center;
        }
        #pesquisa{
            position: fixed;
            right: 0%;
        }
        .footer{
            position:fixed;
            bottom:0;
            width:100%;
            background-color: black;
        }
        hr{
            border-color: #aaa;
            box-sizing:border-box;
            width:100%;  
        }
        .loading{
    	position: absolute;
	    left: 25%;
	    top: 25%;
	    width: 50%;
	    height: 50%;
	    z-index: 9999;
	    }
        .details-text{
            left: 20%;
            right: 20%
        }    
     </style> 
</head>
<body>
    <div id="sidebar">
        <nav class="navbar navbar-expand static-top" role="navigation">
            <a class="navbar-brand" href="index.php"><img src="http://www.logos-ma.com.br/portal/imagem/logos.png" width="110" class="d-inline-block align-top" alt="MetodistaSLZ"></a>
            <div class="btn-group btn-group-sm" role="group" aria-label="Menu IMSLZ-CMS">
                
            </div> 
        </nav>
        <?php
            echo $advice;
        ?>
    </div>
    <div class="container" id="actions"></br>
        <div id="show"  align="left" style="left: 1%;">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radioOptions" id="radioOptions" value="all" checked>
                <label class="form-check-label" for="exampleRadios1">
                    Todos
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radioOptions" id="radioOptions" value="ativo">
                <label class="form-check-label" for="exampleRadios2">
                    Online
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radioOptions" id="radioOptions" value="inativo">
                <label class="form-check-label" for="exampleRadios3">
                    Offline
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radioOptions" id="radioOptions" value="windows">
                <label class="form-check-label" for="exampleRadios4">
                    Windows
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radioOptions" id="radioOptions" value="linux">
                <label class="form-check-label" for="exampleRadios5">
                    Linux
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radioOptions" id="radioOptions" value="other">
                <label class="form-check-label" for="exampleRadios5">
                    Outros
                </label>
            </div>
        </div>
        <div id="add"  align="right" style="right: 1%;">
            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAddServer"><i class="fas fa-plus-circle"> Adicionar Server</i> </button>
        </div>
    </div></br>
    <div class="container" align="center" id="content">
        <div class="row align-content-center">
            <?php
            //capturar os servers já cadastrados
            require_once('connect.php');
            $stmt = $bd->prepare('SELECT * FROM tb_internal_servers WHERE status_server = 1');
            $stmt->execute();
            $servers = $stmt->fetchAll(PDO::FETCH_OBJ);
            if($stmt->rowCount()==0){
                $msg = '<div class="alert alert-info justify-content-center text-center" role="alert"> Sem servidores cadastrados/ativos!</div>';
            }

            foreach($servers as $server){
                $ip = $server->ip_address;
                $output = '';
                $result = '';
                $state = '';
                $stOnOff = '';
                $tipo= '';
                $image = '<i class="fas fa-question-circle fa-3x"></i>';
                $distro= '';
                exec("ping -n 1 -w 1 ".$ip,$output,$result);
                if ($result == 0) {
                    $state = '<span class="btn badge badge-pill badge-success" data-toggle="modal" data-target="#modalPorts'.$server->id_server.'">Server ON</span>';
                    $stOnOff = 'ativo';
                } else {
                    $state = '<span class="badge badge-pill badge-danger">Server OFF</span>';
                    $stOnOff = 'inativo';
                }
                @$distro = str_replace("=","",substr($output[2],-3));
                if($distro=='128'){
                    $image = '<i class="fab fa-windows fa-3x"></i>';
                    $tipo = 'windows';
                }
                if($distro=='64'){
                    $image = '<i class="fab fa-linux fa-3x"></i>';
                    $tipo = 'linux';
                }
                if($distro=='255'){
                    $image = '<i class="fas fa-microchip fa-3x"></i>';
                    $tipo = 'other';
                }
                echo '<div class="card '.$stOnOff.' col-lg-4 '.$tipo.'" align="center"></br></hr>';
                    echo $image;
                    echo '<div class="card-body">';
                        echo '<h5 class="card-title">'.$server->hostname.'</h5>';
                        echo '<p class="card-text">'.$state.'</p>';
                        echo '<div class="card-footer">';
                            echo '<div class="btn-group" role="group" aria-label="Botões de Ação">';
                                echo '<a class="btn btn-danger" href="remServer.php?id='.$server->id_server.'" data-toggle="tooltip" data-placement="bottom" title="Inativar Servidor"><i class="fas fa-trash"></i></a>';
                                echo '<a class="btn btn-primary" href="edtServer.php?id='.$server->id_server.'" data-toggle="tooltip" data-placement="bottom" title="Editar info"><i class="fas fa-edit"></i></a>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div></br>
    <div class="container" style="width: 100%">
            <?php echo $msg;?>
    </div>
    <div class="footer">
        <div class="container">
            <p class="m-0 text-center text-white small">2020 - Powered by  <img src="http://www.logos-ma.com.br/portal/imagem/logos.png" width="60" alt=""> &copy;</p>
        </div>
    </div>
<!-- LISTA DE MODAIS -->
<!-- INICIO MODAL ADD SERVER-->
<div class="modal" id="modalAddServer" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Servidor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
         <form name="newHost" id="newHost" action="addServer.php" method="POST">
            <div class="modal-body" align="center">
                <div class="container">
                    <div class="row">
                        <div class="col form-group">
                            <label for="nome">Nome do Host:</label>
                            <input type="text" class="form-control" name="inputHostname" id="inputHostname" aria-describedby="inputHostname" placeholder="Entre com o nome do Host" required>
                        </div>
                        <div class="col form-group">
                            <label for="nome">IP do Host:</label>
                            <input type="text" class="form-control" name="inputIP" id="inputIP" aria-describedby="inputIP" placeholder="Entre com o IP do Host" min="8" max="24" required>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col form-group"></hr>
                            <label for="btnAddPorta">Testar Portas:</label>
                            <input type="hidden" name="qtdeAdd" id="qtdeAdd" value="0">
                            
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div id="divPorta" class="card col-lg-6 justify-content-center">
                        <label for="port">Porta: </label>
                        <input type="hidden" name="json" id="json">
                        <select name="selPortas" id="selPortas">
                            <?php
                            $qr = $bd->prepare('SELECT * from tb_name_port');
                            $qr->execute();
                            $nameports = $qr->fetchAll(PDO::FETCH_OBJ);
                            foreach($nameports as $nmp){
                                echo'<option value="'.$nmp->id_name_port.'">'.$nmp->nome_port.'</option>';
                            }
                            ?>
                        </select>
                        <input type="tel" name="inputPortas" id="inputPortas" onkeypress="fMasc(this,mNum);"></br>
                        <a class="btn btn-outline-primary" onclick="addPorta();">Add Porta</a>
                    </div>
                </div></br>
                <div width="100%" class="row justify-content-center" align="left">
                    <label for="valores">Portas adicionadas:</label>
                </div>
                <div id="valores" name="valores" width="100%" class="row justify-content-center" align="left">
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-warning">Limpar</button>
                <button type="submit" class="btn btn-outline-primary">Salvar</button>
            </div>
         </form>
        </div>
    </div>
</div>
<!-- FIM MODAL ADD SERVER-->
<!-- INICIO MODAL VER PORTAS-->
<?php
    foreach($servers as $server){
        $query = $bd->prepare('SELECT * FROM tb_ports WHERE id_server = :id');
        $query->bindParam(':id',$server->id_server);
        $nm = $bd->prepare('SELECT * FROM tb_name_port');
        $nm->execute();
        $names_port = $nm->fetchAll(PDO::FETCH_OBJ);
        $query->execute();
        $ports = $query->fetchAll(PDO::FETCH_OBJ);
        echo '<div class="modal" id="modalPorts'.$server->id_server.'" tabindex="-1" role="dialog">';
            echo '<div class="modal-dialog modal-lg" role="document">';
                echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                        echo '<h5 class="modal-title">Servidor: '.$server->hostname.' ('.$server->ip_address.')</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                    echo '</div>';
                    echo '<div class="modal-body" align="center">';
                        echo '<div class="container">';
                            if($query->rowCount()==0){
                                echo '<div class="row">';
                                    echo '<div class="col form-group">';
                                        echo '<p>Não há portas sendo monitoradas!</p>';
                                    echo '</div>';
                                echo '</div>';
                            } else{
                                foreach($ports as $port){
                                    $fp = NULL;
                                    $name = NULL;
                                    foreach($names_port as $name_port){
                                        if($name_port->id_name_port == $port->port_name){
                                            $name = $name_port->nome_port;
                                        }
                                    }
                                    $fp = @fsockopen($server->ip_address, $port->port, $errno, $errstr, 1);
                                    if($fp >= 1){
                                        echo '<div class="row">';
                                            echo '<div class="col form-group">';
                                                echo '<button type="button" class="btn btn-success" style="width: 13rem;">';
                                                    echo $name.' : '.$port->port.' <span class="badge badge-light">UP</span>';
                                                echo '</button>';
                                            echo '</div>';
                                        echo '</div>';
                                    } else {
                                        echo '<div class="row">';
                                            echo '<div class="col form-group">';
                                                echo '<button type="button" class="btn btn-danger" style="width: 13rem;">';
                                                    echo $name.' : '.$port->port.' <span class="badge badge-light">DOWN</span>';
                                                echo '</button>';
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
?>

<!-- FIM MODAL VER PORTAS-->
<script>
    $('input[name="radioOptions"]').change(function () {
      if ($('input[name="radioOptions"]:checked').val() === "all") {
          $('.ativo').show();
          $('.inativo').show();
          $('.windows').show();
          $('.linux').show();
          $('.other').show();
      }
      if ($('input[name="radioOptions"]:checked').val() === "ativo") {
          $('.ativo').show();
          $('.inativo').hide();
      }
      if ($('input[name="radioOptions"]:checked').val() === "inativo") {
          $('.ativo').hide();
          $('.inativo').show();
      }
      if ($('input[name="radioOptions"]:checked').val() === "windows") {
          $('.ativo').hide();
          $('.inativo').hide();
          $('.windows').show();
          $('.linux').hide();
          $('.other').hide();
      }
      if ($('input[name="radioOptions"]:checked').val() === "linux") {
          $('.ativo').hide();
          $('.inativo').hide();
          $('.windows').hide();
          $('.linux').show();
          $('.other').hide();
      }
      if ($('input[name="radioOptions"]:checked').val() === "other") {
          $('.ativo').hide();
          $('.inativo').hide();
          $('.windows').hide();
          $('.linux').hide();
          $('.other').show();
      }
    });
    i=0;
    function addPorta() {
        var divAtual  = document.querySelector('#valores');
        var divTemp = divAtual.innerHTML;
        var divNova = '<div name="cardPorta'+i+'" id="cardPorta'+i+'" class="card form-group" style="width: 12rem;"><input type="text" name="dataNome'+ i +'" id="dataNome'+ i +'" class="form-control" value="'+ $('#selPortas option:selected').text() +'"><input type="hidden" name="hiddenDataNome'+ i +'" id="hiddenDataNome'+ i +'" class="form-control" value="'+ document.getElementById('selPortas').value +'"><input type="text" name="dataPorta'+ i +'" id="dataPorta'+ i +'" class="form-control" value="'+ document.getElementById('inputPortas').value +'"><a class="btn btn-outline-danger" onclick="removeLinha(this)"><i class="fas fa-trash"></i></a></div>';
        i++;
        divTemp = divNova + divTemp;
        divAtual.innerHTML = divTemp;
        document.getElementById('selPortas').value = '1';
        document.getElementById('inputPortas').value = '';
        document.getElementById('qtdeAdd').value = i;
        
        var form = document.getElementById('newHost');
        console.log(i);
    }
    function removeLinha(item) {
        item.parentNode.outerHTML = '';
        i--;
    }
    $("#newHost").submit(function() {
        document.getElementById('selPortas').value = '1';
        document.getElementById('inputPortas').value = '';
        document.getElementById('newHost').submit();
  });
</script>
</body>
<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</html>