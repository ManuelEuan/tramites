<div class="row columna">
    <div class="col-md-3">
        <label class="titulo_pequeno">Nombre</label> <br>
        <label class='respuesta_pequena'>{{$tramite->USTR_CNOMBRE}}</label>
    </div>
    <div class="col-md-2">
        <label class="titulo_pequeno">Primer Apellido</label> <br>
        <label class='respuesta_pequena'>{{$tramite->USTR_CPRIMER_APELLIDO}}</label>
    </div>
    <div class="col-md-3">
        <label class="titulo_pequeno">Segundo Apellido</label> <br>
        <label class='respuesta_pequena'>{{$tramite->USTR_CSEGUNDO_APELLIDO}}</label>
    </div>

    <div class="col-md-3">
        <label class="titulo_pequeno">Folio del trámite</label> <br>
        <label class='respuesta_pequena'>{{$tramite->USTR_CFOLIO}}</label>
    </div>
</div>
<div class="row columna">
    <div class="col-md-3">
        <label class="titulo_pequeno">RFC</label> <br>
        <label class='respuesta_pequena'>{{$tramite->USTR_CRFC}}</label>
    </div>
    <div class="col-md-3">
        <label class="titulo_pequeno">CURP</label> <br>
        <label class='respuesta_pequena'>{{$tramite->USTR_CCURP}}</label>
    </div>
</div>

<div id="txtRevisionInfo" class="row columna" style="display: none;">
    <div class="col-md-12">
        <h3 class="indicaciones">Favor de seleccionar los campos que considera que el solicitante deberá editar o completar.</h3>
    </div>
</div>

{{-- Acoordion Secciones --}}
<div class="row columna">
    <div class="col-md-12">
        <div id="accordion">
        </div>
        <div id="accordion_documentos">
            <div class="card">
                <div class="card-header" id="heading_documento">
                    <h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapse_documento" aria-controls="collapse_documento">Documentos</button></h5>
                </div>
                <div id="collapse_documento" class="collapse " aria-labelledby="heading_documento" data-parent="#accordion_documentos">
                    <!-- <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-2">
                                        <img src="{{ asset('assets/template/img/jpg.png') }}" width="25" height="25">
                                    </div>
                                    <div class="col-8">
                                        <p><label class="titulo_pequeno">Acta de Nacimiento</label></p>
                                    </div>
                                    <div class="col-2">
                                        <span style="padding-right: 15px;font-size: 20px;"><i title="Ver documento" style="cursor:pointer;" onclick="TRAM_FN_VER_DOCUMENTO()" class="fas fa-eye"></i></span>
                                        <span style="font-size: 20px;"><i title="Descargar documento" style="cursor:pointer;" onclick="TRAM_FN_DOWNLOAD_DOCUMENTO()" class="fas fa-download"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 validatePregunta" style="display: block;">
                                <div class="form-check form-check-inline"><input onchange="TRAM_FN_ACEPTAR_PREGUNTA(21);" class="form-check-input" type="radio" name="radio_pregunta_21" id="radio_aceptar_21" value="2" checked=""><label class="form-check-label respuesta_pequena " for="radio_aceptar_21">Aceptar</label></div>
                                <div class="form-check form-check-inline"><input onchange="TRAM_FN_RECHAZAR_PREGUNTA(21);" class="form-check-input" type="radio" name="radio_pregunta_21" id="radio_rechazar_21" value="1"><label class="form-check-label respuesta_pequena" for="radio_rechazar_21">Rechazar</label></div>
                            </div>
                            <div class="col-md-4 validatePregunta" style="display: block;">
                                <div class="form-group"><textarea style="display:none;" onchange="TRAM_FN_JUSTIFICACION(21)" class="form-control txtJustificacion" id="txt_justificacion_pregunta_21" rows="3" placeholder="Justificacion"></textarea></div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
</div>
{{-------------------}}
