@extends('layout.Layout')

@section('body')
<div class="container-fluid">
    <br/>
    <div class="row">
        <div class="col-md-12">
        <h2>Mi Expediente</h2>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body text-body">
            <div class="row">
                <div class="col-md-12">

                <div>

                    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="infoPersonal-tab" data-toggle="tab" href="#infoPersonal" role="tab" aria-controls="infoPersonal" aria-selected="true">INFORMACIÓN PERSONAL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="predios-tab" data-toggle="tab" href="#predios" role="tab" aria-controls="predios" aria-selected="false">PREDIOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="documentos-tab" data-toggle="tab" href="#documentos" role="tab" aria-controls="documentos" aria-selected="false">DOCUMENTOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="resolutivos-tab" data-toggle="tab" href="#resolutivos" role="tab" aria-controls="resolutivos" aria-selected="false">RESOLUTIVOS</a>
                        </li>
                    </ul>
                    <br>
                    <form id="frmForm" name="form">
                        <div class="tab-content" id="myTabContent">
                            <!-- Div Informacion Personal -->
                            <div class="tab-pane fade show active" id="infoPersonal" role="tabpanel" aria-labelledby="infoPersonal-tab">

                                <div class="col-md-12">
                                    <div class="row justify-content-between">
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-sm white btn-warning" onclick="TRAM_FN_CONFIRMAR_PERFIL();">Cambiar contraseña</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="listError"></div>
                                    <div class="MensajeSuccess"></div>

                                    
                                        <input type="hidden" name="txtIdUsuario" value="{{$ObjAuth->USUA_NIDUSUARIO}}"/>
                                        <input type="hidden" name="rdbTipo_Persona" value="{{$ObjAuth->USUA_NTIPO_PERSONA}}"/>
                                        <div id="frmRegistro">
                                            <div class="row">
                                                <div class="col-md-6"><p class="text-dark" id="divTxtRepresentante"><b>Datos de persona moral</b></p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">RFC <span class="text-danger">*</span> <span class="text-primary">Se compone de 13 caracteres</span></label>
                                                    <input type="text" class="form-control" id="txtRfc" name="txtRfc" placeholder="RFC" value="{{$ObjAuth->USUA_CRFC}}" required disabled>
                                                            <span id="resultadoValidText" style="font-size: 12px;"></span>
                                                            <span id="resultadoExistRfc" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 divCurp">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">CURP<span class="text-danger">*</span><span class="text-primary">Se compone de 18 caracteres</span> <span>&nbsp;&nbsp; <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCurpFisica', 1);"></i></span></label>
                                                        <input type="text" class="form-control txtCurp" name="txtCurp" id="txtCurpFisica"
                                                            placeholder="CURP" value="{{$ObjAuth->USUA_CCURP}}" disabled>
                                                        <span class="resultadoValidTextCurp" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 divRazon_Social">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Razón Social <span class="text-danger">*</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtRazon_Social', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="txtRazon_Social" id="txtRazon_Social"
                                                            placeholder="Razón Social"  value="{{$ObjAuth->USUA_CRAZON_SOCIAL}}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-dark" id="divTxtRepresentante"><b>Datos del representante legal</b></p>
                                                    <label for="bus-txt-centro-trabajo">Sexo <span class="text-danger">*</span><i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('rdbSexo', 2);"></i></span></label>
                                                    <div class="form-group">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input rdbSexo" type="radio" value="F"
                                                                name="rdbSexo" {{$ObjAuth->USUA_NTIPO_SEXO == "F" ? "checked" : "" }} required disabled>
                                                            <label class="form-check-label">Mujer</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input rdbSexo" type="radio" value="M"
                                                                name="rdbSexo" {{$ObjAuth->USUA_NTIPO_SEXO == "M" ? "checked" : "" }} required disabled>
                                                            <label class="form-check-label">Hombre</label>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4">
                                                    <br>
                                                    <br>
                                                    <div class="row divCurp_Moral">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="bus-txt-centro-trabajo">CURP <span class="text-danger">*</span><span class="text-primary">Se compone de 18 caracteres</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCurpMoral', 1);"></i></span></label>
                                                                <input type="text" class="form-control txtCurp" name="txtCurp" id="txtCurpMoral"
                                                                placeholder="CURP" value="{{$ObjAuth->USUA_CCURP}}" disabled>
                                                                <span class="resultadoValidTextCurp" style="font-size: 12px;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Nombre (s) <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNombres', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="txtNombres" id="txtNombres"
                                                            placeholder="Nombre (s)" value="{{$ObjAuth->USUA_CNOMBRES}}" required disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Primer apellido <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtPrimer_Apellido', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="txtPrimer_Apellido" id="txtPrimer_Apellido"
                                                            placeholder="Primer apellido" value="{{$ObjAuth->USUA_CPRIMER_APELLIDO}}" required disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Segundo apellido <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtSegundo_Apellido', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="txtSegundo_Apellido" id="txtSegundo_Apellido"
                                                            placeholder="Segundo apellido" value="{{$ObjAuth->USUA_CSEGUNDO_APELLIDO}}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>

                                            <div class="row divFechaNacimiento">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Fecha de Nacimiento: <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('fechaNacimientoFisica', 1);"></i> </label>
                                                        <br>
                                                        <input type="date" id="fechaNacimientoFisica" name="fechaNacimientoFisica" value="{{$ObjAuth->USUA_DFECHA_NACIMIENTO}}" disabled>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="text-dark" id="divTxtRepresentante">Datos de contacto</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            
                                                            <div class="form-group">
                                                                <label for="bus-txt-centro-trabajo">Correo electronico <span class="text-danger">*</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCorreo', 1);"></i></span></label>
                                                                <input type="text" class="form-control" name="txtCorreo" id="txtCorreo"
                                                                    placeholder="ejemplo@correo.com" value="{{$ObjAuth->USUA_CCORREO_ELECTRONICO}}" disabled>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            
                                                            <div class="form-group">
                                                                <label for="bus-txt-centro-trabajo">Correo electronico alternativo <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCorreoAlternativo', 1);"></i></span></label>
                                                                <input type="text" class="form-control" name="txtCorreoAlternativo" id="txtCorreoAlternativo"
                                                                    placeholder="alternativo@correo.com" value="{{$ObjAuth->USUA_CCORREO_ALTERNATIVO}}" disabled>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                <label for="bus-txt-centro-trabajo">Teléfono<span class="text-danger">*</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('rdbTelefono', 2);"></i></span></label>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input rdbTelefono" type="radio" value="LOCAL"
                                                                    name="rdbTelefono" checked required disabled>
                                                                <label class="form-check-label">Local</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input rdbTelefono" type="radio" value="CELULAR"
                                                                    name="rdbTelefono" required disabled>
                                                                <label class="form-check-label">Celular</label>
                                                            </div>
                                                        </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control rdbTelefono" name="txtTelefono" id="txtTelefono"
                                                            placeholder="9999999999" value="{{$ObjAuth->USUA_NTELEFONO}}" disabled>
                                                    </div>
                                                </div>

                                            </div>

                                            <label for=""><b>Personas autorizadas para oír y recibir notificaciones</b></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="bus-txt-centro-trabajo">Nombre (s) <span class="text-danger">*</span> <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('nombrePersonaAutorizada', 1);"></i></label>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" id="nombrePersonaAutorizada" name="nombrePersonaAutorizada" value="{{$ObjAuth->USUA_CNOMBRE_NOTIFICACION}}" placeholder="Nombre (s)" required disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="bus-txt-centro-trabajo">Teléfono <span class="text-danger">*</span> <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('telefonoPersonaAutorizada', 1);"></i></label>
                                                    <div class="form-group">
                                                    <input type="tel" class="form-control" id="telefonoPersonaAutorizada" name="telefonoPersonaAutorizada" value="{{$ObjAuth->USUA_CTEL_CELULAR_NOTIFICACION}}" placeholder="999999999" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"  placeholder="No. de teléfono" required disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="bus-txt-centro-trabajo">Correo <span class="text-danger">*</span> <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('correoPersonaAutorizada', 1);"></i></label>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" id="correoPersonaAutorizada" name="correoPersonaAutorizada" value="{{$ObjAuth->USUA_CCORREO_NOTIFICACION}}" placeholder="Correo" required disabled>
                                                    </div>
                                                </div>

                                            </div>
                                            
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
                                                        <label for="bus-txt-centro-trabajo">Calle <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCalle_Particular', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="txtCalle_Particular" id="txtCalle_Particular"
                                                            placeholder="Calle" value="{{$ObjAuth->USUA_CCALLE_PARTICULAR}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Número interior <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNumero_Interior_Particular', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="txtNumero_Interior_Particular" id="txtNumero_Interior_Particular"
                                                            placeholder="Número interior" value="{{$ObjAuth->USUA_NNUMERO_INTERIOR_PARTICULAR}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger">*</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNumero_Exterior_Particular', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="txtNumero_Exterior_Particular" id="txtNumero_Exterior_Particular"
                                                            placeholder="Número exterior" value="{{$ObjAuth->USUA_NNUMERO_EXTERIOR_PARTICULAR}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCP_Particular', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="txtCP_Particular" id="txtCP_Particular"
                                                            placeholder="C.P." value="{{$ObjAuth->USUA_NCP_PARTICULAR}}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row divDomicilio_Particular">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbColonia_Particular">Colonia <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbColonia_Particular', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="cmbColonia_Particular"
                                                            id="cmbColonia_Particular" title="Colonia" value="{{$ObjAuth->USUA_CCOLONIA_PARTICULAR}}" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Zona Centro" {{$ObjAuth->USUA_CCOLONIA_PARTICULAR == "Zona Centro" ? "selected" : ""}}>Zona Centro</option>
                                                            <option value="San Pedro" {{$ObjAuth->USUA_CCOLONIA_PARTICULAR == "San Pedro" ? "selected" : ""}}>San Pedro</option>
                                                            <option value="Sector Bolívar" {{$ObjAuth->USUA_CCOLONIA_PARTICULAR == "Sector Bolívar" ? "selected" : ""}}>Sector Bolívar</option>
                                                            <option value="Nava" {{$ObjAuth->USUA_CCOLONIA_PARTICULAR == "Nava" ? "selected" : ""}}>Nava</option>
                                                            <option value="Nogales Norte" {{$ObjAuth->USUA_CCOLONIA_PARTICULAR == "Nogales Norte" ? "selected" : ""}}>Nogales Norte</option>
                                                            <option value="Pátzcuaro" {{$ObjAuth->USUA_CCOLONIA_PARTICULAR == "Pátzcuaro" ? "selected" : ""}}>Pátzcuaro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbMunicipio_Particular">Municipio <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbMunicipio_Particular', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="cmbMunicipio_Particular"
                                                            id="cmbMunicipio_Particular" title="Municipio" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Chihuahua" {{$ObjAuth->USUA_CMUNICIPIO_PARTICULAR == "Chihuahua" ? "selected" : ""}}>Chihuahua</option>
                                                            <option value="Juárez" {{$ObjAuth->USUA_CMUNICIPIO_PARTICULAR == "Juárez" ? "selected" : ""}}>Juárez</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbEstado_Particular">Estado <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbEstado_Particular', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="cmbEstado_Particular"
                                                            id="cmbEstado_Particular" title="Estado" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Chihuahua" {{$ObjAuth->USUA_CESTADO_PARTICULAR == "Chihuahua" ? "selected" : ""}}>Chihuahua</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbPais_Particular">País <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbPais_Particular', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="cmbPais_Particular"
                                                            id="cmbPais_Particular"  title="País" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="México" {{$ObjAuth->USUA_CPAIS_PARTICULAR == "México" ? "selected" : ""}}>México</option>
                                                        </select>
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
                                                        <!--
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br/>
                                                    <h5 class="font-weight-bold">Domicilio físcal</h5>
                                                </div>
                                            </div>
                                            <br/>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Calle <span class="text-danger asterisco" id="asterisco">*</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCalle_Fiscal', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="txtCalle_Fiscal" id="txtCalle_Fiscal"
                                                            placeholder="Calle" value="{{$ObjAuth->USUA_CCALLE}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Número interior <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNumero_Interior_Fiscal', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="txtNumero_Interior_Fiscal" id="txtNumero_Interior_Fiscal"
                                                            placeholder="Número interior" value="{{$ObjAuth->USUA_NNUMERO_INTERIOR}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNumero_Exterior_Fiscal', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="txtNumero_Exterior_Fiscal" id="txtNumero_Exterior_Fiscal" pattern="[0-9]+"
                                                            placeholder="Número exterior" value="{{$ObjAuth->USUA_NNUMERO_EXTERIOR}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCP_Fiscal', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="txtCP_Fiscal" id="txtCP_Fiscal"
                                                            placeholder="C.P." value="{{$ObjAuth->USUA_NCP}}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbColonia_Fiscal">Colonia <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbColonia_Fiscal', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="cmbColonia_Fiscal"
                                                            id="cmbColonia_Fiscal" title="Colonia" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Zona Centro" {{$ObjAuth->USUA_CCOLONIA == "Zona Centro" ? "selected" : ""}}>Zona Centro</option>
                                                            <option value="San Pedro" {{$ObjAuth->USUA_CCOLONIA == "San Pedro" ? "selected" : ""}}>San Pedro</option>
                                                            <option value="Sector Bolívar" {{$ObjAuth->USUA_CCOLONIA == "Sector Bolívar" ? "selected" : ""}}>Sector Bolívar</option>
                                                            <option value="Nava" {{$ObjAuth->USUA_CCOLONIA == "Nava" ? "selected" : ""}}>Nava</option>
                                                            <option value="Nogales Norte" {{$ObjAuth->USUA_CCOLONIA == "Nogales Norte" ? "selected" : ""}}>Nogales Norte</option>
                                                            <option value="Pátzcuaro" {{$ObjAuth->USUA_CCOLONIA == "Pátzcuaro" ? "selected" : ""}}>Pátzcuaro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbMunicipio_Fiscal">Municipio <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbMunicipio_Fiscal', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="cmbMunicipio_Fiscal"
                                                            id="cmbMunicipio_Fiscal" title="Municipio" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Chihuahua" {{$ObjAuth->USUA_CMUNICIPIO == "Chihuahua" ? "selected" : ""}}>Chihuahua</option>
                                                            <option value="Juárez" {{$ObjAuth->USUA_CMUNICIPIO == "Juárez" ? "selected" : ""}}>Juárez</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbEstado_Fiscal">Estado <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbEstado_Fiscal', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="cmbEstado_Fiscal"
                                                            id="cmbEstado_Fiscal" title="Estado" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Chihuahua" {{$ObjAuth->USUA_CESTADO == "Chihuahua" ? "selected" : ""}}>Chihuahua</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbPais_Fiscal">País <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbPais_Fiscal', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="cmbPais_Fiscal"
                                                            id="cmbPais_Fiscal" title="País" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="México" {{$ObjAuth->USUA_CPAIS == "México" ? "selected" : ""}}>México</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br/>
                                                    <div class="repeater">
                                                        <h5 class="font-weight-bold">Agregar sucursal <span class="circle" data-repeater-create>+</span></h5>
                                                        <div data-repeater-list="lstSucursal">
                                                            <?php $IntIndex = 0; ?>
                                                            @if(count($ObjAuth->TRAM_MDV_SUCURSAL) > 0)
                                                                @foreach($ObjAuth->TRAM_MDV_SUCURSAL as $item)
                                                                    <div data-repeater-item>
                                                                        <div class="row">
                                                                            <div class="col-md-11">
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Calle <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{$IntIndex}}_txtCalle_Sucursal', 1);"></i></span></label>
                                                                                            <input type="text" class="form-control txtCalle_Sucursal" name="txtCalle_Sucursal" id="{{$IntIndex}}_txtCalle_Sucursal"  placeholder="Calle" value="{{$item->SUCU_CCALLE}}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Número interior <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{$IntIndex}}_txtNumero_Interior_Sucursal', 1);"></i></span></label>
                                                                                            <input type="number" class="form-control txtNumero_Interior_Sucursal" name="txtNumero_Interior_Sucursal" id="{{$IntIndex}}_txtNumero_Interior_Sucursal"
                                                                                                placeholder="Número interior" value="{{$item->SUCU_NNUMERO_INTERIOR}}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{$IntIndex}}_txtNumero_Exterior_Sucursal', 1);"></i></span></label>
                                                                                            <input type="number" class="form-control txtNumero_Exterior_Sucursal" name="txtNumero_Exterior_Sucursal" id="{{$IntIndex}}_txtNumero_Exterior_Sucursal"
                                                                                                placeholder="Número exterior" value="{{$item->SUCU_NNUMERO_EXTERIOR}}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{$IntIndex}}_txtCP_Sucursal', 1);"></i></span></label>
                                                                                            <input type="number" class="form-control txtCP_Sucursal" name="txtCP_Sucursal" id="{{$IntIndex}}_txtCP_Sucursal"
                                                                                                placeholder="C.P." value="{{$item->SUCU_NCP}}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br/>
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbColonia_Sucursal">Colonia <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{$IntIndex}}_cmbColonia_Sucursal', 1);"></i></span></label>
                                                                                            <select class="combobox form-control cmbColonia_Sucursal" name="cmbColonia_Sucursal" id="{{$IntIndex}}_cmbColonia_Sucursal" title="Colonia" disabled>
                                                                                                <option value="">Seleccione...</option>
                                                                                                <option value="Zona Centro" {{$item->SUCU_CCOLONIA == "Zona Centro" ? "selected" : ""}}>Zona Centro</option>
                                                                                                <option value="San Pedro" {{$item->SUCU_CCOLONIA == "San Pedro" ? "selected" : ""}}>San Pedro</option>
                                                                                                <option value="Sector Bolívar" {{$item->SUCU_CCOLONIA == "Sector Bolívar" ? "selected" : ""}}>Sector Bolívar</option>
                                                                                                <option value="Nava" {{$item->SUCU_CCOLONIA == "Nava" ? "selected" : ""}}>Nava</option>
                                                                                                <option value="Nogales Norte" {{$item->SUCU_CCOLONIA == "Nogales Norte" ? "selected" : ""}}>Nogales Norte</option>
                                                                                                <option value="Pátzcuaro" {{$item->SUCU_CCOLONIA == "Pátzcuaro" ? "selected" : ""}}>Pátzcuaro</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbMunicipio_Sucursal">Municipio <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{$IntIndex}}_cmbMunicipio_Sucursal', 1);"></i></span></label>
                                                                                            <select class="combobox form-control cmbMunicipio_Sucursal" name="cmbMunicipio_Sucursal" id="{{$IntIndex}}_cmbMunicipio_Sucursal" title="Municipio" disabled>
                                                                                                <option value="">Seleccione...</option>
                                                                                                <option value="Chihuahua" {{$item->SUCU_CMUNICIPIO == "Chihuahua" ? "selected" : ""}}>Chihuahua</option>
                                                                                                <option value="Juárez" {{$item->SUCU_CMUNICIPIO == "Juárez" ? "selected" : ""}}>Juárez</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbEstado_Sucursal">Estado <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{$IntIndex}}_cmbEstado_Sucursal', 1);"></i></span></label>
                                                                                            <select class="combobox form-control cmbEstado_Sucursal" name="cmbEstado_Sucursal" id="{{$IntIndex}}_cmbEstado_Sucursal" title="Estado" disabled>
                                                                                                <option value="">Seleccione...</option>
                                                                                                <option value="Chihuahua" {{$item->SUCU_CESTADO == "Chihuahua" ? "selected" : ""}}>Chihuahua</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbPais_Sucursal">País <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{$IntIndex}}_cmbPais_Sucursal', 1);"></i></span></label>
                                                                                            <select class="combobox form-control cmbPais_Sucursal" name="cmbPais_Sucursal" id="{{$IntIndex}}_cmbPais_Sucursal" title="País" disabled>
                                                                                                <option value="">Seleccione...</option>
                                                                                                <option value="México" {{$item->SUCU_CPAIS == "México" ? "selected" : ""}}>México</option>
                                                                                            </select>
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
                                                                    <?php $IntIndex++; ?>
                                                                @endforeach
                                                            @else
                                                            <div data-repeater-item>
                                                                <div class="row">
                                                                    <div class="col-md-11">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="bus-txt-centro-trabajo">Calle <span class="text-danger" id="asterisco">*</span></label> 
                                                                                    <input type="text" class="form-control txtCalle_Sucursal" name="txtCalle_Sucursal" placeholder="Calle">
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
                                                                                    <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger" id="asterisco">*</span></label>
                                                                                    <input type="number" class="form-control txtNumero_Exterior_Sucursal" name="txtNumero_Exterior_Sucursal"
                                                                                        placeholder="Número exterior">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger" id="asterisco">*</span></label>
                                                                                    <input type="number" class="form-control txtCP_Sucursal" name="txtCP_Sucursal"
                                                                                        placeholder="C.P.">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br/>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="cmbColonia_Sucursal">Colonia <span class="text-danger" id="asterisco">*</span></label>
                                                                                    <select class="combobox form-control cmbColonia_Sucursal" name="cmbColonia_Sucursal" title="Colonia">
                                                                                        <option value="">Seleccione...</option>
                                                                                        <option value="Zona Centro">Zona Centro</option>
                                                                                        <option value="San Pedro">San Pedro</option>
                                                                                        <option value="Sector Bolívar">Sector Bolívar</option>
                                                                                        <option value="Nava">Nava</option>
                                                                                        <option value="Nogales Norte">Nogales Norte</option>
                                                                                        <option value="Pátzcuaro">Pátzcuaro</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="cmbMunicipio_Sucursal">Municipio <span class="text-danger" id="asterisco">*</span></label>
                                                                                    <select class="combobox form-control cmbMunicipio_Sucursal" name="cmbMunicipio_Sucursal" title="Municipio">
                                                                                        <option value="">Seleccione...</option>
                                                                                        <option value="Chihuahua">Chihuahua</option>
                                                                                        <option value="Juárez">Juárez</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="cmbEstado_Sucursal">Estado <span class="text-danger" id="asterisco">*</span></i></span></label>
                                                                                    <select class="combobox form-control cmbEstado_Sucursal" name="cmbEstado_Sucursal" title="Estado">
                                                                                        <option value="">Seleccione...</option>
                                                                                        <option value="Chihuahua">Chihuahua</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="cmbPais_Sucursal">País <span class="text-danger" id="asterisco">*</span></label>
                                                                                    <select class="combobox form-control cmbPais_Sucursal" name="cmbPais_Sucursal" title="País">
                                                                                        <option value="">Seleccione...</option>
                                                                                        <option value="México">México</option>
                                                                                    </select>
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
                                                            @endif 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br/>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Correo electrónico <span class="text-danger">*</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCorreo_Electronico', 1);"></i></span></label>
                                                        <input type="email" class="form-control" name="txtCorreo_Electronico" id="txtCorreo_Electronico"
                                                            placeholder="Correo electrónico" value="{{$ObjAuth->USUA_CCORREO_ELECTRONICO}}" required disabled>
                                                        <span id="resultadoExistCorreo" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Correo electrónico alternativo <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCorreo_Alternativo', 1);"></i></span></label>
                                                        <input type="email" class="form-control" name="txtCorreo_Alternativo" id="txtCorreo_Alternativo"
                                                            placeholder="Correo electrónico alternativo" value="{{$ObjAuth->USUA_CCORREO_ALTERNATIVO}}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                                -->
                                            <br/>
                                        </div>
                                    

                                </div>

                                <!-- Aqui termina -->
                            </div>
                            <!-- Div Predios-->
                            <div class="tab-pane fade" id="predios" role="tabpanel" aria-labelledby="predios-tab" >

                            <div class="card mt-3">
                                <div class="card-body text-body">

                                <div class="row justify-content-md-center">
                                        <div class="col-md-6">
                                            <dvi class="row">
                                                <div class="col-md-4">
                                                    <label for="">Ubicar predio por: </label>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="opcionPredio" id="predioDireccion" value="DIRECCION">
                                                        <label class="form-check-label" for="predioDireccion">Dirección</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="opcionPredio" id="predioFolio" value="FOLIO">
                                                        <label class="form-check-label" for="predioFolio">Folio</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="opcionPredio" id="predioTablaje" value="TABLAJE">
                                                        <label class="form-check-label" for="predioTablaje">Tablaje</label>
                                                    </div>
                                                </div>
                                            </dvi>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row justify-content-md-center">

                                        <div class="col-md-6">
                                            <form action="">
                                                <div class="row">
                                                        <div class="col-md-8" style="text-align: right;">
                                                            <input type="text" class="form-control" style="height: 38px;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="submit" class="btn btn-primary" value="Buscar">
                                                        </div> 
                                                </div>
                                            </form>
                                        </div>

                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Resultado de la búsqueda</h6>
                                        </div>
                                    </div>

                                    <div class="card mt-12">
                                        <div class="card-body text-body">
                                            <div class="row justify-content-md-center">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                            <div class="col-md-2" style="text-align: right;">Folio</div>
                                                            <div class="col-md-2">Dirección</div>
                                                            <div class="col-md-8"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2" style="text-align: right;">00000</div>
                                                        <div class="col-md-5"><label for="" >Lorem Ipsum is simply dummy text of the printing h</label></div>
                                                        <div class="col-md-3">
                                                            <select name="" id="" class="form-control">
                                                                <option value="" >Seleccione un tipo de predio</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-primary" style="height: 32px;font-size: inherit;">Añadir</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <!--Collapse-->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12" id="accordion">
                                                
                                            <div class="card">
                                                <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" id="domicilioP" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    Domicilio Particular
                                                    </button>
                                                </h5>
                                                </div>

                                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row justify-content-md-center">
                                                                    <div class="col-md-3">
                                                                        <label for="">Calle</label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtCalleParticular" name="txtCalleParticular" value="{{$ObjAuth->USUA_CCALLE_PARTICULAR}}" placeholder="21">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Número interior</label>
                                                                        <br>
                                                                        <input type="number" class="form-control" id="txtNumeroInteriorParticular" name="txtNumeroInteriorParticular" value="{{$ObjAuth->USUA_NNUMERO_INTERIOR_PARTICULAR}}" placeholder="Número interior">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Número exterior</label>
                                                                        <br>
                                                                        <input type="number" class="form-control" id="txtNumeroExteriorParticular" name="txtNumeroExteriorParticular" value="{{$ObjAuth->USUA_NNUMERO_EXTERIOR_PARTICULAR}}" placeholder="Número exterior">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">C.P.</label>
                                                                        <br>
                                                                        <input type="number" class="form-control" id="txtNumeroCPParticular" name="txtNumeroCPParticular" value="{{$ObjAuth->USUA_NCP_PARTICULAR}}" placeholder="97000">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row justify-content-md-center">
                                                                    <div class="col-md-3">
                                                                        <label for="">Colonia</label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtColoniaParticular" name="txtColoniaParticular" value="{{$ObjAuth->USUA_CCOLONIA_PARTICULAR}}" placeholder="Centro">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Municipio</label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtMunicipioParticular" name="txtMunicipioParticular" value="{{$ObjAuth->USUA_CMUNICIPIO_PARTICULAR}}" placeholder="Mérida">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Estado<nav></nav></label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtEstadoParticular" name="txtEstadoParticular" value="{{$ObjAuth->USUA_CESTADO_PARTICULAR}}" placeholder="Yucatán">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Pais</label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtPaisParticular" name="txtPaisParticular" value="{{$ObjAuth->USUA_CPAIS_PARTICULAR}}" placeholder="México">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br>

                                                    </div>
                                                </div>
                                            </div>

                                            <br>

                                            <div class="card">
                                                <div class="card-header" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Domicilio Fiscal
                                                    </button>
                                                </h5>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row justify-content-md-center">
                                                                    <div class="col-md-3">
                                                                        <label for="">Calle</label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtCalleFiscal" name="txtCalleFiscal" value="{{$ObjAuth->USUA_CCALLE}}" placeholder="21">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Número interior</label>
                                                                        <br> 
                                                                        <input type="number" class="form-control" id="txtNumeroInteriorFiscal" name="txtNumeroInteriorFiscal" value="{{$ObjAuth->USUA_NNUMERO_INTERIOR}}" placeholder="Número interior">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Número exterior</label>
                                                                        <br>
                                                                        <input type="number" class="form-control" id="txtNumeroExteriorFiscal" name="txtNumeroExteriorFiscal" value="{{$ObjAuth->USUA_NNUMERO_EXTERIOR}}" placeholder="Número exterior">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">C.P.</label>
                                                                        <br>
                                                                        <input type="number" class="form-control" id="txtCPFiscal" name="txtCPFiscal" value="{{$ObjAuth->USUA_NCP}}" placeholder="97000">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row justify-content-md-center">
                                                                    <div class="col-md-3">
                                                                        <label for="">Colonia</label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtColoniaFiscal" name="txtColoniaFiscal" value="{{$ObjAuth->USUA_CCOLONIA}}" placeholder="Centro">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Municipio</label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtMunicipioFiscal" name="txtMunicipioFiscal" value="{{$ObjAuth->USUA_CMUNICIPIO}}" placeholder="Mérida">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Estado<nav></nav></label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtEstadoFiscal" name="txtEstadoFiscal" value="{{$ObjAuth->USUA_CESTADO}}" placeholder="Yucatán">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Pais</label>
                                                                        <br>
                                                                        <input type="text" class="form-control" id="txtPaisFiscal" name="txtPaisFiscal" value="{{$ObjAuth->USUA_CPAIS}}" placeholder="México">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br>

                                                    </div>
                                                </div>
                                            </div>

                                            <br>

                                            <div class="card">
                                                <div class="card-header" id="headingThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Sucursales
                                                    </button>
                                                </h5>
                                                </div>
                                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                <div class="card-body">
                                                <div class="row">
                                                <div class="col-md-12">
                                                    <br/>
                                                    <div class="repeater">
                                                        <h5 class="font-weight-bold">Agregar sucursal <span class="circle" data-repeater-create>+</span></h5>
                                                        <div data-repeater-list="lstSucursal">
                                                            <?php $IntIndex = 0; ?>
                                                            @if(count($ObjAuth->TRAM_MDV_SUCURSAL) > 0)
                                                                @foreach($ObjAuth->TRAM_MDV_SUCURSAL as $item)
                                                                    <div data-repeater-item>
                                                                        <div class="row">
                                                                            <div class="col-md-11">
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Calle</label>
                                                                                            <input type="text" class="form-control txtCalle_Sucursal" name="txtCalle_Sucursal" id="{{$IntIndex}}_txtCalle_Sucursal"  placeholder="Calle" value="{{$item->SUCU_CCALLE}}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Número interior</label>
                                                                                            <input type="number" class="form-control txtNumero_Interior_Sucursal" name="txtNumero_Interior_Sucursal" id="{{$IntIndex}}_txtNumero_Interior_Sucursal"
                                                                                                placeholder="Número interior" value="{{$item->SUCU_NNUMERO_INTERIOR}}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Número exterior</label>
                                                                                            <input type="number" class="form-control txtNumero_Exterior_Sucursal" name="txtNumero_Exterior_Sucursal" id="{{$IntIndex}}_txtNumero_Exterior_Sucursal"
                                                                                                placeholder="Número exterior" value="{{$item->SUCU_NNUMERO_EXTERIOR}}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">C.P.</label>
                                                                                            <input type="number" class="form-control txtCP_Sucursal" name="txtCP_Sucursal" id="{{$IntIndex}}_txtCP_Sucursal"
                                                                                                placeholder="C.P." value="{{$item->SUCU_NCP}}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br/>
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbColonia_Sucursal">Colonia </label>
                                                                                            <input type="text" class="form-control cmbColonia_Sucursal" name="cmbColonia_Sucursal" id="{{$IntIndex}}_cmbColonia_Sucursal"
                                                                                                placeholder="Centro" value="{{$item->SUCU_CCOLONIA}}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbMunicipio_Sucursal">Municipio </label>
                                                                                            <input type="text" class="form-control cmbMunicipio_Sucursal" name="cmbMunicipio_Sucursal" id="{{$IntIndex}}_cmbMunicipio_Sucursal"
                                                                                                placeholder="Mérida" value="{{$item->SUCU_CMUNICIPIO}}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbEstado_Sucursal">Estado</label>
                                                                                            <input type="text" class="form-control cmbEstado_Sucursal" name="cmbEstado_Sucursal" id="{{$IntIndex}}_cmbEstado_Sucursal"
                                                                                                placeholder="Yucatán" value="{{$item->SUCU_CESTADO}}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbPais_Sucursal">País </label>
                                                                                            <input type="text" class="form-control cmbPais_Sucursal" name="cmbPais_Sucursal" id="{{$IntIndex}}_cmbPais_Sucursal"
                                                                                                placeholder="México" value="{{$item->SUCU_CPAIS}}">
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
                                                                    <?php $IntIndex++; ?>
                                                                @endforeach
                                                            @else
                                                            <div data-repeater-item>
                                                                        <div class="row">
                                                                            <div class="col-md-11">
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Calle</label>
                                                                                            <input type="text" class="form-control txtCalle_Sucursal" name="txtCalle_Sucursal" id="txtCalle_Sucursal"  placeholder="Calle" value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Número interior</label>
                                                                                            <input type="number" class="form-control txtNumero_Interior_Sucursal" name="txtNumero_Interior_Sucursal" id="txtNumero_Interior_Sucursal"
                                                                                                placeholder="Número interior" value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">Número exterior</label>
                                                                                            <input type="number" class="form-control txtNumero_Exterior_Sucursal" name="txtNumero_Exterior_Sucursal" id="txtNumero_Exterior_Sucursal"
                                                                                                placeholder="Número exterior" value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="bus-txt-centro-trabajo">C.P.</label>
                                                                                            <input type="number" class="form-control txtCP_Sucursal" name="txtCP_Sucursal" id="txtCP_Sucursal"
                                                                                                placeholder="C.P." value="">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br/>
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbColonia_Sucursal">Colonia </label>
                                                                                            <input type="text" class="form-control cmbColonia_Sucursal" name="cmbColonia_Sucursal" id="cmbColonia_Sucursal"
                                                                                                placeholder="Centro" value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbMunicipio_Sucursal">Municipio </label>
                                                                                            <input type="text" class="form-control cmbMunicipio_Sucursal" name="cmbMunicipio_Sucursal" id="cmbMunicipio_Sucursal"
                                                                                                placeholder="Mérida" value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbEstado_Sucursal">Estado</label>
                                                                                            <input type="text" class="form-control cmbEstado_Sucursal" name="cmbEstado_Sucursal" id="cmbEstado_Sucursal"
                                                                                                placeholder="Yucatán" value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="cmbPais_Sucursal">País </label>
                                                                                            <input type="text" class="form-control cmbPais_Sucursal" name="cmbPais_Sucursal" id="cmbPais_Sucursal"
                                                                                                placeholder="México" value="">
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
                                                                    <?php $IntIndex++; ?>
                                                            @endif 
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

                                </div>
                                </div>
                            </div>

                            <!-- Div Documentos -->
                            <div class="tab-pane fade" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">
                                <div class="col-md-12">
                                    <div class="row">
                                    <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                <th scope="col">Existente</th>
                                                <th scope="col"></th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Tamaño</th>
                                                <th scope="col">Estatus</th>
                                                <th scope="col">Vigencia Inicio</th>
                                                <th scope="col">Vigencia Fin</th>
                                                <th scope="col">#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ObjAuth['documentosExpedienteUser'] as $resultDocs)
                                                    <tr>
                                                        <td><input type="checkbox"></td>
                                                        <td>
                                                            @if($resultDocs->FORMATO != null)
                                                                @switch($resultDocs->FORMATO)
                                                                    @case('pdf')
                                                                    <i class="fa-solid fa-file-pdf" style="color:red"></i>
                                                                    @break

                                                                    @default
                                                                    <i class="fa-solid fa-file-lines" style="color:deepskyblue"></i>
                                                                    @break
                                                                @endswitch
                                                                
                                                            @else
                                                            <i class="fa-solid fa-file-circle-plus" style="color:deepskyblue"></i>
                                                            @endif
                                                        </td>
                                                        <td>{{$resultDocs->NOMBRE}}</td>
                                                        <td>@if($resultDocs->PESO != null)
                                                                {{$resultDocs->PESO}}
                                                            @else
                                                                0 KB
                                                            @endif
                                                        </td>
                                                        <td>@if($resultDocs->PESO != null)
                                                                Pendiente
                                                            @else
                                                                <input type="file">
                                                            @endif</td>
                                                        <td>@if($resultDocs->VIGENCIA_INICIO != null)
                                                                {{$resultDocs->VIGENCIA_INICIO}}
                                                            @else
                                                                ---
                                                            @endif</td>
                                                        <td>@if($resultDocs->VIGENCIA_FIN != null)
                                                                <?php
                                                                    $date_now = date("Y-m-d"); // this format is string comparable
                                                                    if ($date_now > $resultDocs->VIGENCIA_FIN) {
                                                                        echo $resultDocs->VIGENCIA_FIN.' <i class="fa-solid fa-triangle-exclamation" style="color: orange;"></i>';
                                                                    }else{
                                                                        echo $resultDocs->VIGENCIA_FIN.' <i class="fa-solid fa-circle-check" style="color: green;"></i>';
                                                                    }
                                                                ?>
                                                            @else
                                                                ---
                                                            @endif</td>
                                                        <td><i class="fa-solid fa-circle-xmark" style="color:red;"></i></td>
                                                    </tr>
                                                @endforeach                                 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Div Resolutivos -->
                            <div class="tab-pane fade" id="resolutivos" role="tabpanel" aria-labelledby="resolutivos-tab">

                                <div class="col-md-12">
                                        <div class="row">
                                        <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">OTORGADO EL</th>
                                                    <th scope="col">NOMBRE</th>
                                                    <th scope="col">TAMAÑO</th>
                                                    <th scope="col">VENCE EL</th>
                                                    <th scope="col">ESTATUS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <th>30/09/21</th>
                                                    <td><i class="fa-solid fa-file-pdf" style="color: red;"></i>LICENCIA DE FUN...</td>
                                                    <td>1.3 MB</td>
                                                    <td>30/09/21</td>
                                                    <td style="color: orange;">VENCIDO <i class="fa-solid fa-triangle-exclamation"></i></td>
                                                    </tr>

                                                    <tr>
                                                    <th>30/09/21</th>
                                                    <td><i class="fa-solid fa-file-pdf" style="color: red;"></i>LICENCIA DE CONS...</td>
                                                    <td>78 KB</td>
                                                    <td>30/09/21</td>
                                                    <td style="color: green;">VIGENTE <i class="fa-solid fa-circle-check"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
                    <!--                
                                
                    -->
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <div class="col-md-12 text-right">
            <button class="btn btn-primary btnSubmit" id="btnSubmit" onclick="TRAM_AJX_GUARDAR();">Guardar</button>
            <button class="btn btn-danger">Cerrar</button>
        </div>
    </div>
    <br/>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalConfirmarCuenta" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ModalConfirmarCuenta" aria-hidden="true">
    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-radius-6">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="listErrorConfirmarCuenta"></div>
                        <form id="frmFormConfirmar_Cuenta" name="frmFormConfirmar_Cuenta">
                            <div class="form-group">
                                <label id="ciudadano">RFC o Correo electrónico <span class="text-danger">*</span></label>
                                <label id="servidor">Correo electrónico o Usuario <span class="text-danger">*</span></label>
                             
                                <input type="text" class="form-control" name="txtCorreo_RFC_Electronico" id="txtCorreo_RFC_Electronico"
                                    placeholder="RFC o Correo electrónico" required>



                                <span class="resultadoValidText" style="font-size: 12px;"></span>
                            </div>
                            <div class="form-group">
                                <label>Contraseña actual <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="txtContrasena_Actual" id="txtContrasena_Actual"
                                    placeholder="Contraseña actual" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-between">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary" id="btnSubmitConfirmaCuenta" onclick="TRAM_AJX_CONFIRMAR_PERFIL();">Aceptar</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ModalCambiarContrasena -->
<div class="modal fade" id="ModalCambiarContrasena" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ModalCambiarContrasena" aria-hidden="true">
    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-radius-6">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="listErrorCambiarContrasena"></div>
                        <p class="m-0">Completa el formulario para realizar el cambio de contraseña.</p>
                        <form id="frmFormCmabiar_Contrasena" name="frmFormCmabiar_Contrasena">
                            <input type="hidden" name="txtIntIdUsuario" value="{{$ObjAuth->USUA_NIDUSUARIO}}">
                            <input type="hidden" name="txtIntTipo" value="1">
                            <div class="form-group">
                                <label>Ingresa nueva contraseña</label>
                                <input type="password" class="form-control" name="txtContrasena_Nueva" id="txtContrasena_Nueva"
                                    placeholder="Nueva contraseña" required>
                            </div>
                            <div class="form-group">
                                <label>Repetir contraseña</label>
                                <input type="password" class="form-control" name="txtConformacion_Contrasena" id="txtConformacion_Contrasena"
                                    placeholder="Contraseña actual" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-between">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary" id="btnSubmitConfirmaCuenta" onclick="TRAM_AJX_CAMBIAR_CONTRASENA();">Aceptar</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    function GET_VISTA_PREDIOS(){
        var settings = {
                "url": "http://pruebasws.merida.gob.mx:8080/wsducat/api/WSDUWEB/html/consultaPredios/LC",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "token": "EAAAAPUuUDk5VgdJxOdRW8lxRqAs/9hBNo50msZWXsTFkcBg/o9Wzt02o6mt73PSucp59hbtfc2sSOl1QdYnmyk8so/IkpOu3SG1x4yhzmgQ1/EuKs2N3lOy0sRHaFp+vbdGXieEnIPg4tz6t4vTmpBosTuqq//OyWxuZAK31YcipgE/7b7W7DXBnzbuAgvalAbFfQ==",
                    "X-Forwarded-For": "192.168.0.108",
                    "Cookie": "cookiesession1=678A8C31542C3AB6E98C83CF462E0302"
                },
                };

                $.ajax(settings).done(function (response) {
                    $('#divPredios').html(response)
                });

        }   

    $(document).ready(function () {
        var StrTipoPersona = '{{ $ObjAuth->USUA_NTIPO_PERSONA }}';
        var BolSucursal = '{{ count($ObjAuth->TRAM_MDV_SUCURSAL) > 0 ? false : true }}';
        var rolCat = '{{$ObjAuth->TRAM_CAT_ROL->ROL_CCLAVE}}';
        GET_VISTA_PREDIOS()

        $('#frmForm').on('submit', function(e){
            e.preventDefault()
        })

        
        console.log(rolCat);
   

        if(StrTipoPersona == "FISICA"){
            $('.asterisco').hide();
        }else{
            $('.asterisco').show();
        }

       if(rolCat=="CDNS"){
            // es un ciudadano
            $('#ciudadano').show();
            $('#servidor').hide();

            $("#txtCorreo_RFC_Electronico").attr("placeholder", "RFC o Correo electrónico");
       }else{
            $('#ciudadano').hide();
            $('#servidor').show();

            $("#txtCorreo_RFC_Electronico").attr("placeholder", "Correo electrónico o Usuario");
       }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.validator.addMethod("passwordcheck", function(value) {
            return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value)// has a special character
            },"La contraseña debe contener de 8 a 15 carácteres alfanuméricos (a-z A-Z), contener mínimo un dígito (0-9) y un carácter especial (_-=)."  
        );

        $.validator.addMethod( 'passwordMatch', function(value, element) {
            var password = $("#txtContrasena_Nueva").val();
            var confirmPassword = $("#txtConformacion_Contrasena").val();
            if (password != confirmPassword ) {
                return false;
            } else {
                return true;
            }
        });

        $.validator.addMethod("lettersonly", function(value, element)  {
                return this.optional(element) || /^[a-z\s]+$/i.test(value);
            }, "El nombre (s) solamente puede tener caracteres alfabéticos y espacios."
        );

       
                
        $("#frmFormCmabiar_Contrasena").validate({
            focusInvalid: false,
            invalidHandler: function() {
                $(this).find(":input.error:first").focus();
            },
            rules: {
                txtContrasena_Nueva: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck:true
                },
                txtConformacion_Contrasena: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck:true,
                    passwordMatch: true
                }
            },
            messages: {
                txtContrasena_Nueva: {
                    passwordcheck: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    minlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    maxlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    required: ""
                },
                txtConformacion_Contrasena: {
                    passwordcheck: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    minlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    maxlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    passwordMatch: "La contraseña no coincide, favor de verificar.",
                    required: ""
                }
            }
        });

    


        //Validate form confirmar cuenta
        $("#frmFormConfirmar_Cuenta").validate({
            focusInvalid: false,
            invalidHandler: function() {
                $(this).find(":input.error:first").focus();
            },
            rules: {
                txtContrasena_Actual: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck:true
                }
            },
            messages: {
                txtCorreo_RFC_Electronico: {
                    required: ""
                },
                txtContrasena_Actual: {
                    passwordcheck: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    minlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    maxlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    required: ""
                }
            }
        });

        var invalidChars = [
  "-",
  "+",
  "e",
];

        //para personas morales
        $( "#txtNumero_Exterior_Fiscal" ).keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });


        $( "#txtNumero_Interior_Fiscal" ).keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });

        $("#txtCP_Fiscal" ).keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });


        //para personas fisicas
        $( "#txtNumero_Interior_Particular" ).keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });


        $( "#txtNumero_Exterior_Particular" ).keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });

        $("#txtCP_Particular" ).keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });


        $("#txtNombres").keypress(function(event) {
            var inputValue = event.charCode;
            console.log("chispas");
            if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
                event.preventDefault();
            }
        });


      
        
        //Validate form registro
        $("#frmForm").validate({
            focusInvalid: false,
            invalidHandler: function() {
                $(this).find(":input.error:first").focus();
            },
            rules: {
                txtRfc: {
                        minlength: 13,
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
                txtCalleParticular: {
                    minlength: 2,
                    maxlength: 100
                },
                txtCalleFiscal: {
                    minlength: 2,
                    maxlength: 100
                },
                txtNumeroInteriorParticular: {
                    minlength: 1,
                    maxlength: 10
                },
                txtNumeroExteriorParticular: {
                    minlength: 1,
                    maxlength: 10
                },
                txtNumeroInteriorFiscal: {
                    minlength: 1,
                    maxlength: 10
             
              
                },
                txtNumeroExteriorFiscal: {
                    minlength: 1,
                    maxlength: 10
                
                },
                txtCPParticular: {
                    minlength: 5,
                    maxlength: 5
                },
                txtCPFiscal: {
                    minlength: 5,
                    maxlength: 5
                },
                txtCorreo_Electronico: {
                    email: true
                },
                txtCorreo_Alternativo: {
                    email: true
                }
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
                txtCalleParticular: {
                    minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    required: ""
                },
                txtCalleFiscal: {
                    minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    required: ""
                },
                txtNumeroInteriorParticular: {
                    minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                    maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                    required: ""
                },
                txtNumeroExteriorParticular: {
                    minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                    maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                    required: ""
                },
                txtNumeroInteriorFiscal: {
                    minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                    maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                    required: ""
                },
                txtNumeroExteriorFiscal: {
                    minlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                    maxlength: "El tamaño campo no puede ser menor de 1 carácter ni mayor de 10 caracteres.",
                    required: ""
                },
                txtCPParticular: {
                    minlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                    maxlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                    required: ""
                },
                txtCPFiscal: {
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
                cmbColoniaParticular: {
                    required: ""
                },
                cmbMunicipioParticular: {
                    required: ""
                },
                cmbEstadoParticular: {
                    required: ""
                },
                cmbPaisParticular: {
                    required: ""
                },
                cmbColoniaFiscal: {
                    required: ""
                },
                cmbMunicipioFiscal: {
                    required: ""
                },
                cmbEstadoFiscal: {
                    required: ""
                },
                cmbPaisFiscal: {
                    required: ""
                }
            }
        });

        setTimeout(function(){
            $(".txtCalle_Sucursal").each(function() {
                $(this).rules('add', {
                    required: true,
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
                    required: true,
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
                    required: true,
                    minlength: 5,
                    maxlength: 5,
                    messages: {
                        required: "",
                        minlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                        maxlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                    }
                });
            });
        }, 1000);
            
        $('.repeater').repeater({
            initEmpty: BolSucursal,
            show: function (item) {
                $(this).slideDown();
                $(this).attr('id', 'item_sucursal_' + $(this).index());

                $( "input[name='lstSucursal["+$(this).index()+"][txtCalle_Sucursal]']" ).prop("disabled", false);
                $( "input[name='lstSucursal["+$(this).index()+"][txtNumero_Interior_Sucursal]']" ).prop("disabled", false);
                $( "input[name='lstSucursal["+$(this).index()+"][txtNumero_Exterior_Sucursal]']" ).prop("disabled", false);
                $( "input[name='lstSucursal["+$(this).index()+"][txtCP_Sucursal]']" ).prop("disabled", false);
                $( "select[name='lstSucursal["+$(this).index()+"][cmbColonia_Sucursal]']" ).prop("disabled", false);
                $( "select[name='lstSucursal["+$(this).index()+"][cmbMunicipio_Sucursal]']" ).prop("disabled", false);
                $( "select[name='lstSucursal["+$(this).index()+"][cmbEstado_Sucursal]']" ).prop("disabled", false);
                $( "select[name='lstSucursal["+$(this).index()+"][cmbPais_Sucursal]']" ).prop("disabled", false);
                $("#item_sucursal_" + $(this).index()).find($( "input[name='lstSucursal["+$(this).index()+"][txtCalle_Sucursal]']" )).attr('id', $(this).index() +'_txtCalle_Sucursal');
                $("#item_sucursal_" + $(this).index()).find($( "input[name='lstSucursal["+$(this).index()+"][txtNumero_Interior_Sucursal]']" )).attr('id', $(this).index() +'_txtNumero_Interior_Sucursal');
                $("#item_sucursal_" + $(this).index()).find($( "input[name='lstSucursal["+$(this).index()+"][txtNumero_Exterior_Sucursal]']" )).attr('id', $(this).index() +'_txtNumero_Exterior_Sucursal');
                $("#item_sucursal_" + $(this).index()).find($( "input[name='lstSucursal["+$(this).index()+"][txtCP_Sucursal]']" )).attr('id', $(this).index() +'_txtCP_Sucursal');
                $("#item_sucursal_" + $(this).index()).find($( "select[name='lstSucursal["+$(this).index()+"][cmbColonia_Sucursal]']" )).attr('id', $(this).index() +'_cmbColonia_Sucursal');
                $("#item_sucursal_" + $(this).index()).find($( "select[name='lstSucursal["+$(this).index()+"][cmbMunicipio_Sucursal]']" )).attr('id', $(this).index() +'_cmbMunicipio_Sucursal');
                $("#item_sucursal_" + $(this).index()).find($( "select[name='lstSucursal["+$(this).index()+"][cmbEstado_Sucursal]']" )).attr('id', $(this).index() +'_cmbEstado_Sucursal');
                $("#item_sucursal_" + $(this).index()).find($( "select[name='lstSucursal["+$(this).index()+"][cmbPais_Sucursal]']" )).attr('id', $(this).index() +'_cmbPais_Sucursal');
                $("#item_sucursal_" + $(this).index()).find(".icon-edit").hide();

                var numinterir =  $(this).index()+"_txtNumero_Interior_Sucursal";
                var numexterior =  $(this).index()+"_txtNumero_Exterior_Sucursal";
                var cpsucu      =  $(this).index()+"_txtCP_Sucursal";

                $("#"+numinterir).keydown(function(e) {
                    if (invalidChars.includes(e.key)) {
                        e.preventDefault();
                    }
                });


                $("#"+numexterior).keydown(function(e) {
                    if (invalidChars.includes(e.key)) {
                        e.preventDefault();
                    }
                });


                $("#"+cpsucu).keydown(function(e) {
                    if (invalidChars.includes(e.key)) {
                        e.preventDefault();
                    }
                });

                setTimeout(function(){
                    $(".txtCalle_Sucursal").each(function() {
                        $(this).rules('add', {
                            required: true,
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
                            required: true,
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
                            required: true,
                            minlength: 5,
                            maxlength: 5,
                            messages: {
                                required: "",
                                minlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                                maxlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                            }
                        });
                    });
                }, 1000);
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: '¡Confirmar!',
                    text: "¿Desea eliminar la información?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).slideUp(deleteElement);
                    }
                });
            }
        });

        //Tipo de persona
        if(StrTipoPersona == "FISICA"){
            $(".divRazon_Social").hide();
            $(".divCurp").show();
            $("#divTxtRepresentante").hide();
            $(".divDomicilio_Particular").hide();
            $(".divCurp_Moral").hide();

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

        }else {
            $(".divRazon_Social").show();
            $(".divCurp").hide();
            $("#divTxtRepresentante").show();
            $(".divDomicilio_Particular").hide();
            $(".divCurp_Moral").show();

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
        }

        //RFC
        $('#txtRfc').change(function(){
            var value = $( this ).val();
            TRAM_FN_VALIDAR_INPUT_RFC(value);
            TRAM_AJX_VALIDAR_RFC(value);
        });
        
        //CURP
        $(".txtCurp").change(function(){
            var value = $( this ).val();
            TRAM_FN_VALIDAR_INPUNT_CURP(value);
        });

        //Correo
        $('#txtCorreo_Electronico').change(function(){
            var value = $( this ).val();
            TRAM_AJX_VALIDAR_CORREO(value);

            console.log("ejecutando");
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

        //Correo
        $('#txtCorreo_RFC_Electronico').change(function(){
            var value = $( this ).val();

            if(rolCat=="CDNS"){
                

                if(TRAM_FN_VALIDA_CORREO(value)){
                    $(".resultadoValidText").html("");
                    $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                    $("#frmFormConfirmar_Cuenta").validate({
                        focusInvalid: false,
                        invalidHandler: function() {
                            $(this).find(":input.error:first").focus();
                        },
                        rules: {
                            txtCorreo_RFC_Electronico: {
                                email: true
                            }
                        },
                        messages: {
                            txtCorreo_RFC_Electronico: {
                                email: "¡Error! El correo que se agregó no es válido, favor de verificar.",
                                required: ""
                            },
                        }
                    });
                }else {
                    TRAM_FN_VALIDAR_INPUT_RFC_RECUPERAR_CONTRASENA(value);
                }

            }
        });
    });

    //Validar correo valido
    function TRAM_FN_VALIDA_CORREO(value) {
        var emailValue = value;
        var isEmailValid = false;
        var reg = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
        
        if (reg.test(emailValue)) {
            isEmailValid = true;
        } else {
            isEmailValid = false;
        }

        return isEmailValid;
    };
    
    //Deshabilita/Habilita
    function TRAM_FN_ENABLE(StrInput, IntTipo){
        var StrIdentificador = IntTipo == 1 ? "#" : ".";
        if($(StrIdentificador + StrInput).is(':disabled')){
            $(StrIdentificador + StrInput).prop("disabled", false);
        }else{
            $(StrIdentificador + StrInput).prop("disabled", true);
        }
    };

    function TRAM_FN_DISABLED_INPUT(){
        $("input").each(function() {
            $(this).attr("disabled", true);
        });
        $("select").each(function() {
            $(this).attr("disabled", true);
        });
    };
    
    function TRAM_FN_ENABLED_INPUT(){
        $("input").each(function() {
            $(this).removeAttr('disabled');
        });
        $("select").each(function() {
            $(this).removeAttr('disabled');
        });
    };

    function TRAM_AJX_GUARDAR(){
        $("#btnSubmit").prop("disabled", true);
        TRAM_FN_ENABLED_INPUT();
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
            TRAM_FN_DISABLED_INPUT();
            return;
        }
        $.ajax({
            data: $('#frmForm').serialize(),
            url: "/perfil/modificar",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $("#btnSubmit").prop("disabled", false);
                if(data.status == "success"){
                    $('#frmForm').trigger("reset");
                    $(".listError").html("");
                    TRAM_FN_TRAMITE();
                }else {
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
    };

    //Redirige a login
    function TRAM_FN_TRAMITE(){
        document.location.href = '/tramite_servicio';
    };

    //Confirmar cuenta
    function TRAM_FN_CONFIRMAR_PERFIL(){
        $("#ModalConfirmarCuenta").modal("show");
    };

    //Cambiar contraseña
    function TRAM_FN_CAMBIAR_CONTRASENA(){
        $("#ModalCambiarContrasena").modal("show");
    };

    //Ajx validar cuenta
    function TRAM_AJX_CONFIRMAR_PERFIL(){
        $("#btnSubmitConfirmaCuenta").prop("disabled", true);
        if (!$("#frmFormConfirmar_Cuenta").valid()){
            $('.listErrorConfirmarCuenta').hide();
            var validator = $('#frmFormConfirmar_Cuenta').validate();
            var htmlError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
            $.each(validator.errorList, function (index, value) {
                var campo = $("#"+ value.element.id).attr('placeholder') == undefined ? $("#"+ value.element.id).attr('title') : $("#"+ value.element.id).attr('placeholder');
                if(value.method == "required"){
                    $('.listErrorConfirmarCuenta').show();
                    htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                }
            });
            htmlError += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $(".listErrorConfirmarCuenta").html(htmlError);
            $("#btnSubmitConfirmaCuenta").prop("disabled", false);
            return;
        }


        var rolCat = '{{$ObjAuth->TRAM_CAT_ROL->ROL_CCLAVE}}';
        if(rolCat=="CDNS"){
                //para ciudadanos
                        
                    $.ajax({
                        data: $('#frmFormConfirmar_Cuenta').serialize(),
                        url: "/perfil/confirmar",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                            if(data.status == "success"){
                                $('#frmFormConfirmar_Cuenta').trigger("reset");
                                $(".listErrorConfirmarCuenta").html("");
                                $("#ModalConfirmarCuenta").modal("hide");
                                TRAM_FN_CAMBIAR_CONTRASENA();
                            }else {
                                Swal.fire({
                                    title: '¡Error!',
                                    text: data.message,
                                    icon: 'warning',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        },
                        error: function (data) {

                            console.log(data.message);
                            $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                            Swal.fire({
                                    title: '¡Error!',
                                    text: data.message,
                                    icon: 'warning',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar'
                                });
                        }
                    });
        }else{
                //para servidores publicos
                        
                $.ajax({
                    data: $('#frmFormConfirmar_Cuenta').serialize(),
                    url: "/perfil/confirmarServidor",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                        if(data.status == "success"){
                            $('#frmFormConfirmar_Cuenta').trigger("reset");
                            $(".listErrorConfirmarCuenta").html("");
                            $("#ModalConfirmarCuenta").modal("hide");
                            TRAM_FN_CAMBIAR_CONTRASENA();
                        }else {
                            Swal.fire({
                                title: '¡Error!',
                                text: data.message,
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function (data) {

                        console.log(data.message);
                        $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                        Swal.fire({
                                title: '¡Error!',
                                text: data.message,
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar'
                            });
                    }
                });
        }
        

    };

    //Cambiar contraseña 
    function TRAM_AJX_CAMBIAR_CONTRASENA(){
        $("#btnSubmitCambiarContrasena").prop("disabled", true);
        if (!$("#frmFormCmabiar_Contrasena").valid()){
            $('.listErrorCambiarContrasena').hide();
            var validator = $('#frmFormCmabiar_Contrasena').validate();
            var htmlError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
            $.each(validator.errorList, function (index, value) {
                var campo = $("#"+ value.element.id).attr('placeholder') == undefined ? $("#"+ value.element.id).attr('title') : $("#"+ value.element.id).attr('placeholder');
                if(value.method == "required"){
                    $('.listErrorCambiarContrasena').show();
                    htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                }
            });
            htmlError += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $(".listErrorCambiarContrasena").html(htmlError);
            $("#btnSubmitCambiarContrasena").prop("disabled", false);
            return;
        }
        $.ajax({
            data: $('#frmFormCmabiar_Contrasena').serialize(),
            url: "/cambiar_contrasena",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $("#btnSubmitCambiarContrasena").prop("disabled", false);
                if(data.status == "success"){
                    $('#frmFormCmabiar_Contrasena').trigger("reset");
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    }).then((result2) => {
                        if (result2.isConfirmed) {
                            $(".listErrorCambiarContrasena").html("");
                            $("#ModalCambiarContrasena").modal("hide");
                        }
                    });
                }else {
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
                $("#btnSubmitCambiarContrasena").prop("disabled", false);
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
    
    function TRAM_FN_VALIDAR_INPUT_RFC_RECUPERAR_CONTRASENA (input) {
        var rolCat = '{{$ObjAuth->TRAM_CAT_ROL->ROL_CCLAVE}}';
        //Validar valor
        if (input == null || input == undefined || input == "") {
        } else {
            var newValue = input;
            var rfc = newValue.trim().toUpperCase();
            var rfcCorrecto = TRAM_FN_VALIDAR_RFC(rfc);   // Acá se comprueba
            if (rfcCorrecto) {
                setTimeout(function(){
                    $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                }, 1000);
                $(".resultadoValidText").html("");
            } else {
                setTimeout(function(){
                    $("#btnSubmitConfirmaCuenta").prop("disabled", true);
                }, 1000);

                
                if(rolCat=="CDNS"){
                    // es un ciudadano
                    $(".resultadoValidText").html("<span style='color: red;'>¡Error!</span> El RFC  o Correo no es válido, favor de verficar.");
                }else{
                    $(".resultadoValidText").html("<span style='color: red;'>¡Error!</span> El Correo que se agregó no es válido, favor de verficar.");
                }
               
            }
            //toUpperCase
            $("#txtCorreo_RFC_Electronico").val(rfc);
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
    function TRAM_FN_VALIDAR_INPUNT_CURP (input) {
        var newValue = input;
        if (input == null || input == undefined || input == "") {
        } else {
            var curp = newValue.trim().toUpperCase();  
            if (TRAM_FN_VALIDAR_CURP(curp)) { // Acá se comprueba
                setTimeout(function(){
                    $(".btnSubmit").prop("disabled", false);
                }, 1000);
                $(".iconCurp_Valido").show();
                $(".resultadoValidTextCurp").html("");
            } else {
                setTimeout(function(){
                    $(".btnSubmit").prop("disabled", false);
                }, 1000);
                $(".iconCurp_Valido").hide();
                $(".resultadoValidTextCurp").html("<span style='color: red;'>¡Error!</span> El CURP no es válido, favor de verficar.");
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
</script>
@endsection