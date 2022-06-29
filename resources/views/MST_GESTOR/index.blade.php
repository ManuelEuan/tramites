@extends('layout.Layout')

@section('body')

<!-- <%-- Contenido individual --%> -->
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2>Trámites y servicios disponibles</h2>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-body">
            <div class="row">
                <div class="col-md-12">
                    <h2>Datos de búsqueda</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="txtPalabraClave">Nombre del trámite o servicio</label>
                        <input type="text" class="form-control" name="txtPalabraClave" id="txtPalabraClave" placeholder="Nombre del trámite o servicio">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmbDependenciaEntidad">Ente público</label>
                        <select class="combobox form-control" name="cmbDependenciaEntidad" id="cmbDependenciaEntidad">
                            <option></option>
                        </select>
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmbUnidad">Unidad Administrativa</label>
                        <select class="combobox form-control" name="cmbUnidad" id="cmbUnidad">
                            <option></option>
                        </select>
                    </div>
                </div> --}}
            </div>
            {{-- <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmbModalidad">Modalidad</label>
                        <select class="combobox form-control" name="cmbModalidad" id="cmbModalidad">
                            <option value="Todos">Seleccione</option>
                            <option value="PRESENCIAL">Presencial</option>
                            <option value="LINEA">Línea</option>
                            <option value="TELEFONO">Teléfono</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmbClasificacion">Clasificación</label>
                        <select class="combobox form-control" name="cmbClasificacion" id="cmbClasificacion">
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmbEstatus">Estatus</label>
                        <select class="combobox form-control" name="cmbEstatus" id="cmbEstatus">
                            <option value="2" disabled selected>Seleccione</option>
                            <option value="1">Activos</option>
                            <option value="0">Inactivos</option>
                        </select>
                    </div>
                </div>
            </div> --}}

            <div class="row justify-content-between">
                <div class="col-md-6">
                    <button class="btn btn-sm btn-primary" onclick="TRAM_FN_BUSCAR(event);">Buscar</button>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btn-warning" onclick="TRAM_FN_LIMPIAR(event);">Limpiar</button>
                    <button class="btn btn-sm btn-primary">Exportar</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div>
        <strong>Mostrar </strong>
        <select style="width: 70px; display: inline-block;" class="custom-select custom-select-sm form-control form-control-sm" name="cmbNumeroRegistro" id="cmbNumeroRegistro">
            <option>10</option>
            <option>25</option>
            <option>50</option>
            <option>100</option>
        </select>
        <strong> registros</strong>
    </div>
    <br>
    <br>

    @if(count($data_tramite) > 0)
    <div id="tramite_servicio">
        <section>
            @foreach ($data_tramite as $data)
            <div class="card text-left" style="margin-bottom: 2rem;">
                <div class="card-header text-primary titleCard">
                    <div class="row">
                        <div class="col-10">
                            {{$data->TRAM_CNOMBRE}} <span class="badge badge-warning">{{$data->UNAD_CNOMBRE}}</span>
                        </div>
                        <div class="col-2">
                            @if($data->TRAM_NIDTRAMITE_CONFIG > 0)
                            <div style="float: right; color:#212529;">
                                <a href="{{route('detalle_configuracion_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => $data->TRAM_NIDTRAMITE_CONFIG] )}}" title="Ver Configuración"><i class="fas fa-eye sizeBtnIcon"></i></a>
                                <a href="{{route('gestor_configurar_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => $data->TRAM_NIDTRAMITE_CONFIG]) }}" title="Configurar Trámite"><i class="fas fa-edit sizeBtnIcon"></i></a>

                                @if(Gate::allows('isAdministradorOrEnlace'))
                                @if($data->TRAM_NIMPLEMENTADO > 0)
                                <a href="javascript:TRAM_FN_CAMBIAR_ESTATUS({{$data->TRAM_NIDTRAMITE_CONFIG}}, 0)"><i class="fas fa-toggle-on sizeBtnIcon" style="color:#28a745;"></i></a>
                                @elseif($data->TRAM_NIMPLEMENTADO == 0)
                                <a href="javascript:TRAM_FN_CAMBIAR_ESTATUS({{$data->TRAM_NIDTRAMITE_CONFIG}}, 1)"><i class="fas fa-toggle-off sizeBtnIcon"></i></a>
                                @else
                                @endif
                                @endif

                                @if(!(Gate::allows('isAdministradorOrEnlace')))
                                @if($data->TRAM_NIMPLEMENTADO > 0)
                                <a style="pointer-events:none" title="Implementado" href="javascript:void();"><i class="fas fa-circle sizeBtnIcon" style="color:#28a745;"></i></a>
                                @elseif($data->TRAM_NIMPLEMENTADO == 0)
                                <a style="pointer-events:none" title="No implementado" href="javascript:void();"><i class="fas fa-circle sizeBtnIcon" style="color: #737373 !important;"></i></a>
                                @else
                                @endif
                                @endif

                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h6 class="card-text" style="color: #212529;">
                                {{$data->TRAM_CDESCRIPCION}}
                            </h6>
                        </div>
                        <div class="col-2">
                            @if($data->TRAM_NIDTRAMITE_CONFIG == null)
                            <div style="float: right;">
                                <a href="{{route('gestor_configurar_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => 0])}}" class="btn btn-primary" style="width:172px; float:right; margin-bottom:7px;">Configurar trámite</a>
                                <a href="{{route('gestor_consultar_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => 0])}}" class="btn btn-primary" style="width:172px; float:right;">Ver trámite</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($data->TRAM_NIDTRAMITE_CONFIG > 0)
                <div class="card-footer text-muted" style="background-color: transparent; border-top: none; border-bottom: none;">
                    <span class="text-left" style="margin-right: 30px;">Creado: {{date("d/m/Y", strtotime($data->TRAM_DFECHACREACION))}}</span>
                    <span class="text-left">Ultima Modificación: {{date("d/m/Y", strtotime($data->TRAM_DFECHAACTUALIZACION))}}</span>

                    <div style="float: right;">
                        <a href="{{route('gestor_consultar_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => $data->TRAM_NIDTRAMITE_CONFIG])}}" class="btn btn-primary" style="float: right;">Ver trámite</a>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
            <div class="paginate" style="float: right;">
                {{ $data_tramite->links() }}
            </div>
            <div>
                <strong>Mostrando registros del {{($data_tramite->currentpage()-1)*$data_tramite->perpage()+1}} al {{$data_tramite->currentpage()*$data_tramite->perpage()}}
                    de un total de {{$data_tramite->total()}} registros</strong>
            </div>
        </section>
    </div>
    @else
    <div>
        <h6 style="text-align: center;">No se encontraron resultados.</h6>
    </div>
    @endif
    <br>
</div>
<br />
<div id="loading" class="loadingFrame" class="text-center" style="display: none !important;">
    <div class="inner">
        <div class="spinner-grow text-secondary" role="status">
        </div>
        <p style="color: #393939 !important;"><span id="loading-text"></span></p>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .sizeBtnIcon {
        font-size: 1.2rem;
        margin-right: 4px;
    }

    .titleCard {
        text-align: left;
        background-color: transparent;
        border-bottom: none;
        font-weight: bold;
        font-size: 1rem;
    }

    .progress_circle {
        width: 150px;
        height: 150px;
        background: none;
        position: relative;
    }

    .progress_circle::after {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 12px solid #03BAFF;
        position: absolute;
        top: 0;
        left: 0;
    }

    .progress_circle>span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .progress_circle .progress_circle-left {
        left: 0;
    }

    .progress_circle .progress_circle-bar {
        width: 100%;
        height: 100%;
        background: none;
        border-width: 12px;
        border-style: solid;
        position: absolute;
        top: 0;
    }

    .progress_circle .progress_circle-left .progress_circle-bar {
        left: 100%;
        border-top-right-radius: 80px;
        border-bottom-right-radius: 80px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }

    .progress_circle .progress_circle-right {
        right: 0;
    }

    .progress_circle .progress_circle-right .progress_circle-bar {
        left: -100%;
        border-top-left-radius: 80px;
        border-bottom-left-radius: 80px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
    }

    .progress_circle .progress_circle-value {
        position: absolute;
        top: 0;
        left: 0;
    }
    .loadingFrame {
        background: rgb(255 255 255 / 50%);
        display: table;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 999;
    }

    .loadingFrame .inner {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }

    .loadingFrame .inner md-progress-circular {
        margin: auto;
        height: 460px;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        margin-top: -50px;
    }

    .loadingFrame .inner p {
        color: #fff;
        font-size: 22px;
    }
</style>
<script>
    var page = 1;
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function TRAM_AJX_CONSULTAR_FILTRO() {

            var cmbClasificacion = $("#cmbClasificacion");
            /*var cmbAudiencia = $("#cmbAudiencia");*/
            var cmbDependenciaEntidad = $("#cmbDependenciaEntidad");

            $.ajax({
                //data: $('#frmForm').serialize(),
                //dataType: 'json',
                url: "/gestores/consultar_filtro",
                type: "GET",
                success: function(data) {
                    //Limpiamos el select de clasificacion
                    cmbClasificacion.find('option').remove();
                    //Opcion por defecto de select clasificacion
                    cmbClasificacion.append('<option value="0" selected>Seleccione</option>');
                    //Llenamos select de clasificacion
                    $(data.clasificacion).each(function(i, v) {
                        cmbClasificacion.append('<option value="' + v.id + '">' + v.name + '</option>');
                    })

                    /*
                    //Limpiamos el select de audiencia
                    cmbAudiencia.find('option').remove();
                    //Opcion por defecto de select audiencia
                    cmbAudiencia.append('<option value="" selected>Seleccione</option>');
                    //Llenamos select de audiencia
                    $(data.audiencia).each(function(i, v) {
                        cmbAudiencia.append('<option value="' + v.name + '">' + v.name + '</option>');
                    })*/

                    //Limpiamos el select de dependencias
                    cmbDependenciaEntidad.find('option').remove();
                    //Opcion por defecto de select dependencias
                    cmbDependenciaEntidad.append('<option value="0" selected>Seleccione</option>');
                    //Llenamos select de dependencias
                    $(data.dependencias).each(function(i, v) {
                        cmbDependenciaEntidad.append('<option value="' + v.id + '">' + v.name + '</option>');
                    })


                },
                error: function(data) {
                    Swal.fire({
                        icon: data.status,
                        title: '',
                        text: data.message,
                        footer: ''
                    });
                }
            });
        }

        TRAM_AJX_CONSULTAR_FILTRO();
    });

    //Cambiar páginado
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        $("#loading-text").html("Cargando...");
        $('#loading').show();
        page = $(this).attr('href').split('page=')[1];
        TRAM_AJX_CONSULTARTRAMITES(page);
    });

    //Cambiar número de registro
    $(document).on('change', '#cmbNumeroRegistro', function(e) {
        e.preventDefault();
        $("#loading-text").html("Cargando...");
        $('#loading').show();
        TRAM_AJX_CONSULTARTRAMITES(1);
    });

    //Consultar unidades
    $("#cmbUnidad").prop("disabled", true);
    // $(document).on('change', '#cmbDependenciaEntidad', function(e) {
    //     var id = $(this).val();
    //     e.preventDefault();
    //     var cmbUnidad = $("#cmbUnidad");
    //     $.ajax({
    //         url: "/gestores/unidad_administrativa/" + id,
    //         type: "GET",
    //         success: function(data) {
    //             $("#cmbUnidad").prop("disabled", false);
    //             //Limpiamos el select de clasificacion
    //             cmbUnidad.find('option').remove();
    //             //Opcion por defecto de select clasificacion
    //             cmbUnidad.append('<option value="0" selected>Seleccione</option>');
    //             //Llenamos select de clasificacion
    //             $(data).each(function(i, v) {
    //                 cmbUnidad.append('<option value="' + v.ID_UNIDAD + '">' + v.DESCRIPCION + '</option>');
    //             });
    //         }
    //     });
    // });

    //Funcion limpiar filtro
    function TRAM_FN_LIMPIAR(e) {
        e.preventDefault();
        $('#txtPalabraClave').val('');
        $('#cmbDependenciaEntidad').prop('selectedIndex', 0);
        $('#cmbUnidad').prop('cmbUnidad', 0);
        // $('#cmbModalidad').prop('selectedIndex', 0);
        // $('#cmbClasificacion').prop('selectedIndex', 0);
        // $('#cmbEstatus').prop('selectedIndex', 0);
        $("#loading-text").html("Filtrando...");
        $('#loading').show();
        TRAM_AJX_CONSULTARTRAMITES(1);
    }

    //Funcion buscar
    function TRAM_FN_BUSCAR(e) {
        e.preventDefault();
        $('#loading').show();
        $("#loading-text").html("Filtrando...");
        TRAM_AJX_CONSULTARTRAMITES(page);
    }

    //Funcion para obtener tramites
    function TRAM_AJX_CONSULTARTRAMITES(page) {
        let dependencia_id = $('#cmbDependenciaEntidad').val() > 0 ? $('#cmbDependenciaEntidad').val() : 0;
        var dependencia_arr = [];
        if(dependencia_id > 0){
            dependencia_arr.push(Number(dependencia_id));
        }
        var filtro = {
            "palabraClave": $('#txtPalabraClave').val(),
            "dependencia": dependencia_arr,
            "modalidad": "",
            "unidad": [],
            "clasificacion": "",
            // "audiencia": $('#cmbAudiencia').val() === "" ? null : $('#cmbAudiencia').val(),
            "estatus": 2,
            "IntNumPagina": page,
            "IntCantidadRegistros": $('#cmbNumeroRegistro').val(),
            "StrOrdenColumna": "",
            "StrOrdenDir": "",
            "IntUsuarioId": 3,
        };

        console.log("Filtro");
        console.log(filtro);

        $.ajax({
            data: filtro,
            dataType: 'json',
            url: "/gestores/consultar",
            type: "POST",
            success: function(data) {
                $('#loading').hide();
                $('#tramite_servicio').html(data);
                $("html, body").animate({ scrollTop: 0 }, "slow");
            },
            error: function(data) {
                $('#loading').hide();
                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });
    }

    var input = document.getElementById("txtPalabraClave");
    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Cancel the default action, if needed
            event.preventDefault();
            $("#loading-text").html("Filtrando...");
            $('#loading').show();
            TRAM_AJX_CONSULTARTRAMITES(page);
        }
    });

    //Funcion para cambiar estatus del tramite
    function TRAM_FN_CAMBIAR_ESTATUS(TRAM_NIDTRAMITE_CONFIG, TRAM_NIMPLEMENTADO) {

        var mensaje = TRAM_NIMPLEMENTADO === 0 ? "¿Desea deshabilitar el trámite ?" : "¿Desea habilitar el trámite ?";
        var icon = TRAM_NIMPLEMENTADO === 0 ? "warning" : "success";

        Swal.fire({
            title: '',
            text: mensaje,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
        }).then((result) => {

            if (result.isConfirmed) {
                $("#loading-text").html("Cargando...");
                $('#loading').show();
                $.ajax({
                    //data: $('#frmForm').serialize(),
                    //dataType: 'json',
                    url: '/gestores/implementar_tramite/' + TRAM_NIDTRAMITE_CONFIG + '/' + TRAM_NIMPLEMENTADO + '',
                    type: "GET",
                    success: function(data) {

                        if (data.codigo === 200) {

                            if (TRAM_NIMPLEMENTADO > 0) {
                                Swal.fire({
                                    icon: "success",
                                    title: '',
                                    text: "El trámite se habilito con éxito.",
                                    footer: '',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: "success",
                                    title: '',
                                    text: "El trámite se deshabilito con éxito.",
                                    footer: '',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }

                        TRAM_AJX_CONSULTARTRAMITES(page);
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: data.status,
                            title: '',
                            text: data.message,
                            footer: '',
                            timer: 1500
                        });
                        $('#loading').hide();
                    }
                });
            }

        });
    }
</script>
@endsection
