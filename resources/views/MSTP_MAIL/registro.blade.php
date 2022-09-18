<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Registro</title>
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
    </style>
</head>
<body>
    <table class="cont-60">
        <tr>
            <td class="text-center"><h4>¡Bienvenido!</h4> </td>
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
                <br />
                <p>
                    Le informamos que se le ha generado un perfil para acceder al Sistema.
                    Al respecto, los datos registrados son los que se muestran a continuación:

                </p>
            </td>
        </tr>
    </table>
    <br />
    <table class="cont-30">
        <tr>
            <td class="text-left">
                <p><b>Nombre (s):</b> {{$StrNombres}}</p>
            </td>
        </tr>
        <tr>
            <td class="text-left">
                <p><b>Apellidos:</b> {{$StrApellidos}}</p>
            </td>
        </tr>
        <tr>
            <td class="text-left">
                <p><b>Correo electrónico:</b> {{$StrCorreoElectronico}}</p>
            </td>
        </tr>
        <tr>
            <td class="text-left">
                <p><b>RFC:</b> {{$StrRFC}}</p>
            </td>
        </tr>
    </table>
    <br />
    <table class="cont-60">
        <tr>
            <td class="text-left">
                <p>
                    Para poder acceder al Sistema, podrá utilizar la siguiente liga electrónica:
                </p>
            </td>
        </tr>
    </table>
    <br />
    <table class="cont-60">
        <tr>
            <td class="text-center"><a href="{{$StrHost}}" target="_blank"><button class="btn btn-info">{{$StrHost}}</button></a></td>
        </tr>
        <tr>
            <td class="text-center"><br /><b>Atentamente</b><br />Sistema de Trámites Digitales Querétaro</td>
        </tr>
    </table>
</body>
</html>