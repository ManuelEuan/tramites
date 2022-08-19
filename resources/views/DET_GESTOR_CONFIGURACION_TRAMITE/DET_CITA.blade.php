<input type="hidden" id="tramiteID" value="{id_accede_cita}">

<div class="card_titulo">
    <span class="circulo" style="height: 80px;width: 80px;">
        <i class="far fa-calendar-alt"></i>
    </span>
    <div class="titulo_derecha">
        <span class="">Citas en línea</span>
    </div>
</div>
<div class="parrafo">
    <p>
    <h6>
        Este módulo está vinculado con el Portal de Citas por Internet, de manera que el solicitante pueda agendar automáticamente sus citas cuando el módulo esté activo.
    </h6>
    </p>
    <hr class="division_2" />
</div>
<div class="parrafo">
    <br>
    <p style="color: #000000 !important; font-size:16px;"><strong style="font-weight:bold;">ID de trámite:</strong> {id_accede_cita}</p>
    <p style="color: #000000 !important; font-size:16px;"><strong style="font-weight:bold;">Nombre del trámite:</strong> {nombre_tramite_cita} </p>
    <p style="color: #000000 !important; font-size:16px;"><strong style="font-weight:bold;">Estatus de sincronización al Portal de Citas:</strong> <label style="color: orange;" id="lblSyncCita">...Cargando...</label></p>
</div>
<br>

<div class="parrafo">
    <div class="col-md-12">
        <div class="accordion" id="accordionExample">
            <div id="htmHorario"></div>
        </div> 
    </div>
</div>

<div class="parrafo">
    <div class="col-md-12">
        <label style="font-size: 1rem;">
            Aquí se genera la plantilla de texto con una breve descripción de los motivos por los que deberá acudir a la cita, así como los elementos que debe contemplar al momento de presentarse (por ejemplo, documentos que debe llevar)
        </label>
        <textarea id="txtPlantillaExplicacionCita" name="txtPlantillaExplicacionCita" maxlength="50"></textarea>
    </div>
</div>


<script>
    CKEDITOR.replace('txtPlantillaExplicacionCita');

    if (textCita !== null && textCita !== "") {
        CKEDITOR.instances['txtPlantillaExplicacionCita'].setData(textCita);
    } else {
        CKEDITOR.instances['txtPlantillaExplicacionCita'].setData("");
    }

    CKEDITOR.instances['txtPlantillaExplicacionCita'].on('change', function() {
        list_sections[_index].descripcion_cita = CKEDITOR.instances['txtPlantillaExplicacionCita'].getData();
        // textCita = CKEDITOR.instances['txtPlantillaExplicacionCita'].getData();
    });

    validateCitasSync("lblSyncCita");

    const d = new Date();
    let text = d.toLocaleTimeString();

    /***************** Manuel Euan /*****************/
    var tramiteId =  $("#tramiteID").val();
    /* if(getModulos){ */
        $.ajax({
            dataType: 'json',
            url: "/gestores/detalleTramite/" + tramiteId + "",
            type: "GET",
            success: function(response) {
                let oficinas    = response.data.oficinas;
                let horarios    = response.data.horario;
                let show        = 'show';
                let html        = '';
               
                oficinas.forEach(oficina => {
                    html += `
                    <div class="card">
                        <div class="card-header" id="heading${oficina.iId}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse${oficina.iId}" aria-expanded="true" aria-controls="collapse${oficina.iId}">
                                    ${oficina.Name}
                                </button>
                            </h2>
                        </div>
              
                        <div id="collapse${oficina.iId}" class="collapse ${show}" aria-labelledby="heading${oficina.iId}" data-parent="#accordionExample">
                            <div class="row cardHorario">
                                <div class="col-sm-6">
                                    <div class="card cardDias">
                                        <div class="card-header"><label class="tituloHorario"> Horario de atención </label></div>
                                        <div class="card-body"> `;
                                            horarios.forEach(horario => {
                                                if(horario.Id == oficina.Id){
                                                    let entrada = formatAMPM(horario.OpeningHour);
                                                    let salida  = formatAMPM(horario.ClosingHour);
    
                                                    html += `
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="chDia${horario.diaId}"  id="chDia${horario.diaId}" value="${horario.diaId}">
                                                                    <label class="form-check-label" for="chDia${horario.diaId}"> ${ horario.diaNombre } </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4"> ${ entrada } </div>
                                                            <div class="col-md-4"> ${ salida } </div>
                                                        </div>`;
                                                }
                                            });
                                        html += `</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    show = '';
                });

                $("#htmHorario").html(html);
                getModulos = false;
            },
            error: function(data) {
                console.log(data)
            }
        });
    /* } */

    function formatAMPM(hora) {
        let array = hora.split(':');
        var ampm = array[0] >= 12 ? 'pm' : 'am';
        array[0] = array[0] % 12;
        array[0] = array[0] ? array[0] : 12; // the hour '0' should be '12'
        array[1] = array[1] < 10 ? '0'+ array[1] : array[1];

        return array[0] + ':' + array[1] + ' ' + ampm;
    }


</script>

<style>
    .cardHorario{
        margin-top: 4%
    }

    .cardDias{
        margin-left: 10%;
        margin-bottom: 10%;
    }
</style>