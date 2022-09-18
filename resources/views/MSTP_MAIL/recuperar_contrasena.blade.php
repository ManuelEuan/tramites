<!DOCTYPE html>
<html>
<head>
    <title>Recuperar contraseña</title>
    <style>

        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #fff;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

            table table table {
                table-layout: auto;
            }

        img {
            -ms-interpolation-mode: bicubic;
        }

        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: underline !important;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .cont-60 {
            width: 60%;
            margin: auto;
        }

        .cont-30 {
            width: 30%;
            margin: auto;
        }
        .recuperarbtn{
            color: #fff !important;
            background-color: #23468c;
            padding: 10px 30px 10px 30px;
     
        }
    </style>
</head>
<body>
    <table class="cont-60">
        <tr>
            <td class="text-center"><h4> Trámites Digitales Querétaro </h4> </td>
        </tr>
        <tr>
        <!--
            <td class="text-center">
                <img src="https://sigetys.azurewebsites.net/assets/template/img/logo_edo_admin.png" style="width: 100px;
                margin: auto;">
            </td>-->
        </tr>
    </table>
    <table class="cont-60">
        <tr>
            <td class="text-left">
              <br/>
              <p>
                <b>Estimado(a) {{$StrUsuario}}</b>
              </p>
                <p>
                    Recientemente se solicitó el restablecimiento de su contraseña para acceder al Sistema de Trámites Digitales Querétaro.
                </p>
            </td>
        </tr>
    </table>
    <br />
    <table class="cont-60">
        <tr>
            <td class="text-left">
                <p>
                    Para continuar, favor de dar clic en el siguiente enlace:
                </p>
            </td>
        </tr>
    </table>
    <br />
    <table class="cont-60">
        <tr>
            <td class="text-center" style="text-align:center">
                <a href="{{$StrUrl}}" class="recuperarbtn" style="border:15px solid #23468c;background-color:#23468c;color:#FFF;font-size:14px; font-family:Arial;text-decoration:none" target="_blank">Recuperar contraseña</a>  
            </td>
        </tr>
        <tr>
            <td class="text-left">
              <br/>
                <p>
                    Si usted no ha solicitado el restablecimiento de contraseña, haga caso omiso a este correo.
                </p>
            </td>
        </tr>
        <tr>
            <td class="text-center"><br />
              <br/><b>Atentamente</b><br />Sistema de Trámites Digitales Querétaro
            </td>
        </tr>
    </table>
</body>
</html>