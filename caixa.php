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


<?php

session_start();
require 'configcaixa.php';

if(isset($_SESSION['banco']) && empty($_SESSION['banco']) == false) {

     $id = $_SESSION['banco'];

     $sql = $pdo->prepare('SELECT * FROM  contas WHERE id = :id');
     $sql->bindValue(':id', $id);
     $sql->execute();

     if($sql->rowCount() > 0) {
         $info = $sql->fetch();
     }
     else {
        header('Location: logincaixa.php');
        exit;
     }

}
else {
      header('Location: logincaixa.php');
      exit;
}

?>

<body>

    <div class='container'>   

    <h2>Banco</h2> 
    <img src='imagens/imagem.png' class="rounded img-circle float-center" width="12%" ><br>

  <strong> Titular:</strong> <?php echo $info['titular'];?><br>
  <strong>  Agência:</strong> <?php echo $info['agencia'];?><br>
  <strong>   Conta:</strong> <?php echo $info['conta'];?> <br>

  <strong>  Saldo:</strong> <?php if($info['saldo'] < '0,00'): ?>
              <font color='red'>
                    <!-- esse abaixo mostra o valor  -->
                    R$<?php echo $info['saldo'] ?></font>
                 

        <?php else: ?>
         <font color='green'>  
                    R$<?php echo $info['saldo'] ?></font>
        <?php endif; ?>
    
    <br>
    <br>

    
    
    <ul class="pager">
            <li class='next'><a href='cadastrocaixa.php'>Cadastrar nova conta</a></li>
            

        </ul>
    <hr>
<h3>Movimentação/Extrato</h3>
<br>



<table class="table-sm table  table-dark table-hover" id='table-1'>

    <tr>
        <th class="success">Data</th>
        <th class="success">Valor</th>
    </tr>

    <?php

    $sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta= :id_conta");
    $sql->bindValue(':id_conta', $id);   // pega o id_conta e substitui pelo id
    $sql->execute();
   
    // comando abaixo verifica se tem movimentacao 
    if($sql->rowCount() > 0) {
        foreach($sql->fetchAll() as $item) {
            ?>

            <tr>
                <!-- mostrar a data da operacao o strtotime vai transforma em tempo e coloca em ordem com o date('d/m/Y H:i')  -->
                <td><?php echo date('d/m/Y H:i', strtotime($item['data_operacao'])); ?></td>

                <td>                    
            <?php if($item['tipo'] == '0'): ?>
              <font color='green'>
                    <!-- esse abaixo mostra o valor  -->
                    R$<?php echo $item['valor'] ?></font>
        <?php else: ?>
         <font color='red'>  
                    -R$<?php echo $item['valor'] ?></font>
        <?php endif; ?>
                </td>
            </tr>
            <?php
        }
    }
    
    ?>


</table>

<ul class="pager">
            <li><a href='add-transacao.php'>Adicionar transação</a></li>
            <li><a href='saircaixa.php'>Sair</a></li>

        </ul>


</div>
<br>
<div class='container-fluider'>
    <div class="panel panel-success " >
        <div class="panel-footer panel-sm">Desenvolvedor <a href='http://www.asilas.6te.net' id='link-1' target='blank'>Asilas.6te.net</a>
        
        </div>
        
    </div>
</div>
</body>

</html>