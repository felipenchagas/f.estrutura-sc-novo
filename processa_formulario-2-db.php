<?php
session_start();

// Ativar exibição de erros (remover em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("novo/src/PHPMailer.php");
require_once("novo/src/SMTP.php");
require_once("novo/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

// Conectar ao primeiro banco de dados
$servidor1 = "162.214.145.189";
$usuario1 = "empre028_felipe";
$senha1 = "Iuh86gwt--@Z123"; 
$banco1 = "empre028_estruturasc";
$conexao1 = new mysqli($servidor1, $usuario1, $senha1, $banco1);

// Conectar ao segundo banco de dados
$servidor2 = "localhost";
$usuario2 = "quarto_estrusc";
$senha2 = "uRXA1r9Z7pv~Cw3"; 
$banco2 = "quarto_estruturasc";
$conexao2 = new mysqli($servidor2, $usuario2, $senha2, $banco2);

// Verifica se a conexão foi bem-sucedida com ambos os bancos
if ($conexao1->connect_error) {
    file_put_contents('error_log.txt', "[" . date('Y-m-d H:i:s') . "] Erro na conexão com o banco 1: " . $conexao1->connect_error . "\n", FILE_APPEND);
    die("Erro na conexão com o banco 1.");
}
if ($conexao2->connect_error) {
    file_put_contents('error_log.txt', "[" . date('Y-m-d H:i:s') . "] Erro na conexão com o banco 2: " . $conexao2->connect_error . "\n", FILE_APPEND);
    die("Erro na conexão com o banco 2.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function sanitizar($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    $nome = sanitizar($_POST['nome'] ?? '');
    $email = sanitizar($_POST['email'] ?? '');
    $ddd = sanitizar($_POST['ddd'] ?? '');
    $telefone = sanitizar($_POST['telefone'] ?? '');
    $cidade = sanitizar($_POST['cidade'] ?? '');
    $estado = sanitizar($_POST['estado'] ?? '');
    $descricao = sanitizar($_POST['descricao'] ?? '');
    $honeypot = sanitizar($_POST['honeypot'] ?? '');
    $form_loaded_at = intval($_POST['form_loaded_at'] ?? 0);

    if (!empty($honeypot)) {
        header('Location: https://estruturametalicasc.com.br/sucesso');
        exit();
    }

    $current_time = round(microtime(true) * 1000);
    $time_diff = ($current_time - $form_loaded_at) / 1000;

    if ($form_loaded_at == 0 || $time_diff < 5) {
        header('Location: https://estruturametalicasc.com.br/sucesso');
        exit();
    }

    if (empty($nome) || empty($email) || empty($ddd) || empty($telefone) || empty($cidade) || empty($estado) || empty($descricao)) {
        file_put_contents('error_log.txt', "[" . date('Y-m-d H:i:s') . "] Campos obrigatórios ausentes.\n", FILE_APPEND);
        header('Location: https://estruturametalicasc.com.br/error');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        file_put_contents('error_log.txt', "[" . date('Y-m-d H:i:s') . "] E-mail inválido: $email\n", FILE_APPEND);
        header('Location: https://estruturametalicasc.com.br/error');
        exit();
    }

    $telefone_completo = "({$ddd}) {$telefone}";

    $sql1 = "INSERT INTO orcamentos (nome, email, telefone, cidade, estado, descricao, data_envio) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $sql2 = "INSERT INTO orcamentos (nome, email, telefone, cidade, estado, descricao, data_envio) VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt1 = $conexao1->prepare($sql1);
    $stmt2 = $conexao2->prepare($sql2);

    if (!$stmt1 || !$stmt2) {
        file_put_contents('error_log.txt', "[" . date('Y-m-d H:i:s') . "] Erro ao preparar consulta SQL.\n", FILE_APPEND);
        die("Erro ao preparar consulta SQL.");
    }

    $stmt1->bind_param("ssssss", $nome, $email, $telefone_completo, $cidade, $estado, $descricao);
    $stmt2->bind_param("ssssss", $nome, $email, $telefone_completo, $cidade, $estado, $descricao);

    if ($stmt1->execute() && $stmt2->execute()) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'mail.embrafer.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contato@estruturametalicasc.com.br';
            $mail->Password = 'Futgrass80802!';
            $mail->SMTPSecure = 'ssl'; 
            $mail->Port = 465; 

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('contato@estruturametalicasc.com.br', 'ESTRUTURA SC');
            $mail->addAddress('contato@estruturametalicasc.com.br', 'ESTRUTURA SC');
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Novo Contato - Site ESTRUTURA SC Empresarial';
            $mail->Body = "
                <html>
                <body>
                    <h3>Contato recebido pelo site</h3>
                    <p><strong>Nome:</strong> $nome</p>
                    <p><strong>E-mail:</strong> $email</p>
                    <p><strong>Telefone:</strong> $telefone_completo</p>
                    <p><strong>Cidade:</strong> $cidade</p>
                    <p><strong>Estado:</strong> $estado</p>
                    <p><strong>Descrição:</strong> $descricao</p>
                    <p><strong>Data:</strong> " . date('d/m/Y H:i:s') . "</p>
                </body>
                </html>
            ";

            $mail->send();
            header('Location: https://estruturametalicasc.com.br/sucesso');
            exit();
        } catch (Exception $e) {
            file_put_contents('error_log.txt', "[" . date('Y-m-d H:i:s') . "] Erro ao enviar e-mail: " . $e->getMessage() . "\n", FILE_APPEND);
            header('Location: https://estruturametalicasc.com.br/error');
            exit();
        }
    } else {
        file_put_contents('error_log.txt', "[" . date('Y-m-d H:i:s') . "] Erro ao inserir dados no banco.\n", FILE_APPEND);
        header('Location: https://estruturametalicasc.com.br/error');
        exit();
    }

    $stmt1->close();
    $stmt2->close();
    $conexao1->close();
    $conexao2->close();
} else {
    header('Location: https://estruturametalicasc.com.br/error');
    exit();
}
?>
