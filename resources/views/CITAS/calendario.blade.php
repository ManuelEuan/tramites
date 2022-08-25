
@extends('layout.Layout')

@section('body')
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-md-12">
                <h2>Citas</h2>
            </div>
        </div>
        <p>
            <button id = "mostrarFiltro" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Filtro Seleccionado: <span>Trámite / Edificio</span>
            </button>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
            <div class="form-row">
                <div class="form-group col-lg-5 col-md-5 col-lg-5 col-sm-12">
                    <label for="formTramite">Trámite</label>
                    <select id="formTramite" class="form-control">
                        <option value="0" selected>Seleccionar trámite</option>
                        <option value="45">Prueba trámite</option>
                        <option value="0">...</option>
                    </select>
                </div>
                <div class="form-group col-lg-5 col-md-5 col-sm-12">
                    <label for="formEdificio">Edificio</label>
                    <select id="formEdificio" class="form-control">
                        <option value="0" selected>Seleccionar edificio</option>
                        <option value="14">Prueba edificio</option>
                        <option value="0">...</option>
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-2 col-sm-12 text-center center">
                    <button id="formFiltrar" style="margin-top: 3px;" class="btn btn-primary btn-lg"><i class="fas fa-search"></i>&nbspFiltrar</button>
                </div>
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div id="calendario"></div>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i id="toastIcon" class="fas fa-search"></i>
                <strong class="mr-auto">&nbsp Notificación</strong>
                <small>Ahora</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body" id="toastMsj">
                
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/locales-all.js"></script>

    <script>
        function cambiarTextoBtnMostartFiltro() {
            var txtTramite = $("#formTramite option:selected").text();
            var txtModulo = $("#formEdificio option:selected").text();
            $("#mostrarFiltro").text("Filtro Seleccionado: "+txtTramite+" / "+txtModulo);
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        cambiarTextoBtnMostartFiltro();
        
        var calendarEl = document.getElementById('calendario');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: 'es',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
            // right: 'dayGridMonth,timeGridWeek'
          },
          events: [],
          dateClick: function(info) {
            // alert('Clicked on: ' + info.dateStr);
            mostrarAlerta("Aún debe seleccionar los campos del filtro y agendar en la fecha: " + info.dateStr);
          }
        });
        calendar.render();
    });     
    </script>

    <script>        
    $('#formFiltrar').click(function () {
        var url_api = "<?= $data['API_URL'] ?>";
        var tramite = document.getElementById('formTramite').value;
        var modulo = document.getElementById('formEdificio').value;

        if (tramite == 0 || modulo == 0) {
            mostrarAlerta('Debe seleccionar los criterios para la búsqueda.');
            return;
        }

        const d = new Date();

        $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        request = $.ajax({
            url : '/api/citas/'+ tramite + '/' + modulo + '/' + d.getFullYear() + '/' + (d.getMonth() + 1),
            type: "GET"
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){                
            pintarDisponibilidad(response);
            mostrarAlerta("Se cargaron los horarios disponibles");
            window.resultadoMes = response;
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Operación exitosa',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 400);
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });

    }); 
    </script>

    <script>
        window.resultadoMes = [];
        function mostrarAlerta(txt) {
            $("#toastMsj").text(txt);
            $('.toast').toast({delay: 3000});
            $('.toast').toast('show');
        }

        function pintarDisponibilidad(data) {
            var events = [];
            for(var row in data) {
                var color = (data[row].horario.porcentajeOcupacion < 40 
                    ? '#42E04C' 
                    : ( 40 <= data[row].horario.porcentajeOcupacion 
                    && data[row].horario.porcentajeOcupacion < 80 ? '#FAE847' : '#F01919'));
                color = (data[row].horario.length == 0 ? '#F01919' : color)
                var colores = {
                    start: data[row].fecha,
                    end: data[row].fecha,
                    overlap: false,
                    display: 'background',
                    color: color
                };
                events.push(colores);
            }
            // document.getElementById('calendario')
            // $('#calendario').fullCalendar({
            //     events: [events]
            // });

            var calendarEl = document.getElementById('calendario');
            var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
                // right: 'dayGridMonth,timeGridWeek'
            },
            events: events,
            dateClick: function(info) {
                alert('Clicked on: ' + info.dateStr);
            }
            });
            calendar.render();
        }
    </script>
@endsection
