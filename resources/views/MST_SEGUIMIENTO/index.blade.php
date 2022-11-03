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
                    <button class="btn btn-sm btn-primary" id="btn_search"  onclick="listar()">Buscar</button>
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
            <div class="col-12">
                <div class="input-group mb-3">
                    <label style="margin:10px;" for="selctItems">Mostrar: </label>
                    <div style="width: 70px;">
                        <select class="custom-select" id="selctItems" onchange="listar(false)">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <label style="margin:10px;" for="selctItems">registros. </label>
                </div>

                <div class="row">
                    <div class="col-md-12" id="divTabla" style="text-align: center;">
                        <table id="tblTramites" class="table table-bordered" style="width: 100%">
                            <thead class="bg-gob">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Folio</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Dependencia</th>
                                    <th>Estatus</th>
                                    <th >Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
   
    var varPaginacion = {
        "order"         : "desc",
        "orderBy"       : "v.USTR_DFECHAMODIFICADO",
        "items_to_show" : 10,
        "page"          : "page=1",

        "fecha"         : null,
        "folio"         : null,
        "usuario"       : null,
        "estatus"       : null,
        "dependencia"   : null,
    };



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
        },
        {
            id: 10,
            nombre: "Cancelado"
        },
        {
            id: 11,
            nombre: "Iniciado"
        },
    ];

    var estatus_seguimiento2 = [{
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
        },
        {
            id: 10,
            nombre: "Cancelado"
        },
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
                        cmbDependenciaEntidad.append('<option value="' + v.iId + '">' + v.name + '</option>');
                    })
                },
                error: function(data) {

                }
            });
        }

        TRAM_AJX_CONSULTAR_FILTRO();

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

            $(estatus_seguimiento2).each(function(i, v) {
                cmbEstatus.append('<option value="' + v.id + '">' + v.nombre + '</option>');
            });
        }

        listar();
        //TRAM_AJX_CONSULTARDEPENDENCIAENTIDAD();
        TRAM_FN_CMBESTATUS();
    });

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

    /**************** Manuel Euan  **********/
    function listar(pag= true) {
        $("#btn_search").prop("disabled", true);
        $("#tbody").remove();
        $("#paginacion").remove();
        $("#divTabla").append(`<div id="spinner" class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`);

        varPaginacion.fecha = $('#dteFechaInicio').val();
        varPaginacion.nombre = $('#txtNombre').val();
        varPaginacion.estatus = $('#cmbEstatus').val();
        varPaginacion.dependencia = $('#cmbDependenciaEntidad').val();
        varPaginacion.page = pag == false ? 1 :  varPaginacion.page;
        varPaginacion.items_to_show = $("#selctItems option:selected").text();

       
        request = $.ajax({
            url: "/seguimiento/consultar",
            type: "get",
            data: varPaginacion
        });

        request.done(function (response, textStatus, jqXHR){
            let items = response.data;
            let html = '<tbody id="tbody">';
            if(items.length > 0)
                items.forEach(element => {
                    let estatus = estatus_seguimiento[(element.USTR_NESTATUS - 1)];
                    html+= `<tr role='row' class'odd>
                                <td> ${ element.USTR_DFECHACREACION  } </td>
                                <td> ${ element.USTR_CFOLIO } </td>
                                <td> ${ element.USTR_CNOMBRE_COMPLETO } </td>
                                <td> ${ element.USTR_CNOMBRE_TRAMITE  } </td>
                                <td> ${ element.USTR_CCENTRO   } </td>
                                <td> ${ estatus.nombre } </td>
                                <td>
                                    <a href="/tramite_servicio/seguimiento_tramite/${element.USTR_NIDUSUARIOTRAMITE}" class="btn btn-primary" style="float: right;">Ver trámite</a>
                                </td>
                            </tr>`;

                });
            else{
                html += '<tr class="odd text-center"><td valign="top" colspan="6" class="dataTables_empty">Ningún dato disponible en esta tabla</td></tr>';
            }
            html+= `</tbody>`;
                                    
             $("#btn_search").prop("disabled", false);
            let anterior = response.current_page == 1 ? "disabled" : "";
            let siguiente= response.current_page == response.last_page ? "disabled" : "";
            let paginacion = `
                <div class="row" id="paginacion" style="margin-top: 30px;">
                    <div class="col-md-6 dataTables_info" style="margin-top:10px;" role="status" aria-live="polite">Mostrando registros del ${response.from} al ${response.to} de un total de ${response.total} registros</div>

                    <div class="col-md-6 float-right">
                    <nav aria-label="Page navigation example" style="float:right;">
                        <ul class="pagination">
                            <li class="page-item  ${anterior}">
                                <a class="page-link" href="javascript:onclick=cambiaPagina(${ response.current_page - 1 });" tabindex="-1">Anterior</a>
                            </li>`;

                            let num_paginas = response.last_page;
                            let activo = "";

                            for (let i = 1; i <= num_paginas; i++) {
                                if(i == response.current_page){
                                    activo = "active";
                                }
                                else{
                                    activo = "";
                                }

                                if(response.last_page > 4){
                                    if(response.current_page <= 3){
                                        if(i <= 4){
                                            paginacion+=` <li class="page-item ${activo}"><a class="page-link" href="javascript:onclick=cambiaPagina(${ i });">${ i }</a></li>`;
                                        }
                                        else if( i == 5){
                                            paginacion+=` <li class="page-item ${activo}"><a class="page-link">...</a></li>`;
                                        }

                                    }
                                    else{
                                        if( i == ( response.current_page -2)){
                                            paginacion+=` <li class="page-item ${activo}"><a class="page-link">...</a></li>`;
                                        }
                                        if( i == (response.current_page - 1) || i == response.current_page || i == (response.current_page +1) ){
                                            paginacion+=` <li class="page-item ${activo}"><a class="page-link" href="javascript:onclick=cambiaPagina(${ i });">${ i }</a></li>`;
                                        }
                                        if( i == ( response.current_page  + 2)){
                                            paginacion+=` <li class="page-item ${activo}"><a class="page-link">...</a></li>`;
                                        }
                                    }
                                }
                                else{
                                    paginacion+=` <li class="page-item ${activo}"><a class="page-link" href="javascript:onclick=cambiaPagina(${ i });">${ i }</a></li>`;
                                }
                            }

                paginacion+=`<li class="page-item ${siguiente}">
                                <a class="page-link" href="javascript:onclick=cambiaPagina(${ response.current_page + 1 });">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                    </div>
                </div>   `;

            $("#tblTramites").append(html);
            $("#divTabla").append(paginacion);
            $("#spinner").remove();
        });
    }

    function cambiaPagina(pagina){
        varPaginacion.page = pagina;
        listar();
    }

    $('th').click(function() {
        var table   = $(this).parents('table').eq(0)
        var rows    = []
        var column  = table.context.innerText;

        this.asc = !this.asc
        if (!this.asc) {
            rows = rows.reverse()
        }
        setIcon($(this), this.asc, column);
    })

    function setIcon(element, asc, column) {
        $("th").each(function(index) {
            $(this).removeClass("sorting");
            $(this).removeClass("asc");
            $(this).removeClass("desc");
        });
        element.addClass("sorting");
        if (asc) element.addClass("asc");
        else element.addClass("desc");


        let orderBy = 'u.USUA_NIDUSUARIO';
        let order   = asc == true ? 'asc' : 'desc';

        switch (column) {
            case 'Fecha'    : orderBy = 'fecha'; break;
            case 'Folio'    : orderBy = 'folio'; break;
            case 'Usuario'  : orderBy = 'usuario'; break;
            case 'Estatus'  : orderBy = 'estatus'; break;
            case 'Dependencia': orderBy = 'dependencia'; break;
            default: break;
        }

        if(column !== 'Acciones'){
            varPaginacion.order     = order;
            varPaginacion.orderBy  = orderBy;
            listar();
        }
    }
</script>
@endsection
