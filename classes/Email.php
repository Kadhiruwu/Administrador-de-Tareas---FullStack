<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host =  $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PUERTO'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('jeanpiero_23_01@hotmail.com');
        $mail->addAddress($this->email, 'uptask.com');
        $mail->Subject = 'Confirma tu Cuenta';

        $mail->isHTML();
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>
        <head>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    line-height: 1.6;
                    color: black;
                }
                p {
                    margin-bottom: 15px;
                    color: black;
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <p>Hola " . $this->nombre . ",</p>
            <p>Has creado tu cuenta en Uptask. Para confirmar tu cuenta, por favor presiona el enlace de abajo:</p>
            <p><a href='" . $_ENV['APP_URL'] . "/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>
            <p>Si no solicitaste esta cuenta, puedes ignorar este mensaje.</p>
        </body>
      </html>";

        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();
        


    }

    public function enviarInstrucciones()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PUERTO'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('jeanpiero_23_01@hotmail.com');
        $mail->addAddress($this->email, 'uptask.com');
        $mail->Subject = 'Reestablece tu Password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>
        <head>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    line-height: 1.6;
                    color: black;
                }
                p {
                    margin-bottom: 15px;
                    color: black;
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <p>Hola " . $this->nombre . ",</p>
            <p>Has solicitado cambiar tu password en Uptask. Para confirmar seguir el proceso, por favor presiona el siguiente enlace:</p>
            <p><a href='" . $_ENV['APP_URL'] . "/reestablecer?token=" . $this->token . "'>Cambiar Password</a></p>
            <p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
        </body>
      </html>";

        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();


    }
}

?>
