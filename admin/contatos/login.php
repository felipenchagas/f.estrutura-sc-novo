<?php

session_start();



// Verifica se o usuário já está logado

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

    header('Location: index.php');

    exit();

}



// Processa o login

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = $_POST['usuario'];

    $senha = $_POST['senha'];



    // Defina seu usuário e senha

    $usuario_correto = 'eneas';

    $senha_correta = 'embra8080@';



    if ($usuario === $usuario_correto && $senha === $senha_correta) {

        $_SESSION['logged_in'] = true;

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

</head>



<body>

    <div class="login-container">

        <div class="login-box">

            <h2>Login</h2>

            <?php if (isset($erro)): ?>

                <p class="error-message"><?php echo $erro; ?></p>

            <?php endif; ?>

            <form action="" method="post" class="login-form">

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

