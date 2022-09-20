<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link href="{{ asset('assets/template/fonts/fontawesome-5.0.6/css/fontawesome-all.css') }}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

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
            background-color: #e0e0e0;
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
        .spanBorder {
            width: 10px;
            background-color: #eec535;
            color: #eec535;
            border-radius: 5px;
            padding: 3px 1px 0px 1px;
        }

        .spanTitle {
            font-size: 16px;
            font-weight: bold;
        }

        .documentInfo {
            font-size: 16px;
            margin-left: 16px;
        }

        .lblDatos {
            font-size: 15px;
            font-weight: bold;
            color: #212529;
        }

        .pDatos {
            font-size: 16px;
            color: #212529;
        }
    </style>
</head>

<body>

    <!-- Titulo y subtilo del trámite -->
    <div style="padding: 15px;">
        <h2>{{$tramite['nombre']}}</h2>
        <h2 class="subtitulo">{{$tramite['responsable']}}</h2>
    </div>
    <div style="padding: 15px; padding-top:5px; padding-bottom:0px;">
        <h2>Descripción del trámite</h2>
        <p class="pDatos">{!! $tramite['descripcion'] !!}</p>
    </div>
    <div style="padding: 15px; padding-top:5px; padding-bottom:0px;">
        <h2>Información General</h2>
        @foreach($tramite['informacion_general'] as $informacion)
            <label class="lblDatos">{{$informacion['titulo']}}</label>
            <p class="pDatos">{!! $informacion['descripcion'] !!}</p>
        @endforeach
    </div>
    <div style="padding: 15px; padding-top:5px; padding-bottom:0px;">
        <h2>Oficinas donde se puede realizar el trámite</h2>
        @foreach($tramite['oficinas'] as $oficinas)
            <div class="documentTitle">
                <span class="spanBorder">.</span>
                <span class="spanTitle">{{$oficinas['nombre']}}</span>
                <div class="documentInfo">
                    <span style="width: 100%;">Dirección: {!! $oficinas['direccion'] !!}</span><br/>
                    <span style="width: 100%;">Contacto: {!! $oficinas['contacto_telefono'] !!}</span><br/>
                    <span style="width: 100%;">Información adicional: {!! $oficinas['informacion_adicional'] !!}</span>
                </div>
            </div>
            <br>
        @endforeach
    </div>
    <div style="padding: 15px; padding-top:5px; padding-bottom:0px;">
        <h2>¿Qué necesito para realizarlo?</h2>
        @foreach($tramite['requerimientos'] as $informacion)
            <label class="lblDatos">{{$informacion['titulo']}}</label>
            <p class="pDatos">{!! $informacion['descripcion'] !!}</p>
            @if(count($informacion['opciones'])> 0)
                @foreach($informacion['opciones'] as $opcion)
                    <p class="pDatos">{!! $opcion !!}</p>
                @endforeach
            @endif
            @if(count($informacion['documentos'])> 0)
                @foreach($informacion['documentos'] as $documento)
                    <div class="documentTitle">
                        <span class="spanBorder">.</span>
                        <span class="spanTitle">{{$documento['nombre']}}</span>
                        <div class="documentInfo">
                            <span style="width: 100%;">Presentación: {{$documento['presentacion']}}</span>
                            <span style="width: 100%;">Observaciones: {{$documento['observaciones']}}</span>
                        </div>
                    </div>
                    <br>
                @endforeach
            @endif
        @endforeach
    </div>
    <div style="padding: 15px; padding-top:5px; padding-bottom:0px;">
        <h2>¿Qué puedo encontrar en línea?</h2>
        @foreach($tramite['en_linea'] as $linea)
            <label class="lblDatos">{{$linea['titulo']}}</label>
            <p class="pDatos">{!! $linea['descripcion'] !!}</p>
            @if(count($linea['opciones'])> 0)
                @foreach($linea['opciones'] as $opcion)
                    <p class="pDatos">{!! $opcion !!}</p>
                @endforeach
            @endif
            @if(count($linea['documentos'])> 0)
                @foreach($linea['documentos'] as $documento)
                    <div class="documentTitle">
                        <span class="spanBorder">.</span>
                        <span class="spanTitle">{{$documento['nombre']}}</span>
                        <div class="documentInfo">
                            <span style="width: 100%;">Presentación: {{$documento['presentacion']}}</span>
                            <span style="width: 100%;">Observaciones: {{$documento['observaciones']}}</span>
                        </div>
                    </div>
                    <br>
                @endforeach
            @endif
        @endforeach
    </div>    
    <div style="padding: 15px; padding-top:5px; padding-bottom:0px;">
        <h2>¿El trámite tiene algún costo?</h2>
        @foreach($tramite['costo'] as $costo)
            <label class="lblDatos">{{$costo['titulo']}}</label>
            <p class="pDatos">{!! $costo['descripcion'] !!}</p>
            @if(count($costo['opciones'])> 0)
                @foreach($costo['opciones'] as $opcion)
                <p class="pDatos">{{$opcion}}</p>
                @endforeach
            @endif
            @if(count($costo['documentos'])> 0)
                @foreach($costo['documentos'] as $documento)
                    <div class="documentTitle">
                        <span class="spanBorder">.</span>
                        <span class="spanTitle">{{$documento['nombre']}}</span>
                        <div class="documentInfo">
                            <span style="width: 100%;">{{$documento['direccion']}}</span>
                            <span style="width: 100%; font-size: small; font-weight: 600;">Responsable: {{$documento['responsable']}}</span>
                            <span style="width: 100%; font-size: small; font-weight: 600;">Contacto: {{$documento['contacto_telefono']}}</span>
                        </div>
                    </div>
                    <br>
                @endforeach
            @endif
        @endforeach
    </div>
    <div style="padding: 15px; padding-top:5px; padding-bottom:0px;">
        <h2>Fundamento legal</h2>
        @foreach($tramite['fundamento_legal'] as $fundamento)
            <label class="lblDatos">{{$fundamento['titulo']}}</label>
            <p class="pDatos">{!! $fundamento['descripcion'] !!}</p>
            @if(count($fundamento['adicional'])> 0)
                @foreach($fundamento['adicional'] as $adicional)
                    <div class="documentTitle">
                        <span class="spanBorder">.</span>
                        <span class="spanTitle">{{$adicional['titulo']}}</span>
                        <div class="documentInfo">
                            <span style="width: 100%;">{{$adicional['descripcion']}}</span>
                        </div>
                    </div>
                    <br>
                @endforeach
            @endif
        @endforeach
    </div>


    {{-- <script src="{{ asset('assets/template/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery-ui.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
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


    <script type="text/javascript">
        var list_documentos = [];
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>

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
