@extends('layout.Layout')

@section('body')

<!-- <%-- Contenido individual --%> -->
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2>Detalle usuario</h2>
            {{-- @if(Auth::user() != null)
                {{Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE}}
            @endif --}}
        </div>
    </div>
    <div class="card">
        <div class="card-body text-body">
            <div class="listError"></div>
            <div class="MensajeSuccess"></div>
            <form id="frmForm" name="frmForm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa fa-user icon-user"></i>
                            </div>
                            <div class="col-md-11">
                                <label class="font-weight-bold">Usuario: </label> <label>{{$Obj->USUA_CUSUARIO}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-11">
                                <label class="font-weight-bold">Nombre: </label> <label>{{$Obj->USUA_CNOMBRES}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-11">
                                <label class="font-weight-bold">Primero apellido: </label> <label>{{$Obj->USUA_CPRIMER_APELLIDO}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-11">
                                <label class="font-weight-bold">Segundo apellido: </label> <label>{{$Obj->USUA_CSEGUNDO_APELLIDO}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa fa-phone icon-phone"></i>
                            </div>
                            <div class="col-md-11">
                                <label class="font-weight-bold">Teléfono: </label> <label>{{$Obj->USUA_NTELEFONO}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            <i class="fa fa-envelope"></i>
                            </div>
                            <div class="col-md-11">
                                <label class="font-weight-bold">Correo electrónico: </label> <label>{{$Obj->USUA_CCORREO_ELECTRONICO}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa fa-users icon-users"></i>
                            </div>
                            <div class="col-md-11">
                                <label class="font-weight-bold">Rol: </label> <label>{{$Obj->ROL_CNOMBRE}}</label>
                            </div>
                        </div>
                        <div class="row">&nbsp;&nbsp;</div>
                        <div class="row">&nbsp;&nbsp;</div>
                        <div class="row">&nbsp;&nbsp;</div>
                        <div class="row">&nbsp;&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa fa-comment icon-comment"></i>
                            </div>
                            <div class="col-md-11">
                                <label class="font-weight-bold">Extensión: </label> <label>{{$Obj->USUA_NTELEFONO}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="content-info">
                            <div class="row">
                                <div class="col-md-10 text-right">
                                   <label>Dependencia o entidad</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="font-weight-bold" id="txtCantidadDependencia"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-right">
                                   <label>Unidades administrativas</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="font-weight-bold" id="txtCantidadUnidad"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-right">
                                   <label>Trámites</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="font-weight-bold" id="txtCantidadTramite"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-right">
                                   <label>Edificios</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="font-weight-bold" id="txtCantidadEdificio"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="area_pertenece"></div>
                        <div class="area_acceso"></div>
                    </div>
                </div>
                <br/>
            </form>
        </div>
    </div>
    <br>
    
    <div class="row justify-content-between">
        <div class="col-md-12 text-right">
            {{-- <button class="btn btn-primary btn-md btnSubmit" id="btnSubmit" onclick="TRAM_AJX_CONFIRMAR();">Guardar</button> --}}
            <a class="btn btn-danger btn-md" href="{{ url('servidorespublicos') }}">Volver</a>
        </div>
    </div>
</div>
<br />
@endsection
@section('scripts')

<script>
    var lstEdificios = [];
    var lstUnidad_Administrativa = [];
    var lstDependencias = [];
    var lstTramites = [];
    var lstEdificios_Acceso = [];
    var lstUnidad_Administrativa_Acceso = [];
    var lstDependencias_Acceso = [];
    var lstTramites_Acceso = [];
    var StrRol = '{{ Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE }}';
    
    var _cantidad_dependencias  = <?php echo json_encode($Obj->num_dependen); ?>;
    var _cantidad_unidades      = <?php echo json_encode($Obj->num_unidades); ?>;
    var _cantidad_tramites      = <?php echo json_encode($Obj->num_tramites); ?>;
    var _cantidad_edificios     = <?php echo json_encode($Obj->num_edificios); ?>;

    var _lstDependencias        = <?php echo json_encode($Obj->lstDependenciaPertenece); ?>;
    var _lstUnidad_Administrativa = <?php echo json_encode($Obj->lstUnidadPertence); ?>;
    var _lstTramites            = <?php echo json_encode($Obj->lstTramitePertence); ?>;
    var _lstEdificios           = <?php echo json_encode($Obj->lstEdificioPertence); ?>;

    var _lstDependencias_Acceso = <?php echo json_encode($Obj->lstDependenciaAcceso); ?>;
    var _lstUnidad_Administrativa_Acceso = <?php echo json_encode($Obj->lstUnidadAcceso); ?>;
    var _lstTramites_Acceso     = <?php echo json_encode($Obj->lstTramiteAcceso); ?>;
    var _lstEdificios_Acceso    = <?php echo json_encode($Obj->lstEdificioAcceso); ?>;

    for(var a = 0; a < _lstDependencias.length; a++){
        var _html_unidad_pertence = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
        for(var b = 0; b < _lstUnidad_Administrativa.length; b++){
            if(_lstUnidad_Administrativa[b].ID_DEPENDENCIA == _lstDependencias[a].DEPUP_NIDDEPENCIA){
                var html_tramites_pertence = '';
                for(var c = 0; c < _lstTramites.length; c++){
                    if(_lstTramites[c].ID_UNIDAD == _lstUnidad_Administrativa[b].UNIDUP_NIDUNIDAD){
                        html_tramites_pertence += '<div><label style="color: #a2a2a2; font-size: 14px;">' + _lstTramites[c].TRAMUP_CNOMBRE + '</label></div><br/>';
                    }
                }

                var html_edificio_pertence = '';
                for(var c = 0; c < _lstEdificios.length; c++){
                    html_edificio_pertence += '<div><label style="color: #29B6F6; font-size: 14px;">' + _lstEdificios[c].EDIFUP_CNOMBRE + '</label></div><br/>';
                }
                _html_unidad_pertence += '<div class="panel panel-default">'
                                    + '<div class="panel-heading" role="tab" id="headingOne" style="padding-left: 100px !important;">'
                                    +    '<h4 class="panel-title">'
                                    +       '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#tab'+_lstUnidad_Administrativa[b].UNIDUP_NIDUNIDAD+'" aria-expanded="true" aria-controls="tab'+_lstUnidad_Administrativa[b].UNIDUP_NIDUNIDAD+'">'
                                    +           '<i class="more-less fa fa-angle-down float-right"></i>'
                                    +           '<h4 class="font-weight-bold">'+_lstUnidad_Administrativa[b].UNIDUP_CNOMBRE+'</h4>'
                                    +        '</a>'
                                    +    '</h4>'
                                    + '</div>'
                                    + '<div id="tab'+_lstUnidad_Administrativa[b].UNIDUP_NIDUNIDAD+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">'
                                    +   '<div class="panel-body">'
                                    +         '<div class="row"><div class="col-md-6">'+html_tramites_pertence+'</div><div class="col-md-6">'+html_edificio_pertence+'</div></div>'
                                    +    '</div>'
                                    + '</div>'
                                    + '</div>';
            }
        }
        _html_unidad_pertence += '</div>';
        $(".area_pertenece").append('<span><h5 class="text-info">Área a la que pertenece</h5></span> <span><h5 class="font-weight-bold" style="color:#8f8f8f;">&nbsp;&nbsp;'+_lstDependencias[a].DEPUP_CNOMBRE+'</h5></span><br>' + _html_unidad_pertence);
    }

    for(var a = 0; a < _lstDependencias_Acceso.length; a++){
        var _html_unidad_acceso = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
        for(var b = 0; b < _lstUnidad_Administrativa_Acceso.length; b++){
            if(_lstUnidad_Administrativa_Acceso[b].ID_DEPENDENCIA == _lstDependencias_Acceso[a].DEPUA_NIDDEPENCIA){
                var html_tramites_acceso = '';

               /*  for(var c = 0; c < _lstTramites_Acceso.length; c++){
                    if(_lstTramites_Acceso[c].ID_UNIDAD == _lstUnidad_Administrativa_Acceso[b].UNIDUA_NIDUNIDAD){
                        html_tramites_acceso += '<div><label style="color: #a2a2a2;">' + _lstTramites_Acceso[c].TRAMUA_CNOMBRE + '</label></div><br/>';
                    }
                } */

                var html_edificio_acceso = '';

                for(var c = 0; c < _lstEdificios_Acceso.length; c++){
                    if( _lstEdificios_Acceso[c].unidad_id == _lstUnidad_Administrativa_Acceso[b].UNIDUA_NIDUNIDAD){
                        html_edificio_acceso += '<div><label style="color: #29B6F6; font-size: 14px;">' + _lstEdificios_Acceso[c].EDIFUP_CNOMBRE + '</label></div><br/>';
                    }
                }
                let acordeon = "";

                if(html_edificio_acceso != ""){
                    acordeon = _lstUnidad_Administrativa_Acceso[b].UNIDUA_NIDUNIDAD;
                }

                _html_unidad_acceso += '<div class="panel panel-default">'
                                    + '<div class="panel-heading" role="tab" id="headingOne" style="padding-left: 100px !important;">'
                                    +    '<h4 class="panel-title">'
                                    +       '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#tab'+acordeon+'" aria-expanded="true" aria-controls="tab'+_lstUnidad_Administrativa_Acceso[b].UNIDUA_NIDUNIDAD+'">';
                                    
                                    if(html_edificio_acceso != ""){
                                        _html_unidad_acceso +='<i class="more-less fa fa-angle-down float-right"></i>';
                                    }
                                    
                                    _html_unidad_acceso +='<h4 class="font-weight-bold">'+_lstUnidad_Administrativa_Acceso[b].UNIDUA_CNOMBRE+'</h4>'
                                    +        '</a>'
                                    +    '</h4>'
                                    + '</div>'
                                    + '<div id="tab'+_lstUnidad_Administrativa_Acceso[b].UNIDUA_NIDUNIDAD+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">'
                                    +   '<div class="panel-body">'
                                    +         '<div class="row"><div class="col-md-6">'+html_tramites_acceso+'</div> <div class="col-md-6">'+html_edificio_acceso+'</div></div>'
                                    +    '</div>'
                                    + '</div>'
                                    + '</div>';
            }
        }
        _html_unidad_acceso += '</div>';
        $(".area_acceso").append('<span><h5 class="text-info">Área a la que puede tener acceso</h5></span> <span><h5 class="font-weight-bold" style="color:#8f8f8f;">&nbsp;&nbsp;'+_lstDependencias_Acceso[a].DEPUA_CNOMBRE+'</h5></span><br>' + _html_unidad_acceso);

        $("#txtCantidadDependencia").html(_cantidad_dependencias);
        $("#txtCantidadUnidad").html(_cantidad_unidades);
        $("#txtCantidadTramite").html(_cantidad_tramites);
        $("#txtCantidadEdificio").html(_cantidad_edificios);
    }
    
    function toggleIcon(e) {
        $(e.target)
            .prev(".panel-heading")
            .find(".more-less")
            .toggleClass("fa-angle-down fa-angle-up");
    }
    $(".panel-group").on("hidden.bs.collapse", toggleIcon);
    $(".panel-group").on("shown.bs.collapse", toggleIcon);
    
</script>

<style>
    .panel-group{
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        margin: 5px 0px 5px 0px;
        padding: 25px;
    }
    .panel-body{
        padding: 10px 100px;
    }
    .text-info {
        color: dodgerblue !important;
    }
    .btnExport {
        background-color: #ffa000;
        border-color: #ffa000;
        color: #ffffff;
        margin-right: 4px;
    }

    .btnExport:hover {
        color: #ffffff;
    }
    .dropdown-menu{
        width: 100% !important;
    }
    .content-info {
        background: #f1f1f1;
        padding: 10px;
        border-radius: 4px;
    }
</style>

@endsection