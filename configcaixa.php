<?php
// try {
//    $pdo = new PDO("mysql:host=localhost;dbname=projeto_caixaeletronico", "root", " ");
// }
// catch(PDOException $e) {
//     echo "ERRO: ".$e->getMessage();
//     exit;
// }
// 

try {
    global $pdo;
    //$pdo = new PDO('mysql:host=localhost;dbname=projeto_caixaeletronico;charset=utf8', 'root', '');

    $pdo = new PDO('mysql:host=67.23.245.159;dbname=ctdntmed_projeto_caixaeletronico;charset=utf8', 'ctdntmed_amos', 'a123456');

    $pdo->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);

} catch(PDOException $e) {
    echo "ERROR: ".$e->getMessage();
    exit;
}

$limite = 3;  // mostrar na lista de consulta

$patentes = array(


);
