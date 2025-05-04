<?php
require_once __DIR__ . '/../auth/check-auth.php';

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .access-alert {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Bem-vindo, <?= htmlspecialchars($user['username']) ?>!</h1>
    
    <?php if (isset($_SESSION['restricted_access'])): ?>
        <div class="access-alert">
            ⚠️ <?= htmlspecialchars($_SESSION['access_message']) ?>
            <form action="logout.php" method="post" style="margin-top: 10px;">
                <button type="submit" class="logout-btn">Sair</button>
            </form>
        </div>
    <?php else: ?>
        <p>Seu nível de acesso é "alto"</p>
        <a href="logout.php" class="logout-btn">Sair</a>
    <?php endif; ?>
</body>
</html>