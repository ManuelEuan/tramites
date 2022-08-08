@extends('layout.Layout')
@section('body')
<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-10" style="text-align: left;">
                    <h2 class="titulo">{{$tramite->USTR_CNOMBRE_TRAMITE}}</h2>
                    <h2 class="subtitulo">{{$tramite->USTR_CCENTRO}}</h2>
                </div>
                <div class="col-md-2" style="text-align: center;">
                    <p style="margin: 0px; font-size: 1rem; color:#393939;">Estatus de trámite</p>
                    @switch($tramite->USTR_NESTATUS)
                    @case(9)
                    <p class="text-danger" style="font-size: 1rem; font-weight: bold;">RECHAZADO</p>
                    @break
                    @case(8)
                    <p class="text-success" style="font-size: 1rem; font-weight: bold;">TERMINADO</p>
                    @break
                    @case(7)
                    <p style="font-size: 1rem; font-weight: bold; color: #6c757d;">EN PROCESO</p>
                    @break
                    @case(6)
                    <p style="font-size: 1rem; font-weight: bold; color: #6c757d;">ACCIÓN REQUERIDA</p>
                    @break
                    @case(5)
                    <p style="font-size: 1rem; font-weight: bold; color: #6c757d;">INICIADO</p>
                    @break
                    @case(4)
                    <p style="font-size: 1rem; font-weight: bold; color: #6c757d;">INFORMACIÓN INCOMPLETA</p>
                    @break
                    @case(3)
                    <p style="font-size: 1rem; font-weight: bold; color: #6c757d;">RECIBIDO</p>
                    @break
                    @case(2)
                    <p style="font-size: 1rem; font-weight: bold; color: #6c757d;">PENDIENTE DE REVISIÓN</p>
                    @break
                    @default
                    <p style="font-size: 1rem; font-weight: bold; color: #6c757d;">CAPTURA INICIAL</p>
                    @endswitch

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <ul id="rowTab" class="nav nav-tabs">
                @foreach($secciones as $seccion)
                @switch($seccion->SSEGTRA_CNOMBRE_SECCION)

                @case('Revisión de documentación')
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab_formulario_{{$secciones[0]->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_FN_RENDER_REVISION_DOCUMENTACION({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}, {{$secciones[$loop->index - 1]->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Revisión de documentación
                        @if($seccion->SSEGTRA_NIDESTATUS == 2)
                        <span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>
                        @endif
                    </a>
                </li>
                @break

                @case('Citas en línea')
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab_cita_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_FN_RENDER_CITA({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Citas en línea
                        @if($seccion->SSEGTRA_NIDESTATUS == 2)
                        <span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>
                        @endif
                    </a>
                </li>
                @break

                @case('Ventanilla sin cita')
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab_sincita_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_FN_RENDER_VENTANILLA({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Ventanilla sin cita
                        @if($seccion->SSEGTRA_NIDESTATUS == 2)
                        <span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>
                        @endif
                    </a>
                </li>
                @break

                @case('Pago en línea')
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab_pago_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_FN_RENDER_PAGO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Pago en línea
                        @if($seccion->SSEGTRA_NIDESTATUS == 2)
                        <span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>
                        @endif
                    </a>
                </li>
                @break

                @case('Módulo de análisis interno del área')
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab_analisis_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_FN_RENDER_ANALISIS_INTERNO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Módulo análisis interno del área
                        @if($seccion->SSEGTRA_NIDESTATUS == 2)
                        <span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>
                        @endif
                    </a>
                </li>
                @break

                @case('Resolutivo electrónico')
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab_resolutivo_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_FN_RENDER_RESOLUTIVO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Resolutivo electrónico
                        @if($seccion->SSEGTRA_NIDESTATUS == 2)
                        <span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>
                        @endif
                    </a>
                </li>
                @break

                @default
                <li>
                    <a class="nav-link active" data-toggle="tab" href="#tab_formulario_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_FN_RENDER_FORMULARIO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Formulario
                        @if($seccion->SSEGTRA_NIDESTATUS == 2)
                        <span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>
                        @endif
                    </a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab_formulario_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_FN_RENDER_REVISION({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Revisión de documentación
                        @if($seccion->SSEGTRA_NIDESTATUS == 2)
                        <span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>
                        @endif
                    </a>
                </li>
                @break
                @endswitch
                @endforeach
            </ul>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">

                                @foreach($secciones as $seccion)
                                @switch($seccion->SSEGTRA_CNOMBRE_SECCION)
                                @case('Revisión de documentación')

                                @break
                                @case('Citas en línea')
                                <div id="tab_cita_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" class="tab-pane fade pestana">
                                    @if(!($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2))

                                    <div class="row columna">
                                        <div class=" col-md-12">
                                            <div class="alert alert-warning" role="alert" style="font-size: 16px;">
                                                ¡Se requiere aprobar la sección anterior!
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <input type="hidden" value="" id="cita_id" />

                                    <div class="row columna">
                                        <div class=" col-md-4">
                                            <label class="titulo_cita">Estatus de la cita</label>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="respuesta_pequena" id="cita_status">...</label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-12">
                                            <label class="titulo_cita">Datos de la cita</label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-4">
                                            <label class="titulo_pequeno">Folio de cita</label> <br>
                                            <label class="respuesta_pequena" id='cita_folio'>...</label>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="titulo_pequeno">Fecha de cita</label> <br>
                                            <label class="respuesta_pequena" id='cita_fecha'>...</label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-4">
                                            <label class="titulo_pequeno">Hora de cita</label> <br>
                                            <label class="respuesta_pequena" id='cita_hora'>...</label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-4">
                                            <label class="titulo_pequeno">Nombre del trámite</label> <br>
                                            <label id="id_cita_tramite" class='respuesta_pequena'>{{$tramite->USTR_CNOMBRE_TRAMITE}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="titulo_pequeno">ID Accede</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_NIDTRAMITE_ACCEDE}}</label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-4">
                                            <label class="titulo_pequeno">Solicitante</label> <br>
                                            <label id="id_cita_tramite" class='respuesta_pequena'>{{$tramite->USTR_CNOMBRE_COMPLETO}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="titulo_pequeno">Correo</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CCORREO_ELECTRONICO}}</label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12" style="margin-top: 1%;">
                                                    <label class="titulo_pequeno">Edificio</label> <br>
                                                    <label class='respuesta_pequena' id='cita_edificio'>...</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" style="margin-top: 1%;">
                                                    <label class="titulo_pequeno">Unidad administrativa</label> <br>
                                                    <label class='respuesta_pequena'>{{$tramite->USTR_CCENTRO}}</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" style="margin-top: 1%;">
                                                    <label class="titulo_pequeno">Secretaria o Entidad</label> <br>
                                                    <label class='respuesta_pequena'>{{$tramite->USTR_CCENTRO}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div id="mapa_cita" style="height: 300px; width:100%;">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row columna_2">
                                        @if ($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2 && $seccion->SSEGTRA_NIDESTATUS != 2 && $tramite->USTR_NESTATUS < 8) <div style="width:100%">
                                            <div class="row" style="margin-bottom: 80px;">
                                                <div class="col-md-12">
                                                    <h3 class="indicaciones">Notificación al solicitante</h3>
                                                    <label>Favor de indicar los puntos que el solicitante requiere atender para validar este paso de su solicitud</label>
                                                    <small style="font-size: 12px; margin-top:5px; margin-bottom: 2px;" class="form-text text-muted">La notificación esta limitada a 1000 carácteres con HTML.</small>
                                                    <textarea name="txtAreaCita_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-12 mt-5 contenedorBtn">
                                                        <div class="text-right botones">
                                                            <button onclick="TRAM_FN_REPROGRAMAR_CITA({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-warning border btnLetras">Reprogramar</button>
                                                            <button onclick="TRAM_FN_RECHAZAR({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-danger border btnLetras">Rechazar trámite</button>
                                                            <button onclick="TRAM_FN_APROBAR_CITA({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-success border btnLetras">Aprobar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @break

                            @case('Ventanilla sin cita')
                            <div id="tab_sincita_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" class="tab-pane fade pestana">
                                @if(!($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2))
                                <div class="row columna">
                                    <div class=" col-md-12">
                                        <div class="alert alert-warning" role="alert" style="font-size: 16px;">
                                            ¡Se requiere aprobar la sección anterior!
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row columna">
                                    <div class=" col-md-4">
                                        <label class="titulo_cita">Estatus</label>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="respuesta_cita">{{$seccion->SSEGTRA_NIDESTATUS == 2 ? 'Aprobado' : 'Pendiente'}}</label>
                                    </div>
                                </div>
                                <div class="row columna">
                                    <div class="col-md-12">
                                        <label class="titulo_cita">Datos de ventanilla</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="row columna">
                                                <div class="col-md-12">
                                                    <label class="titulo_pequeno">Folio del trámite</label> <br>
                                                    <label class='respuesta_pequena'>{{$tramite->USTR_CFOLIO}}</label>
                                                </div>
                                            </div>
                                            <div class="row columna">
                                                <div class="col-md-12">
                                                    <label class="titulo_pequeno">Nombre del trámite</label> <br>
                                                    <label class='respuesta_pequena'>{{$tramite->USTR_CNOMBRE_TRAMITE}}</label>
                                                </div>
                                            </div>
                                            {{-- <div class="row columna_2">
                                                <div class="col-md-12">
                                                    <label class="titulo_pequeno">Edificio</label> <br>
                                                    <label class='respuesta_pequena'>Calle Juan Aldama 901, Zona Centro, Chihuahua, Chih.</label>
                                                </div>
                                            </div> --}}
                                            <div class="row columna_2">
                                                <div class="col-md-12">
                                                    <label class="titulo_pequeno">Ventanilla</label> <br>
                                                    <label class='respuesta_pequena'>{{$tramite->EDF_VENTANILLA_SIN_CITA}}</label>
                                                </div>
                                            </div>
                                            <div class="row columna_2">
                                                <div class="col-md-12">
                                                    <label class="titulo_pequeno">Unidad administrativa</label> <br>
                                                    <label class='respuesta_pequena'>{{$tramite->USTR_CUNIDADADMINISTRATIVA}}</label>
                                                </div>
                                            </div>
                                            <div class="row columna_2">
                                                <div class="col-md-12">
                                                    <label class="titulo_pequeno">Secretaria o Entidad</label> <br>
                                                    <label class='respuesta_pequena'>{{$tramite->USTR_CCENTRO}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="mapaEdificioVentanilla" style="width: 100%; height:25rem;">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                @if($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2 && $seccion->SSEGTRA_NIDESTATUS != 2 && $tramite->USTR_NESTATUS < 8) <div class="col-md-12 mt-5">
                                    <div class="text-right botones">
                                        <button onclick="TRAM_FN_RECHAZAR({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-danger border btnLetras">Rechazar trámite</button>
                                        <button onclick="TRAM_FN_APROBAR_VENTANILLA({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-success border btnLetras">Aprobar visita</button>
                                    </div>

                            </div>
                            @endif
                        </div>
                        @break

                        @case('Pago en línea')
                        <div id="tab_pago_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" class="tab-pane fade pestana">
                            @if(!($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2))
                            <div class="row columna">
                                <div class=" col-md-12">
                                    <div class="alert alert-warning" role="alert" style="font-size: 16px;">
                                        ¡Se requiere aprobar la sección anterior!
                                    </div>
                                </div>
                            </div>
                            @endif
			    @if($seccion->SSEGTRA_PAGADO == 1)
                            	<div class="alert alert-success" role="alert" style="font-size: 16px">
				   ¡Pago realizado con éxito!
				</div>
			    @endif
                            @if($conceptos > 0 && $tramite->USTR_NESTATUS < 8)
                            <form id="frmFormConceptos_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" name="frmFormConceptos_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">
                                <input type="hidden" name="txtIdUsuarioTramite" value="{{$tramite->USTR_NIDUSUARIOTRAMITE}}">
                                <input type="hidden" name="txtIdSeccion" value="{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Referencia</th>
                                            <th scope="col">Concepto</th>
                                            <th scope="col">¿Aplica?</th>
                                            <th scope="col">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($conceptos as $con)
                                        @if($con->USCON_NIDSECCION == $seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO)
                                        <tr>
                                            <td>{{$con->USCON_NREFERENCIA}}</td>
                                            <td>{{$con->USCON_CONCEPTO}}</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" name="respc1_{{$con->USCON_NIDUSUARIOCONCEPTO}}" id="respc1_{{$con->USCON_NIDUSUARIOCONCEPTO}}" value="{{$con->USCON_NIDUSUARIOCONCEPTO}}" {{$con->USCON_NACTIVO == 1 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="respc1_{{$con->USCON_NIDUSUARIOCONCEPTO}}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" name="respc2_{{$con->USCON_NIDUSUARIOCONCEPTO}}" id="respc2_{{$con->USCON_NIDUSUARIOCONCEPTO}}" value="{{$con->USCON_NCANTIDAD}}">
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                </form>
                                @if($seccion->SSEGTRA_PAGADO == 0)
                                <button type="submit" class="btn btn-success float-right" id="guardar_concepto_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" onclick="TRAM_AJX_GUARDAR_CONCEPTOS({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" style="margin-right:10px;">Guardar</button>
                                @endif
                                @endif

                                <div class="row row-pago" id="pagos_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">
                                    <div class="col-md-12">
                                        <div class="row columna">
                                        <div class=" col-md-4">
                                            <label class="titulo_cita">Estatus del pago</label>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="respuesta_cita" id="txtEstatus_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}"></label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-12">
                                            <label class="titulo_cita">Datos del pago</label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-4">
                                            <label class="titulo_pequeno">Folio del trámite</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CFOLIO}}</label>
                                        </div>
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-12">
                                            <label class="titulo_pequeno">Nombre del trámite</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CNOMBRE_TRAMITE}}</label>
                                        </div>
                                    </div>

                                    <div class="row columna_2">
                                        <!-- <div class="col-md-4">
                                            <label class="titulo_pequeno">Fecha de pago</label> <br>
                                            <label class='respuesta_pequena'>1 de febrero de 2021</label>
                                        </div> -->
                                        <div class="col-md-6">
                                            <label class="titulo_pequeno">Número de referencia del pago</label> <br>
                                            <label class='respuesta_pequena' id="txtReferencia_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}"></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="titulo_pequeno">Número de referencia</label> <br>
                                            <label class='respuesta_pequena' id="txtIdReferencia_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">033-6622</label>
                                        </div>
                                        <div class="col-md-12">
                                           <!-- <label class="titulo_pequeno">Mensaje</label> <br>
                                            <label class='respuesta_pequena' id="txtMensaje_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">033-6622</label> -->
                                        </div>
                                    </div>
                                    <div class="row columna_2">
                                        <div class="col-md-12">
                                            <label class="titulo_pequeno">Unidad administrativa</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CUNIDADADMINISTRATIVA}}</label>
                                        </div>
                                    </div>
                                    <div class="row columna_2">
                                        <div class="col-md-12">
                                            <label class="titulo_pequeno">Secretaria o Entidad</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CCENTRO}}</label>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <br>
                                <div class="row columna_2">
                                    @if($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2 && $seccion->SSEGTRA_PAGADO == 1) <div style="width:100%">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12 mt-5 contenedorBtn">
                                                    <div class="text-right botones">
                                                        <button onclick="TRAM_FN_APROBAR_PAGO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-success border btnLetras">Aprobar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                @endif
                        </div>
                    </div>
                    @break

                    @case('Módulo de análisis interno del área')
                    <div id="tab_analisis_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" class="tab-pane fade pestana">
                        @if(!($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2))
                        <div class="row columna">
                            <div class=" col-md-12">
                                <div class="alert alert-warning" role="alert" style="font-size: 16px;">
                                    ¡Se requiere aprobar la sección anterior!
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row columna">
                            <div class=" col-md-12">
                                <label class="respuesta_cita">El trámite actualmente se encuentra en el módulo de analisis interno del área, por lo que los plazos del tramite siguen contando.</label>
                            </div>
                        </div>
                        <div class="row columna">
                            <div class="col-md-12">
                                <label class="titulo_pequeno">Fecha de recepción del tramite:</label> <br>
                                <label class='respuesta_pequena'>{{date("d/m/Y", strtotime($tramite->USTR_DFECHACREACION))}}</label>
                            </div>
                        </div>
                        <div class="row columna">
                            <div class="col-md-12">
                                <label class="titulo_pequeno">Días transcurridos desde el inicio del tramite:</label> <br>
                                <label class='respuesta_pequena' id="diastranscurridos">0</label>
                            </div>
                        </div>
                        <div class="row columna">
                            <div class="col-md-12">
                                <label class="titulo_pequeno">Exportar información del tramite: </label><br>
                                <span>
                                    <button onclick="descargar({{$tramite->USTR_NIDUSUARIOTRAMITE}}, 'TRAM_{{$tramite->USTR_CFOLIO}}')" type="button" class="btn btn-link"><i class="fas fa-download" style="color: black"></i></button>
                                </span>
                            </div>
                        </div>
                        <br>
                        @if($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2 && $seccion->SSEGTRA_NIDESTATUS != 2 && $tramite->USTR_NESTATUS < 8) <div class="col-md-12 mt-5 contenedorBtn">
                            <div class="text-right botones">
                                <button onclick="TRAM_FN_RECHAZAR({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-danger border btnLetras">Rechazar trámite </button>
                                <button onclick="TRAM_FN_APROBAR_ANALISIS_INTERNO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-success border btnLetras">Activar el siguiente módulo </button>
                            </div>
                    </div>
                    @endif
                </div>
                @break

                @case('Resolutivo electrónico')
                <div id="tab_resolutivo_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" class="tab-pane fade pestana">
                    @if(!($secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2))
                    <div class="row columna">
                        <div class=" col-md-12">
                            <div class="alert alert-warning" role="alert" style="font-size: 16px;">
                                ¡Se requiere aprobar la sección anterior!
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row columna">
                        <div class=" col-md-4">
                            <label class="titulo_cita">Resolutivo electrónico</label>
                        </div>
                    </div>
                    @foreach($resolutivos as $resolutivo)
                    <div class="row columna">
                        <div class=" col-md-4">
                            <label class="titulo_pequeno">Nombre</label>
                        </div>
                        <div class=" col-md-8">
                            <label class="respuesta_pequena">{{$resolutivo->RESO_CNOMBRE}}</label>
                        </div>
                    </div>
                    @endforeach
                    <div class="row columna">
                        <div class=" col-md-4">
                            <label class="titulo_pequeno">Estatus</label>
                        </div>
                        <div class="col-md-8">
                            @if($seccion->SSEGTRA_NIDESTATUS != 2)
                            <label class="respuesta_pequena">Pendiente</label>
                            @else
                            <label class="respuesta_pequena">Atendido</label>
                            @endif
                        </div>
                    </div>
                    @if($seccion->SSEGTRA_NIDESTATUS != 2 && $secciones[$loop->index - 1]->SSEGTRA_NIDESTATUS == 2 && $tramite->USTR_NESTATUS < 8) <form enctype="multipart/form-data">
                        <div class="row columna">
                            <div class="col-md-4">
                                <label class="titulo_pequeno">Estatus del resolutivo</label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="estatus_resolutivo_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" id="estatus_resolutivo_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">
                                    <option value="default" disabled>Seleccione una opción </option>
                                    <option value="aprobado">Aprobado</option>
                                    <option value="rechazado">Rechazado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row columna">
                            <div class="col-md-4">
                                <label class="titulo_pequeno">Cargar documento</label><br>
                                <small class="helper">Solo se acepta un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB</small>
                            </div>
                            <div class="col-md-4">
                                <input type="file" class="form-control-file" name="documento_resolutivo_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" id="documento_resolutivo_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">
                            </div>
                        </div>
                        <div class="col-md-12 mt-5 contenedorBtn">
                            <div class="text-right botones">
                                <button type="button" class="btn btn-success border btnLetras" onclick="TRAM_FN_EMITIR_RESOLUTIVO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})">Emitir resolutivo </button>
                            </div>
                        </div>
                        </form>
                        @else
                        <div class="row columna">
                            <div class=" col-md-4">
                                <label class="titulo_pequeno">Estatus del resolutivo</label>
                            </div>
                            <div class="col-md-8">
                                @if ($seccion->SSEGTRA_NIDESTATUS == 2)
                                Aprobado
                                @else
                                Pendiente
                                @endif
                            </div>
                        </div>
                        <div class="row columna">
                            <div class=" col-md-4">
                                <label class="titulo_pequeno">Archivo del resolutivo</label>
                            </div>
                            @if ($seccion->SSEGTRA_NIDESTATUS == 2)
                            <div class="col-md-8" id="archivo_resolutivo_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">
                                <span><i class="fas fa-eye"></i></span> <span><i class="fas fa-download"></i></span>
                            </div>
                            @else
                            <div class="col-md-8" id="archivo_resolutivo_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}">
                                Pendiente
                            </div>
                            @endif
                        </div>
                        @endif
                </div>
                @break

                @default
                <div id="tab_formulario_{{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}}" class="tab-pane fade pestana active show">
                    <div id="infoCompleteRevision" style="display: none !important;" class="row columna">
                        <div class=" col-md-12">
                            <div class="alert alert-warning" role="alert" style="font-size: 16px;">
                                ¡Se requiere aprobar la sección anterior!
                            </div>
                        </div>
                    </div>
                    @include('TRAMITES_CEMR_SEGUIMIENTO.DET_FORMULARIO')
                    <div id="areaNotificacionRevision" style="display: none !important;">
                        <div class="row columna" style="margin-bottom: 80px;">
                            <div class="col-md-12">
                                <h3 class="indicaciones">Notificación al solicitante</h3>
                                <label>Favor de indicar los puntos que el solicitante requiere atender para validar este paso de su solicitud</label>
                                <small style="font-size: 12px; margin-top:5px; margin-bottom: 2px;" class="form-text text-muted">La notificación esta limitada a 1000 carácteres con HTML.</small>
                                <textarea name="txtAreaRevision"></textarea>
                            </div>
                        </div>
                        <div class="row columna">
                            <div class="col-md-12">
                                <div class="col-md-12 mt-5 contenedorBtn">
                                    <div class="text-right botones">
                                        <button id="btnFormularioIncompleto" onclick="TRAM_FN_FORMULARIO_INCOMPLETO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-warning border btnLetras">Notificar información incompleta</button>
                                        <button id="btnFormularioRechazar" onclick="TRAM_FN_RECHAZAR({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-danger border btnLetras">Notificar rechazo de trámite</button>
                                        <button id="btnFormularioAprobar" onclick="TRAM_FN_APROBAR_FORMULARIO({{$seccion->SSEGTRA_NIDSECCION_SEGUIMIENTO}})" class="btn btn-success border btnLetras">Aprobar documentación</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @break
                @endswitch
                @endforeach
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

<div id="loading_" class="loadingFrame" class="text-center" style="display: none !important;">
    <div class="inner">
        <div class="spinner-grow text-secondary" role="status"></div>
        <p id="txt_loading" style="color: #393939 !important;">Cargando Trámite...</p>
    </div>
</div>
<!-- Modal de ver documentos -->
<div class="modal fade" id="modalDocumento" tabindex="-1" role="dialog" aria-labelledby="modalDocumentoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="modalContentDocumento" class="modal-content" style="width: 720px; height: 720px;">
        </div>
    </div>
</div>

<!-- Modal de ver resolutivos -->
<div class="modal fade" id="modalResolutivo" tabindex="-1" role="dialog" aria-labelledby="modalResolutivoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="modalContentResolutivo" class="modal-content" style="width: 720px; height: 720px;"></div>
    </div>
</div>

<!-- Rechazar trámite -->
<div class="modal fade" id="modalRechazar" tabindex="-1" role="dialog" aria-labelledby="modalRechazarTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 720px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">¿Deseas rechazar el trámite?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong style="font-weight: bold;">Si deseas rechazar el trámite ingresa los motivos de rechazo y presiona el botón de Rechazar trámite. Presiona el botón Cancelar si no deseas rechazar.</strong>
                <br>
                <br>
                <div class="form-group">
                    <label for="textRechazarTramite" class="col-form-label">Motivos de rechazo</label>
                    <small style="font-size: 12px; margin-top:5px; margin-bottom: 2px;" class="form-text text-muted">La notificación esta limitada a 1000 carácteres con HTML.</small>
                    <textarea class="form-control" name="textRechazarTramite" id="textRechazarTramite" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button onclick="TRAM_FN_RECHAZAR_SAVE();" type="button" class="btn btn-danger">Rechazar trámite</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')


<style>
    .loadingFrame {
        background: rgb(255 255 255 / 50%);
        display: table;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 999;
    }

    .loadingFrame .inner {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }

    .loadingFrame .inner md-progress-circular {
        margin: auto;
        height: 460px;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        margin-top: -50px;
    }

    .loadingFrame .inner p {
        color: #fff;
        font-size: 22px;
    }

    /* CSS Manuel Euan */
    .titulo {
        width: 100%;
        height: 40px;
        border-top-right-radius: 60px;
        border-bottom-right-radius: 60px;
        margin-top: 2%;
        display: flex;
        align-items: center;
        z-index: -1;
        color: #575654;
        font-size: 32px;
    }

    .subtitulo {
        color: #F8B30A;
        font-size: 22px;
    }

    .btnLetras {
        color: #fff;
        font-weight: 900;
        margin-left: 20px;
        min-width: 180px;
    }

    .botones {
        margin-right: 4%;
    }

    .border {
        border-radius: 5px;
    }

    .pestana {
        min-height: 700px;
    }

    .titulo_cita {
        color: #000000;
        font-weight: bold;
        font-size: 24px;
    }

    .titulo_pequeno {
        color: #000000;
        font-weight: bold;
        font-size: 18px;
    }

    .respuesta_pequena {
        color: #000000;
        font-size: 18px;
    }

    .respuesta_cita {
        color: #7E7D7B;
        font-size: 24px;
    }

    .columna {
        margin-top: 2%;
        margin-left: 2%;
    }

    .columna_2 {
        margin-top: 1%;
        margin-left: 2%;
    }

    .contenedorBtn {
        position: absolute;
        bottom: 0;
    }

    .indicaciones {
        color: #575654;
        font-size: 22px;
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

<script type="text/javascript" src="{{ URL::asset('js/citas.js') }}"></script>
<script>
    var objTramite;
    var list_secciones_estatus = [];
    var list_preguntas_revision = [];
    var list_secciones_configuracion = [];
    var list_secciones_formulario = [];
    var list_documentos = [];
    var list_resolutivos = [];
    var resolutivo_incorrecto = true;

    var mapa_cita = null;
    var coordenadas_cita = {
        "latitud": 28.638551,
        "longitud": -106.0738939
    };

    function getDiasTranscurridos(dateString) {
        var date = new Date(dateString.substring(0, 10)).getTime();
        var today = new Date().getTime();

        var diff = today - date;
        var diastranscurridos = diff / (1000 * 60 * 60 * 24);

        $("#diastranscurridos").text(diastranscurridos.toFixed() - 1); //-1 del dia despues que se requiere
    }

    $(document).ready(function() {

        var idusuario = "{{$tramite->USTR_NIDUSUARIO}}";
        var id = "{{$tramite->USTR_NIDUSUARIOTRAMITE}}";
        var fechaString = "{{$tramite->USTR_DFECHACREACION}}";

        if (fechaString.length) {
            getDiasTranscurridos(fechaString);
        }

        existeCitaFuncionario(idusuario, id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var estatus_general_tramite = parseInt("{{$tramite->USTR_NESTATUS}}");

        //Pagos
        $('.row-pago').each(function() {
            var id = this.id;
            var _arr = id.split("_");
            var _id_seccion = _arr[1];

            //Mostrar info de pago
            var estatus_pagos = null;
            $.ajax({
                data: {},
                url: "/consultar_pago/" + _id_seccion,
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    estatus_pagos = data[0].NO_ERROR;
                    $("#txtEstatus_" + _id_seccion).html(data[0].MENSAJE_ERROR);
                    $("#txtReferencia_" + _id_seccion).html(data[0].REFERENCIA);
                    $("#txtIdReferencia_" + _id_seccion).html(data[0].ID_REFERENCIA);
                    $("#txtMensaje_" + _id_seccion).html(data[0].MENSAJE + " <br/>" + data[0].MENSAJE_2);

                    //Se habilita el btn de pagar unicamente cuando el estatus sea igual 0, tomando en cuenta que 0 es Pagado correctamente
                    if(estatus_pagos == 0){
                        $("#linkPago_" + _arr[1]).show();
                    }else {
                        $("#linkPago_" + _arr[1]).hide();
                    }

                    //Guardar conceptos
                    if(estatus_pagos == 0 || estatus_pagos == 4){
                        $("#guardar_concepto_" + _arr[1]).hide();
                    }else {
                        $("#guardar_concepto_" + _arr[1]).show();
                    }
                },
                error: function (data) {
                }
            });
        });

        //Validacion de tipo de resolutivo
        if (9 < 8) {
            var control = document.getElementById("documento_resolutivo");
            control.addEventListener("change", function(event) {

                resolutivo_incorrecto = true;
                var files = control.files;

                if (files.length > 1) {
                    resolutivo_incorrecto = true;
                    Swal.fire({
                        icon: "warning",
                        title: 'Excedido cantidad de archivos',
                        text: "Solo se acepta un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB",
                        footer: ''
                    });
                    return;
                }

                for (var i = 0; i < files.length; i++) {

                    const sizeFile = Math.round((files[i].size / 1024));

                    if (sizeFile >= 4096) {

                        resolutivo_incorrecto = true;
                        Swal.fire({
                            icon: "warning",
                            title: 'Archivo pesado',
                            text: "Solo se acepta un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB",
                            footer: ''
                        });
                        return;
                    } else {

                        var typeFile = files[i].type;

                        if (typeFile === "image/jpeg" || typeFile === "image/png" || typeFile === "image/gif" || typeFile === "application/pdf") {
                            resolutivo_incorrecto = false;
                        } else {
                            resolutivo_incorrecto = true;
                            Swal.fire({
                                icon: "warning",
                                title: 'Formato de archivo no válido',
                                text: "Solo se acepta un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB",
                                footer: ''
                            });
                            return;
                        }
                    }
                }
            }, false);
        }

        $('#form_resolutivo').on('submit', function(event) {

            event.preventDefault();
            var form_data = new FormData(this);

            form_data.append('nombre_tramite', "{{$tramite->USTR_CNOMBRE_TRAMITE}}");
            form_data.append('folio_tramite', "{{$tramite->USTR_CFOLIO}}");
            var value_select = $("#estatus_resolutivo").val();

            //Seleccion de notificacion
            /*if (value_select === "notificacion") {
                var txtAreaResolutivo = CKEDITOR.instances['txtAreaResolutivo'].getData();
                if (isEmpty(txtAreaResolutivo)) {
                    Swal.fire({
                        icon: "warning",
                        title: 'Notificación no ingresada',
                        text: "Favor de indicar los puntos que el solicitante requiere atender para validar este paso de su solicitud",
                        footer: ''
                    });
                    return;
                }
                form_data.append('notificacion', txtAreaResolutivo);
            }*/

            if (resolutivo_incorrecto === true) {
                Swal.fire({
                    icon: "warning",
                    title: 'Revise el archivo',
                    text: "Solo se acepta un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB",
                    footer: ''
                });
                return;
            }

            Swal.fire({
                title: '¿Desea aprobar esta acción?',
                text: "Usted emitirá un resolutivo",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#218838',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No, cancelar',
                confirmButtonText: 'Sí aprobar'
            }).then((result) => {

                if (result.isConfirmed) {

                    $("#txt_loading").text("Guardando Trámite...");
                    $("#loading_").show();

                    if (!(navigator.onLine)) {
                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();
                        Swal.fire({
                            icon: "error",
                            title: 'Sin conexión a intenert',
                            text: "Verifique su conexión de internet e intente de nuevo",
                            footer: '',
                            timer: 4000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    $.ajax({
                        url: "/tramite_servicio_cemr/seccion_emitir_resolutivo",
                        method: "POST",
                        data: form_data,
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {

                            if (data.estatus === "warning") {
                                Swal.fire({
                                    icon: data.estatus,
                                    title: '',
                                    text: data.mensaje,
                                    footer: '',
                                    timer: 4000,
                                    showConfirmButton: false
                                });
                                $("#txt_loading").text("Cargando Trámite...");
                                $("#loading_").hide();
                                return;
                            }

                            if (data.codigo === 200) {

                                Swal.fire({
                                    icon: data.estatus,
                                    title: '',
                                    text: data.mensaje,
                                    footer: '',
                                    timer: 4000,
                                    showConfirmButton: false
                                });

                                var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                                setTimeout(function() {
                                    load_page_seguimiento(ruta);
                                }, 500);

                            } else {
                                Swal.fire({
                                    icon: data.estatus,
                                    title: '',
                                    text: data.mensaje,
                                    footer: '',
                                    timer: 4000,
                                    showConfirmButton: false
                                });

                                var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                                setTimeout(function() {
                                    load_page_seguimiento(ruta);
                                }, 500);
                            }
                        },
                        error: function(data) {

                            $("#txt_loading").text("Cargando Trámite...");
                            $("#loading_").hide();

                            Swal.fire({
                                icon: "error",
                                title: '',
                                text: "Ocurrió un error al guardar el trámite",
                                footer: '',
                                timer: 3000
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                            load_page_seguimiento(ruta);
                        }
                    })
                }
            });

        });

        function TRAM_AJX_RENDER_FORMULARIO() {

            var id = "{{request()->route('id') }}";

            $.ajax({
                url: "/tramite_servicio_cemr/obtener_tramite/" + id + "",
                type: "GET",
                success: function(data) {

                    var tramite = data.tramite[0];
                    objTramite = data.tramite[0];
                    list_secciones_estatus = data.configuracion.secciones_estatus;

                    if (data.resolutivos.length > 0) {
                        list_resolutivos = data.configuracion.resolutivos_finales;
                    } else {
                        list_resolutivos = [];
                    }

                    //Buton de habilitar trámite
                    if (tramite.USTR_NESTATUS <= 2) {
                        $("#btnRevision").text("Iniciar revisión");
                        $("#btnRevision").prop("disabled", false);
                    } else if (tramite.USTR_NESTATUS > 2) {
                        $("#btnRevision").text("Ir a revisón");
                        $("#btnRevision").prop("disabled", false);
                    }

                    var secciones_formularios = data.configuracion.formularios[0].secciones;

                    //Guardamos secciones y formulario con sus secciones
                    list_secciones_configuracion = [];
                    list_secciones_formulario = [];
                    list_secciones_configuracion = data.configuracion.secciones;
                    list_secciones_formulario = data.configuracion.formularios[0].secciones;

                    //Agregar secciones del formulario al acordion
                    $('#accordion').html('');
                    var divSectionContainer = $('#accordion');
                    var list_text_area = [];

                    $.each(secciones_formularios, function(index, value) {

                        if (!(value.preguntas.length > 0)) {
                            return;
                        }

                        var show = index === 0 ? "show" : "";

                        var itemCollapse = '<div class="card">' +
                            '<div class="card-header" id="heading_' + value.FORM_NID + '">' +
                            '<h5 class="mb-0">' +
                            '<button class="btn btn-link" data-toggle="collapse" data-target="#collapse_' + value.FORM_NID + '" aria-controls="collapse_' + value.FORM_NID + '">' +
                            '' + value.FORM_CNOMBRE + '' +
                            '</button>' +
                            '</h5>' +
                            '</div>';

                        var collapse_detalle = '<div id="collapse_' + value.FORM_NID + '" class="collapse ' + show + '" aria-labelledby="heading_' + value.FORM_NID + '" data-parent="#accordion">' +
                            '<div class="card-body">';


                        $.each(value.preguntas, function(index_preguntas, value_pregunta) {

                            //Se agrega pregunta a lista de revision
                            var obj_pregunta_revision = {
                                'pregunta_id': parseInt(value_pregunta.FORM_NID),
                                'estatus': value_pregunta.estatus === null ? 0 : parseInt(value_pregunta.estatus),
                                'observaciones': value_pregunta.observaciones !== null ? value_pregunta.observaciones : ""
                            };

                            list_preguntas_revision.push(obj_pregunta_revision);

                            //Se marca el valor que corresponda
                            var checkAceptado = "";
                            var checkRechazado = "";
                            var displayTextArea = "none";
                            if (obj_pregunta_revision.estatus === 2) {
                                var checkAceptado = "checked";
                                var checkRechazado = "";
                            } else if (obj_pregunta_revision.estatus === 1) {
                                var checkAceptado = "";
                                var checkRechazado = "checked";
                                displayTextArea = "block";
                            }

                            //Abre row con columnas
                            collapse_detalle += '<div class="row">';
                            collapse_detalle += '<div class="col-md-5">';

                            switch (value_pregunta.FORM_CTIPORESPUESTA) {

                                case "abierta":

                                    collapse_detalle += '<p>' +
                                        '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>' +
                                        '<label class="respuesta_pequena">' + value_pregunta.respuestas[0].FORM_CVALOR_RESPUESTA + '</label>' +
                                        '</p>';
                                    break;

                                case "unica":

                                    collapse_detalle += '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>';
                                    $.each(value_pregunta.respuestas, function(index_respuesta, value_respuesta) {
                                        collapse_detalle += '<div class="form-check">' +
                                            '<input ' + value_respuesta.FORM_CVALOR_RESPUESTA + ' style="pointer-events:none; width: 20px; height: 20px;" class="form-check-input" type="radio" name="radion_respuesta_' + value_respuesta.FORM_NPREGUNTAID + '" id="radion_respuesta_' + value_respuesta.FORM_NID + '">' +
                                            '<label style="pointer-events:none; padding-top: 4px; padding-left: 8px; font-size: 14px;" class="form-check-label" for="radion_respuesta_' + value_respuesta.FORM_NID + '">' +
                                            value_respuesta.FORM_CVALOR +
                                            '</label>' +
                                            '</div>';
                                    });
                                    break;

                                case "especial":

                                    collapse_detalle += '<br>';
                                    collapse_detalle += '<div class="form-group">' +
                                        '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>' +
                                        '<table class="table table-striped table-bordered">' +
                                        '<tr>';

                                    $.each(value_pregunta.respuestas, function(index_respuesta, value_respuesta) {

                                        collapse_detalle += '<th>';
                                        collapse_detalle += '' + value_respuesta.FORM_CVALOR + '';
                                        collapse_detalle += '</th>';
                                    });
                                    collapse_detalle += '</tr>';

                                    collapse_detalle += '<tr>';
                                    $.each(value_pregunta.respuestas, function(index_respuesta, value_respuesta) {

                                        switch (value_respuesta.FORM_CTIPORESPUESTAESPECIAL) {
                                            case "numerico":
                                                collapse_detalle += '<th>';
                                                collapse_detalle += '' + value_respuesta.respuestas_especial[0].FORM_CVALOR_RESPUESTA + '';
                                                collapse_detalle += '</th>';
                                                break;

                                            case "opciones":
                                                var selected = value_respuesta.respuestas_especial.find(x => x.FORM_CVALOR_RESPUESTA === "selected");
                                                collapse_detalle += '<th>';
                                                collapse_detalle += '' + selected.FORM_CVALOR + '';
                                                collapse_detalle += '</th>';
                                                break;
                                            default:

                                                if (value_respuesta.respuestas_especial.length > 0) {
                                                    collapse_detalle += '<th>';
                                                    collapse_detalle += '' + value_respuesta.respuestas_especial[0].FORM_CVALOR_RESPUESTA + '';
                                                    collapse_detalle += '</th>';
                                                } else {
                                                    collapse_detalle += '<th>';
                                                    collapse_detalle += '';
                                                    collapse_detalle += '</th>';
                                                }
                                                break;
                                        }

                                    });
                                    collapse_detalle += '</tr>';
                                    collapse_detalle += '</table>' +
                                        '</div>';
                                    break;

                                case 'enriquecido':

                                    collapse_detalle += '<br>' +
                                        '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>' +
                                        '<div class="form-group">' +
                                        '<textarea disabled class="txtEnriquecido" name="resp_' + value_pregunta.FORM_NID + '_0"  id="resp_' + value_pregunta.FORM_NID + '_0" rows="5" style="display: block !important;"></textarea>' +
                                        '</div>';

                                    list_text_area.push({
                                        id: 'resp_' + value_pregunta.FORM_NID + '_0',
                                        valor: value_pregunta.respuestas[0].FORM_CVALOR_RESPUESTA
                                    });
                                    break;

                                case 'multiple':

                                    collapse_detalle += '<br>' +
                                        '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>' +
                                        '<div class="form-group">';

                                    $.each(value_pregunta.respuestas, function(index_respuesta, value_respuesta) {

                                        collapse_detalle += '<div class="form-check">' +
                                            '<input ' + value_respuesta.FORM_CVALOR_RESPUESTA + ' style="pointer-events:none; width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="" id="check_' + value_respuesta.FORM_NID + '">' +
                                            '<label style="pointer-events:none; padding-top: 4px; padding-left: 8px; font-size: 14px;" class="form-check-label" for="check_' + value_respuesta.FORM_NID + '">' +
                                            '' + value_respuesta.FORM_CVALOR + '' +
                                            '</label>' +
                                            '</div>';
                                    });
                                    collapse_detalle += '</div>';
                                    break;

                                default:

                            }

                            //Cierre col-md-5
                            collapse_detalle += '</div>';

                            //Se agrega col-md-3
                            collapse_detalle += '<div class="col-md-3 validatePregunta">';
                            collapse_detalle += '<div class="form-check form-check-inline">' +
                                '<input onchange="TRAM_FN_ACEPTAR_PREGUNTA(' + value_pregunta.FORM_NID + ');"  class="form-check-input" type="radio" name="radio_pregunta_' + value_pregunta.FORM_NID + '" id="radio_aceptar_' + value_pregunta.FORM_NID + '" value="2" ' + checkAceptado + '>' +
                                '<label class="form-check-label respuesta_pequena " for="radio_aceptar_' + value_pregunta.FORM_NID + '">Aceptar</label>' +
                                '</div>' +
                                '<div class="form-check form-check-inline">' +
                                '<input onchange="TRAM_FN_RECHAZAR_PREGUNTA(' + value_pregunta.FORM_NID + ');" class="form-check-input" type="radio" name="radio_pregunta_' + value_pregunta.FORM_NID + '" id="radio_rechazar_' + value_pregunta.FORM_NID + '" value="1" ' + checkRechazado + '>' +
                                '<label class="form-check-label respuesta_pequena" for="radio_rechazar_' + value_pregunta.FORM_NID + '">Rechazar</label>' +
                                '</div>';
                            collapse_detalle += '</div>';

                            //Se agrega col-md-4
                            collapse_detalle += '<div class="col-md-4 validatePregunta">';
                            collapse_detalle += '<div class="form-group">';
                            collapse_detalle += '<textarea style="display:' + displayTextArea + ';" onchange="TRAM_FN_JUSTIFICACION(' + value_pregunta.FORM_NID + ')" class="form-control txtJustificacion" id="txt_justificacion_pregunta_' + value_pregunta.FORM_NID + '" rows="3" placeholder="Justificacion">' + obj_pregunta_revision.observaciones + '</textarea>';
                            collapse_detalle += '</div>';
                            collapse_detalle += '</div>';

                            //Se cierra row
                            collapse_detalle += '</div>';
                        });

                        collapse_detalle += '</div>' +
                            '</div>';

                        itemCollapse += collapse_detalle;

                        //Cierre de card
                        itemCollapse += '</div>';
                        divSectionContainer.append(itemCollapse);

                    });

                    //Cambiar texto enrequicido
                    setTimeout(() => {
                        if (list_text_area.length > 0) {

                            $.each(list_text_area, function(index_area, value_area) {

                                CKEDITOR.replace(value_area.id);

                                if (value_area.valor != null && value_area.valor != "") {
                                    CKEDITOR.instances[value_area.id].setData(value_area.valor);
                                }
                            });
                        }
                    }, 500);

                    //Agregar documentos al acordion
                    $('#collapse_documento').html('');
                    var divSectionContainer_documento = $('#collapse_documento');

                    var lista_documentos = data.configuracion.documentos;

                    var filter = data.configuracion.documentos.filter(x => x.existe === 1);

                    var itemDocumento = "";
                    itemDocumento += '<div class="card-body">';

                    $.each(lista_documentos, function(index, value) {

                        var documento_add = {
                            documento_id: parseInt(value.TRAD_NIDTRAMITEDOCUMENTO),
                            estatus: parseInt(value.TRAD_NESTATUS),
                            observaciones: value.TRAD_COBSERVACION === null ? "" : value.TRAD_COBSERVACION,
                            ruta: value.TRAD_CRUTADOC === null ? "" : value.TRAD_CRUTADOC,
                            nombre: value.TRAD_CNOMBRE,
                            extension: value.TRAD_CEXTENSION,
                            vigencia: ""
                        };

                        list_documentos.push(documento_add);

                        var icon = "";
                        switch (value.TRAD_CEXTENSION) {
                            case "jpg":
                                icon = "{{ asset('assets/template/img/jpg.png') }}";
                                break;
                            case "png":
                                icon = "{{ asset('assets/template/img/png.png') }}";
                                break;
                            case "pdf":
                                icon = "{{ asset('assets/template/img/pdf.png') }}";
                                break;
                            default:
                                icon = "{{ asset('assets/template/img/doc.png') }}";
                        }

                        //Marcar documentos y indicar observaciones
                        var checkAceptado = "";
                        var checkRechazado = "";
                        var displayTextArea = "none";
                        if (documento_add.estatus === 2) {
                            var checkAceptado = "checked";
                            var checkRechazado = "";
                        } else if (documento_add.estatus === 1) {
                            var checkAceptado = "";
                            var checkRechazado = "checked";
                            displayTextArea = "block";
                        }

                        var rutaDocumento = value.TRAD_CRUTADOC !== null && value.TRAD_CRUTADOC !== "" ? value.TRAD_CRUTADOC : "";

                        itemDocumento += '<div class="row">' +
                            '<div class="col-md-6">' +
                            '<div class="row">' +
                            '<div class="col-2">' +
                            '<img src="' + icon + '" width="25" height="25">' +
                            '</div>' +
                            '<div class="col-4">' +
                            '<p><label class="titulo_pequeno">' + value.TRAD_CNOMBRE + '</label></p>' +
                            '</div>';

                        itemDocumento += '<div class="col-4">';
                        if (value.existe > 0 && rutaDocumento != "") {
                            itemDocumento += '<span style="padding-right: 15px;font-size: 20px;"><i title="Ver documento" style="cursor:pointer;" onclick="TRAM_FN_VER_DOCUMENTO(' + value.TRAD_NIDTRAMITEDOCUMENTO + ')" class="fas fa-eye"></i></span>' +
                                "<a href='{{ asset('') }}" + rutaDocumento + "' style='padding-right: 15px;font-size: 20px;' download='" + documento_add.nombre + "'><i title='Descargar documento' class='fas fa-download'></i></a> ";
                            itemDocumento += '<label class="divV"><input class="vigencia" id="vig'+value.TRAD_NIDTRAMITEDOCUMENTO+'" onchange="vigencia('+ value.TRAD_NIDTRAMITEDOCUMENTO +', this);" type="checkbox" name="vigencia">¿Vigencia?</label>';
                            
                        }
                        itemDocumento += '</div>'; //col-2
                        itemDocumento += '</div>' + //row
                            '</div>'; //col-md-5
                        itemDocumento += '<div class="col-2" id="divVigencia'+ value.TRAD_NIDTRAMITEDOCUMENTO +'"></div>';
                        itemDocumento += '<div class="col-md-3 validatePregunta" style="display: block;">' +
                            '<div class="form-check form-check-inline">' +
                            '<input ' + checkAceptado + ' onchange="TRAM_FN_ACEPTAR_DOCUMENTO(' + value.TRAD_NIDTRAMITEDOCUMENTO + ');" class="form-check-input" type="radio" name="radio_documento_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" id="radio_aceptar_d_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" value="2">' +
                            '<label class="form-check-label respuesta_pequena " for="radio_aceptar_d_' + value.TRAD_NIDTRAMITEDOCUMENTO + '">Aceptar</label>' +
                            '</div>' +
                            '<div class="form-check form-check-inline">' +
                            '<input ' + checkRechazado + ' onchange="TRAM_FN_RECHAZAR_DOCUMENTO(' + value.TRAD_NIDTRAMITEDOCUMENTO + ');" class="form-check-input" type="radio" name="radio_documento_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" id="radio_rechazar_d_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" value="1">' +
                            '<label class="form-check-label respuesta_pequena" for="radio_rechazar_d_' + value.TRAD_NIDTRAMITEDOCUMENTO + '">Rechazar</label>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-4 validatePregunta" style="display: block;">' +
                            '<div class="form-group"><textarea style="display: ' + displayTextArea + ';" onchange="TRAM_FN_JUSTIFICACION_DOCUMENTO(' + value.TRAD_NIDTRAMITEDOCUMENTO + ')" class="form-control txtJustificacion" id="txt_justificacion_documento_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" rows="3" placeholder="Justificacion">' + documento_add.observaciones + '</textarea></div>' +
                            '</div>';

                        itemDocumento += ' </div>'; //row
                        
                    });

                    itemDocumento += '</div>'; //card-body

                    divSectionContainer_documento.append(itemDocumento);
                    ///////////////////////////////////7
                    /*$('.vigencia').change(function() {
                        console.log("Clickando")  
                    });*/
                    $(".validatePregunta").hide();
                    $(".divV").hide();
                    $("#txtRevisionInfo").hide();
                    setTimeout(function() {
                        $('#loading_').hide();
                    }, 2000);
                },
                error: function(data) {

                    $('#loading_').hide();
                    // Swal.fire({
                    //     icon: data.status,
                    //     title: '',
                    //     text: data.message,
                    //     footer: ''
                    // });
                }
            });
        }

        TRAM_AJX_RENDER_FORMULARIO();
        $('#loading_').show();
        CKEDITOR.replace('txtAreaRevision', {
            extraPlugins: 'wordcount',
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countHTML: true,
                maxWordCount: -1,
                maxCharCount: 1000,
            }
        });
        // CKEDITOR.replace('txtAreaCita');
        // CKEDITOR.replace('txtAreaResolutivo');
        CKEDITOR.replace('textRechazarTramite', {
            extraPlugins: 'wordcount',
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countHTML: true,
                maxWordCount: -1,
                maxCharCount: 1000,
            }
        });

        //Select de estatus del trámite en seccion resolutivo
        /*$('#estatus_resolutivo').on('change', function() {
            if (this.value === "notificacion") {
                $("#areaResolutivo").show();
            } else {
                $("#areaResolutivo").hide();
            }
        });*/

        //Cargar mapa y ubicacion de oficina
        setTimeout(function() {
            var lat = parseFloat("{{$tramite->EDF_VENTANILLA_SIN_CITA_LAT}}");
            var lon = parseFloat("{{$tramite->EDF_VENTANILLA_SIN_CITA_LON}}");
            var latitud = lat != 0 ? lat : 28.640157192843148;
            var longitud = lon != 0 ? lon : -106.07436882706008;
            map = new google.maps.Map(document.getElementById('mapaEdificioVentanilla'), {
                center: {
                    lat : latitud,
                    lng: longitud
                    //lat: -34.5862088,
                    //lng: -58.415677500000015
                },
                zoom: 15,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_CENTER,
                },
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.BOTTOM_RIGHT,
                },
            });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(latitud, longitud),
                map: map,
                title: 'Ubicación'
            });
        }, 1000);
    });

    function vigencia(id, event){

        if(event.checked){
            $("#divVigencia"+id).html('<input type="date" id="vigencia'+id+'" name="fechaV" value="2022-08-08" >');
            var documento = list_documentos.find(x => x.documento_id === parseInt(id));
            var vigencia = $("#vigencia"+id).val();
            documento.vigencia = vigencia;
        }else{
            $("#divVigencia"+id).html("");
        }
       
    }

    function TRAM_FN_VER_DOCUMENTO(id) {

        var doc = list_documentos.find(x => x.documento_id === parseInt(id));
        var host = window.location.origin;
        var rutaa = host + "/" + doc.ruta;

        $("#modalContentDocumento").html("");
        var content = $("#modalContentDocumento");

        if (doc.extension === "png" || doc.extension === "jpg") {

            var documentView = '<div class="modal-header">' +
                '<h5 class="modal-title" id="exampleModalLongTitle">' + doc.nombre + '</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                // '<iframe class="modal-body" id="pdfDoc" title="Inline Frame Example" src="http://127.0.0.1:8000/files/documentos/254162746.pdf">' +
                // '</iframe>' +
                '<img id="imgDoc" class="modal-body" src="' + rutaa + '" alt="" style="object-fit: contain; width: 720px; height: 650px;">';
            // '<div class="modal-footer">' +
            // '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>' +
            // '</div>';

            content.append(documentView);

        } else if (doc.extension === "pdf") {

            var documentView = '<div class="modal-header">' +
                '<h5 class="modal-title" id="exampleModalLongTitle">' + doc.nombre + '</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<iframe class="modal-body" id="pdfDoc" title="' + doc.nombre + '" src="' + rutaa + '">' +
                '</iframe>';
            // '<img id="imgDoc" class="modal-body" src="http://k36.kn3.net/5D072EE3A.jpg" alt="" style="object-fit: cover;">' +
            // '<div class="modal-footer">' +
            // '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>' +
            // '</div>';

            content.append(documentView);
        }

        $("#modalDocumento").modal('show');
    }

    function TRAM_FN_DESCARGAR_DOCUMENTO(id) {

        var doc = list_documentos.find(x => x.documento_id === parseInt(id));
        var host = window.location.origin;
        var rutaa = host + "/" + doc.ruta;
        window.location.href = rutaa;

        // $("#btnDo").attr("href", rutaa);
        // $('#btnDo').trigger('click');
    }

    function TRAM_FN_VER_RESOLUTIVO(id) {

        var doc = list_resolutivos.find(x => parseInt(x.USRE_NIDUSUARIO_RESOLUTIVO) === parseInt(id));
        var host = window.location.origin;
        var rutaa = host + "/" + doc.USRE_CRUTADOC;
        var folio = "{{$tramite->USTR_CFOLIO}}";
        var arrayFolio = folio.split('/');
        var nombre_resolutivo = "Resolutivo_" + arrayFolio[0] + "_" + arrayFolio[1] + "";

        $("#modalContentResolutivo").html("");
        var content = $("#modalContentResolutivo");

        if (doc.USRE_CEXTENSION === "png" || doc.USRE_CEXTENSION === "jpg" || doc.USRE_CEXTENSION === "gif") {

            var documentView = '<div class="modal-header">' +
                '<h5 class="modal-title">' + nombre_resolutivo + '</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<img id="imgResolutivo" class="modal-body" src="' + rutaa + '" alt="" style="object-fit: contain; width: 720px; height: 650px;">';
            content.append(documentView);

        } else if (doc.USRE_CEXTENSION === "pdf") {

            var documentView = '<div class="modal-header">' +
                '<h5 class="modal-title">' + nombre_resolutivo + '</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<iframe class="modal-body" id="pdfResolutivo" title="' + nombre_resolutivo + '" src="' + rutaa + '">' +
                '</iframe>';
            content.append(documentView);
        }
        $("#modalResolutivo").modal('show');
    }

    function load_page_seguimiento(ruta) {
        window.location.replace(ruta)
    }

    function TRAM_FN_ACEPTAR_PREGUNTA(PreguntaID) {

        var pregunta = list_preguntas_revision.find(x => x.pregunta_id === PreguntaID);
        pregunta.estatus = 2;
        pregunta.observaciones = "";

        $("#txt_justificacion_pregunta_" + PreguntaID + "").val("");
        $("#txt_justificacion_pregunta_" + PreguntaID + "").hide();
    }

    function TRAM_FN_RECHAZAR_PREGUNTA(PreguntaID) {

        var pregunta = list_preguntas_revision.find(x => x.pregunta_id === PreguntaID);
        pregunta.estatus = 1;
        pregunta.observaciones = "";

        $("#txt_justificacion_pregunta_" + PreguntaID + "").val("");
        $("#txt_justificacion_pregunta_" + PreguntaID + "").show();
    }

    function TRAM_FN_JUSTIFICACION(PreguntaID) {
        var texto = $("#txt_justificacion_pregunta_" + PreguntaID + "").val();
        var pregunta = list_preguntas_revision.find(x => x.pregunta_id === PreguntaID);
        pregunta.observaciones = texto;
    }


    function TRAM_FN_ACEPTAR_DOCUMENTO(DocumentoID) {

        var documento = list_documentos.find(x => x.documento_id === parseInt(DocumentoID));
        documento.estatus = 2;
        documento.observaciones = "";

        $("#txt_justificacion_documento_" + DocumentoID + "").val("");
        $("#txt_justificacion_documento_" + DocumentoID + "").hide();
    }

    function TRAM_FN_RECHAZAR_DOCUMENTO(DocumentoID) {

        var documento = list_documentos.find(x => x.documento_id === parseInt(DocumentoID));
        documento.estatus = 1;
        documento.observaciones = "";

        $("#txt_justificacion_documento_" + DocumentoID + "").val("");
        $("#txt_justificacion_documento_" + DocumentoID + "").show();
    }

    function TRAM_FN_JUSTIFICACION_DOCUMENTO(DocumentoID) {
        var texto = $("#txt_justificacion_documento_" + DocumentoID + "").val();
        var documento = list_documentos.find(x => x.documento_id === parseInt(DocumentoID));
        documento.observaciones = texto;
    }

    //Funcion para verificar si una cadena está en blanco, nula o indefinida
    function isEmpty(str) {
        return (!str || 0 === str.length);
    }

    //------------ Formulario y primera Revisión de documentación ------------
    function TRAM_FN_RENDER_FORMULARIO(SeccionID) {

        $(".validatePregunta").hide();
        $("#txtRevisionInfo").hide();
        $("#areaNotificacionRevision").hide();
        $("#infoCompleteRevision").hide();

        //Cambiar onclick de botones
        $("#btnFormularioIncompleto").attr("onclick", "TRAM_FN_FORMULARIO_INCOMPLETO(" + parseInt(SeccionID) + ")");
        $("#btnFormularioRechazar").attr("onclick", "TRAM_FN_RECHAZAR(" + parseInt(SeccionID) + ")");
        $("#btnFormularioAprobar").attr("onclick", "TRAM_FN_APROBAR_FORMULARIO(" + parseInt(SeccionID) + ")");
    }

    function TRAM_FN_RENDER_REVISION(SeccionID) {

        var formulario = list_secciones_estatus.find(x => x.SSEGTRA_CNOMBRE_SECCION === "Formulario");
        $("#infoCompleteRevision").hide();
        var tramiteEstatus = "{{$tramite->USTR_NESTATUS}}";

        if (parseInt(formulario.SSEGTRA_NIDESTATUS) === 3 || parseInt(formulario.SSEGTRA_NIDESTATUS) === 1 || parseInt(formulario.SSEGTRA_NIDESTATUS) === 0) {
            if (parseInt(tramiteEstatus) < 8) {
                $(".validatePregunta").show();
                $("#txtRevisionInfo").show();
                $("#areaNotificacionRevision").show();
                $(".divV").show();
            } else {
                $(".validatePregunta").hide();
                $("#txtRevisionInfo").hide();
                $("#areaNotificacionRevision").hide();
            }
        } else {
            $(".validatePregunta").hide();
            $("#txtRevisionInfo").hide();
            $("#areaNotificacionRevision").hide();
        }

        //Cambiar onclick de botones
        $("#btnFormularioIncompleto").attr("onclick", "TRAM_FN_FORMULARIO_INCOMPLETO(" + parseInt(SeccionID) + ")");
        $("#btnFormularioRechazar").attr("onclick", "TRAM_FN_RECHAZAR(" + parseInt(SeccionID) + ")");
        $("#btnFormularioAprobar").attr("onclick", "TRAM_FN_APROBAR_FORMULARIO(" + parseInt(SeccionID) + ")");
    }

    function TRAM_FN_APROBAR_FORMULARIO(SeccionID) {

        var seccion_formulario = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 2,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": []
        };

        //Verificacion de preguntas aprobadas
        var existen_sin_atender = false;
        $.each(list_preguntas_revision, function(index, value) {

            if (value.estatus < 2) {
                existen_sin_atender = true;
                return;
            } else {
                seccion_formulario.CONF_PREGUNTAS.push(value);
            }
        });

        if (existen_sin_atender) {
            Swal.fire({
                icon: "warning",
                title: 'Verifique las preguntas',
                text: "Es necesario aceptar todas las preguntas",
                footer: ''
            });
            return;
        }

        //Validacion de documentos
        var documentos_sin_atender = false;
        $.each(list_documentos, function(index, value) {

            if (value.estatus < 2) {
                documentos_sin_atender = true;
                return;
            }
        });

        if (documentos_sin_atender) {
            Swal.fire({
                icon: "warning",
                title: 'Verifique los documentos',
                text: "Es necesario aceptar los documentos",
                footer: ''
            });

            return;
        }

        Swal.fire({
            title: '¿Desea aprobar esta acción?',
            text: "Usted aprobará el formulario y los documentos",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar',
            confirmButtonText: 'Sí aprobar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_formulario,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_formulario_aprobado',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });
    }

    function TRAM_FN_FORMULARIO_INCOMPLETO(SeccionID) {

        var seccion_formulario = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 3,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": [],
            "CONF_DOCUMENTOS": [],
            "nombre_tramite": "{{$tramite->USTR_CNOMBRE_TRAMITE}}",
            "folio_tramite": "{{$tramite->USTR_CFOLIO}}"
        };

        var txtAreaRevision = CKEDITOR.instances['txtAreaRevision'].getData();

        //Verificamos que ingreso notificacion
        if (isEmpty(txtAreaRevision)) {
            Swal.fire({
                icon: "warning",
                title: 'Notificación no ingresada',
                text: "Favor de indicar los puntos que el solicitante requiere atender para validar este paso de su solicitud",
                footer: ''
            });
            return;
        }
        seccion_formulario.CONF_NOTIFICACION = txtAreaRevision;

        var existen_sin_atender = false;
        $.each(list_preguntas_revision, function(index, value) {

            if (value.estatus < 1) {

                existen_sin_atender = true;
                return;
            } else {
                seccion_formulario.CONF_PREGUNTAS.push(value);
            }
        });

        if (existen_sin_atender) {
            Swal.fire({
                icon: "warning",
                title: 'Verifique las preguntas',
                text: "Es necesario aceptar o rechazar las respuestas",
                footer: ''
            });

            return;
        }

        //Validacion de documentos
        var documentos_sin_atender = false;
        $.each(list_documentos, function(index, value) {

            if (value.estatus < 1) {
                documentos_sin_atender = true;
                return;
            } else {
                seccion_formulario.CONF_DOCUMENTOS.push(value);
            }
        });

        if (documentos_sin_atender) {
            Swal.fire({
                icon: "warning",
                title: 'Verifique los documentos',
                text: "Es necesario aceptar o rechazar los documentos",
                footer: ''
            });

            return;
        }

        Swal.fire({
            title: 'Notificar Información Incompleta',
            text: "¿Desea notificar al ciudadano como Información Incompleta?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_formulario,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_formulario_incompleta',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            setTimeout(function() {
                                load_page_seguimiento(data.ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });
    }

    //------- Revision de documentacion - Secciones Diferentes --------
    function TRAM_FN_RENDER_REVISION_DOCUMENTACION(SeccionID, SeccionIDAnterior) {

        var secciones_tem = @json($secciones);
        var revision = secciones_tem.find(x => x.SSEGTRA_NIDSECCION_SEGUIMIENTO === parseInt(SeccionID));
        var seccion_anterior = secciones_tem.find(x => x.SSEGTRA_NIDSECCION_SEGUIMIENTO === parseInt(SeccionIDAnterior));
        var tramiteEstatus = "{{$tramite->USTR_NESTATUS}}";

        //Mostrar-Ocultar leyenda de sección anterior incompleta
        if (!(seccion_anterior.SSEGTRA_NIDESTATUS === 2)) {
            $("#infoCompleteRevision").show();
            $("#areaNotificacionRevision").hide();
            $(".validatePregunta").hide();
            $("#txtRevisionInfo").hide();
        } else {

            $("#infoCompleteRevision").hide();

            if (parseInt(revision.SSEGTRA_NIDESTATUS) != 2 && parseInt(tramiteEstatus) < 8) {
                $("#areaNotificacionRevision").show();
                $(".validatePregunta").show();
                $("#txtRevisionInfo").show();
                $(".divV").show();
            } else {
                $("#areaNotificacionRevision").hide();
                $(".validatePregunta").hide();
                $("#txtRevisionInfo").hide();
            }
        }

        //Cambiar onclick de botones
        $("#btnFormularioIncompleto").attr("onclick", "TRAM_FN_REVISION_DOCUMENTACION_INCOMPLETO(" + parseInt(SeccionID) + ")");
        $("#btnFormularioRechazar").attr("onclick", "TRAM_FN_RECHAZAR(" + parseInt(SeccionID) + ")");
        $("#btnFormularioAprobar").attr("onclick", "TRAM_FN_APROBAR_REVISION_DOCUMENTACION(" + parseInt(SeccionID) + ")");
    }

    function TRAM_FN_APROBAR_REVISION_DOCUMENTACION(SeccionID) {

        var seccion_formulario = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 2,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": []
        };

        //Verificacion de preguntas aprobadas
        var existen_sin_atender = false;
        $.each(list_preguntas_revision, function(index, value) {

            if (value.estatus < 2) {
                existen_sin_atender = true;
                return;
            } else {
                seccion_formulario.CONF_PREGUNTAS.push(value);
            }
        });

        if (existen_sin_atender) {
            Swal.fire({
                icon: "warning",
                title: 'Verifique las preguntas',
                text: "Es necesario aceptar todas las preguntas",
                footer: ''
            });
            return;
        }

        //Validacion de documentos
        var documentos_sin_atender = false;
        $.each(list_documentos, function(index, value) {

            if (value.estatus < 2) {
                documentos_sin_atender = true;
                return;
            }
        });

        if (documentos_sin_atender) {
            Swal.fire({
                icon: "warning",
                title: 'Verifique los documentos',
                text: "Es necesario aceptar los documentos",
                footer: ''
            });

            return;
        }

        Swal.fire({
            title: '¿Desea aprobar esta acción?',
            text: "Usted aprobará el formulario y los documentos",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar',
            confirmButtonText: 'Sí aprobar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_formulario,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_revision_aprobado',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });
    }

    function TRAM_FN_REVISION_DOCUMENTACION_INCOMPLETO(SeccionID) {

        var seccion_formulario = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 3,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": [],
            "CONF_DOCUMENTOS": [],
            "nombre_tramite": "{{$tramite->USTR_CNOMBRE_TRAMITE}}",
            "folio_tramite": "{{$tramite->USTR_CFOLIO}}"
        };

        var txtAreaRevision = CKEDITOR.instances['txtAreaRevision'].getData();

        //Verificamos que ingreso notificacion
        if (isEmpty(txtAreaRevision)) {
            Swal.fire({
                icon: "warning",
                title: 'Notificación no ingresada',
                text: "Favor de indicar los puntos que el solicitante requiere atender para validar este paso de su solicitud",
                footer: ''
            });
            return;
        }
        seccion_formulario.CONF_NOTIFICACION = txtAreaRevision;

        var existen_sin_atender = false;
        $.each(list_preguntas_revision, function(index, value) {

            if (value.estatus < 1) {

                existen_sin_atender = true;
                return;
            } else {
                seccion_formulario.CONF_PREGUNTAS.push(value);
            }
        });

        if (existen_sin_atender) {
            Swal.fire({
                icon: "warning",
                title: 'Verifique las preguntas',
                text: "Es necesario aceptar o rechazar las respuestas",
                footer: ''
            });

            return;
        }

        //Validacion de documentos
        var documentos_sin_atender = false;
        $.each(list_documentos, function(index, value) {

            if (value.estatus < 1) {
                documentos_sin_atender = true;
                return;
            } else {
                seccion_formulario.CONF_DOCUMENTOS.push(value);
            }
        });

        if (documentos_sin_atender) {
            Swal.fire({
                icon: "warning",
                title: 'Verifique los documentos',
                text: "Es necesario aceptar o rechazar los documentos",
                footer: ''
            });

            return;
        }

        Swal.fire({
            title: 'Notificar Información Incompleta',
            text: "¿Desea notificar al ciudadano como Información Incompleta?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_formulario,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_revision_incompleta',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            setTimeout(function() {
                                load_page_seguimiento(data.ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });
    }

    //----------------- Citas ---------------
    function TRAM_FN_RENDER_CITA(SeccionID) {

        var listaSecciones = @json($secciones);
        var seccion = listaSecciones.find(x => parseInt(x.SSEGTRA_NIDSECCION_SEGUIMIENTO) == parseInt(SeccionID));

        if (seccion.SSEGTRA_NIDESTATUS === 2) {
            return;
        }

        setTimeout(function() {

            var existeEditor = CKEDITOR.instances['txtAreaCita_' + SeccionID + ''];

            if (existeEditor) {
                existeEditor.destroy(true);
            }

            CKEDITOR.replace('txtAreaCita_' + SeccionID + '', {
                extraPlugins: 'wordcount',
                wordcount: {
                    showWordCount: true,
                    showCharCount: true,
                    countHTML: true,
                    maxWordCount: -1,
                    maxCharCount: 1000,
                }
            });

        }, 100);
    }

    function TRAM_FN_APROBAR_CITA(SeccionID) {

        var seccion_cita = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 2,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": []
        };

        Swal.fire({
            title: '¿Desea aprobar esta acción?',
            text: "Usted aprobará la cita",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar',
            confirmButtonText: 'Sí aprobar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_cita,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_cita_aprobado',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            //ACTUALIZAR APROBADA CITA
                            actualizaCita(false, 'ACEPTADO');

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });
    }

    function TRAM_FN_REPROGRAMAR_CITA(SeccionID) {

        var seccion_cita = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 3,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": [],
            "CONF_DOCUMENTOS": [],
            "nombre_tramite": "{{$tramite->USTR_CNOMBRE_TRAMITE}}",
            "folio_tramite": "{{$tramite->USTR_CFOLIO}}"
        };

        var txtAreaRevision = CKEDITOR.instances['txtAreaCita_' + SeccionID + ''].getData();

        //Verificamos que ingreso notificacion
        if (isEmpty(txtAreaRevision)) {
            Swal.fire({
                icon: "warning",
                title: 'Notificación no ingresada',
                text: "Favor de indicar los puntos que el solicitante requiere atender para validar este paso de su solicitud",
                footer: ''
            });
            return;
        }

        seccion_cita.CONF_NOTIFICACION = txtAreaRevision;

        Swal.fire({
            title: 'Notificar Reprogramación de cita',
            text: "¿Desea notificar al ciudadano la Reprogramación de Cita?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_cita,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_cita_reprogramar',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            //ACTUALIZAR CITA CANCELACION
                            actualizaCita(true, txtAreaRevision);

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });

    }

    //--------------  Ventanilla sin cita  ------------------

    function TRAM_FN_RENDER_VENTANILLA(SeccionID) {
        console.log("Render ventanilla: " + SeccionID);
    }

    function TRAM_FN_APROBAR_VENTANILLA(SeccionID) {

        var seccion_ventanilla = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 2,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": []
        };

        Swal.fire({
            title: '¿Desea aprobar esta acción?',
            text: "Usted aprobará la visita",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar',
            confirmButtonText: 'Sí aprobar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_ventanilla,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_ventanilla_aprobado',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });
    }

    //--------------------- Pago ----------------
    function TRAM_FN_RENDER_PAGO(SeccionID) {
        console.log("Render pago: " + SeccionID);
    }

    function TRAM_FN_APROBAR_PAGO(SeccionID) {

        var seccion_pago = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 2,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": []
        };

        Swal.fire({
            title: '¿Desea aprobar esta acción?',
            text: "Usted aprobará el pago",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar',
            confirmButtonText: 'Sí aprobar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_pago,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_pago_aprobado',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });
    }

    //------------ Resolutivo ---------------
    function TRAM_FN_RENDER_RESOLUTIVO(SeccionID) {

        var list_secciones_tem = @json($secciones);
        var seccion = list_secciones_tem.find(x => parseInt(x.SSEGTRA_NIDSECCION_SEGUIMIENTO) == parseInt(SeccionID));

        if (seccion.SSEGTRA_NIDESTATUS === 2) {

            var list_resolutivos_tem = list_resolutivos.filter(x => parseInt(x.USRE_NIDSECCION) == parseInt(SeccionID) || isNaN(x.USRE_NIDSECCION));
            $('#archivo_resolutivo_' + SeccionID).html("");
            var area_doc_resolutivo = $('#archivo_resolutivo_' + SeccionID);
            var folio = "{{$tramite->USTR_CFOLIO}}";
            var arrayFolio = folio.split('/');

            $.each(list_resolutivos_tem, function(index, value) {
                var itemAddResolutivo = '<span style="font-size: 20px; margin-right: 25px; cursor:pointer;"><i onclick="TRAM_FN_VER_RESOLUTIVO(' + value.USRE_NIDUSUARIO_RESOLUTIVO + ')" class="fas fa-eye"></i></span>';
                itemAddResolutivo += "<a style='font-size: 20px; margin-right: 25px; cursor:pointer;' href='{{ asset('') }}" + value.USRE_CRUTADOC + "' download='Resolutivo_" + arrayFolio[0] + "_" + arrayFolio[1] + "'><i title='Descargar resolutivo' class='fas fa-download'></i></a>";;
                area_doc_resolutivo.append(itemAddResolutivo);
            });
        }
    }

    //------------ Modulos de analisis interno del area--------------
    function TRAM_FN_RENDER_ANALISIS_INTERNO(SeccionID) {
        console.log("Render analisis: " + SeccionID);
    }

    function TRAM_FN_APROBAR_ANALISIS_INTERNO(SeccionID) {

        var seccion_analisis = {
            "SSEGTRA_NIDSECCION_SEGUIMIENTO": SeccionID,
            "CONF_ESTATUSSECCION": 2,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": []
        };

        Swal.fire({
            title: '¿Desea aprobar esta acción?',
            text: "Usted aprobará el Módulo de análisis interno del área",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar',
            confirmButtonText: 'Sí aprobar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_analisis,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_analisis_interno_aprobado',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });
    }

    //------------ Resolutivo electronico --------------
    function TRAM_FN_EMITIR_RESOLUTIVO(SeccionID) {

        var reso_incorrecto = true;
        var input = document.getElementById("documento_resolutivo_" + SeccionID);
        var files = input.files;

        //Validación de tipo de cantidad de files y tipo
        if (!input.files[0]) {
            reso_incorrecto = true;
            Swal.fire({
                icon: "warning",
                title: 'Archivo no subido',
                text: "Debe subir un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB",
                footer: ''
            });
            return;
        }

        if (files.length > 1) {
            reso_incorrecto = true;
            Swal.fire({
                icon: "warning",
                title: 'Excedido cantidad de archivos',
                text: "Solo se acepta un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB",
                footer: ''
            });
            return;
        }

        for (var i = 0; i < files.length; i++) {

            const sizeFile = Math.round((files[i].size / 1024));

            if (sizeFile >= 4096) {

                reso_incorrecto = true;
                Swal.fire({
                    icon: "warning",
                    title: 'Archivo pesado',
                    text: "Solo se acepta un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB",
                    footer: ''
                });
                return;
            } else {

                var typeFile = files[i].type;

                if (typeFile === "image/jpeg" || typeFile === "image/png" || typeFile === "image/gif" || typeFile === "application/pdf") {
                    reso_incorrecto = false;
                } else {
                    reso_incorrecto = true;
                    Swal.fire({
                        icon: "warning",
                        title: 'Formato de archivo no válido',
                        text: "Solo se acepta un archivo con formato PDF, JPG, GIF, PNG que no exceda de los 4 MB",
                        footer: ''
                    });
                    return;
                }
            }
        }


        // var seccionResolutivo = new FormData();
        // formData.append("username", "Groucho");
        // formData.append("accountnum", 123456);
        // HTML file input user's choice...
        // formData.append("userfile", fileInputElement.files[0]);

        var form_data = new FormData();
        form_data.append('CONF_NIDUSUARIOTRAMITE', parseInt("{{request()->route('id') }}"));
        form_data.append('SSEGTRA_NIDSECCION_SEGUIMIENTO', SeccionID);
        form_data.append('estatus_resolutivo', $("#estatus_resolutivo_" + SeccionID).val());
        form_data.append('documento_resolutivo', input.files[0]);
        form_data.append('nombre_tramite', "{{$tramite->USTR_CNOMBRE_TRAMITE}}");
        form_data.append('folio_tramite', "{{$tramite->USTR_CFOLIO}}");

        Swal.fire({
            title: '¿Desea aprobar esta acción?',
            text: "Usted emitirá un resolutivo",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar',
            confirmButtonText: 'Sí aprobar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    url: "/tramite_servicio_cemr/seccion_emitir_resolutivo",
                    method: "POST",
                    data: form_data,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {

                        if (data.estatus === "warning") {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });
                            $("#txt_loading").text("Cargando Trámite...");
                            $("#loading_").hide();
                            return;
                        }

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                })
            }
        });
    }

    //------------ Rechazar trámite --------------
    var id_seccion_rechazar = 0;

    function TRAM_FN_RECHAZAR(SeccionID) {

        CKEDITOR.instances['textRechazarTramite'].setData('');
        id_seccion_rechazar = parseInt(SeccionID);
        $('#modalRechazar').modal('show');
        return;

        /*
        var seccion_formulario = {
            "CONF_ESTATUSSECCION": 2,
            "CONF_NOTIFICACION": "",
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_PREGUNTAS": []
        };*/

        /*
        Swal.fire({
            title: '¿Desea rechazar el trámite?',
            text: "Usted rechazará el trámite",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar',
            confirmButtonText: 'Sí rechazar'
        }).then((result) => {

            if (result.isConfirmed) {

                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();

                if (!(navigator.onLine)) {
                    $("#txt_loading").text("Cargando Trámite...");
                    $("#loading_").hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Sin conexión a intenert',
                        text: "Verifique su conexión de internet e intente de nuevo",
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    data: seccion_formulario,
                    dataType: 'json',
                    url: '/tramite_servicio_cemr/seccion_rechazar_tramite',
                    type: "POST",
                    success: function(data) {

                        if (data.codigo === 200) {

                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);

                        } else {
                            Swal.fire({
                                icon: data.estatus,
                                title: '',
                                text: data.mensaje,
                                footer: '',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                            setTimeout(function() {
                                load_page_seguimiento(ruta);
                            }, 500);
                        }
                    },
                    error: function(data) {

                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();

                        Swal.fire({
                            icon: "error",
                            title: '',
                            text: "Ocurrió un error al guardar el trámite",
                            footer: '',
                            timer: 3000
                        });

                        var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                        load_page_seguimiento(ruta);
                    }
                });
            }
        });*/
    };

    function TRAM_FN_RECHAZAR_SAVE() {

        var seccion_formulario = {
            "CONF_NIDUSUARIOTRAMITE": parseInt("{{request()->route('id') }}"),
            "CONF_NIDSECCION": id_seccion_rechazar,
            "CONF_NOTIFICACION": "",
            "nombre_tramite": "{{$tramite->USTR_CNOMBRE_TRAMITE}}",
            "folio_tramite": "{{$tramite->USTR_CFOLIO}}",
            "CONF_PREGUNTAS": []
        };

        var txtMotivoRechazo = CKEDITOR.instances['textRechazarTramite'].getData();

        //Verificamos que ingreso notificacion
        if (isEmpty(txtMotivoRechazo)) {
            Swal.fire({
                icon: "warning",
                title: 'Motivo no ingresado',
                text: "Favor de indicar el motivo de rechazo del trámite ",
                footer: ''
            });
            return;
        }

        seccion_formulario.CONF_NOTIFICACION = txtMotivoRechazo;

        $("#txt_loading").text("Guardando Trámite...");
        $("#loading_").show();

        if (!(navigator.onLine)) {
            $("#txt_loading").text("Cargando Trámite...");
            $("#loading_").hide();
            Swal.fire({
                icon: "error",
                title: 'Sin conexión a intenert',
                text: "Verifique su conexión de internet e intente de nuevo",
                footer: '',
                timer: 4000,
                showConfirmButton: false
            });
            return;
        }

        $.ajax({
            data: seccion_formulario,
            dataType: 'json',
            url: '/tramite_servicio_cemr/seccion_rechazar_tramite',
            type: "POST",
            success: function(data) {

                if (data.codigo === 200) {

                    Swal.fire({
                        icon: data.estatus,
                        title: '',
                        text: data.mensaje,
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });

                    var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                    setTimeout(function() {
                        load_page_seguimiento(ruta);
                    }, 500);

                } else {
                    Swal.fire({
                        icon: data.estatus,
                        title: '',
                        text: data.mensaje,
                        footer: '',
                        timer: 4000,
                        showConfirmButton: false
                    });

                    var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";

                    setTimeout(function() {
                        load_page_seguimiento(ruta);
                    }, 500);
                }
            },
            error: function(data) {

                $("#txt_loading").text("Cargando Trámite...");
                $("#loading_").hide();

                Swal.fire({
                    icon: "error",
                    title: '',
                    text: "Ocurrió un error al guardar el trámite",
                    footer: '',
                    timer: 3000
                });

                var ruta = "{{route('seguimiento_tramite_servidor', ['id' => request()->route('id')  ])}}";
                load_page_seguimiento(ruta);
            }
        });
    }

    //Conceptos de trámite

    function TRAM_AJX_GUARDAR_CONCEPTOS(SeccionID) {

        var listTemporalConceptos = @json($conceptos);
        var conceptosFilter = listTemporalConceptos.filter(x => parseInt(x.USCON_NIDSECCION) == parseInt(SeccionID));

        if (!(conceptosFilter.length > 0)) {
            Swal.fire({
                title: '¡Aviso!',
                text: "No existen conceptos que guardar",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        Swal.fire({
            title: '',
            text: '¿Está seguro de guardar los conceptos?',
            icon: 'info',
            showCancelButton: true,
            cancelButtonText: 'No, cancelar',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Sí guardar'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#txt_loading").text("Guardando Trámite...");
                $("#loading_").show();
                $.ajax({
                    data: $('#frmFormConceptos_' + SeccionID).serialize(),
                    url: "/tramite_servicio_cemr/guardar_conceptos",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == "success") {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: data.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
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
                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: data.status,
                            title: '',
                            text: data.message,
                            footer: ''
                        });
                        $("#txt_loading").text("Cargando Trámite...");
                        $("#loading_").hide();
                    }
                });
            }
        });
    };

    function descargar(id = 1, name = 'Archivo 1') {

        Swal.fire({
            title: '¡Confirmar!',
            text: "Se descargará el expendiente " + name + " ¿Deseas continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {

                // var data = '';
                $.ajax({
                    type: 'GET',
                    url: '/tramite_servicio_cemr/download_tramite/' + id,
                    // data: data,
                    // xhrFields: {
                    //     responseType: 'json'
                    // },
                    success: function(response) {

                        var host = window.location.origin;
                        var ruta = host + "/" + response.name;
                        window.location = ruta;
                    },
                    error: function(blob) {
                    }
                });
            }
        });
    };
</script>
@endsection
