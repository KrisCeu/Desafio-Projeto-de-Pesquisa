<?php
session_start();

// Se não estiver logado, redireciona para login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Define flag de acesso restrito sem bloquear totalmente
if ($_SESSION['user']['nivel_acesso'] !== 'alto') {
    $_SESSION['restricted_access'] = true;
    $_SESSION['access_message'] = "não foi possível acessar. Seu nível de acesso é baixo";
}
?>