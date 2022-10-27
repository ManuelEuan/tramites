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
    <div id="formulario">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <h2 class="titulo">Formularios</h2>
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
                                <div class=" col-md-5 mb-3">
                                    <label for="txtFecha">Fecha Inicio &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha Fin</label>
                                    <div class="input-group">
                                        <input style="width: 40% !important; margin-right:30px;" type="date" class="form-control" id="txtFechaInicio" placeholder="01/01/2020" aria-describedby="inputGroupPrepend2">
                                        <input style="width: 40% !important;" type="date" class="form-control" id="txtFechaFin" placeholder="01/01/2020" aria-describedby="inputGroupPrepend2">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="txtNombre">Nombre</label>
                                    <input type="text" class="form-control" id="txtNombre" placeholder="Trámite 0001">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="txtEstatus">Estatus</label>
                                    <select id="txtEstatus" class="form-control">
                                        <option value="NA" selected>Seleccionar</option>
                                        <option value="1">Activos</option>
                                        <option value="0">Inactivos</option>
                                    </select>
                                </div>
                                <div class="col-md-12 btnContenedor">
                                    <button class="btn btn-primary bntGeneral btnLetras" type="button" onclick="buscar()">Buscar</button>
                                    <button class="btn btn-primary bntGeneral btnLetras" onclick="abreModal()" type="button" data-toggle="modal" data-target="#exampleModalCenter">Crear nuevo</button>
                                    <button style="display: none;" id='btnModal' type="button" data-toggle="modal" data-target="#exampleModalCenter"></button>
                                    <button class="btn btn-warning bntGeneral btnLetras btnLimpiar" type="button" onclick="limpiaCampos('btnLimpiar')">Limpiar</button>
                                </div>
                            </div>
                        </form>

                        {{-- <h2 class="resultados_De_busqueda">Resultados de la búsqueda</h2>
                        <div class="seguimiento">
                            <div class="input-group mb-3">
                                <label style="margin:10px;" for="selctItems">Mostrar: </label>
                                <div style="width: 70px;">
                                    <select class="custom-select" id="selctItems" onchange="listaFormularios(false)">
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
                                                <th>Fecha</th>
                                                <th>Nombre</th>
                                                <th style="width: 30%">Descripción</th>
                                                <th>Estatus</th>
                                                <th style="width: 20%" data-orderable="false" class="nosort">Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div> --}}

                        <h2 class="resultados_De_busqueda">Resultados de la búsqueda</h2>
                        <div class="seguimiento">
                            <div class="row">
                                <div class="col-12">
                                    <table id="tblFormularios" class="table table-bordered" style="width: 100%">
                                        <thead class="bg-gob">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Nombre</th>
                                                <th style="width: 30%">Descripción</th>
                                                <th>Estatus</th>
                                                <th style="width: 20%" data-orderable="false" class="nosort">Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tituloModal">Agregar Formulario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form_fomulario" class="needs-validation" novalidate>
                                    <input type="text" style="display: none;" id="id">
                                    <div class="form-row">

                                        <div class="col-md-12 mb-3" id="tipoId">
                                            <label for="tipoCuestionario">Tipo de cuestionario</label>
                                            <select name="tipoCuestionario" id="tipoCuestionario" class="form-control" onchange="seleccionaCuestionario()">
                                                <option value='nuevo' selected>Nuevo</option>
                                                <option value='copia'>Duplicar</option>
                                            </select>
                                        </div>

                                        <div id="copiaCuestionario" class="row"></div>

                                        <div class="col-md-12 mb-3">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" placeholder="Nombre" autocomplete="off" required>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="descripcion" class="col-form-label">Descripción:</label>
                                            <textarea class="form-control" id="descripcion" rows="5" maxlength="1000" minlength="2" aria-errormessage="El tamaño del campo debe contener mínimo 2 carácteres y máximo 1000 carácteres."></textarea>
                                            <small class="text-danger" id="error-desc" style="display: none">El tamaño del campo debe contener mínimo 2 carácteres y máximo 1000 carácteres.</small>
                                        </div>
                                    </div>
                                    <button style="display: none;" id="btnSubmit" type="submit">Submit form</button>
                                </form>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btnModal" data-dismiss="modal" id="btnCerrarForm">Cancelar</button>
                                <button type="button" class="btn btn-success btnModal" onclick="guardarFormulario();" id="btnGuardarForm">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="secciones" style="display: none;">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <h2 class="titulo">Secciones <label for="" id="divNombre"></label></h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body body">
                                <div class="seguimiento">
                                    <div class="row">
                                        <div class="col-12" id="contenedorSecciones">
                                            <table id="tblSecciones" class="table table-bordered" style="width: 100%">
                                                <thead class="bg-gob">
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Preguntas</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="btnContenedorRegresar">
                                <button class="btn btn-link btnRegresar" type="button" onclick="regresar('formularios')"> Regresar </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="preguntas" style="display: none;">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <h2 class="titulo">Preguntas de formularios <label id="labelNombre"></label></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body body">
                        <h2 class="subtitulo" id=tituloSeccion></h2>
                        <form id="form_preguntas" class="needs-validation" novalidate>
                            <div id="contenedorPreguntas"></div>
                            <button style="display: none;" id='btnPreguntas' type="submit" data-toggle="modal"></button>
                        </form>
                        <div class="btnContenedor" id="contenedorPeguntas">
                            <button class="btn btn-link btnLink" type="button" onclick="agregaPregunta()"> Agregar Pregunta</button>

                            <button class="btn btn-danger bntGeneral btnLetras btnDerecha" type="button" onclick="regresar('secciones')" id="btnCPreg"> Cancelar </button>
                            <button class="btn btn-primary bntGeneral btnLetras btnDerecha" type="button" onclick="guardarPreguntas()" id="btnGPreg"> Guardar </button>
                        </div>

                        <div id="cargaPreguntas">
                            <div style="text-align: center; margin-top:160px;">
                                <div class="spinner-grow" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    
    <div class="modal" id="asignarRolSeccionModal" tabindex="-1" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignación de Rol - Sección</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-3" id="tipoId" >
                        <div class="row">
                            <div class="col-md-8">
                                <label style="font-size: 1rem; font-weight: bold;"><span id="lblSelect">Roles</span></label>
                                <div id="htmlsecrol">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="asignaSecRoles()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<br />
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.min.js"></script>

<script>
    var visible = "formulario";
    var accion = 'add';
    var tipo = 'nuevo';
    var validateFormulario = false;
    var open_modal = "{{$open}}";
    var catalogos = [];

    var formulario_id = 0;
    var seccion_id = 0;
    var formularios = [];
    var eliminados = [];
    var cuestionarios = [];

    /* Variables para las preguntas */
    var pregunda_id = 1;
    var respuesta_id = 1;
    var especial_id = 1;
    var opcion_numero = 3;
    var opcion_especial = 1;
    var editores = [];
    var validatePreguntas = false;
    var accion_pregunta = "add";

    $(document).ready(function() {
        listaFormularios();
        getCuestionarios();
        getSecciones();
        getCatalogos();
        getRoles();

        $("#descripcion").keyup(function() {
            if ($(this).val() != undefined && $(this).val() != null) {
                if ($(this).val().length < 2 || $(this).val().length > 1000) {
                    $("#error-desc").show();
                    validateFormulario = false;
                } else {
                    $("#error-desc").hide();
                }
            }
        });
    });

    $('#txtFechaInicio').change(function() {
        var date = $(this).val();
        $('#txtFechaFin').attr('min', date);
    });

    function buscar() {
        table.ajax.reload();
    }

    function getSecciones() {
        request = $.ajax({
            url: "/formulario/secciones",
            type: "get"
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            secciones = response;
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
    }

    

    /////////nuevas funciones////////////
    var lstRoles = [];
    var gform_nid = 0;

    function getRoles() {
        request = $.ajax({
            url: "/formulario/roles",
            type: "get"
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            roles = response;
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
    }

    function openSecRol(FORM_NID){
        gform_nid = FORM_NID;
        request = $.ajax({
            url: "/formulario/seccion_roles/"+FORM_NID,
            type: "get"
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            seccion_roles = response;

            var html = '<select id="cmbRoles" class="selectpicker form-control" multiple>';
            roles.forEach(roles => {
                let select = '';
                seccion_roles.forEach(element => {
                    if(element.ROL_NIDROL == roles.ROL_NIDROL){
                        select      =   'selected';
                        /*
                        let option  =   `<div class="group-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-12 text-center">
                                                    <span class="text-dark"> ${ value.Description } </span>
                                                </div>
                                            </div>
                                        </div`;*/

                        lstRoles.push(roles.ROL_NIDROL);
                    }
                });
                html += `<option ${select} value="${ roles.ROL_NIDROL }"> ${ roles.ROL_CNOMBRE } </option>`;
            });
            html += '</select>';
            $("#htmlsecrol").html(html);

            $('#cmbRoles').selectpicker({
                noneSelectedText: 'Roles',
                noneResultsText: 'No se encontraron resultados',
            });

            $('#cmbRoles').on('change', function(e) { 
                console.log("entro");
                selected = $('#cmbRoles').val();
                console.log(selected);
                lstRoles = [];

                //$('#list_roles').html('');
                
                $.each(selected, function(key, value) {
                    lstRoles.push(value);
                    //var text =  $("#cmbRoles option[value='" + value + "']")[0].innerText;
                    //$('#list_roles').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                });
            });

            $('#asignarRolSeccionModal').modal('show');

        });

         // Callback handler that will be called on failure
         request.fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
    }

    function asignaSecRoles(){
        var htmlid = $("#idTramite").val();
        console.log(lstRoles);
        var envio = {
                FORM_NID: gform_nid,
                listROL: lstRoles,
                USUA_NIDUSUARIOREGISTRO: 0,
            };

            console.log(envio);
        /*
        $.ajax({
            data: envio,
            type: 'POST',
            url: "tramite_servicio_cemr/asignar_tramite", 
            success: function(result){
                $("#asignarFuncionarioModal").modal('hide');

                if(envio.USUA_NIDUSUARIO == 0){
                    $("#icon-"+htmlid).removeClass("fa fa-users");
                    $("#icon-"+htmlid).removeClass("fa-solid fa-user-check");
                    $("#icon-"+htmlid).addClass("fa fa-users");
                    $("#icon-"+htmlid).attr("title", "Asignar funcionario");
                }else{
                    $("#icon-"+htmlid).removeClass("fa fa-users");
                    $("#icon-"+htmlid).removeClass("fa-solid fa-user-check");
                    $("#icon-"+htmlid).addClass("fa-solid fa-user-check");
                    $("#icon-"+htmlid).attr("title", "Reasignar funcionario");
                }

                //fa-solid fa-user-check
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
        */
    }

    ///////////////////////////////////7

    function listaFormularios() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tblFormularios').DataTable({
            "language": {
                url: "/assets/template/plugins/DataTables/language/Spanish.json",
                "search": "Filtrar resultados:",
            },
            "ajax": {
                "url": "/formulario/find",
                "type": "get",
                "data": function(d) {
                    return $.extend({}, d, {
                        "fecha_inicio": $("#txtFechaInicio").val(),
                        "fecha_final": $("#txtFechaFin").val(),
                        "nombre": $("#txtNombre").val(),
                        "estatus": $("#txtEstatus option:selected").text(),
                    });
                }
            },
            "columns": [{
                    data: "FORM_DFECHA",
                    render: function(data, type, row) {
                        if (type === 'display') {
                            let date = data == null ? "" : data;
                            return date.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');
                        }
                        return data;
                    }
                },
                {
                    data: 'FORM_CNOMBRE'
                },
                {
                    data: "FORM_CDESCRIPCION"
                },
                {
                    data: "FORM_BACTIVO",
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return data == 0 ? 'Inactivo' : 'Activo';
                        }
                        return data;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let estatus = data.FORM_BACTIVO == false ? 'Activar' : 'Desactivar';
                        html = `<span>
                                        <button type="button" onclick="cambiaVista('secciones', ${ data.FORM_NID },'${data.FORM_CNOMBRE}')" title="Secciones" class="btn btn-link"><i class="fas fa-list" style="color: black"></i></button>
                                    </span>
                                    <span>
                                        <button type="button" onclick="abreModal(${ data.FORM_NID }, '${ data.FORM_CNOMBRE}', '${data.FORM_CDESCRIPCION }')" title="Editar" class="btn btn-link"><i class="fas fa-edit" style="color: black"></i></button>
                                    </span>
                                    <span>
                                        <button type="button" onclick="Habilitar(${ data.FORM_NID },'${ data.FORM_BACTIVO}','${ data.FORM_CNOMBRE}')" title="${estatus}" class="btn btn-link">`;

                        if (data.FORM_BACTIVO == false)
                            html += `<i class="fas fa-toggle-off" style="color: black"></i>`;
                        else
                            html += `<i class="fas fa-toggle-on" style="color: black"></i>`;

                        html += `</button></span>
                                    <span>
                                        <button type="button" onclick="cambiaEstatus(${ data.FORM_NID }, 'eliminar')" title="Eliminar"  class="btn btn-link"><i class="far fa-trash-alt" style="color: black"></i></button>
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
            order: [
                [0, "desc"]
            ],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todos"]
            ],
            dom: 'Blrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'csvHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }
            ]
        });
    }

    function cambiaEstatus($id, estatus = 'estatus') {

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
            if (result.isConfirmed) {
                let url = "/formulario/status";
                if (estatus != 'estatus') {
                    url = "/formulario/delete";
                }

                request = $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        "id": $id
                    }
                });

                request.done(function(response, textStatus, jqXHR) {
                    buscar();

                    Swal.fire({
                        icon: 'success',
                        title: 'Operación exitosa',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });

                request.fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'se presento el siguiente error: ' + errorThrown
                    });
                });
            }
        });
    }

    function Habilitar($id, estatus = 'estatus', valor) {

        if (estatus == 0) {
            //activar el formulario
            estatus = 'estatus'
            Swal.fire({
                title: 'Confirmar!',
                text: "¿Desea habilitar el formulario " + valor + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "/formulario/status";
                    if (estatus != 'estatus') {
                        url = "/formulario/delete";
                    }

                    request = $.ajax({
                        url: url,
                        type: "post",
                        data: {
                            "id": $id
                        }
                    });

                    request.done(function(response, textStatus, jqXHR) {
                        buscar();

                        Swal.fire({
                            icon: 'success',
                            title: 'El formulario se ha habilitado con éxito.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });

                    request.fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'se presento el siguiente error: ' + errorThrown
                        });
                    });
                }
            });
        } else {
            //desactivar el formulario
            estatus = 'estatus'
            Swal.fire({
                title: 'Confirmar!',
                text: "¿Desea deshabilitar el formulario " + valor + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "/formulario/status";
                    if (estatus != 'estatus') {
                        url = "/formulario/delete";
                    }

                    request = $.ajax({
                        url: url,
                        type: "post",
                        data: {
                            "id": $id
                        }
                    });

                    request.done(function(response, textStatus, jqXHR) {
                        buscar();

                        Swal.fire({
                            icon: 'success',
                            title: 'El formulario se ha deshabilitado con éxito.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });

                    request.fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'se presento el siguiente error: ' + errorThrown
                        });
                    });
                }
            });
        }

    }

    function abreModal(id = 0, nombre = '', descripcion = '') {
        let valor = descripcion == 'null' ? '' : descripcion;
        limpiaCampos();
        $("#tituloModal").text("Agregar Formulario");
        $("#form_fomulario").removeClass("was-validated");

        if (id != 0) {
            $("#id").val(id);
            $("#nombre").val(nombre);
            $("#descripcion").val(valor);
            $("#tituloModal").text("Actualizar Formulario");
            $("#btnModal").trigger("click");
            accion = 'update';
            $("#tipoId").hide();
            $("#copiaCuestionario").hide();
            $('#frmCuestionario').removeAttr("required");
        } else {
            $("#tipoId").show();
            $("#copiaCuestionario").show();
            $('#frmCuestionario').prop("required", true);
        }
    }

    if (open_modal == 1) {
        abreModal();
        $("#exampleModalCenter").modal('show');
    }

    function getCuestionarios() {
        request = $.ajax({
            url: "/formulario/find",
            type: "get",
            data: {
                "paginate": true,
                'estatus': 'Activos'
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            cuestionarios = response.data;
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
    }

    function getCatalogos() {
        request = $.ajax({
            url: "/catalogos/find",
            type: "get",
            data: {
                paginate: false,
                activo: true
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            catalogos = response.data;
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
    }

    function seleccionaCuestionario() {
        let sel = $("#tipoCuestionario option:selected").val();

        if (sel == 'copia') {
            tipo = 'copia';
            let html = `
                    <div class="col-md-12 mb-3" id='copiando'>
                        <label for="frmCuestionario">Formulario</label>

                        <select name="frmCuestionario" id="frmCuestionario" class="form-control" required>
                            <option value='' selected>Seleccionar</option>`;
            cuestionarios.forEach(element => {
                html += `<option value= ${element.FORM_NID}> ${element.FORM_CNOMBRE}</option>`;
            });

            html += `</select>
                    </div>`;

            $("#copiaCuestionario").append(html);
        } else {
            tipo = 'nuevo';
            $("#copiando").remove();
        }
    }

    /* Valido que los campos requeridos */
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        Swal.fire({
                            icon: 'error',
                            title: 'Campos Requeridos',
                            text: 'El tamaño campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.'
                        });
                        validateFormulario = false;
                        validatePreguntas = false;
                    } else {
                        event.preventDefault();
                        validateFormulario = true;
                        validatePreguntas = true;

                        $("#btnGuardarForm").text("");
                        $("#btnGuardarForm").append(`
                            <div id="spinnerGuardar" class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div> `);
                        $("#btnCerrarForm").prop('disabled', true);
                        $("#btnGuardarForm").prop('disabled', true);
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    function guardarFormulario() {
        $("#btnSubmit").click();

        if (validateFormulario == false) {
            return;
        }

        var completo = $('#form_fomulario').serialize();
        let copia_id = 0;

        if (tipo == 'copia') {
            copia_id = $("#frmCuestionario option:selected").val();
        }
        let data = {
            "id": $("#id").val(),
            "nombre": $("#nombre").val(),
            "descripcion": $("#descripcion").val(),
            'copia_id': copia_id
        };
        let url = "/formulario/store";

        if (accion == 'update') {
            url = "/formulario/update";
        }

        request = $.ajax({
            url: url,
            type: "post",
            data: data
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            limpiaCampos();
            setTimeout(() => {
                $("#btnCerrarForm").click();
                buscar();

                Swal.fire({
                    icon: 'success',
                    title: 'Operación exitosa',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 400);
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
            limpiaCampos();
        });
    }

    function limpiaCampos(opcion = 'general') {
        accion = 'add';
        tipo = 'nuevo';
        validateFormulario = false;

        /* Campos de modal de alta */
        $("#id").val("0");
        $("#nombre").val("");
        $("#descripcion").val("");
        $("#btnCerrarForm").prop('disabled', false);
        $("#btnGuardarForm").prop('disabled', false);
        $("#btnGuardarForm").text("Guardar");
        $("#spinnerGuardar").remove();

        /* campos de filtros */
        $("#txtFechaInicio").val("");
        $("#txtFechaFin").val("");
        $("#txtNombre").val("");
        $("#txtEstatus").val("NA");

        if (opcion == 'btnLimpiar') {
            buscar();
        }
    }

    function cambiaVista(vista, id, nombre = '') {
        accion_pregunta = 'add';

        if (vista == 'secciones') {
            $("#tbody").remove();
            $('#formulario').fadeToggle(500);
            $('#secciones').fadeToggle(500);
            formulario_id = id;

            let tbody = '<tbody id="tbody">';
            secciones.forEach(seccion => {
                tbody += `<tr role=""row class="odd">
                                    <td>${seccion.FORM_CNOMBRE}</td>
                                    <td>
                                        <span>
                                            <button type="button" onclick="cambiaVista('preguntas',${ seccion.FORM_NID }, '${nombre}')" title="Preguntas"  class="btn btn-link">
                                                <i class="fas fa-eye" style="color: black"></i>
                                            </button>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" onclick="openSecRol(${ seccion.FORM_NID })" title="Asignar Roles" class="btn btn-link">
                                            <i class="fa-solid fa-user-check" style="color: black"></i>
                                        </button>
                                    </td>




                                    
                                </tr>`;
            });

            tbody += '</tbody>';
            $('#divNombre').empty();
            $('#divNombre').append('- ' + nombre)
            $("#tblSecciones").append(tbody);
        } else {
            seccion_id = id;

            let divPreguntas = Array.prototype.slice.call(document.getElementsByClassName("contenedorPregunta"), 0);
            let divHr = Array.prototype.slice.call(document.getElementsByClassName("hr"), 0);
            for (element of divPreguntas) {
                element.remove();
            }
            for (element of divHr) {
                element.remove();
            }

            const seccion = secciones.find(seccion => seccion.FORM_NID == seccion_id);
            $('#secciones').fadeToggle(500);
            $('#preguntas').fadeToggle(500);
            $('#contenedorPeguntas').hide();
            $('#cargaPreguntas').show();
            $('#labelNombre').empty()
            $('#labelNombre').append('- ' + nombre)
            $("#tituloSeccion").text(seccion.FORM_CNOMBRE);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            request = $.ajax({
                url: "/formulario/detalle",
                type: "get",
                data: {
                    "formulario_id": formulario_id,
                    "seccion_id": seccion_id
                }
            });

            request.done(function(response, textStatus, jqXHR) {
                if (response.length == 0) {
                    /**
                     * !parte para poder realizar la vinculacion del campo segun lo requerido en el tipo
                     * TODO: tipoVinculacion_ es el nombre del campo
                     */
                    $("#contenedorPreguntas").append(
                        `<div class="form-row contenedorPregunta" id="div_pregunta_${pregunda_id}">
                                <div class=" col-md-4 mb-3">
                                    <label for="pregunta_${pregunda_id}">Pregunta</label>
                                    <div class="input-group">
                                        <input type="text" minlength="2" maxlength="100" class="form-control" name="pregunta_${pregunda_id}" id="pregunta_${pregunda_id}" placeholder="Pregunta" aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                    <em class="text-danger" id="error_${pregunda_id}"></em>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="tipoRespuesta_${pregunda_id}">Tipo respuesta</label>
                                    <select name="tipoRespuesta_${pregunda_id}" id="tipoRespuesta_${pregunda_id}" class="form-control" onchange="cambiaTipoRespuesta(this);">
                                        <option value= 'abierta' selected>Respuesta abierta</option>
                                        <option value= 'unica'>Selección única</option>
                                        <option value= 'multiple'>Seleccción múltiple</option>
                                        <option value= 'enriquecido'>Texto enriquecido</option>
                                        <option value= 'especial'>Especial</option>
                                        <option value= 'catalogo'>Catalogo</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="resolutivo_${pregunda_id}">¿Es resolutivo?</label>
                                    <select name="resolutivo_${pregunda_id}" id="resolutivo" class="form-control" onchange="cambiaTipoRespuesta(this);">
                                        <option value= '1' selected>SI</option>
                                        <option value= '0'>NO</option>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-3">
                                <span  style="margin-top: 1%;">
                                    <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_pregunta_${pregunda_id}')">
                                        <i class="far fa-trash-alt" style="color: black"></i>
                                    </button>
                                    <br>
                                    <label class="ml-3"><input type="checkbox" name="asignacion_${pregunda_id}" id="asignacion_${pregunda_id}" nameVinculo="tipoVinculacion_${pregunda_id}" onclick="muestraCampoVinculacion(this)"> ¿Tiene asignación?</label>
                                </span>
                                </div>
                                <br>
                                <div class="col-md-4 mb-3">
                                <label for="tipoVinculacion_${pregunda_id}" hidden>Tipo de Vinculación</label>
                                <select name="tipoVinculacion_${pregunda_id}" id="tipoVinculacion_${pregunda_id}" class="form-control" hidden>
                                    <option value= 'USUA_CRFC' selected>RFC</option>
                                    <option value= 'USUA_CCURP'>CURP</option>
                                    <option value= 'USUA_NTIPO_SEXO'>Sexo</option>
                                    <option value= 'USUA_CRAZON_SOCIAL'>Razón Social</option>
                                    <option value= 'USUA_CNOMBRES'>Nombre Ciudadano</option>
                                    <option value= 'USUA_CCALLE'>Calle Persona Moral</option>
                                    <option value= 'USUA_NCP'>Código Postal Persona Moral</option>
                                    <option value= 'USUA_NNUMERO_EXTERIOR'>Número Exterior Persona Moral</option>
                                    <option value= 'USUA_NNUMERO_INTERIOR'>Número Interior Persona Moral</option>
                                    <option value= 'USUA_CCOLONIA'>Colonia Persona Moral</option>
                                    <option value= 'USUA_CMUNICIPIO'>Municipio Persona Moral</option>
                                    <option value= 'USUA_CESTADO'>Estado Persona Moral</option>
                                    <option value= 'USUA_CPAIS'>Pais Persona Moral</option>
                                    <option value= 'USUA_CCORREO_ELECTRONICO'>Correo Electronico</option>
                                    <option value= 'USUA_CCORREO_ALTERNATIVO'>Correo Alternativo</option>
                                    <option value= 'USUA_CCALLE_PARTICULAR'>Calle Particular Persona Física</option>
                                    <option value= 'USUA_NCP_PARTICULAR'>Código Postal Particular Persona Física</option>
                                    <option value= 'USUA_NNUMERO_EXTERIOR_PARTICULAR'>Número Exterior Particular Persona Física</option>
                                    <option value= 'USUA_NNUMERO_INTERIOR_PARTICULAR'>Número Interior Particular Persona Física</option>
                                    <option value= 'USUA_CCOLONIA_PARTICULAR'>Colonia Persona Física</option>
                                    <option value= 'USUA_CMUNICIPIO_PARTICULAR'>Municio Persona Física</option>
                                    <option value= 'USUA_CESTADO_PARTICULAR'>Estado Persona Física</option>
                                    <option value= 'USUA_CPAIS_PARTICULAR'>Pais Persona Física</option>
                                    <option value= 'USUA_NTELEFONO'>Telefono</option>
                                    <option value= 'USUA_DFECHA_NACIMIENTO'>Fecha De Nacimiento</option>
                                    <option value= 'USUA_CTEL_LOCAL'>Número De Teléfono Fijo</option>
                                    <option value= 'USUA_CTEL_CELULAR'>Número De Teléfono Celular</option>
                                </select>
                                </div>
                                <div class="col-md-8 mb-9">
                                    <div class="form-group" id="contenedorRespuestas_${pregunda_id}"> </div>
                                </div>
                                
                            </div> <hr class="hr">`
                    );
                } else {
                    accion_pregunta = 'update'
                    response.forEach(element => {
                        let tipo_respuesta = element.respuestas.length > 0 ? element.respuestas[0].FORM_CTIPORESPUESTA : "abierta";
                        let nom_pregunta = element.FORM_CPREGUNTA;
                        let resol = element.FORM_BRESOLUTIVO;
                        let preguntas = `<div class="form-row contenedorPregunta" id="div_pregunta_update${element.FORM_NID}">
                                <div class=" col-md-4 mb-3">
                                    <label for="update_pregunta_${element.FORM_NID}">Pregunta</label>
                                    <div class="input-group">
                                        <input type="text" minlength="2" maxlength="100" value='${nom_pregunta}' class="form-control" name="update_pregunta_${element.FORM_NID}" id="pregunta_${element.FORM_NID}" placeholder="Pregunta" aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                    <em class="text-danger" id="error_${element.FORM_NID}"></em>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="tipoRespuesta_update_${element.FORM_NID}">Tipo respuesta</label>
                                    <select name="tipoRespuesta_update_${element.FORM_NID}" id="tipoRespuesta_update_${element.FORM_NID}" class="form-control" onchange="cambiaTipoRespuesta(this);">
                                        <option value= 'abierta'     ${tipo_respuesta   == 'abierta' ? 'selected': ''}>Respuesta abierta</option>
                                        <option value= 'unica'       ${tipo_respuesta   == 'unica' ? 'selected': ''}>Selección única</option>
                                        <option value= 'multiple'    ${tipo_respuesta   == 'multiple' ? 'selected': ''}>Seleccción múltiple</option>
                                        <option value= 'enriquecido' ${tipo_respuesta   == 'enriquecido' ? 'selected': ''}>Texto enriquecido</option>
                                        <option value= 'especial'    ${tipo_respuesta   == 'especial' ? 'selected': ''}>Especial</option>
                                        <option value= 'catalogo'    ${tipo_respuesta   == 'catalogo' ? 'selected': ''}>Catalogo</option>
                                    </select>
                                </div>
                                
                                <div class=" col-md-3 mb-3">
                                    <label for="update_resolutivo_${element.FORM_NID}">¿Es resolutivo?</label>
                                    <select name="update_resolutivo_${element.FORM_NID}" id="update_resolutivo_${element.FORM_NID}" class="form-control" onchange="cambiaTipoRespuesta(this);">
                                        <option value= '1'     ${resol   == 1 ? 'selected': ''}>SI</option>
                                        <option value= '0'       ${resol   == 0 ? 'selected': ''}>NO</option>
                                        
                                    </select>
                                    <em class="text-danger" id="error_${element.FORM_NID}"></em>
                                </div>

                                <div class="col-md-2 mb-3">
                                <span  style="margin-top: 1%;">
                                    <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_pregunta_update${element.FORM_NID}', true)">
                                        <i class="far fa-trash-alt" style="color: black"></i>
                                    </button>
                                    <br>
                                    <label class="ml-3"><input type="checkbox" name="update_asignacion_${element.FORM_NID}" id="update_asignacion_${element.FORM_NID}" nameVinculo="update_tipoVinculacion_${element.FORM_NID}" onclick="muestraCampoVinculacion(this)"> ¿Tiene asignación?</label>
                                </span>
                                </div>
                                <br>
                                <div class="col-md-4 mb-3">
                                <label for="tipoVinculacion_${element.FORM_NID}" ${element.FORM_BTIENEASIGNACION == 1 ? "": "hidden"}>Tipo de Vinculación</label>
                                <select name="update_tipoVinculacion_${element.FORM_NID}" id="update_tipoVinculacion_${element.FORM_NID}" class="form-control" ${element.FORM_BTIENEASIGNACION == 1 ? "": "hidden"}>
                                    <option value= 'USUA_CRFC' ${element.FORM_CVALORASIGNACION == "USUA_CRFC" ? "selected": ""}>RFC</option>
                                    <option value= 'USUA_CCURP' ${element.FORM_CVALORASIGNACION == "USUA_CCURP" ? "selected": ""}>CURP</option>
                                    <option value= 'USUA_NTIPO_SEXO' ${element.FORM_CVALORASIGNACION == "USUA_NTIPO_SEXO" ? "selected": ""}>Sexo</option>
                                    <option value= 'USUA_CRAZON_SOCIAL' ${element.FORM_CVALORASIGNACION == "USUA_CRAZON_SOCIAL" ? "selected": ""}>Razón Social</option>
                                    <option value= 'USUA_CNOMBRES' ${element.FORM_CVALORASIGNACION == "USUA_CNOMBRES" ? "selected": ""}>Nombre Ciudadano</option>
                                    <option value= 'USUA_CCALLE' ${element.FORM_CVALORASIGNACION == "USUA_CCALLE" ? "selected": ""}>Calle Persona Moral</option>
                                    <option value= 'USUA_NCP' ${element.FORM_CVALORASIGNACION == "USUA_NCP" ? "selected": ""}>Código Postal Persona Moral</option>
                                    <option value= 'USUA_NNUMERO_EXTERIOR' ${element.FORM_CVALORASIGNACION == "USUA_NNUMERO_EXTERIOR" ? "selected": ""}>Número Exterior Persona Moral</option>
                                    <option value= 'USUA_NNUMERO_INTERIOR' ${element.FORM_CVALORASIGNACION == "USUA_NNUMERO_INTERIOR" ? "selected": ""}>Número Interior Persona Moral</option>
                                    <option value= 'USUA_CCOLONIA' ${element.FORM_CVALORASIGNACION == "USUA_CCOLONIA" ? "selected": ""}>Colonia Persona Moral</option>
                                    <option value= 'USUA_CMUNICIPIO' ${element.FORM_CVALORASIGNACION == "USUA_CMUNICIPIO" ? "selected": ""}>Municipio Persona Moral</option>
                                    <option value= 'USUA_CESTADO' ${element.FORM_CVALORASIGNACION == "USUA_CESTADO" ? "selected": ""}>Estado Persona Moral</option>
                                    <option value= 'USUA_CPAIS' ${element.FORM_CVALORASIGNACION == "USUA_CPAIS" ? "selected": ""}>Pais Persona Moral</option>
                                    <option value= 'USUA_CCORREO_ELECTRONICO' ${element.FORM_CVALORASIGNACION == "USUA_CCORREO_ELECTRONICO" ? "selected": ""}>Correo Electronico</option>
                                    <option value= 'USUA_CCORREO_ALTERNATIVO' ${element.FORM_CVALORASIGNACION == "USUA_CCORREO_ALTERNATIVO" ? "selected": ""}>Correo Alternativo</option>
                                    <option value= 'USUA_CCALLE_PARTICULAR' ${element.FORM_CVALORASIGNACION == "USUA_CCALLE_PARTICULAR" ? "selected": ""}>Calle Particular Persona Física</option>
                                    <option value= 'USUA_NCP_PARTICULAR' ${element.FORM_CVALORASIGNACION == "USUA_NCP_PARTICULAR" ? "selected": ""}>Código Postal Particular Persona Física</option>
                                    <option value= 'USUA_NNUMERO_EXTERIOR_PARTICULAR' ${element.FORM_CVALORASIGNACION == "USUA_NNUMERO_EXTERIOR_PARTICULAR" ? "selected": ""}>Número Exterior Particular Persona Física</option>
                                    <option value= 'USUA_NNUMERO_INTERIOR_PARTICULAR' ${element.FORM_CVALORASIGNACION == "USUA_NNUMERO_INTERIOR_PARTICULAR" ? "selected": ""}>Número Interior Particular Persona Física</option>
                                    <option value= 'USUA_CCOLONIA_PARTICULAR' ${element.FORM_CVALORASIGNACION == "USUA_CCOLONIA_PARTICULAR" ? "selected": ""}>Colonia Persona Física</option>
                                    <option value= 'USUA_CMUNICIPIO_PARTICULAR' ${element.FORM_CVALORASIGNACION == "USUA_CMUNICIPIO_PARTICULAR" ? "selected": ""}>Municio Persona Física</option>
                                    <option value= 'USUA_CESTADO_PARTICULAR' ${element.FORM_CVALORASIGNACION == "USUA_CESTADO_PARTICULAR" ? "selected": ""}>Estado Persona Física</option>
                                    <option value= 'USUA_CPAIS_PARTICULAR' ${element.FORM_CVALORASIGNACION == "USUA_CPAIS_PARTICULAR" ? "selected": ""}>Pais Persona Física</option>
                                    <option value= 'USUA_NTELEFONO' ${element.FORM_CVALORASIGNACION == "USUA_NTELEFONO" ? "selected": ""}>Telefono</option>
                                    <option value= 'USUA_DFECHA_NACIMIENTO' ${element.FORM_CVALORASIGNACION == "USUA_DFECHA_NACIMIENTO" ? "selected": ""}>Fecha De Nacimiento</option>
                                    <option value= 'USUA_CTEL_LOCAL' ${element.FORM_CVALORASIGNACION == "USUA_CTEL_LOCAL" ? "selected": ""}>Número De Teléfono Fijo</option>
                                    <option value= 'USUA_CTEL_CELULAR' ${element.FORM_CVALORASIGNACION == "USUA_CTEL_CELULAR" ? "selected": ""}>Número De Teléfono Celular</option>
                                </select>
                                </div>
                                <div class="col-md-8">
                                
                                    <div class="form-group" id="contenedorRespuestas_update_${element.FORM_NID}">`;
                                    
                        if (tipo_respuesta == 'abierta') {
                            let prim_res = element.respuestas.length > 0 ? element.respuestas[0].FORM_NID : 0;
                            preguntas += ``;
                        } else if (tipo_respuesta == 'unica') {
                            element.respuestas.forEach(res => {
                                preguntas += `<div class="col-md-12" id="div_resp_update${res.FORM_NID}">
                                                    <input type="radio"  name="radio_${element.FORM_NID}_${res.FORM_NID}">
                                                    <input type="text" class="form-control inputRespuesta" name="update_respuesta_${element.FORM_NID}_${res.FORM_NID}" id="respuesta_${element.FORM_NID}_${res.FORM_NID}" value='${res.FORM_CVALOR}' required>
                                                    <span>
                                                        <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_update${res.FORM_NID}', true)">
                                                            <i class="far fa-trash-alt" style="color: black"></i>
                                                        </button>
                                                    </span>
                                                </div>`;
                            });
                            preguntas += ` <div class="" id="agregaMas_${element.FORM_NID}"></div>                    
                                            <div class="btnContenedor">
                                                <button type="button" class="btn btn-success border btnLetras btnAgregaRespuesta" onclick="agregaRespuestas('unica', '${element.FORM_NID}')"> Agregar respuesta</button>
                                            </div>`;
                        } else if (tipo_respuesta == 'multiple') {
                            element.respuestas.forEach(res => {
                                preguntas += `<div class="col-md-12" id="div_resp_update${res.FORM_NID}">
                                                    <input type="checkbox"  name="checkbox_${element.FORM_NID}_${res.FORM_NID}">
                                                    <input type="text" class="form-control inputRespuesta" name="update_respuesta_${element.FORM_NID}_${res.FORM_NID}" id="respuesta_${element.FORM_NID}_${res.FORM_NID}" value='${res.FORM_CVALOR}' required>
                                                    
                                                    <input type="checkbox" name="bloqueo_${element.FORM_NID}_${res.FORM_NID}" ${res.FORM_BBLOQUEAR == null ? '' : 'checked'}>
                                                    <label class="form-check-label" for="bloqueo_${element.FORM_NID}_${res.FORM_NID}">Bloquear</label>

                                                    <span>
                                                        <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_update${res.FORM_NID}', true)">
                                                            <i class="far fa-trash-alt" style="color: black"></i>
                                                        </button>
                                                    </span>
                                                </div>`;
                            });
                            preguntas += ` <div class="" id="agregaMas_${element.FORM_NID}"></div>                    
                                            <div class="btnContenedor">
                                                <button type="button" class="btn btn-success border btnLetras btnAgregaRespuesta" onclick="agregaRespuestas('multiple', '${element.FORM_NID}')"> Agregar respuesta</button>
                                            </div>`;
                        } else if (tipo_respuesta == 'enriquecido') {
                            element.respuestas.forEach(res => {
                                preguntas += `<textarea class="form-control inputRespuesta2" name="update_respuesta_${element.FORM_NID}_${element.respuestas[0].FORM_NID}"  id="update_respuesta_${element.FORM_NID}_${element.respuestas[0].FORM_NID}" rows="5"></textarea>`;
                                setTimeout(() => {
                                    let ck = CKEDITOR.replace(`update_respuesta_${element.FORM_NID}_${element.respuestas[0].FORM_NID}`);
                                    let array = {
                                        "id": `respuesta_${element.FORM_NID}_${res.FORM_NID}`,
                                        "value": ck
                                    };
                                    editores.push(array);
                                    array.value.setData(res.FORM_CVALOR);
                                }, 300);
                            });
                        } else if (tipo_respuesta == 'especial') {
                            element.respuestas.forEach(res => {
                                preguntas += `<div class="col-md-12" id="div_resp_update${res.FORM_NID}">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="respuesta_${element.FORM_NID}_${res.FORM_NID}">Encabezado</label>
                                                                <input type="text" minlength="2" maxlength="100" class="form-control"  name="update_respuesta_${element.FORM_NID}_${res.FORM_NID}" id="respuesta_${element.FORM_NID}_${res.FORM_NID}" value='${res.FORM_CVALOR}' required>
                                                                <em class="text-danger" id="error_${element.FORM_NID}_${res.FORM_NID}"></em>
                                                            </div>
                                                        </div>`;


                                if (res.especial.length > 0) {
                                    let tipo_especial = res.especial[0].FORM_CTIPORESPUESTA;
                                    preguntas += `<div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="encabezado_${res.FORM_NID}"></label>
                                                                    <select class="form-control mt-3" name="update_select_${element.FORM_NID}_${res.FORM_NID}" id="select_${element.FORM_NID}_${res.FORM_NID}" onchange="cambiaEspecial(this,'update');">
                                                                        <option value="simple"      ${tipo_especial == 'simple' ? 'selected': ''} >Texto simple</option>
                                                                        <option value="numerico"    ${tipo_especial == 'numerico' ? 'selected': ''}>Númerico</option>
                                                                        <option value="opciones"    ${tipo_especial == 'opciones' ? 'selected': ''}>Seleccion</option>
                                                                    </select>
                                                                </div>
                                                            </div>`;

                                    if (tipo_especial == 'opciones') {
                                        preguntas += `<div class="col-md-3" id="contenedorRespuestaEspecial_update_${element.FORM_NID}_${res.FORM_NID}">`;
                                    } else {
                                        preguntas += `<div class="col-md-0" id="contenedorRespuestaEspecial_update_${element.FORM_NID}_${res.FORM_NID}">`;
                                    }

                                    if (tipo_especial == 'opciones') {
                                        res.especial.forEach(esp => {
                                            preguntas += `<div class="row" id="div_especial_update${esp.FORM_NID}" style="margin-top: 2.2%;">
                                                                        <div class="col-md-7">
                                                                            <input type="text" class="form-control" name="update_opcionEspecial_${element.FORM_NID}_${res.FORM_NID}_${esp.FORM_NID}" id="respuesta_${esp.FORM_NID}" value=" ${esp.FORM_CVALOR}" required>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <span style="margin-top:1%;">
                                                                                <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_especial_update${esp.FORM_NID}', true)">
                                                                                    <i class="far fa-trash-alt" style="color: black"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                    </div>`;
                                        });

                                        preguntas += `<div id="agregaEspecial_${element.FORM_NID}_${res.FORM_NID}"></div>
                                                                <button type="button" class="btn btn-success btn-circle" onclick="agregaMasEspecial(${element.FORM_NID},${res.FORM_NID})">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>`;
                                    } else if (tipo_especial == 'numerico') {
                                        /* preguntas += ` <button type="button" class="btn btn-link" disabled  style="margin-left:20%;">
                                            <i class="fas fa-plus-square iconoEspecial"></i>
                                        </button>

                                        <button type="button" class="btn btn-link" disabled style="margin-left:30px;">
                                            <i class="fas fa-minus-square iconoEspecial"></i>
                                        </button>`; */
                                    } else if (tipo_especial == 'simple') {
                                        /*  preguntas += `<label for="encabezado_${element.FORM_NID}_${res.FORM_NID}"></label>
                                         <input type="text" class="form-control" id="encabezado_${element.FORM_NID}_${res.FORM_NID}" value="Texto simple" disabled >`; */
                                    }

                                    preguntas += `</div><span style="margin-top:1%;">
                                                                    <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_update${res.FORM_NID}', true)">
                                                                        <i class="far fa-trash-alt" style="color: black"></i>
                                                                    </button>
                                                                </span>
                                                            </div>`;
                                }
                                preguntas += `</div>`;
                            });
                            preguntas += ` <div class="" id="agregaMas_${element.FORM_NID}"></div>                    
                                            <div class="btnContenedor">
                                                <button type="button" class="btn btn-success border btnLetras btnAgregaRespuesta" onclick="agregaRespuestas('especial', '${element.FORM_NID}')"> Agregar respuesta</button>
                                            </div>`;
                        } else if (tipo_respuesta == 'catalogo') {
                            element.respuestas.forEach(res => {
                                let id = `update_respuesta_${res.FORM_NPREGUNTAID}_${res.FORM_NID}`;
                                let select = '';
                                preguntas += `<div class="col-md-4">
                                                                    <label> Catálogo</label>
                                                                    <select name="${id}" id="${id}" class="form-control" required>
                                                                        <option value="0">Seleccionar</option>`;
                                catalogos.forEach(element => {
                                    select = element.tabla == res.FORM_CVALOR ? 'selected' : '';
                                    preguntas += `<option value="${element.tabla}" ${select}>${element.nombre}</option>`;
                                });
                                preguntas += `</select>
                                                                </div>`;
                            });
                        }
                        /**
                         * !aqui finaliza el div
                        */
                        preguntas += `</div>
                                </div>
                            </div> <hr class="hr">`

                        $("#contenedorPreguntas").append(preguntas);
                        if(element.FORM_BTIENEASIGNACION == 1){
                            $(`#update_asignacion_${element.FORM_NID}`).attr("checked",true);
                        }
                    });
                }
                $('#cargaPreguntas').hide();
                $('#contenedorPeguntas').show()
            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });

        }
        $("#form_preguntas").removeClass("was-validated");
    }

    function agregaPregunta() {
        pregunda_id++;
        opcion_especial = 1;
        $("#contenedorPreguntas").append(
            `<div class="form-row contenedorPregunta" id="div_pregunta_${pregunda_id}">
                    <div class=" col-md-4 mb-3">
                        <label for="pregunta_${pregunda_id}">Pregunta</label>
                        <div class="input-group">
                            <input type="text" minlength="2" minlength="100" class="form-control" name="pregunta_${pregunda_id}" id="pregunta_${pregunda_id}" placeholder="Pregunta" aria-describedby="inputGroupPrepend2" required>
                        </div>
                        <em class="text-danger" id="error_${pregunda_id}"></em>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="tipoRespuesta_${pregunda_id}">Tipo respuesta</label>
                        <select name="tipoRespuesta_${pregunda_id}" id="tipoRespuesta_${pregunda_id}" class="form-control" onchange="cambiaTipoRespuesta(this);">
                            <option value= 'abierta' selected>Respuesta abierta</option>
                            <option value= 'unica'>Selección única</option>
                            <option value= 'multiple'>Seleccción múltiple</option>
                            <option value= 'enriquecido'>Texto enriquecido</option>
                            <option value= 'especial'>Especial</option>
                            <option value= 'catalogo'>Catalogo</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                                    <label for="resolutivo_${pregunda_id}">¿Es resolutivo?</label>
                                    <select name="resolutivo_${pregunda_id}" id="resolutivo" class="form-control" onchange="cambiaTipoRespuesta(this);">
                                        <option value= '1' selected>SI</option>
                                        <option value= '0'>NO</option>
                                    </select>
                                </div>
                        <div class="col-md-2 mb-3">
                        <span  style="margin-top: 1%;">
                            <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_pregunta_${pregunda_id}')">
                                <i class="far fa-trash-alt" style="color: black"></i>
                            </button>
                            <br>
                            <label class="ml-3"><input type="checkbox" name="asignacion_${pregunda_id}" id="asignacion_${pregunda_id}" nameVinculo="tipoVinculacion_${pregunda_id}" onclick="muestraCampoVinculacion(this)"> ¿Tiene asignación?</label>
                        </span>
                        </div>
                        <br>
                        <div class="col-md-4 mb-3">
                            <label for="tipoVinculacion_${pregunda_id}" hidden>Tipo de Vinculación</label>
                            <select name="tipoVinculacion_${pregunda_id}" id="tipoVinculacion_${pregunda_id}" class="form-control" hidden>
                                <option value= 'USUA_CRFC' selected>RFC</option>
                                <option value= 'USUA_CCURP'>CURP</option>
                                <option value= 'USUA_NTIPO_SEXO'>Sexo</option>
                                <option value= 'USUA_CRAZON_SOCIAL'>Razón Social</option>
                                <option value= 'USUA_CNOMBRES'>Nombre Ciudadano</option>
                                <option value= 'USUA_CCALLE'>Calle Persona Moral</option>
                                <option value= 'USUA_NCP'>Código Postal Persona Moral</option>
                                <option value= 'USUA_NNUMERO_EXTERIOR'>Número Exterior Persona Moral</option>
                                <option value= 'USUA_NNUMERO_INTERIOR'>Número Interior Persona Moral</option>
                                <option value= 'USUA_CCOLONIA'>Colonia Persona Moral</option>
                                <option value= 'USUA_CMUNICIPIO'>Municipio Persona Moral</option>
                                <option value= 'USUA_CESTADO'>Estado Persona Moral</option>
                                <option value= 'USUA_CPAIS'>Pais Persona Moral</option>
                                <option value= 'USUA_CCORREO_ELECTRONICO'>Correo Electronico</option>
                                <option value= 'USUA_CCORREO_ALTERNATIVO'>Correo Alternativo</option>
                                <option value= 'USUA_CCALLE_PARTICULAR'>Calle Particular Persona Física</option>
                                <option value= 'USUA_NCP_PARTICULAR'>Código Postal Particular Persona Física</option>
                                <option value= 'USUA_NNUMERO_EXTERIOR_PARTICULAR'>Número Exterior Particular Persona Física</option>
                                <option value= 'USUA_NNUMERO_INTERIOR_PARTICULAR'>Número Interior Particular Persona Física</option>
                                <option value= 'USUA_CCOLONIA_PARTICULAR'>Colonia Persona Física</option>
                                <option value= 'USUA_CMUNICIPIO_PARTICULAR'>Municio Persona Física</option>
                                <option value= 'USUA_CESTADO_PARTICULAR'>Estado Persona Física</option>
                                <option value= 'USUA_CPAIS_PARTICULAR'>Pais Persona Física</option>
                                <option value= 'USUA_NTELEFONO'>Telefono</option>
                                <option value= 'USUA_DFECHA_NACIMIENTO'>Fecha De Nacimiento</option>
                                <option value= 'USUA_CTEL_LOCAL'>Número De Teléfono Fijo</option>
                                <option value= 'USUA_CTEL_CELULAR'>Número De Teléfono Celular</option>
                            </select>
                        </div>
                    <div class="col-md-8">
                        <div class="form-group" id="contenedorRespuestas_${pregunda_id}">
                        </div>
                    </div>
                </div><hr class="hr">`
        );
        opcion_numero = 3;
    }
    function muestraCampoVinculacion(data){
        let cbNombre = $(data).attr("nameVinculo");
        // alert($("#"+cbNombre).is(":visible"));
        if($("#"+cbNombre).attr("hidden")){
            $("#"+cbNombre).attr("hidden", false);
            $("#"+cbNombre).closest("div").find("label").attr("hidden", false);
        }else{
            $("#"+cbNombre).attr("hidden", true);
            $("#"+cbNombre).closest("div").find("label").attr("hidden", true);
        }
    }
    function cambiaTipoRespuesta(data) {
        let pregunta = data.id.replace("tipoRespuesta_", "");

        switch (data.value) {
            case "abierta":
                $("#contenedorRespuestas_" + pregunta).replaceWith(`
                        <div class="form-group" id="contenedorRespuestas_${pregunta}">
                        </div>
                    `);
                break;
            case "unica":
                $("#contenedorRespuestas_" + pregunta).replaceWith(`
                        <div id="contenedorRespuestas_${pregunta}">
                            <div class="row">
                                <div class="col-md-12" id="div_resp_${respuesta_id}">
                                    <input type="radio"  name="radio_${pregunta}_${respuesta_id}">
                                    <input type="text" class="form-control inputRespuesta" name="respuesta_${pregunta}_${respuesta_id}" id="respuesta_${pregunta}_${respuesta_id}" value='Opcion 1' required>
                                    <span>
                                        <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_${respuesta_id}')">
                                            <i class="far fa-trash-alt" style="color: black"></i>
                                        </button>
                                    </span>
                                </div>
                                <div class="col-md-12" id="div_resp_${respuesta_id = respuesta_id + 1}">
                                    <input type="radio" name="radio_${pregunta}_${respuesta_id}">
                                    <input type="text" class="form-control inputRespuesta" name="respuesta_${pregunta}_${respuesta_id}" id="respuesta_${pregunta}_${respuesta_id}" value='Opcion 2' required>
                                    <span>
                                        <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_${respuesta_id}')">
                                            <i class="far fa-trash-alt" style="color: black"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="row" id="agregaMas_${pregunta}"></div>
                        
                            <div class="btnContenedor">
                                <button type="button" class="btn btn-success border btnLetras btnAgregaRespuesta" onclick="agregaRespuestas('${data.value}', '${pregunta}')"> Agregar respuesta</button>
                            </div>
                        </div>
                    `);
                break;

            case "multiple":
                $("#contenedorRespuestas_" + pregunta).replaceWith(`
                        <div id="contenedorRespuestas_${pregunta}">
                            <div class="row">
                                <div class="col-md-12" id="div_resp_${respuesta_id}">
                                    <input type="checkbox"  name="checkbox_${pregunta}_${respuesta_id}">
                                    <input type="text" class="form-control inputRespuesta" name="respuesta_${pregunta}_${respuesta_id}" id="respuesta_${pregunta}_${respuesta_id}" value='Opcion 1' required>

                                    <input type="checkbox" name="bloqueo_${pregunta}_${respuesta_id}">
                                    <label class="form-check-label" for="bloqueo_${pregunta}_${respuesta_id}">Bloquear</label>
                                    <em class="text-danger" id="error_${pregunta}_${respuesta_id}"></em>
                                    <span>
                                        <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_${respuesta_id}')">
                                            <i class="far fa-trash-alt" style="color: black"></i>
                                        </button>
                                    </span>
                                </div>
                                <div class="col-md-12" id="div_resp_${respuesta_id = respuesta_id + 1}">
                                    <input type="checkbox" name="radio_${pregunta}_${respuesta_id}">
                                    <input type="text" class="form-control inputRespuesta" name="respuesta_${pregunta}_${respuesta_id}" id="respuesta_${pregunta}_${respuesta_id}" value='Opcion 2' required>
                                    
                                    <input type="checkbox" name="bloqueo_${pregunta}_${respuesta_id }">
                                    <label class="form-check-label" for="bloqueo_${pregunta}_${respuesta_id }">Bloquear</label>
                                    <em class="text-danger" id="error_${pregunta}_${respuesta_id}"></em>
                                    <span>
                                        <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_${respuesta_id}')">
                                            <i class="far fa-trash-alt" style="color: black"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="row" id="agregaMas_${pregunta}"></div>
                        
                            <div class="btnContenedor">
                                <button type="button" class="btn btn-success border btnLetras btnAgregaRespuesta" onclick="agregaRespuestas('${data.value}', '${pregunta}')"> Agregar respuesta</button>
                            </div>
                        </div>                    
                    `);
                break;

            case "enriquecido":
                $("#contenedorRespuestas_" + pregunta).replaceWith(`
                        <div class="form-group" id="contenedorRespuestas_${pregunta}" style="width: 70%;">
                            <textarea name="respuesta_${pregunta}_${respuesta_id}"  id="editor_${pregunta}_${respuesta_id}" rows="5"></textarea>
                        </div>
                    `);

                let ck = CKEDITOR.replace(`respuesta_${pregunta}_${respuesta_id}`);
                let array = {
                    "id": `respuesta_${pregunta}_${respuesta_id}`,
                    "value": ck
                };
                editores.push(array);
                break;

            case "especial":
                $("#contenedorRespuestas_" + pregunta).replaceWith(`
                        <div id="contenedorRespuestas_${pregunta}">
                            <div class="row"> 
                                <div class="col-md-12" id="div_resp_${respuesta_id}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="respuesta_${pregunta}_${respuesta_id}">Encabezado</label>
                                                <input type="text" minlength="2" maxlength="100" class="form-control"  name="respuesta_${pregunta}_${respuesta_id}" id="respuesta_${pregunta}_${respuesta_id}">
                                                <em class="text-danger" id="error_${pregunta}_${respuesta_id}"></em>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-3">
                                                <label for="encabezado_${respuesta_id}"></label>
                                                <select class="form-control" name="select_${pregunta}_${respuesta_id}" id="select_${pregunta}_${respuesta_id}" onchange="cambiaEspecial(this);">
                                                    <option value="simple" selected>Texto simple</option>
                                                    <option value="numerico">Númerico</option>
                                                    <option value="opciones">Seleccion</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="" id="contenedorRespuestaEspecial_${pregunta}_${respuesta_id}">
                                           
                                        </div>

                                        <span style="margin-top:1%;">
                                            <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_${respuesta_id}')">
                                                <i class="far fa-trash-alt" style="color: black"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="agregaMas_${pregunta}"></div>
                            <div class="btnContenedor">
                                <button type="button" class="btn btn-success border btnLetras btnAgregaRespuesta" onclick="agregaRespuestas('${data.value}', '${pregunta}')"> Agregar respuesta</button>
                            </div>
                        </div>
                    `);
                break;
            case "catalogo":
                let id = `respuesta_${pregunta}_${respuesta_id}`;
                let html = ` <div class="form-group row" id="contenedorRespuestas_${id}" style="width: 70%; margin-left: -1%;">
                                    <div class="col-md-6">
                                        <label> Catálogo</label>
                                        <select name="${id}" id="${id}" class="form-control" required>
                                            <option value="0">Seleccionar</option>`;
                catalogos.forEach(element => {
                    html += `<option value="${element.tabla}" >${element.nombre}</option>`;
                });
                html += `</select>
                                    </div>
                                </div>`;
                $("#contenedorRespuestas_" + pregunta).replaceWith(html);
                break;
            default:
                break;
        }
    }

    function agregaRespuestas(opcion, pregunta) {
        respuesta_id++;
        especial_id++;
        switch (opcion) {
            case "unica":
                $("#agregaMas_" + pregunta).append(`
                        <div class="col-md-12" id="div_resp_${respuesta_id}">
                            <input type="radio" name="radio_${pregunta}_${respuesta_id}">
                            <input type="text" class="form-control inputRespuesta" name="respuesta_${pregunta}_${respuesta_id}" id="respuesta_${pregunta}_${respuesta_id}" value='Opcion ${opcion_numero}'>
                            <span>
                                <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_${respuesta_id}')">
                                    <i class="far fa-trash-alt" style="color: black"></i>
                                </button>
                            </span>
                        </div>
                    `);

                opcion_numero++;
                break;

            case "multiple":
                $("#agregaMas_" + pregunta).append(`
                        <div class="col-md-12" id="div_resp_${respuesta_id}">
                            <input type="checkbox" name="checkbox_${pregunta}"">
                            <input type="text" name="respuesta_${pregunta}_${respuesta_id}" class="form-control inputRespuesta" id="usr" value='Opcion ${opcion_numero}'>

                            <input type="checkbox" name="bloqueo_${pregunta}_${respuesta_id}">
                            <label class="form-check-label" for="bloqueo_${pregunta}_${respuesta_id}">Bloquear</label>
                            <span>
                                <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_${respuesta_id}')">
                                    <i class="far fa-trash-alt" style="color: black"></i>
                                </button>
                            </span>
                        </div>
                    `);

                opcion_numero++;
                break;

            case "especial":
                $("#agregaMas_" + pregunta).append(`
                        <div class="col-md-12" id="div_resp_${respuesta_id}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="encabezado_${respuesta_id}">Encabezado</label>
                                        <input type="text" minlength="2" maxlength="100" name="respuesta_${pregunta}_${respuesta_id}"" class="form-control" id="encabezado_${respuesta_id}">
                                        <em class="text-danger" id="error_${pregunta}_${respuesta_id}"></em>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="encabezado_${respuesta_id}"></label>
                                        <select name="select_${pregunta}_${respuesta_id}" class="form-control mt-3" id="select_${pregunta}_${respuesta_id}" onchange="cambiaEspecial(this);">
                                            <option value="simple" selected>Texto simple</option>
                                            <option value="numerico">Númerico</option>
                                            <option value="opciones">Seleccion</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="" id="contenedorRespuestaEspecial_${pregunta}_${respuesta_id}"></div>

                                <span style="margin-top:1%;">
                                    <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_resp_${respuesta_id}')">
                                        <i class="far fa-trash-alt" style="color: black"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    `);

            default:
                break;
        }
    }

    function cambiaEspecial(data, accion = 'add') {
        let opcion = data.id.replace("tipoEspecial_", "");
        opcion = opcion.replace("select_", "");
        let pregunta = pregunda_id;
        let respuesta = respuesta_id;
        let especial = especial_id;

        if (accion != 'add') {
            opcion = 'update_' + opcion;
        }


        switch (data.value) {
            case "simple":
                $("#contenedorRespuestaEspecial_" + opcion).replaceWith(`
                        <div class="" id="contenedorRespuestaEspecial_${opcion}"></div>
                    `);
                break;
            case "numerico":
                $("#contenedorRespuestaEspecial_" + opcion).replaceWith(`
                        <div class="" id="contenedorRespuestaEspecial_${opcion}"></div>
                    `);
                break;
            case "opciones":
                opcion_especial = 1;

                $("#contenedorRespuestaEspecial_" + opcion).replaceWith(`  
                        <div class="col-md-4" id="contenedorRespuestaEspecial_${opcion}">
                            <div class="row" id="div_especial_${especial}" style="margin-top: 2.2%;">
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="opcionEspecial_${pregunta}_${respuesta}_${especial}" id="respuesta_${opcion}_${especial}" value="Opcion ${especial}" required>
                                </div>
                                <div class="col-md-3">
                                    <span style="margin-top:1%;">
                                        <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_especial_${especial}')">
                                            <i class="far fa-trash-alt" style="color: black"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div id="agregaEspecial_${pregunta}_${respuesta}"></div>
                            <button type="button" class="btn btn-success btn-circle" onclick="agregaMasEspecial(${pregunta},${respuesta})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    `);
                break;
            default:
                break;
        }
    }

    function eliminaRespuesta(data, eliminar = false) {
        if (eliminar != false) {
            let p = data.includes('div_pregunta');
            let r = data.includes('div_resp');
            let tipo_eliminar = 'especial';
            let array = 0;

            if (p) {
                tipo_eliminar = 'pregunta';
                array = data.split('pregunta_update');
            } else if (r) {
                tipo_eliminar = 'respuesta';
                array = data.split('div_resp_update');
            } else {
                array = data.split('div_especial_update');
            }

            let final = {
                "tipo": tipo_eliminar,
                'id': array[1]
            };
            eliminados.push(final);
            console.log(eliminados);
        }

        $("#" + data).remove();
    }

    function agregaMasEspecial(pre, resp) {
        opcion_especial++;
        let pregunta = pregunda_id;
        let respuesta = respuesta_id;
        let especial = especial_id;


        let q = 'agregaEspecial_' + pre + "_" + resp;
        $("#agregaEspecial_" + pre + "_" + resp).append(`
                <div class="row" id="div_especial_${especial}" style="margin-top: 2.2%;">
                                
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="opcionEspecial_${pregunta}_${respuesta}_${especial}" id="respuesta_${pregunta}_${respuesta}_${especial}" value="Opcion ${opcion_especial}" required>
                    </div>
                    <div class="col-md-3">
                        <span style="margin-top:1%;">
                            <button type="button" title="Eliminar" class="btn btn-link" onclick="eliminaRespuesta('div_especial_${especial}')">
                                <i class="far fa-trash-alt" style="color: black"></i>
                            </button>
                        </span>
                    </div>
                </div>
            `);

        especial_id++;
    }

    function guardarPreguntas() {
        $("#btnPreguntas").click();

        if (validatePreguntas == false) {
            return;
        }

        $("#btnGPreg").text("");
        $("#btnGPreg").append(`
                <div id="spinnerGuardar" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div> `);
        $("#btnCPreg").prop('disabled', true);
        $("#btnGPreg").prop('disabled', true);

        setTimeout(() => {
            let completo = jQuery('#form_preguntas').serializeArray();
            let entra = false;
            for (let i = 0; i < completo.length; i++) {
                completo[i].id = 0;
                let name = completo[i].name;
                if(name.includes("update_tipoVinculacion_")){
                    array = name.split("update_tipoVinculacion_");
                    completo[i].id = array[1];
                    completo[i].name = "tipoVinculacion_" + array[1];
                }
                if(name.includes("update_asignacion_")){
                    array = name.split("update_asignacion_");
                    completo[i].id = array[1];
                    completo[i].name = "asignacion_" + array[1];
                }
                if (name.includes("update_pregunta")) {
                    array = name.split("update_pregunta_");
                    completo[i].id = array[1];
                    completo[i].name = "pregunta_" + array[1];
                }
                if (name.includes("update_resolutivo_")) {
                    array = name.split("update_resolutivo_");
                    completo[i].id = array[1];
                    completo[i].name = "resolutivo_" + array[1];
                } else if (name.includes("update_respuesta")) {
                    array = name.split("_");
                    completo[i].name = "respuesta_" + array[3] + "_"+array[2];
                } else if (name.includes("update_opcionEspecial_")) {
                    array = name.split("_");
                    completo[i].id = array[4];
                    completo[i].name = "opcionEspecial_" + array[4];
                } else if (name.includes("update_select_")) {
                    array = name.split("_");
                    completo[i].id = array[3];
                    console.log(completo[i].name);
                }

                if (completo[i].value == 'enriquecido') {
                    entra = true;
                }

                if (entra) {
                    editores.forEach(editor => {
                        if (editor.id == completo[i].name) {
                            completo[i].value = editor.value.getData();
                            entra = false;
                        }
                    });
                }
            }
            $reslu = $('#resolutivo').val();
            let preguntas = JSON.stringify(completo);
            console.log(preguntas)
            let data = {
                "formulario_id": formulario_id,
                "seccion_id": seccion_id,
                "preguntas": preguntas,
                "eliminados": JSON.stringify(eliminados),
                "resolutivo": $reslu
            };
            request = $.ajax({
                type: 'POST',
                url: '/formulario/preguntas',
                data: data,
                async: false,
            });
            // Callback handler that will be called on success
            request.done(function(response, textStatus, jqXHR) {
                console.log(response)
                Swal.fire({
                    icon: 'success',
                    title: 'Operación exitosa',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    $("#btnGPreg").text("Guardar");
                    $("#spinnerGuardar").remove();
                    $("#btnGPreg").prop('disabled', false);
                    $("#btnCPreg").prop('disabled', false);
                    $('#preguntas').fadeToggle(500);
                    $('#secciones').fadeToggle(500);
                    eliminados = [];
                }, 400);
            });

            // Callback handler that will be called on failure
            request.fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });
        }, 300);
    }

    function regresar(vista) {
        $('#secciones').fadeToggle(500);

        if (vista == 'formularios') {
            $('#formulario').fadeToggle(500);
        } else if ('secciones') {
            $('#preguntas').fadeToggle(500);
        }
    }
</script>
@endsection

<style>
    /* CSS Manuel Euan */
    .body {
        min-height: 400px;
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

    .btnAgregaRespuesta {
        margin: 0 30px;
    }

    .btnContenedor {
        margin-top: 1.2%;
        margin-right: 20px;
        margin-left: 20px;
    }

    label {
        font-weight: bold;
    }

    .resultados_De_busqueda {
        font-weight: bold;
        margin-top: 40px;
    }

    .bntGeneral {
        min-width: 120px;
        margin-right: 30px;
    }

    .btnLimpiar {
        float: right;
        background-color: #01b3e8 !important;
        border-color: #01b3e8 !important;
        color: #ffffff;
    }

    .btnLimpiar:hover {
        background-color: #33B5FF !important;
        border-color: #33B5FF !important;
        color: #ffffff;
        margin-left: 20px;
    }

    .buttons-html5 {
        background-color: #01b3e8 !important;
    }

    .btnModal {
        min-width: 115px;
    }

    .subtitulo {
        font-size: 22px;
    }

    .contenedorPregunta {
        margin-top: 35px;
    }

    .dataTables_info {
        text-align: left !important;
    }

    .btn-circle {
        margin-top: 10px !important;
        width: 30px !important;
        height: 30px !important;
        padding: 6px 0px !important;
        border-radius: 15px !important;
        font-size: 12px !important;
    }

    /* CSS para las respuestas*/
    .inputRespuesta {
        display: inline !important;
        width: 71% !important;
        margin-left: 30px;
        margin-top: 10px !important;
    }

    .inputRespuesta2 {
        display: inline !important;
        width: 71% !important;
        margin-top: 10px !important;
    }

    .iconoEspecial {
        font-size: 30px;
        margin-top: 10px;
    }

    .btnLink {
        color: #218838;
        text-decoration: none;
        font-weight: 900;
        margin-bottom: 30px;
    }

    .btnLink:hover {
        color: #218838;
        text-decoration: none;
    }


    /* Css de secciones */
    .btnContenedorRegresar {
        margin-top: 1.2%;
        margin-right: 20px;
        margin-left: 20px;
    }

    .btnRegresar {
        float: right;
        color: #218838;
        text-decoration: none;
        font-weight: 900;
        margin-bottom: 30px;
    }

    .btnRegresar:hover {
        color: #218838;
        text-decoration: none;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
    }

    .btnDerecha {
        float: right;
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
</style>