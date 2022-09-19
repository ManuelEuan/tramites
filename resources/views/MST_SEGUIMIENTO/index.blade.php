@extends('layout.Layout')

@section('body')

<style>
    div.dt-buttons {
        float: right;
    }
    .btn-secondary{
        background-color: #ffa000;
        height: 25px;
        align-items: center;
        vertical-align: center;
        font-size: x-small;
    }
</style>

<!-- <%-- Contenido individual --%> -->
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2>Seguimiento de Trámites y Servicios</h2>
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="dteFechaInicio">Fecha</label>
                            <input type="date" value="12/12/2020" class="form-control" name="dteFechaInicio" id="dteFechaInicio">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtNombre">Nombre del trámite</label>
                            <input type="text" placeholder="Nombre" class="form-control" name="txtNombre" id="txtNombre">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cmbDependenciaEntidad">Dependencia</label>
                            <select class="combobox form-control" name="cmbDependenciaEntidad" id="cmbDependenciaEntidad">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cmbEstatus">Estatus</label>
                            <select class="combobox form-control" name="cmbEstatus" id="cmbEstatus">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <button class="btn btn-sm btn-primary" onclick="TRAM_AJX_CONSULTAR(event)">Buscar</button>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btnLimpiar waves-effect waves-light" onclick="TRAM_FN_LIMPIAR(event);">Limpiar</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="seguimiento">
        <div class="row">
            <div class="col-12" >
                <table id="example" class="table table-bordered" style="width: 100%">
                    <thead class="bg-gob">
                        <tr>
                            <th>Fecha</th>
                            <th>Folio</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Dependencia</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <br>
</div>
<br />
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.min.js"></script>
<style>
    .btnLimpiar{
        float: right;
        background-color: #01b3e8 !important;;
        border-color: #01b3e8 !important;;
        color: #ffffff;
        margin-left: 20px;
    }

    .btnLimpiar:hover{
        background-color: #33B5FF !important;;
        border-color: #33B5FF !important;;
        color: #ffffff;
        margin-left: 20px;
    }
</style>
<script>
    var table = null;
    var SITEURL = "{{URL::to('')}}";

    var registros_paginas = 10;

    var estatus_seguimiento = [{
            id: 1,
            nombre: "Captura inicial"
        },
        {
            id: 2,
            nombre: "Pendiente de revisión"
        },
        {
            id: 3,
            nombre: "Recibido"
        },
        {
            id: 4,
            nombre: "Información incompleta"
        },
        {
            id: 5,
            nombre: "Iniciado"
        },
        {
            id: 6,
            nombre: "Acción requerida "
        },
        {
            id: 7,
            nombre: "En proceso"
        },
        {
            id: 8,
            nombre: "Terminado"
        },
        {
            id: 9,
            nombre: "Rechazado"
        }
    ];

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function TRAM_AJX_CONSULTAR_FILTRO() {
            var cmbClasificacion = $("#cmbClasificacion");
            var cmbAudiencia = $("#cmbDependenciaEntidad");
            var cmbDependenciaEntidad = $("#cmbDependenciaEntidad");
            
            $.ajax({
                //data: $('#frmForm').serialize(),
                //dataType: 'json',
                url: "/gestores/consultar_filtro",
                type: "GET",
                success: function(data) {

                    /*console.log("Data");
                    console.log(data);*/

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
                    cmbDependenciaEntidad.append('<option value="" selected>Seleccione</option>');
                    //Llenamos select de dependencias
                    $(data.dependencias).each(function(i, v) {
                        cmbDependenciaEntidad.append('<option value="' + v.id + '">' + v.name + '</option>');
                    })


                },
                error: function(data) {

                }
            });
        }

        TRAM_AJX_CONSULTAR_FILTRO();

        function TRAM_AJX_CONSULTARSEGUIMIENTO() {
            $("#divTabla").append(`<div id="spinner" class="spinner-grow" role="status" style="text-align: center;"><span class="sr-only">Loading...</span></div>`);
            var filtro = {
                dteFechaInicio: null,
                txtNombre: null,
                cmbDependenciaEntidad: null,
                cmbEstatus: null,
            };

            table = $('#example').DataTable({
                "language": {
                    url: "assets/template/plugins/DataTables/language/Spanish.json",
                    "search": "Filtrar resultados:"
                },
                "ajax": {
                    "data": filtro,
                    "url": "/seguimiento/consultar",
                    "type": "POST"
                },
                "columns": [
                    {
                        "data":null,
                         render: function(data, type, row) {
                             var date = new Date(data.USTR_DFECHACREACION.substring(0, 10));
                            return (date.getDate() + 1)+ '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + data.USTR_DFECHACREACION.substring(11, data.USTR_DFECHACREACION.length);
                        }
                        
                    },
                    {
                        "data": "USTR_CFOLIO"
                    },
                    {
                        "data": "USTR_CNOMBRE_COMPLETO"
                    },
                    {
                        "data": "USTR_CNOMBRE_TRAMITE"
                    },
                    {
                        "data": "USTR_CCENTRO"
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            $("#spinner").remove();
                            var estatus = estatus_seguimiento[(data.USTR_NESTATUS - 1)];
                            return '<span>' + estatus.nombre + '</span>';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var url = '{{ route("seguimiento_tramite", ":id") }}';
                            url = url.replace(':id', data.USTR_NIDUSUARIOTRAMITE);
                            return '<a href="' + url + '" class="btn btn-primary" style="float: right;">Ver trámite</a>';
                        }
                    },
                ],
                searching: true,
                ordering: true,
                order: [[ 0, "desc" ]],
                paging: true,
                bLengthChange: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                dom: 'Blrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    }
                ]
            });
        }

        function TRAM_AJX_CONSULTARDEPENDENCIAENTIDAD() {

            var cmbDependenciaEntidad = $("#cmbDependenciaEntidad");

            $.ajax({
                url: "/seguimiento/obtener_dependencias_unidad",
                type: "GET",
                success: function(data) {

                    // Limpiamos el select
                    cmbDependenciaEntidad.find('option').remove();

                    //Opcion por defecto
                    cmbDependenciaEntidad.append('<option value="0" selected>Seleccione</option>');

                    $(data).each(function(i, v) {
                        cmbDependenciaEntidad.append('<option value="' + v.id + '">' + v.nombre + '</option>');
                    });
                },
                error: function(data) {
  
                }
            });
        }

        function TRAM_FN_CMBESTATUS() {

            var cmbEstatus = $("#cmbEstatus");

            // Limpiamos el select
            cmbEstatus.find('option').remove();

            //Opcion por defecto
            cmbEstatus.append('<option value="" selected>Seleccione</option>');

            $(estatus_seguimiento).each(function(i, v) {
                cmbEstatus.append('<option value="' + v.id + '">' + v.nombre + '</option>');
            });
        }

        TRAM_AJX_CONSULTARSEGUIMIENTO();
        //TRAM_AJX_CONSULTARDEPENDENCIAENTIDAD();
        TRAM_FN_CMBESTATUS();
    });

    function TRAM_AJX_CONSULTAR(e) {
        $("#divTabla").append(`<div id="spinner" class="spinner-grow" role="status" style="text-align: center;"><span class="sr-only">Loading...</span></div>`);

        e.preventDefault();
        var filtro = {
            dteFechaInicio: $('#dteFechaInicio').val(),
            txtNombre: $('#txtNombre').val(),
            cmbDependenciaEntidad: $('#cmbDependenciaEntidad').val(),
            cmbEstatus: $('#cmbEstatus').val()
        };
        $.ajax({
            data: filtro,
            dataType: "json",
            url: "/seguimiento/consultar",
            type: "POST",
            success: function(data) {
                $("#spinner").remove();
                table.clear();
                table.rows.add(data.data);
                table.draw();

                // table.ajax.reload();

            },
            error: function(data) {

            }
        });
    }

    function TRAM_FN_FILTRO() {
        var filtro = {
            dteFechaInicio: $('#dteFechaInicio').val(),
            txtNombre: $('#txtNombre').val(),
            cmbDependenciaEntidad: $('#cmbDependenciaEntidad').val(),
            cmbEstatus: $('#cmbEstatus').val(),
        };

        return filtro;
    }

    function TRAM_FN_LIMPIAR(e) {
        e.preventDefault();
        $('#dteFechaInicio').val('');
        $('#txtNombre').val('');
        $('#cmbDependenciaEntidad').prop('selectedIndex', 0);
        $('#cmbEstatus').prop('selectedIndex', 0);
    }
</script>
@endsection
