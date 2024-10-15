<html>
<head>
<title>PHPMailer - SMTP (Gmail) basic test</title>
</head>

<!-- Botão Flutuante -->
<div class="floating-button">
  <button id="openModalBtn">Solicitar Orçamento</button>
</div>

<!-- Modal -->
<div id="contactModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Solicitar Orçamento</h2>
    
    <form action="processa_formulario.php" method="post" id="contact-form">
      <div class="input-group">
        <label for="nome">Nome Completo</label>
        <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
      </div>
      
      <div class="input-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
      </div>
      
      <div class="input-group">
        <label for="telefone">Telefone</label>
        <div class="phone-fields">
          <input type="text" id="ddd" name="ddd" placeholder="DDD" maxlength="2" required>
          <input type="text" id="telefone" name="telefone" placeholder="Número" required>
        </div>
      </div>
      
<div class="form-row">
  <div class="input-group cidade">
    <label for="cidade">Cidade</label>
    <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required>
  </div>
  <div class="input-group estado">
    <label for="estado">Estado</label>
    <input type="text" id="estado" name="estado" placeholder="Digite" maxlength="2" required>
  </div>
</div>
      
      <div class="input-group">
        <label for="descricao">Descrição do Orçamento</label>
        <textarea id="descricao" name="descricao" placeholder="Descreva o serviço ou estrutura metálica que deseja orçar" required></textarea>
      </div>
      
      <button type="submit">Enviar</button>
    </form>
  </div>
</div>
<body>
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

<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

require_once('../class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$body             = file_get_contents('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.yourdomain.com"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "yourusername@gmail.com";  // GMAIL username
$mail->Password   = "yourpassword";            // GMAIL password

$mail->SetFrom('name@yourdomain.com', 'First Last');

$mail->AddReplyTo("name@yourdomain.com","First Last");

$mail->Subject    = "PHPMailer Test Subject via smtp (Gmail), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$address = "whoto@otherdomain.com";
$mail->AddAddress($address, "John Doe");

$mail->AddAttachment("images/phpmailer.gif");      // attachment
$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>

</body>
</html>
