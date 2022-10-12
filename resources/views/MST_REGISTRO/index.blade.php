<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/template/img/favicon_queretaro/android-chrome.png') }}" rel="shortcut icon">
    <link href="{{ asset('assets/template/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/formvalidation.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/bootstrap-combobox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/fonts/fontawesome-5.0.6/css/fontawesome-all.css') }}" rel="stylesheet">

    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAVfZgspC8DkCkN29aATmcx4ZhH4VD8ik&libraries=places,drawing" async defer></script>
</head>

<body>
    <div class="container-sm">
        <!-- <%-- Contenido individual --%> -->
        <br>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-3">
                            <a class="navbar-brand  Texto-menu" href="/">
                                <img src="{{ asset('assets/template/img/login.png') }}" style="width: 70px;"  class="d-inline-block align-top" alt="">
                            </a>
                        </div>
                        <div class="col-md-9 align-self-end">
                            <h4 class="font-weight-bold"></h4>
                            <ol class="breadcrumb breadcrumb-nav">
                                <li class="breadcrumb-item"><a href="/" style="color: #007bff;">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Crear usuario</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center ">
                    <h5 class="font-weight-bold">Crear usuario</h5>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <br/>

            <div class="card">
                <div class="card-body text-body" style="padding: 0px !important;">
                    <div class="listError"></div>
                    <div class="MensajeSuccess"></div>
                    <form id="frmForm" name="form" class="form-horizontal m-4 needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold">Tipo de persona</h5>
                            </div>
                        </div>
                        <!-- <label for="bus-txt-centro-trabajo" style="color: red;">PARA LA CREACION  DE UNA PERSONA MORAL ES IMPORTANTE QUE EL REPRESENTANTE LEGAL ESTÉ REGISTRADO COMO PERSONA FISICA <span class="text-danger">*</span></label> -->
                        <div>
                            <div class="col-md-4">
                                <p class="text-dark">Por favor, selecciona una opción</p>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input rdbTipo_Persona" type="radio" value="FISICA"
                                            name="rdbTipo_Persona">
                                        <label class="form-check-label">Física</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input rdbTipo_Persona" type="radio" value="MORAL"
                                            name="rdbTipo_Persona">
                                        <label class="form-check-label">Moral</label>
                                    </div>
                                </div>
                            </div>
                            <div id="divMensaje" class="alert alert-warning" role="alert" style="display: none;">
                                Para Registrar una Persona Moral, es es necesario realizar el registro previamente del Representante Legal como Persona Física. <br> El correo del Representante Legal debe ser su correo laboral, mientras que al registrar a la Persona Moral se debe de poner el correo empresarial de la misma
                            </div>
                        </div>
                        
                        <div id="frmRegistro" style="display: none;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">RFC <span class="text-danger">*</span> <span class="text-primary" id="lblRfc">Se compone de 13 caracteres</span></label>
                                            <input type="text" title="RFC" class="form-control" id="txtRfc" name="txtRfc" placeholder="RFC" value="" required>
                                            <span id="resultadoValidText" style="font-size: 12px;"></span>
                                            <span id="resultadoExistRfc" style="font-size: 12px;"></span>
                                    </div>
                                </div>

                                <div class="col-md-1 row align-items-center">
                                    <span class="circle-success" id="iconRfc_Valido">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col-md-5 divCurp">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">CURP <span class="text-danger">*</span>  <span class="text-primary">Se compone de 18 caracteres</span></label>
                                        <input type="text" class="form-control txtCurp" name="txtCurp" id="txtCurpFisica" placeholder="CURP">
                                        <span class="resultadoValidTextCurp" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                                <div class="col-md-1 row align-items-center divCurp">
                                    <span class="circle-success iconCurp_Valido">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </span>
                                </div>

                                <div class="col-md-8 divRazon_Social">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Razón Social <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="txtRazon_Social" id="txtRazon_Social"
                                            placeholder="Razón Social">
                                        <span class="resultadoValidTextRaSocial" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                                <!--
                                <div class="col-md-4 divFechaConstitucionMoral">
                                    <div class="form-group" style="text-align: -webkit-center;">
                                        <br>
                                        <label for="bus-txt-centro-trabajo">Fecha de Constitución: </label>
                                        <input type="date" id="fechaConstitucionMoral" name="fechaConstitucionMoral" value="">
                                    </div>
                                </div>
                            -->

                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="font-weight-bold" id="divTxtRepresentante">Datos del representante legal</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <!--<p class="text-dark" id="divTxtRepresentante">Por favor, captura los datos del representante legal</p>-->
                                    <label for="bus-txt-centro-trabajo">Género<span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="F"
                                                name="rdbSexo" checked required>
                                            <label class="form-check-label">Mujer</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="M"
                                                name="rdbSexo" required>
                                            <label class="form-check-label">Hombre</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="NA"
                                                name="rdbSexo" required>
                                            <label class="form-check-label">Prefiero no contestar</label>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 divCurpMoral">
                                <!-- <label for="bus-txt-centro-trabajo" style="color: red;">EL REPRESENTANTE LEGAL DEBE DE ESTAR REGISTRADO COMO PERSONA FISICA <span class="text-danger">*</span></label> -->
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">CURP <span class="text-danger">*</span>  <span class="text-primary">Se compone de 18 caracteres</span></label>
                                        <span class="text-primary">Ingresa la curp del representante legal para buscar su información</span>
                                        <input type="text" class="form-control txtCurp" name="txtCurpMoral" id="txtCurpMoral" placeholder="CURP">
                                        <span class="resultadoValidTextCurpMoral" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Primer apellido <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="txtPrimer_Apellido" id="txtPrimer_Apellido" placeholder="Primer apellido" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Segundo apellido</label>
                                        <input type="text" class="form-control" name="txtSegundo_Apellido" id="txtSegundo_Apellido" placeholder="Segundo apellido">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Nombre (s) <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="txtNombres" id="txtNombres" placeholder="Nombre (s)" required >
                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="row divFechaNacimiento">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Fecha de Nacimiento: </label>
                                        <input type="date" id="fechaNacimientoFisica" name="fechaNacimientoFisica" value="">
                                    </div>
                                </div>

                            </div>

                            <br>

                            <h5 class="font-weight-bold">Datos de Contacto</h5>
                            <div class="row ">
                                <div class="col-md-6 divCorreoFisica">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="txtCorreo_Electronico" id="txtCorreo_Electronico" placeholder="Correo electrónico" required>
                                            <span id="resultadoExistCorreo" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 divCorreoMoral">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Correo electrónico Moral<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="txtCorreo_ElectronicoMoral" id="txtCorreo_ElectronicoMoral" placeholder="Correo electrónico" required>
                                            <span id="resultadoExistCorreoMoral" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Correo electrónico alternativo</label>
                                        <input type="email" class="form-control" name="txtCorreo_Alternativo" id="txtCorreo_Alternativo" placeholder="Correo electrónico alternativo">
                                        <span id="resultadoAlterno" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                                <br>
                                <!-- metodos de confirmacion -->
                                <div class="col-md-6">
                                    <div class="form-group confirmMoral">
                                        <label for="bus-txt-centro-trabajo">Ingresa nuevamente el correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="txtConfirmacionCorreo_Electronico" id="txtConfirmacionCorreo_Electronico" placeholder="Vuelve a escribir el correo electrónico" required>
                                            <span id="correoEsIgual" style="font-size: 12px;"></span>
                                    </div>
                                    <div class="form-group confirmFisica">
                                        <label for="bus-txt-centro-trabajo">Ingresa nuevamente el correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="txtConfirmacionCorreo_ElectronicoFisica" id="txtConfirmacionCorreo_ElectronicoFisica" placeholder="Vuelve a escribir el correo electrónico" required>
                                            <span id="correoEsIgualFisica" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Ingresa nuevamente el correo electrónico alternativo</label>
                                        <input type="email" class="form-control" name="txtConfirmacionCorreo_Alternativo" id="txtConfirmacionCorreo_Alternativo" placeholder="Vuelve a escribir el correo electrónico alternativo">
                                        <span id="alternativoEsIgual" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="bus-txt-centro-trabajo">Teléfono <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="LOCAL" name="rdbTelefono" checked required>
                                            <label class="form-check-label">Local</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="CELULAR" name="rdbTelefono" required>
                                            <label class="form-check-label">Celular</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" title="Teléfono" id="txtNumeroTelefono" name="txtNumeroTelefono" placeholder="999999999" placeholder="No. de teléfono"  required>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <label for=""><b>Personas autorizadas para oír y recibir notificaciones</b></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Primer apellido <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="apellidoPrimerAutorizada" id="apellidoPrimerAutorizada" placeholder="Primer apellido" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Segundo apellido</label>
                                        <input type="text" class="form-control" name="apellidoSegundoAutorizada" id="apellidoSegundoAutorizada" placeholder="Segundo apellido">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="bus-txt-centro-trabajo">Nombre<span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="nombrePersonaAutorizada" name="nombrePersonaAutorizada" placeholder="Nombre (s)" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="bus-txt-centro-trabajo">Teléfono <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                    <input type="text" class="form-control" title='Teléfono'  id="telefonoPersonaAutorizada" name="telefonoPersonaAutorizada" placeholder="999999999" placeholder="No. de teléfono" required >
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="bus-txt-centro-trabajo">Correo <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="correoPersonaAutorizada" name="correoPersonaAutorizada" placeholder="Correo" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="bus-txt-centro-trabajo">Confirmación correo persona autorizada <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="ConfirmCorreoPersonaAutorizada" name="ConfirmCorreoPersonaAutorizada" placeholder="Correo" required>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Contraseña <span class="text-danger">*</span> <span class="text-primary">Debe tener mínimo 6 y máximo 20 caracteres</span></label>
                                        <input type="password" class="form-control" name="txtContrasenia" id="txtContrasenia" placeholder="Contraseña" required>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Confirmar Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="txtConfirmacion" id="txtConfirmacion" placeholder="Vuelva a escribir la contraseña" required>
                                        <span id="resultadoConfirmacion" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div><!--fin card-->
            </div>
            <br/>
            <div class="row justify-content-between">
                <div class="col-md-12 text-right">
                    <button class="btn btn-primary btnSubmit" id="btnSubmit" onclick="TRAM_AJX_GUARDAR();">Guardar</button>
                    <button class="btn btn-danger" onclick="TRAM_FN_CANCELAR();">Cerrar</button>
                </div>
            </div>
            <br/>
        </div>
    </div>

    <div class="modal fade" id="modalConfirmar" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Crear usuario</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="p-4 text-center">
                        <h4>¿Desea guardar la información?</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row justify-content-between">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary" id="BtnGuardar" onclick="TRAM_AJX_GUARDAR();">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalGuardado" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="p-4 text-center">
                        <h4>Acción realizada con éxito.</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row mx-auto">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" data-dismiss="modal" onclick="TRAM_FN_LOGIN();">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalError" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>¡Error!</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="p-4 text-center">
                        <h4 id="lblRespuesta"></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row mx-auto">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('assets/template/js/jquery.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="js/popper.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script src="{{ asset('assets/template/js/bootstrap.min.js') }}"></script>
    {{-- <script type="text/javascript" src="plugins/mdb/js/mdb.min.js"></script> --}}
    <script src="{{ asset('assets/template/plugins/DataTables/datatables.min.js') }}"></script>
    {{-- <script type="text/javascript" src="plugins/fontawesome-5.9.0/js/all.min.js"></script> --}}
    <script src="{{ asset('assets/template/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/framework/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/sweet-alert.init.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/bootstrap-combobox.js') }}"></script>
    <script src="{{ asset('assets/template/js/Moment.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    {{-- <script src="plugins/date/js/bootstrap-datepicker.min.js"></script> --}}
    {{-- <script src="plugins/date/js/bootstrap-datetimepicker.min.js"></script> --}}

    <script>
        $(document).ready(function () {
            // $.validator.addMethod("soloLetras", function (value, element) {
            //     var pattern = /^[a-zA-Z]+$/i;
            //     return this.optional(element) || pattern.test(value);
            // }, "El primer apellido solamente puede tener caracteres alfabéticos y espacios.");
            var tipoPersona = $('.rdbTipo_Persona').val();
            console.log(tipoPersona)

            $("#txtCurpFisica").focusout(function(){
                let curp = $(this).val();
                let isCurp =  TRAM_FN_VALIDAR_CURP(curp);
                console.log(isCurp);
                if(isCurp){
                    function curp2date(curp) {
                        var m = curp.match( /^\w{4}(\w{2})(\w{2})(\w{2})/ );
                        //miFecha = new Date(año,mes,dia) 
                        var anyo = parseInt(m[1],10)+1900;
                        if( anyo < 1950 ) anyo += 100;
                        var mes = parseInt(m[2], 10)-1;
                        var dia = parseInt(m[3], 10);
                        return (new Date( anyo, mes, dia ));
                    }
                    Date.prototype.toString = function() {
                        var anyo = this.getFullYear();
                        var mes = this.getMonth()+1;
                        if( mes<=9 ) mes = "0"+mes;
                        var dia = this.getDate();
                        if( dia<=9 ) dia = "0"+dia;
                        return anyo+"-"+mes+"-"+dia;
                    }
                    let fechanac = curp2date(curp);
                    $("#fechaNacimientoFisica").val(fechanac);
                }
                
            })
            function convertValueToUpperCase() {
                $("#txtRfc").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#txtCurpFisica").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#txtCurpMoral").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#txtNombres").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#txtPrimer_Apellido").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                
                $("#txtSegundo_Apellido").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                
                $("#nombrePersonaAutorizada").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#apellidoPrimerAutorizada").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#apellidoSegundoAutorizada").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#txtRazon_Social").keyup(function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#txtNombres").on("change",function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#txtPrimer_Apellido").on("change",function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                $("#txtSegundo_Apellido").on("change",function(){
                    this.value = this.value.toLocaleUpperCase();
                });
                
            }
            convertValueToUpperCase();
            $.validator.addMethod("soloLetras", function(value, element) {
                return this.optional(element) || /^\D+$/gi.test(value);
            }, "no valido");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.validator.addMethod("passwordcheck", function(value) {
                return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,20}$/.test(value)// has a special character
                },"La contraseña debe contener de 8 a 15 carácteres alfanuméricos (a-z A-Z), contener mínimo un dígito (0-9) y un carácter especial (_-=)."
            );
          
//             $.validator.addMethod("passwordcheck", function(value) {
//     return /^[a-zA-Z0-9!@#$%^&()=[]{};':"\|,.<>\/?+-]+$/.test(value) 
//   },"La contraseña debe contener de 8 a 15 carácteres alfanuméricos (a-z A-Z), contener mínimo un dígito (0-9) y un carácter especial (_-=)."  
//   );

            $("#frmForm").validate({
                focusInvalid: false,
                invalidHandler: function() {
                    $(this).find(":input.error:first").focus();
                },
                rules: {
                    txtRfc: {
                            minlength: 11,
                            maxlength: 13
                    },
                    txtNombres: {
                        minlength: 2,
                        maxlength: 100,
                    },
                    txtPrimer_Apellido: {
                        minlength: 2,
                        maxlength: 100,
                    },
                    txtSegundo_Apellido: {
                        minlength: 2,
                        maxlength: 100,
                    },
                    txtCalle_Particular: {
                        minlength: 2,
                        maxlength: 100
                    },
                    txtCalle_Fiscal: {
                        minlength: 2,
                        maxlength: 100
                    },
                    txtNumero_Interior_Particular: {
                        minlength: 1,
                        maxlength: 10
                    },
                    txtNumero_Exterior_Particular: {
                        minlength: 1,
                        maxlength: 10
                    },
                    txtNumero_Interior_Fiscal: {
                        minlength: 1,
                        maxlength: 10
                    },
                    txtNumero_Exterior_Fiscal: {
                        minlength: 1,
                        maxlength: 10
                    },
                    txtCP_Particular: {
                        minlength: 5,
                        maxlength: 5
                    },
                    txtCP_Fiscal: {
                        minlength: 5,
                        maxlength: 5
                    },
                    txtContrasenia: {
                        minlength: 6,
                        maxlength: 20,
                        passwordcheck:true
                    },
                    nombrePersonaAutorizada: {
                        minlength: 2,
                        maxlength: 100,
                        soloLetras: ""
                    },
                    apellidoPrimerAutorizada: {
                        minlength: 2,
                        maxlength: 100,
                        soloLetras: ""
                    },
                    apellidoSegundoAutorizada: {
                        minlength: 2,
                        maxlength: 100,
                        soloLetras: ""
                    },
                    /*
                    txtRazon_Social :{
                        minlength: 2,
                        maxlength: 100,
                    },*/
                    txtNumeroTelefono : {
                        minlength : 10
                    },
                    telefonoPersonaAutorizada : {
                        minlength : 10
                    },
                },
                messages: {
                    txtRfc: {
                            minlength: "",
                            maxlength: "",
                            required: ""
                    },
                    txtNombres: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: "",
                    },
                    txtPrimer_Apellido: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: "",
                    },
                    txtSegundo_Apellido: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: "",
                    },
                    txtCalle_Particular: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: ""
                    },
                    txtCalle_Fiscal: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: ""
                    },
                    txtNumero_Interior_Particular: {
                        minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                        maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                        required: ""
                    },
                    txtNumero_Exterior_Particular: {
                        minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                        maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                        required: ""
                    },
                    txtNumero_Interior_Fiscal: {
                        minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                        maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                        required: ""
                    },
                    txtNumero_Exterior_Fiscal: {
                        minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                        maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                        required: ""
                    },
                    txtCP_Particular: {
                        minlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                        maxlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                        required: ""
                    },
                    txtCP_Fiscal: {
                        minlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                        maxlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                        required: ""
                    },
                    txtCorreo_Electronico: {
                        email: "",
                        required: ""
                    },
                    txtCorreo_Alternativo: {
                        email: "",
                        required: ""
                    },
                    txtConfirmacionCorreo_Electronico: {
                        email: "",
                        required: ""
                    },
                    txtConfirmacionCorreo_ElectronicoFisica: {
                        email: "",
                        required: ""
                    },
                    txtConfirmacionCorreo_Alternativo: {
                        email: "",
                        required: ""
                    },
                    txtContrasenia: {
                        minlength: "El tamaño del campo debe contener mínimo 5 dígitos.",
                        maxlength: "El tamaño del campo debe contener máximo 20.",
                        passwordcheck:"La contraseña requiere mínimo una letra mayúscula y un caracter especial [!@#$%^&*]",
                        required: ""
                    },
                        cmbColonia_Particular: {
                        required: ""
                    },
                    cmbMunicipio_Particular: {
                        required: ""
                    },
                    cmbEstado_Particular: {
                        required: ""
                    },
                    cmbPais_Particular: {
                        required: ""
                    },
                    cmbColonia_Fiscal: {
                        required: ""
                    },
                    cmbMunicipio_Fiscal: {
                        required: ""
                    },
                    cmbEstado_Fiscal: {
                        required: ""
                    },
                    cmbPais_Fiscal: {
                        required: ""
                    },
                    txtCurpFisica: {
                        required: ""
                    },
                    /*txtRazon_Social: {
                        required: "",
                        minlength: "El tamaño del campo debe contener mínimo 2 dígitos.",
                        maxlength: "El tamaño del campo debe contener máximo 100.",
                    },*/
                    txtCurp: {
                        required: ""
                    },
                    txtNumeroTelefono:{
                        minlength: "El tamaño del campo debe contener mínimo 10 dígitos.",
                        required: ""
                    },
                    telefonoPersonaAutorizada:{
                        minlength: "El tamaño del campo debe contener mínimo 10 dígitos.",
                        required: ""
                    },
                    nombrePersonaAutorizada:{
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: "",
                        soloLetras: "La campo solamente puede tener caracteres alfabéticos y espacios."
                    },
                    apellidoPrimerAutorizada:{
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: "",
                        soloLetras: "La campo solamente puede tener caracteres alfabéticos y espacios."
                    },
                    apellidoSegundoAutorizada:{
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: "",
                        soloLetras: "La campo solamente puede tener caracteres alfabéticos y espacios."
                    },
                    correoPersonaAutorizada: {
                        required: ""
                    },
                    ConfirmCorreoPersonaAutorizada: {
                        required: ""
                    },
                    txtConfirmacion: {
                        required: ""
                    }
                }
            });

            $('.repeater').repeater({
                initEmpty: true,
                show: function () {
                    $(this).slideDown();
                        TRAM_AJX_CARGAR_MUNICIPIOS_SUCURSAL();
                        TRAM_AJX_CARGAR_ESTADOS_SUCURSAL();
                        TRAM_AJX_CARGAR_PAISES_SUCURSAL();
                    $(".txtCalle_Sucursal").each(function() {
                        $(this).rules('add', {
                            required: false,
                            minlength: 2,
                            maxlength: 100,
                            messages: {
                                required: "",
                                minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                                maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                            }
                        });
                    });
                    $(".txtNumero_Interior_Sucursal").each(function() {
                        $(this).rules('add', {
                            required: false,
                            minlength: 2,
                            maxlength: 10,
                            messages: {
                                required: "",
                                minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                                maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                            }
                        });
                    });
                    $(".txtNumero_Exterior_Sucursal").each(function() {
                        $(this).rules('add', {
                            required: false,
                            minlength: 2,
                            maxlength: 10,
                            messages: {
                                required: "",
                                minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                                maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                            }
                        });
                    });
                    $(".txtCP_Sucursal").each(function() {
                        $(this).rules('add', {
                            required: false,
                            minlength: 5,
                            maxlength: 5,
                            messages: {
                                required: "",
                                minlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                                maxlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                            }
                        });
                    });

                    $('.optionsMunicipioSucursal').change(function(){


                       //var value = $(".optionsMunicipioSucursal option:selected" ).text();
                       var value = $(this).val();

                       var name = $(this).attr("name");
                        var resultado = name.split("]");

                        TRAM_AJX_CARGAR_LOCALIDADES_SUCURSAL(value,resultado[0]+"]"+"[cmbColonia_Sucursal]");


                    });


                }
            });

            $("#frmRegistro").hide();
            $("#iconRfc_Valido").hide();
            $(".iconCurp_Valido").hide();
        });

        document.getElementById('txtNumeroTelefono').addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });

        document.getElementById('telefonoPersonaAutorizada').addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
        

        //Tipo de persona
        $('.rdbTipo_Persona').change(function(){
            var value = $( this ).val();
            // console.log(value);
            $("#frmRegistro").show();
            if(value == "FISICA"){
                $("#divMensaje").hide();
                $(".divRazon_Social").hide();
                $(".divCurp").show();
                $("#divTxtRepresentante").hide();
                $(".divDomicilio_Particular").show();
                $(".divCurp_Moral").hide();
                $(".divCurpMoral").hide();
                $(".divCorreoMoral").hide();

                $(".divFechaNacimiento").show();
                $(".divFechaConstitucionMoral").hide();
                $(".divCorreoFisica").show();
                $(".confirmMoral").hide();
                $(".confirmFisica").show();


                $('#txtNombres').val('')
                $('#txtPrimer_Apellido').val('')
                $('#txtSegundo_Apellido').val('')
                $('#txtCurpMoral').val('')
                $('#txtConfirmacionCorreo_Electronico').val('')
                $('#txtCurpMoral').val('')

                //TXT Datos de la persona
                document.getElementById("txtNombres").readOnly = false;
                document.getElementById("txtNombres").placeholder = "Nombre (s)";
                document.getElementById("txtPrimer_Apellido").readOnly = false;
                document.getElementById("txtPrimer_Apellido").placeholder = "Primer apellido";
                document.getElementById("txtSegundo_Apellido").readOnly = false;
                document.getElementById("txtSegundo_Apellido").placeholder = "Segundo apellido";

                $('#txtCalle_Particular').prop('required',true);
                $('#txtNumero_Exterior_Particular').prop('required',true);
                $('#txtCP_Particular').prop('required',true);
                $('#cmbColonia_Particular').prop('required',true);
                $('#cmbMunicipio_Particular').prop('required',true);
                $('#cmbEstado_Particular').prop('required',true);
                $('#cmbPais_Particular').prop('required',true);

                $('#txtCalle_Fiscal').prop('required',false);
                $('#txtNumero_Exterior_Fiscal').prop('required',false);
                $('#txtCP_Fiscal').prop('required',false);
                $('#cmbColonia_Fiscal').prop('required',false);
                $('#cmbMunicipio_Fiscal').prop('required',false);
                $('#cmbEstado_Fiscal').prop('required',false);
                $('#cmbPais_Fiscal').prop('required',false);

                $('#txtCurpFisica').prop('required',true);
                $('#txtCurpMoral').prop('required',false);
                $('#txtCorreo_Electronico').prop('required',true);
                $('#txtCorreo_ElectronicoMoral').prop('required',false);
                $('#txtConfirmacionCorreo_ElectronicoFisica').prop('required',true);
                $('#txtConfirmacionCorreo_Electronico').prop('required',false);

                $('#txtRazon_Social').prop('required',false);

                $('.asterisco').hide();
                $('#lblRfc').html("Se compone de 13 caracteres");

            }else {
                $("#divMensaje").show();
                $(".divRazon_Social").show();
                $(".divCurp").hide();
                $("#divTxtRepresentante").show();
                $(".divDomicilio_Particular").hide();
                $(".divCurp_Moral").show();
                $(".divCurpMoral").show();
                $(".divCorreoMoral").show();
                $(".divCorreoFisica").hide();

                $(".divFechaNacimiento").hide();
                $(".divFechaConstitucionMoral").show();

                $(".confirmMoral").show();
                $(".confirmFisica").hide();

                //TXT Datos de la persona
                document.getElementById("txtNombres").readOnly = true;
                document.getElementById("txtNombres").placeholder = "";
                document.getElementById("txtPrimer_Apellido").readOnly = true;
                document.getElementById("txtPrimer_Apellido").placeholder = "";
                document.getElementById("txtSegundo_Apellido").readOnly = true;
                document.getElementById("txtSegundo_Apellido").placeholder = "";

                $('#txtCalle_Particular').prop('required',false);
                $('#txtNumero_Exterior_Particular').prop('required',false);
                $('#txtCP_Particular').prop('required',false);
                $('#cmbColonia_Particular').prop('required',false);
                $('#cmbMunicipio_Particular').prop('required',false);
                $('#cmbEstado_Particular').prop('required',false);
                $('#cmbPais_Particular').prop('required',false);

                $('#txtCalle_Fiscal').prop('required',true);
                $('#txtNumero_Exterior_Fiscal').prop('required',true);
                $('#txtCP_Fiscal').prop('required',true);
                $('#cmbColonia_Fiscal').prop('required',true);
                $('#cmbMunicipio_Fiscal').prop('required',true);
                $('#cmbEstado_Fiscal').prop('required',true);
                $('#cmbPais_Fiscal').prop('required',true);

                $('#txtCurpFisica').prop('required',false);
                $('#txtCurpMoral').prop('required',true);
                //$('#txtRazon_Social').prop('required',true);
                $('#txtCorreo_Electronico').prop('required',false);
                $('#txtCorreo_ElectronicoMoral').prop('required',true);
                $('#txtConfirmacionCorreo_ElectronicoFisica').prop('required',false);
                $('#txtConfirmacionCorreo_Electronico').prop('required',true);


                $('.asterisco').show();
                $('#lblRfc').html("Se compone de 12 caracteres");
            }
        });

        //RFC
        $('#txtRfc').change(function(){
            var value = $( this ).val();
            TRAM_FN_VALIDAR_INPUT_RFC(value);
            if(rfcCorrecto ){
                TRAM_AJX_VALIDAR_RFC(value, 'rfc');
            }
        });

        //RAZON SOCIAL
        $('#txtRazon_Social').change(function(){
            var value = $( this ).val().length;
            if(value < 2 || value > 100){
                $(".resultadoValidTextRaSocial").html("<span style='color: red;'>El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.</span>");
            }else{
                $(".resultadoValidTextRaSocial").html("");
            }
            console.log(value);
            
        });

        //CURP
        $("#txtCurpFisica").change(function(){
            var value = $( this ).val();
            var tipo = "FISICA";
            TRAM_FN_VALIDAR_INPUNT_CURP(value, tipo);
            if(curpValido){
                TRAM_AJX_VALIDAR_RFC(value, 'curp');
            }
        });

        //Correo
        $('#txtCorreo_Electronico').change(function(){
            // $('.rdbTipo_Persona').empty();
            var value = $( this ).val();
            var tipo = 'FISICA';
            // var tipoPersona = $('.rdbTipo_Persona').val();
            // console.log(tipoPersona);
            emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            if(value != ""){
                if (emailRegex.test(value)) {
                    $("#resultadoExistCorreo").html('');
                    TRAM_AJX_VALIDAR_CORREO(value,tipo);
                } else {
                    $("#resultadoExistCorreo").html("<span style='color: red;'> El correo que se agregó no es válido, se requiere verificar.</span>");
                }
            }
        });
        $('#txtCorreo_ElectronicoMoral').change(function(){
            // $('.rdbTipo_Persona').empty();
            var value = $( this ).val();
            var tipo = 'MORAL';
            // var tipoPersona = $('.rdbTipo_Persona').val();
            // console.log(tipoPersona);
            emailRegex = /^([a-zA-Z0-9_.+-])+\@((gmail|hotmail|outlook)+\.)+([a-zA-Z0-9]{2,4})+$/i;
            console.log(emailRegex.test(value));
            if(value != ""){
                if (!emailRegex.test(value)) {
                    $("#resultadoExistCorreoMoral").html('');
                    TRAM_AJX_VALIDAR_CORREO(value,tipo);
                } else {
                    $("#resultadoExistCorreoMoral").html("<span style='color: red;'> El correo que se agregó no es válido, se requiere verificar.</span>");
                }
            }
        });

        $('#txtCorreo_Alternativo').change(function(){
            var value = $( this ).val();
            emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            if(value != ""){
                if (emailRegex.test(value)) {
                    $("#resultadoAlterno").html('');
                } else {
                    $("#resultadoAlterno").html("<span style='color: red;'> El correo que se agregó no es válido, se requiere verificar.</span>");
                }
            }
        });
        $('#txtConfirmacionCorreo_Electronico').change(function(){
            var value = $( this ).val();
            emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            var correoprincipal = $('#txtCorreo_ElectronicoMoral').val();
            if(value != ""){
                if (emailRegex.test(value)) {
                    if(value == correoprincipal){
                    $("#correoEsIgual").html('');
                    }
                    else {
                        $("#correoEsIgual").html("<span style='color: red;'> Los correos no coinciden</span>");
                    }
                } else {
                    $("#correoEsIgual").html("<span style='color: red;'> El correo que se agregó no es válido, se requiere verificar.</span>");
                }
               
            }
        });
        $('#txtConfirmacionCorreo_ElectronicoFisica').change(function(){
            var value = $( this ).val();
            emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            var correoprincipal = $('#txtCorreo_Electronico').val();
            if(value != ""){
                if (emailRegex.test(value)) {
                    if(value == correoprincipal){
                    $("#correoEsIgualFisica").html('');
                    }
                    else {
                        $("#correoEsIgualFisica").html("<span style='color: red;'> Los correos no coinciden</span>");
                    }
                } else {
                    $("#correoEsIgualFisica").html("<span style='color: red;'> El correo que se agregó no es válido, se requiere verificar.</span>");
                }
               
            }
        });
        $('#txtConfirmacionCorreo_Alternativo').change(function(){
            var value = $( this ).val();
            emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            var correoprincipal = $('#txtCorreo_Alternativo').val();

            if(value != ""){
                if (emailRegex.test(value)) {
                    if(value == correoprincipal){
                    $("#alternativoEsIgual").html('');
                    }
                    else {
                        $("#alternativoEsIgual").html("<span style='color: red;'> Los correos no coinciden</span>");
                    }
                    // $("#alternativoEsIgual").html('');
                } else {
                    $("#alternativoEsIgual").html("<span style='color: red;'> El correo que se agregó no es válido, se requiere verificar.</span>");
                }
            }
        });

        $('#txtConfirmacion').change(function(){
            var value = $( this ).val();
            if(value == $('#txtContrasenia').val()){
               $("#resultadoConfirmacion").html('');
            }
            else {
                $("#resultadoConfirmacion").html("<span style='color: red;'> Las contraseñas que ingresó no coinciden, se requiere verificar.</span>");
            }
        });


        $('#txtCurpMoral').change(function(){
            var value = $( this ).val();
            var tipo = "MORAL";
            TRAM_FN_VALIDAR_INPUNT_CURP(value, tipo);
        });

        //Mismo domicilio
        $("#chbDomicilio_Mismo").click(function(){
            if($(this).is(':checked')){
                $('#txtCalle_Fiscal').prop('value', $('#txtCalle_Particular').val());
                $('#txtNumero_Interior_Fiscal').prop('value',$('#txtNumero_Interior_Particular').val());
                $('#txtNumero_Exterior_Fiscal').prop('value',$('#txtNumero_Exterior_Particular').val());
                $('#txtCP_Fiscal').prop('value',$('#txtCP_Particular').val());
                $('#cmbColonia_Fiscal').prop('value',$('#cmbColonia_Particular').val());
                $('#cmbMunicipio_Fiscal').prop('value',$('#cmbMunicipio_Particular').val());
                $('#cmbEstado_Fiscal').prop('value',$('#cmbEstado_Particular').val());
                $('#cmbPais_Fiscal').prop('value',$('#cmbPais_Particular').val());
            }else{
                $('#txtCalle_Fiscal').prop('value', "");
                $('#txtNumero_Interior_Fiscal').prop('value', "");
                $('#txtNumero_Exterior_Fiscal').prop('value', "");
                $('#txtCP_Fiscal').prop('value', "");
                $('#cmbColonia_Fiscal').prop('value', "");
                $('#cmbMunicipio_Fiscal').prop('value', "");
                $('#cmbEstado_Fiscal').prop('value', "");
                $('#cmbPais_Fiscal').prop('value', "");
            }
        });

        //Cancelar
        function TRAM_FN_CANCELAR(){
            Swal.fire({
                title: '',
                text: "¿Desea cancelar el registro?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Si'
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/";
                }
            });
        };

        //Confirmar
        function TRAM_AJX_CONFIRMAR(){
            // $('#modalConfirmar').modal('show');
            Swal.fire({
                title: '¡Confirmar!',
                text: "Se enviará un correo con la información para iniciar sesión. ¿Desea continuar?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
                }).then((result) => {
                if (result.isConfirmed) {
                    //TRAM_AJX_GUARDAR();
                }
            });
        };

        //Guardar
        function TRAM_AJX_GUARDAR(){
            $("#btnSubmit").prop("disabled", true);
            if (!$("#frmForm").valid()){
                $('.listError').hide();
                var validator = $('#frmForm').validate();
                var htmlError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
                $.each(validator.errorList, function (index, value) {
                    var campo = $("#"+ value.element.id).attr('title') == undefined ? $("#"+ value.element.id).attr('placeholder') : $("#"+ value.element.id).attr('title');

                    if(value.method == "required"){
                        $('.listError').show();
                        htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                    }
                });
                htmlError += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $(".listError").html(htmlError);
                $("#btnSubmit").prop("disabled", false);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            }
            if($("#resultadoValidText").html() != ""){
                $("#btnSubmit").prop("disabled", true);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            }
            // if($("#txtConfirmacionCorreo_Electronico").val() != $("#txtCorreo_ElectronicoMoral").val()){
            //     console.log($("#txtConfirmacionCorreo_Electronico").val(),)
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Correos incorrectos',
            //         text: 'Los correos no coinciden, por favor verifica la información e intenta nuevamente',
            //     })
            //     $("#resultadoExistCorreo").html("<span style='color: red;'> Los correos principales no coinciden favor de verificar la información</span>");
            //     $("#correoEsIgual").html("<span style='color: red;'> Los correos principales no coinciden favor de verificar la información</span>");
            //     return;
            // }
            // if($("#txtConfirmacionCorreo_ElectronicoFisica").val() != $("#txtCorreo_Electronico").val()){
            //     console.log($("#txtConfirmacionCorreo_ElectronicoFisica").val(),)
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Correos incorrectos',
            //         text: 'Los correos no coinciden, por favor verifica la información e intenta nuevamente',
            //     })
            //     $("#resultadoExistCorreo").html("<span style='color: red;'> Los correos principales no coinciden favor de verificar la información</span>");
            //     $("#correoEsIgual").html("<span style='color: red;'> Los correos principales no coinciden favor de verificar la información</span>");
            //     return;
            // }
            if($("#correoPersonaAutorizada").val() != $("#ConfirmCorreoPersonaAutorizada").val()){
                Swal.fire({
                    icon: 'error',
                    title: 'Correos incorrectos',
                    text: 'Los correos de la persona autorizada no coinciden, por favor verifica la información e intenta nuevamente',
                })
                return;
            }
            if($("#txtCorreo_Alternativo").val() != ""){
                if($("#txtCorreo_Alternativo").val() != $("#txtConfirmacionCorreo_Alternativo").val()){
                    Swal.fire({
                        icon: 'error',
                        title: 'Correos alternativos incorrectos',
                        text: 'Los correos alternativos no coinciden, por favor verifica la información e intenta nuevamente',
                    })
                    $("#resultadoAlterno").html("<span style='color: red;'> Los correos alternativos no coinciden favor de verificar la información</span>");
                    $("#alternativoEsIgual").html("<span style='color: red;'> Los correos alternativos no coinciden favor de verificar la información</span>");
                    return;
                }
            }
            if($("#resultadoExistRfc").html() != ""){
                $("#btnSubmit").prop("disabled", true);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            }

            if($(".resultadoValidTextCurp").html() != ""){
                $("#btnSubmit").prop("disabled", true);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            }

            if($(".resultadoValidTextCurpMoral").html() != ""){
                $("#btnSubmit").prop("disabled", true);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            }

            if($("#resultadoExistCorreo").html() != ""){
                $("#btnSubmit").prop("disabled", true);
                return;
            }
            if($("#resultadoExistCorreoMoral").html() != ""){
                $("#btnSubmit").prop("disabled", true);
                return;
            }

            Swal.fire({
                title: '¡Confirmar!',
                text: "Se enviará un correo con la información para iniciar sesión. ¿Desea continuar?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
                }).then((result) => {
                if (result.isConfirmed) {


                    $.ajax({
                        data: $('#frmForm').serialize(),
                        url: "/registrar/agregar",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $("#btnSubmit").prop("disabled", false);
                            if(data.status == "success"){
                                $('#frmForm').trigger("reset");
                                $(".MensajeSuccess").html('<div class="alert alert-success" role="alert">'+ data.message +'</div>');
                                $("#frmRegistro").hide();
                                $("#iconRfc_Valido").hide();
                                $(".iconCurp_Valido").hide();
                                Swal.fire({
                                    title: '¡Éxito!',
                                    text: "Su usuario se registró correctamente.",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $(".listError").html("");
                                        TRAM_FN_LOGIN();
                                    }
                                });
                            }else {
                                $(".MensajeSuccess").html("");
                                Swal.fire({
                                    title: '¡Aviso!',
                                    text: data.message,
                                    icon: 'info',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        },
                        error: function (data) {
                            $("#btnSubmit").prop("disabled", false);
                            // $("#lblRespuesta").text(data.message);
                            // $("#modalError").modal('show');
                            Swal.fire({
                                    title: '¡Aviso!',
                                    text: data.message,
                                    icon: 'info',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar'
                                });
                        }
                    });


                }
            });


        }

        //Redirige a login
        function TRAM_FN_LOGIN(){
            document.location.href = '/';
        };

        //Función para validar un RFC
        // Devuelve el RFC sin espacios ni guiones si es correcto
        // Devuelve false si es inválido
        // (debe estar en mayúsculas, guiones y espacios intermedios opcionales)
        function TRAM_FN_VALIDAR_RFC (rfc, aceptarGenerico = true) {
            const re = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            var validado = rfc.match(re);

            if (!validado)  //Coincide con el formato general del regex?
                return false;

            //Separar el dígito verificador del resto del RFC
            const digitoVerificador = validado.pop(),
                rfcSinDigito = validado.slice(1).join(''),
                len = rfcSinDigito.length,

                //Obtener el digito esperado
                diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
                indice = len + 1;
            var suma,
                digitoEsperado;

            if (len == 12) suma = 0
            else suma = 481; //Ajuste para persona moral

            for (var i = 0; i < len; i++)
                suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
            digitoEsperado = 11 - suma % 11;
            if (digitoEsperado == 11) digitoEsperado = 0;
            else if (digitoEsperado == 10) digitoEsperado = "A";

            //El dígito verificador coincide con el esperado?
            // o es un RFC Genérico (ventas a público general)?
            if ((digitoVerificador != digitoEsperado)
                && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
                return false;
            else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
                return false;
            return rfcSinDigito + digitoVerificador;
        };

        //Handler para el evento cuando cambia el input
        // -Lleva la RFC a mayúsculas para validarlo
        // -Elimina los espacios que pueda tener antes o después
        var rfcCorrecto = false;
        function TRAM_FN_VALIDAR_INPUT_RFC (input) {
            //Validar valor
            if (input == null || input == undefined || input == "") {
                console.log('esta vacio');
            } else {
                var newValue = input;
                var rfc = newValue.trim().toUpperCase();
                rfcCorrecto = TRAM_FN_VALIDAR_RFC(rfc);   // Acá se comprueba
                if (rfcCorrecto) {
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    $("#resultadoValidText").html("");
                } else {
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", true);
                    }, 1000);
                    $("#resultadoValidText").html("<span style='color: red;'>El RFC no es válido, se requiere verificar.</span>");
                }
                //toUpperCase
                $("#txtRfc").val(rfc);
            }
        };

        function TRAM_FN_VALIDAR_CURP (params) {
            var reg = "";
            var curp = params;

            if (curp.length == 18) {
                var digito = calculaDigito(curp);
                reg = /^([A-Z]{4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[A-Z]{3}[0-9A-Z]\d)$/i;

                if (curp.search(reg)) {
                    return false;
                }

                if (!(parseInt(digito) == parseInt(curp.substring(17, 18)))) {
                    return false;
                } else {
                    return true;
                }

            } else {
                return false;
            }
        }

        function calculaDigito(curp) {
            var segRaiz = curp.substring(0, 17);
            var chrCaracter = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
            var intFactor = new Array(17);
            var lngSuma = 0.0;
            var lngDigito = 0.0;

            for (var i = 0; i < 17; i++) {
                for (var j = 0; j < 37; j++) {
                    if (segRaiz.substring(i, i + 1) == chrCaracter.substring(j, j + 1)) {
                        intFactor[i] = j;
                    }
                }
            }

            for (var k = 0; k < 17; k++) {
                lngSuma = lngSuma + ((intFactor[k]) * (18 - k));
            }

            lngDigito = (10 - (lngSuma % 10));

            if (lngDigito == 10) {
                lngDigito = 0;
            }

            return lngDigito;
        }

        //Handler para el evento cuando cambia el input
        //Lleva la CURP a mayúsculas para validarlo
        var curpValido= false;
        function TRAM_FN_VALIDAR_INPUNT_CURP(input, tipo) {
            var newValue = input;
            if (input == null || input == undefined || input == "") {
            } else {
                var curp = newValue.trim().toUpperCase();
                curpValido = TRAM_FN_VALIDAR_CURP(curp);
                if (curpValido) {

                    if(tipo == "MORAL"){
                        TRAM_AJX_VALIDAR_RFC(curp, 'curp',tipo)
                    }
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    $(".resultadoValidTextCurp").html("");
                    $(".resultadoValidTextCurpMoral").html("");
                } else {
                    $('#txtNombres').val('')
                    $('#txtPrimer_Apellido').val('')
                    $('#txtSegundo_Apellido').val('')
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    tipo == "MORAL" ? $(".resultadoValidTextCurpMoral").html("<span style='color: red;'>El CURP no es válido, se requiere verificar.</span>") 
                                    : $(".resultadoValidTextCurp").html("<span style='color: red;'> El CURP no es válido, se requiere verificar.</span>");
                }

                tipo == "MORAL" ? $("#txtCurpMoral").val(curp) : $("#txtCurpFisica").val(curp);
            }
        }

        //Validar si el rfc existe
        function TRAM_AJX_VALIDAR_RFC(value, tipo, persona = 'fisica'){
            $.ajax({
                data: {tipo: tipo, valor: value},
                url: "/api/general/validaDuplicidad",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if(data.data != null){
                        setTimeout(function(){
                            $(".btnSubmit").prop("disabled", true);
                        }, 1000);
                        if(tipo == 'curp'){
                            if(persona == 'fisica'){
                                $(".iconCurp_Valido").hide();
                                $(".resultadoValidTextCurp").html("<span style='color: red;'> El CURP ya existe en el sistema, por favor ingresa con tu usuario y contraseña.</span>");
                            }
                            else{
                                $("#txtNombres").val(data.data.USUA_CNOMBRES);
                                $("#txtPrimer_Apellido").val(data.data.USUA_CPRIMER_APELLIDO);
                                $("#txtSegundo_Apellido").val(data.data.USUA_CSEGUNDO_APELLIDO);

                            }
                        }
                        else{
                            $("#iconRfc_Valido").hide();
                            $("#txtRfc").attr("aria-invalid", "true");
                            $("#txtRfc").addClass("error");
                            $("#resultadoExistRfc").html("<span style='color: red;'> El RFC ya existe en el sistema, por favor ingresa con tu usuario y contraseña.</span>");
                        }
                    }else {
                        if(tipo == 'curp'){
                            if(persona == 'fisica'){
                                $(".iconCurp_Valido").show();
                                $("#resultadoExistRfc").html("");
                            }
                            else{
                                $(".resultadoValidTextCurpMoral").html("<span style='color: red;'> El CURP no tiene un registro previo, es necesario que primero se registre el representante legal como persona física.</span>");
                            }
                        }
                        else{
                            if(rfcCorrecto){}
                            $("#iconRfc_Valido").show();
                            $("#txtRfc").attr("aria-invalid", "false");
                            $("#txtRfc").removeClass("error");
                            $("#resultadoExistRfc").html("");
                        }
                    }
                },
            });
        };

        //Validar si el correo existe
        function TRAM_AJX_VALIDAR_CORREO(StrCorreo,tipo){
            $.get('/registrar/validar_correo/' + StrCorreo, function (data) {
                //Validamos si existe un usuario con el correo capturado
                if(data.status == "success"){
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", true);
                    }, 1000);
                    $("#txtRfc").attr("aria-invalid", "true");
                    $("#txtRfc").addClass("error");
                    if(tipo == 'FISICA'){

                        $("#resultadoExistCorreo").html("<span style='color: red;'>"+ data.message +"</span>");
                    }else{

                        $("#resultadoExistCorreoMoral").html("<span style='color: red;'>"+ data.message +"</span>");
                    }
                }else {
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    $("#txtRfc").attr("aria-invalid", "false");
                    $("#txtRfc").removeClass("error");
                    if(tipo == 'FISICA'){

                        $("#resultadoExistCorreo").html("");
                    }else{

                        $("#resultadoExistCorreoMoral").html("");
                    }
                }
            });
        };


        var host = "https://retys-queretaro.azurewebsites.net";
        var listadoLocalidades     = [];
        //localidad y pais option manual html no tiene


        function TRAM_AJX_CARGAR_LOCALIDADES(municipio){
            $.get('/registrar/localidades/'+municipio, function (data) {
                var html = '';
                data.forEach(function(value) {
                    html += '<option value="'+ value.NOMBRE +'">' + value.NOMBRE + '</option>';
                });

                $(".optionsColoniaParticular").append(html);
            });

        }


        function TRAM_AJX_CARGAR_LOCALIDADES_FISCAL(municipio){
            $.get('/registrar/localidades/'+municipio, function (data) {

                var html = '';
                data.forEach(function(value) {
                     html += '<option value="'+ value.NOMBRE +'">' + value.NOMBRE + '</option>';
                 });

                $(".optionsColoniaFiscal").append(html);
            });

        }

        function TRAM_AJX_CARGAR_LOCALIDADES_SUCURSAL(municipio,nombredata){
            $.get('/registrar/localidades/'+municipio, function (data) {
                var html = '';
                data.forEach(function(value) {
                    html += '<option value="'+ value.NOMBRE +'">' + value.NOMBRE + '</option>';
                });

                var element = document.getElementsByName(nombredata);
                $(element).append(html);
            });
        }




        var listadoMunicipios = [];
        var listadoEstados    = [];
        var listadoPaises     = [];

        function TRAM_AJX_CARGAR_MUNICIPIOS_ESTADOS(){
            var host2 =  '/registrar/municipios';
            $.get(host2, function (data) {
                listadoMunicipios = data;

                var html = '<select class="combobox form-control" name="cmbMunicipio_Particular" id="cmbMunicipio_Particular" title="Municipio">';
               var htmlFiscal = '<select class="combobox form-control" name="cmbMunicipio_Fiscal" id="cmbMunicipio_Fiscal" title="Municipio">';
               var htmlSucursal = '';

                    html        += '<option value="'+ 0 +'"> Seleccione</option>';
                    htmlFiscal  += '<option value="'+ 0 +'"> Seleccione</option>';

               data.forEach(function(value) {
                    html        += '<option value="'+ value.id +'">' + value.nombre + '</option>';
                    htmlFiscal  += '<option value="'+ value.id +'">' + value.nombre + '</option>';

                });
                html += '</select>';
                htmlFiscal += '</select>';

                $("#selectcmbMunicipio_Particular").html(html);
               $("#selectcmbMunicipio_Fiscal").html(htmlFiscal);

            });
        }

        function TRAM_AJX_CARGAR_ESTADOS(){
            var host2 =  '/registrar/estados';
            $.get(host2, function (data) {
                listadoEstados = data;

                var html = '<select class="combobox form-control" name="cmbEstado_Particular" id="cmbEstado_Particular" title="Estado">';
                var htmlFiscal = '<select class="combobox form-control" name="cmbEstado_Fiscal" id="cmbEstado_Fiscal" title="Estado">';

                    html        += '<option value="'+ 0 +'"> Seleccione</option>';
                    htmlFiscal  += '<option value="'+ 0 +'"> Seleccione</option>';

               data.forEach(function(value) {
                    html        += '<option value="'+ value.id +'">' + value.nombre + '</option>';
                    htmlFiscal  += '<option value="'+ value.id +'">' + value.nombre + '</option>';

                });
                html += '</select>';
                htmlFiscal += '</select>';

                $("#selectcmbEstado_Particular").html(html);
                $("#selectcmbEstado_Fiscal").html(htmlFiscal);

            });
        }

         function TRAM_AJX_CARGAR_PAISES(){

            var host2 = host + '/api/vw_accede_paises ';
            var paisDefault = 'México';
            $.get(host2, function (data) {

                var html = '<select class="combobox form-control" name="cmbPais_Particular" id="cmbPais_Particular"  title="País">';
                var htmlFiscal = '<select class="combobox form-control" name="cmbPais_Fiscal" id="cmbPais_Fiscal" title="País">';

                listadoPaises = data;

               if (data.length == 0){
                    html        += '<option value="'+ paisDefault +'">' + paisDefault + '</option>';
                    htmlFiscal  += '<option value="'+ paisDefault +'">' + paisDefault + '</option>';
               }else{
                    data.forEach(function(value) {
                        html        += '<option value="'+ value.DESCRIPCION +'">' + value.DESCRIPCION + '</option>';
                        htmlFiscal  += '<option value="'+ value.DESCRIPCION +'">' + value.DESCRIPCION + '</option>';

                    });
               }

                html += '</select>';
                htmlFiscal += '</select>';

                $("#selectcmbPais_Particular").html(html);
                $("#selectcmbPais_Fiscal").html(htmlFiscal);

            });
         }

        function TRAM_AJX_CARGAR_MUNICIPIOS_SUCURSAL(){

            var htmlSucursal = '';
            listadoMunicipios.forEach(function(value) {

                    htmlSucursal += '<option value="'+ value.id +'">' + value.nombre + '</option>';

                });

                $(".optionsMunicipioSucursal").append(htmlSucursal);
        }



        function TRAM_AJX_CARGAR_ESTADOS_SUCURSAL(){
            var host2 = host + '/api/Tramite/Estados';
           /* $.get(host2, function (data) {

                var htmlSucursal = '';
               data.forEach(function(value) {

                    htmlSucursal += '<option value="'+ value.NOMBRE +'">' + value.NOMBRE + '</option>';

                });

                $(".optionsEstadosSucursal").append(htmlSucursal);


            });*/
            var htmlSucursal = '';
            listadoEstados.forEach(function(value) {

                    htmlSucursal += '<option value="'+ value.id +'">' + value.nombre + '</option>';

                });

                $(".optionsEstadosSucursal").append(htmlSucursal);

        }

        function TRAM_AJX_CARGAR_PAISES_SUCURSAL(){
            var host2 = host + '/api/vw_accede_paises';
            var paisDefault = 'México';
            /*$.get(host2, function (data) {
                var htmlSucursal = '';

                if (data.length == 0){
                    htmlSucursal += '<option value="'+ paisDefault +'">' + paisDefault + '</option>';
                }else{
                    data.forEach(function(value) {
                        htmlSucursal += '<option value="'+ value.NOMBRE +'">' + value.NOMBRE + '</option>';
                     });
                }

                $(".optionsPaisesSucursal").append(htmlSucursal);
            });*/
            var htmlSucursal = '';
            if(listadoPaises.length == 0){
                htmlSucursal += '<option value="'+ paisDefault +'">' + paisDefault + '</option>';
            }else{
                listadoPaises.forEach(function(value) {
                        htmlSucursal += '<option value="'+ value.DESCRIPCION +'">' + value.DESCRIPCION + '</option>';
                     });
            }

            $(".optionsPaisesSucursal").append(htmlSucursal);

        }





        //TRAM_AJX_CARGAR_MUNICIPIOS_ESTADOS();
        //TRAM_AJX_CARGAR_ESTADOS();
       // TRAM_AJX_CARGAR_PAISES();

    </script>
    @yield('scripts')
</body>
</html>
