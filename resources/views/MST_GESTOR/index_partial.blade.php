<section>
    @if(count($data_tramite) > 0)
        @foreach ($data_tramite as $data)
            <div class="card text-left" style="margin-bottom: 2rem;">
                <div class="card-header text-primary titleCard">
                    <div class="row">
                        <div class="col-10">
                            {{$data->TRAM_CNOMBRE}} <span class="badge badge-warning">{{$data->UNAD_CNOMBRE}}</span>
                        </div>
                        <div class="col-2">
                            @if($data->TRAM_NIDTRAMITE_CONFIG > 0)
                                <div style="float: right; color:#212529;">
                                    <a href="{{route('detalle_configuracion_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => $data->TRAM_NIDTRAMITE_CONFIG] )}}" title="Ver Configuración"><i class="fas fa-eye sizeBtnIcon"></i></a>
                                    <a href="{{route('gestor_configurar_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => $data->TRAM_NIDTRAMITE_CONFIG]) }}" title="Configurar Trámite"><i class="fas fa-edit sizeBtnIcon"></i></a>

                                    @if(Gate::allows('isAdministradorOrEnlace'))
                                        @if($data->TRAM_NIMPLEMENTADO > 0)
                                            <a href="javascript:TRAM_FN_CAMBIAR_ESTATUS({{$data->TRAM_NIDTRAMITE_CONFIG}}, 0)"><i class="fas fa-toggle-on sizeBtnIcon" style="color:#28a745;"></i></a>
                                        @elseif($data->TRAM_NIMPLEMENTADO == 0)
                                            <a href="javascript:TRAM_FN_CAMBIAR_ESTATUS({{$data->TRAM_NIDTRAMITE_CONFIG}}, 1)"><i class="fas fa-toggle-off sizeBtnIcon"></i></a>
                                        @endif
                                    @endif

                                    @if(!(Gate::allows('isAdministradorOrEnlace')))
                                        @if($data->TRAM_NIMPLEMENTADO > 0)
                                            <a style="pointer-events:none" title="Implementado" href="javascript:void();"><i class="fas fa-circle sizeBtnIcon" style="color:#28a745;"></i></a>
                                        @elseif($data->TRAM_NIMPLEMENTADO == 0)
                                            <a style="pointer-events:none" title="No implementado" href="javascript:void();"><i class="fas fa-circle sizeBtnIcon" style="color: #737373 !important;"></i></a>
                                        @endif
                                    @endif

                                    @if(Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE == 'ADM' )
                                        <div style="position: absolute;">
                                            <select style="margin-top: 10px;width: 100%;" id="{{ $data->TRAM_NIDTRAMITE_CONFIG }}">
                                            @if($data->TRAM_CTIPO_PERSONA == 0)<option value="0" selected>Ambos</option>@else<option value="0">Ambos</option>@endif
                                            @if($data->TRAM_CTIPO_PERSONA == 1)<option value="1" selected>Física</option>@else<option value="1">Física</option>@endif
                                            @if($data->TRAM_CTIPO_PERSONA == 2)<option value="2" selected>Moral</option>@else<option value="2">Moral</option>@endif
                                            </select><br>
                                            <button class="btn-success" style="width: 100%;margin-top: 10px;" onclick="asignarPersona({{ $data->TRAM_NIDTRAMITE_CONFIG }})">Guardar</button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h6 class="card-text" style="color: #212529;">
                                {{$data->TRAM_CDESCRIPCION}}
                            </h6>
                        </div>
                        <div class="col-2">
                            @if($data->TRAM_NIDTRAMITE_CONFIG == null)
                                <div style="float: right;">
                                    {{-- <span onclick="validaTramite({{$data->TRAM_NIDTRAMITE}}, 0, 'configurar');" class="btn btn-primary" style="width:172px; float:right; margin-bottom:7px;">Configurar trámite MAnuel</span> --}}
                                    <a href="{{route('gestor_configurar_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => 0])}}" class="btn btn-primary" style="width:172px; float:right; margin-bottom:7px;">Configurar trámite</a>
                                    <a href="{{route('gestor_consultar_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => 0])}}" class="btn btn-primary" style="width:172px; float:right;">Ver trámite</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($data->TRAM_NIDTRAMITE_CONFIG > 0)
                    <div class="card-footer text-muted" style="background-color: transparent; border-top: none; border-bottom: none;">
                        <span class="text-left" style="margin-right: 30px;">Creado: {{date("d/m/Y", strtotime($data->TRAM_DFECHACREACION))}}</span>
                        <span class="text-left">Ultima Modificación: {{date("d/m/Y", strtotime($data->TRAM_DFECHAACTUALIZACION))}}</span>

                        <div style="float: right;">
                            <a href="{{route('gestor_consultar_tramite', ['tramiteID' => $data->TRAM_NIDTRAMITE, 'tramiteIDConfig' => $data->TRAM_NIDTRAMITE_CONFIG])}}" class="btn btn-primary" style="float: right;">Ver trámite</a>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div>
            <h6 style="text-align: center;">No se encontraron resultados.</h6>
        </div>
        <br>
    @endif
    <div class="paginate" style="float: right;">
        {{ $data_tramite->links() }}
    </div>
    <div>
        <strong>Mostrando registros del {{($data_tramite->currentpage()-1)*$data_tramite->perpage()+1}} al {{$data_tramite->currentpage()*$data_tramite->perpage()}}
            de un total de {{$data_tramite->total()}} registros</strong>
    </div>

    <script>
        /* function validaTramite(tramiteID, tramiteIDConfig, tipo= 'configurar'){
            $.ajax({
                url: "/gestores/validaTramite",
                type: "GET",
                data: {'tramiteId': tramiteID},
                success: function(data) {
                    console.log(data);

                },
                error: function(error) {
                    console.log(error);
                    
                }
            });
        } */
    </script>
</section>
