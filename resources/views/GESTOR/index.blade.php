@extends('layout.Layout')
@section('body')

<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div id="formulario">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <h2 class="titulo">Agregar Gestor</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body body">                        
                        <form>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="txtBuscar">CURP/RFC</label>
                                    <input type="text" class="form-control txtBuscar" id="txtBuscar" placeholder="CURP/RFC">
                                    <input type="text" style="display: none;" id='usuario_id' value="{{Auth::user()->USUA_NIDUSUARIO}}">
                                </div>

                                <div class="col-md-5 btnBuscar">
                                    <button class="btn btn-primary btnLetras" onclick="buscar()" type="button" id="btnBuscar">Buscar</button>
                                    <button class="btn btn-danger btnLetras" onclick="regresar()" type="button">Regresar</button>
                                </div>
                            </div>
                        </form>

                        <div>
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
                                                <th>CURP</th>
                                                <th>RFC</th>
                                                <th>Estatus</th>
                                                <th style="width: 10%;">Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                         <!-- Modal -->
                         <button id='abreModal' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="display: none;"></button>
                         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="tituloModal">Gestor</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="frm_dias" class="needs-validation" novalidate>
                                            <input type="text" style="display: none;" id="gestorID">
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="nombre">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" disabled>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="apellidoPaterno">Primer Apellido</label>
                                                    <input type="text" class="form-control" id="apellidoPaterno" placeholder="Apellido Paterno" disabled>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="apellidoMaterno">Segundo Apellido</label>
                                                    <input type="text" class="form-control" id="apellidoMaterno" placeholder="Apellido Materno" disabled>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="RFC">RFC</label>
                                                    <input type="text" class="form-control" id="RFC" placeholder="RFC" disabled>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="CURP">CURP</label>
                                                    <input type="text" class="form-control" id="CURP" placeholder="CURP" disabled>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="correo">Correo electrónico</label>
                                                    <input type="text" class="form-control" id="correo" placeholder="Correo" disabled>
                                                </div>                                          
                                            </div>
                                            <button style="display: none;" id="btnSubmit" type="submit">Submit form</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btnModal" data-dismiss="modal" id="btnCerrarModal">Cancelar</button>
                                        <button type="button" class="btn btn-success btnModal" onclick="vincular();" id="btnGuardarModal">Vincular</button>
                                    </div>
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
@endsection
@section('scripts')

<script>
    /* Variables para la paginacion */   
    var varPaginacion = {
        "sort"           : "desc",
        "sort_by"        : "id",
        "items_to_show"  : 10,
        "paginate"       : "page=1",
        "txtBuscar"      : null
    };
    var accion_buscar   = false;
    var usuarios        = null;

    $(function() {
        listar();

        $("#txtBuscar").keypress(function(e) {
            if(e.which == 13) {
                buscar();
            }
        });
    });

    function buscar(){
        varPaginacion = {"txtBuscar" : $("#txtBuscar").val() };
        accion_buscar = true;
        listarBuscar(false);
    }

    function regresar(){
        console.log("regresar");
        window.history.back();
    }

    function vincular(){
        $("#btnGuardarModal").text("");
        $("#btnGuardarModal").append(`
            <div id="spinnerGuardar" class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div> `);
        $("#btnCerrarModal").prop('disabled', true);
        $("#btnGuardarModal").prop('disabled', true);

        var name = $("#nombre").val()+" "+$("#apellidoPaterno").val()+" "+$("#apellidoMaterno").val();

        let data    = { "usuario_id": $("#usuario_id").val(),"gestor_id": $("#gestorID").val() };
        $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        
        request = $.ajax({
            url : '/gestores_solicitud/vincular',
            type: "post",
            data: data
        });
        
        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){                
            limpiaCampos();
           setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Aprobaste a '+name+' como tu gestor para trámites',
                    showConfirmButton: false,
                    timer: 4000
                });
                listar();
            }, 400);
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
            limpiaCampos();
            listar();
        });
    }

    function limpiaCampos(){        
        accion_buscar   = false;

        $("#CURP").val("");
        $("#RFC").val("");
        $("#nombre").val("");
        $("#gestorID").val("");
        $("#apellidoPaterno").val("");       
        $("#apellidoMaterno").val("");
        $("#correo").val("");
        $("#txtBuscar").val("");

        $("#btnCerrarModal").prop('disabled', false);
        $("#btnGuardarModal").prop('disabled', false);
        $("#btnGuardarModal").text("Guardar");
        $("#btnCerrarModal").text("Cancelar");
        $("#spinnerGuardar").remove();
        $("#btnCerrarModal").click();
    }
    
    function abreModal(id){
        const found = usuarios.find(element => {
            if(element.USUA_NIDUSUARIO == id){
                return element;
            }
        });
        
        $("#CURP").val(found.USUA_CCURP);
        $("#RFC").val(found.USUA_CRFC);
        $("#nombre").val(found.USUA_CNOMBRES);
        $("#gestorID").val(found.USUA_NIDUSUARIO);
        $("#apellidoPaterno").val(found.USUA_CPRIMER_APELLIDO);        
        $("#apellidoMaterno").val(found.USUA_CSEGUNDO_APELLIDO);
        $("#correo").val(found.USUA_CCORREO_ELECTRONICO);
        $('#abreModal').click();
    }

    function eliminar(id){
        Swal.fire({
                title: '¡Advertencia!',
                text: "¿Desea eliminar al Gestor?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed){              
                    $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    request = $.ajax({
                        url: '/gestores_solicitud/delete',
                        type: "post",
                        data: {"id": id}
                    });

                    request.done(function (response, textStatus, jqXHR){
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Acaba de eliminar al gestor',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        accion_buscar = false;
                        listar();
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


        $("#tbodyFormulario").remove();
        $("#paginacion").remove();
        $("#sinRegistros").remove();
        $("#divTabla").append(`<div id="spinner" class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`);

        varPaginacion.items_to_show = $("#selctItems option:selected").text();
        varPaginacion.usuario_id = $("#usuario_id").val();

        if(pag == false){
            varPaginacion.page = 1;
        }

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
        let url =  "/gestores_solicitud/find";
        if(accion_buscar != false){
            url = '/gestores_solicitud/usuarios';
        }
        request = $.ajax({
            url: url,
            type: "get",
            data: varPaginacion
        });
      
        request.done(function (response, textStatus, jqXHR){
            usuarios        = response.data;
            let gestores    = response.data;
            let html        = '<tbody id="tbodyFormulario">';

            if(gestores.length > 0){
                $( "#btnBuscar").prop( "disabled", true );
            }else{
                $( "#btnBuscar").prop( "disabled", false );
            }

            for (let i = 0; i < gestores.length; i++) {
                let estatus = gestores[i].GES_CESTATUS == undefined ? "" : gestores[i].GES_CESTATUS ;
                html+= `<tr role='row' class'odd>
                            <td> ${ gestores[i].USUA_CCURP } </td>
                            <td> ${ gestores[i].USUA_CRFC } </td>
                            <td> ${ estatus } </td>
                            <td>
                                <span>`;
                                    if(accion_buscar == true){
                                        html+= `<button type="button" onclick="abreModal(${ gestores[i].USUA_NIDUSUARIO })" title="Vincular"  class="btn btn-link"><i class="fas fa-plus-circle" style="color: black"></i></button>`;
                                    }
                                    else{
                                        html+= `<button type="button" onclick="eliminar(${ gestores[i].GES_NID })" title="Eliminar"  class="btn btn-link"><i class="far fa-trash-alt" style="color: black"></i></button>`;
                                    }                                    
                        html+= `</span>
                            </td>
                        </tr>`;
            }
            html+= `</tbody>`;

            let anterior = response.current_page == 1 ? "disabled" : "";
            let siguiente= response.current_page == response.last_page ? "disabled" : "";
            
            if(response.total > 0){
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

                                paginacion+=` <li class="page-item ${activo}"><a class="page-link" href="javascript:onclick=cambiaPagina(${ i });">${ i }</a></li>`;
                            }

                paginacion+=`<li class="page-item ${siguiente}">
                                <a class="page-link" href="javascript:onclick=cambiaPagina(${ response.current_page + 1 });">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                    </div>
                </div>   `;

                $("#divTabla").append(paginacion);
            }
           

            $("#tblFormularios").append(html);
            if(response.total == 0){
                $("#divTabla").append(`<div id='sinRegistros' style='font-sizepx;' > <td> No se encontraron resultados </div>`);
            }

            $("#spinner").remove();

            function formato(texto){
               return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
    }

    function listarBuscar(pag= true){
        $("#tbodyFormulario").remove();
        $("#paginacion").remove();
        $("#sinRegistros").remove();
        $("#divTabla").append(`<div id="spinner" class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`);

        varPaginacion.items_to_show = $("#selctItems option:selected").text();
        varPaginacion.usuario_id = $("#usuario_id").val();

        if(pag == false){
            varPaginacion.page = 1;
        }

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
        let url =  "/gestores_solicitud/find";
        if(accion_buscar != false){
            url = '/gestores_solicitud/usuarios';
        }
        request = $.ajax({
            url: url,
            type: "get",
            data: varPaginacion
        });
      
        request.done(function (response, textStatus, jqXHR){
            usuarios        = response.data;
            let gestores    = response.data;
            let html        = '<tbody id="tbodyFormulario">';

            /*if(gestores.length > 0){
                $( "#btnBuscar").prop( "disabled", true );
            }else{*/
                $( "#btnBuscar").prop( "disabled", false );
            //}
            for (let i = 0; i < gestores.length; i++) {
                let estatus = gestores[i].GES_CESTATUS == undefined ? "" : gestores[i].GES_CESTATUS ;
                html+= `<tr role='row' class'odd>
                            <td> ${ gestores[i].USUA_CCURP } </td>
                            <td> ${ gestores[i].USUA_CRFC } </td>
                            <td> ${ estatus } </td>
                            <td>
                                <span>`;
                                    if(accion_buscar == true){
                                        html+= `<button type="button" onclick="abreModal(${ gestores[i].USUA_NIDUSUARIO })" title="Vincular"  class="btn btn-link"><i class="fas fa-plus-circle" style="color: black"></i></button>`;
                                    }
                                    else{
                                        html+= `<button type="button" onclick="eliminar(${ gestores[i].GES_NID })" title="Eliminar"  class="btn btn-link"><i class="far fa-trash-alt" style="color: black"></i></button>`;
                                    }                                    
                        html+= `</span>
                            </td>
                        </tr>`;
            }
            html+= `</tbody>`;

            let anterior = response.current_page == 1 ? "disabled" : "";
            let siguiente= response.current_page == response.last_page ? "disabled" : "";
            
            if(response.total > 0){
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

                                paginacion+=` <li class="page-item ${activo}"><a class="page-link" href="javascript:onclick=cambiaPagina(${ i });">${ i }</a></li>`;
                            }

                paginacion+=`<li class="page-item ${siguiente}">
                                <a class="page-link" href="javascript:onclick=cambiaPagina(${ response.current_page + 1 });">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                    </div>
                </div>   `;

                $("#divTabla").append(paginacion);
            }
           

            $("#tblFormularios").append(html);
            if(response.total == 0){
                $("#divTabla").append(`<div id='sinRegistros' style='font-sizepx;' > <td> No se encontraron resultados </div>`);
            }

            $("#spinner").remove();

            function formato(texto){
               return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
    }

    </script>
@endsection
<style>
    /* CSS Manuel Euan */
    .body {
        min-height: 700px;
    }

    .border {
        border-radius: 5px;
    }
    .txtBuscar{
        height: 42px;
        font-size: 14px !important;
    }

    .btnLetras {
        color: #fff;
        font-weight: 900;
        margin-left: 20px;
        min-width: 180px;
    }
    .btnModal{
        min-width: 108px !important;
        max-height: 43px;
    }

    .btnBuscar {
        margin-top: 1.2%;
        margin-right: 20px;
        margin-left: 20px;
    }

    label {
        font-weight: bold;
    }

    /* Paginacion */
    .dataTables_info{
        text-align: left !important;
    }

    /* CSS Buscador */
    .container-1{
        text-align: center;
    }

    .container-1 input#search{
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
    .container-1 .icon{
        position: absolute;
        top: 20%;
        font-size: 20px;
        margin-left: 17px;
        margin-top: 17px;
        z-index: 1;
        color: #4f5b66;
    }

    .container-1 input#search:hover, .container-1 input#search:focus, .container-1 input#search:active{
        outline:none;
        background: #ffffff;
    }

</style>

