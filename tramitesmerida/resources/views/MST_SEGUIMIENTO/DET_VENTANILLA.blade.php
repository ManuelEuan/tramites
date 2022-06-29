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
    <div class="row">
        <div class="col-md-12">
            <br>
            <h6 class="text-primary">
                Para continuar con su trámite, es necesario que acuda a nuestras ventanillas en cualquiera de las siguientes ubicaciones:
            </h6>
            <br>
            <br>
        </div>
        <div class="col-md-12">
            <div>
                <div class="row">
                    <div class="col-md-8" style="overflow-y: auto;">

                        @for ($i=0; $i < 1; $i++)
                        <div>
                            <div class="card text-left" style="margin-bottom: 2rem;">
                                <div class="card-header titleCard">
                                    <h6 style="font-weight: bold;">Módulo de Licencias Mitla | Ciudad Juárez, Chihuahua</h6>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-text text-primary">Días de atención</h6>
                                    <label style="color: #212529;">Lunes a viernes: 8:00 a 15:00 horas.</label>
                                    <h6 class="card-text text-primary">Domicilio</h6>
                                    <label style="color: #212529;">Palacio Mitla 6 , locales 4, 5 y 6, #1151 37</label>
                                </div>
                            </div>
                        </div>

                        @endfor
                    </div>
                    <div class="col-md-4">
                        <div id="mapa" style="height: 400px;;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
<br />
@endsection
@section('scripts')
<style>
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
        //Cargar mapa y ubicacion de oficina
        setTimeout(function() {

            map = new google.maps.Map(document.getElementById('mapa'), {
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






    });
</script>
@endsection
