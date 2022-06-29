<section>
    @if(count($data_tramite) > 0)
    @foreach ($data_tramite as $data)
    <div class="card text-left" style="margin-bottom: 2rem;">
        <div class="card-header text-primary titleCard">
            {{$data->TRAM_CNOMBRE}} <span class="badge badge-warning">{{$data->UNAD_CNOMBRE}}</span>
        </div>
        <div class="card-body">
            <h6 class="card-text" style="color: #212529;">
                {{$data->TRAM_CDESCRIPCION}}
            </h6>
        </div>
        <div class="card-footer text-muted" style="background-color: transparent; border-top: none; border-bottom: none;">
            <span class="text-left" style="margin-right: 30px;">Creado: 07/12/2020</span>
            <span class="text-left">Ultima Modificación: 07/12/2020</span>
            <a href="{{route('detalle_tramite', ['id' => $data->TRAM_NIDTRAMITE_CONFIG])}}" class="btn btn-primary" style="float: right;">Ver trámite</a>
        </div>
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
</section>
