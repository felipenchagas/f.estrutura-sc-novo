<?php<body>
<div class="floating-button">
  <button id="openModalBtn">Solicitar Orçamento</button>
</div>


<!-- Modal -->
  <div id="contactModal" class="modal" style="display:none;">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Solicitar Orçamento</h2>
        
        <form action="processa_formulario.php" method="post" id="contact-form">
          <div class="input-group">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required pattern="[A-Za-zÀ-ÿ\s]+" title="Somente letras são permitidas">
          </div>
          
          <div class="input-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
          </div>
          
          <div class="input-group">
            <label for="telefone">Telefone</label>
            <div class="phone-fields">
              <input type="text" id="ddd" name="ddd" placeholder="DDD" maxlength="2" required pattern="\d{2}" title="Somente números são permitidos">
              <input type="text" id="telefone" name="telefone" placeholder="Número" maxlength="9" pattern="\d{9}" title="Somente números são permitidos" required>
            </div>
          </div>
          
          <div class="form-row">
            <div class="input-group cidade">
              <label for="cidade">Cidade</label>
              <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required pattern="[A-Za-zÀ-ÿ\s]+" title="Somente letras são permitidas">
            </div>
            <div class="input-group estado">
              <label for="estado">Estado</label>
              <input type="text" id="estado" name="estado" placeholder="Digite" maxlength="2" pattern="[A-Za-z]{2}" title="Apenas 2 letras são permitidas" required>
            </div>
          </div>
          
          <div class="input-group">
            <label for="descricao">Descrição do Orçamento</label>
            <textarea id="descricao" name="descricao" placeholder="Descreva o serviço ou estrutura metálica que deseja orçar" required></textarea>
          </div>
          
          <!-- Campo Honeypot escondido -->
          <div style="display:none;">
            <label for="honeypot">Não preencha este campo se for humano:</label>
            <input type="text" id="honeypot" name="honeypot">
          </div>
          
          <!-- Campo Oculto para o Temporizador -->
          <input type="hidden" id="form_loaded_at" name="form_loaded_at" value="">
          
          <button type="submit">Enviar</button>
        </form>
      </div>
    </div>
session_start();

// **⚠️ IMPORTANTE:** Desative a exibição de erros em produção por segurança
ini_set('display_errors', 1); // Altere para 0 em produção
ini_set('display_startup_errors', 1); // Altere para 0 em produção
error_reporting(E_ALL); // Altere para 0 em produção

// Inclui o PHPMailer
require_once("novo/src/PHPMailer.php");
require_once("novo/src/SMTP.php");
require_once("novo/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conectar ao primeiro banco de dados (informações fornecidas)
$servidor1 = "162.214.145.189";
$usuario1 = "empre028_felipe";
$senha1 = "Iuh86gwt--@Z123";
$banco1 = "empre028_embrafer";
$conexao1 = new mysqli($servidor1, $usuario1, $senha1, $banco1);

// Conectar ao segundo banco de dados (Locaweb)
$servidor2 = "localhost";
$usuario2 = "quarto_estrusc";
$senha2 = "uRXA1r9Z7pv~Cw3";
$banco2 = "quarto_estruturasc";
$conexao2 = new mysqli($servidor2, $usuario2, $senha2, $banco2);

// Verifica se a conexão foi bem-sucedida com ambos os bancos
if ($conexao1->connect_error || $conexao2->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao1->connect_error . " / " . $conexao2->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Função para sanitizar os dados de entrada
    function sanitizar($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    // Captura e sanitiza os dados do formulário
    $nome = sanitizar($_POST['nome'] ?? '');
    $email = sanitizar($_POST['email'] ?? '');
    $ddd = sanitizar($_POST['ddd'] ?? '');
    $telefone = sanitizar($_POST['telefone'] ?? '');
    $cidade = sanitizar($_POST['cidade'] ?? '');
    $estado = sanitizar($_POST['estado'] ?? '');
    $descricao = sanitizar($_POST['descricao'] ?? '');
    $honeypot = sanitizar($_POST['honeypot'] ?? '');
    $form_loaded_at = isset($_POST['form_loaded_at']) ? intval($_POST['form_loaded_at']) : 0;

    // Verificação do Honeypot
    if (!empty($honeypot)) {
        // Submissão suspeita de bot
        header('Location: sucesso.html'); 
        exit();
    }

    // Verificação do Temporizador de Submissão
    $current_time = round(microtime(true) * 1000); // Tempo atual em milissegundos
    $time_diff = ($current_time - $form_loaded_at) / 1000; // diferença em segundos

    if ($form_loaded_at == 0 || $time_diff < 5) {  // Se o formulário foi enviado muito rapidamente
        // Submissão suspeita de bot
        header('Location: sucesso.html'); 
        exit();
    }

    // Validação básica dos campos (já realizada no frontend, mas reforçada aqui)
    if (empty($nome) || empty($email) || empty($ddd) || empty($telefone) || empty($cidade) || empty($estado) || empty($descricao)) {
        echo "Todos os campos são obrigatórios.";
        exit();
    }

    // Combina 'ddd' e 'telefone'
    $telefone_completo = "({$ddd}) {$telefone}";

    // Prepara a consulta SQL de inserção para o primeiro banco
    $sql1 = "INSERT INTO orcamentos (nome, email, telefone, cidade, estado, descricao, data_envio) 
             VALUES (?, ?, ?, ?, ?, ?, NOW())";

    // Prepara a consulta SQL de inserção para o segundo banco
    $sql2 = "INSERT INTO orcamentos (nome, email, telefone, cidade, estado, descricao, data_envio) 
             VALUES (?, ?, ?, ?, ?, ?, NOW())";

    // Prepara a inserção no primeiro banco
    $stmt1 = $conexao1->prepare($sql1);
    // Prepara a inserção no segundo banco
    $stmt2 = $conexao2->prepare($sql2);

    if ($stmt1 && $stmt2) {
        // Bind os parâmetros para ambos os bancos
        $stmt1->bind_param("ssssss", $nome, $email, $telefone_completo, $cidade, $estado, $descricao);
        $stmt2->bind_param("ssssss", $nome, $email, $telefone_completo, $cidade, $estado, $descricao);

        // Executa as inserções
        if ($stmt1->execute() && $stmt2->execute()) {
            // Envio do e-mail somente se os dados forem inseridos com sucesso nos dois bancos
            $mail = new PHPMailer(true);
            try {
                // Configurações do servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'mail.embrafer.com';    // Endereço do servidor SMTP
                $mail->SMTPAuth   = true;
                $mail->Username   = 'contato@estruturametalicasc.com.br'; // Seu email no SMTP
                $mail->Password   = 'Futgrass80802!';      // Sua senha no SMTP
                $mail->SMTPSecure = 'tls';                  // Criptografia TLS
                $mail->Port       = 587;                    // Porta SMTP

                // Remetente e destinatário
                $mail->setFrom('contato@estruturametalicasc.com.br', 'ESTRUTURA SC Contato');
                $mail->addAddress('contato@estruturametalicasc.com.br', 'ESTRUTURA SC'); // Email que receberá o aviso

                // Conteúdo do e-mail
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Novo Contato - Site Empresarial SC';
                $mail->Body    = "
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

                // Envia o e-mail
                $mail->send();

                // Redireciona para a página de sucesso
                header('Location: sucesso.html');
                exit();
            } catch (Exception $e) {
                echo "Erro ao enviar e-mail: " . $mail->ErrorInfo;
            }
        } else {
            echo "Erro ao inserir dados no banco 1: " . $stmt1->error;
            echo "Erro ao inserir dados no banco 2: " . $stmt2->error;
            exit();
        }
        $stmt1->close();
        $stmt2->close();
    } else {
        echo "Erro ao preparar a consulta no banco 1: " . $conexao1->error;
        echo "Erro ao preparar a consulta no banco 2: " . $conexao2->error;
        exit();
    }

    // Fecha a conexão com os bancos de dados
    $conexao1->close();
    $conexao2->close();
} else {
    echo "Método de requisição inválido.";
}
?>
