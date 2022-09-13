<!DOCTYPE html>
<html>
<head>
    <title>Aviso</title>
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
            <td class="text-center"><h4>Sistema de Tramites Digitales Queretaro</h4> </td>
        </tr>
        <tr>
            {{-- <td class="text-center">
                <img src="https://sigetys.azurewebsites.net/assets/template/img/logo_edo_admin.png" style="width: 100px;
                margin: auto;">
            </td> --}}
        </tr>
    </table>
    <table class="cont-60">
        <tr>
            <td class="text-left">
              <br/>
              <p>
                <b>Asunto: Aviso de sobre trámite con folio {{$_folio_tramite}}</b>
              </p>
                <p>
                    Apreciable {{$_nombre_usuario}}:
                </p>
            </td>
        </tr>
    </table>
    <br />
    <table class="cont-60">
        <tr>
            <td class="text-left">
                <p>
                    Le informamos que a través del Sistema se presentó una nueva notificación sobre su trámite {{$_nombre_tramite}} con folio {{$_folio_tramite}}.
                </p>
            </td>
        </tr>
        <tr>
            <td class="text-left">
                Folio: {{$_folio_tramite}}
            </td>
        </tr>
        <!-- <tr>
            <td class="text-left">
                Homoclave: {{$_homoclave_tramite}}
            </td>
        </tr> -->
        <tr>
            <td class="text-left">
                Nombre del trámite: {{$_nombre_tramite}}
            </td>
        </tr>
        <tr>
            <td class="text-left">
                Unidad Administrativa: {{$_unidad_administrativa}}
            </td>
        </tr>
        <tr>
            <td class="text-left">
                Secretaría o entidad: {{$_secretaria}}
            </td>
        </tr>
        <tr>
            <td class="text-left">
                Fecha y hora {{$_fecha_hora}}.
            </td>
        </tr>
        <!-- <tr>
            <td class="text-left">
                Fecha máxima para atender notificación: {{$_fecha_maxima}}
            </td>
        </tr> -->
    </table>
    <br />
    <table class="cont-60">
        <tr>
            <td class="text-center"><br />
              <br/><b>Atentamente</b><br />Sistema de Tramites Digitales Queretaro
            </td>
        </tr>
    </table>
</body>
</html>
