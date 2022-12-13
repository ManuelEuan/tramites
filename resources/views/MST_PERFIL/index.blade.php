@extends('layout.Layout')

@section('body')
<div class="container-fluid">
    <br />
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
                                <a class="nav-link active" id="infoPersonal-tab" data-toggle="tab" href="#infoPersonal" role="tab" aria-controls="infoPersonal" aria-selected="true" onclick="hideSaveCancel(false)">INFORMACIÓN
                                    PERSONAL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="predios-tab" data-toggle="tab" href="#predios" role="tab" aria-controls="predios" aria-selected="false" onclick="hideSaveCancel(false)">PREDIOS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="documentos-tab" data-toggle="tab" href="#documentos" onclick="hideSaveCancel(true)" role="tab" aria-controls="documentos" aria-selected="false">DOCUMENTOS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="resolutivos-tab" data-toggle="tab" href="#resolutivos" role="tab" aria-controls="resolutivos" aria-selected="false" onclick="hideSaveCancel(true)">RESOLUTIVOS</a>
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


                                        <input type="hidden" id="txtIdUsuario" name="txtIdUsuario" value="{{ $usuario->USUA_NIDUSUARIO }}" />
                                        <input type="hidden" name="rdbTipo_Persona" value="{{ $usuario->USUA_NTIPO_PERSONA }}" />
                                        <div id="frmRegistro">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="text-dark" id="divTxtRepresentante">
                                                        <b>Datos de persona moral</b>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">RFC <span class="text-danger">*</span> <span class="text-primary">Se compone de 13
                                                                caracteres</span></label>
                                                        <input type="text" class="form-control" id="txtRfc" name="USUA_CRFC" placeholder="RFC" value="{{ $usuario->USUA_CRFC }}" required disabled>
                                                        <span id="resultadoValidText" style="font-size: 12px;"></span>
                                                        <span id="resultadoExistRfc" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 divCurp">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">CURP<span class="text-danger">*</span><span class="text-primary">Se compone de 18 caracteres</span>
                                                            <span>&nbsp;&nbsp; <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCurpFisica', 1);"></i></span></label>
                                                        <input type="text" class="form-control txtCurp" name="USUA_CCURP" id="txtCurpFisica" placeholder="CURP" value="{{ $usuario->USUA_CCURP }}" disabled>
                                                        <span class="resultadoValidTextCurp" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 divRazon_Social">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Razón Social <span class="text-danger">*</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtRazon_Social', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="USUA_CRAZON_SOCIAL" id="txtRazon_Social" placeholder="Razón Social" value="{{ $usuario->USUA_CRAZON_SOCIAL }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-dark" id="divTxtRepresentante"><b>Datos del representante legal</b></p>
                                                    <label for="bus-txt-centro-trabajo">Sexo <span class="text-danger">*</span><i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('rdbSexo', 2);"></i></span></label>
                                                    <div class="form-group">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input rdbSexo" type="radio" value="F" name="USUA_NTIPO_SEXO" {{ $usuario->USUA_NTIPO_SEXO == 'F' ? 'checked' : '' }} required disabled>
                                                            <label class="form-check-label">Mujer</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input rdbSexo" type="radio" value="M" name="USUA_NTIPO_SEXO" {{ $usuario->USUA_NTIPO_SEXO == 'M' ? 'checked' : '' }} required disabled>
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
                                                                <label for="bus-txt-centro-trabajo">CURP <span class="text-danger">*</span><span class="text-primary">Se compone de 18
                                                                        caracteres</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCurpMoral', 1);"></i></span></label>
                                                                <input type="text" class="form-control txtCurp" name="USUA_CCURP" id="txtCurpMoral" placeholder="CURP" value="{{ $usuario->USUA_CCURP }}" disabled>
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
                                                        <input type="text" class="form-control" name="USUA_CNOMBRES" id="txtNombres" placeholder="Nombre (s)" value="{{ $usuario->USUA_CNOMBRES }}" required disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Primer apellido <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtPrimer_Apellido', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="USUA_CPRIMER_APELLIDO" id="txtPrimer_Apellido" placeholder="Primer apellido" value="{{ $usuario->USUA_CPRIMER_APELLIDO }}" required disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Segundo apellido
                                                            <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtSegundo_Apellido', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="USUA_CSEGUNDO_APELLIDO" id="txtSegundo_Apellido" placeholder="Segundo apellido" value="{{ $usuario->USUA_CSEGUNDO_APELLIDO }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />

                                            <div class="row divFechaNacimiento">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Fecha de Nacimiento: <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('fechaNacimientoFisica', 1);"></i>
                                                        </label>
                                                        <br>
                                                        <input type="date" id="fechaNacimientoFisica" name="USUA_DFECHA_NACIMIENTO" value="{{ $usuario->USUA_DFECHA_NACIMIENTO }}" disabled>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="text-dark" id="divTxtRepresentante">Datos de contacto
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <div class="form-group">
                                                                <label for="bus-txt-centro-trabajo">Correo electronico
                                                                    <span class="text-danger">*</span>
                                                                    <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCorreo', 1);"></i></span></label>
                                                                <input type="text" class="form-control" name="USUA_CCORREO_ELECTRONICO" id="txtCorreo" placeholder="ejemplo@correo.com" value="{{ $usuario->USUA_CCORREO_ELECTRONICO }}" disabled>
                                                                <span id="resultadoExistCorreoElectronico" style="font-size: 12px;"></span>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">

                                                            <div class="form-group">
                                                                <label for="bus-txt-centro-trabajo">Correo electronico
                                                                    alternativo <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCorreoAlternativo', 1);"></i></span></label>
                                                                <input type="text" class="form-control" name="USUA_CCORREO_ALTERNATIVO" id="txtCorreoAlternativo" placeholder="alternativo@correo.com" value="{{ $usuario->USUA_CCORREO_ALTERNATIVO }}" disabled>
                                                                <span id="resultadoExistCorreoElectronicoAlternativo" style="font-size: 12px;"></span>
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
                                                            <input class="form-check-input rdbTelefono" type="radio" value="LOCAL" name="rdbTelefono" checked required disabled>
                                                            <label class="form-check-label">Local</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input rdbTelefono" type="radio" value="CELULAR" name="rdbTelefono" required disabled>
                                                            <label class="form-check-label">Celular</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control rdbTelefono" name="USUA_NTELEFONO" id="USUA_CTEL_LOCAL" placeholder="9999999999" value="{{ $usuario->USUA_NTELEFONO }}" disabled>
                                                    </div>
                                                </div>

                                            </div>

                                            <label for=""><b>Personas autorizadas para oír y recibir
                                                    notificaciones</b></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="bus-txt-centro-trabajo">Nombre (s) <span class="text-danger">*</span> <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('nombrePersonaAutorizada', 1);"></i></label>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" id="nombrePersonaAutorizada" name="USUA_CNOMBRE_NOTIFICACION" value="{{ $usuario->USUA_CNOMBRE_NOTIFICACION }}" placeholder="Nombre (s)" required disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="bus-txt-centro-trabajo">Teléfono <span class="text-danger">*</span> <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('telefonoPersonaAutorizada', 1);"></i></label>
                                                    <div class="form-group">
                                                        <input type="tel" class="form-control" id="telefonoPersonaAutorizada" name="USUA_CTEL_CELULAR_NOTIFICACION" value="{{ $usuario->USUA_CTEL_CELULAR_NOTIFICACION }}" placeholder="999999999" pattern="[(]{1}[0-9]{3}[) ]{2}[0-9]{3}[-]{1}[0-9]{4}" placeholder="No. de teléfono" required disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="bus-txt-centro-trabajo">Correo <span class="text-danger">*</span> <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('correoPersonaAutorizada', 1);"></i></label>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" id="correoPersonaAutorizada" name="USUA_CCORREO_NOTIFICACION" value="{{ $usuario->USUA_CCORREO_NOTIFICACION }}" placeholder="Correo" required disabled>
                                                        <span id="errorPAutorizada" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row divDomicilio_Particular">
                                                <div class="col-md-12">
                                                    <br />
                                                    <h5 class="font-weight-bold">Domicilio particular</h5>
                                                    <br />
                                                </div>
                                            </div>
                                            <div class="row divDomicilio_Particular">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Calle <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCalle_Particular', 1);"></i></span></label>
                                                        <input type="text" class="form-control" name="USUA_CCALLE_PARTICULAR" id="txtCalle_Particular" placeholder="Calle" value="{{ $usuario->USUA_CCALLE_PARTICULAR }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Número interior
                                                            <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNumero_Interior_Particular', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="USUA_NNUMERO_INTERIOR_PARTICULAR" id="txtNumero_Interior_Particular" placeholder="Número interior" value="{{ $usuario->USUA_NNUMERO_INTERIOR_PARTICULAR }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger">*</span> <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNumero_Exterior_Particular', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="USUA_NNUMERO_EXTERIOR_PARTICULAR" id="txtNumero_Exterior_Particular" placeholder="Número exterior" value="{{ $usuario->USUA_NNUMERO_EXTERIOR_PARTICULAR }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCP_Particular', 1);"></i></span></label>
                                                        <input type="number" class="form-control" name="USUA_NCP_PARTICULAR" id="txtCP_Particular" placeholder="C.P." value="{{ $usuario->USUA_NCP_PARTICULAR }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row divDomicilio_Particular">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbColonia_Particular">Colonia <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbColonia_Particular', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="USUA_CCOLONIA_PARTICULAR" id="cmbColonia_Particular" title="Colonia" value="{{ $usuario->USUA_CCOLONIA_PARTICULAR }}" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Zona Centro" {{ $usuario->USUA_CCOLONIA_PARTICULAR == 'Zona Centro' ? 'selected' : '' }}>
                                                                Zona Centro</option>
                                                            <option value="San Pedro" {{ $usuario->USUA_CCOLONIA_PARTICULAR == 'San Pedro' ? 'selected' : '' }}>
                                                                San Pedro</option>
                                                            <option value="Sector Bolívar" {{ $usuario->USUA_CCOLONIA_PARTICULAR == 'Sector Bolívar' ? 'selected' : '' }}>
                                                                Sector Bolívar</option>
                                                            <option value="Nava" {{ $usuario->USUA_CCOLONIA_PARTICULAR == 'Nava' ? 'selected' : '' }}>
                                                                Nava</option>
                                                            <option value="Nogales Norte" {{ $usuario->USUA_CCOLONIA_PARTICULAR == 'Nogales Norte' ? 'selected' : '' }}>
                                                                Nogales Norte</option>
                                                            <option value="Pátzcuaro" {{ $usuario->USUA_CCOLONIA_PARTICULAR == 'Pátzcuaro' ? 'selected' : '' }}>
                                                                Pátzcuaro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbMunicipio_Particular">Municipio <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbMunicipio_Particular', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="USUA_CMUNICIPIO_PARTICULAR" id="cmbMunicipio_Particular" title="Municipio" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Chihuahua" {{ $usuario->USUA_CMUNICIPIO_PARTICULAR == 'Chihuahua' ? 'selected' : '' }}>
                                                                Chihuahua</option>
                                                            <option value="Juárez" {{ $usuario->USUA_CMUNICIPIO_PARTICULAR == 'Juárez' ? 'selected' : '' }}>
                                                                Juárez</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbEstado_Particular">Estado <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbEstado_Particular', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="USUA_CESTADO_PARTICULAR" id="cmbEstado_Particular" title="Estado" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="Chihuahua" {{ $usuario->USUA_CESTADO_PARTICULAR == 'Chihuahua' ? 'selected' : '' }}>
                                                                Chihuahua</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cmbPais_Particular">País <span class="text-danger">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbPais_Particular', 1);"></i></span></label>
                                                        <select class="combobox form-control" name="USUA_CPAIS_PARTICULAR" id="cmbPais_Particular" title="País" disabled>
                                                            <option value="">Seleccione...</option>
                                                            <option value="México" {{ $usuario->USUA_CPAIS_PARTICULAR == 'México' ? 'selected' : '' }}>
                                                                México</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row divDomicilio_Particular">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="chbDomicilio_Mismo" id="chbDomicilio_Mismo" value="1">
                                                            <label class="form-check-label" for="chbDomicilio_Mismo"><span class="text-primary">¿El domicilio particular y el
                                                                    domicilio físcal es el mismo?</span></label>
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
                                                                                    placeholder="Calle" value="{{ $usuario->USUA_CCALLE }}" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="bus-txt-centro-trabajo">Número interior <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNumero_Interior_Fiscal', 1);"></i></span></label>
                                                                                <input type="number" class="form-control" name="txtNumero_Interior_Fiscal" id="txtNumero_Interior_Fiscal"
                                                                                    placeholder="Número interior" value="{{ $usuario->USUA_NNUMERO_INTERIOR }}" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNumero_Exterior_Fiscal', 1);"></i></span></label>
                                                                                <input type="number" class="form-control" name="txtNumero_Exterior_Fiscal" id="txtNumero_Exterior_Fiscal" pattern="[0-9]+"
                                                                                    placeholder="Número exterior" value="{{ $usuario->USUA_NNUMERO_EXTERIOR }}" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCP_Fiscal', 1);"></i></span></label>
                                                                                <input type="number" class="form-control" name="txtCP_Fiscal" id="txtCP_Fiscal"
                                                                                    placeholder="C.P." value="{{ $usuario->USUA_NCP }}" disabled>
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
                                                                                    <option value="Zona Centro" {{ $usuario->USUA_CCOLONIA == 'Zona Centro' ? 'selected' : '' }}>Zona Centro</option>
                                                                                    <option value="San Pedro" {{ $usuario->USUA_CCOLONIA == 'San Pedro' ? 'selected' : '' }}>San Pedro</option>
                                                                                    <option value="Sector Bolívar" {{ $usuario->USUA_CCOLONIA == 'Sector Bolívar' ? 'selected' : '' }}>Sector Bolívar</option>
                                                                                    <option value="Nava" {{ $usuario->USUA_CCOLONIA == 'Nava' ? 'selected' : '' }}>Nava</option>
                                                                                    <option value="Nogales Norte" {{ $usuario->USUA_CCOLONIA == 'Nogales Norte' ? 'selected' : '' }}>Nogales Norte</option>
                                                                                    <option value="Pátzcuaro" {{ $usuario->USUA_CCOLONIA == 'Pátzcuaro' ? 'selected' : '' }}>Pátzcuaro</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="cmbMunicipio_Fiscal">Municipio <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbMunicipio_Fiscal', 1);"></i></span></label>
                                                                                <select class="combobox form-control" name="cmbMunicipio_Fiscal"
                                                                                    id="cmbMunicipio_Fiscal" title="Municipio" disabled>
                                                                                    <option value="">Seleccione...</option>
                                                                                    <option value="Chihuahua" {{ $usuario->USUA_CMUNICIPIO == 'Chihuahua' ? 'selected' : '' }}>Chihuahua</option>
                                                                                    <option value="Juárez" {{ $usuario->USUA_CMUNICIPIO == 'Juárez' ? 'selected' : '' }}>Juárez</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="cmbEstado_Fiscal">Estado <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbEstado_Fiscal', 1);"></i></span></label>
                                                                                <select class="combobox form-control" name="cmbEstado_Fiscal"
                                                                                    id="cmbEstado_Fiscal" title="Estado" disabled>
                                                                                    <option value="">Seleccione...</option>
                                                                                    <option value="Chihuahua" {{ $usuario->USUA_CESTADO == 'Chihuahua' ? 'selected' : '' }}>Chihuahua</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="cmbPais_Fiscal">País <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('cmbPais_Fiscal', 1);"></i></span></label>
                                                                                <select class="combobox form-control" name="cmbPais_Fiscal"
                                                                                    id="cmbPais_Fiscal" title="País" disabled>
                                                                                    <option value="">Seleccione...</option>
                                                                                    <option value="México" {{ $usuario->USUA_CPAIS == 'México' ? 'selected' : '' }}>México</option>
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
                                                                                    @if (count($usuario->TRAM_MDV_SUCURSAL) > 0)
    @foreach ($usuario->TRAM_MDV_SUCURSAL as $item)
    <div data-repeater-item>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-11">
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
                                                                                                                    <label for="bus-txt-centro-trabajo">Calle <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{ $IntIndex }}_txtCalle_Sucursal', 1);"></i></span></label>
                                                                                                                    <input type="text" class="form-control txtCalle_Sucursal" name="txtCalle_Sucursal" id="{{ $IntIndex }}_txtCalle_Sucursal"  placeholder="Calle" value="{{ $item->SUCU_CCALLE }}" disabled>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
                                                                                                                    <label for="bus-txt-centro-trabajo">Número interior <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{ $IntIndex }}_txtNumero_Interior_Sucursal', 1);"></i></span></label>
                                                                                                                    <input type="number" class="form-control txtNumero_Interior_Sucursal" name="txtNumero_Interior_Sucursal" id="{{ $IntIndex }}_txtNumero_Interior_Sucursal"
                                                                                                                        placeholder="Número interior" value="{{ $item->SUCU_NNUMERO_INTERIOR }}" disabled>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
                                                                                                                    <label for="bus-txt-centro-trabajo">Número exterior <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{ $IntIndex }}_txtNumero_Exterior_Sucursal', 1);"></i></span></label>
                                                                                                                    <input type="number" class="form-control txtNumero_Exterior_Sucursal" name="txtNumero_Exterior_Sucursal" id="{{ $IntIndex }}_txtNumero_Exterior_Sucursal"
                                                                                                                        placeholder="Número exterior" value="{{ $item->SUCU_NNUMERO_EXTERIOR }}" disabled>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
                                                                                                                    <label for="bus-txt-centro-trabajo">C.P. <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{ $IntIndex }}_txtCP_Sucursal', 1);"></i></span></label>
                                                                                                                    <input type="number" class="form-control txtCP_Sucursal" name="txtCP_Sucursal" id="{{ $IntIndex }}_txtCP_Sucursal"
                                                                                                                        placeholder="C.P." value="{{ $item->SUCU_NCP }}" disabled>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <br/>
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
                                                                                                                    <label for="cmbColonia_Sucursal">Colonia <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{ $IntIndex }}_cmbColonia_Sucursal', 1);"></i></span></label>
                                                                                                                    <select class="combobox form-control cmbColonia_Sucursal" name="cmbColonia_Sucursal" id="{{ $IntIndex }}_cmbColonia_Sucursal" title="Colonia" disabled>
                                                                                                                        <option value="">Seleccione...</option>
                                                                                                                        <option value="Zona Centro" {{ $item->SUCU_CCOLONIA == 'Zona Centro' ? 'selected' : '' }}>Zona Centro</option>
                                                                                                                        <option value="San Pedro" {{ $item->SUCU_CCOLONIA == 'San Pedro' ? 'selected' : '' }}>San Pedro</option>
                                                                                                                        <option value="Sector Bolívar" {{ $item->SUCU_CCOLONIA == 'Sector Bolívar' ? 'selected' : '' }}>Sector Bolívar</option>
                                                                                                                        <option value="Nava" {{ $item->SUCU_CCOLONIA == 'Nava' ? 'selected' : '' }}>Nava</option>
                                                                                                                        <option value="Nogales Norte" {{ $item->SUCU_CCOLONIA == 'Nogales Norte' ? 'selected' : '' }}>Nogales Norte</option>
                                                                                                                        <option value="Pátzcuaro" {{ $item->SUCU_CCOLONIA == 'Pátzcuaro' ? 'selected' : '' }}>Pátzcuaro</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
                                                                                                                    <label for="cmbMunicipio_Sucursal">Municipio <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{ $IntIndex }}_cmbMunicipio_Sucursal', 1);"></i></span></label>
                                                                                                                    <select class="combobox form-control cmbMunicipio_Sucursal" name="cmbMunicipio_Sucursal" id="{{ $IntIndex }}_cmbMunicipio_Sucursal" title="Municipio" disabled>
                                                                                                                        <option value="">Seleccione...</option>
                                                                                                                        <option value="Chihuahua" {{ $item->SUCU_CMUNICIPIO == 'Chihuahua' ? 'selected' : '' }}>Chihuahua</option>
                                                                                                                        <option value="Juárez" {{ $item->SUCU_CMUNICIPIO == 'Juárez' ? 'selected' : '' }}>Juárez</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
                                                                                                                    <label for="cmbEstado_Sucursal">Estado <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{ $IntIndex }}_cmbEstado_Sucursal', 1);"></i></span></label>
                                                                                                                    <select class="combobox form-control cmbEstado_Sucursal" name="cmbEstado_Sucursal" id="{{ $IntIndex }}_cmbEstado_Sucursal" title="Estado" disabled>
                                                                                                                        <option value="">Seleccione...</option>
                                                                                                                        <option value="Chihuahua" {{ $item->SUCU_CESTADO == 'Chihuahua' ? 'selected' : '' }}>Chihuahua</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
                                                                                                                    <label for="cmbPais_Sucursal">País <span class="text-danger asterisco" id="asterisco">*</span><span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('{{ $IntIndex }}_cmbPais_Sucursal', 1);"></i></span></label>
                                                                                                                    <select class="combobox form-control cmbPais_Sucursal" name="cmbPais_Sucursal" id="{{ $IntIndex }}_cmbPais_Sucursal" title="País" disabled>
                                                                                                                        <option value="">Seleccione...</option>
                                                                                                                        <option value="México" {{ $item->SUCU_CPAIS == 'México' ? 'selected' : '' }}>México</option>
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
                                                                                    placeholder="Correo electrónico" value="{{ $usuario->USUA_CCORREO_ELECTRONICO }}" required disabled>
                                                                                <span id="resultadoExistCorreo" style="font-size: 12px;"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="bus-txt-centro-trabajo">Correo electrónico alternativo <span>&nbsp;&nbsp;<i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCorreo_Alternativo', 1);"></i></span></label>
                                                                                <input type="email" class="form-control" name="txtCorreo_Alternativo" id="txtCorreo_Alternativo"
                                                                                    placeholder="Correo electrónico alternativo" value="{{ $usuario->USUA_CCORREO_ALTERNATIVO }}" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                        -->
                                            <br />
                                        </div>


                                    </div>

                                    <!-- Aqui termina -->
                                </div>
                                <!-- Div Predios-->
                                <div class="tab-pane fade" id="predios" role="tabpanel" aria-labelledby="predios-tab">

                                    <div class="card mt-3">
                                        <div class="card-body text-body">

                                            <!-- <div class="row justify-content-md-center">
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
                                            </div> -->

                                            <!-- <br>

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

                                            </div> -->

                                            <!-- <br>

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
                                                                <div class="col-md-2" style="text-align: right;">Folio
                                                                </div>
                                                                <div class="col-md-2">Dirección</div>
                                                                <div class="col-md-8"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-2" style="text-align: right;">00000
                                                                </div>
                                                                <div class="col-md-5"><label for="">Lorem
                                                                        Ipsum is simply dummy text of the printing
                                                                        h</label></div>
                                                                <div class="col-md-3">
                                                                    <select name="" id="" class="form-control">
                                                                        <option value="">Seleccione un tipo de
                                                                            predio</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-primary" style="height: 32px;font-size: inherit;">Añadir</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <br>


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
                                                                                    <input type="text" class="form-control" id="txtCalleParticular" name="USUA_CCALLE_PARTICULAR" value="{{ $usuario->USUA_CCALLE_PARTICULAR }}" placeholder="21">
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Número
                                                                                        interior</label>
                                                                                    <br>
                                                                                    <input type="text" class="form-control" id="txtNumeroInteriorParticular" name="USUA_NNUMERO_INTERIOR_PARTICULAR" value="{{ $usuario->USUA_NNUMERO_INTERIOR_PARTICULAR }}" placeholder="Número interior">
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Número
                                                                                        exterior</label>
                                                                                    <br>
                                                                                    <input type="text" class="form-control" id="txtNumeroExteriorParticular" name="USUA_NNUMERO_EXTERIOR_PARTICULAR" value="{{ $usuario->USUA_NNUMERO_EXTERIOR_PARTICULAR }}" placeholder="Número exterior">
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">C.P.</label>
                                                                                    <br>
                                                                                    <input type="number" class="form-control" id="txtNumeroCPParticular" name="USUA_NCP_PARTICULAR" value="{{ $usuario->USUA_NCP_PARTICULAR }}" placeholder="97000">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="row justify-content-md-center">
                                                                                <div class="col-md-3">
                                                                                    <label for="">Pais</label>
                                                                                    <br>
                                                                                    <!--<input type="text" class="form-control" id="txtPaisParticular" name="txtPaisParticular" value="{{ $usuario->USUA_CPAIS_PARTICULAR }}" placeholder="México">--->
                                                                                    <div id="selectcmbPais_Particular"></div>
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Estado<nav>
                                                                                        </nav></label>
                                                                                    <br>
                                                                                    <!-- <input type="text" class="form-control" id="txtEstadoParticular" name="txtEstadoParticular" value="{{ $usuario->USUA_CESTADO_PARTICULAR }}" placeholder="Querétaro">-->
                                                                                    <div id="selectcmbEstado_Particular"></div>
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Municipio</label>
                                                                                    <br>
                                                                                    <!-- <input type="text" class="form-control" id="txtMunicipioParticular" name="txtMunicipioParticular" value="{{ $usuario->USUA_CMUNICIPIO_PARTICULAR }}" placeholder="Querétaro">-->
                                                                                    <div id="selectcmbMunicipio_Particular"></div>
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Colonia</label>
                                                                                    <br>
                                                                                    <!-- <input type="text" class="form-control" id="txtColoniaParticular" name="txtColoniaParticular" value="{{ $usuario->USUA_CCOLONIA_PARTICULAR }}" placeholder="Centro">-->
                                                                                    <select class="combobox form-control optionsColoniaParticular" name="USUA_CCOLONIA_PARTICULAR"
                                                                                        id="txtColoniaParticular" title="Colonia">
                                                                                        <option value="" selected="true" disabled="disabled">Selecione una colonia.</option>
                                                                                    </select>
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
                                                                                    <input type="text" class="form-control" id="txtCalleFiscal" name="USUA_CCALLE" value="{{ $usuario->USUA_CCALLE }}" placeholder="21">
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Número
                                                                                        interior</label>
                                                                                    <br>
                                                                                    <input type="number" class="form-control" id="txtNumeroInteriorFiscal" name="USUA_NNUMERO_INTERIOR" value="{{ $usuario->USUA_NNUMERO_INTERIOR }}" placeholder="Número interior">
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Número
                                                                                        exterior</label>
                                                                                    <br>
                                                                                    <input type="number" class="form-control" id="txtNumeroExteriorFiscal" name="USUA_NNUMERO_EXTERIOR" value="{{ $usuario->USUA_NNUMERO_EXTERIOR }}" placeholder="Número exterior">
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">C.P.</label>
                                                                                    <br>
                                                                                    <input type="number" class="form-control" id="txtCPFiscal" name="USUA_NCP" value="{{ $usuario->USUA_NCP }}" placeholder="97000">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="row justify-content-md-center">
                                                                                <div class="col-md-3">
                                                                                    <label for="">Pais</label>
                                                                                    <br>
                                                                                    <!-- <input type="text" class="form-control" id="txtPaisFiscal" name="txtPaisFiscal" value="{{ $usuario->USUA_CPAIS }}" placeholder="México">-->
                                                                                    <div id="selectcmbPais_Fiscal"></div>
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Estado<nav>
                                                                                        </nav></label>
                                                                                    <br>
                                                                                    <!-- <input type="text" class="form-control" id="txtEstadoFiscal" name="txtEstadoFiscal" value="{{ $usuario->USUA_CESTADO }}" placeholder="Querétaro">-->
                                                                                    <div id="selectcmbEstado_Fiscal"></div>
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Municipio</label>
                                                                                    <br>
                                                                                    <!--<input type="text" class="form-control" id="txtMunicipioFiscal" name="txtMunicipioFiscal" value="{{ $usuario->USUA_CMUNICIPIO }}" placeholder="Querétaro">-->
                                                                                    <div id="selectcmbMunicipio_Fiscal"></div>
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label for="">Colonia</label>
                                                                                    <br>
                                                                                    <select class="combobox form-control optionsColoniaFiscal" name="txtColoniaFiscal"
                                                                                        id="txtColoniaFiscal" title="Colonia">
                                                                                        <option value="" selected="true" disabled="disabled">Selecione un Municipio.</option>
                                                                                    </select>
                                                                                    <!--<input type="text" class="form-control" id="txtColoniaFiscal" name="txtColoniaFiscal" value="{{ $usuario->USUA_CCOLONIA }}" placeholder="Centro">-->
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
                                                                            <br />
                                                                            <div class="repeater">
                                                                                <h5 class="font-weight-bold">Agregar
                                                                                    sucursal <span class="circle" data-repeater-create>+</span>
                                                                                </h5>
                                                                                <div data-repeater-list="lstSucursal">
                                                                                    <?php $IntIndex = 0; ?>
                                                                                    @if (count($usuario->TRAM_MDV_SUCURSAL) > 0)
                                                                                    @foreach ($usuario->TRAM_MDV_SUCURSAL as $item)
                                                                                    <div data-repeater-item>
                                                                                        <div class="row">
                                                                                            <div class="col-md-11">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="bus-txt-centro-trabajo">Calle</label>
                                                                                                            <input type="text" class="form-control txtCalle_Sucursal" name="txtCalle_Sucursal" id="{{ $IntIndex }}_txtCalle_Sucursal" placeholder="Calle" value="{{ $item->SUCU_CCALLE }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="bus-txt-centro-trabajo">Número
                                                                                                                interior</label>
                                                                                                            <input type="number" class="form-control txtNumero_Interior_Sucursal" name="txtNumero_Interior_Sucursal" id="{{ $IntIndex }}_txtNumero_Interior_Sucursal" placeholder="Número interior" value="{{ $item->SUCU_NNUMERO_INTERIOR }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="bus-txt-centro-trabajo">Número
                                                                                                                exterior</label>
                                                                                                            <input type="number" class="form-control txtNumero_Exterior_Sucursal" name="txtNumero_Exterior_Sucursal" id="{{ $IntIndex }}_txtNumero_Exterior_Sucursal" placeholder="Número exterior" value="{{ $item->SUCU_NNUMERO_EXTERIOR }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="bus-txt-centro-trabajo">C.P.</label>
                                                                                                            <input type="number" class="form-control txtCP_Sucursal" name="txtCP_Sucursal" id="{{ $IntIndex }}_txtCP_Sucursal" placeholder="C.P." value="{{ $item->SUCU_NCP }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <br />
                                                                                                <div class="row">
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="cmbPais_Sucursal">País
                                                                                                            </label>
                                                                                                            <select class="combobox form-control cmbPais_Sucursal optionsPaisesSucursal" name="cmbPais_Sucursal" title="País" id="{{ $IntIndex }}_cmbPais_Sucursal" value="{{ $item->SUCU_CPAIS }}">
                                                                                                            </select>
                                                                                                            <!-- <input type="text" class="form-control cmbPais_Sucursal" name="cmbPais_Sucursal" id="{{ $IntIndex }}_cmbPais_Sucursal" placeholder="México" value="{{ $item->SUCU_CPAIS }}"> -->
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="cmbEstado_Sucursal">Estado</label>
                                                                                                            <select class="combobox form-control cmbEstado_Sucursal optionsEstadosSucursal" name="cmbEstado_Sucursal" title="Estado" id="{{ $IntIndex }}_cmbEstado_Sucursal" value="{{ $item->SUCU_CESTADO }}">
                                                                                                            </select>
                                                                                                            <!-- <input type="text" class="form-control cmbEstado_Sucursal" name="cmbEstado_Sucursal" id="{{ $IntIndex }}_cmbEstado_Sucursal" placeholder="Querétaro" value="{{ $item->SUCU_CESTADO }}"> -->
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="cmbMunicipio_Sucursal">Municipio
                                                                                                            </label>
                                                                                                            <select class="combobox form-control cmbMunicipio_Sucursal optionsMunicipioSucursal" name="cmbMunicipio_Sucursal" title="Municipio" id="{{ $IntIndex }}_cmbMunicipio_Sucursal" value="{{ $item->SUCU_CMUNICIPIO }}">
                                                                                                            </select>
                                                                                                            <!-- <input type="text" class="form-control cmbMunicipio_Sucursal" name="cmbMunicipio_Sucursal" id="{{ $IntIndex }}_cmbMunicipio_Sucursal" placeholder="Querétaro" value="{{ $item->SUCU_CMUNICIPIO }}"> -->
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="cmbColonia_Sucursal">Colonia
                                                                                                            </label>
                                                                                                            <select class="combobox form-control cmbColonia_Sucursal optionscmbColonia_Sucursal" name="cmbColonia_Sucursal" title="Colonia" id="{{ $IntIndex }}_cmbColonia_Sucursal" value="{{ $item->SUCU_CCOLONIA }}">
                                                                                                                <option value="" selected="true" disabled="disabled">Selecione un Municipio.</option> 
                                                                                                            </select>
                                                                                                            <!-- <input type="text" class="form-control cmbColonia_Sucursal" name="cmbColonia_Sucursal" id="{{ $IntIndex }}_cmbColonia_Sucursal" placeholder="Centro" value="{{ $item->SUCU_CCOLONIA }}"> -->
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
                                                                                        <hr />
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
                                                                                                            <input type="text" class="form-control txtCalle_Sucursal" name="txtCalle_Sucursal" id="txtCalle_Sucursal" placeholder="Calle" value="">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="bus-txt-centro-trabajo">Número
                                                                                                                interior</label>
                                                                                                            <input type="number" class="form-control txtNumero_Interior_Sucursal" name="txtNumero_Interior_Sucursal" id="txtNumero_Interior_Sucursal" placeholder="Número interior" value="">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="bus-txt-centro-trabajo">Número
                                                                                                                exterior</label>
                                                                                                            <input type="number" class="form-control txtNumero_Exterior_Sucursal" name="txtNumero_Exterior_Sucursal" id="txtNumero_Exterior_Sucursal" placeholder="Número exterior" value="">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="bus-txt-centro-trabajo">C.P.</label>
                                                                                                            <input type="number" class="form-control txtCP_Sucursal" name="txtCP_Sucursal" id="txtCP_Sucursal" placeholder="C.P." value="">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <br />
                                                                                                <div class="row">
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="cmbPais_Sucursal">País
                                                                                                            </label>
                                                                                                            <select class="combobox form-control cmbPais_Sucursal optionsPaisesSucursal" name="cmbPais_Sucursal" title="País">
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="cmbEstado_Sucursal">Estado</label>
                                                                                                            <select class="combobox form-control cmbEstado_Sucursal optionsEstadosSucursal" name="cmbEstado_Sucursal" title="Estado">
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="cmbMunicipio_Sucursal">Municipio
                                                                                                            </label>
                                                                                                            <select class="combobox form-control cmbMunicipio_Sucursal optionsMunicipioSucursal" name="cmbMunicipio_Sucursal" title="Municipio" onchange="TRAM_AJX_CARGAR_LOCALIDADES_SUCURSAL(this)">
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="cmbColonia_Sucursal">Colonia
                                                                                                            </label>
                                                                                                            <select class="combobox form-control cmbColonia_Sucursal optionscmbColonia_Sucursal" name="cmbColonia_Sucursal" title="Colonia">
                                                                                                                <option value="" selected="true" disabled="disabled">Selecione un Municipio.</option> 
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
                                                                                        <hr />
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
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Expedientes</a>
                                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Histórico documentos tramite</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <br>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table id="tbl_listado" class="table table-striped" style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Nombre</th>
                                                                    <th scope="col">Tamaño</th>
                                                                    <th scope="col">Estatus</th>
                                                                    <th scope="col">Vigencia</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <br>
                                            <table id="tbl_history" class="table table-striped" style="width: 100%">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Estatus</th>
                                                    <th>Fecha vencimiento</th>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Div Resolutivos -->
                                <div class="tab-pane fade" id="resolutivos" role="tabpanel" aria-labelledby="resolutivos-tab">
                                    <br>
                                    <table class="table table-striped" id="tbl_resolutivos" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">OTORGADO EL</th>
                                                <th scope="col">NOMBRE</th>
                                                <th scope="col">TAMAÑO</th>
                                                <th scope="col">ACCIONES</th>
                                                <!-- <th scope="col">VENCE EL</th>
                                                <th scope="col">ESTATUS</th> -->
                                            </tr>
                                        </thead>
                                    </table>

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
<br />
<div>
    <div class="col-md-12 text-right" id="sendDatos">
        <button class="btn btn-primary btnSubmit" id="btnSubmit" onclick="TRAM_AJX_GUARDAR();">Guardar</button>
        <button class="btn btn-danger">Cerrar</button>
    </div>
</div>
<br />
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

                                <input type="text" class="form-control" name="txtCorreo_RFC_Electronico" id="txtCorreo_RFC_Electronico" placeholder="RFC o Correo electrónico" required>



                                <span class="resultadoValidText" style="font-size: 12px;"></span>
                            </div>
                            <div class="form-group">
                                <label>Contraseña actual <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="txtContrasena_Actual" id="txtContrasena_Actual" placeholder="Contraseña actual" required>
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
                            <input type="hidden" name="txtIntIdUsuario" value="{{ $usuario->USUA_NIDUSUARIO }}">
                            <input type="hidden" name="txtIntTipo" value="1">
                            <div class="form-group">
                                <label>Ingresa nueva contraseña</label>
                                <input type="password" class="form-control" name="txtContrasena_Nueva" id="txtContrasena_Nueva" placeholder="Nueva contraseña" required>
                            </div>
                            <div class="form-group">
                                <label>Repetir contraseña</label>
                                <input type="password" class="form-control" name="txtConformacion_Contrasena" id="txtConformacion_Contrasena" placeholder="Contraseña actual" required>
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

<!-- Modal ver docs -->
<div class="modal fade" id="verDocsD" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="verDocsD" aria-hidden="true">
    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-radius-6">
            <div class="modal-header">
                <h5 class="modal-title">Historial de documentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbl_historyexp" class="table table-striped" style="width: 100%">
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-between">
                    <div class="col-md-12 text-right">
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
    @if (empty($usuario->USUA_CCORREO_ELECTRONICO))
    var emailPrimario = '';
    @else
    var emailPrimario = '{{$usuario->USUA_CCORREO_ELECTRONICO}}';
    @endif

    @if (empty($usuario->USUA_CCORREO_ALTERNATIVO))
    var emailAlternativo = '';
    @else
    var emailAlternativo = '{{$usuario->USUA_CCORREO_ALTERNATIVO}}';
    @endif

    @if (empty($usuario->USUA_CCORREO_ELECTRONICO))
    var emailPA = '';
    @else
    var emailPA = '{{$usuario->USUA_CCORREO_NOTIFICACION}}';
    @endif


    @if (empty($usuario->USUA_CCURP))
    var curpPrincipal = '';
    @else
    var curpPrincipal = '{{$usuario->USUA_CCURP}}';
    @endif
    
    
    var emailPrimarioValido = 1;

    var emailAlternativoValido = 1;

    var emailPAValido = 1;

    var curpPrincipalValido = 1;

    var estadoParticular = '{{ $usuario->USUA_CESTADO_PARTICULAR }}';
    var estadoFiscal = '{{ $usuario->USUA_CESTADO }}';
    var municipioParticular = '{{ $usuario->USUA_CMUNICIPIO_PARTICULAR }}';
    var municipioFiscal = '{{ $usuario->USUA_CMUNICIPIO }}';
    var coloniaParticular = '{{ $usuario->USUA_CCOLONIA_PARTICULAR }}';
    var coloniaFiscal = '{{ $usuario->USUA_CCOLONIA }}';
    

    function GET_VISTA_PREDIOS() {
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

        $.ajax(settings).done(function(response) {
            $('#divPredios').html(response)
        });

    }

    $(document).ready(function() {
        var StrTipoPersona = '{{ $usuario->USUA_NTIPO_PERSONA }}';
        var BolSucursal = '{{ count($usuario->TRAM_MDV_SUCURSAL) > 0 ? false : true }}';
        var rolCat = '{{ $usuario->TRAM_CAT_ROL->ROL_CCLAVE }}';
        
        GET_VISTA_PREDIOS()

        $('#frmForm').on('submit', function(e) {
            e.preventDefault()
        })


        console.log(rolCat);


        if (StrTipoPersona == "FISICA") {
            $('.asterisco').hide();
        } else {
            $('.asterisco').show();
        }

        if (rolCat == "CDNS") {
            // es un ciudadano
            $('#ciudadano').show();
            $('#servidor').hide();

            $("#txtCorreo_RFC_Electronico").attr("placeholder", "RFC o Correo electrónico");
        } else {
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
                return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value) // has a special character
            },
            "La contraseña debe contener de 8 a 15 carácteres alfanuméricos (a-z A-Z), contener mínimo un dígito (0-9) y un carácter especial (_-=)."
        );

        $.validator.addMethod('passwordMatch', function(value, element) {
            var password = $("#txtContrasena_Nueva").val();
            var confirmPassword = $("#txtConformacion_Contrasena").val();
            if (password != confirmPassword) {
                return false;
            } else {
                return true;
            }
        });

        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "El nombre (s) solamente puede tener caracteres alfabéticos y espacios.");



        $("#frmFormCmabiar_Contrasena").validate({
            focusInvalid: false,
            invalidHandler: function() {
                $(this).find(":input.error:first").focus();
            },
            rules: {
                txtContrasena_Nueva: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck: true
                },
                txtConformacion_Contrasena: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck: true,
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
                    passwordcheck: true
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
                

        //para personas morales
        $("#txtNumero_Exterior_Fiscal").keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });


        $("#txtNumero_Interior_Fiscal").keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });

        $("#txtCP_Fiscal").keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });


        //para personas fisicas
        $("#txtNumero_Interior_Particular").keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });


        $("#txtNumero_Exterior_Particular").keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });

        $("#txtCP_Particular").keydown(function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });


        $("#txtNombres").keypress(function(event) {
            var inputValue = event.charCode;
            console.log("chispas");
            if (!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) || (
                    inputValue == 32) || (inputValue == 0))) {
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
                txtNumeroCPParticular: {
                    minlength: 5,
                    maxlength: 5
                },
                txtCPFiscal: {
                    minlength: 5,
                    maxlength: 5
                }
            },
            messages: {
                txtNumeroCPParticular: {
                    minlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                    maxlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                    required: ""
                },
                txtCPFiscal: {
                    minlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                    maxlength: "El tamaño del campo debe contener 5 dígitos, sin espacios ni guiones.",
                    required: ""
                }
            }
        });

        

        $('.repeater').repeater({
            initEmpty: BolSucursal,
            ready: function () {
                var element = $(this);
                var index = element.index();
                $(this).slideDown();
                TRAM_AJX_CARGAR_MUNICIPIOS_SUCURSAL(index);
                TRAM_AJX_CARGAR_ESTADOS_SUCURSAL(index);
                TRAM_AJX_CARGAR_PAISES_SUCURSAL(index);
            },
            show: function () {
                var element = $(this);
                var index = element.index();
                $(this).slideDown();
                TRAM_AJX_CARGAR_MUNICIPIOS_SUCURSAL(index);
                TRAM_AJX_CARGAR_ESTADOS_SUCURSAL(index);
                TRAM_AJX_CARGAR_PAISES_SUCURSAL(index);
                $('.optionsMunicipioSucursal').change(function(){              
                    var value = $(this).val();
                    var name = $(this).attr("name");
                    var resultado = name.split("]");
                    
                    TRAM_AJX_CARGAR_LOCALIDADES_SUCURSAL(value,index);
                        
                });

                setTimeout(function() {
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
                }, 3000);
            }
        });

        //Tipo de persona
        if (StrTipoPersona == "FISICA") {
            $(".divRazon_Social").hide();
            $(".divCurp").show();
            $("#divTxtRepresentante").hide();
            $(".divDomicilio_Particular").hide();
            $(".divCurp_Moral").hide();

            $('#txtCalle_Particular').prop('required', true);
            $('#txtNumero_Exterior_Particular').prop('required', true);
            $('#txtCP_Particular').prop('required', true);
            $('#cmbColonia_Particular').prop('required', true);
            $('#cmbMunicipio_Particular').prop('required', true);
            $('#cmbEstado_Particular').prop('required', true);
            $('#cmbPais_Particular').prop('required', true);

            $('#txtCalle_Fiscal').prop('required', false);
            $('#txtNumero_Exterior_Fiscal').prop('required', false);
            $('#txtCP_Fiscal').prop('required', false);
            $('#cmbColonia_Fiscal').prop('required', false);
            $('#cmbMunicipio_Fiscal').prop('required', false);
            $('#cmbEstado_Fiscal').prop('required', false);
            $('#cmbPais_Fiscal').prop('required', false);

            $('#txtCurpFisica').prop('required', true);
            $('#txtCurpMoral').prop('required', false);

            $('#txtRazon_Social').prop('required', false);

        } else {
            $(".divRazon_Social").show();
            $(".divCurp").hide();
            $("#divTxtRepresentante").show();
            $(".divDomicilio_Particular").hide();
            $(".divCurp_Moral").show();

            $('#txtCalle_Particular').prop('required', false);
            $('#txtNumero_Exterior_Particular').prop('required', false);
            $('#txtCP_Particular').prop('required', false);
            $('#cmbColonia_Particular').prop('required', false);
            $('#cmbMunicipio_Particular').prop('required', false);
            $('#cmbEstado_Particular').prop('required', false);
            $('#cmbPais_Particular').prop('required', false);

            $('#txtCalle_Fiscal').prop('required', true);
            $('#txtNumero_Exterior_Fiscal').prop('required', true);
            $('#txtCP_Fiscal').prop('required', true);
            $('#cmbColonia_Fiscal').prop('required', true);
            $('#cmbMunicipio_Fiscal').prop('required', true);
            $('#cmbEstado_Fiscal').prop('required', true);
            $('#cmbPais_Fiscal').prop('required', true);

            $('#txtCurpFisica').prop('required', false);
            $('#txtCurpMoral').prop('required', true);
            $('#txtRazon_Social').prop('required', true);
        }

        //RFC
        $('#txtRfc').change(function() {
            var value = $(this).val();
            TRAM_FN_VALIDAR_INPUT_RFC(value);
            TRAM_AJX_VALIDAR_RFC(value);
        });

        //CURP
        $(".txtCurp").change(function() {
            var value = $(this).val();
            TRAM_FN_VALIDAR_INPUNT_CURP(value);

            if(curpPrincipal == value){
                return;
            }
            let id = $("#txtIdUsuario").val();
            $.get('/registrar/validar_curp/' + value.toUpperCase()+"/"+id, function(data) {
                //Validamos si existe un usuario con el correo capturado
                if (data.status != "success") {
                    
                    $(".iconCurp_Valido").hide();
                    $(".resultadoValidTextCurp").html(
                    "<span style='color: red;'>¡Error!</span> El CURP ya existe en el sistema.");
                    curpPrincipalValido = 0;
                } else {
                   
                    if(curpPrincipalValido == 1){

                        $(".iconCurp_Valido").show();
                        $(".resultadoValidTextCurp").html("");
                        curpPrincipalValido = 1;

                    }
                }
            });

        });

        //Correo
        $('#txtCorreo_Electronico').change(function() {
            var value = $(this).val();
            TRAM_AJX_VALIDAR_CORREO(value);
        });

        //Correo resultadoExistCorreoElectronico
        $('#txtCorreo').change(function() {
            var value = $(this).val();
            //TRAM_AJX_VALIDAR_CORREO_ERROR(value,'#txtCorreo','#resultadoExistCorreoElectronico');

            var reg = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

            if (reg.test(value)) {
                emailPrimarioValido = 1;
                $('#resultadoExistCorreoElectronico').html("");
            } else {
                emailPrimarioValido = 0;
                $('#resultadoExistCorreoElectronico').html("<span style='color: red;'>El correo electrónico no es valido</span>");
                return;
            }

            if(emailPrimario == value){
                return;
            }

            $.get('/registrar/validar_correo/' + value, function(data) {
                //Validamos si existe un usuario con el correo capturado
                if (data.status == "success") {
                    
                    $('#resultadoExistCorreoElectronico').html("<span style='color: red;'>El correo electrónico ya existe en el sistema</span>");
                    emailPrimarioValido = 0;
                } else {
                    $('#resultadoExistCorreoElectronico').html("");
                    emailPrimarioValido = 1;
                }
            });
        });

        //Correo resultadoExistCorreoElectronico
        $('#txtCorreoAlternativo').change(function() {
            var value = $(this).val();
            //TRAM_AJX_VALIDAR_CORREO_ERROR(value,'#txtCorreo','#resultadoExistCorreoElectronico');

            var reg = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

            if (reg.test(value)) {
                emailAlternativoValido = 1;
                $('#resultadoExistCorreoElectronicoAlternativo').html("");
            } else {
                emailAlternativoValido = 0;
                $('#resultadoExistCorreoElectronicoAlternativo').html("<span style='color: red;'>El correo electrónico no es valido</span>");
                return;
            }

            if(emailAlternativo == value){
                return;
            }

            $.get('/registrar/validar_correo/' + value, function(data) {
                //Validamos si existe un usuario con el correo capturado
                if (data.status == "success") {
                    $('#resultadoExistCorreoElectronicoAlternativo').html("<span style='color: red;'>El correo electrónico ya existe en el sistema</span>");
                    emailAlternativoValido = 0;
                } else {
                    $('#resultadoExistCorreoElectronicoAlternativo').html("");
                    emailAlternativoValido = 1;
                }
            });
        });

        document.getElementById('telefonoPersonaAutorizada').addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });

        document.getElementById('USUA_CTEL_LOCAL').addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });

        $("#correoPersonaAutorizada").change(function(){
            var value = $(this).val();
            emailRegex = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
            if(value == ""){
                emailPAValido = 0;
                $("#errorPAutorizada").html("<span style='color: red;'> El correo es requerido.</span>");
            }
           
            if (!emailRegex.test(value)) {
                emailPAValido = 0;
                $("#errorPAutorizada").html("<span style='color: red;'>El correo electrónico no es valido.</span>");
            }
            else{
                emailPAValido = 1;
                $("#errorPAutorizada").html("");
            }
        });

        //Mismo domicilio
        $("#chbDomicilio_Mismo").click(function() {
            if ($(this).is(':checked')) {
                $('#txtCalle_Fiscal').prop('value', $('#txtCalle_Particular').val());
                $('#txtNumero_Interior_Fiscal').prop('value', $('#txtNumero_Interior_Particular')
                    .val());
                $('#txtNumero_Exterior_Fiscal').prop('value', $('#txtNumero_Exterior_Particular')
                    .val());
                $('#txtCP_Fiscal').prop('value', $('#txtCP_Particular').val());
                $('#cmbColonia_Fiscal').prop('value', $('#cmbColonia_Particular').val());
                $('#cmbMunicipio_Fiscal').prop('value', $('#cmbMunicipio_Particular').val());
                $('#cmbEstado_Fiscal').prop('value', $('#cmbEstado_Particular').val());
                $('#cmbPais_Fiscal').prop('value', $('#cmbPais_Particular').val());
            } else {
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
        $('#txtCorreo_RFC_Electronico').change(function() {
            var value = $(this).val();

            if (rolCat == "CDNS") {


                if (TRAM_FN_VALIDA_CORREO(value)) {
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
                } else {
                    TRAM_FN_VALIDAR_INPUT_RFC_RECUPERAR_CONTRASENA(value);
                }

            }
        });
        listarDocs();
        listarResolutivos()
        verHDocsHistory();
        $.LoadingOverlaySetup({
            background: "rgba(0, 0, 0, 0.5)",
            image: "",
            fontawesome: "fa fa-cog fa-spin",
            imageColor: "#ffcc00"
        });

    });

    function listarDocs() {
        $('#tbl_listado').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "Cargando...",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }

            },
            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginación y filtrado realizados por el servidor
            "ajax": {
                url: '/perfil/listarDocs',
                type: "get",
                dataType: "json",
                error: function(e) {
                    console.log("manuel", e);
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5, //Paginación
            "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
        }).DataTable();

    }

    function listarResolutivos() {
        $('#tbl_resolutivos').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "Cargando...",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }

            },
            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginación y filtrado realizados por el servidor
            "ajax": {
                url: '/perfil/listarResolutivos',
                type: "get",
                dataType: "json",
                error: function(e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5, //Paginación
            "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
        }).DataTable();

    }
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
    function TRAM_FN_ENABLE(StrInput, IntTipo) {
        var StrIdentificador = IntTipo == 1 ? "#" : ".";
        if ($(StrIdentificador + StrInput).is(':disabled')) {
            $(StrIdentificador + StrInput).prop("disabled", false);
        } else {
            $(StrIdentificador + StrInput).prop("disabled", true);
        }
    };

    function TRAM_FN_DISABLED_INPUT() {
        $("input").each(function() {
            $(this).attr("disabled", true);
        });
        $("select").each(function() {
            $(this).attr("disabled", true);
        });
    };

    function TRAM_FN_ENABLED_INPUT() {
        $("input").each(function() {
            $(this).removeAttr('disabled');
        });
        $("select").each(function() {
            $(this).removeAttr('disabled');
        });
    };

    function TRAM_AJX_GUARDAR() {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        /* $("#btnSubmit").prop("disabled", true); */
        const validator = $('#frmForm').validate({onkeyup: false});
        if(emailPrimarioValido == 0) {
            return;
        }

        if(emailAlternativoValido == 0){
            return;
        }

        if(curpPrincipalValido == 0) {
            return;
        }

        if(emailPAValido == 0) {
            return;
        }

        let CPA = $("#correoPersonaAutorizada").val();
        if(CPA == ""){
            $("#errorPAutorizada").html("<span style='color: red;'> El correo es requerido.</span>");
        }

        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        if(!emailRegex.test(CPA)) {
            $("#errorPAutorizada").html("<span style='color: red;'> El correo que se agregó no es válido, se requiere verificar.</span>");
            return;
        }
        else{
            $("#errorPAutorizada").html("");
        }

       
        if (!validator.form()) {
            console.log("entre");
            const errorMap = validator.errorMap;

            $('.listError').hide();

            if(errorMap){
                if(errorMap.telefonoPersonaAutorizada){
                    $('#telefonoPersonaAutorizada-error').html('<b style="color: red;">Favor de poner en el formato (999) 999-9999</b>');
                }
                if(errorMap.txtCorreo){
                    $('#txtCorreo-error').html('<b style="color: red;">Correo inválido</b>');
                }
                if(errorMap.txtCorreoAlternativo){
                    $('#txtCorreoAlternativo-error').html('<b style="color: red;">Correo inválido</b>');
                }
            }

            var htmlError =
                "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
            $.each(validator.errorList, function(index, value) {
                var campo = $("#" + value.element.id).attr('placeholder') == undefined ? $("#" + value.element
                    .id).attr('title') : $("#" + value.element.id).attr('placeholder');
                if (value.method == "required") {
                    $('.listError').show();
                    htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                }
            });
            htmlError +=
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $(".listError").html(htmlError);
            $("#btnSubmit").prop("disabled", false);
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            TRAM_FN_DISABLED_INPUT();

            return;
        }
        else{
            $("#btnSubmit").prop("disabled", true);
            TRAM_FN_ENABLED_INPUT();
            $.ajax({
                data: $('#frmForm').serialize(),
                url: "/perfil/modificar",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $("#btnSubmit").prop("disabled", false);
                    TRAM_FN_DISABLED_INPUT();
                    if (data.status == "success") {
                        // $('#frmForm').trigger("reset");
                        // $(".listError").html("");
                        // TRAM_FN_TRAMITE();
                        Swal.fire({
                            title: '¡Aviso!',
                            text: data.message,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
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
                error: function(data) {
                    $("#btnSubmit").prop("disabled", false);
                    TRAM_FN_DISABLED_INPUT();
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
       
       /*   */
    };

    //Redirige a login
    function TRAM_FN_TRAMITE() {
        document.location.href = '/tramite_servicio';
    };

    //Confirmar cuenta
    function TRAM_FN_CONFIRMAR_PERFIL() {
        $("#ModalConfirmarCuenta").modal("show");
    };

    //Cambiar contraseña
    function TRAM_FN_CAMBIAR_CONTRASENA() {
        $("#ModalCambiarContrasena").modal("show");
    };

    //Ajx validar cuenta
    function TRAM_AJX_CONFIRMAR_PERFIL() {
        $("#btnSubmitConfirmaCuenta").prop("disabled", true);
        if (!$("#frmFormConfirmar_Cuenta").valid()) {
            $('.listErrorConfirmarCuenta').hide();
            var validator = $('#frmFormConfirmar_Cuenta').validate();
            var htmlError =
                "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
            $.each(validator.errorList, function(index, value) {
                var campo = $("#" + value.element.id).attr('placeholder') == undefined ? $("#" + value.element
                    .id).attr('title') : $("#" + value.element.id).attr('placeholder');
                if (value.method == "required") {
                    $('.listErrorConfirmarCuenta').show();
                    htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                }
            });
            htmlError +=
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $(".listErrorConfirmarCuenta").html(htmlError);
            $("#btnSubmitConfirmaCuenta").prop("disabled", false);
            return;
        }


        var rolCat = '{{ $usuario->TRAM_CAT_ROL->ROL_CCLAVE }}';
        if (rolCat == "CDNS") {
            //para ciudadanos

            $.ajax({
                data: $('#frmFormConfirmar_Cuenta').serialize(),
                url: "/perfil/confirmar",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                    if (data.status == "success") {
                        $('#frmFormConfirmar_Cuenta').trigger("reset");
                        $(".listErrorConfirmarCuenta").html("");
                        $("#ModalConfirmarCuenta").modal("hide");
                        TRAM_FN_CAMBIAR_CONTRASENA();
                    } else {
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
                error: function(data) {

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
        } else {
            //para servidores publicos

            $.ajax({
                data: $('#frmFormConfirmar_Cuenta').serialize(),
                url: "/perfil/confirmarServidor",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                    if (data.status == "success") {
                        $('#frmFormConfirmar_Cuenta').trigger("reset");
                        $(".listErrorConfirmarCuenta").html("");
                        $("#ModalConfirmarCuenta").modal("hide");
                        TRAM_FN_CAMBIAR_CONTRASENA();
                    } else {
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
                error: function(data) {

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
    function TRAM_AJX_CAMBIAR_CONTRASENA() {
        $("#btnSubmitCambiarContrasena").prop("disabled", true);
        if (!$("#frmFormCmabiar_Contrasena").valid()) {
            $('.listErrorCambiarContrasena').hide();
            var validator = $('#frmFormCmabiar_Contrasena').validate();
            var htmlError =
                "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
            $.each(validator.errorList, function(index, value) {
                var campo = $("#" + value.element.id).attr('placeholder') == undefined ? $("#" + value.element
                    .id).attr('title') : $("#" + value.element.id).attr('placeholder');
                if (value.method == "required") {
                    $('.listErrorCambiarContrasena').show();
                    htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                }
            });
            htmlError +=
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $(".listErrorCambiarContrasena").html(htmlError);
            $("#btnSubmitCambiarContrasena").prop("disabled", false);
            return;
        }
        $.ajax({
            data: $('#frmFormCmabiar_Contrasena').serialize(),
            url: "/cambiar_contrasena",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $("#btnSubmitCambiarContrasena").prop("disabled", false);
                if (data.status == "success") {
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
                } else {
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
            error: function(data) {
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
    function TRAM_FN_VALIDAR_RFC(rfc, aceptarGenerico = true) {
        const re =
            /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
        var validado = rfc.match(re);

        if (!validado) //Coincide con el formato general del regex?
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
        if ((digitoVerificador != digitoEsperado) &&
            (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
            return false;
        else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
            return false;
        return rfcSinDigito + digitoVerificador;
    };

    //Handler para el evento cuando cambia el input
    // -Lleva la RFC a mayúsculas para validarlo
    // -Elimina los espacios que pueda tener antes o después
    function TRAM_FN_VALIDAR_INPUT_RFC(input) {
        //Validar valor
        if (input == null || input == undefined || input == "") {} else {
            var newValue = input;
            var rfc = newValue.trim().toUpperCase();
            var rfcCorrecto = TRAM_FN_VALIDAR_RFC(rfc); // Acá se comprueba
            if (rfcCorrecto) {
                setTimeout(function() {
                    $(".btnSubmit").prop("disabled", false);
                }, 1000);
                $("#iconRfc_Valido").show();
                $("#resultadoValidText").html("");
            } else {
                setTimeout(function() {
                    $(".btnSubmit").prop("disabled", true);
                }, 1000);
                $("#iconRfc_Valido").hide();
                $("#resultadoValidText").html(
                    "<span style='color: red;'>¡Error!</span> El RFC no es válido, favor de verficar.");
            }
            //toUpperCase
            $("#txtRfc").val(rfc);
        }
    };

    function TRAM_FN_VALIDAR_INPUT_RFC_RECUPERAR_CONTRASENA(input) {
        var rolCat = '{{ $usuario->TRAM_CAT_ROL->ROL_CCLAVE }}';
        //Validar valor
        if (input == null || input == undefined || input == "") {} else {
            var newValue = input;
            var rfc = newValue.trim().toUpperCase();
            var rfcCorrecto = TRAM_FN_VALIDAR_RFC(rfc); // Acá se comprueba
            if (rfcCorrecto) {
                setTimeout(function() {
                    $("#btnSubmitConfirmaCuenta").prop("disabled", false);
                }, 1000);
                $(".resultadoValidText").html("");
            } else {
                setTimeout(function() {
                    $("#btnSubmitConfirmaCuenta").prop("disabled", true);
                }, 1000);


                if (rolCat == "CDNS") {
                    // es un ciudadano
                    $(".resultadoValidText").html(
                        "<span style='color: red;'>¡Error!</span> El RFC  o Correo no es válido, favor de verficar."
                    );
                } else {
                    $(".resultadoValidText").html(
                        "<span style='color: red;'>¡Error!</span> El Correo que se agregó no es válido, favor de verficar."
                    );
                }

            }
            //toUpperCase
            $("#txtCorreo_RFC_Electronico").val(rfc);
        }
    };

    function TRAM_FN_VALIDAR_CURP(params) {
        var reg = "";
        var curp = params;

        if (curp.length == 18) {
            var digito = calculaDigito(curp);
            reg =
                /^([A-Z]{4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[A-Z]{3}[0-9A-Z]\d)$/i;

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
    function TRAM_FN_VALIDAR_INPUNT_CURP(input) {
        var newValue = input;
        if (input == null || input == undefined || input == "") {} else {
            var curp = newValue.trim().toUpperCase();
            if (TRAM_FN_VALIDAR_CURP(curp)) { // Acá se comprueba
                setTimeout(function() {
                    $(".btnSubmit").prop("disabled", false);
                }, 1000);
                $(".iconCurp_Valido").show();
                $(".resultadoValidTextCurp").html("");
                curpPrincipalValido = 1;
            } else {
                setTimeout(function() {
                    $(".btnSubmit").prop("disabled", false);
                }, 1000);
                $(".iconCurp_Valido").hide();
                $(".resultadoValidTextCurp").html(
                    "<span style='color: red;'>¡Error!</span> El CURP no es válido, favor de verficar.");
                    curpPrincipalValido = 0;
            }
            $(".txtCurp").val(curp);
        }
    }

    //Validar si el rfc existe
    function TRAM_AJX_VALIDAR_RFC(StrRfc) {
        $.get('/registrar/validar_rfc/' + StrRfc, function(data) {
            //Validamos si existe un usuario con el rfc capturado
            if (data.status == "success") {
                setTimeout(function() {
                    $(".btnSubmit").prop("disabled", true);
                }, 1000);
                $("#txtRfc").attr("aria-invalid", "true");
                $("#txtRfc").addClass("error");
                $("#resultadoExistRfc").html("<span style='color: red;'>" + data.message + "</span>");
            } else {
                $("#txtRfc").attr("aria-invalid", "false");
                $("#txtRfc").removeClass("error");
                $("#resultadoExistRfc").html("");
            }
        });
    };

    //Validar si el correo existe
    function TRAM_AJX_VALIDAR_CORREO(StrCorreo) {
        $.get('/registrar/validar_correo/' + StrCorreo, function(data) {
            //Validamos si existe un usuario con el correo capturado
            if (data.status == "success") {
                setTimeout(function() {
                    $(".btnSubmit").prop("disabled", true);
                }, 1000);
                $("#txtRfc").attr("aria-invalid", "true");
                $("#txtRfc").addClass("error");
                $("#resultadoExistCorreo").html("<span style='color: red;'>" + data.message + "</span>");
            } else {
                setTimeout(function() {
                    $(".btnSubmit").prop("disabled", false);
                }, 1000);
                $("#txtRfc").attr("aria-invalid", "false");
                $("#txtRfc").removeClass("error");
                $("#resultadoExistCorreo").html("");
            }
        });
    };

   
    function deleteDocUser(id) {

        Swal.fire({
            title: '',
            text: "¿Desea eliminar el documento?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteDocs(id);
            }
        });
    }

    function deleteDocs(id) {
        $.LoadingOverlay("show");
        var formData = new FormData()
        formData.append('id', id)
        $.ajax({
            data: formData,
            url: "/perfil/eliminarDoc",
            type: "POST",
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(data) {
                //console.log(data)
                listarDocs()
                Swal.fire('Éxito', data, 'success')
                $.LoadingOverlay("hide");
            }
        })
    }

    function enviarDoc(id) {
        var file        = $('input[name="doc' + id + '"]').val()
        var extension   = file.substr((file.lastIndexOf('.') + 1));
        var size        = $('input[name="doc' + id + '"]')[0].files[0].size;
        var kb          = (size / 1024);
        var mb          = (kb / 1024);
        console.log(extension, size, mb.toFixed(3));

        if(mb.toFixed(3) > 5){
            $('input[name="doc' + id + '"]').val('');
            Swal.fire({ 
                title: 'Error!',
                text: 'El archivo debe de pesar menos de 5Mb',
                icon: 'error',
                confirmButtonText: 'Ok'
            })
            return ;
        }
        if(extension != "pdf"){
            $('input[name="doc' + id + '"]').val('');
            Swal.fire({ 
                title: 'Error!',
                text: 'Solo se permite PDF',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }

        Swal.fire({
            title: '',
            text: "¿Desea guardar el documento?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                $.LoadingOverlay("show");
                var doc         = $('input[name="doc' + id + '"]')[0].files[0];
                var formData    = new FormData()

                formData.append('documento', doc)
                formData.append('tipo', id)
                formData.append('formato', extension)
                formData.append('peso', size)
                console.log(doc);
                $.ajax({
                    data: formData,
                    url: "/perfil/guardarDocs",
                    type: "POST",
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function(data) {
                        listarDocs()
                        Swal.fire('Éxito', data, 'success')
                        $.LoadingOverlay("hide");
                        $('input[name="doc' + id + '"]').val('');
                    }
                })
            } else {
                $('input[name="doc' + id + '"]').val('');
            }
        });
    }

    function guardarDoc(id, e) {
        e.preventDefault();
        $('input[name="doc' + id + '"]').click();
        $('input[name="doc' + id + '"]').on('change', function() {
            enviarDoc(id);
        });

    }

    function hideSaveCancel(flag) {
        if (flag) {
            $("#sendDatos").hide();
        } else {
            $("#sendDatos").show();
        }

    }

    function verHDocsHistory() {
        //$("#verDocsD").modal('toggle');

        $('#tbl_history').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "Cargando...",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }

            },
            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginación y filtrado realizados por el servidor
            "ajax": {
                url: '/perfil/getHistory',
                type: "get",
                dataType: "json",
                error: function(e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5, //Paginación
            "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
        }).DataTable();
    }

    function verHDocs(id) {
        $("#verDocsD").modal('toggle');

        $('#tbl_historyexp').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "Cargando...",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }

            },
            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginación y filtrado realizados por el servidor
            "ajax": {
                url: '/perfil/getDocsHistoryExpediente/' + id,
                type: "get",
                dataType: "json",
                error: function(e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5, //Paginación
            "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
        }).DataTable();
    }

    function setActual(id) {
        var formData = new FormData()
        formData.append('id', id)
        $.ajax({
            data: formData,
            url: "/perfil/setActual",
            type: "POST",
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(data) {
                $("#verDocsD").modal('toggle');
                Swal.fire('Éxito', data, 'success')
                listarDocs();
            }
        })
    }

    var listadoMunicipios = [];
    var listadoEstados    = [];
    var listadoPaises     = [];
    var listadoLocalidades     = [];

    function TRAM_AJX_CARGAR_PAISES(){
        var paisDefault = 'México';
        
            var html = '<select class="combobox form-control" name="txtPaisParticular" id="txtPaisParticular"  title="País">';
            var htmlFiscal = '<select class="combobox form-control" name="txtPaisFiscal" id="txtPaisFiscal" title="País">';

            listadoPaises.push({"DESCRIPCION": paisDefault});

            html += '<option value="'+ paisDefault +'">' + paisDefault + '</option>';
            htmlFiscal  += '<option value="'+ paisDefault +'">' + paisDefault + '</option>';
        
            html += '</select>';
            htmlFiscal += '</select>';

            $("#selectcmbPais_Particular").html(html);
            $("#selectcmbPais_Fiscal").html(htmlFiscal);
    }
    TRAM_AJX_CARGAR_PAISES();

    function TRAM_AJX_CARGAR_ESTADOS(){
        var url = '/registrar/estados';
        $.get(url, function (data) {
            listadoEstados = data;
            var selectedParticular = "";
            var selectedFiscal = "";
            
            var html = '<select class="combobox form-control" name="txtEstadoParticular" id="txtEstadoParticular" onchange="TRAM_AJX_CARGAR_MUNICIPIOS(this, 1)" title="Estado">';
            var htmlFiscal = '<select class="combobox form-control" name="txtEstadoFiscal" id="txtEstadoFiscal" onchange="TRAM_AJX_CARGAR_MUNICIPIOS(this, 2)" title="Estado">';
            
            data.forEach(function(value) {
                if(value.Id == Number(estadoParticular)){
                    selectedParticular = "selected";
                    let selValP = {"value": estadoParticular};
                    TRAM_AJX_CARGAR_MUNICIPIOS(selValP, 1);
                }else {
                    selectedParticular = "";
                }
                if(value.Id == estadoFiscal){
                    selectedFiscal = "selected";
                    let selValF = {"value": estadoFiscal};
                    TRAM_AJX_CARGAR_MUNICIPIOS(selValF, 2);
                }else {
                    selectedFiscal = "";
                }

                html        += '<option value="">Selecciona un estado</option>';
                html        += '<option value="'+ value.Id +'" '+selectedParticular+'>' + value.Name + '</option>';
                htmlFiscal  += '<option value="">Selecciona un estado</option>';;
                htmlFiscal  += '<option value="'+ value.Id +'" '+selectedFiscal+'>' + value.Name + '</option>';
                
            });
            html += '</select>';
            htmlFiscal += '</select>';

            $("#selectcmbEstado_Particular").html(html);
            $("#selectcmbEstado_Fiscal").html(htmlFiscal);
            
        });
    }
    TRAM_AJX_CARGAR_ESTADOS();

    function TRAM_AJX_CARGAR_MUNICIPIOS(id, type){
        var url = '/registrar/municipios/'+id.value;
        $.get(url, function (data) {
            listadoMunicipios = data;
            var selectedParticular2 = "";
            var selectedFiscal2 = "";

            var html = '<select class="combobox form-control" name="txtMunicipioParticular" id="txtMunicipioParticular" onchange="TRAM_AJX_CARGAR_LOCALIDADES(this, 1)" title="Municipio">';
            var htmlFiscal = '<select class="combobox form-control" name="txtMunicipioFiscal" id="txtMunicipioFiscal" onchange="TRAM_AJX_CARGAR_LOCALIDADES(this, 2)" title="Municipio">';
            var htmlSucursal = '';

            html        += '<option value="" selected="true" disabled="disabled">Seleccione...</option>';
            htmlFiscal  += '<option value="" selected="true" disabled="disabled">Seleccione...</option>';
            htmlSucursal += '<option value="" selected="true" disabled="disabled">Seleccione...</option>';

            data.forEach(function(value) {
                if(value.Id == municipioParticular){
                    selectedParticular2 = "selected";
                    let selValP = {"value": municipioParticular};
                    TRAM_AJX_CARGAR_LOCALIDADES(selValP, 1);
                }else {
                    selectedParticular2 = "";
                }
                if(value.Id == municipioFiscal){
                    selectedFiscal2 = "selected";
                    let selValF = {"value": municipioFiscal};
                    TRAM_AJX_CARGAR_LOCALIDADES(selValF, 2);
                }else {
                    selectedFiscal2 = "";
                }

                html        += '<option value="'+ value.Id +'" '+selectedParticular2+'>' + value.Name + '</option>';
                htmlFiscal  += '<option value="'+ value.Id +'" '+selectedFiscal2+'>' + value.Name + '</option>';
                htmlSucursal += '<option value="'+ value.Id +'">' + value.Name + '</option>';
            
            });
            html += '</select>';
            htmlFiscal += '</select>';

            if(type == 1){
                $("#selectcmbMunicipio_Particular").html(html);
            }else if(type == 2){
                $("#selectcmbMunicipio_Fiscal").html(htmlFiscal);
            }
        });
    }

    function TRAM_AJX_CARGAR_LOCALIDADES(id, type){
        var url = '/registrar/localidades/'+id.value;
        $.get(url, function (data) {          
            listadoLocalidades = data;
            var html = "";
            var htmlFiscal = "";
            var selectedParticular3 = "";
            var selectedFiscal3 = "";

            if(data.length == 0){
                html = '<option value="">Sin localidades</option>';
            }else {
                data.forEach(function(value) {
                    if(value.Id == coloniaParticular){
                        selectedParticular3 = "selected";
                    }else {
                        selectedParticular3 = "";
                    }
                    if(value.Id == coloniaFiscal){
                        selectedFiscal3 = "selected";
                    }else {
                        selectedFiscal3 = "";
                    }
                    html += '<option value="'+ value.Id +'" '+selectedParticular3+'>' + value.Name + '</option>';
                    htmlFiscal += '<option value="'+ value.Id +'" '+selectedFiscal3+'>' + value.Name + '</option>';
                });
            }

            if(type == 1){
                $(".optionsColoniaParticular").html(html);
            }else if(type == 2){
                $(".optionsColoniaFiscal").html(htmlFiscal);
            }
        });
    }

    function TRAM_AJX_CARGAR_PAISES_SUCURSAL(index){
        var paisDefault = 'México';
        var htmlSucursal = ''; 
        if(listadoPaises.length == 0){
            htmlSucursal += '<option value="'+ paisDefault +'">' + paisDefault + '</option>';
        }else{
            listadoPaises.forEach(function(value) {
                    htmlSucursal += '<option value="'+ value.DESCRIPCION +'">' + value.DESCRIPCION + '</option>';
                    });
        }
        var element = document.getElementsByName('lstSucursal['+index+'][cmbPais_Sucursal]');
        $(element).empty();
        $(element).append(htmlSucursal);
    }

    function TRAM_AJX_CARGAR_ESTADOS_SUCURSAL(index){
        var htmlSucursal = '';   
        listadoEstados.forEach(function(value) {
            htmlSucursal += '<option value="'+ value.Id +'">' + value.Name + '</option>';
        });
        
        var element = document.getElementsByName('lstSucursal['+index+'][cmbEstado_Sucursal]');
        $(element).empty();
        $(element).append(htmlSucursal);
    }

    function TRAM_AJX_CARGAR_MUNICIPIOS_SUCURSAL(index){
        var htmlSucursal = '<option value="" selected="true" disabled="disabled">Seleccione...</option>';   
        listadoMunicipios.forEach(function(value) {
            htmlSucursal += '<option value="'+ value.Id +'">' + value.Name + '</option>';
        });
            
        var element = document.getElementsByName('lstSucursal['+index+'][cmbMunicipio_Sucursal]');
        $(element).empty();
        $(element).append(htmlSucursal);
    }

    function TRAM_AJX_CARGAR_LOCALIDADES_SUCURSAL(municipio, index){
        $.get('/registrar/localidades/'+municipio, function (data) {          

            var html = '';   
            data.forEach(function(value) {
                html += '<option value="'+ value.Id +'">' + value.Name + '</option>';
            });

            var element = document.getElementsByName('lstSucursal['+index+'][cmbColonia_Sucursal]');
            $(element).empty();
            $(element).append(html);
        });
    }
</script>
@endsection
