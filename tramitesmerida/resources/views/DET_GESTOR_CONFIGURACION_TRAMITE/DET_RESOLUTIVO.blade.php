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
            <select id="cmbResolutivo" class="selectpicker form-control" data-live-search="true" multiple>
                <option value="Autorización">Autorización</option>

                <option value="Permiso de acceso">Permiso de acceso</option>

                <option value="Resolutivo 1">Resolutivo 1</option>

                <option value="Resolutivo 2">Resolutivo 2</option>

                <option value="Resolutivo 3">Resolutivo 3</option>

                <option value="Resolutivo 4">Resolutivo 4</option>

                <option value="Resolutivo 5">Resolutivo 5</option>
            </select>
        </div>
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
            var selected = $('#cmbResolutivo').val();
            TRAM_FN_AGREGAR_RESOLUTIVO(selected);
        });

        if (resolutivos.length > 0) {

            $('#list_resolutivos').html('');
            $('#cmbResolutivo').selectpicker('val', resolutivos);

            $.each(resolutivos, function(key, value) {
                $('#list_resolutivos').append('<li class="list-group-item d-flex justify-content-between align-items-center">' + value + '  <span class="deleteItemResolutivo" onclick="TRAM_FN_ELIMINAR_RESOLUTIVO(' + key + ');" style="cursor:pointer;" title="Eliminar resolutivo" class="badge badge-pill"><i style="font-size:16px;" class="fas fa-times"></i></span></li>');
            });
        }

    });
</script>
