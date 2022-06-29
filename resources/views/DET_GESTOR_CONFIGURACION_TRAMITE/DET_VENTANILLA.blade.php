<div class="card_titulo">
    <span class="circulo" style="height: 80px;width: 80px;">
        <i class="fas fa-male"></i>
    </span>
    <div class="titulo_derecha">
        <span class="">Ventanilla sin cita</span>
    </div>
</div>
<div class="parrafo">
    <p>
    <h6>
        Este módulo se debe establecer cuando dentro del proceso de una solicitud se requiere que el solicitante acuda a ventanilla sin una cita programada.
    </h6>
    </p>
    <hr class="division_2" />
</div>
<div class="parrafo">
    <div class="col-md-12">
        <div class="form-group">
            <label for="cmbEdificios" style="font-size: 1rem; font-weight: bold;">Seleccione edificios</label>
            <select id="cmbEdificios" class="selectpicker form-control" data-live-search="true" multiple>

            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <h6 style="font-size: 1rem; font-weight:bold;">Ubicaciones</h6>
                <div>
                    <ul id="list_edificios" class="list-group" style="height: 23.5rem; cursor: auto; overflow-x: auto;">
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div id="mapaEdificios" style="width: 100%; height:25rem;">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="parrafo">
    <div class="col-md-12">
        <label style="font-size: 1rem;">
            Aquí se genera la plantilla de texto con una breve descripción de los motivos por los que deberá acudir a la ventanilla sin cita, así como los elementos que debe contemplar al momento de presentarse (por ejemplo, documentos que debe llevar)
        </label>
        <textarea id="txtPlantillaExplicacion_sinCita" name="txtPlantillaExplicacion_sinCita"></textarea>
    </div>
</div>

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        CKEDITOR.replace('txtPlantillaExplicacion_sinCita');

        if (textVentanilla !== null && textVentanilla !== "") {
            CKEDITOR.instances['txtPlantillaExplicacion_sinCita'].setData(textVentanilla);
        } else {
            CKEDITOR.instances['txtPlantillaExplicacion_sinCita'].setData("");
        }

        CKEDITOR.instances['txtPlantillaExplicacion_sinCita'].on('change', function() {
            list_sections[_index].descripcion_ventanilla = CKEDITOR.instances['txtPlantillaExplicacion_sinCita'].getData();
            // textVentanilla = CKEDITOR.instances['txtPlantillaExplicacion_sinCita'].getData();
        });



        //Cargar mapa y ubicacion de oficina
        setTimeout(function() {

            map = new google.maps.Map(document.getElementById('mapaEdificios'), {
                center: {
                    lat: 28.639185042057246,
                    lng: -106.07334571552455
                },
                zoom: 13,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_CENTER,
                },
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.BOTTOM_RIGHT,
                },
            });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(28.639185042057246, -106.07334571552455),
                map: map,
                title: 'Ubicación'
            });
        }, 1000);


    });
</script>
