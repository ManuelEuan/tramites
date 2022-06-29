<div class="card_titulo">
    <span class="circulo" style="height: 80px;width: 80px;">
        <i class="far fa-folder"></i>
    </span>
    <div class="titulo_derecha">
        <span class="">Formulario</span>
    </div>
</div>
<div class="parrafo">
    <p>
    <h6>
        Este módulo es el primero para la configuración del trámite, en este espacio se define el cuestionario que deberá llenar cada solicitante, así como los documentos que deberán adjuntar de manera digital.
    </h6>
    </p>
    <hr class="division_2" />
</div>
{{-- Buscador --}}
<div id="boxSearchAddFormulario" class="box">
    <div class="container-1">
        <span class="icon"><i class="fa fa-search"></i></span>
        <input onkeyup="TRAM_FN_BUSCAR_FORMULARIO();" type="search" id="search" autocomplete="off" placeholder="Buscar..." />
    </div>
    <div style="text-align: center; margin-top:10px;">
        <a id="btnAgregarFormulario" href="/gestores/formulario" class="btn  btn-sm btnAzul">Crear nuevo formulario</a>
    </div>
</div>

{{-- Buscador --}}
<div>
    <div id="listFormulario" class="parrafo_formulario">
        <!-- <div class="row">
            <div class="col-10">
                <p>
                <h6 class="negritas">Formulario de datos de identificación</h6>
                <h6>Activo</h6>
                Formulario que contiene los campos con los datos de identificación del solicitante del trámite
                </p>
            </div>
            <div class="col-2" style="align-items: center; display: flex; justify-content: center;">
                <div class="form-group">
                    <div class="form-check">
                        <input style="width: 1.4rem; height: 1.4rem;" class="form-check-input" type="checkbox" id="gridCheck">
                    </div>
                </div>
            </div>
        </div>
        <hr class="division_2" />

        <div class="row">
            <div class="col-10">
                <p>
                <h6 class="negritas">Formulario de datos de identificación</h6>
                <h6>Activo</h6>
                Formulario que contiene los campos con los datos de identificación del solicitante del trámite
                </p>
            </div>
            <div class="col-2" style="align-items: center; display: flex; justify-content: center;">
                <div class="form-group">
                    <div class="form-check">
                        <input style="width: 1.4rem; height: 1.4rem;" class="form-check-input" type="checkbox" id="gridCheck">
                    </div>
                </div>
            </div>
        </div>
        <hr class="division_2" /> -->
    </div>
    <div style="text-align: center; margin-top:15px; margin-bottom:15px;">
        <button id="btnAddDocumento" class="btn  btn-sm btnAzul" onclick="TRAM_FN_ASIGNAR_DOCUMENTOS();">Agregar documentos</button>
    </div>
</div>

<div class="modal fade" id="documentosModal" tabindex="-1" role="dialog" aria-labelledby="documentosModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 650px;">
            <div class="modal-header" style="background-color: #37BFFA; color:#fff;">
                <h5 class="modal-title" id="documentosModalLabel" style="text-align: center;">Documentos</h5>
            </div>
            <div class="modal-body">
                <div style="padding: 16px;">
                    <div class="row">
                        <strong>Favor de indicar los documentos que deberá adjuntar cada solicitante. La relación de documentos se obtiene del Registro Estatal de Trámites y Servicios, por lo que no se pueden adicionar más documentos de los establecidos.</strong>
                    </div>
                    <div id="divSearchDocumento" class="row" style="padding: 16px;">
                        <input type="text" id="searchDocumento" onkeyup="TRAM_FN_BUSCAR_DOCUMENTOS()" placeholder="Buscar documentos.." title="Escriba el nombre del documento">
                    </div>
                </div>
                <div id="listDocumentos">
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button> -->
                <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
