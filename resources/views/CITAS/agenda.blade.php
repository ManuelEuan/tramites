
@extends('layout.Layout')

@section('body')
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-md-12">
                <h2>Citas</h2>
            </div>
        </div>

        <div class="col-lg-12" style="margin-bottom: 20px;">
            <div class="card card-body">
                <div class="form-row">
                    <div class="form-group col-lg-5 col-md-5 col-lg-5 col-sm-12">
                        <label for="formTramite">Trámite</label>
                        <select id="formTramite" class="form-control">
                            <option value="0" selected>Seleccionar trámite</option>
                            @foreach ($data['tramites'] as $tramite)
                                <option value="{{$tramite->TRAM_NIDTRAMITE_ACCEDE}}"> {{ $tramite->TRAM_CNOMBRE }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-5 col-md-5 col-sm-12">
                        <label for="formEdificio">Edificio</label>
                        <select id="formEdificio" class="form-control">
                            <option value="0" selected>Seleccionar edificio</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-12 text-center center">
                        <button id="formFiltrar" style="margin-top: 3px;" class="btn btn-primary btn-lg"><i class="fas fa-search"></i>&nbspFiltrar</button>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#infoCita">
                        Launch demo modal
                      </button>

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
                        <h5 class="text-primary text-center"><i class="fas fa-clock text-info"></i>&nbsp Citas programadas</h5>
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
    <div id='modalLoading' class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-sm" style="display: table; position: relative; margin: 0 auto; top: calc(50% - 24px);">
            <div class="modal-content" style="width: 48px; background-color: transparent; border: none;">
                <div class="spinner-border text-primary" style="width: 10rem; height: 10rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <div id="infoCita" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información de cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="text-align: center;">
                    <p>
                        <label class="titulo"> <b>Trámite:</b></label>
                        <label class="respuesta" id="txtTramite"></label>
                    </p>
                    <p>
                        <label class="titulo"> <b>Solicitante:</b></label>
                        <label class="respuesta" id="txtSolicitante"></label>
                    </p>
                    <p>
                        <label class="titulo"> <b>Folio:</b></label>
                        <label class="respuesta" id="txtFolio"></label>
                    </p>
                    <p>
                        <label class="titulo"> <b>Fecha:</b></label>
                        <label class="respuesta" id="txtFecha"></label>
                    </p>
                    <p>
                        <label class="titulo"> <b>Hora:</b></label>
                        <label class="respuesta" id="txtHora"></label>
                    </p>
                    <p>
                        <label class="titulo"> <b>Municipio:</b></label>
                        <label class="respuesta" id="txtMunicipio"></label>
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Reagendar</button>
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
        var citas = [];
        function cargarEventos(payload) {
            var tramite = document.getElementById('formTramite').value;
            var modulo = document.getElementById('formEdificio').value;

            if (tramite == 0 || modulo == 0) {
                mostrarAlerta('Debe seleccionar los criterios para la búsqueda.');
                return;
            }

            $('#modalLoading').modal('show');
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
                $('#modalLoading').modal('hide');
                pintarDisponibilidad(response);
                mostrarAlerta("Se cargaron los horarios disponibles");
                window.resultadoMes = response;
            });
            //On failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                $('#modalLoading').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });
        }

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
                case 'Jan': month = "1"; break;
                case 'Feb': month = "2"; break;
                case 'Mar': month = "3"; break;
                case 'Apr': month = "4"; break;
                case 'May': month = "5"; break;
                case 'Jun': month = "6"; break;
                case 'Jul': month = "7"; break;
                case 'Aug': month = "8"; break;
                case 'Sep': month = "9"; break;
                case 'Oct': month = "10"; break;
                case 'Nov': month = "11"; break;
                case 'Dec': month = "12"; break;
            }

            url = "/" + array[3] + "/" + month;
            return url;
        }

        function dateClickEvent(info) {
            if (window.resultadoMes.length == 0) {
                mostrarAlerta("Aún debe seleccionar los campos del filtro y agendar en la fecha: " + info.dateStr);
                return;
            }

            citas           = [];
            var arrFecha    = info.dateStr.split('-');
            let horarios    = [];
            let fechaDFormat = arrFecha[2] + "/" + arrFecha[1] + "/" + arrFecha[0];
            $("#formRFecha").text("Fecha: " + fechaDFormat);
            $('#modalLoading').modal('show');

            $.ajax({
                url: "/citas/listado",
                type: "GET",
                data: {
                    tramite_id  : 60,
                    modulo_id   : 13,
                    fecha_inicio: info.dateStr,
                    fecha_final : info.dateStr,
                    order_by    : "c.CITA_HORA"
                },
                success: function(data) {
                    citas           = data.data;
                    let container   = document.getElementById("horariosContainer");

                    citas.forEach(element => {
                        let hora = formatAMPM( element.CITA_HORA);
                        let html =  `<div class="col-lg-12 row rowFecha">
                                        <div class="col-lg-12" onclick="getDetalle(${element.idcitas_tramites_calendario})">
                                            <p class="leyendaDerecha">
                                                ${ element.nombre.toUpperCase() } ${ element.apellido_paterno.toUpperCase() } ${ hora }
                                            </p>
                                        </div>
                                    </div>`;
                        container.insertAdjacentHTML('beforeend', html);
                    });
                    $('#modalLoading').modal('hide');
                },
                error: function(data) {
                    console.log(data);
                    $('#modalLoading').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'se presento el siguiente error: ' + data
                    });
                }
            });
            $(".rowFecha").remove();
        }

        function getDetalle(citaId){
            let tramite = $("#formTramite").text();

            /* citas.forEach(element => {
                if(element.idcitas_tramites_calendario == citaId){
                    let hr      = formatAMPM(element.CITA_HORA);
                    let arrFech = element.CITA_FECHA.split('-');
                    let fecha   = arrFech[2] + "/" + arrFech[1] + "/" + arrFech[0];
                    let solici  = element.nombre.toUpperCase() + " " + element.apellido_paterno.toUpperCase();


                    $("#txtFolio").text(element.CITA_FOLIO);
                    $("#txtHora").text(hr);
                    $("#txtFecha").text(fecha);
                    $("#txtSolicitante").text(solici);
                    console.log("entro", element);
                }

            });

            $("#infoCita").modal("show"); */
        }

        function formatAMPM(hora) {
            let array = hora.split(':');
            var ampm = array[0] >= 12 ? 'pm' : 'am';
            array[0] = array[0] % 12;
            array[0] = array[0] < 10 ? '0' + array[0] : array[0];
            array[0] = array[0] == '00' ? '12' : array[0];

            return array[0] + ':' + array[1] + ' ' + ampm;
        }
    </script>

    <script>
        //Funciones para el formulario lateral
        $('#btnAgendarCita').click(function () {
            alert($('input[name="radio"]:checked', '#horariosContainer').val());
            console.log($('input[name="radio"]:checked', '#horariosContainer').val());
        });

        $("#formTramite").change(function() {
            let tramiteId = $("#formTramite").val();
            $('#modalLoading').modal('show');

            $.ajax({
                url: "/gestores/detalleTramite/" + tramiteId,
                type: "GET",
                success: function(data) {
                    let oficinas    = data.data.oficinas;
                    let html        = '<option value="0" selected>Seleccionar edificio</option>';

                    oficinas.forEach(element => {
                        html += '<option value="'+ element.iId +'">' + element.Name + '</option>';
                    });

                    $("#formEdificio").html(html);
                    $('#modalLoading').modal('hide');
                },
                error: function(data) {
                    console.log(data);
                    $('#modalLoading').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'se presento el siguiente error: ' + data
                    });
                }
            });
        });

        $('#formFiltrar').click(function () {
            cargarEventos();
        });
    </script>

    <style>
        .leyendaDerecha {
            font-size: 11px;
            margin-top: 6px;
            margin-bottom: 10px;
        }

        #infoCita .modal-dialog {
            -webkit-transform: translate(0,-50%);
            -o-transform: translate(0,-50%);
            transform: translate(0,-50%);
            top: 50%;
            margin: 0 auto;
        }
        .titulo{
            color: black;
            font-size: 16px;
            font-weight: bold;
        }
        .respuesta{
            font-size: 16px;
        }
    </style>
@endsection
