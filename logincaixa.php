<?php
session_start();
require_once 'configcaixa.php';

if(isset($_POST['agencia']) && empty($_POST['agencia']) == false ) {
    $agencia = addslashes($_POST['agencia']);
    $conta = addslashes($_POST['conta']);
    $senha = addslashes($_POST['senha']);
     
    $sql = $pdo->prepare('SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND  senha = :senha');
    $sql->bindValue(':agencia', $agencia);
    $sql->bindValue(':conta', $conta);
    $sql->bindValue(':senha', md5($senha));
    $sql->execute();
        
    // comando abaixo, se ele achou agencia conta e senha 
    if($sql->rowCount() > 0) {
        $sql = $sql->fetch();
// adiciona a sessao banco e registra o id da conta
        $_SESSION['banco'] = $sql['id'];
        // Redirecionar para a pagina index.php
        header('Location: caixa.php');
 }
 else{
     echo 'Senha e Agência <strong>ERRADA!</strong>';
     
     
 }
}
?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Caixa Eletrônico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrapv4.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="stylecaixa.css" />
    
</head>


<body>

<div class='container'>

<h2>Banco</h2> 
<img src='imagens/imagem.png' class="rounded img-circle float-center" width="12%" ><br><br>


<form method="POST">
<div class="form-group">
     Agência <br>
     <input type='text'  name='agencia' id='form-1' class="form-control form-control-sm" autofocus placeholder='123'/> 

     Conta <br>
     <input type='text' name='conta' id='form-1' class="form-control form-control-sm" placeholder='321'/> 

     Senha <br>
     <input type='password' name='senha' id='form-1' class="form-control form-control-sm" placeholder='123'/> 
<br> <br>
     <input type='submit' value='Entrar' class="btn btn-primary" />
     <button class="btn btn-success" data-toggle='tooltip' title='Agência:123 Conta:321 Senha:123' data-placement='bottom'>Teste</button>
     <a href='saircaixa.php' class="btn btn-primary">Limpar</a>
</div>
</form>



</div>
<div class='container-fluider'>
    <div class="panel panel-success " >
        <div class="panel-heading panel-sm">Desenvolvedor <a href='http://www.asilas.6te.net' id='link-1' target='blank'>Asilas.6te.net</a></div>
    </div>
</div>
<script type='text/javascript' src="js/jqueryv4.min.js"></script>
<script type='text/javascript' src="js/bootstrapv4.min.js"></script>
<script type='text/javascript'>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
    </script>

</body>

</html>