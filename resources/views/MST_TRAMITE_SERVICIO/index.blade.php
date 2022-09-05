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
            <form>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtPalabraClave">Palabra clave</label>
                            <input type="text" class="form-control" name="txtPalabraClave" id="txtPalabraClave" placeholder="Palabra clave">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbDependenciaEntidad">Dependencia o Entidad de la Administración Pública Estatal</label>
                            <select class="combobox form-control" name="cmbDependenciaEntidad" id="cmbDependenciaEntidad">
                                <option>Seleccione</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbModalidad">Modalidad</label>
                            <select class="combobox form-control" name="cmbModalidad" id="cmbModalidad">
                                <option value="Todos">Seleccione</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Línea">Línea</option>
                                <option value="Teléfono">Teléfono</option>
                            </select>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbClasificacion">Clasificación</label>
                            <select class="combobox form-control" name="cmbClasificacion" id="cmbClasificacion">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbAudiencia">Audiencia</label>
                            <select class="combobox form-control" name="cmbAudiencia" id="cmbAudiencia">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div> --}}
            </form>
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <button class="btn btn-sm btn-primary" onclick="TRAM_FN_BUSCAR(event);">Buscar</button>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btn-warning" onclick="TRAM_FN_LIMPIAR(event);">Limpiar</button>
                    {{-- <button class="btn btn-sm btn-primary">Exportar</button> --}}
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
    <div id="tramite_servicio">

    </div>
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
    .titleCard {
        text-align: left;
        background-color: transparent;
        border-bottom: none;
        font-weight: bold;
        font-size: 1rem;
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
        var host = "http://vucapacita.chihuahua.gob.mx";

        getTramites()

        function TRAM_AJX_CONSULTAR_FILTRO() {
            var cmbClasificacion = $("#cmbClasificacion");
            var cmbAudiencia = $("#cmbAudiencia");
            var cmbDependenciaEntidad = $("#cmbDependenciaEntidad");

            $.ajax({
                //data: $('#frmForm').serialize(),
                //dataType: 'json',
                url: "/gestores/consultar_filtro",
                type: "GET",
                success: function(data) {

                    console.log("Data");
                    console.log(data);

                    //Limpiamos el select de clasificacion
                    cmbClasificacion.find('option').remove();
                    //Opcion por defecto de select clasificacion
                    cmbClasificacion.append('<option value="0" selected>Seleccione</option>');
                    //Llenamos select de clasificacion
                    $(data.clasificacion).each(function(i, v) {
                        cmbClasificacion.append('<option value="' + v.id + '">' + v.name + '</option>');
                    })


                    //Limpiamos el select de audiencia
                    cmbAudiencia.find('option').remove();
                    //Opcion por defecto de select audiencia
                    cmbAudiencia.append('<option selected>Seleccione</option>');
                    //Llenamos select de audiencia
                    $(data.audiencia).each(function(i, v) {
                        cmbAudiencia.append('<option value="' + v.id + '">' + v.name + '</option>');
                    })


                    //Limpiamos el select de dependencias
                    cmbDependenciaEntidad.find('option').remove();
                    //Opcion por defecto de select dependencias
                    cmbDependenciaEntidad.append('<option selected>Seleccione</option>');
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

    //Funcion limpiar filtro
    function TRAM_FN_LIMPIAR(e) {
        e.preventDefault();
        $('#txtPalabraClave').val('');
        $('#cmbDependenciaEntidad').prop('selectedIndex', 0);
        // $('#cmbModalidad').prop('selectedIndex', 0);
        // $('#cmbClasificacion').prop('selectedIndex', 0);
        // $('#cmbAudiencia').prop('selectedIndex', 0);
    }

    //Funcion buscar
    function TRAM_FN_BUSCAR(e) {
        $("#loading-text").html("Filtrando...");
        $('#loading').show();
        e.preventDefault();
        TRAM_AJX_CONSULTARTRAMITES(page);
    }

    //Funcion para obtener tramites
    function TRAM_AJX_CONSULTARTRAMITES(page) {

        var filtro = {
            "StrTexto": $('#txtPalabraClave').val(),
            "IntDependencia": $('#cmbDependenciaEntidad').val() > 0 ? $('#cmbDependenciaEntidad').val() : 0,
            "StrModalidad": "",
            "IntClasificacion": 0,
            "StrAudiencia": "",
            "IntNumPagina": page,
            "IntCantidadRegistros": $('#cmbNumeroRegistro').val(),
            "StrOrdenColumna": "",
            "StrOrdenDir": "",
            "IntUsuarioId": 3,
        };

        console.log("Filtros");
        console.log(filtro);

        $.ajax({
            data: filtro,
            dataType: 'json',
            url: "/tramite_servicio/consultar",
            type: "POST",
            success: function(data) {
                $('#loading').hide();
                $('#tramite_servicio').html(data);
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
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

    function getTramites() {
        var formData = new FormData()
        formData.append('search', '')
        formData.append('dependencies', '')
        $.ajax({
            data: formData,
            url: "/tramite_servicio/getTramites",
            type: "POST",
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(data) {
                $("#tramite_servicio").html(data)
            }
        });
    }
</script>
@endsection