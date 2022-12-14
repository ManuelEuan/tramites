@extends('layout.Layout')
@section('body')

<style>
    .dot {
        height: 25px;
        width: 25px;
        border-radius: 50%;
        display: inline-block;
    }

    div.dt-buttons {
        float: right;
    }

    .btn-secondary {
        background-color: #ffa000;
        height: 25px;
        align-items: center;
        vertical-align: center;
        font-size: x-small;
    }
</style>
<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12" style="text-align: left;">
                    <h2 class="titulo">Trámites y servicios disponibles</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body body">
                    <h2 class="titulo">Datos de búsqueda</h2>
                    <form>
                        <div class="form-row">
                            <div class=" col-md-3 mb-3">
                                <label for="txtFecha">Fecha</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="txtFecha" placeholder="01/01/2020" aria-describedby="inputGroupPrepend2">
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="txtFolio">Folio</label>
                                <input type="text" class="form-control" id="txtFolio" placeholder="Folio">
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="txtTramite">Trámite</label>
                                    <select id="txtTramite" class="selectpicker form-control" data-live-search="true" data-dropup-auto="false" data-size="10">
                                        <option value="0">Trámite</option>
                                        @foreach($tramites as $tramite)
                                        <option value="{{$tramite['ID_TRAM']}}">{{$tramite['TRAMITE']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="txtRazon">Razón social</label>
                                <input type="text" class="form-control" id="txtRazon" placeholder="Razón social">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="txtNombre">Nombre</label>
                                <input type="text" class="form-control" id="txtNombre" placeholder="Nombre">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="txtRFC">RFC</label>
                                <input type="text" class="form-control" id="txtRFC" placeholder="RFC">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="txtCURP">CURP</label>
                                <input type="text" class="form-control" id="txtCURP" placeholder="CURP">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="txtEstatus">Estatus</label>
                                <select id="txtEstatus" class="form-control">
                                    <option value="0">Estatus</option>
                                    <option value="2">Pendiente de revisión</option>
                                    <option value="3">Recibido</option>
                                    <option value="4">Solicitud con Observaciones</option>
                                    <option value="5">Iniciado</option>
                                    <option value="6">Acción requerida</option>
                                    <option value="7">En proceso</option>
                                    <option value="8">Terminado</option>
                                    <option value="9">Rechazado</option>
                                    <option value="10">Cancelado</option>
                                    <option value="11">Vencido</option>
                                </select>
                            </div>
                            <div class="col-md-7 btnBuscar">
                                <button onclick="filter();" class="btn btn-primary btnLetras" type="button">Buscar</button>
                                <button onclick="clean_filter();" class="btn btn-warning btnLimpiar btnLetras" type="button">Limpiar</button>
                            </div>
                        </div>
                    </form>

                    <h2 class="resultados_De_busqueda">Resultados de la búsqueda</h2>
                    <div class="seguimiento">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <style>
                                        .child{
                                            text-align: left;
                                        }
                                        tbody{
                                            text-align: center; 
                                        }
                                    </style>
                                    <table id="example" class="table table-bordered table-sm" style="width: 100%">
                                    @php
                                            $usuario    = Auth::user();
                                            $rol        = $usuario->TRAM_CAT_ROL;
                                    @endphp
                                        <thead class="bg-gob">
                                            <tr>
                                                <th data-priority="1"></th>
                                                <th data-priority="4">Fecha</th>
                                                @if ($rol->ROL_CCLAVE == 'ANTA' || $rol->ROL_CCLAVE == 'VLDR')
                                                    <td data-priority="4">Fecha Asignación</td>
                                                @endif
                                                <th data-priority="1">Folio</th>
                                                <th data-priority="2">Nombre</th>
                                                <th data-priority="2">RFC</th>
                                                <th data-priority="3">Trámite</th>
                                                @if ($rol->ROL_CCLAVE == 'ANTA' || $rol->ROL_CCLAVE == 'VLDR')
                                                    <th data-priority="3">Nombre Interno</th>
                                                    <th data-priority="3">RFC Interno</th>
                                                @endif
                                                <th data-priority="1">Estatus</th>
                                                @if ($rol->ROL_CCLAVE == 'ANTA' || $rol->ROL_CCLAVE == 'VLDR')
                                                    <td data-priority="4">Asignado</td>
                                                @endif
                                                <th  data-priority="2">Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<br />
<!-- Modal -->
<div class="modal" id="asignarFuncionarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignación de Trámite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mb-3" id="tipoId" style="">
                    <label>Tipo de cuestionario</label>
                    <select name="analistaSelec" id="analistaSelec" class="form-control">
                    </select>
                    <input type="hidden" id="idTramite" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="asignarFuncionario()">Guardar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.min.js"></script>
<script>
    var table = null;
    var registros_paginas = 10;
    var isVencido   = false;
    var analistas   = [];
    var rol         =<?php echo("'".$rol->ROL_CCLAVE."';") ?>
    var id_user     =<?php echo($usuario->USUA_NIDUSUARIO.";") ?>

    var estatus_seguimiento_antiguo = [{
            id: 1,
            nombre: "Captura inicial"
        },
        {
            id: 2,
            nombre: "Recibido"
        },
        {
            id: 3,
            nombre: "En revisíon"
        },
        {
            id: 4,
            nombre: "Finalizado"
        },
        {
            id: 5,
            nombre: "Rechazado"
        },
        {
            id: 6,
            nombre: "Acción requerida"
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
        },
        {
            id: 10,
            nombre: "Cancelado"
        },
        {
            id: 11,
            nombre: "Vencido"
        },
    ];

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
            nombre: "Solicitud con Observaciones"
        },
        {
            id: 5,
            nombre: "Iniciado"
        },
        {
            id: 6,
            nombre: "Acción requerida"
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
        },
        {
            id: 10,
            nombre: "Cancelado"
        },
        {
            id: 11,
            nombre: "Vencido"
        },
    ];

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#txtTramite').selectpicker({
            noneSelectedText: 'Trámite',
            noneResultsText: 'Trámite no encontrados',
        });

        TRAM_AJX_CONSULTARSEGUIMIENTO();
        listaAnalistas();
    });

    function TRAM_AJX_CONSULTARSEGUIMIENTO() {
        var filtro = {
            dteFechaInicio: null,
            txtNombre: null,
            cmbDependenciaEntidad: null,
            cmbEstatus: null,
        };

        if(rol == 'ANTA' || rol == 'VLDR'){
            table = $('#example').DataTable({
            responsive: true,
            "language": {
                url: "/assets/template/plugins/DataTables/language/Spanish.json",
                "search": "Filtrar resultados:",
            },
            "ajax": {
                // "data": filtro,
                "url": "/tramite_servicio_cemr/find",
                "type": "POST",
                "data": function(d) {
                    
                    isVencido = false
                    return $.extend({}, d, {
                        "fecha": $('#txtFecha').val(),
                        "folio": $('#txtFolio').val(),
                        "tramite": $('#txtTramite').val(),
                        "razonSocial": $('#txtRazon').val(),
                        "nombre": $('#txtNombre').val(),
                        "rfc": $('#txtRFC').val(),
                        "curp": $('#txtCURP').val(),
                        "estatus": $('#txtEstatus').val(),
                    });
                },
                "beforesend": function(){
                    alert('mi mensaje');// to debug error
                },
                "error": function(thrownError){
                    alert('mi mensaje');// to debug error
                }
            },
            "columns": [
                    {
                        data: null,
                        render: function(data, type, row) {
                            var dateFromTramite = new Date(data.USTR_DFECHACREACION);
                            dateFromTramite.setDate(parseInt(dateFromTramite.getDate()) + parseInt(data.USTR_NDIASHABILESRESOLUCION));

                            var dateMiddle = new Date(data.USTR_DFECHACREACION);
                            dateMiddle.setDate(parseInt(dateMiddle.getDate()) + parseFloat(parseInt(data.USTR_NDIASHABILESRESOLUCION) / 2));

                            var dateTwoDays = new Date(data.USTR_DFECHACREACION);
                            dateTwoDays.setDate(parseInt(dateTwoDays.getDate()) + parseFloat(parseInt(data.USTR_NDIASHABILESRESOLUCION) - 2));
                            //Fecha de notificacion
                            var currentDate = new Date();

                            var level = 0;
                            if(data.USTR_NESTATUS != 4){
                                if(data.USTR_NESTATUS != 10 && data.USTR_NESTATUS != 11){
                                    if(currentDate > dateFromTramite){
                                        isVencido = true
                                        level = 4;
                                    }else if(currentDate >= dateTwoDays){
                                        level = 3;
                                    }else if (dateMiddle >= currentDate) {
                                        level = 1;
                                    } else if (dateFromTramite >= currentDate) {
                                        level = 2;
                                    } else {
                                        level = 3;
                                    }
                                }else if(data.USTR_NESTATUS == 1){
                                    level = 1;
                                }else{
                                    level =3;
                                }
                            }else{
                                if(data.USTR_DFECHAESTATUS != null){
                                    var dateNoti = new Date(data.USTR_DFECHAESTATUS);
                                    dateNoti.setDate(parseInt(dateNoti.getDate()) + parseInt(data.USTR_NDIASHABILESNOTIFICACION));

                                    var dateNotiMedio = new Date(data.USTR_DFECHAESTATUS);
                                    dateNotiMedio.setDate(parseInt(dateNotiMedio.getDate()) + parseFloat(parseInt(data.USTR_NDIASHABILESNOTIFICACION) / 2));
                                    if(dateNotiMedio >= currentDate){
                                        level = 1;
                                    }else if(dateNoti >= currentDate){
                                        level = 2;
                                    }else{
                                        level = 3;
                                    }
                                }else{
                                    if (dateMiddle >= currentDate) {
                                        level = 1;
                                    } else if (dateFromTramite >= currentDate) {
                                        level = 2;
                                    } else {
                                        level = 3;
                                    }
                                }
                            }
                            
                            
                            var color = level == 1 || data.USTR_NESTATUS == 8 || data.USTR_NESTATUS == 9 ? "green" : (level == 2 ? "yellow" : (level == 3 ? "red" : "black"));
                        
                            return '<span class="dot" style="background-color:' + color + '"></span>';
                        }
                    },
                    {
                        data: 'USTR_DFECHACREACION_FORMAT',
                    },
                    {
                        "data": null,
                        render: function(data, type, row) {
                            var fecha = "";
                            if (data.fecha_asignacion) {
                                fecha = data.fecha_asignacion;
                            } else {
                                fecha = '';
                            }
                            return fecha;
                        }
                    },
                    {
                        "data": "USTR_CFOLIO"
                    },
                    {
                        "data": null,
                        render: function(data, type, row) {
                            var nombre = "";
                            if (data.USTR_CNOMBRE_COMPLETO == "" || data.USTR_CNOMBRE_COMPLETO == null) {
                                if(data.USTR_CTIPO_PERSONA == 'FISICA'){

                                    if (data.USTR_CSEGUNDO_APELLIDO == null || data.USTR_CSEGUNDO_APELLIDO == "") {
                                    nombre = data.USTR_CNOMBRE + " " + data.USTR_CPRIMER_APELLIDO;
                                    } else {
                                        nombre = data.USTR_CNOMBRE + " " + data.USTR_CPRIMER_APELLIDO + " " + data.USTR_CSEGUNDO_APELLIDO;
                                    }
                                }else{
                                nombre = data.USTR_CRAZON_SOCIAL;
                                }
                            } else {
                                if(data.USTR_CTIPO_PERSONA == 'FISICA'){

                                    nombre = data.USTR_CNOMBRE_COMPLETO;
                                }else{
                                    nombre = data.USTR_CRAZON_SOCIAL;
                                }
                            }
                            return nombre;
                        }
                    },
                    {
                        "data": "USTR_CRFC"
                    },
                    {
                        "data": "USTR_CNOMBRE_TRAMITE"
                    },
                    {
                        "data": "tram_razon_social",
                    },
                    {
                        "data": "tram_rfc"
                    },
                    {
                        data: null,//'USTR_NESTATUS',
                        render: function(data, type, row) {
                            if(isVencido){
                                if (type === 'display') {
                                    var status = 'Vencido';
                                    return status;
                                }
                            }else{
                                var user_act = '';
                                if (type === 'display') {
                                    var status = estatus_seguimiento.find(x => x.id === parseInt(data.USTR_NESTATUS));
                                    if(data.USTR_NESTATUS == 2 && data.USTR_NBANDERA_PROCESO == 2){
                                        user_act = ' <br>(observaciones atendidas)';
                                    }
                                    return status.nombre+user_act;
                                }
                            }
                            
                            return data;
                        }
                    },
                    {
                        data: 'analista'
                    },
                    {
                        /**
                         * !configurar para mostrar el botón asignar 
                         */
                        data: null,
                        render: function(data, type, row) {
                            let html =  `<span>
                                            <button type="button" onclick="verDetalle(${ data.USTR_NIDUSUARIOTRAMITE })" title="Ver detalles" class="btn btn-link"><i class="fas fa-eye" style="color: black"></i></button>
                                        </span>
                                        <span>
                                            <button type="button" onclick="Editar(${ data.USTR_NIDUSUARIOTRAMITE })" title="Editar seguimiento"  class="btn btn-link"><i class="fas fa-edit" style="color: black"></i></button>
                                        </span>`;

                                        if(data.rol != 'ANTA'){
                                            html +=`<span>`;
                                                if(data.asignado != 0){
                                                    
                                                    html +=`<input type="hidden" id="asignado_${ data.USTR_NIDUSUARIOTRAMITE }" value="${ data.responsable }">
                                                            <button type="button" onclick="asignarFuncionarioModal(${ data.USTR_NIDUSUARIOTRAMITE })" title="Reasignar funcionario"  class="btn btn-link"><i id="icon-${ data.USTR_NIDUSUARIOTRAMITE }" class='fa-solid fa-user-check' style="color: black"></i></button>`;
                                                }
                                                else{
                                                    html +=`<input type="hidden" id="asignado_${ data.USTR_NIDUSUARIOTRAMITE }" value="0">
                                                            <button type="button" onclick="asignarFuncionarioModal(${ data.USTR_NIDUSUARIOTRAMITE })" title="Asignar funcionario"  class="btn btn-link"><i id="icon-${ data.USTR_NIDUSUARIOTRAMITE }" class='fa fa-users' style="color: black"></i></button>`;
                                                }
                                            html +=`</span>`;
                                        }

                                html +=` <span>
                                            <button type="button" onclick="descargar(${ data.USTR_NIDUSUARIOTRAMITE }, 'TRAM_${ data.USTR_CFOLIO }' )" title="Descargar" class="btn btn-link"><i class="fas fa-download" style="color: black"></i></button>
                                        </span>`;         

                                return html;
                        }
                    },
                ],
                searching: false,
                ordering: true,
                paging: true,
                bLengthChange: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todos"]
                ],
                dom: 'Blrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    }
                ]
            });
        }
        else{
            table = $('#example').DataTable({
            responsive: true,
            "language": {
                url: "/assets/template/plugins/DataTables/language/Spanish.json",
                "search": "Filtrar resultados:",
            },
            "ajax": {
                // "data": filtro,
                "url": "/tramite_servicio_cemr/find",
                "type": "POST",
                "data": function(d) {
                    
                    isVencido = false
                    return $.extend({}, d, {
                        "fecha": $('#txtFecha').val(),
                        "folio": $('#txtFolio').val(),
                        "tramite": $('#txtTramite').val(),
                        "razonSocial": $('#txtRazon').val(),
                        "nombre": $('#txtNombre').val(),
                        "rfc": $('#txtRFC').val(),
                        "curp": $('#txtCURP').val(),
                        "estatus": $('#txtEstatus').val(),
                    });
                },
                "beforesend": function(){
                    alert('mi mensaje');// to debug error
                },
                "error": function(thrownError){
                    alert('mi mensaje');// to debug error
                }
            },
            "columns": [
                    {
                        data: null,
                        render: function(data, type, row) {
                            var dateFromTramite = new Date(data.USTR_DFECHACREACION);
                            dateFromTramite.setDate(parseInt(dateFromTramite.getDate()) + parseInt(data.USTR_NDIASHABILESRESOLUCION));

                            var dateMiddle = new Date(data.USTR_DFECHACREACION);
                            dateMiddle.setDate(parseInt(dateMiddle.getDate()) + parseFloat(parseInt(data.USTR_NDIASHABILESRESOLUCION) / 2));

                            var dateTwoDays = new Date(data.USTR_DFECHACREACION);
                            dateTwoDays.setDate(parseInt(dateTwoDays.getDate()) + parseFloat(parseInt(data.USTR_NDIASHABILESRESOLUCION) - 2));
                            //Fecha de notificacion
                            var currentDate = new Date();

                            var level = 0;
                            if(data.USTR_NESTATUS != 4){
                                if(data.USTR_NESTATUS != 10 && data.USTR_NESTATUS != 11){
                                    if(currentDate > dateFromTramite){
                                        isVencido = true
                                        level = 4;
                                    }else if(currentDate >= dateTwoDays){
                                        level = 3;
                                    }else if (dateMiddle >= currentDate) {
                                        level = 1;
                                    } else if (dateFromTramite >= currentDate) {
                                        level = 2;
                                    } else {
                                        level = 3;
                                    }
                                }else if(data.USTR_NESTATUS == 1){
                                    level = 1;
                                }else{
                                    level =3;
                                }
                            }else{
                                if(data.USTR_DFECHAESTATUS != null){
                                    var dateNoti = new Date(data.USTR_DFECHAESTATUS);
                                    dateNoti.setDate(parseInt(dateNoti.getDate()) + parseInt(data.USTR_NDIASHABILESNOTIFICACION));

                                    var dateNotiMedio = new Date(data.USTR_DFECHAESTATUS);
                                    dateNotiMedio.setDate(parseInt(dateNotiMedio.getDate()) + parseFloat(parseInt(data.USTR_NDIASHABILESNOTIFICACION) / 2));
                                    if(dateNotiMedio >= currentDate){
                                        level = 1;
                                    }else if(dateNoti >= currentDate){
                                        level = 2;
                                    }else{
                                        level = 3;
                                    }
                                }else{
                                    if (dateMiddle >= currentDate) {
                                        level = 1;
                                    } else if (dateFromTramite >= currentDate) {
                                        level = 2;
                                    } else {
                                        level = 3;
                                    }
                                }
                            }
                            
                            
                            var color = level == 1 || data.USTR_NESTATUS == 8 || data.USTR_NESTATUS == 9 ? "green" : (level == 2 ? "yellow" : (level == 3 ? "red" : "black"));
                        
                            return '<span class="dot" style="background-color:' + color + '"></span>';
                        }
                    },
                    {
                        data: 'USTR_DFECHACREACION_FORMAT',
                    },
                    {
                        "data": "USTR_CFOLIO"
                    },
                    {
                        "data": null,
                        render: function(data, type, row) {
                            var nombre = "";
                            if (data.USTR_CNOMBRE_COMPLETO == "" || data.USTR_CNOMBRE_COMPLETO == null) {

                            
                                if(data.USTR_CTIPO_PERSONA == 'FISICA'){

                                    if (data.USTR_CSEGUNDO_APELLIDO == null || data.USTR_CSEGUNDO_APELLIDO == "") {
                                    nombre = data.USTR_CNOMBRE + " " + data.USTR_CPRIMER_APELLIDO;
                                    } else {
                                        nombre = data.USTR_CNOMBRE + " " + data.USTR_CPRIMER_APELLIDO + " " + data.USTR_CSEGUNDO_APELLIDO;
                                    }
                                }else{
                                nombre = data.USTR_CRAZON_SOCIAL;
                                }
                            } else {
                                if(data.USTR_CTIPO_PERSONA == 'FISICA'){

                                    nombre = data.USTR_CNOMBRE_COMPLETO;
                                }else{
                                    nombre = data.USTR_CRAZON_SOCIAL;
                                }
                            }
                            return nombre;
                        }
                    },
                    {
                        "data": "USTR_CRFC"
                    },
                    {
                        "data": "USTR_CNOMBRE_TRAMITE"
                    },
                    {
                        data: null,//'USTR_NESTATUS',
                        render: function(data, type, row) {
                            if(isVencido){
                                if (type === 'display') {
                                    var status = 'Vencido';
                                    return status;
                                }
                            }else{
                                var user_act = '';
                                if (type === 'display') {
                                    var status = estatus_seguimiento.find(x => x.id === parseInt(data.USTR_NESTATUS));
                                    if(data.USTR_NESTATUS == 2 && data.USTR_NBANDERA_PROCESO == 2){
                                        user_act = '<br> (observaciones atendidas)';
                                    }
                                    return status.nombre+user_act;
                                }
                            }
                            
                            return data;
                        }
                    },
                    {
                        /**
                         * !configurar para mostrar el botón asignar 
                         */
                        data: null,
                        render: function(data, type, row) {
                            let html =  `<span>
                                            <button type="button" onclick="verDetalle(${ data.USTR_NIDUSUARIOTRAMITE })" title="Ver detalles" class="btn btn-link"><i class="fas fa-eye" style="color: black"></i></button>
                                        </span>
                                        <span>
                                            <button type="button" onclick="Editar(${ data.USTR_NIDUSUARIOTRAMITE })" title="Editar seguimiento"  class="btn btn-link"><i class="fas fa-edit" style="color: black"></i></button>
                                        </span>`;

                                        if(data.rol != 'ANTA'){
                                            html +=`<span>`;
                                                if(data.asignado != 0){
                                                    
                                                    html +=`<input type="hidden" id="asignado_${ data.USTR_NIDUSUARIOTRAMITE }" value="${ data.responsable }">
                                                            <button type="button" onclick="asignarFuncionarioModal(${ data.USTR_NIDUSUARIOTRAMITE })" title="Reasignar funcionario"  class="btn btn-link"><i id="icon-${ data.USTR_NIDUSUARIOTRAMITE }" class='fa-solid fa-user-check' style="color: black"></i></button>`;
                                                }
                                                else{
                                                    html +=`<input type="hidden" id="asignado_${ data.USTR_NIDUSUARIOTRAMITE }" value="0">
                                                            <button type="button" onclick="asignarFuncionarioModal(${ data.USTR_NIDUSUARIOTRAMITE })" title="Asignar funcionario"  class="btn btn-link"><i id="icon-${ data.USTR_NIDUSUARIOTRAMITE }" class='fa fa-users' style="color: black"></i></button>`;
                                                }
                                            html +=`</span>`;
                                        }

                                html +=` <span>
                                            <button type="button" onclick="descargar(${ data.USTR_NIDUSUARIOTRAMITE }, 'TRAM_${ data.USTR_CFOLIO }' )" title="Descargar" class="btn btn-link"><i class="fas fa-download" style="color: black"></i></button>
                                        </span>`;         

                                return html;
                        }
                    },
                ],
                searching: false,
                ordering: true,
                paging: true,
                bLengthChange: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todos"]
                ],
                dom: 'Blrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        //className: 'btn btn-xs btn-primary p-5 m-0 width-35 assets-export-btn export-csv',
                        charset: 'UTF-8',
                        bom: true,
                        customize: function (csv) {
                            //Split the csv to get the rows
                            var split_csv = csv.split("\n");

                            //Remove the row one to personnalize the headers
                            //split_csv[0] = '"field0","field1","field2","field3","field4","field5"';

                            //For each row except the first one (header)
                            $.each(split_csv.slice(1), function (index, csv_row) {
                                //Split on quotes and comma to get each cell
                                var csv_cell_array = [];
                                csv_cell_array = csv_row.split('","');
                                csv_cell_array[1] = csv_cell_array[1].concat("");
                                split_csv[index+1] = csv_cell_array.join('","');                             
                            });

                            //Join the rows with line breck and return the final csv (datatables will take the returned csv and process it)
                            csv = split_csv.join("\n");
                            return csv;
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    }
                ]
            });
        }
    }

    function verDetalle(id) {
        var host = window.location.origin;
        location.href = "/tramite_servicio_cemr/detalle/" + id;
    }

    function Editar(id) {
        var host = window.location.origin;
        location.href = "/tramite_servicio_cemr/seguimiento/" + id;
    }

    function descargar(id = 1, name = 'Archivo 1') {

        Swal.fire({
            title: '¡Confirmar!',
            text: "Se descargará el expendiente " + name + " ¿Deseas continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '/tramite_servicio_cemr/download_tramite/' + id,
                    success: function(response) {
                        if(response.name != undefined){
                            window.location = response.name;
                        }else{
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Ha ocurrido un error!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                        
                    },
                    error: function(blob) {
                        console.log(blob);
                    }
                });
            }
        });
    }

    function clean_filter() {
        $('#txtFecha').val('');
        $('#txtFolio').val('');
        $('#txtTramite').val(0);
        $('#txtRazon').val('');
        $('#txtNombre').val('');
        $('#txtRFC').val('');
        $('#txtCURP').val('');
        $('#txtEstatus').val(0);
        $("#txtTramite").selectpicker("refresh");
        filter();
    }

    function filter() {
        table.ajax.reload();
    }

    function listaAnalistas(){  
        listado = []; 
        html = '';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if(rol=='ADM'){
            $.ajax({
                type: 'GET',
                url: "/ListaAnalistas/", 
                success: function(result){
                    analistas = result;
                    html += '<option value="'+0+'" >Sin Asignación</option>';
                    for(i=0; i<result.length; i++){
                        var nombre = result[i].USUA_CPRIMER_APELLIDO+' '+result[i].USUA_CSEGUNDO_APELLIDO+' '+result[i].USUA_CNOMBRES;
                        html += '<option value="'+result[i].USUA_NIDUSUARIO+'" >'+nombre+'</option>';
                    }
                    $("#tipoIdres").html(result);
                    $("#analistaSelec").html(html);
                }}
            );
        }else{
            $.ajax({
                type: 'GET',
                url: "/ListaAnalistasArea/"+id_user, 
                success: function(result){
                    analistas = result;
                    html += '<option value="'+0+'" >Sin Asignación</option>';
                    for(i=0; i<result.length; i++){
                        var nombre = result[i].USUA_CPRIMER_APELLIDO+' '+result[i].USUA_CSEGUNDO_APELLIDO+' '+result[i].USUA_CNOMBRES;
                        html += '<option value="'+result[i].USUA_NIDUSUARIO+'" >'+nombre+'</option>';
                    }
                    $("#tipoIdres").html(result);
                    $("#analistaSelec").html(html);
                }}
            );
        }
    }

    // ! modalito
    function asignarFuncionarioModal(tramiteId) {
        let html = '<option value="'+0+'" >Sin Asignación</option>';
        analistas.forEach(element => {
            var nombre = element.USUA_CPRIMER_APELLIDO + ' '+ element.USUA_CSEGUNDO_APELLIDO + ' ' + element.USUA_CNOMBRES;
            html += '<option value="'+ element.USUA_NIDUSUARIO +'" >'+ nombre +'</option>';
        });

        $("#analistaSelec").html(html);


        let responsableId = $("#asignado_"+ tramiteId).val();
        if(responsableId != 0){
            $("#analistaSelec option[value="+ responsableId +"]").attr("selected", true);
        }

        $("#idTramite").val(tramiteId);
        $("#asignarFuncionarioModal").modal('show');
    }

    function asignarFuncionario() {
        listado = []; 
        let self = this;
        var htmlid = $("#idTramite").val();
        var envio = {
                USTR_NIDUSUARIOTRAMITE: $("#idTramite").val(),
                USUA_NIDUSUARIO: $("#analistaSelec").val(),
                USUA_NIDUSUARIOREGISTRO: 0,
            };
        
        $.ajax({
            data: envio,
            type: 'POST',
            url: "tramite_servicio_cemr/asignar_tramite", 
            success: function(result){
                $("#asignarFuncionarioModal").modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: result.estatus,
                    title: '',
                    text: result.mensaje,
                    footer: '',
                    timer: 4000,
                    showConfirmButton: false
                });
            },
            error: function(result) {
                Swal.fire({
                    icon: "error",
                    title: '',
                    text: result.mensaje,
                    footer: '',
                    timer: 3000
                });
            }
        });
    }
    // ! modalito
</script>


<style>
    .bootstrap-select .dropdown-menu {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        width: 24rem;
    }

    .dropdown-item {
        display: block;
        width: 100%;
        padding: 0.25rem 1rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        font-size: 12px;
    }

    /* CSS Manuel Euan */
    .body {
        min-height: 700px;
    }

    .border {
        border-radius: 5px;
    }

    .btnLetras {
        color: #fff;
        font-weight: 900;
        margin-left: 20px;
        min-width: 180px;
    }

    .btnBuscar {
        margin-top: 1.2%;
        margin-right: 20px;
        margin-left: 20px;
    }

    .btnLimpiar {
        background-color: #01b3e8;
        border-color: #01b3e8;
        color: #ffffff;
        margin-left: 20px;
    }

    label {
        font-weight: bold;
    }

    .resultados_De_busqueda {
        font-weight: bold;
        margin-top: 40px;
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

    .buttons-html5 {
        background-color: #01b3e8 !important;
    }
</style>
@endsection