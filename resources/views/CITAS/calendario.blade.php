
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
        <div class="col-lg-12">            
            <div class="card col-lg-12">
                <div class="card-body col-lg-12 row">
                    <div class="col-lg-9">
                        <div id="calendario"></div>
                    </div>
                    <div class="col-lg-3" style="background-color: #f0f0f0; padding-top: 20px;">
                        <h5 class="text-primary text-center"><i class="fas fa-clock text-info"></i>&nbspHorarios disponibles</h5>
                        <hr class="text-primary">
                        <div class="col-lg-12 text-center" style=" width: 100%">
                            <p id="formRFecha">Fecha: </p>
                            <div id="horariosContainer" class="col-lg-12" style="height:300px; overflow-y: scroll;">
                            
                            </div>
                            <button id="btnAgendarCita" disabled class="btn btn-primary" style="margin: 15px;">Agendar</button>
                        </div>
                    </div>
                </div>
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
    <!-- Modal de carga -->
    <div class="modal fade bd-example-modal-lg" id="modalLoad" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-sm" style="display: table; position: relative; margin: 0 auto; top: calc(50% - 24px);">
            <div class="modal-content" style="width: 48px; background-color: transparent; border: none;">
                <div class="spinner-border text-primary" style="width: 10rem; height: 10rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="citaInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¡Tu cita hasido agendada!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center center">
            <p id="citaFolio"></p>
            <p id="citaFecha"></p>
            <p id="citaHora"></p>
            <p id="citaMunicipio"></p>
            <p id="citaModulo"></p>

            <button id="btnPDF" class="btn btn-primary" style="margin: 15px;">Descargar PDF</button>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/locales-all.js"></script>

    <script>
        window.resultadoMes = [];
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
        window.calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: 'es',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
            // right: 'dayGridMonth,timeGridWeek'
          },
          events: [],
          datesSet: cargarEventos,
          dateClick: function(info) {
            dateClickEvent(info);
          }
        });
        window.calendar.render();
    });     
    </script>

    <script>
    function cargarEventos(payload) {
        var tramite = document.getElementById('formTramite').value;
        var modulo = document.getElementById('formEdificio').value;
        if (tramite == 0 || modulo == 0) {
            mostrarAlerta('Debe seleccionar los criterios para la búsqueda.');
            return;
        }
        $('#modalLoad').modal('show');
        var url_api = "<?= $data['API_URL'] ?>";
        var URL_COMP = "";
        if (payload == null){
            const d = new Date();
            URL_COMP = '/' + d.getFullYear() + '/' + (d.getMonth() + 1)
        } else {
            URL_COMP = formatURLGet(payload.view.currentStart);
        }

        $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        request = $.ajax({
            url : '/api/citas/'+ tramite + '/' + modulo + URL_COMP,
            type: "GET"
        });
        //On success
        request.done(function (response, textStatus, jqXHR){
            $('#modalLoad').modal('hide');             
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
        //On failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            $('#modalLoad').modal('hide');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'se presento el siguiente error: ' + errorThrown
            });
        });
    }        
    $('#formFiltrar').click(function () {
        cargarEventos();
    }); 
    </script>

    <script>
        function mostrarAlerta(txt) {
            $("#toastMsj").text(txt);
            $('.toast').toast({delay: 3000});
            $('.toast').toast('show');
        }

        function pintarDisponibilidad(data, payload) {
            var events = [];
            for(var row in data) {
                var color = (data[row].horario.porcentajeOcupacion < 40 // menos de 40 Verde
                    ? '#42E04C' 
                    : ( 40 <= data[row].horario.porcentajeOcupacion // 40 - 80 Amarillo
                    && data[row].horario.porcentajeOcupacion < 80 ? '#FAE847' : '#F01919')); //Mayor a 80 Rojo
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
            //Eliminar eventos del listado
            removeEvents = window.calendar.getEventSources();
            removeEvents.forEach(event => {
                event.remove();
            });
            window.calendar.addEventSource(events) //agregar eventos de resultado de busqueda
            window.calendar.refetchEvents(); //Recolorear los eventos
        }

        function formatURLGet(text) {
            var texto = text;
            var array = texto.toString().split(' ');
            var month = "";
            switch (array[1]) {
                case 'Jan':
                    month = "1"
                    break;
                case 'Feb':
                    month = "2"
                    break;
                case 'Mar':
                    month = "3"
                    break;
                case 'Apr':
                    month = "4"
                    break;
                case 'May':
                    month = "5"
                    break;
                case 'Jun':
                    month = "6"
                    break;
                case 'Jul':
                    month = "7"
                    break;
                case 'Aug':
                    month = "8"
                    break;
                case 'Sep':
                    month = "9"
                    break;
                case 'Oct':
                    month = "10"
                    break;
                case 'Nov':
                    month = "11"
                    break;
                case 'Dec':
                    month = "12"
                    break;
            }

            url = "/" + array[3] + "/" + month;
            return url;
        }

        function dateClickEvent(info) {
            $("#formRFecha").text("Fecha: ");
            window.dateOnDisplay = null;
            $(".rowFecha").remove();
            if (window.resultadoMes.length == 0) {
                mostrarAlerta("Aún debe seleccionar los campos del filtro y agendar en la fecha: " + info.dateStr);
                return;
            }
            var arrFecha = info.dateStr.split('-');
            let fechaDFormat = arrFecha[2] + "/" + arrFecha[1] + "/" + arrFecha[0];
            $("#formRFecha").text("Fecha: " + fechaDFormat);
            var horarios = [];
            for(var row in window.resultadoMes){
                if (info.dateStr == window.resultadoMes[row]['fecha']) {
                    horarios = window.resultadoMes[row]['horario'];
                    window.dateOnDisplay = row;
                }
            }
            $(".rowFecha").remove();
            let ventanillas = horarios.ventanillas;
            var container = document.getElementById("horariosContainer");
            for(var row in horarios.disponibles){
                if (horarios.disponibles[row].recervas < ventanillas) {
                    let element = '<div class="col-lg-12 row rowFecha"><div class="col-lg-9"><p style="margin-top: 6px; margin-bottom: 10px;">' +
                    horarios.disponibles[row].horario + '</p></div><div class="col-lg-3"><label class="container"><input value="' +
                    row +'" type="radio" name="radio"><span class="checkmark"></span></label></div></div>';
                    container.insertAdjacentHTML('beforeend', element);
                }
            }
            $('#btnAgendarCita').removeAttr('disabled');
        }
    </script>

    <script>
        //Funciones para el formulario lateral
        $('#btnAgendarCita').click(function () {
            $('#modalLoad').modal('show');
            var citaSeleccionada = $('input[name="radio"]:checked', '#horariosContainer').val();
            if (window.dateOnDisplay == null || window.dateOnDisplay == undefined ||
                window.dateOnDisplay == 0 || citaSeleccionada == null || citaSeleccionada == undefined) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Necesita seleccionar un horario para agendar una cita'
                });
                return;
            }

            let data    = { 
                "CITA_IDUSUARIO": 999,
                "CITA_FECHA": window.resultadoMes[window.dateOnDisplay].fecha,
                "CITA_HORA": window.resultadoMes[window.dateOnDisplay].horario.disponibles[citaSeleccionada].horario,
                "CITA_IDTRAMITE": document.getElementById('formTramite').value,
                "CITA_IDMODULO":  document.getElementById('formEdificio').value
            };
            $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            request = $.ajax({
                url : '/api/citas',
                type: "POST",
                data: data,
            });
            //On success
            request.done(function (response, textStatus, jqXHR){
                $('#modalLoad').modal('hide');
                if (response.codigo == 200) {
                    $("#citaFolio").text("Folio: " + response.cita.CITA_FOLIO);
                    $("#citaFecha").text("Fecha: " + response.cita.CITA_FECHA);
                    $("#citaHora").text("Hora: " + response.cita.CITA_HORA);
                    $("#citaMunicipio").text("Municipio: " + response.cita.CITA_MUNICIPIO);
                    $("#citaModulo").text("Módulo: " + document.getElementById('formEdificio').value);
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Operación exitosa',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }, 400);
                    window.cita = response.cita;
                    $('#citaInfoModal').modal('show');
                } else {
                    setTimeout(() => {
                        Swal.fire({
                            icon: response.estatus,
                            title: 'Alerta',
                            text: response.mensaje,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }, 400);

                }
            });
            //On failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                $('#modalLoad').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });
        });

        $('#btnPDF').click(function () {
            $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            request = $.ajax({
                url : '/citas/descargar',
                type: "POST",
                data: window.cita,
                responseType: 'blob'
            });
            //On success
            request.done(function (response, textStatus, jqXHR){
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "cita.pdf";
                link.click();
            });
            //On failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });
        });
    </script>
@endsection
