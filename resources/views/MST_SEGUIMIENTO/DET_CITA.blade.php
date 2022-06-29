@extends('layout.Layout')
@section('body')
<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12" style="text-align: left;">
                    <h2 class="titulo">{{$tramite['nombre']}}</h2>
                    <h6 class="text-warning">{{$tramite['responsable']}}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: left;">
                    <h6><strong>Folio: </strong>ASX-08648</h6>
                    <h6><strong>Fecha de actualización: </strong>20/09/2020</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-sm-12 col-md-2">
                    <div id="datepicker" data-date="12/03/2012" style="display: flex; justify-content: flex-end;"></div>
                    <input type="hidden" id="my_hidden_input">
                </div>
                <div class="col-sm-12 col-md-8">
                    <div id='calendar'></div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
    <br>
</div>
<br />
<!-- Add Cita -->
<div class="modal fade" id="addCitaModal" tabindex="-1" role="dialog" aria-labelledby="addCitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCitaLabel">Crear Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtNombre" style="font-weight: bold;">Nombre del trámite</label>
                            <label id="txtNombre" style="font-size: 1rem;">Expedición de licencia de conducir para chofer particular (renovación)</label>
                        </div>
                        <div class="form-group">
                            <label for="cmbEdificio" style="font-weight: bold;">Edificio</label>
                            <label id="cmbEdificio" style="font-size: 1rem;">Fiscalía General del Estado de Chihuahua</label>
                        </div>
                        <div class="form-group">
                            <label for="dteFecha" style="font-weight: bold;">Fecha</label>
                            <input type="date" value="12/12/2020" class="form-control" name="dteFecha" id="dteFecha">
                        </div>
                        <div class="form-group" style="font-weight: bold;">
                            <label for="tmeHora">Horario</label>
                            <input type="time" class="form-control" name="tmeHora" id="tmeHora">
                        </div>
                        <div class="form-group">
                            <label for="txtDomicilio" style="font-weight: bold;">Domicilio</label><br>
                            <label id="txtDomicilio" style="font-size: 1rem;">Calle Sansorez 17</label>
                        </div>
                        <div class="form-group">
                            <label for="txtMunicipio" style="font-weight: bold;">Municipio</label><br>
                            <label id="txtMunicipio" style="font-size: 1rem;">Dzemul, Yucatán México</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="mapaEdificio" style="width: 100%; height:300px;">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Agregar Cita</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<style>
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }

    .titleCard {
        text-align: left;
        background-color: transparent;
        border-bottom: none;
        font-weight: bold;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }

    .cardItemNotification {
        padding-top: .5rem;
        margin-left: 1rem;
        border: 1px solid #393939;
        background-color: #d3edf9;
        margin-right: 1rem;
        padding-bottom: .5rem;
    }

    .cardNotification {
        width: 100% !important;
        border: none;
        border-top: solid #393939;
        border-radius: initial;
    }

    .btnCard {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#datepicker').datepicker({
            language: 'es'
        }).on('changeMonth', function(e) {

            console.log('Siguiente Mes');
            console.log(e);
            console.log($('#calendar'));

            // $('#calendar').fullCalendar('next');


        });

        // $('#datepicker').datepicker()
        //     .on('changeMonth', function(e) {
        //         alert('mamam');
        //     });


        // $('#datepicker').on('changeDate', function() {
        //     $('#my_hidden_input').val(
        //         $('#datepicker').datepicker('getFormattedDate')
        //     );
        // });
    });


    //Cargar mapa y ubicacion de oficina
    var map = null;
    setTimeout(function() {

        map = new google.maps.Map(document.getElementById('mapaEdificio'), {
            center: {
                lat: -34.5862088,
                lng: -58.415677500000015
            },
            zoom: 15,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER,
            },
            fullscreenControlOptions: {
                position: google.maps.ControlPosition.BOTTOM_RIGHT,
            },
        });

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(-34.5862088, -58.415677500000015),
            map: map,
            title: 'Ubicación'
        });
    }, 1000);


    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                right: 'prev,next',
                center: 'title',
                left: 'today,dayGridMonth'
                // right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'es',
            // initialDate: 'today',
            navLinks: false, // can click day/week names to navigate views
            selectable: false,
            selectMirror: true,
            dateClick: function(arg) {

                console.log("Click day");
                console.log(arg);


                $('#dteFecha').val(arg.dateStr);
                $('#addCitaModal').modal('show');
                return;

                var title = prompt('Event Title:');
                if (title) {
                    calendar.addEvent({
                        title: title,
                        start: arg.start,
                        end: arg.end,
                        allDay: arg.allDay
                    })
                }
                calendar.unselect()
            },
            eventClick: function(arg) {
                if (confirm('Are you sure you want to delete this event?')) {
                    arg.event.remove()
                }
            },
            editable: true,
            dayMaxEvents: true, // allow "more" link when too many events
            events: []
        });

        calendar.render();
    });
</script>
@endsection
