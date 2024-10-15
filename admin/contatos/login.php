<?php
session_start();

// Habilita a exibição de erros temporariamente (desative em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica se o usuário já está logado
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit();
}

// Inicializa a variável de erro
$erro = '';

// Processa o login quando o formulário é submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos 'usuario' e 'senha' estão presentes
    if (isset($_POST['usuario']) && isset($_POST['senha'])) {
        // Sanitiza os dados de entrada para prevenir XSS
        $usuario = trim(htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8'));
        $senha = trim(htmlspecialchars($_POST['senha'], ENT_QUOTES, 'UTF-8'));

        // Defina seu usuário e senha corretos
        $usuario_correto = 'eneas';
        $senha_correta = 'estrutura8080@'; // **⚠️ ALTERAR IMEDIATAMENTE**

        // Verifica se as credenciais estão corretas
        if ($usuario === $usuario_correto && $senha === $senha_correta) {
            // Define a sessão como logada
            $_SESSION['logged_in'] = true;

            // Redireciona para a página principal
            header('Location: index.php');
            exit();
        } else {
            // Define a mensagem de erro para credenciais inválidas
            $erro = 'Usuário ou senha inválidos.';
        }
    } else {
        // Define a mensagem de erro para campos faltantes
        $erro = 'Por favor, preencha os campos de usuário e senha.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Link para o CSS -->
    <link rel="stylesheet" href="admin_styles20.css">
    <!-- Fonte Personalizada -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- Meta viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos básicos para centralizar o formulário */
        body {
			font-family: 'Montserrat', sans-serif;
			background-color: #000; /* Altere para preto */
			display: flex;
			height: 100vh;
			justify-content: center;
			align-items: center;
			margin: 0;
		}
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 700;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error-message {
            color: #a94442;
            background-color: #f2dede;
            padding: 10px;
            border: 1px solid #ebccd1;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-form button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <?php if (!empty($erro)): ?>
                <p class="error-message"><?php echo $erro; ?></p>
            <?php endif; ?>
            <form action="login.php" method="post" class="login-form">
                <div class="input-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
