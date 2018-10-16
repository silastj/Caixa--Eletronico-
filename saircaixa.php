<?php
session_start();

unset($_SESSION['banco']);
header('Location: caixa.php');
exit;