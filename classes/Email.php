<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $nombre;
    protected $token;
    protected static $rutaServidor = 'http://uptask.localhost/';

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        // Conectarse al MailTrap con PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b996f7e1ed6275';
        $mail->Password = '8fac93611f8217';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');

        // Asunto
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = $this->getContenidoHTML (
            'Confirma tu cuenta',
            'Has creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace presionando el botón',
            'confirmar',
            'Confirmar Cuenta',
            'Si tu no creaste esta cuenta, puedes ignorar este mensaje'
        );

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }

    public function enviarInstrucciones(){
        // Conectarse al MailTrap con PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b996f7e1ed6275';
        $mail->Password = '8fac93611f8217';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');

        // Asunto
        $mail->Subject = 'Reestablece tu Contraseña';

        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = $this->getContenidoHTML (
            'Reestablece tu Contraseña',
            'Parece que has olvidado tu contraseña, sigue el siguiente enlace del botón para recuperarlo',
            'reestablecer',
            'Reestablecer Contraseña',
            'Si tu no creaste esta cuenta, puedes ignorar este mensaje'
        );

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }

    /**
    *
    *Plantilla del contenido HTML cuando se envia el correo al usuario.
    *
    *@param String $asunto = El asunto del mensaje que muestra abajo el nombre de la pagina
    *@param String $mensaje = El mensaje que le quieres dar al usuario cuando se registra o quiere reestablecer su contraseña, etc.
    *@param String $ruta = La ruta que lo enviara por el MVC al hacer click en el botón.
    *@param String $textoBoton = El enlace es un botón por lo tanto tiene texto, lo cual decidiras que texto tendra el botón.
    *@param String $textoAviso = El mensaje de aviso en caso de que el usuario no hizo dicha acción y desconoce el por qué de ese correo
    *que le enviaron
    *
    *@return String $cuerpoHTML
    */
    public function getContenidoHTML($asunto, $mensaje, $ruta, $textoBoton, $textoAviso){

        $cuerpoHTML = "
        <html>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap');

            html {
                font-size: 62.5%;
            }

            body {
                font-size: 16px;
                font-family: 'Poppins', sans-serif;
                max-width: 100%;
            }

            h1 {
                text-align:  center;
            }
            
            h2 {
                text-align: center;
            }

            .texto {
                text-align: justify;
                max-width: 95%;
            }

            .texto p {
                margin: 20px 0;
                width: 100%;
            }

            .texto p span{
                font-weight: bold;
            }

            .boton-link{                       
                text-decoration: none;
                text-align: center;
                background-color: #1a1b15;
                color: #ffffff;
                padding: 15px;
                font-weight: bold;
                display: block;            
            }

            @media (min-width: 768px) {
                .boton-link {     
                    display: inline-block;
                }
            }

            .boton-link:hover{
                background-color: #2b2a2a;
            }

            .borde {
                border-bottom: 1px solid #a09f9f;
                margin-bottom: 20px;
            }

            .texto-debajo {
                text-align: center;
            }

            .texto-aviso {
                font-style: italic;
            }
        </style>

        <body>
            <h1>UpTask</h1>

            <h2>${asunto}</h2>

            <div class='texto'>
                <p>¡Saludos! <span>" .$this->nombre . " (".$this->email.").</span> ${mensaje}</p>
                <a href='" . self::$rutaServidor . "${ruta}?token=" . $this->token . "' class='boton-link'>${textoBoton}</a>
                <p class='texto-aviso'>${textoAviso}</p>
            </div>

            <div class='borde'></div>

            <div class='Texto-debajo'>
                <span>No responder a este correo</span>
            </div>
        </body>
        </html>       
        ";

        return $cuerpoHTML;
    }
}

?>