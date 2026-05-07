<?php
require 'config.php';
include 'verificar_login.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Carregar o autoloader do Composer
require '../vendor/autoload.php';

// Instanciar a classe
$mail = new PHPMailer(true);

$nome = strip_tags($_POST['nome']);
$email = strip_tags($_POST['email']);
$assunto = strip_tags($_POST['assunto']);
$mensagem = strip_tags($_POST['mensagem']);

try {
    // Configurações do Servidor
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USER;
    $mail->Password = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Destinatários
    $mail->setFrom('victorkoba08@gmail.com', 'Koba');
    $mail->addAddress('victorkoba08@gmail.com');

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = $assunto;
    $mail->Body = "<strong>Nome:</strong> $nome <br> 
    <strong>E-mail:</strong> $email <br> 
    <strong>Mensagem:</strong> $mensagem";

    $mail->AltBody = "Nome: $nome \n E-mail: $email \n Mensagem: $mensagem";
    
    $mail->send();
    echo 'sucesso';

} catch (Exception $e) {
        echo 'erro';
    }

    if (!empty($_POST['sobrenome_real'])) {
    exit; 
}
?>