<div class="card_titulo">
    <span class="circulo" style="height: 80px;width: 80px;">
        <i class="far fa-copy"></i>
    </span>
    <div class="titulo_derecha">
        <span class="">Resolutivo electrónico</span>
    </div>
</div>
<div class="parrafo">
    <div class="col-md-12">
        <div class="form-group">
            <label for="cmbResolutivo" style="font-size: 1rem; font-weight: bold;">Indique el nombre del resolutivo electrónico que se le enviará al solicitante en esta etapa del proceso.</label>
            <select id="cmbResolutivo" class="selectpicker form-control" onchange="TRAM_FN_CAMBIORESOLUTIVO();" data-live-search="true">
            </select>
        </div>
        <div class="form-group">
            <label for="cmbResolutivo" style="font-size: 1rem; font-weight: bold;">Selecione el archivo de word que se usara como plantilla .</label><br />
            <label for="cmbResolutivo" style="font-size: 1rem; font-weight: bold;" id="lbFileNameResolutivo">Nombre archivo: </label><br />
            <input type="file" name="fileResolutivo" id="fileResolutivo" />
        </div>

    </div>
    <div class="col-md-12" id="contenerdorCamposPlantillaResolutivo"> </div>

    <div class="btnContenedor" style="margin-top:2%;">
        <button type="button" class="btn btn-success border btnLetras btnAgregaRespuesta" onclick="TRAM_FN_MOSTRARMODALADDCAMPORESOLUTIVO()"> Agregar Campo</button>
    </div>
    <br>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <ul id="list_resolutivos" class="list-group" style="height: 23.5rem; cursor: auto; overflow-x: auto;">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var cmbResolutivo = $('#cmbResolutivo');
        cmbResolutivo.find('option').remove();
        $(list_resolutivos_tramite).each(function(i, v) {
            cmbResolutivo.append('<option value="' + v.nombre + '">' + v.nombre + '</option>');
        })

        $('#cmbResolutivo').selectpicker({
            noneSelectedText: 'Seleccione resolutivos',
            noneResultsText: 'Resolutivos no encontrados',
        });

        $('#cmbResolutivo').on('change', function() {
            //var selected = $('#cmbResolutivo').val();
            // TRAM_FN_AGREGAR_RESOLUTIVO(selected);
            TRAM_FN_CAMBIORESOLUTIVO();
        });

        if (tramite_.resolutivos.length > 0) {
            var firsResolutuvo = tramite_.resolutivos[0];
            objResolutivoEletronico.nameFile = firsResolutuvo.RESO_CNAMEFILE;
            $("#lbFileNameResolutivo").html(objResolutivoEletronico.nameFile);

            objResolutivoEletronico.nameResolutivo = firsResolutuvo.RESO_CNOMBRE;
            $("#cmbResolutivo").val(objResolutivoEletronico.nameResolutivo);

            objResolutivoEletronico.list_mapeo_resolutivo = [];

            firsResolutuvo.MAPEO.forEach(function(v, i) {

                var campo = {
                    idFormulario: undefined,
                    formulario: undefined,
                    idPregunta: undefined,
                    pregunta: undefined,
                    campo: undefined,
                }

                campo.idFormulario = v.TRAM_NIDFORMULARIO;
                //campo.formulario = $("#cmbFormulario option:selected").text();
                campo.idPregunta = v.TRAM_NIDPRGUNTA;
                campo.pregunta = v.FORM_CPREGUNTA;
                campo.campo = v.TRAM_CNOMBRECAMPO;

                objResolutivoEletronico.list_mapeo_resolutivo.push(campo);

                TRAM_FN_RENDERCAMPOSRESOLUTIVO();

            });




        }

        if (resolutivos.length > 0) {

            //alert("resolutivo");

            console.log("resolutivos des",  tramite_.resolutivos[0]);

            /* $('#list_resolutivos').html('');
            $('#cmbResolutivo').selectpicker('val', resolutivos);

            $.each(resolutivos, function(key, value) {
                $('#list_resolutivos').append('<li class="list-group-item d-flex justify-content-between align-items-center">' + value + '  <span class="deleteItemResolutivo" onclick="TRAM_FN_ELIMINAR_RESOLUTIVO(' + key + ');" style="cursor:pointer;" title="Eliminar resolutivo" class="badge badge-pill"><i style="font-size:16px;" class="fas fa-times"></i></span></li>');
            }); */
        }

    });
</script>