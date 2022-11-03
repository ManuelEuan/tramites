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
    .btn-secondary{
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
                        <h2 class="titulo">Personas Fisicas y Morales</h2>
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
                                <div class="col-md-4 mb-3">
                                    <label for="txtNombre">Nombre</label>
                                    <input type="text" class="form-control" id="txtNombre" placeholder="Nombre" >
                                    <span id="validaNombre" style="font-size: 12px; color:red;"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="txtApellidoP">Primer Apellido</label>
                                    <input type="text" class="form-control" id="txtApellidoP" placeholder="Primer Apellido" >
                                    <span id="validaPaterno" style="font-size: 12px; color:red;"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="txtApellidoM">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="txtApellidoM" placeholder="Segundo Apellido" >
                                    <span id="validaMaterno" style="font-size: 12px; color:red;"></span>
                                </div>
                                <div class=" col-md-4 mb-3">
                                    <label for="txtRFC">RFC</label>
                                    <input type="text" class="form-control"  id="txtRFC" placeholder="RFC" >
                                    <span id="validaRFC" style="font-size: 12px;  color:red;"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="txtCURP">CURP</label>
                                    <input type="text" class="form-control" id="txtCURP" placeholder="CURP" >
                                    <span id="validaCURP" style="font-size: 12px; color:red;"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="txtEmail">Correo electrónico</label>
                                    <input type="text" class="form-control" id="txtEmail" placeholder="Correo electrónico" >
                                    <span id="validaEmail" style="font-size: 12px;  color:red;"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="txtRS">Razón Social</label>
                                    <input type="text" class="form-control" id="txtRS" placeholder="Razón Social" >
                                    <span id="validaRS" style="font-size: 12px; color:red;"></span>
                                </div>
                                <div class="col-md-12 btnContenedor">
                                    <button class="btn btn-primary bntGeneral btnLetras" type="button" onclick="buscar()">Buscar</button>
                                    <button style="display: none;" id='btnModal' type="button" data-toggle="modal" data-target="#exampleModalCenter"></button>
                                    <button class="btn btn-warning bntGeneral btnLimpiar btnLetras" type="button" onclick="limpiaCampos('btnLimpiar')">Limpiar Filtros</button>
                                </div>
                            </div>
                        </form>

                        <h2 class="resultados_De_busqueda">Resultados de la búsqueda</h2>
                        <div class="seguimiento">
                            <div class="row">
                                <div class="col-12">
                                    <table id="example" class="table table-bordered" style="width: 100%">
                                        <thead class="bg-gob">
                                            <tr>
                                                <th>Nombres</th>
                                                <th>Primer apellido</th>
                                                <th>Segundo apellido</th>
                                                <th>CURP</th>
                                                <th>RFC</th>
                                                <th>Razón Social</th>
                                                <th>Tipo de persona</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
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
                                    <div class="col-md-6 mb-3">
                                        <label for="rfc">RFC</label>
                                        <span class="modalEditar">
                                            <button type="button" onclick="editaCampo('rfc')" title="Editar"  class="btn btn-link"><i class="fas fa-pencil-alt" style="color: black"></i></button>
                                        </span>
                                        <input type="text" class="form-control mayusculas" id="rfc" placeholder="RFC" autocomplete="off" disabled required>
                                        <span id="valRFC" style="font-size: 12px;  color:red;"></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="curp">CURP</label>
                                        <span class="modalEditar">
                                            <button type="button" onclick="editaCampo('curp')" title="Editar"  class="btn btn-link"><i class="fas fa-pencil-alt" style="color: black"></i></button>
                                        </span>
                                        <input type="text" class="form-control mayusculas" id="curp" placeholder="CURP" autocomplete="off" disabled required>
                                        <span id="valCURP" style="font-size: 12px;  color:red;"></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="correo">Correo electrónico</label>
                                        <span class="modalEditar">
                                            <button type="button" onclick="editaCampo('correo')" title="Editar"  class="btn btn-link"><i class="fas fa-pencil-alt" style="color: black"></i></button>
                                        </span>
                                        <input type="text" class="form-control" id="correo" placeholder="Correo electrónico" autocomplete="off" required disabled>
                                        <span id="valCorreo" style="font-size: 12px;  color:red;"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <span class="modalEditar">
                                            <button type="button" onclick="editaCampo('alternativo')" title="Editar"  class="btn btn-link"><i class="fas fa-pencil-alt" style="color: black"></i></button>
                                        </span>
                                        <label for="alternativo">Correo electrónico alterno</label>
                                        <input type="text" class="form-control" id="alternativo" placeholder="Correo electrónico alterno" autocomplete="off" disabled>
                                        <span id="valAlternativo" style="font-size: 12px;  color:red;"></span>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="nombre">Nombres</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="Nombres" autocomplete="off" disabled required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="apellidoP">Primer Apellido</label>
                                        <input type="text" class="form-control" id="apellidoP" placeholder="Primer Apellido" autocomplete="off" disabled required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="apellidoM">Segundo Apellido</label>
                                        <input type="text" class="form-control" id="apellidoM" placeholder="Segundo Apellido" disabled autocomplete="off">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sexo">Sexo</label>
                                        <input type="text" class="form-control" id="sexo" placeholder="Segundo Apellido" disabled autocomplete="off">
                                    </div>
                                    <div class="col-md-8 mb-3" id="datosRs">
                                        <label for="razon">Razón social</label>
                                        <input type="text" class="form-control" id="razon" placeholder="Razón social" autocomplete="off" disabled>
                                    </div>

                                    <div id="datosParticular" style="width: 100%"  class="form-row">
                                        <hr>
                                        <div class="col-md-12 mb-3">
                                            <h5>Domicilio Particular</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="callePart">Calle</label>
                                            <input type="text" class="form-control" id="callePart" placeholder="Calle" autocomplete="off" disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="numInteriorPart">Número interior</label>
                                            <input type="number" class="form-control" id="numInteriorPart" placeholder="Número interior" autocomplete="off" disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="numExteriorPart">Número exterior</label>
                                            <input type="number" class="form-control" id="numExterior" placeholder="Número exterior" autocomplete="off" disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="cpPart">C.P.</label>
                                            <input type="number" class="form-control" id="cpPart" placeholder="C.P." autocomplete="off" disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="coloniaPart">Colonia</label>
                                            <input type="text" class="form-control" id="coloniaPart" placeholder="Colonia" autocomplete="off" disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="municipioPart">Municipio</label>
                                            <input type="text" class="form-control" id="municipioPart" placeholder="Municipio" autocomplete="off" disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="estadoPart">Estado</label>
                                            <input type="text" class="form-control" id="estadoPart" placeholder="Estado" autocomplete="off" disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="paisPart">País</label>
                                            <input type="text" class="form-control" id="paisPart" placeholder="País" autocomplete="off" disabled>
                                        </div>
                                    </div>
                                   
                                    <div id="datosFiscal" style="width: 100%"  class="form-row">
                                        <hr>
                                        <div class="col-md-12 mb-3">
                                            <h5>Domicilio Fiscal</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="calleFisc">Calle</label>
                                            <input type="text" class="form-control" id="calleFisc" placeholder="Calle" autocomplete="off" required disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="numInteriorFisc">Número interior</label>
                                            <input type="number" class="form-control" id="numInteriorFisc" placeholder="Número interior" autocomplete="off" required disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="numExteriorFisc">Número exterior</label>
                                            <input type="number" class="form-control" id="numExteriorFisc" placeholder="Número exterior" autocomplete="off" required disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="cpFisc">C.P.</label>
                                            <input type="number" class="form-control" id="cpFisc" placeholder="C.P." autocomplete="off" required disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="coloniaFisc">Colonia</label>
                                            <input type="text" class="form-control" id="coloniaFisc" placeholder="Colonia" autocomplete="off" required disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="municipioFisc">Municipio</label>
                                            <input type="text" class="form-control" id="municipioFisc" placeholder="Municipio" autocomplete="off" required disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="estadoFisc">Estado</label>
                                            <input type="text" class="form-control" id="estadoFisc" placeholder="Estado" autocomplete="off" required disabled>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="paisFisc">País</label>
                                            <input type="text" class="form-control" id="paisFisc" placeholder="País" autocomplete="off" required disabled>
                                        </div>
                                    </div>

                                    <div id="datosSucursal" style="width: 100%"  class="form-row"></div>
                                    <div id="agregaSucursal" style="width: 100%"  class="form-row"></div>
                                </div>
                                <button style="display: none;" id="btnSubmit" type="submit">Submit form</button>
                            </form>


                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none;" data-dismiss="modal" id="btnCerrar"></button>
                            <button type="button" class="btn btn-danger btnModal" onclick="cierraModal();" id="btnCerrarForm">Cerrar</button>
                            <button type="button" class="btn btn-success btnModal" onclick="guardar();" id="btnGuardarForm">
                                Guardar
                            </button>
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
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.min.js"></script>

    <script>
        var listado     = [];
        var elimina     = [];
        var consecutivo = 0;
        var persona     = null;
       
        var validacionGuardar   = true;
        var validacionBusqueda  = true;
        

        $(document).ready(function() {       
            listaPersonas();

            $("#txtNombre").blur(function(){
                validaLength('#validaNombre', $(this).val());
            });

            $("#txtApellidoP").blur(function(){
                validaLength('#validaPaterno', $(this).val());
            });

            $("#txtApellidoM").blur(function(){
                validaLength('#validaMaterno', $(this).val());
            });

            $("#txtRS").blur(function(){
                validaLength('#validaRS', $(this).val());
            });
            
            $("#txtRFC").blur(function(){
                validaLength('#validaRFC', $(this).val());
            });

            $("#txtCURP").blur(function(){
                validaLength('#validaCURP', $(this).val());
            });

            $("#txtEmail").blur(function(){
                validaLength('#validaEmail', $(this).val());
            });


            /* validaciones del modal  */
            $("#rfc").blur(function(){
                let res = validacionRFC('#valRFC', $(this).val(),'modal');
                res == true ? $(this).prop('disabled', true) : $(this).prop('disabled', false);
            });

            $("#curp").blur(function(){
                let res = validacionCURP('#valCURP', $(this).val(),'modal');
                res == true ? $(this).prop('disabled', true) : $(this).prop('disabled', false);
            });

            $("#correo").blur(function(){
                let res = validaCorreo('#valCorreo', $(this).val(),'modal');
                res == true ? $(this).prop('disabled', true) : $(this).prop('disabled', false);
            });

            $("#alternativo").blur(function(){
                let res = validaCorreo('#valAlternativo', $(this).val(),'modal');
                res == true ? $(this).prop('disabled', true) : $(this).prop('disabled', false);
            });
        });

        function listaPersonas(){  
            listado = [];          
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#example').DataTable({
                "language": {
                    url: "/assets/template/plugins/DataTables/language/Spanish.json",
                    "search": "Filtrar resultados:",
                },
                "ajax": {
                    "url": "/personasfsicasmorales/find",
                    "type": "get",
                    "data": function(d) {
                        return $.extend({}, d, {
                            "rfc"       : $("#txtRFC").val(),
                            "curp"      : $("#txtCURP").val(),
                            "nombre"    : $("#txtNombre").val(),
                            "paterno"   : $("#txtApellidoP").val(),
                            "materno"   : $("#txtApellidoM").val(),
                            "correo"    : $("#txtEmail").val(),
                            "razon_social": $("#txtRS").val(),
                        });
                    }
                },
                "columns": [
                    { data: "USUA_CNOMBRES" }, 
                    { data: 'USUA_CPRIMER_APELLIDO' },
                    { data: "USUA_CSEGUNDO_APELLIDO" },
                    { data: "USUA_CCURP" },
                    { data: "USUA_CRFC" },
                    { data: "USUA_CRAZON_SOCIAL" },
                    { data: 'USUA_NTIPO_PERSONA' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            listado.push(data);
                            let estatus = data.USUA_NACTIVO == true ? 'Habilitar' : 'Deshabilitar';
                            html =  `<span>
                                        <button type="button" onclick="abreModal(${ data.USUA_NIDUSUARIO }, 'consultar')" title="Consultar" class="btn btn-link"><i class="fas fa-eye" style="color: black"></i></button>
                                    </span>
                                    <span>
                                        <button type="button" onclick="abreModal(${ data.USUA_NIDUSUARIO}, 'editar')" title= "Editar"  class="btn btn-link"><i class="fas fa-edit" style="color: black"></i></button>
                                    </span>
                                    <span>
                                        <button type="button" onclick="cambiaEstatus(${ data.USUA_NIDUSUARIO })" title="${estatus}" class="btn btn-link">`;
                                            
                                            if(data.USUA_NACTIVO == true)
                                        html += `<i class="fas fa-toggle-off" style="color: black"></i>`;
                                    else
                                        html += `<i class="fas fa-toggle-on" style="color: black"></i>`;
                                
                                        html +=`</button></span>`;

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
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                dom: 'Blrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
                    }
                ]
            });
        }
        
        
        function cierraModal(){
            $("#valRFC").text("");
            $("#valCURP").text("");
            $("#valCorreo").text("");
            $("#valAlternativo").text("");

            $('#rfc').prop('disabled', true);
            $('#curp').prop('disabled', true);
            $('#alternativo').prop('disabled', true);
            $('#correo').prop('disabled', true);
            setTimeout(() => {
                $("#btnCerrar").click();
            }, 150);
        }
        
        function guardar(){
            
            if(!validacionGuardar){
                Swal.fire({
                    icon: 'warning',
                    title: 'Favor de corregir los errores señalados.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            else{
                $("#btnCerrarForm").prop('disabled', true);
                $("#btnGuardarForm").prop('disabled', true);
                $("#btnGuardarForm").text("");
                $("#btnGuardarForm").append(` <div id="spinnerGuardar" class="spinner-border" role="status"><span class="sr-only">Loading...</span></div> `);
                
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

                let data= {"id": $("#id").val(),"rfc": $("#rfc").val(),"curp": $("#curp").val(), "correo": $("#correo").val(), 'alternativo': $("#alternativo").val()};

                request = $.ajax({
                    url: "/personasfsicasmorales/update",
                    type: "post",
                    data: data
                });

                request.done(function (response, textStatus, jqXHR){
                    $("#btnCerrarForm").prop('disabled', false);
                    $("#btnGuardarForm").prop('disabled', false);
                    $("#spinnerGuardar").remove();
                    $("#btnGuardarForm").text("Guardar");
                                     
                    if(jqXHR.status == 202){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'El RFC ya existe en el sistema, por favor, inicia sesión con tu usuario y contraseña.'
                        });
                    }else{
                        $("#btnCerrar").click();
                        buscar();
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Operación exitosa',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }, 400);
                    }
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    $("#btnCerrarForm").prop('disabled', false);
                    $("#btnGuardarForm").prop('disabled', false);
                    $("#spinnerGuardar").remove();
                    $("#btnGuardarForm").text("Guardar");
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'se presento el siguiente error: ' + errorThrown
                    });
                });
            }
        }

        function validaLength(input,val){
            if((val.length > 2 && val.length < 100)){
                validacionBusqueda = true;
                $(input).text("");
            }
            else{
                validacionBusqueda = false;
                $(input).text( "El tamaño campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.");
            }
            
            if(val == ''){
                validacionBusqueda = true;
                $(input).text("");
            }
        }

        function validacionCURP(input,val, tipo='buscador'){
            var response = true;
            const strongRegex = new RegExp('^([A-Z&]|[a-z&]{1})([AEIOU]|[aeiou]{1})([A-Z&]|[a-z&]{1})([A-Z&]|[a-z&]{1})([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])([HM]|[hm]{1})([AS|as|BC|bc|BS|bs|CC|cc|CS|cs|CH|ch|CL|cl|CM|cm|DF|df|DG|dg|GT|gt|GR|gr|HG|hg|JC|jc|MC|mc|MN|mn|MS|ms|NT|nt|NL|nl|OC|oc|PL|pl|QT|qt|QR|qr|SP|sp|SL|sl|SR|sr|TC|tc|TS|ts|TL|tl|VZ|vz|YN|yn|ZS|zs|NE|ne]{2})([^A|a|E|e|I|i|O|o|U|u]{1})([^A|a|E|e|I|i|O|o|U|u]{1})([^A|a|E|e|I|i|O|o|U|u]{1})([0-9]{2})$');
            if(strongRegex.test(val.toUpperCase())) {
                tipo== 'buscador' ? validacionBusqueda = true : validacionGuardar= true;
                $(input).text("");
            }
            else{
                tipo== 'buscador' ? validacionBusqueda = false : validacionGuardar= false;
                $(input).text("¡Error! La CURP no es válida, favor de verificar.");
                response = false;
            }
            
            return response;
        }

        function validaCorreo(input,val, tipo='buscador'){
            var response = true;
            const strongRegex = /^(([^<>()\[\]\.,;:\s@\”]+(\.[^<>()\[\]\.,;:\s@\”]+)*)|(\”.+\”))@(([^<>()[\]\.,;:\s@\”]+\.)+[^<>()[\]\.,;:\s@\”]{2,})$/
            if(strongRegex.test(val)) {
                tipo== 'buscador' ? validacionBusqueda = true : validacionGuardar= true;
                $(input).text("");
            }
            else{
                tipo== 'buscador' ? validacionBusqueda = false : validacionGuardar= false;
                $(input).text("¡Error! El formato de correo no es válido, favor de verificar.");
                response = false;
            }
            
            return response;
        }

        function validacionRFC(input,val, tipo='buscador'){
            var response = true;
            const strongRegex = new RegExp("^([A-ZÑ&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))((-)?(([A-Z]|[a-z]|[0-9]){3}))?$");
            if(strongRegex.test(val.toUpperCase())) {
                tipo== 'buscador' ? validacionBusqueda = true : validacionGuardar= true;
                $(input).text("");
            }
            else{
                tipo== 'buscador' ? validacionBusqueda = false : validacionGuardar= false;
                $(input).text("¡Error! El RFC no es válido, favor de verificar.");
                response = false;
            }
            return response;
        }

        function abreModal(id, accion){
            console.log("modal", listado);
            const found = listado.find(element => {
                if(element.USUA_NIDUSUARIO == id){
                    return element;
                }
            });
            if(accion != 'editar'){
                $(".modalEditar").hide();
                $("#btnGuardarForm").hide();
            }
            else{
                $(".modalEditar").show();
                $("#btnGuardarForm").show();
            }

            persona = found;
            console.log(found);
            $("#id").val(found.USUA_NIDUSUARIO);
            $("#rfc").val(found.USUA_CRFC);
            $("#curp").val(found.USUA_CCURP);
            $("#nombre").val(found.USUA_CNOMBRES);
            $("#apellidoP").val(found.USUA_CPRIMER_APELLIDO);
            $("#apellidoM").val(found.USUA_CSEGUNDO_APELLIDO);
            $("#razon").val(found.USUA_CRAZON_SOCIAL);
            found.USUA_NTIPO_SEXO == 'F' ?  $("#sexo").val("Femenino") : $("#sexo").val("Masculino");
            $("#correo").val(found.USUA_CCORREO_ELECTRONICO);
            $("#alternativo").val(found.USUA_CCORREO_ALTERNATIVO);

            $("#callePart").val(found.USUA_CCALLE_PARTICULAR);
            $("#numInteriorPart").val(found.USUA_NNUMERO_INTERIOR_PARTICULAR);
            $("#numExteriorPart").val(found.USUA_NNUMERO_EXTERIOR_PARTICULAR);
            $("#cpPart").val(found.USUA_NCP_PARTICULAR);
            $("#coloniaPart").val(found.USUA_CCOLONIA_PARTICULAR);
            $("#municipioPart").val(found.USUA_CMUNICIPIO_PARTICULAR);
            $("#estadoPart").val(found.USUA_CESTADO_PARTICULAR);
            $("#paisPart").val(found.USUA_CPAIS_PARTICULAR);

            $("#calleFisc").val(found.USUA_CCALLE);
            $("#numInteriorFisc").val(found.USUA_NNUMERO_INTERIOR);
            $("#numExteriorFisc").val(found.USUA_NNUMERO_EXTERIOR);
            $("#cpFisc").val(found.USUA_NCP);
            $("#coloniaFisc").val(found.USUA_CCOLONIA);
            $("#municipioFisc").val(found.USUA_CMUNICIPIO);
            $("#estadoFisc").val(found.USUA_CESTADO);
            $("#paisFisc").val(found.USUA_CPAIS);
            $("#tituloModal").text("Detalle del usuario");
            
            if(found.USUA_NTIPO_PERSONA == 'MORAL'){
                $("#datosParticular").hide();
                $("#datosRs").show();
                $("#datosSucursal").show();
                let html = `<div id='datosSucursal' style='width: 100%' class='form-row'><hr><div class="col-md-12 mb-3"><h5>Sucursal</h5></div>`;
                let i = 0;

                found.sucursales.forEach(element => {
                    html += `<div id="sucursal_${element.SUCU_NIDSUCURSAL}" class="form-row" style="width: 100%;">`;
                    if(i !== 0){
                        html += `<hr><div class="col-md-12 mb-3"><h5></h5></div>`;
                    }
                    
                    html += `<div class="col-md-4 mb-3">
                                        <label for="calleFisc">Calle</label>
                                        <input type="text" class="form-control" id="calleFisc" placeholder="Calle" autocomplete="off" value='${element.SUCU_CCALLE}' disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="numInteriorFisc">Número interior</label>
                                        <input type="number" class="form-control" id="numInteriorFisc" placeholder="Número interior" autocomplete="off" value='${element.SUCU_NNUMERO_INTERIOR}' disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="numExteriorFisc">Número exterior</label>
                                        <input type="number" class="form-control" id="numExteriorFisc" placeholder="Número exterior" autocomplete="off" value='${element.SUCU_NNUMERO_EXTERIOR}' disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="cpFisc">C.P.</label>
                                        <input type="number" class="form-control" id="cpFisc" placeholder="C.P." autocomplete="off" value='${element.SUCU_NCP}' disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="coloniaFisc">Colonia</label>
                                        <input type="number" class="form-control" id="cpFisc" placeholder="C.P." autocomplete="off" value='${element.SUCU_CCOLONIA}' disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="municipioFisc">Municipio</label>
                                        <input type="number" class="form-control" id="cpFisc" placeholder="C.P." autocomplete="off" value='${element.SUCU_CMUNICIPIO}' disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="estadoFisc">Estado</label>
                                        <input type="number" class="form-control" id="cpFisc" placeholder="C.P." autocomplete="off" value='${element.SUCU_CESTADO}' disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="paisFisc">País</label>
                                        <input type="number" class="form-control" id="cpFisc" placeholder="C.P." autocomplete="off" value='${element.SUCU_CPAIS}' disabled>
                                    </div>
                                    <div class="col-md-4 mb-3"></div>
                    </div>`;
                    i++;
                });
                html += `</div>`;

                $("#datosSucursal").replaceWith(html);

                /* Se tiene contemplado si quieren agregar mas sucursales
                if(accion == 'editar'){
                    let btnAgregar = `<button style="margin: auto;" type="button" class="btn btn-success btn-circle" onclick="agregaSucursal()">
                                    <i class="fas fa-plus" title='Agregar Sucursal'></i> </button>`;
                    $("#agregaSucursal").append(btnAgregar);
                } */
            }
            else{
                $("#datosParticular").show();
                $("#datosRs").hide();
                $("#datosSucursal").hide();
            }

            $("#btnModal").trigger("click");
            $("#form_fomulario").removeClass("was-validated");
        }
   
        function buscar(){
            if(!validacionBusqueda){
                return;
            } 
            
            table.ajax.reload();
        }

        function limpiaCampos(){
            $("#txtRFC").val("");
            $("#txtCURP").val("");
            $("#txtNombre").val("");
            $("#txtApellidoP").val("");
            $("#txtApellidoM").val("");
            $("#txtRS").val("");
            $("#txtEmail").val("");

            $("#validaNombre").text("");
            $("#validaPaterno").text("");
            $("#validaMaterno").text("");
            $("#validaRS").text("");
            $("#validaCURP").text("");
            $("#validaRFC").text("");

            buscar();
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
                        buscar();
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
        
        function eliminaSucursal(data){
            let array = [];
            array = data.split('_');
            
            if(array.length > 1){
                elimina.push({"id": array[1]});
            }
            $("#"+data).remove(); 
        }

        function agregaSucursal(){
            let html = `<div id="sucursal${consecutivo}" class="form-row" style="width: 100%;">
                    <hr><div class="col-md-12 mb-3"><h5></h5></div>
                    <div class="col-md-4 mb-3">
                        <label for="calleFisc">Calle</label>
                        <input type="text" class="form-control" id="calleFisc" placeholder="Calle" autocomplete="off" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="numInteriorFisc">Número interior</label>
                        <input type="text" class="form-control" id="numInteriorFisc" placeholder="Número interior" autocomplete="off" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="numExteriorFisc">Número exterior</label>
                        <input type="text" class="form-control" id="numExteriorFisc" placeholder="Número exterior" autocomplete="off" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cpFisc">C.P.</label>
                        <input type="text" class="form-control" id="cpFisc" placeholder="C.P." autocomplete="off" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="coloniaFisc">Colonia</label>
                        <select class="combobox form-control" name="coloniaFisc" id="coloniaFisc" title="Colonia" required>
                            <option value="">Seleccione...</option>
                            <option value="Zona Centro">Zona Centro</option>
                            <option value="San Pedro">San Pedro</option>
                            <option value="Sector Bolívar">Sector Bolívar</option>
                            <option value="Nava">Nava</option>
                            <option value="Nogales Norte">Nogales Norte</option>
                            <option value="Pátzcuaro">Pátzcuaro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="municipioFisc">Municipio</label>
                        <select class="combobox form-control" name="municipioFisc" id="municipioFisc" title="Municipio" required>
                            <option value="">Seleccione...</option>
                            <option>Chihuahua</option>
                            <option>Juárez</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="estadoFisc">Estado</label>
                        <select class="combobox form-control" name="estadoFisc" id="estadoFisc" title="Estado">
                            <option value="">Seleccione...</option>
                            <option>Chihuahua</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="paisFisc">País</label>
                        <select class="combobox form-control" name="paisFisc" id="paisFisc" title="País">
                            <option value="">Seleccione...</option>
                            <option>México</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <span style="margin-top:15%; margin-left:30%;">
                            <button type="button" title="Eliminar sucursal" class="btn btn-link" onclick="eliminaSucursal('sucursal${consecutivo}')">
                                <i class="far fa-trash-alt" style="color: black"></i>
                            </button>
                        </span>
                    </div>
                </div>`;

            $("#datosSucursal").append(html );
        }

        function editaCampo(campo){
            if(campo == 'rfc' || campo == 'curp' || campo == 'correo' || campo == 'alternativo'){
                Swal.fire({
                    title: 'Aviso!',
                    text:  `Está seguro de editar el campo ${ campo.toUpperCase() } del usuario ${persona.USUA_CNOMBRES} ${persona.USUA_CPRIMER_APELLIDO} ${persona.USUA_CSEGUNDO_APELLIDO}`,
                    icon:  'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, aceptar',
                    cancelButtonText: 'No, cancelar',
                })
                .then((result) => {
                    if (result.isConfirmed){
                        $("#"+ campo).prop('disabled', false);
                    }
                });
            }
        }
    </script>
@endsection

<style>
    /* CSS Manuel Euan */
    .body{
        min-height: 400px;
    }
    .border{
        border-radius: 5px;
    }
    .btnLetras{
        color: #fff;
        font-weight: 900;
        margin-left: 20px;
        min-width: 180px;      
    }
    .btnAgregaRespuesta{
        margin: 0 30px;
    }
    hr{
        width: 100% !important;
    }
    .btnContenedor{
        margin-top: 1.2%;
        margin-right: 20px;
        margin-left: 20px;
    }
    label{
        font-weight: bold;
    }
    .resultados_De_busqueda{
        font-weight: bold;
        margin-top: 40px;
    }
    .bntGeneral{
        min-width: 120px;
        margin-right: 30px;
    }
    
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
   
    .btnModal {
        min-width: 115px;
        max-height: 37px;
    }
    .subtitulo{
        font-size: 22px;
    }
    .contenedorPregunta{
        margin-top: 35px;
    }
    .dataTables_info{
        text-align: left !important;
    }
    .btn-circle{
        margin-top: 10px !important;
        width: 30px !important;
        height: 30px !important;
        padding: 6px 0px !important;
        border-radius: 15px !important;
        font-size: 12px !important;
    }

    /* CSS para las respuestas*/
    .inputRespuesta{
        display: inline !important;
        width: 71% !important;
        margin-left: 30px;
        margin-top: 10px !important;
    }
    .inputRespuesta2{
        display: inline !important;
        width: 71% !important;
        margin-top: 10px !important;
    }
    .iconoEspecial{
        font-size: 30px;
        margin-top: 10px;
    }
    .btnLink{
        color: #218838;
        text-decoration:none;
        font-weight: 900;
        margin-bottom: 30px;
    }
    .btnLink:hover{
        color: #218838;
        text-decoration:none;
    }
    .mayusculas{
        text-transform: uppercase;
    }


    /* Css de secciones */
    .btnContenedorRegresar{
        margin-top: 1.2%;
        margin-right: 20px;
        margin-left: 20px;
    }
    .btnRegresar{
        float: right;
        color: #218838;
        text-decoration:none;
        font-weight: 900;
        margin-bottom: 30px;
    }
    .btnRegresar:hover{
        color: #218838;
        text-decoration:none;
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
    .btnDerecha{
        float: right;
    }

    /*  Tabla */
    .inicio{
        width: 0%;
    }
    .final{
        width: 100%;
    }
    .animacion{
        transition: all 0.5s ease .1s;
    }
    #cargando{
        height: 45%;
    }

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

    
    .btnLink{
        color: #218838;
        text-decoration:none;
        font-weight: 900;
        margin-bottom: 30px;
    }
    .btnLink:hover{
        color: #218838;
        text-decoration:none;
    }
    .mayusculas{
        text-transform: uppercase;
    }

    /* Css de secciones */
    .btnContenedorRegresar{
        margin-top: 1.2%;
        margin-right: 20px;
        margin-left: 20px;
    }
    .btnRegresar{
        float: right;
        color: #218838;
        text-decoration:none;
        font-weight: 900;
        margin-bottom: 30px;
    }
    .btnRegresar:hover{
        color: #218838;
        text-decoration:none;
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
    .btnDerecha{
        float: right;
    }

    /*  Tabla */
    .inicio{
        width: 0%;
    }
    .final{
        width: 100%;
    }
    .animacion{
        transition: all 0.5s ease .1s;
    }
    #cargando{
        height: 45%;
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

    .buttons-html5{
        background-color: #01b3e8 !important;
    }

</style>

