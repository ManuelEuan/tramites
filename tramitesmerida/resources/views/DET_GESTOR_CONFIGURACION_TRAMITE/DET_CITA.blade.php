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
    {{-- <p style="color: #000000 !important; font-size:16px;"><strong style="font-weight:bold;">ID de trámite:</strong> {id_accede_cita}</p> --}}
    <p style="color: #000000 !important; font-size:16px;"><strong style="font-weight:bold;">Nombre del trámite:</strong> {nombre_tramite_cita} </p>
    {{-- <p style="color: #000000 !important; font-size:16px;"><strong style="font-weight:bold;">Estatus de sincronización al Portal de Citas:</strong> <label style="color: orange;" id="lblSyncCita">...Cargando...</label></p> --}}
</div>
<br>
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

</script>
