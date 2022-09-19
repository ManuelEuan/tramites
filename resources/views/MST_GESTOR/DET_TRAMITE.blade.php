@extends('layout.Layout')

@section('body')
<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div class="row">
        <div class="col-md-12" style="text-align: right;">
            <h2 class="titulo">{{$tramite['nombre']}}</h2>
            <h6 class="text-warning">{{$tramite['responsable']}}</h6>
        </div>
    </div>
    <div class="row" style="height: calc(100% - 92px);">
        <div class="col-md-8" style="text-align: left;">
            <h2>Descripción del trámite</h2>
            <h6>{{$tramite['descripcion']}}</h6>
            <br>
            <div>
                <a href="{{route('gestor_index')}}" id="btn_impirmir" class="btn btn-sm btn-danger" style="margin: 2px;">Cancelar</a>
                @if(Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE != 'ANTA' )
                    @if(request()->route('tramiteIDConfig') !== null && request()->route('tramiteIDConfig') > 0)
                    <a href="{{route('gestor_configurar_tramite', ['tramiteID' => request()->route('tramiteID'), 'tramiteIDConfig' => request()->route('tramiteIDConfig')])}}" id="btn_iniciar_tramite" class="btn btn-sm btn-primary" style="margin: 2px;">Iniciar configuración de trámite</a>
                    @else
                    <a href="{{route('gestor_configurar_tramite', ['tramiteID' => request()->route('tramiteID'), 'tramiteIDConfig' => 0])}}" id="btn_iniciar_tramite" class="btn btn-sm btn-primary" style="margin: 2px;">Iniciar configuración de trámite</a>
                    @endif
                @endif
            </div>
            <br>
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fa" aria-hidden="true"></i> Acerca del Trámite
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            @foreach($tramite['informacion_general'] as $informacion)
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="lblDatos">{{$informacion['titulo']}}</label>
                                    <p class="pDatos">{!! $informacion['descripcion'] !!}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h4 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fa" aria-hidden="true"></i> Requisitos
                            </button>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            @foreach($tramite['requerimientos'] as $informacion)
                            <div class="row">
                                <!--<div class="col-md-12">
                                    <label class="lblDatos">{{$informacion['titulo']}}</label>
                                    <p class="pDatos">{!! $informacion['descripcion'] !!}</p>
                                </div>-->
                                @if(count($informacion['opciones'])> 0)
                                <div class="col-md-12">
                                    @foreach($informacion['opciones'] as $opcion)
                                    <p class="pDatos">{!! $opcion !!}</p>
                                    @endforeach
                                </div>
                                @endif
                                @if(count($informacion['documentos'])> 0)
                                @foreach($informacion['documentos'] as $documento)
                                <div class="col-md-12">
                                    <div class="documentTitle">
                                        <span class="spanBorder">.</span>
                                        <span class="spanTitle">{{$documento['nombre']}}</span>
                                        <div class="documentInfo">
                                            <span style="width: 100%;"><b>Presentación:</b> {{$documento['presentacion']}}</span>
                                            <span style="width: 100%;"><b>Observaciones:</b> {{$documento['observaciones']}}</span>
                                            {{-- <span style="width: 100%;"><b>Información Complementaria:</b> {{$documento['informacionComplementaria']}}</span> --}}
                                            <span style="width: 100%;"><b>Tipo:</b> {{$documento['tipo']}}</span>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <i class="fa" aria-hidden="true"></i> Costos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            @foreach($tramite['costo'] as $costo)
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="lblDatos">{{$costo['titulo']}}</label>
                                        <p class="pDatos">{{$costo['descripcion']}}</p>
                                    </div>

                                    @if(count($costo['opciones'])> 0)
                                        <div class="col-md-12">
                                            @foreach($costo['opciones'] as $opcion)
                                                <p class="pDatos">{{$opcion}}</p>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    @if(count($costo['documentos'])> 0)
                                        @foreach($costo['documentos'] as $documento)
                                            <div class="col-md-12">
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
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFive">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <i class="fa" aria-hidden="true"></i> Fundamento legal
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="card-body">
                            @foreach($tramite['fundamento_legal'] as $fundamento)
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="lblDatos">{{$fundamento['titulo']}}</label>
                                    <p class="pDatos">{{$fundamento['descripcion']}}</p>
                                </div>
                                @if(count($fundamento['adicional'])> 0)
                                @foreach($fundamento['adicional'] as $adicional)
                                <div class="col-md-12">
                                    <div class="documentTitle">
                                        <span class="spanBorder">.</span>
                                        <span class="spanTitle">{{$adicional['titulo']}}</span>
                                        <div class="documentInfo">
                                            <span style="width: 100%;">{{$adicional['descripcion']}}</span>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row" style="height: 100%; padding: 15px;">
                <div class="col-12 ">
                    <div class="row d-flex justify-content-center" style="background-color: #ffffff;">
                        <div class="btn-group" role="group">
                            <button onclick="TRAM_FN_ANTERIOR_OFICINA();" type="button" class="btn btn-secondary sizeBtnArrow"><i class="fas fa-chevron-left"></i></button>
                            <button onclick="TRAM_FN_SIGUIENTE_OFICINA();" type="button" class="btn btn-secondary sizeBtnArrow"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="row bg-azul-marino txt-oficinas">
                        <h6 class="lbl-white-bold w-all">Oficinas donde se puede realizar el trámite</h6>
                    </div>
                    <div class="row">
                        <div id="mapa" style="height: 300px; width: 100%;"></div>
                    </div>
                    <div id="divOficina" class="row bg-azul-marino" style="height: calc(100% - 360px);">
                        <ul class="list-group w-all text-center">
                            <li class="list-group-item text-white bg-border-none">
                                <label id="text_nombre_oficina" class="lbl-white-bold">Nombre Oficina</label>
                            </li>
                            <li class="list-group-item text-white bg-border-none">
                                <p id="text_direccion_oficina" class="text-white" style="margin:0px;">Tecnológico, 2903 19</p>
                                <p id="text_horario_oficina" class="text-white" style="margin:0px;">Verano: Domingos de 11:00 a 20:00 horas. Invierno: Domingos de 11:00 a 19:00 horas. Sujeto a cambios de horario.</p>

                            </li>
                            <li class="list-group-item text-white bg-border-none">
                                <label class="lbl-white-bold">Responsable del trámite</label>
                                <p id="text_responsable_oficina" class="text-white" style="margin:0px;">Lic. María Álvarez Monge, Directora de Esparcimiento.</p>
                            </li>
                            <li class="list-group-item text-white bg-border-none">
                                <label class="lbl-white-bold">Contacto</label>
                                <p id="text_telefono_oficina" class="text-white" style="margin:0px;">9999888771 Ext. 123, 456</p>
                                <p id="text_correo_oficina" class="text-white" style="margin:0px;">atencion.semilla@gmail.com</p>
                            </li>
                            <li class="list-group-item text-white bg-border-none">
                                <label class="lbl-white-bold">Información adicional</label>
                                <p id="text_informacion_adicional_oficina" class="text-white" style="margin:0px;">El Parque Infantil DIF se encuentra en remodelación.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<br />
<style>
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

    .btn-link {
        font-weight: bold;
        font-size: 1rem;
    }

    .btn-link:hover {
        color: #0056b3;
        text-decoration: none !important;
    }

    .btn-link:focus {
        text-decoration: none !important;
    }

    .bg-border-none {
        background: none;
        border: none;
    }

    .lbl-white-bold {
        color: #ffffff;
        font-weight: bold;
        font-size: 1rem;
    }

    .txt-oficinas {
        font-weight: bold;
        border-radius: 8px;
        padding: 5px 10px 5px 10px;
        text-align: center;
    }

    .bg-azul-marino {
        background-color: #004081;
    }

    .w-all {
        width: 100%;
    }

    .contentPage {
        background-color: #ffffff;
        height: calc(100% - 104px);
        margin-bottom: 5px;
        position: absolute;
        width: calc(100% - 25px) !important;
        margin-left: 15px !important;
        margin-right: 10px !important;
    }

    .titulo {
        font-weight: bold;
    }

    .sizeBtnArrow {
        width: 65px !important;
    }

    [data-toggle="collapse"] .fa:before {
        content: "\f107";
        font-size: 1.5rem;
        vertical-align: middle;
        color: #7F7F7F;
    }

    [data-toggle="collapse"].collapsed .fa:before {
        content: "\f105";
        font-size: 1.5rem;
        vertical-align: middle;
        color: #7F7F7F;
    }
</style>
@endsection


@section('scripts')
<script>
    var index_start = 0;
    var index_end = <?php echo (count($tramite['oficinas'])) ?>;

    var map = null;
    var markers = [];

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function TRAM_FN_RENDER_MAPA(latitud, longitud) {
            //Cargar mapa y ubicacion de oficina
            setTimeout(function() {
                var lat = latitud == null || latitud == 0 ? 28.6389324 : Number(latitud);
                var long = longitud == null || longitud == 0 ? -106.075353 : Number(longitud);
                map = new google.maps.Map(document.getElementById('mapa'), {
                    center: {
                        lat: lat,
                        lng: long
                    },
                    zoom: 15,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                        position: google.maps.ControlPosition.TOP_CENTER,
                    },
                    fullscreenControlOptions: {
                        position: google.maps.ControlPosition.BOTTOM_RIGHT,
                    },
                });

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, long),
                    map: map,
                    title: 'Ubicación'
                });
            }, 1000);
        };

        function TRAN_FN_MOSTRAR_OFICINA() {
            var oficinas = <?php echo json_encode($tramite['oficinas']) ?>;
            var oficina = oficinas[0];

            $('#text_nombre_oficina').html(oficina.nombre);
            $('#text_direccion_oficina').html(oficina.direccion);
            $('#text_horario_oficina').html(oficina.horario);
            $('#text_responsable_oficina').html(oficina.responsable);
            $('#text_telefono_oficina').html(oficina.contacto_telefono);
            $('#text_correo_oficina').html(oficina.contacto_email);
            $('#text_informacion_adicional_oficina').html(oficina.informacion_adicional);
            TRAM_FN_RENDER_MAPA(oficina.latitud, oficina.longitud);
        };

        TRAN_FN_MOSTRAR_OFICINA();
    });

    function TRAM_FN_RENDER_MAPA(latitud, longitud) {
        //Cargar mapa y ubicacion de oficina
        setTimeout(function() {
            var lat = latitud == null || latitud == 0 ? 28.6389324 : Number(latitud);
            var long = longitud == null || longitud == 0 ? -106.075353 : Number(longitud);
            map = new google.maps.Map(document.getElementById('mapa'), {
                center: {
                    lat: lat,
                    lng: long
                },
                zoom: 15,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_CENTER,
                },
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.BOTTOM_RIGHT,
                },
            });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, long),
                map: map,
                title: 'Ubicación'
            });
        }, 1000);
    };

    function TRAM_FN_ANTERIOR_OFICINA() {

        var oficinas = <?php echo json_encode($tramite['oficinas']) ?>;

        if (index_start > 0) {

            index_start--;
        } else {

            index_star = 0;
        }

        setTimeout(function() {
            var oficina = oficinas[index_start];
            $('#text_nombre_oficina').html(oficina.nombre);
            $('#text_direccion_oficina').html(oficina.direccion);
            $('#text_horario_oficina').html(oficina.horario);
            $('#text_responsable_oficina').html(oficina.responsable);
            $('#text_telefono_oficina').html(oficina.contacto_telefono);
            $('#text_correo_oficina').html(oficina.contacto_email);
            $('#text_informacion_adicional_oficina').html(oficina.informacion_adicional);
            TRAM_FN_RENDER_MAPA(oficina.latitud, oficina.longitud);
        }, 100);
    }

    function TRAM_FN_SIGUIENTE_OFICINA() {

        var oficinas = <?php echo json_encode($tramite['oficinas']) ?>;

        if (index_start < (index_end - 1)) {

            index_start++;

        } else {

            index_star = index_end - 1;
        }

        setTimeout(function() {
            var oficina = oficinas[index_start];
            $('#text_nombre_oficina').html(oficina.nombre);
            $('#text_direccion_oficina').html(oficina.direccion);
            $('#text_horario_oficina').html(oficina.horario);
            $('#text_responsable_oficina').html(oficina.responsable);
            $('#text_telefono_oficina').html(oficina.contacto_telefono);
            $('#text_correo_oficina').html(oficina.contacto_email);
            $('#text_informacion_adicional_oficina').html(oficina.informacion_adicional);
            TRAM_FN_RENDER_MAPA(oficina.latitud, oficina.longitud);
        }, 100);
    }
</script>
@endsection

