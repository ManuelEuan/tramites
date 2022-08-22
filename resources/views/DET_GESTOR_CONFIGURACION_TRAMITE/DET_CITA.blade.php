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
            <div class="card">
                <div class="card-header" id="heading">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="true" aria-controls="collapse">
                            Modulo
                        </button>
                    </h2>
                </div>
      
                <div id="collapse" class="collapse show" aria-labelledby="heading" data-parent="#accordionExample">
                    <div class="container formHorario">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row ">
                                    <div class="form-group  col-md-3">
                                        <label for="diaSemana">Días</label>
                                        <select class="custom-select" id="diaSemana">
                                            <option value="0">Seleccionar</option>
                                            <option value="Lunes">Lunes</option>
                                            <option value="Martes">Martes</option>
                                            <option value="Miercoles">Miercoles</option>
                                            <option value="Jueves">Jueves</option>
                                            <option value="Viernes">Viernes</option>
                                            <option value="Sabado">Sabado</option>
                                            <option value="Domingo">Domingo</option>
                                        </select>
                                    </div>
        
                                    <div class="form-group col-md-2">
                                        <label for="horaInicial">Hora inicial</label>
                                        <input type="time" class="form-control" id="horaInicial" placeholder="Hora inicial" required>
                                    </div>
        
                                    <div class="form-group col-md-2">
                                        <label for="horaFinal">Hora final</label>
                                        <input type="time" class="form-control" id="horaFinal" placeholder="Hora final" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="capacidad">Capacidad</label>
                                        <input type="number" min="0" class="form-control" id="capacidad" placeholder="Personas" required>
                                    </div>
                                    <div class="col-md-2 btnAddDia">
                                        <button type="button" class="btn btn-info btn-circle btn-xl" onclick="agregarDia()" title="Agregar">
                                            <i class="fa fa-add"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="card cardDias">
                                            <div class="card-header"><label class="tituloHorario"> Horario de atención </label></div>
                                            <div class="card-body" id="detalleHorario"> 
                                                <ul>
                                                    <li>
                                                        <div class="row lineaDia" >
                                                            <div class="col-md-4">
                                                                <div class="form-check form-check-inline">
                                                                    <label class="form-check-label" for=""> Lunes </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">9:00 am </div>
                                                            <div class="col-md-3">5:30 pm </div>
                                                            <div class="col-md-2"><i class="fa fa-trash"></i></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-5" >
                                        <div class="form-group col-md-6" style="margin-top: 10%;">
                                            <label for="tiempoAtencion">Tiempo de atención</label>
                                            <input type="number" min="1" class="form-control" placeholder="Minutos"  id="tiempoAtencion" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="ventanillas">Ventanillas</label>
                                            <input type="number" min="10" class="form-control" placeholder="Ventanillas" id="ventanillas" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>

            {{-- <div id="htmHorario"></div> --}}
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

    function agregarDia(){
        let dia         = $("#diaSemana").val();
        let inicio      = $("#horaInicial").val();
        let final       = $("#horaFinal").val();
        let capacidad   = $("#capacidad").val();

        dia         == 0 || "" ? $("#diaSemana").addClass("is-invalid") : $("#diaSemana").removeClass("is-invalid");
        inicio      == 0 || "" ? $("#horaInicial").addClass("is-invalid") : $("#horaInicial").removeClass("is-invalid");
        final       == 0 || "" ? $("#horaFinal").addClass("is-invalid") : $("#horaFinal").removeClass("is-invalid");
        capacidad   == 0 || "" ? $("#capacidad").addClass("is-invalid") : $("#capacidad").removeClass("is-invalid");

        if(dia == 0 || inicio == 0 || final == 0 || capacidad == 0 ){
            return;
        }
        else{

            let actual = $("#cardDias").html();

            console.log(actual);
        }

        /* if(dia == 0)
            $("#diaSemana").addClass("is-invalid");
        else 
            $("#diaSemana").removeClass("is-invalid"); */
        console.log(dia, inicio,final,capacidad)
    }


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
    .formHorario{
        margin: 4%;
    }

    .btn-circle.btn-xl {
        width: 40px;
        height: 40px;
        padding: 7px 10px;
        border-radius: 35px;
        font-size: 18px;
        line-height: 1;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
    }

    .card-header{
        text-align: center !important;
    }
    .cardDias{
        margin-top: 4%;
    }
    .btnAddDia{
        margin-top: 1.5%;
    }
    .lineaDia{
        margin-bottom: 20px;
    }
</style>