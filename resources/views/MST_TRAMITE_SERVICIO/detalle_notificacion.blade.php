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
                    <h6><strong>Folio: </strong>{{$tramite['folio']}}</h6>
                    <h6><strong>Fecha y hora: </strong>{{$tramite['notificacion']['HNOTI_DFECHACREACION']}}</h6>
                    <h6><strong>Estatus: </strong>{{$tramite['notificacion']['HNOTI_NTIPO'] == 1 ? 'Notificación al solicitante' : ''}}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br>
            <h6 class="text-primary">
                {{$tramite['notificacion']['HNOTI_NTIPO'] == 1 ? 'Para dar seguimiento a las observaciones, por favor de clic en el botón "Iniciar atención del trámite" y siga las instrucciones' : 'Para dar seguimiento, por favor de clic en el botón "Iniciar atención del trámite" y siga las instrucciones'}}
            </h6>
            <br>
            <br>
        </div>
        <div class="col-md-12">
            <div class="card text-left cardNotification">
                {{-- <div class="card-header titleCard">
                    <h6 style="font-weight: bold;">29/06/2018 - 17:56 hrs | Se requiere programar cita</h6>
                </div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {!!$tramite['notificacion']['HNOTI_CMENSAJE']!!}
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="background-color: transparent; border-top: solid rgb(57 57 57);">
                    {{-- <a href="{{route('consultar_ventanilla', 1)}}" class="btn btn-primary">Iniciar atención de trámite Ventanilla </a>
                    <a href="{{route('consultar_cita', 1)}}" class="btn btn-primary">Iniciar atención de trámite Cita</a> --}}
                    <a href="javascript:void()" class="btn btn-primary" onclick="TRAM_FN_ANTENCION({{$tramite['notificacion']['HNOTI_NIDNOTIFICACION']}})">Iniciar atención del trámite</a>
                    <a href="javascript:void()" class="btn" style="background-color: #E91E63; color:#ffffff" onclick="goBack();">Cerrar </a>
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
    var id = "{{$tramite['idusuariotramite']}}";
    function goBack() {
        $(location).attr('href','/tramite_servicio/seguimiento_tramite/' + id);
    }
    
    function TRAM_FN_ANTENCION(noti){
        $(location).attr('href','/tramite_servicio/atencion_notificacion_seguimiento/' + id + "/" + noti);
    }
</script>
@endsection
