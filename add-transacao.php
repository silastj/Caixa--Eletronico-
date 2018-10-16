<?php
session_start();
require 'configcaixa.php';

if(isset($_POST['tipo'])) {

    $tipo = $_POST['tipo'];
    // esse comando ha mais ele esta convertando para brasileiro, ele procura virgula e muda para ponto dentro do post
    $valor = str_replace(',','.', $_POST['valor']);

    // para garantir que o valor do tipo float no banco de dados
    $valor = floatval($valor);
    
    // ele pega a data_operacao e substitui para  NOW() para pegar horario atual 
    $sql = $pdo->prepare('INSERT INTO historico (id_conta, tipo, valor, data_operacao) VALUES (:id_conta, :tipo, :valor, NOW())');
    
    $sql->bindValue(':id_conta', $_SESSION['banco']);
    $sql->bindValue(':tipo', $tipo);
    $sql->bindValue(':valor', $valor);
    $sql->execute();

    // ao adicionar a movimentacao 
    if($tipo == '0') {
        //Deposito se ele estiver zero ele vai atualizar
        $sql = $pdo->prepare('UPDATE contas SET saldo = saldo + :valor WHERE id =:id');
        $sql->bindValue(':valor', $valor);
        $sql->bindValue(':id', $_SESSION['banco']);
        $sql->execute();
        
    }
    else {
        // Saque 
        $sql = $pdo->prepare('UPDATE contas SET saldo = saldo - :valor WHERE id =:id');
        $sql->bindValue(':valor', $valor);
        $sql->bindValue(':id', $_SESSION['banco']);
        $sql->execute();
    }

    

    header('Location: caixa.php');
    exit;

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
    <script type='text/javascript' src="js/jqueryv4.min.js"></script>
    <script type='text/javascript' src="js/bootstrapv4.min.js"></script>
</head>

<body>
<div class='container'>   

<h2>Banco</h2> 
<img src='imagens/imagem.png' class="rounded img-circle float-center" width="12%" ><br>


    <form method="POST">
      <h3> Tipo de transação</h3> <br>
      
        <select name='tipo' class="form-control form-control-sm" >
            <option>Escolher...</option>
            <option value='0'>Depósito</option>
            <option value='1'>Retirada</option>
        </select>
    
        <br><br><br>
     
<strong>Valor R$</strong><br>

<!-- pattern ele aceita no campo numeros de 0 a 9 com virgulas e pontos com o doctype no inicio da pagina -->
<input type='text' id='form-2' name='valor' pattern="[0-9.,]{1,}" class="form-control form-control-sm" autofocus placeholder='Digite o valor'/> <br> <br>

<ul class="pager">
            <li><input type='submit' value='Adicionar' class="btn btn-primary" /></li>
            <li><input type='submit' value='Voltar' target='caixa.php'class="btn btn-primary" /></li>

        </ul>
</form>

</div>

<div class='container-fluider'>
    <div class="panel panel-success " >
        <div class="panel-heading panel-sm">Desenvolvedor <a href='http://www.asilas.6te.net' id='link-1' target='blank'>Asilas.6te.net</a></div>
    </div>
</div>

</body>

</html>