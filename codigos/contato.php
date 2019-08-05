<!DOCTYPE html>
<html lang="br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Contato</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="pagestilo.css">
  </head>
  <body class="text-center">
<div class="container">
            <?php $email = $_SESSION['emailLogado'];
                        $nome = $_SESSION['nomeLogado'];
            ?>
    <div class="row">
        <div class="formcontato">
            <fieldset>
                        <legend>Fale Conosco</legend>
            <p> Seu contato é muito importante para nós. Preencha o formulário abaixo:</p><hr>
            <br><form method="post" action="principal.php?link=3">
            <label for="inputfale">Nome: </label>
            <input type="text" id="inputfale" name="nome" value= <?php echo $nome; ?> required>

            <label for="inputemail">E-mail: </label>
            <input id="inputemail" type="email" name="email" value = <?php echo $email; ?> required><br><br>

            <label for="inputduvida">Dúvida / Sugestão</label><br>
            <textarea id="inputduvida" required name="sugestao" rows="6" cols="30"></textarea><br /><br>
            <input id="btnenviar" type="submit" name="button" value="Enviar" />
            </form>
              </fieldset>
        </div>
    </div>
</div>

  </body>
</html>

<?php
require './PHPMailer-Master/PHPMailerAutoload.php';
    //trim->remove espaços em branco
    //strip_tag->retirar tags html
if (!empty($_POST['nome']) and !empty($_POST['email']) and !empty($_POST['sugestao'])) {
            $nome = strip_tags(trim($_POST['nome']));
            $email_contato = $_POST['email'];
            $mensagem = trim($_POST['sugestao']);

            $email = new PHPMailer();//criando  o objeto

            $email->isSMTP();//cpnfigurar o servidor smtp

            $email->Host = "smtp.gmail.com";// serivço de autenticação do email

            $email->SMTPAuth=true;

            include "dadosemail.php";

            $email->Port = "587";//para protocolo tsl

            $email->SMTPSecure = 'tsl';// ou ssl

            $email->SMTPDebug = 0; // 1 ou 2

            $email->Debugoutput = "html";

            $email->setFrom($email_contato, $nome);

            $email->addReplyTo($email_contato, $nome);

            $email->addAddress("marton.padilha@aluno.iffar.edu.br");

            //$email->addCC("");cópia
            //$email->addBCC("");cópia carbono

            $email->setLanguage('pt');

            $email->CharSet="utf-8";

            $email->WordWrap = 70;

            $email->Subject = "Envio de email pelo sistema";

            $email->isHTML();

            $email->Body = "<b>Email enviado por {$nome} - {$email_contato}</b>"."<br>Mensagem: {$mensagem}<br>";

            //$email->addAttachment("site.rar");

            $resultado = $email->send();

            if($resultado){
               ?> <script>alert('Email enviado com sucesso!\nEm breve você será respondido.');</script>
               <script>window.location('http://localhost/ppi1/codigos/principal.php?link=3')</script><?php
            }
            else{
                echo "Erro...";
            }
}
 ?>
