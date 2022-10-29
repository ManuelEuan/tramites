<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{ asset('assets/template/img/favicon_queretaro/android-chrome.png') }}" rel="shortcut icon">
    <link href="{{ asset('assets/template/css/bootstrap.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/template/plugins/Datepicker/css/bootstrap-datepicker.standalone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/template/plugins/Fullcalendar/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/template/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" />

    <link href="{{ asset('assets/template/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/formvalidation.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/bootstrap-combobox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/style.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/template/fonts/fontawesome-5.0.6/css/fontawesome-all.css') }}" rel="stylesheet"> --}}

    <style>
        /* CSS Manuel Euan */
        .titulo {
            width: 100%;
            height: 40px;
            border-top-right-radius: 60px;
            border-bottom-right-radius: 60px;
            margin-top: 2%;
            display: flex;
            align-items: center;
            z-index: -1;
            color: #575654;
            font-size: 32px;
        }

        .subtitulo {
            color: #F8B30A;
            font-size: 22px;
        }

        .pestana {
            min-height: 700px;
        }

        .btnLetras {
            color: #fff;
            font-weight: 900;
            margin-left: 20px;
            min-width: 180px;
        }

        .titulo_pequeno {
            color: #000000;
            font-weight: bold;
            font-size: 18px;
        }

        .respuesta_pequena {
            color: #000000;
            font-size: 18px;
        }

        .columna {
            margin-top: 2%;
            margin-left: 2%;
            "

        }

        /* CSS Buscador */
        .container-1 {
            text-align: center;
        }

        .container-1 input#search {
            width: 87%;
            height: 50px;
            font-size: 10pt;
            float: center;
            color: #63717f;
            padding-left: 5%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 60px;
        }

        .container-1 .icon {
            position: absolute;
            top: 20%;
            font-size: 20px;
            margin-left: 17px;
            margin-top: 17px;
            z-index: 1;
            color: #4f5b66;
        }

        .container-1 input#search:hover,
        .container-1 input#search:focus,
        .container-1 input#search:active {
            outline: none;
            background: #ffffff;
        }


        .formulario_ {
            
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .nameSection {
            background-color: #e0e0e0;
            border: solid 2px #fff;
            text-align: left;
            font-size: 16px;
            padding: 8px;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>

<body>
    <div style="padding: 15px;">
        <table>
            <thead>
                <tr>
                    <th style="padding-right: 150px;"><img src="{{ asset('assets/template/img/logopdf.png') }}" width="200 " height="47"></th>
                    <th><center>{{$tramite->USTR_CNOMBRE_TRAMITE}}</center></th>
                </tr>
            </thead>
        </table>
        <br>
        <?php $tipoPer = Auth::user()->USUA_NTIPO_PERSONA; ?>
        <table style="width:100%;">
            <thead>
                <tr>
                    <th style="font-size:18px;"><center>Inscripción</center></th>
                    <th style="font-size:18px;"><center>Contribuyente</center></th>
                    <th style="font-size:18px;"><center>Ubicación</center></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="padding-left: 50px;">
                            <label>Inscripción</label><input type="checkbox">
                            <label>Refrendo</label><input type="checkbox" checked>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 50px;">
                            <label>Persona Física</label><input type="checkbox" <?php if ($tipoPer == 'FISICA') { echo 'checked';  } ?>>
                            <label>Persona Moral</label><input type="checkbox" <?php if ($tipoPer == 'MORAL') { echo 'checked';  } ?>>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 50px;">
                            <label>Local</label><input type="checkbox">
                            <label>Foráneo</label><input type="checkbox">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Titulo y subtilo del trámite -->
    <!--<div style="padding: 15px;">
        <h2></h2>
        <h2 class="subtitulo">{{$tramite->USTR_CCENTRO}}</h2>
    </div>-->

    <!--<div style="padding: 15px;">
        <table style="width:100%; font-size:18px;">
            <tr>
                <th align="left">Nombre</th>
                <th align="left">Primer Apellido</th>
                <th align="left">Segundo Apellido</th>
            </tr>
            <tr>
                <td>{{strtoupper($tramite->USTR_CNOMBRE)}}</td>
                <td>{{strtoupper($tramite->USTR_CPRIMER_APELLIDO)}}</td>
                <td>{{strtoupper($tramite->USTR_CSEGUNDO_APELLIDO)}}</td>
            </tr>
            <tr style="margin-top: 10px;">
                <th align="left">RFC</th>
                <th align="left">CURP</th>
                <th align="left">FOLIO</th>
            </tr>
            <tr>
                <td>{{strtoupper($tramite->USTR_CRFC)}}</td>
                <td>{{strtoupper($tramite->USTR_CCURP)}}</td>
                <td>{{strtoupper($tramite->USTR_CFOLIO)}}</td>
            </tr>
        </table>
    </div>-->

    <!--<h3 style="width: 100%; text-align:center;">FORMULARIO</h3> -->
    <?php $contador = 0; ?>
    <?php $cerrado = true; ?>
    @foreach($formularios->secciones as $seccion)
        @if(count($seccion->preguntas) > 0)
            <div style="padding: 15px; padding-top:5px; padding-bottom:0px;">
                <h4 style="padding:5px; margin:0px; width: 100%; text-align:left; background-color:#e0e0e0; ">{{$seccion->FORM_CNOMBRE}}</h5>
            </div>
            <table>
                <tbody>
                    @foreach($seccion->preguntas as $pregunta)
                        <?php $contador++; ?>
                        <?php if($cerrado) echo '<tr>';?>
                        <td>
                            <div style="padding: 15px; padding-top:10px; padding-bottom:0px;">
                                <h4 style="padding:5px; margin:0px; width: 100%; text-align:left;">{{$pregunta->FORM_CPREGUNTA}}</h5>
                            </div>
                            <!-- Verificacion el tipo de pregunta -->
                            @switch($pregunta->FORM_CTIPORESPUESTA)
                                @case('abierta')
                                    <div style="padding: 10px; padding-left:25px; padding-top:0px; padding-bottom:0px;">
                                        <p>
                                            @if(count($pregunta->respuestas)>0)
                                                {{ $pregunta->respuestas[0]->FORM_CVALOR_RESPUESTA }}
                                            @endif
                                        </p>
                                    </div>
                                    @break
                                @case('unica')
                                    <div style="padding: 15px; padding-left:25px; padding-top:0px; padding-bottom:0px;">
                                        @foreach($pregunta->respuestas as $respuesta)
                                            <input {{$respuesta->FORM_CVALOR_RESPUESTA}} style="width: 20px; height: 20px;" class="form-check-input" type="radio">
                                                <label style="padding-top: 4px; padding-left: 8px; font-size: 14px;" class="form-check-label">{{$respuesta->FORM_CVALOR}}</label>
                                            <br>
                                        @endforeach
                                    </div>
                                    @break
                                @case('especial')
                                    <div style="padding: 15px; padding-left:25px; padding-top:0px; padding-bottom:0px;">
                                        <table style="border-collapse: collapse; width: 100%;">
                                            <tr style="background-color: rgb(0, 0, 0, 0.05);">
                                                @foreach($pregunta->respuestas as $respuesta)
                                                    <th style="padding: 5px; border: 1px solid #dee2e6;">{{$respuesta->FORM_CVALOR}}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach($pregunta->respuestas as $respuesta)
                                                    @switch($respuesta->FORM_CTIPORESPUESTAESPECIAL)
                                                        @case('numerico')
                                                            @if(count($respuesta->respuestas_especial)>0)
                                                                <td style="padding: 5px; border: 1px solid #dee2e6;">{{$respuesta->respuestas_especial[0]->FORM_CVALOR_RESPUESTA}}</td>
                                                            @else
                                                                <td style="padding: 5px; border: 1px solid #dee2e6;"></td>
                                                            @endif
                                                        @break
    
                                                        @case('opciones')
                                                            @if(count($respuesta->respuestas_especial)>0)
                                                                @foreach($respuesta->respuestas_especial as $opciones)
                                                                    @if($opciones->FORM_CVALOR_RESPUESTA == 'selected')
                                                                        <td style="padding: 5px; border: 1px solid #dee2e6;">{{$opciones->FORM_CVALOR}}</td>
                                                                    @break
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <td style="padding: 5px; border: 1px solid #dee2e6;"></td>
                                                            @endif
                                                        @break
    
                                                        @default
                                                            @if(count($respuesta->respuestas_especial)>0)
                                                                <td style="padding: 5px; border: 1px solid #dee2e6;">{{$respuesta->respuestas_especial[0]->FORM_CVALOR_RESPUESTA}}</td>
                                                            @else
                                                                <td style="padding: 5px; border: 1px solid #dee2e6;"></td>
                                                            @endif
                                                    @endswitch
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                    @break
                                @case('enriquecido')
                                    <div style="padding: 15px; padding-left:25px; padding-top:0px; padding-bottom:0px;">
                                        @if(count($pregunta->respuestas)>0)
                                            {!! $pregunta->respuestas[0]->FORM_CVALOR_RESPUESTA !!}
                                        @else
                                        @endif
                                    </div>
                                    @break
                                @case('multiple')
                                    <div style="padding: 15px; padding-left:25px; padding-top:0px; padding-bottom:0px;">
                                        @foreach($pregunta->respuestas as $respuesta)
                                            <input {{$respuesta->FORM_CVALOR_RESPUESTA}} style="width: 20px; height: 20px;" type="checkbox">
                                            <label style="padding-left: 8px; font-size: 14px;" class="form-check-label">{{$respuesta->FORM_CVALOR}}</label>
                                            <br>
                                        @endforeach
                                    </div>
                                    @break
                                @case('catalogo')
                                    <div style="padding: 15px; padding-left:25px; padding-top:0px; padding-bottom:0px;">
                                        @foreach($pregunta->respuestas as $respuesta)
                                            <p>
                                                @if(count($pregunta->respuestas)>0)
                                                <ul>
                                                        @if(isset($pregunta->respuestas[0]->FORM_CVALOR_RESPUESTA[0]))
                                                            @foreach($pregunta->respuestas[0]->FORM_CVALOR_RESPUESTA as $v)
                                                            <li>
                                                                @if(isset($v->fecha))
                                                                    <label><b>Nombre:</b> {{$v->nombre}}, <b>Fecha:</b> {{$v->fecha}}</label>
                                                                    <br>
                                                                    <label><b>Descripción</b> {{$v->descripcion}}</label>
                                                                    <br>
                                                                @else
                                                                    <label><b>Nombre:</b> {{$v->nombre}}</label>
                                                                    <br>
                                                                    <label><b>Descripción</b> {{$v->descripcion}}</label>
                                                                    <br>
                                                                @endif
                                                            </li>
                                                            @endforeach
                                                        @endif
                                                </ul>
                                                @endif
                                                
                                            </p>
                                        @endforeach
                                    </div>
                                    @break
                                @default
                            @endswitch
                        </td>
                        <?php if($contador == 1 || $contador == 3 || $contador == 7 || $contador == 10 || $contador == 13 || $contador == 15 || $contador == 16 || $contador == 17 || $contador == 18 || $contador == 19 || $contador == 20 ) {echo '</tr>'; $cerrado = true; } else {$cerrado = false;}?>
                        <!-- Fin Verificamos el tipo de pregunta -->
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
    <br>
    <br>
    <hr>
    <div style="padding: 15px;">
        <label style="font-size: 30px;">
            *Las notificaciones relacionadas con los trámites y procedimientos de su solicitud serán a través del correo electrónico indicado como administrador de su empresa que señala en la solicitud de registro.
            *El proveedor se obliga a informar por escrito a esta Dirección de Adquisiciones sobre cualquier modificación relacionada a los documentos presentados y a esta solicitud.
            *Que el solicitante declara que es sabedor de las sanciones establecidas en el artículo 277 del Código Penal para el Estado de Querétaro en caso conducirse con falsedad ante esta Dirección de Adquisiciones.
            *Manifiesta que conoce nuestro aviso de privacidad, mismo que se encuentra para su consulta en la dirección electrónica:
            <a style="color: blue;" href="http://www.queretaro.gob.mx/ShowAs.aspx?Nombre=174835516_A.Simplificado_Adq_07jun18.pdf&Ruta=Uploads\Formato_Art66FLXVII_2\174835516_A.Simplificado_Adq_07jun18.pdf">http://www.queretaro.gob.mx/ShowAs.aspx?Nombre=174835516_A.Simplificado_Adq_07jun18.pdf&Ruta=Uploads\Formato_</a> <br>
            <a style="color: blue;" href="http://www.queretaro.gob.mx/ShowAs.aspx?Nombre=174835516_A.Simplificado_Adq_07jun18.pdf&Ruta=Uploads\Formato_Art66FLXVII_2\174835516_A.Simplificado_Adq_07jun18.pdf">Art66FLXVII_2\174835516_A.Simplificado_Adq_07jun18.pdf</a>
        </label>

    </div>
    <br>
    <div style="padding: 15px; padding-left: 130px;">
        <table>
            <thead>
                <tr>
                    <th>
                        <h4 style="padding:5px; margin:0px; width: 100%; text-align:left; background-color:#e0e0e0; ">.</h5>
                    </th>
                    <th style="padding: 15px;"></th>
                    <th>
                        <h4 style="padding:5px; margin:0px; width: 100%; text-align:left; background-color:#e0e0e0; ">.</h5>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <center>
                            Firma <br>
                            (Persona Física o Representante Legal)
                        </center>
                    </td>
                    <td style="padding: 15px;"></td>
                    <td>
                        <center>
                            Revisó <br>
                            Jefe del Departamento de Atención a Requisiciones <br>
                            C.P Claudia Guerra Acevedo
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    

    {{-- <script src="{{ asset('assets/template/js/jquery.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script src="{{ asset('assets/template/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/template/js/popper.min.js') }}"></script>

    <script src="{{ asset('assets/template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/framework/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/sweet-alert.init.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/bootstrap-combobox.js') }}"></script>
    <script src="{{ asset('assets/template/js/Moment.js') }}"></script>

    <script src="{{ asset('assets/template/plugins/Datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/Datepicker/js/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/Fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/Fullcalendar/locales-all.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

    {{-- Here's the magic. This MUST be inside body tag. Page count / total, centered at bottom of page --}}
    <script type="text/php">
        if(isset($pdf)) {
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>

</body>

</html>
