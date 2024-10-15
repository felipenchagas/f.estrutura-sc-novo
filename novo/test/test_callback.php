<html>
<head>
<title>PHPMailer Lite - DKIM and Callback Function test</title>
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
/* This is a sample callback function for PHPMailer Lite.
 * This callback function will echo the results of PHPMailer processing.
 */

/* Callback (action) function
 *   bool    $result        result of the send action
 *   string  $to            email address of the recipient
 *   string  $cc            cc email addresses
 *   string  $bcc           bcc email addresses
 *   string  $subject       the subject
 *   string  $body          the email body
 * @return boolean
 */
function callbackAction ($result, $to, $cc, $bcc, $subject, $body) {
  /*
  this callback example echos the results to the screen - implement to
  post to databases, build CSV log files, etc., with minor changes
  */
  $to  = cleanEmails($to,'to');
  $cc  = cleanEmails($cc[0],'cc');
  $bcc = cleanEmails($bcc[0],'cc');
  echo $result . "\tTo: "  . $to['Name'] . "\tTo: "  . $to['Email'] . "\tCc: "  . $cc['Name'] . "\tCc: "  . $cc['Email'] . "\tBcc: "  . $bcc['Name'] . "\tBcc: "  . $bcc['Email'] . "\t"  . $subject . "<br />\n";
  return true;
}

$testLite = false;

if ($testLite) {
  require_once '../class.phpmailer-lite.php';
  $mail = new PHPMailerLite();
} else {
  require_once '../class.phpmailer.php';
  $mail = new PHPMailer();
}

try {
  $mail->IsMail(); // telling the class to use SMTP
  $mail->SetFrom('you@yourdomain.com', 'Your Name');
  $mail->AddAddress('another@yourdomain.com', 'John Doe');
  $mail->Subject = 'PHPMailer Lite Test Subject via Mail()';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(file_get_contents('contents.html'));
  $mail->AddAttachment('images/phpmailer.gif');      // attachment
  $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->action_function = 'callbackAction';
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}

function cleanEmails($str,$type) {
  if ($type == 'cc') {
    $addy['Email'] = $str[0];
    $addy['Name']  = $str[1];
    return $addy;
  }
  if (!strstr($str, ' <')) {
    $addy['Name']  = '';
    $addy['Email'] = $addy;
    return $addy;
  }
  $addyArr = explode(' <', $str);
  if (substr($addyArr[1],-1) == '>') {
    $addyArr[1] = substr($addyArr[1],0,-1);
  }
  $addy['Name']  = $addyArr[0];
  $addy['Email'] = $addyArr[1];
  $addy['Email'] = str_replace('@', '&#64;', $addy['Email']);
  return $addy;
}

?>
</body>
</html>
