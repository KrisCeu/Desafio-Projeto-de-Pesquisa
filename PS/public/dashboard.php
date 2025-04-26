<?php
require_once __DIR__ . '/../auth/check-auth.php';

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo, <?= htmlspecialchars($user['username']) ?>!</h1>
    <p>Seu nível de acesso: <strong><?= $user['nivel_acesso'] ?></strong></p>
    <a href="logout.php">Sair</a>
</body>
</html>