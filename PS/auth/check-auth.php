<?php
session_start();
//rejeitar usários de nível de acesso baixo
if (!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'alto') {
    header("HTTP/1.1 403 Forbidden");
    die("Acesso negado: autenticação de dois fatores necessária.");
}
?>