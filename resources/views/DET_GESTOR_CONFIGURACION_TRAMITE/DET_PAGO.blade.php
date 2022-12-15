<div class="card_titulo">
    <span class="circulo" style="height: 80px;width: 80px;">
        <i class="far fa-credit-card"></i>
    </span>
    <div class="titulo_derecha">
        <span class="">Pago en línea</span>
    </div>
</div>
<div class="parrafo">
    <p>
    <h6>Este módulo está vinculado con el sistema de Pagos en línea, de manera que el solicitante pueda realizar el cobro de derechos correspondiente de manera automática cuando el módulo esté activo.</h6>
    </p>
    <hr class="division_2" />
</div>

<div class="parrafo">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="cmbConceptoPago" style="font-size: 1rem; font-weight: bold;">Seleccione los conceptos de pago</label>
                    <select id="cmbConceptoPago" class="selectpicker form-control" data-live-search="true" multiple></select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="cmbServices" style="font-size: 1rem; font-weight: bold;">Seleccione servicio externo requerido</label>
                    <select id="cmbServices" class="selectpicker form-control" data-live-search="true" multiple></select>
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

        var cmbConceptoPago = $('#cmbConceptoPago');
        cmbConceptoPago.find('option').remove();
        $(list_conceptos_tramite).each(function(i, v) {
            cmbConceptoPago.append('<option value="' + v.ID + '" data-content="<small><strong>' + v.Referencia + '</strong> | ' + v.Concepto + '</small>"></option>');
        })

        $('#cmbConceptoPago').selectpicker({
            noneSelectedText: 'Seleccione conceptos de pago',
            noneResultsText: 'Conceptos de pago no encontrados',
        });

        $('#cmbConceptoPago').on('change', function() {
            var selected = $('#cmbConceptoPago').val();
            TRAM_FN_AGREGA_CONCEPTO_PAGO(selected);
        });

        if (list_conceptos.length > 0) {
            var idTemporalesConceptos = [];
            $.each(list_conceptos, function(index, value) {
                idTemporalesConceptos.push(value.ID);
            });
            $('#cmbConceptoPago').selectpicker('val', idTemporalesConceptos);
        }

        var cmbServices = $('#cmbServices');
        cmbServices.find('option').remove();
        $(list_servicios_tramite).each(function(i, v) {
            cmbServices.append('<option value="' + v.SERV_ID + '" data-content="<small><strong>' + v.SERV_DESCRIPTION + '</strong></small>"></option>');
        })

        $('#cmbServices').selectpicker({
            noneSelectedText: 'Seleccione servicio',
            noneResultsText: 'Servicios no encontrados',
        });

        $('#cmbServices').on('change', function() {
            var selected = $('#cmbServices').val();
            TRAM_FN_AGREGA_SERVICIO(selected);
        });

        if (list_servicios.length > 0) {
            var idTemporalesServicios = [];
            $.each(list_servicios, function(index, value) {
                idTemporalesServicios.push(value.SERV_ID);
            });
            $('#cmbServices').selectpicker('val', idTemporalesServicios);
        }
    });
</script>
