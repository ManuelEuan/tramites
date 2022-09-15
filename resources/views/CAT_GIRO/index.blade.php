@extends('layout.Layout')

@section('body')

<!-- <%-- Contenido individual --%> -->
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2>Giros</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-body">
            <div class="row">
                <div class="col-md-12">
                    <h2>Registrar</h2>
                </div>
            </div>
            <form>
                {{-- <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtClave">Clave</label>
                            <input type="text" placeholder="Clave" class="form-control" name="txtClave" id="txtClave">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtNombre">Nombre</label>
                            <input type="text" placeholder="Nombre" class="form-control" name="txtNombre" id="txtNombre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtNombre">Descripción</label>
                            <input type="text" placeholder="Nombre" class="form-control" name="txtNombre" id="txtNombre">
                        </div>
                    </div>
                </div> --}}
            </form>
            <div class="row justify-content-between">
                <div class="col-md-12 text-right">
                    <button class="btn btn-sm btn-primary" id="btn_search" type="button" data-toggle="modal" data-target="#exampleModal">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <div class="card">
        <div class="card-body text-body">
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
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th style="width: 20%">Acciones</th>
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
    <br>
</div>
<br />

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <input type="hidden" name="txtId" id="txtId">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtClave">Clave</label>
                                <input type="text" placeholder="Clave" class="form-control" name="txtClave" id="txtClave">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="txtNombre">Nombre</label>
                                <input type="text" placeholder="Nombre" class="form-control" name="txtNombre" id="txtNombre">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtDescripcion">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btnCerrar" data-dismiss="modal" onclick="limpiar(false)">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnGuardar" onclick="guardar()">Guardar</button>
            </div>
        </div>
        </div>
    </div>

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
    var arrayGiros  = [];
    var table       = null;
    var accion      = 'add';

    /* Variables para la paginacion */
    var varPaginacion = {
        "order"         : "desc",
        "order_by"      : "id",
        "items_to_show" : 10,
        "paginate"      : true,
        "page"          : "page=1",

        "clave"         : null,
        "nombre"        : null,
        "descripcion"   : null,
    };

    $(document).ready(function () {
        listar();
    });

    
    /* function buscar(){

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
    }} */

    function limpiar(all= true){
        $("#txtId").val("");
        $("#txtClave").val("");
        $("#txtNombre").val("");
        $("#txtDescripcion").val("");

        if(all){
            varPaginacion = {
                "order"         : "desc",
                "order_by"      : "id",
                "items_to_show" : 10,
                "paginate"      : true,
                "page"          : "page=1",

                "clave"         : null,
                "nombre"        : null,
                "descripcion"   : null,
            };

            listar();
        }
    }

    function abreModal(id =0 ){
        accion = 'add';

        if(id != 0){
            accion = 'update';
            arrayGiros.forEach(element => {
                if(element.id == id){
                    $("#txtId").val(element.id);
                    $("#txtClave").val(element.clave);
                    $("#txtNombre").val(element.nombre);
                    $("#txtDescripcion").val(element.descripcion);
                }
            });
        }

        $("#exampleModal").modal("show");
    }

    function guardar(){
        let obj = {
            id: $("#txtId").val(),
            clave: $("#txtClave").val(),
            nombre: $("#txtNombre").val(),
            descripcion: $("#txtDescripcion").val()
        }

        $("#btnGuardar").prop('disabled', true);
        let tipo = accion == 'add' ? 'post' : 'put';
        $.ajax({
            url: "/giro",
            type: tipo,
            data: obj,
            success: function(response) {
                limpiar();
                $("#btnGuardar").prop('disabled', false);
                $("#btnCerrar").click();

                Swal.fire({
                    icon: 'success',
                    title: 'Operación exitosa',
                    showConfirmButton: false,
                    timer: 1500
                });    
            },
            error: function(data) {
                $("#btnGuardar").prop('disabled', false);
                let objError    = JSON.parse(data.responseText);
                let leyenda     = ``;
                objError        = Object.values(objError.error);
                
                objError.forEach(element => {
                    leyenda+= `* ` + element + `<br>`;
                });
                Swal.fire({
                    title: '<strong>Error</strong>',
                    icon: 'error',
                    html: leyenda,
                });

                /* Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: 'se presento el siguiente error: ' + leyenda
                }); */
            }
        });
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
                        url: "/giro/estatus",
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

    function listar(pag= true){
        $("#btn_search").prop("disabled", true);
        $("#tbodyFormulario").remove();
        $("#paginacion").remove();
        $("#divTabla").append(`<div id="spinner" class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`);

        varPaginacion.items_to_show = $("#selctItems option:selected").text();
        if(pag == false){
            varPaginacion.page = 1;
        }

        request = $.ajax({
            url: "/giro/find",
            type: "get",
            data: varPaginacion
        });

        request.done(function (response, textStatus, jqXHR){
            let data    = response.data;
            arrayGiros  = response.data;
            let html    = '<tbody id="tbodyFormulario">';
            if(data.length > 0)
                for (let i = 0; i < data.length; i++) {
                    let estatus= data[i].activo == true || data[i].activo == 1 ? 'Deshabilitar' : 'Habilitar';
                    console.log(data[i].activo, estatus);
                    html+= `<tr role='row' class'odd>
                                <td> ${ data[i].clave       == null ? "" : data[i].clave  } </td>
                                <td> ${ data[i].nombre      == null ? "" : data[i].nombre  } </td>
                                <td> ${ data[i].descripcion == null ? "" : data[i].descripcion  } </td>
                                <td>
                                    <span>
                                        <button type="button"  onclick="abreModal(${ data[i].id });" title="Editar" class="btn btn-link"><i class="fas fa-edit" style="color: black"></i></button>
                                    </span>

                                    <span>
                                            <button type="button" onclick="cambiaEstatus(${ data[i].id })" title="${estatus}" class="btn btn-link">`;
                                        if(estatus == 'Habilitar')
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


        let order_by = 'id';
        let order   = asc == true ? 'asc' : 'desc';

        switch (column) {
            case 'Clave':
                order_by = 'clave';
                break;
            case 'Nombre':
                order_by = 'nombre';
                break;
            case 'Descripcion':
                order_by = 'descripcion';
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
                
                request = $.ajax({
                    url: '/giro/estatus',
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
