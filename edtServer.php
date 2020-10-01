<?php
    $i = 0;
    require('connect.php');
    require('isMobile.php');
    if(@$_GET['id']){
        $id = $_GET['id'];
        $stmt = $bd->prepare('SELECT * FROM tb_internal_servers WHERE id_server = :id');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $server = $stmt->fetch();
        // capturando as portas monitoradas para o server
        $queryserver = $bd->prepare('SELECT p.id_server, p.port_name, p.port, n.id_name_port, n.nome_port FROM tb_ports as p, tb_name_port as n WHERE p.port_name = n.id_name_port AND p.id_server = :id');
        $queryserver->bindParam(':id',$id);
        $queryserver->execute();
        $results = $queryserver->fetchAll(PDO::FETCH_OBJ);
        $cont = $queryserver->rowCount();
        // capturando os nomes das portas
        $querynome = $bd->prepare('SELECT * FROM tb_name_port');
        $querynome->execute();
        $nomes = $querynome->fetchAll(PDO::FETCH_OBJ);
        
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Servidor</title>
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

    <script>
        function fMasc(objeto,mascara) {
				obj=objeto
				masc=mascara
				setTimeout("fMascEx()",1)
		}
		function fMascEx() {
				obj.value=masc(obj.value)
		}
        function mNum(num){
				num=num.replace(/\D/g,"");
				return num;
			}
    </script>

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
            border-color:#aaa;
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
        .cardPorta{
            margin: 1px;
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
    </div></br>
    <div class="container align-content-center text-center" align="center" id="content">
        <form name="editSv" id="editSv" action="execChange.php" method='POST'>
            <div class="row">
                <input type="hidden" id="qtdeAdd" name="qtdeAdd" value="<?php echo $cont;?>">
                <div class="col-lg-12 form-group">
                    <label for="nome">Nome do Host:</label>
                    <input type="text" class="form-control" value="<?php echo $server['hostname']?>" name="inputHostname" id="inputHostname" aria-describedby="inputHostname" placeholder="Entre com o nome do Host" required>
                </div>
                <div class="col-lg-12 form-group">
                    <label for="nome">IP do Host:</label>
                    <input type="text" class="form-control" value="<?php echo $server['ip_address']?>" name="inputIP" id="inputIP" aria-describedby="inputIP" placeholder="Entre com o IP do Host" min="8" max="24" required>
                </div><hr>
            </div>
            <div class="row justify-content-center">
                <div id="divPorta" class="card col-lg-6 justify-content-center">
                    <label for="port">Porta: </label>
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
                    <input type="tel" name="inputPortas" id="inputPortas" value="" onkeypress="fMasc(this,mNum);"></br>
                    <a id="btnAddPorta" class="btn btn-outline-primary">Adicionar Porta</a></br>
                </div>
                </br>
            </div>
            <hr/></br>
            <div class="container">
                <div id="portlist" id="portlist" class="row form-group justify-content-center" width="100%" align="center">
                    <?php
                        foreach($results as $result){
                            echo '<div name="cardPorta'.$i.'" id="cardPorta'.$i.'" class="card form-group cardPorta" style="width: 20%;">';
                            foreach($nomes as $nome){
                                if($nome->id_name_port == $result->id_name_port){
                                    echo '<input type="text" name="dataNome'.$i.'" id="dataNome'.$i.'" class="form-control" value="'.$nome->nome_port.'" disabled><input type="hidden" name="hiddenDataNome'.$i.'" id="hiddenDataNome'.$i.'" class="form-control" value="'.$nome->id_name_port.'">';
                                }
                            }
                            echo '<input type="text" name="dataPorta'.$i.'" id="dataPorta'.$i.'" class="form-control" value="'.$result->port.'" disabled><input type="hidden" name="hiddenDataPorta'.$i.'" id="hiddenDataPorta'.$i.'" class="form-control" value="'.$result->port.'">';
                            echo '<a class="btn btn-outline-danger" onclick="removeLinha(this)"><i class="fas fa-trash"></i></a>';
                            echo '</div>';
                            $i++;
                        }
                    ?>       
                </div>
            </div>
            <input type="hidden" class="form-control" value="<?php echo $id?>" name="inputID" id="inputID" required>
            <div class="col-lg-12 form-group">
                <a class="btn btn-outline-secondary" href="index.php">Voltar</a>
                <button type="submit" class="btn btn-outline-primary">Alterar</button>
            </div>
        </form></br>
    </div>
    <div class="footer">
        <div class="container">
            <p class="m-0 text-center text-white small">2020 - Powered by  <img src="http://www.logos-ma.com.br/portal/imagem/logos.png" width="60" alt=""> &copy;</p>
        </div>
    </div>
    <script type="text/javascript">
        var i = document.getElementById("qtdeAdd").value
        var j = i; 
    function addPorta(){
        var divAtual  = document.querySelector('#portlist');
        var divTemp = divAtual.innerHTML;
        var divNova = '<div name="cardPorta'+i+'" id="cardPorta'+i+'" class="card form-group cardPorta" style="width: 20%; background-color: #f3e8f4;"><input type="text" name="dataNome'+ i +'" id="dataNome'+ i +'" class="form-control" value="'+ $('#selPortas option:selected').text() +'" disabled><input type="hidden" name="hiddenDataNome'+ i +'" id="hiddenDataNome'+ i +'" class="form-control" value="'+ document.getElementById('selPortas').value +'"><input type="text" name="dataPorta'+ i +'" id="dataPorta'+ i +'" class="form-control" value="'+ document.getElementById('inputPortas').value +'"disabled><input type="hidden" name="hiddenDataPorta'+ i +'" id="hiddenDataPorta'+ i +'" class="form-control" value="'+ document.getElementById('inputPortas').value +'"><a class="btn btn-outline-danger" onclick="removeLinha(this)"><i class="fas fa-trash"></i></a></div>';
        i++;
        divTemp = divNova + divTemp;
        divAtual.innerHTML = divTemp;
        document.getElementById('selPortas').value = '1';
        document.getElementById('inputPortas').value = '';
        document.getElementById('qtdeAdd').value = i;
    }
    function removeLinha(item){
        item.parentNode.outerHTML = '';
        i--;
    }
    $('#inputPortas').keyup(function(){
        var texto = document.getElementById('inputPortas').value;
        if (texto.length > 0){
            document.getElementById("btnAddPorta").setAttribute("onclick","addPorta()");
        }
        else{
            document.getElementById("btnAddPorta").removeAttribute("onclick");
        }
    });
    $(document).submit(function() {
        document.querySelector('.form-control').removeAttribute("disabled");
        document.getElementById('selPortas').value = '1';
        document.getElementById('inputPortas').value = '';
        document.getElementById('editSv').submit();
  });
    function soNumeros(numeros){
        numeros = numeros.replace(/[^0-9]/g,'');
        console.log(numeros);
        return numeros.replace(/[^0-9]/g,'');
        
    } 
    </script>
</body>
<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</html>