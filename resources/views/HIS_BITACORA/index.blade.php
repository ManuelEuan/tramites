@extends('layout.Layout')

@section('body')
<style>
    .btn-secondary{
        background-color: #ffa000;
        height: 25px;
        align-items: center;
        vertical-align: center;
        font-size: x-small;
        margin-bottom: 10px;
    }
    div.dt-buttons {
        float: left;
    }
</style>
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-md-8">
                <h2>Bitácora de movimientos</h2>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body text-body">
                <div class="row">
                    <div class="col-12">
                        <table id="example" class="table table-bordered" style="width: 100%">
                            <thead class="bg-gob">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Tipo de movimiento</th>
                                    <th>Usuario</th>
                                    @if($ObjAuth->TRAM_CAT_ROL->ROL_CCLAVE == 'ADM')
                                    <th>Tabla</th>
                                    @endif
                                   
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="frmForm" name="form" class="form-horizontal needs-validation" novalidate>
                    <input type="hidden" name="IntId" id="IntId">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="StrNommbre" name="StrNommbre" placeholder="Nombre" value="" maxlength="50" required>
                                <div class="invalid-feedback">
                                    requerido
                                </div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="StrDescripcion" name="StrDescripcion" placeholder="Descripción" value="" maxlength="50">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Icono</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="StrIcono" name="StrIcono" placeholder="Icono" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ruta</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="StrRuta" name="StrRuta" placeholder="Ruta" value="" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Grupo</label>
                            <div class="col-sm-12">
                                <div id="cmbCategoriaPermiso">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!--<div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Guardar
                        </button>
                    </div>-->
                    <div class="row justify-content-between">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary" id="BtnGuardar" onclick="TRAM_AJX_GUARDAR();">Guardar</button>
                            <button class="btn btn-primary" id="BtnModificar" onclick="TRAM_AJX_MODIFICAR();">Modificar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.min.js"></script>
<script>
    var table = null;
    var SITEURL = '{{URL::to('')}}';
    $(document).ready(function () {

        var rolCat = '{{$ObjAuth->TRAM_CAT_ROL->ROL_CCLAVE}}';


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function TRAM_AJX_CONSULTARPERMISO(){

            if(rolCat == "ADM"){
                table = $('#example').DataTable({
                "language": {
                    url: "assets/template/plugins/DataTables/language/Spanish.json",
                    "search":			"Filtrar resultados:",
                },
                "ajax": "/bitacora/consultar",
                "columns": [
                    { "data": "BITA_FECHAMOVIMIENTO" },
                    { "data": "BITA_HORAMOVIMIENTO" },
                    { "data": "BITA_CMOVIMIENTO" },
                    { "data": "BITA_USUARIO"},
                    { "data": "BITA_CTABLA" }
                ],
                searching: true,
                ordering: true,
                paging: true,
                bLengthChange: true,
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                lengthMenu: [[10, 25, 100, -1], [10, 25, 100, "Todos"]],
                dom: 'lBfrtip',
                buttons: [
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
            }else{
                table = $('#example').DataTable({
                "language": {
                    url: "assets/template/plugins/DataTables/language/Spanish.json",
                    "search":			"Filtrar resultados:",
                },
                "ajax": "/bitacora/consultar",
                "columns": [
                    { "data": "BITA_FECHAMOVIMIENTO" },
                    { "data": "BITA_HORAMOVIMIENTO" },
                    { "data": "BITA_CMOVIMIENTO" },
                    { "data": "BITA_USUARIO"}
                ],
                searching: true,
                ordering: true,
                paging: true,
                bLengthChange: true,
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                lengthMenu: [[10, 25, 100, -1], [10, 25, 100, "Todos"]],
                dom: 'lBfrtip',
                buttons: [
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
            }

          

          


        }
        TRAM_AJX_CONSULTARPERMISO();    
    });



</script>
@endsection