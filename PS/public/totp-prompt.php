<?php
session_start();
require_once __DIR__ . '/../auth/auth-config.php';

if (!isset($_SESSION['pending_totp_setup'])) {
    header("Location: /login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Configuração de Segurança</title>
    <style>
        .container { max-width: 500px; margin: 50px auto; text-align: center; }
        .btn { margin: 10px; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reforçar sua segurança</h2>
        <p>Para acessar este sistema, você precisa configurar autenticação em duas etapas.</p>
        
        <form method="post" action="/handle-totp-choice.php">
            <button type="submit" name="action" value="accept" class="btn" 
                    style="background: #4CAF50; color: white;">
                Sim, quero configurar
            </button>
            
            <button type="submit" name="action" value="reject" class="btn" 
                    style="background: #f44336; color: white;">
                Recusar e sair
            </button>
        </form>
    </div>
</body>
</html>