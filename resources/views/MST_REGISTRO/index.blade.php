<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/template/img/icon-edo.png') }}" rel="shortcut icon">
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
                                <img src="{{ asset('assets/template/img/logoGray.svg') }}" style="width: 70px;"  class="d-inline-block align-top" alt="">
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
                        <div class="row">
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
                                <br/>
                            </div>
                            <div class="col-md-8">
                            </div>
                        </div>
                        <div id="frmRegistro" style="display: none;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">RFC <span class="text-danger">*</span> <span class="text-primary" id="lblRfc">Se compone de 13 caracteres</span></label>
                                            <input type="text" class="form-control" id="txtRfc" name="txtRfc" placeholder="RFC" value="" required>
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
                                        <input type="text" class="form-control txtCurp" name="txtCurp" id="txtCurpFisica"
                                            placeholder="CURP">
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

                                <div class="col-md-4 divRazon_Social">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Razón Social <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="txtRazon_Social" id="txtRazon_Social"
                                            placeholder="Razón Social">
                                    </div>
                                </div>
                                <div class="col-md-4 divFechaConstitucionMoral">
                                    <div class="form-group" style="text-align: -webkit-center;">
                                        <br>
                                        <label for="bus-txt-centro-trabajo">Fecha de Constitución: </label>
                                        <input type="date" id="fechaConstitucionMoral" name="fechaConstitucionMoral" value="">
                                    </div>
                                </div>
                                
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
                                    <label for="bus-txt-centro-trabajo">Sexo <span class="text-danger">*</span> </label>
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
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 divCurpMoral">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">CURP <span class="text-danger">*</span>  <span class="text-primary">Se compone de 18 caracteres</span></label>
                                        <input type="text" class="form-control txtCurp" name="txtCurp" id="txtCurpMoral"
                                            placeholder="CURP">
                                        <span class="resultadoValidTextCurpMoral" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Nombre (s) <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="txtNombres" id="txtNombres" 
                                            placeholder="Nombre (s)" required >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Primer apellido <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="txtPrimer_Apellido" id="txtPrimer_Apellido"
                                            placeholder="Primer apellido" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Segundo apellido</label>
                                        <input type="text" class="form-control" name="txtSegundo_Apellido" id="txtSegundo_Apellido"
                                            placeholder="Segundo apellido">
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
                            
                            <!--
                            <div class="row divCurp_Moral">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">CURP <span class="text-danger asterisco" id="asterisco">*</span><span class="text-primary">Se compone de 18 caracteres</span></label>
                                        <input type="text" class="form-control txtCurp" name="txtCurp" id="txtCurpMoral"
                                            placeholder="CURP">
                                        <span class="resultadoValidTextCurp" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                                <div class="col-md-1 row align-items-center">
                                    <span class="circle-success iconCurp_Valido">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>-->

                            <!--
                            <div class="row divDomicilio_Particular">
                                <div class="col-md-12">
                                    <br/>
                                    <h5 class="font-weight-bold">Domicilio particular</h5>
                                    <br/>
                                </div>
                            </div>
                            
                            <div class="row divDomicilio_Particular">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmbPais_Particular">País <span class="text-danger">*</span> </label>
                                         <select class="combobox form-control" name="cmbPais_Particular"
                                            id="cmbPais_Particular"  title="País">
                                            <option value="">Seleccione...</option>
                                            <option>México</option>
                                        </select> 
                                       <!-  <div id="selectcmbPais_Particular"></div>---
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmbEstado_Particular">Estado <span class="text-danger">*</span> </label>
                                        <!- <select class="combobox form-control" name="cmbEstado_Particular"
                                            id="cmbEstado_Particular" title="Estado">
                                            <option value="">Seleccione...</option>
                                            <option>Chihuahua</option>
                                        </select> --
                                        <div id="selectcmbEstado_Particular"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmbMunicipio_Particular">Municipio <span class="text-danger">*</span> </label>
                                        <!-<select class="combobox form-control" name="cmbMunicipio_Particular"
                                            id="cmbMunicipio_Particular" title="Municipio">
                                            <option value="">Seleccione...</option>
                                            <option>Chihuahua</option>
                                            <option>Juárez</option>
                                        </select>--

                                        <div id="selectcmbMunicipio_Particular">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmbColonia_Particular">Colonia <span class="text-danger">*</span> </label>
                                        <select class="combobox form-control optionsColoniaParticular" name="cmbColonia_Particular"
                                            id="cmbColonia_Particular" title="Colonia">
                                            <<option value="">Seleccione...</option>
                                            <option>Zona Centro</option>
                               
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>

                            <br/>

                            <div class="row divDomicilio_Particular">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Calle <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="txtCalle_Particular" id="txtCalle_Particular"
                                            placeholder="Calle">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Número interior</label>
                                        <input type="number" class="form-control" name="txtNumero_Interior_Particular" id="txtNumero_Interior_Particular"
                                            placeholder="Número interior">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger">*</span> </label>
                                        <input type="number" class="form-control" name="txtNumero_Exterior_Particular" id="txtNumero_Exterior_Particular"
                                            placeholder="Número exterior">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger">*</span> </label>
                                        <input type="number" class="form-control" name="txtCP_Particular" id="txtCP_Particular"
                                            placeholder="C.P.">
                                    </div>
                                </div>
                            </div>

                            <br/>

                            <div class="row divDomicilio_Particular">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="chbDomicilio_Mismo" id="chbDomicilio_Mismo"
                                                value="1">
                                            <label class="form-check-label" for="chbDomicilio_Mismo"><span class="text-primary">¿El domicilio particular y el domicilio físcal es el mismo?</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                -->

                                <!--
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="font-weight-bold">Domicilio físcal</h5>
                                </div>
                            </div>
                            <br/>
                                    -->
                                                                
                                    <!--                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmbPais_Fiscal">País <span class="text-danger asterisco" id="asterisco">*</span></label>
                                        <select class="combobox form-control" name="cmbPais_Fiscal"
                                            id="cmbPais_Fiscal" title="País">
                                            <option value="">Seleccione...</option>
                                            <option>México</option>
                                        </select> 

                                       <!- <div id="selectcmbPais_Fiscal"></div>--
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmbEstado_Fiscal">Estado <span class="text-danger asterisco" id="asterisco">*</span></label>
                                        <!- <select class="combobox form-control" name="cmbEstado_Fiscal"
                                            id="cmbEstado_Fiscal" title="Estado">
                                            <option value="">Seleccione...</option>
                                            <option>Chihuahua</option>
                                        </select> --
                                        <div id="selectcmbEstado_Fiscal"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmbMunicipio_Fiscal">Municipio <span class="text-danger asterisco" id="asterisco">*</span></label>
                                        <!-<select class="combobox form-control" name="cmbMunicipio_Fiscal"
                                            id="cmbMunicipio_Fiscal" title="Municipio">
                                            <option value="">Seleccione...</option>
                                            <option>Chihuahua</option>
                                            <option>Juárez</option>
                                        </select>--
                                        <div id="selectcmbMunicipio_Fiscal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmbColonia_Fiscal">Colonia <span class="text-danger asterisco" id="asterisco">*</span></label>
                                        <select class="combobox form-control optionsColoniaFiscal" name="cmbColonia_Fiscal"
                                            id="cmbColonia_Fiscal" title="Colonia">
                                            <option value="">Seleccione...</option>
                                            <option>Zona Centro</option>
                                
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br/>
                                    -->
                                                                
                                    <!--
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Calle <span class="text-danger asterisco" id="asterisco">*</span> </label>
                                        <input type="text" class="form-control" name="txtCalle_Fiscal" id="txtCalle_Fiscal"
                                            placeholder="Calle">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Número interior</label>
                                        <input type="number" class="form-control" name="txtNumero_Interior_Fiscal" id="txtNumero_Interior_Fiscal"
                                            placeholder="Número interior">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger asterisco" id="asterisco">*</span></label>
                                        <input type="number" class="form-control" name="txtNumero_Exterior_Fiscal" id="txtNumero_Exterior_Fiscal"
                                            placeholder="Número exterior">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger asterisco" id="asterisco">*</span></label>
                                        <input type="number" class="form-control" name="txtCP_Fiscal" id="txtCP_Fiscal"
                                            placeholder="C.P.">
                                    </div>
                                </div>
                            </div>
                            <br/>
                                -->
                            
                                <!--
                            <div class="row">
                                <div class="col-md-12">
                                    <br/>
                                    <div class="repeater">
                                        <h5 class="font-weight-bold">Agregar sucursal <span class="circle" data-repeater-create>+</span></h5>
                                        <div data-repeater-list="lstSucursal">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="cmbPais_Sucursal">País</label>
                                                                    <select class="combobox form-control cmbPais_Sucursal optionsPaisesSucursal" name="cmbPais_Sucursal" title="País">
                                                                      <!- <option value="">Seleccione...</option>
                                                                        <option>México</option>  --
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="cmbEstado_Sucursal">Estado</label>
                                                                    <select class="combobox form-control cmbEstado_Sucursal optionsEstadosSucursal" name="cmbEstado_Sucursal" title="Estado">
                                                                        <!- <option value="">Seleccione...</option>
                                                                        <option>Chihuahua</option> --
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="cmbMunicipio_Sucursal">Municipio</label>
                                                                    <select class="combobox form-control cmbMunicipio_Sucursal optionsMunicipioSucursal" name="cmbMunicipio_Sucursal" title="Municipio">
                                                                        <!- <option value="">Seleccione...</option>
                                                                        <option>Chihuahua</option>
                                                                        <option>Juárez</option>
                                                                       --
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="cmbColonia_Sucursal">Colonia</label>
                                                                    <select class="combobox form-control cmbColonia_Sucursal optionscmbColonia_Sucursal" name="cmbColonia_Sucursal" title="Colonia">
                                                                        <option value="">Seleccione...</option>
                                                                        <option>Zona Centro</option>
                                                                  

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="bus-txt-centro-trabajo">Calle</label>
                                                                    <input type="text" class="form-control txtCalle_Sucursal" name="txtCalle_Sucursal"
                                                                        placeholder="Calle">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="bus-txt-centro-trabajo">Número interior</label>
                                                                    <input type="number" class="form-control txtNumero_Interior_Sucursal" name="txtNumero_Interior_Sucursal"
                                                                        placeholder="Número interior">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="bus-txt-centro-trabajo">Número exterior</label>
                                                                    <input type="number" class="form-control txtNumero_Exterior_Sucursal" name="txtNumero_Exterior_Sucursal"
                                                                        placeholder="Número exterior">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="bus-txt-centro-trabajo">C.P.</label>
                                                                    <input type="number" class="form-control txtCP_Sucursal" name="txtCP_Sucursal"
                                                                        placeholder="C.P.">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-1 row align-items-center">
                                                        <div class="text-right">
                                                            <span class="circle-error" data-repeater-delete>
                                                                x
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <hr/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                                        -->
                            
                            <h5 class="font-weight-bold">Datos de Contacto</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="txtCorreo_Electronico" id="txtCorreo_Electronico"
                                            placeholder="Correo electrónico" required>
                                        <span id="resultadoExistCorreo" style="font-size: 12px;"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Correo electrónico alternativo</label>
                                        <input type="email" class="form-control" name="txtCorreo_Alternativo" id="txtCorreo_Alternativo"
                                            placeholder="Correo electrónico alternativo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                            
                                    <label for="bus-txt-centro-trabajo">Teléfono <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="LOCAL"
                                                name="rdbTelefono" checked required>
                                            <label class="form-check-label">Local</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="CELULAR"
                                                name="rdbTelefono" required>
                                            <label class="form-check-label">Celular</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="tel" class="form-control" id="txtNumeroTelefono" name="txtNumeroTelefono" placeholder="999999999" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"  placeholder="No. de teléfono" required>
                                    </div>

                                </div>



                            </div>

                            <br>

                            <label for=""><b>Personas autorizadas para oír y recibir notificaciones</b></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="bus-txt-centro-trabajo">Nombre (s) <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="nombrePersonaAutorizada" name="nombrePersonaAutorizada" placeholder="Nombre (s)" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="bus-txt-centro-trabajo">Teléfono <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                    <input type="tel" class="form-control" id="telefonoPersonaAutorizada" name="telefonoPersonaAutorizada" placeholder="999999999" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"  placeholder="No. de teléfono" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="bus-txt-centro-trabajo">Correo <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="correoPersonaAutorizada" name="correoPersonaAutorizada" placeholder="Correo" required>
                                    </div>
                                </div>

                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Contraseña <span class="text-danger">*</span> <span class="text-primary">Debe tener mínimo 6 y máximo 20 caracteres</span></label>
                                        <input type="password" class="form-control" name="txtContrasenia" id="txtContrasenia"
                                            placeholder="Contraseña" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label for="bus-txt-centro-trabajo">Confirmar Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="txtContrasenia" id="txtContrasenia"
                                            placeholder="Vuelva a escribir la contraseña" required>
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
    <script src="{{ asset('assets/template/js/jquery.js') }}"></script>
    {{-- <script type="text/javascript" src="js/popper.min.js"></script> --}}
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
          
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.validator.addMethod("passwordcheck", function(value) {
                return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value)// has a special character
                },"La contraseña debe contener de 8 a 15 carácteres alfanuméricos (a-z A-Z), contener mínimo un dígito (0-9) y un carácter especial (_-=)."  
            );

            $.validator.addMethod("lettersonly", function(value, element)  {
return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "El nombre (s) solamente puede tener caracteres alfabéticos y espacios.");
    
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
                        lettersonly: true
                    },
                    txtPrimer_Apellido: {
                        minlength: 2,
                        maxlength: 100
                    },
                    txtSegundo_Apellido: {
                        minlength: 2,
                        maxlength: 100
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
                    txtCorreo_Electronico: {
                        email: true
                    },
                    txtCorreo_Alternativo: {
                        email: true
                    },
                    txtContrasenia: {
                        minlength: 6,
                        maxlength: 20,
                        passwordcheck:true
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
                        lettersonly: "El nombre (s) solamente puede tener caracteres alfabéticos y espacios."
                    },
                    txtPrimer_Apellido: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: ""
                    },
                    txtSegundo_Apellido: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: ""
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
                        email: "¡Error! El correo que se agregó no es válido, favor de verificar.",
                        required: ""
                    },
                    txtCorreo_Alternativo: {
                        email: "¡Error! El correo que se agregó no es válido, favor de verificar.",
                        required: ""
                    },
                    txtContrasenia: {
                        passwordcheck: "¡Error! La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
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
                    txtRazon_Social: {
                        required: ""
                    },
                    txtCurp: {
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
                       //console.log(name,value);
                        var resultado = name.split("]");
                        //console.log(resultado[0]+"]")
                       
                        TRAM_AJX_CARGAR_LOCALIDADES_SUCURSAL(value,resultado[0]+"]"+"[cmbColonia_Sucursal]");

                          
                    });

                    
                }
            });
    
            $("#frmRegistro").hide();
            $("#iconRfc_Valido").hide();
            $(".iconCurp_Valido").hide();
        });

    
    
        //Tipo de persona
        $('.rdbTipo_Persona').change(function(){
            var value = $( this ).val();
            $("#frmRegistro").show();
            if(value == "FISICA"){
                console.log('soy fisica');
                $(".divRazon_Social").hide();
                $(".divCurp").show();
                $("#divTxtRepresentante").hide();
                $(".divDomicilio_Particular").show();
                $(".divCurp_Moral").hide();
                $(".divCurpMoral").hide();

                $(".divFechaNacimiento").show();
                $(".divFechaConstitucionMoral").hide();

                $('#txtNombres').val('')
                $('#txtPrimer_Apellido').val('')
                $('#txtSegundo_Apellido').val('')
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
    
                $('#txtRazon_Social').prop('required',false);

                $('.asterisco').hide();
                $('#lblRfc').html("Se compone de 13 caracteres");
    
            }else {
                $(".divRazon_Social").show();
                $(".divCurp").hide();
                $("#divTxtRepresentante").show();
                $(".divDomicilio_Particular").hide();
                $(".divCurp_Moral").show();
                $(".divCurpMoral").show();
                
                $(".divFechaNacimiento").hide();
                $(".divFechaConstitucionMoral").show();
               
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
                $('#txtRazon_Social').prop('required',true);

                $('.asterisco').show();
                $('#lblRfc').html("Se compone de 12 caracteres");
            }
        });
    
        //RFC
        $('#txtRfc').change(function(){
            var value = $( this ).val();
            TRAM_FN_VALIDAR_INPUT_RFC(value);
            TRAM_AJX_VALIDAR_RFC(value);
        });
        
        //CURP
        $(".txtCurp").change(function(){
            var value = $( this ).val();
            var tipo = "FISICA";
            TRAM_FN_VALIDAR_INPUNT_CURP(value, tipo);
        });

        //Correo
        $('#txtCorreo_Electronico').change(function(){
            var value = $( this ).val();
            TRAM_AJX_VALIDAR_CORREO(value);
        });
        

        $('#txtCurpMoral').change(function(){
            var value = $( this ).val();
            var tipo = "MORAL";
            TRAM_FN_VALIDAR_INPUNT_CURP(value, tipo);
        });

        //Validar si el Curp existe
        function TRAM_AJX_VALIDAR_CURP(StrCurp){
            $.get('/registrar/validar_curp/' + StrCurp, function (data) {
                //Validamos si existe un usuario con el curp capturado
                console.log("Resultado: ", data);
                if(data != ''){
                    $('#txtNombres').val(data[0].USUA_CNOMBRES)
                    $('#txtPrimer_Apellido').val(data[0].USUA_CPRIMER_APELLIDO)
                    $('#txtSegundo_Apellido').val(data[0].USUA_CSEGUNDO_APELLIDO)
                }else {
                    $('#txtNombres').val('')
                    $('#txtPrimer_Apellido').val('')
                    $('#txtSegundo_Apellido').val('')
                    $(".resultadoValidTextCurpMoral").html("<span style='color: red;'>¡Error!</span> El Curp ingresado no cuenta con un registro actualmente, favor de intentar nuevamente..");
                }
            });
        };

        
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




       /* $('#selectcmbMunicipio_Particular').change(function(){
            var value = $("#selectcmbMunicipio_Particular option:selected" ).text();
            
            $('#cmbColonia_Particular').empty();   
            TRAM_AJX_CARGAR_LOCALIDADES(value);
           

        });*/


        /*$('#selectcmbEstado_Particular').change(function(){
            var value = $("#selectcmbEstado_Particular option:selected" ).val();
            
           $('#cmbMunicipio_Particular').empty();  

           console.log(value);
           TRAM_AJX_CARGAR_MUNICIPIOS_ESTADOS(value);
        });*/


        
        /*$('#selectcmbMunicipio_Fiscal').change(function(){           
            var value = $("#selectcmbMunicipio_Fiscal option:selected" ).text();    
            $('#cmbColonia_Fiscal').empty();
            TRAM_AJX_CARGAR_LOCALIDADES_FISCAL(value)
        });*/

       


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
                    var campo = $("#"+ value.element.id).attr('placeholder') == undefined ? $("#"+ value.element.id).attr('title') : $("#"+ value.element.id).attr('placeholder');
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
                                    text: data.message,
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
        function TRAM_FN_VALIDAR_INPUT_RFC (input) {
            //Validar valor
            if (input == null || input == undefined || input == "") {
                console.log('esta vacio');
            } else {
                var newValue = input;
                var rfc = newValue.trim().toUpperCase();
                var rfcCorrecto = TRAM_FN_VALIDAR_RFC(rfc);   // Acá se comprueba
                if (rfcCorrecto) {
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    $("#iconRfc_Valido").show();
                    $("#resultadoValidText").html("");
                } else {
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", true);
                    }, 1000);
                    $("#iconRfc_Valido").hide();
                    $("#resultadoValidText").html("<span style='color: red;'>¡Error!</span> El RFC no es válido, favor de verficar.");
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
                    console.log("La curp: " + curp + " no es valida, verifiqué ");
                    return false;
                }
    
                if (!(parseInt(digito) == parseInt(curp.substring(17, 18)))) {
                    console.log("La curp: " + curp + " no es valida, revisé el Digito Verificador (" + digito + ")");
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
        function TRAM_FN_VALIDAR_INPUNT_CURP
         (input, tipo) {
            var newValue = input;
            if (input == null || input == undefined || input == "") {
            } else {
                var curp = newValue.trim().toUpperCase();  
                if (TRAM_FN_VALIDAR_CURP(curp)) { // Acá se comprueba
                    if(tipo == "MORAL"){
                        TRAM_AJX_VALIDAR_CURP(curp)
                    }
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    $(".iconCurp_Valido").show();
                    $(".resultadoValidTextCurp").html("");
                    $(".resultadoValidTextCurpMoral").html("");
                } else {
                    $('#txtNombres').val('')
                    $('#txtPrimer_Apellido').val('')
                    $('#txtSegundo_Apellido').val('')
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    $(".iconCurp_Valido").hide();
                    if(tipo == "MORAL"){
                        $(".resultadoValidTextCurpMoral").html("<span style='color: red;'>¡Error!</span> El CURP no es válido, favor de verficar.");
                    }else{
                        $(".resultadoValidTextCurp").html("<span style='color: red;'>¡Error!</span> El CURP no es válido, favor de verficar.");
                    }
                }    
                $(".txtCurp").val(curp);
            }
        }
        
        //Validar si el rfc existe
        function TRAM_AJX_VALIDAR_RFC(StrRfc){
            $.get('/registrar/validar_rfc/' + StrRfc, function (data) {
                //Validamos si existe un usuario con el rfc capturado
                if(data.status == "success"){
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", true);
                    }, 1000);
                    $("#txtRfc").attr("aria-invalid", "true");
                    $("#txtRfc").addClass("error");
                    $("#resultadoExistRfc").html("<span style='color: red;'>"+ data.message +"</span>");
                }else {
                    $("#txtRfc").attr("aria-invalid", "false");
                    $("#txtRfc").removeClass("error");
                    $("#resultadoExistRfc").html("");
                }
            });
        };

        //Validar si el correo existe
        function TRAM_AJX_VALIDAR_CORREO(StrCorreo){
            $.get('/registrar/validar_correo/' + StrCorreo, function (data) {
                //Validamos si existe un usuario con el correo capturado
                if(data.status == "success"){
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", true);
                    }, 1000);
                    $("#txtRfc").attr("aria-invalid", "true");
                    $("#txtRfc").addClass("error");
                    $("#resultadoExistCorreo").html("<span style='color: red;'>"+ data.message +"</span>");
                }else {
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    $("#txtRfc").attr("aria-invalid", "false");
                    $("#txtRfc").removeClass("error");
                    $("#resultadoExistCorreo").html("");
                }
            });
        };


        var host = "https://retys-queretaro.azurewebsites.net";
        var listadoLocalidades     = [];
        //localidad y pais option manual html no tiene 


        function TRAM_AJX_CARGAR_LOCALIDADES(municipio){
            console.log("cargando las localidades");
            $.get('/registrar/localidades/'+municipio, function (data) {          
                var html = '';   
                data.forEach(function(value) {
                    html += '<option value="'+ value.NOMBRE +'">' + value.NOMBRE + '</option>';
                });

                $(".optionsColoniaParticular").append(html);
            });

        }


        function TRAM_AJX_CARGAR_LOCALIDADES_FISCAL(municipio){
            console.log("cargando las localidades");
            $.get('/registrar/localidades/'+municipio, function (data) {          
               
                var html = '';  
                data.forEach(function(value) {
                     html += '<option value="'+ value.NOMBRE +'">' + value.NOMBRE + '</option>';
                 });

                $(".optionsColoniaFiscal").append(html);
            });

        }


     


        function TRAM_AJX_CARGAR_LOCALIDADES_SUCURSAL(municipio,nombredata){
            console.log("localidadSucursal " + municipio);

          
            $.get('/registrar/localidades/'+municipio, function (data) {          

                    console.log(data);

                var html = '';   
                data.forEach(function(value) {
                    html += '<option value="'+ value.NOMBRE +'">' + value.NOMBRE + '</option>';
                });

                console.log("agregando aaaa------> " + nombredata);
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

       



        TRAM_AJX_CARGAR_MUNICIPIOS_ESTADOS();
        TRAM_AJX_CARGAR_ESTADOS();
       // TRAM_AJX_CARGAR_PAISES();
      
    </script>
    @yield('scripts')
</body>
</html>
