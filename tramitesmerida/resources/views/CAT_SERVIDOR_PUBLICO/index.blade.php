@extends('layout.Layout')

@section('body')

<!-- <%-- Contenido individual --%> -->
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2>Servidores Publicos</h2>
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
                            <label for="txtNombre">Nombre</label>
                            <input type="text" placeholder="Nombre" class="form-control" name="txtNombre" id="txtNombre">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtPaterno">Primer apellido</label>
                            <input type="text" placeholder="Primer apellido" class="form-control" name="txtPaterno" id="txtPaterno">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtMaterno">Segundo apellido</label>
                            <input type="text" placeholder="Segundo apellido" class="form-control" name="txtMaterno" id="txtMaterno">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbRol">Rol</label>
                            <select class="combobox form-control" name="cmbRol" id="cmbRol">
                                <option value ='0'>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbEstatus">Estatus</label>
                            <select class="combobox form-control" name="cmbEstatus" id="cmbEstatus">
                                <option value ='0'>Seleccionar</option>
                                <option value ='true'>Activo</option>
                                <option value ='false'>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtCorreo">Correo electrónico</label>
                            <input type="text" placeholder="Correo electrónico" class="form-control" name="txtCorreo" id="txtCorreo">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cmbDepPertenece">Dependencia o entidad al que pertence</label>
                            <select class="cmbDepPertenece form-control" name="cmbDepPertenece" id="cmbDepPertenece" onchange="cambiaDependencia(this, 'pertenece');">
                                <option value ='0'>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cmbPertenece">Unidad administrativa a la que pertence</label>
                            <select class="combobox form-control" name="cmbPertenece" id="cmbPertenece">
                                <option value='0'>seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cmbDepPuedeTenerAcceso">Dependencia o entidad al que puede tener acceso</label>
                            <select class="combobox form-control" name="cmbDepPuedeTenerAcceso" id="cmbDepPuedeTenerAcceso" onchange="cambiaDependencia(this, 'acceso');">
                                <option value ='0'>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cmbPuedeTenerAcceso">Unidad administrativa a la que puede tener acceso</label>
                            <select class="combobox form-control" name="cmbPuedeTenerAcceso" id="cmbPuedeTenerAcceso">
                                <option value ='0'>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <button class="btn btn-sm btn-primary" id="btn_search" onclick="buscar()">Buscar</button>
                    <a class="btn btn-sm btn-primary" href="{{ url('servidorespublicos/crear') }}">Agregar</a>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btnExport waves-effect waves-light" onclick="limpiar()">Limpiar</button>
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
                        <table id="tblFormularios" class="table table-bordered" style="width: 100%">
                            <thead class="bg-gob">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Primer apellido</th>
                                    <th>Segundo apellido</th>
                                    <th>Rol</th>
                                    <th style="width: 20%">Acciones</th>
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
<style>
    .btnExport {
        background-color: #ffa000;
        border-color: #ffa000;
        color: #ffffff;
        margin-right: 4px;
    }

    .btnExport:hover {
        color: #ffffff;
    }
</style>
@endsection

@section('scripts')
<script>
    var table = null;
    /* Variables para la paginacion */   
    var varPaginacion = {
        "order"          : "desc",
        "order_by"       : "u.USUA_NIDUSUARIO",
        "items_to_show"  : 10,
        "page"           : "page=1",

        "nombre"        : null,
        "primer_Ap"     : null,
        "segundo_AP"    : null,
        "correo"        : null,
        "rol"           : null,
        "estatus"       : null,
        "dep_pertenece" : null,
        "uni_pertenece" : null,
        "dep_acceso"    : null,
        "uni_acceso"    : null
    };



    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        request = $.ajax({
            url: "/general/roles",
            type: "get",
            data: {"paginate":true, 'estatus':'Activos'}
        });
    
        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            var $select = $('#cmbRol');
            response.forEach(element => {
                if(element.ROL_NIDROL != 2){
                    $select.append('<option value=' + element.ROL_NIDROL + '>' + element.ROL_CNOMBRE + '</option>'); // return empty
                }
            });
            
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });

        dependencias = $.ajax({
            url: "/general/dependencias",
            type: "get",
        });
    
        // Callback handler that will be called on success
        dependencias.done(function (response, textStatus, jqXHR){
            var $dep1 = $('#cmbDepPertenece');
            var $dep2 = $('#cmbDepPuedeTenerAcceso');

            response.forEach(element => {
                $dep1.append('<option value=' + element.ID_CENTRO + '>' + element.DESCRIPCION + '</option>');
                $dep2.append('<option value=' + element.ID_CENTRO + '>' + element.DESCRIPCION + '</option>');
            });
            
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
        listar();
    });

    function cambiaDependencia(data, tipo){
        unidad = $.ajax({
            url: "/general/unidades_administrativas",
            type: "get",
            data: {"dependencia_id":  data.value }

        });
    
        // Callback handler that will be called on success
        unidad.done(function (response, textStatus, jqXHR){
            let unidad = $('#cmbPuedeTenerAcceso');

            if(tipo == "pertenece"){
                unidad = $('#cmbPertenece');
            }

            response.forEach(element => {
                unidad.append('<option value=' + element.ID_CENTRO + '>' + element.DESCRIPCION + '</option>');
            });
        });

        // Callback handler that will be called on failure
        unidad.fail(function (jqXHR, textStatus, errorThrown){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });

    }
    
    function TRAM_FN_EDITAR(IntIdUsuario){
        document.location.href = '/servidorespublicos/editar/' + IntIdUsuario;
    };

    function TRAM_AJX_DETALLE(IntIdUsuario){
        document.location.href = '/servidorespublicos/detalle/' + IntIdUsuario;
    }

    function buscar(){
        
        varPaginacion = {
            "nombre"        : $("#txtNombre").val(),
            "primer_Ap"     : $("#txtPaterno").val(),
            "segundo_AP"    : $("#txtMaterno").val(),
            "rol"           : $("#cmbRol option:selected").val(),
            "correo"        : $("#txtCorreo").val(),
            "estatus"       : $("#cmbEstatus option:selected").val(),
            "dep_pertenece" : $("#cmbDepPertenece option:selected").val(),
            "uni_pertenece" : $("#cmbPertenece option:selected").val(),
            "dep_acceso"    : $("#cmbDepPuedeTenerAcceso option:selected").val(),
            "uni_acceso"    : $("#cmbPuedeTenerAcceso option:selected").val(),
            "page"           : 1
        };

        listar();
    }

    function limpiar(){
        $("#txtNombre").val("");
        $("#txtPaterno").val("");
        $("#txtMaterno").val("");
        $("#txtCorreo").val("");
        $("#cmbRol").val("0");
        $("#cmbEstatus").val("0");
        $("#cmbDepPertenece").val("0");
        $("#cmbPertenece").val("0");
        $("#cmbDepPuedeTenerAcceso").val("0");
        $("#cmbPuedeTenerAcceso").val("0");
        
        varPaginacion = {
            "order"          : "desc",
            "order_by"       : "u.USUA_NIDUSUARIO",
            "items_to_show"  : 10,
            "page"           : "page=1",

            "nombre"        : null,
            "primer_Ap"     : null,
            "segundo_AP"    : null,
            "correo"        : null,
            "rol"           : null,
            "estatus"       : null,
            "dep_pertenece" : null,
            "uni_pertenece" : null,
            "dep_acceso"    : null,
            "uni_acceso"    : null
        };

        listar();
    }
    
    function cambiaPagina(pagina){
        varPaginacion.page = pagina;
        listar();
    }

    function Eliminar(id){
        Swal.fire({
                title: '¿Esta seguro de realizar la operación?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed){
                                   
                    request = $.ajax({
                        url: "/general/delete_usuario",
                        type: "post",
                        data: {"id": id}
                    });

                    request.done(function (response, textStatus, jqXHR){
                        listar();

                        Swal.fire({
                            icon: 'success',
                            title: 'Operación exitosa',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'se presento el siguiente error: ' + errorThrown
                        });
                    });
                }
            });
    }


                            /*
                                <span>
                                    <button type="button"  onclick="Eliminar(${ usuarios[i].USUA_NIDUSUARIO });" title="Eliminar" class="btn btn-link"><i class="fas fa-trash" style="color: black"></i></button>
                                </span>*/
    function listar(pag= true){
        $("#btn_search").prop("disabled", true);
        $("#tbodyFormulario").remove();
        $("#paginacion").remove();
        $("#divTabla").append(`<div id="spinner" class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`);

        varPaginacion.items_to_show = $("#selctItems option:selected").text();
        if(pag == false){
            varPaginacion.page = 1;
        }

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        request = $.ajax({
            url: "/general/usuarios",
            type: "get",
            data: varPaginacion
        });

        request.done(function (response, textStatus, jqXHR){ 
            let usuarios = response.data;
            let html = '<tbody id="tbodyFormulario">';
            if(usuarios.length > 0)
                for (let i = 0; i < usuarios.length; i++) {
                    let estatus     = usuarios[i].USUA_NACTIVO == true ? 'Habilitar' : 'Deshabilitar';
                    html+= `<tr role='row' class'odd>
                                <td> ${ usuarios[i].USUA_CUSUARIO           == null ? "" : usuarios[i].USUA_CUSUARIO  } </td>
                                <td> ${ usuarios[i].USUA_CNOMBRES           == null ? "" : usuarios[i].USUA_CNOMBRES  } </td>
                                <td> ${ usuarios[i].USUA_CPRIMER_APELLIDO   == null ? "" : usuarios[i].USUA_CPRIMER_APELLIDO  } </td>
                                <td> ${ usuarios[i].USUA_CSEGUNDO_APELLIDO  == null ? "" : usuarios[i].USUA_CSEGUNDO_APELLIDO  } </td>
                                <td> ${ usuarios[i].USUA_CROLNOMBRE         == null ? "" : usuarios[i].USUA_CROLNOMBRE  } </td>
                                <td>
                                    <span>
                                        <button type="button"  onclick="TRAM_FN_EDITAR(${ usuarios[i].USUA_NIDUSUARIO });" title="Editar" class="btn btn-link"><i class="fas fa-edit" style="color: black"></i></button>
                                    </span>
                                    <span>
                                        <button type="button"  onclick="TRAM_AJX_DETALLE(${ usuarios[i].USUA_NIDUSUARIO });" title="Ver" class="btn btn-link"><i class="fas fa-eye" style="color: black"></i></button>
                                    </span>
                                
                                    <span>
                                            <button type="button" onclick="cambiaEstatus(${ usuarios[i].USUA_NIDUSUARIO })" title="${estatus}" class="btn btn-link">`;
                                    if(usuarios[i].USUA_NACTIVO == true)
                                                html += `<i class="fas fa-toggle-off" style="color: black"></i>`;
                                            else
                                                html += `<i class="fas fa-toggle-on" style="color: black"></i>`;
                                        
                                                html +=`</button></span>
                                </td>
                            </tr>`;
                }
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

            $("#tblFormularios").append(html);
            $("#divTabla").append(paginacion);
            $("#spinner").remove();
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            $("#btn_search").prop("disabled", false);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
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


            let order_by = 'u.USUA_NIDUSUARIO';
            let order   = asc == true ? 'asc' : 'desc';

            switch (column) {
                case 'Usuario':
                    order_by = 'u.USUA_CUSUARIO';
                    break;
                case 'Nombre':
                    order_by = 'u.USUA_CNOMBRES';
                    break;
                case 'Primer apellido':
                    order_by = 'u.USUA_CPRIMER_APELLIDO';
                    break;
                case 'Segundo apellido':
                    order_by = 'u.USUA_CSEGUNDO_APELLIDO';
                    break;
                case 'Rol':
                    order_by = 'rol.ROL_CNOMBRE';
                    break;
                default:
                    break;
            }

            if(column !== 'Acciones'){
                varPaginacion.order     = order;
                varPaginacion.order_by  = order_by;
                listar();
            }
        }

        function cambiaEstatus(id){
            Swal.fire({
                title: '¿Esta seguro de realizar la operación?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed){
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    });

                    request = $.ajax({
                        url: '/personasfsicasmorales/status',
                        type: "post",
                        data: {"id": id}
                    });

                    request.done(function (response, textStatus, jqXHR){
                        console.log(response);
                        listar();
                        Swal.fire({
                            icon: 'success',
                            title: 'Operación exitosa',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'se presento el siguiente error: ' + errorThrown
                        });
                    });
                }
            });
        }

</script>
@endsection

<style>
    /*  Css para ordenamiento de tablas */
    table tr th {
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .sorting {
        background-color: #D4D4D4;
    }

    .asc:after {
        content: ' ↑';
    }

    .desc:after {
        content: " ↓";
    }
    .dataTables_info{
        text-align: left !important;
    }
</style>