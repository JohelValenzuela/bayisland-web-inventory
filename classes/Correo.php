<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Correo {

    public $correo;
    public $nombre;
    public $token;
    public $password;

    public function __construct($nombrecompleto, $correo, $token, $password) {     
        $this->nombre = $nombrecompleto;
        $this->correo = $correo;
        $this->token = $token;
        $this->password = $password;
    }

    public function enviarConfirmacion() {
         // Crear el objeto del correo
         $correo = new PHPMailer();
         $correo->isSMTP();
         $correo->Host = $_ENV['EMAIL_HOST'];
         $correo->SMTPAuth = true;
         $correo->Port = $_ENV['EMAIL_PORT'];
         $correo->Username = $_ENV['EMAIL_USER'];
         $correo->Password = $_ENV['EMAIL_PASS'];

        // Set HTML
        $correo->isHTML(TRUE);
        $correo->CharSet = 'UTF-8';

        // Datos Remitente y Receptor
        $correo->setFrom('
        testingvlnz@gmail.com');
        $correo->addAddress('
        testingvlnz@gmail.com', 'bayislandcruises.com');
        $correo->Subject = 'Confirma la cuenta del nuevo usuario';

        // Contenido del correo
        $contenido = '<!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml">
        
        <head>
          <title></title>
          <!--[if !mso]><!-- -->
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <!--<![endif]-->
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <style type="text/css">
            #outlook a {
              padding: 0;
            }
        
            .ReadMsgBody {
              width: 100%;
            }
        
            .ExternalClass {
              width: 100%;
            }
        
            .ExternalClass * {
              line-height: 100%;
            }
        
            body {
              margin: 0;
              padding: 0;
              -webkit-text-size-adjust: 100%;
              -ms-text-size-adjust: 100%;
            }
        
            table,
            td {
              border-collapse: collapse;
              mso-table-lspace: 0pt;
              mso-table-rspace: 0pt;
            }
        
          </style>
          <!--[if !mso]><!-->
          <style type="text/css">
            @media only screen and (max-width:480px) {
              @-ms-viewport {
                width: 320px;
              }
              @viewport {
                width: 320px;
              }
            }
          </style>
          <!--<![endif]-->
          <!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]-->
          <!--[if lte mso 11]><style type="text/css">  .outlook-group-fix {    width:100% !important;  }</style><![endif]-->
          <!--[if !mso]><!-->
          <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" type="text/css">
          <style type="text/css">
            @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap");
          </style>
          <!--<![endif]-->
          <style type="text/css">
            @media only screen and (max-width:595px) {
              .container {
                width: 100% !important;
              }
              .button {
                display: block !important;
                width: auto !important;
              }
            }
          </style>
        </head>
        
        <body style="font-family: "Inter", sans-serif; background: #E5E5E5;">
          <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#F6FAFB">
            <tbody>
              <tr>
                <td valign="top" align="center">
                  <table class="container" width="600" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                      <tr>
                        <td style="padding:48px 0 30px 0; text-align: center; font-size: 14px; color: #4C83EE;">
                          <img src="https://mailsend-email-assets.mailtrap.io/vttefb5mshsodyi4ee9vqu46vzur.png" style="width:250px;">
                        </td>
                      </tr>
                      <tr>
                        <td class="main-content" style="padding: 48px 30px 40px; color: #000000;" bgcolor="#ffffff">
                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td style="padding: 0 0 24px 0; font-size: 18px; line-height: 150%; font-weight: bold; color: #000000; letter-spacing: 0.01em;">
                                <h2 class="default-heading2" style="text-align: center; color: #1f2d3d; font-family: arial,helvetica,sans-serif; font-size: 32px; word-break: break-word;">¡Confirma el usuario!</h2>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 10px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                    El usuario <strong>"' . $this->nombre . '"</strong> con el correo <strong>"' . $this->correo . '"</strong> desea crear una nueva cuenta en <strong> Inventario Web - Bay Island Cruises. </strong>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 16px 0; font-size: 14px; line-height: 150%; font-weight: 700; color: #000000; letter-spacing: 0.01em;">
                                    Para confirmar esta creación pulse el siguiente enlace. 
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 24px 0;">
                                  <a class="button" href="'. $_ENV['APP_URL'] ."/auth/confirmar_cuenta?token=" . $this->token . '" title="Reset Password" style="width: 100%; background: #22D172; text-decoration: none; display: inline-block; padding: 10px 0; color: #fff; font-size: 14px; line-height: 21px; text-align: center; font-weight: bold; border-radius: 7px;">Confirmar Usuario</a>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 60px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                    Si no confirmas la creación, la cuenta no será habilitada y el usuario no podrá acceder al sistema .
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 16px;">
                                  <span style="display: block; width: 100%; border-bottom: 1px solid #8B949F;"></span>
                                </td>
                              </tr>
                              <tr>
                                <td style="font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                  Atentamente, <br><strong>Bay Island Cruises</strong>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 24px 0 48px; font-size: 0px;">
                          <!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0">        <tr>          <td style="vertical-align:top;width:300px;">      <![endif]-->
                          <div class="outlook-group-fix" style="padding: 0 0 20px 0; vertical-align: top; display: inline-block; text-align: center; width:100%;">
                            <span style="padding: 0; font-size: 11px; line-height: 15px; font-weight: normal; color: #8B949F;">Bay Island Cruises SRL<br/>Inventario Web</span>
                          </div>
                          <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </body>
        </html>
        ';

        // Asigna contenido en el cuerpo del correo
        $correo->Body = $contenido;

        // Envia el correo
        $correo->send();
    }

    public function enviarIntruccionesPassword() {
         // Crear el objeto del correo
         $correo = new PHPMailer();
         $correo->isSMTP();
         $correo->Host = $_ENV['EMAIL_HOST'];
         $correo->SMTPAuth = true;
         $correo->Port = $_ENV['EMAIL_PORT'];
         $correo->Username = $_ENV['EMAIL_USER'];
         $correo->Password = $_ENV['EMAIL_PASS'];

        // Set HTML
        $correo->isHTML(TRUE);
        $correo->CharSet = 'UTF-8';

        // Datos Remitente y Receptor
        $correo->setFrom('
        testingvlnz@gmail.com');
        $correo->addAddress($this->correo, 'bayislandcruises.com');
        $correo->Subject = 'Sigue las instrucciones para cambiar tu contraseña temporal';

        // Contenido del correo
        $contenido = '<!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml">
        
        <head>
          <title></title>
          <!--[if !mso]><!-- -->
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <!--<![endif]-->
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <style type="text/css">
            #outlook a {
              padding: 0;
            }
        
            .ReadMsgBody {
              width: 100%;
            }
        
            .ExternalClass {
              width: 100%;
            }
        
            .ExternalClass * {
              line-height: 100%;
            }
        
            body {
              margin: 0;
              padding: 0;
              -webkit-text-size-adjust: 100%;
              -ms-text-size-adjust: 100%;
            }
        
            table,
            td {
              border-collapse: collapse;
              mso-table-lspace: 0pt;
              mso-table-rspace: 0pt;
            }
        
          </style>
          <!--[if !mso]><!-->
          <style type="text/css">
            @media only screen and (max-width:480px) {
              @-ms-viewport {
                width: 320px;
              }
              @viewport {
                width: 320px;
              }
            }
          </style>
          <!--<![endif]-->
          <!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]-->
          <!--[if lte mso 11]><style type="text/css">  .outlook-group-fix {    width:100% !important;  }</style><![endif]-->
          <!--[if !mso]><!-->
          <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" type="text/css">
          <style type="text/css">
            @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap");
          </style>
          <!--<![endif]-->
          <style type="text/css">
            @media only screen and (max-width:595px) {
              .container {
                width: 100% !important;
              }
              .button {
                display: block !important;
                width: auto !important;
              }
            }
          </style>
        </head>
        
        <body style="font-family: "Inter", sans-serif; background: #E5E5E5;">
          <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#F6FAFB">
            <tbody>
              <tr>
                <td valign="top" align="center">
                  <table class="container" width="600" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                      <tr>
                        <td style="padding:48px 0 30px 0; text-align: center; font-size: 14px; color: #4C83EE;">
                          <img src="https://mailsend-email-assets.mailtrap.io/vttefb5mshsodyi4ee9vqu46vzur.png" style="width:250px;">
                        </td>
                      </tr>
                      <tr>
                        <td class="main-content" style="padding: 48px 30px 40px; color: #000000;" bgcolor="#ffffff">
                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td style="padding: 0 0 24px 0; font-size: 18px; line-height: 150%; font-weight: bold; color: #000000; letter-spacing: 0.01em;">
                                <h2 class="default-heading2" style="text-align: center; color: #1f2d3d; font-family: arial,helvetica,sans-serif; font-size: 32px; word-break: break-word;">¡Envia las instrucciones!</h2>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 10px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                  Has solicitado el cambio de contraseña para: <span>'. $this->correo .'</span>.
                                </td>
                            <tr> 
                                <td style="padding: 0 0 10px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                Para reestablecer tu contraseña debes seguir las siguientes instrucciones para realizar el cambio de tu contraseña temporal. Para ello da click en el siguiente botón.
                                </td>
                            </tr>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 16px 0; font-size: 14px; line-height: 150%; font-weight: 700; color: #000000; letter-spacing: 0.01em;">
                                  Presiona el siguiente enlace para realizar el cambio.
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 24px 0;">
                                  <a class="button" href="'. $_ENV['APP_URL'] ."/auth/olvide_password?token=" . $this->token . '" title="Reset Password" style="width: 100%; background: #22D172; text-decoration: none; display: inline-block; padding: 10px 0; color: #fff; font-size: 14px; line-height: 21px; text-align: center; font-weight: bold; border-radius: 7px;">Enviar Instrucciones</a>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 10px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                  La contraseña actual es temporal y necesitarás cambiarla para tener más seguridad.
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 60px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                  Si no solicitaste este cambio, solo ignora este correo o ponte en contacto con soporte <a href="">testingvlnz@gmail.com</a>.
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 16px;">
                                  <span style="display: block; width: 100%; border-bottom: 1px solid #8B949F;"></span>
                                </td>
                              </tr>
                              <tr>
                                <td style="font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                  Atentamente, <br><strong>Bay Island Cruises</strong>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 24px 0 48px; font-size: 0px;">
                          <!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0">        <tr>          <td style="vertical-align:top;width:300px;">      <![endif]-->
                          <div class="outlook-group-fix" style="padding: 0 0 20px 0; vertical-align: top; display: inline-block; text-align: center; width:100%;">
                            <span style="padding: 0; font-size: 11px; line-height: 15px; font-weight: normal; color: #8B949F;">Bay Island Cruises SRL<br/>Inventario Web</span>
                          </div>
                          <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </body>
        </html>
        ';

        // Asigna contenido en el cuerpo del correo
        $correo->Body = $contenido;

        // Envia el correo
        $correo->send();
    }

    public function enviarInstrucciones() {
         // Crear el objeto del correo
         $correo = new PHPMailer();
         $correo->isSMTP();
         $correo->Host = $_ENV['EMAIL_HOST'];
         $correo->SMTPAuth = true;
         $correo->Port = $_ENV['EMAIL_PORT'];
         $correo->Username = $_ENV['EMAIL_USER'];
         $correo->Password = $_ENV['EMAIL_PASS'];

        // Set HTML
        $correo->isHTML(TRUE);
        $correo->CharSet = 'UTF-8';

        // Datos Remitente y Receptor
        $correo->setFrom('
        testingvlnz@gmail.com');
        $correo->addAddress($this->correo, 'bayislandcruises.com');
        $correo->Subject = 'Reestablece tu contraseña';

        // Contenido del correo
        $contenido = '<!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml">
        
        <head>
          <title></title>
          <!--[if !mso]><!-- -->
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <!--<![endif]-->
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <style type="text/css">
            #outlook a {
              padding: 0;
            }
        
            .ReadMsgBody {
              width: 100%;
            }
        
            .ExternalClass {
              width: 100%;
            }
        
            .ExternalClass * {
              line-height: 100%;
            }
        
            body {
              margin: 0;
              padding: 0;
              -webkit-text-size-adjust: 100%;
              -ms-text-size-adjust: 100%;
            }
        
            table,
            td {
              border-collapse: collapse;
              mso-table-lspace: 0pt;
              mso-table-rspace: 0pt;
            }
        
          </style>
          <!--[if !mso]><!-->
          <style type="text/css">
            @media only screen and (max-width:480px) {
              @-ms-viewport {
                width: 320px;
              }
              @viewport {
                width: 320px;
              }
            }
          </style>
          <!--<![endif]-->
          <!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]-->
          <!--[if lte mso 11]><style type="text/css">  .outlook-group-fix {    width:100% !important;  }</style><![endif]-->
          <!--[if !mso]><!-->
          <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" type="text/css">
          <style type="text/css">
            @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap");
          </style>
          <!--<![endif]-->
          <style type="text/css">
            @media only screen and (max-width:595px) {
              .container {
                width: 100% !important;
              }
              .button {
                display: block !important;
                width: auto !important;
              }
            }
          </style>
        </head>
        
        <body style="font-family: "Inter", sans-serif; background: #E5E5E5;">
          <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#F6FAFB">
            <tbody>
              <tr>
                <td valign="top" align="center">
                  <table class="container" width="600" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                      <tr>
                        <td style="padding:48px 0 30px 0; text-align: center; font-size: 14px; color: #4C83EE;">
                          <img src="https://mailsend-email-assets.mailtrap.io/vttefb5mshsodyi4ee9vqu46vzur.png" style="width:250px;">
                        </td>
                      </tr>
                      <tr>
                        <td class="main-content" style="padding: 48px 30px 40px; color: #000000;" bgcolor="#ffffff">
                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td style="padding: 0 0 24px 0; font-size: 18px; line-height: 150%; font-weight: bold; color: #000000; letter-spacing: 0.01em;">
                                <h2 class="default-heading2" style="text-align: center; color: #1f2d3d; font-family: arial,helvetica,sans-serif; font-size: 32px; word-break: break-word;">¡Reestablece tu contraseña!</h2>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 10px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                    Hola <strong>'. $this->nombre .'</strong>. 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    Has solicitado reestablecer tu contraseña del usuario con correo <strong>' . $this->correo . '</strong>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 16px 0; font-size: 14px; line-height: 150%; font-weight: 700; color: #000000; letter-spacing: 0.01em;">
                                  Presiona el siguiente enlace para realizar el cambio.
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 24px 0;">
                                  <a class="button" href="'. $_ENV['APP_URL'] ."/auth/cambiar_password?token=" . $this->token . '" title="Reset Password" style="width: 100%; background: #22D172; text-decoration: none; display: inline-block; padding: 10px 0; color: #fff; font-size: 14px; line-height: 21px; text-align: center; font-weight: bold; border-radius: 7px;">Reestablecer Contraseña</a>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 60px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                  Si no solicitaste este cambio, solo ignora este correo o ponte en contacto con soporte <a href="">testingvlnz@gmail.com</a>.
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0 0 16px;">
                                  <span style="display: block; width: 100%; border-bottom: 1px solid #8B949F;"></span>
                                </td>
                              </tr>
                              <tr>
                                <td style="font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                  Atentamente, <br><strong>Bay Island Cruises</strong>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 24px 0 48px; font-size: 0px;">
                          <!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0">        <tr>          <td style="vertical-align:top;width:300px;">      <![endif]-->
                          <div class="outlook-group-fix" style="padding: 0 0 20px 0; vertical-align: top; display: inline-block; text-align: center; width:100%;">
                            <span style="padding: 0; font-size: 11px; line-height: 15px; font-weight: normal; color: #8B949F;">Bay Island Cruises SRL<br/>Inventario Web</span>
                          </div>
                          <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </body>
        </html>
        ';

        // Asigna contenido en el cuerpo del correo
        $correo->Body = $contenido;

        // Envia el correo
        $correo->send();
    }

}
