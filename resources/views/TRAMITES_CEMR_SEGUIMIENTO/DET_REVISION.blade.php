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

<div id="txtRevisionInfo_ReDoc" class="row columna" style="display: none;">
    <div class="col-md-12">
        <h3 class="indicaciones">Favor de seleccionar los campos que considera que el solicitante deberá editar o completar.</h3>
    </div>
</div>

{{-- Acoordion Secciones --}}
<div class="row columna">
    <div class="col-md-12">
        <div id="accordion_ReDoc">
        </div>
        <div id="accordion_documentos_ReDoc">
            <div class="card">
                <div class="card-header" id="heading_documento_ReDoc">
                    <h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapse_documento_ReDoc" aria-controls="collapse_documento_ReDoc">Documentos</button></h5>
                </div>
                <div id="collapse_documento_ReDoc" class="collapse " aria-labelledby="heading_documento_ReDoc" data-parent="#accordion_documentos_ReDoc">
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
</div>
{{-------------------}}

