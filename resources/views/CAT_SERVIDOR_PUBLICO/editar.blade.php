@extends('layout.Layout')

@section('body')

<!-- <%-- Contenido individual --%> -->
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2>Editar usuario</h2>
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
                    <div class="col-md-12">
                        <h6 class="font-weight-bold">Por favor, Ingrese los datos solicitados.</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" name="txtIdUsuario" id="txtIdUsuario" value="{{$objUsuario->USUA_NIDUSUARIO}}">
                            <label for="dteFechaInicio">Usuario <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Usuario" class="form-control" name="txtUsuario" id="txtUsuario" value="{{$objUsuario->USUA_CUSUARIO}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dteFechaInicio">Rol <span class="text-danger">*</span></label>
                            <select class="combobox form-control" name="cmbRol" id="cmbRol" placeholder="Rol" disabled>
                                <option value="1" {{$objUsuario->USUA_NIDROL == "1" ? "selected" : ""}}>Administrador</option>
                                <option value="3" {{$objUsuario->USUA_NIDROL == "3" ? "selected" : ""}}>Enlace Oficial</option>
                                <option value="4" {{$objUsuario->USUA_NIDROL == "4" ? "selected" : ""}}>Admin-CT</option>
                                <option value="5" {{$objUsuario->USUA_NIDROL == "5" ? "selected" : ""}}>Servidor Público</option>
                                <option value="6" {{$objUsuario->USUA_NIDROL == "6" ? "selected" : ""}}>Consultor</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bus-txt-centro-trabajo">Correo electrónico <span class="text-danger">*</span> <span>&nbsp;&nbsp; <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtCorreo_Electronico', 1);"></i></span></label>
                            <input type="email" class="form-control" name="txtCorreo_Electronico" id="txtCorreo_Electronico" value="{{$objUsuario->USUA_CCORREO_ELECTRONICO}}" placeholder="Correo electrónico" required readonly>
                            <span id="resultadoExistCorreo" style="font-size: 12px;"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dteFechaInicio">Nombre (s) <span class="text-danger">*</span> <span>&nbsp;&nbsp; <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtNombres', 1);"></i></span></label>
                            <input type="text" placeholder="Nombre (s)" class="form-control" name="txtNombres" id="txtNombres" value="{{$objUsuario->USUA_CNOMBRES}}" required readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtNombre">Primer apellido <span class="text-danger">*</span> <span>&nbsp;&nbsp; <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtPrimer_Apellido', 1);"></i></span></label>
                            <input type="text" placeholder="Primer apellido" class="form-control" name="txtPrimer_Apellido" id="txtPrimer_Apellido" value="{{$objUsuario->USUA_CPRIMER_APELLIDO}}" required readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbDependenciaEntidad">Segundo apellido <span>&nbsp;&nbsp; <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtSegundo_Apellido', 1);"></i></span></label>
                            <input type="text" placeholder="Segundo apellido" class="form-control" name="txtSegundo_Apellido" id="txtSegundo_Apellido" value="{{$objUsuario->USUA_CSEGUNDO_APELLIDO}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dteFechaInicio">Teléfono <span>&nbsp;&nbsp; <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtTelefono', 1);"></i></span></label>
                            <input type="number" placeholder="Teléfono" class="form-control" name="txtTelefono" id="txtTelefono" value="{{$objUsuario->USUA_NTELEFONO}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dteFechaInicio">Extensión <span>&nbsp;&nbsp; <i class="fa fa-pencil-alt icon-edit" onclick="TRAM_FN_ENABLE('txtExtension', 1);"></i></span></label>
                            <input type="number" placeholder="Extensión" class="form-control" name="txtExtension" id="txtExtension" value="{{$objUsuario->USUA_NEXTENSION}}" readonly>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="font-weight-bold">Área a la que pertenece</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">Dependencia o entidad <span class="circle-sm" onclick="FN_AGREGAR_AREAS_PERTENECE(0)">+</span></p>
                        <div class="group-list">
                            <div id="list_dependencias"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">Unidad administrativa <span class="circle-sm" onclick="FN_AGREGAR_AREAS_PERTENECE(1)">+</span></p>
                        <div class="group-list">
                            <div id="list_unidad_administrativa"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">Trámites <span class="circle-sm" onclick="FN_AGREGAR_AREAS_PERTENECE(2)">+</span></p>
                        <div class="group-list">
                            <div id="list_tramites"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">Edificios <span class="circle-sm" onclick="FN_AGREGAR_AREAS_PERTENECE(3)">+</span></p>
                        <div class="group-list">
                            <div id="list_edificios"></div>
                        </div>
                    </div>
                </div>
                <br /><br />
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="font-weight-bold">Área a la que puede tener acceso</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">
                            Dependencia o entidad
                            @if(Auth::user() != null)
                            @if(Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE == "ADM")
                            <span class="circle-sm" onclick="FN_AGREGAR_AREAS_ACCESO(0)">+</span>
                        </p>
                        @endif
                        @endif
                        <div class="group-list">
                            <div id="list_dependencias_acceso"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">Unidad administrativa <span class="circle-sm" onclick="FN_AGREGAR_AREAS_ACCESO(1)">+</span></p>
                        <div class="group-list">
                            <div id="list_unidad_administrativa_acceso"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">Trámites <span class="circle-sm" onclick="FN_AGREGAR_AREAS_ACCESO(2)">+</span></p>
                        <div class="group-list">
                            <div id="list_tramites_acceso"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">Edificios <span class="circle-sm" onclick="FN_AGREGAR_AREAS_ACCESO(3)">+</span></p>
                        <div class="group-list">
                            <div id="list_edificios_acceso"></div>
                        </div>
                    </div>
                </div>
                <br />
            </form>
            <div class="row justify-content-between">
                <div class="col-md-12 text-right">
                    <button class="btn btn-primary btn-md btnSubmit" id="btnSubmit" onclick="TRAM_AJX_CONFIRMAR();">Guardar</button>
                    <a class="btn btn-danger btn-md" href="{{ url('servidorespublicos') }}">Cerrar</a>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
<br />
<!-- areas pertence -->
<div class="modal fade" id="ModalAreasPertence" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ModalAreasPertence" aria-hidden="true">
    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-radius-6">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <label style="font-size: 1rem; font-weight: bold;"><span id="lblSelect"></span></label>
                        <div id="Dependencias"></div>
                        <div id="UnidadAdministrativa"></div>
                        <div id="Tramites"></div>
                        <div id="Edificios"></div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="row align-items-center" id="AccionDependencias">
                            <div class="col-md-12 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_PERTENECE(0);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            {{-- <div class="col-md-6  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodos" type="checkbox" id="chkTodos" onclick="FN_SELECIONAR_TODOS_PERTECE(0)">
                                        <label class="form-check-label" for="chkTodos">
                                            Seleccionar todos
                                        </label>
                                  </div>
                            </div> --}}
                        </div>
                        <div class="row align-items-center" id="AccionUnidadAdministrativa">
                            <div class="col-md-12 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_PERTENECE(1);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            {{-- <div class="col-md-6  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodos" type="checkbox" id="chkTodos" onclick="FN_SELECIONAR_TODOS_PERTECE(1)">
                                        <label class="form-check-label" for="chkTodos">
                                            Seleccionar todos
                                        </label>
                                  </div>
                            </div> --}}
                        </div>
                        <div class="row align-items-center" id="AccionTramites">
                            <div class="col-md-8 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_PERTENECE(2);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-3  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodos" type="checkbox" id="chkTodos" onclick="FN_SELECIONAR_TODOS_PERTECE(2)">
                                    <label class="form-check-label" for="chkTodos">
                                        Seleccionar todos
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="AccionEdificio">
                            <div class="col-md-8 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_PERTENECE(3);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-3  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodos" type="checkbox" id="chkTodos" onclick="FN_SELECIONAR_TODOS_PERTECE(3)">
                                    <label class="form-check-label" for="chkTodos">
                                        Seleccionar todos
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-between">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAreasAcceso" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ModalAreasAcceso" aria-hidden="true">
    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-radius-6">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <label style="font-size: 1rem; font-weight: bold;"><span id="lblSelectAcceso"></span></label>
                        <div id="DependenciasAcceso"></div>
                        <div id="UnidadAdministrativaAcceso"></div>
                        <div id="TramitesAcceso"></div>
                        <div id="EdificiosAcceso"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="row align-items-center" id="AccionDependenciasAcceso">
                            <div class="col-md-8 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_ACCESO(0);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-3  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodosAcceso" type="checkbox" id="chkTodosAcceso" onclick="FN_SELECIONAR_TODOS_ACCESO(0)">
                                    <label class="form-check-label" for="chkTodosAcceso">
                                        Seleccionar todos
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="AccionUnidadAdministrativaAcceso">
                            <div class="col-md-8 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_ACCESO(1);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-3  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodosAcceso" type="checkbox" id="chkTodosAcceso" onclick="FN_SELECIONAR_TODOS_ACCESO(1)">
                                    <label class="form-check-label" for="chkTodosAcceso">
                                        Seleccionar todos
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="AccionTramitesAcceso">
                            <div class="col-md-8 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_ACCESO(2);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-3  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodosAcceso" type="checkbox" id="chkTodosAcceso" onclick="FN_SELECIONAR_TODOS_ACCESO(2)">
                                    <label class="form-check-label" for="chkTodosAcceso">
                                        Seleccionar todos
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="AccionEdificioAcceso">
                            <div class="col-md-8 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_ACCESO(3);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-3  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodosAcceso" type="checkbox" id="chkTodosAcceso" onclick="FN_SELECIONAR_TODOS_ACCESO(3)">
                                    <label class="form-check-label" for="chkTodosAcceso">
                                        Seleccionar todos
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-between">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loading_" class="loadingFrame" class="text-center" style="display: none !important;">
    <div class="inner">
        <div class="spinner-grow text-secondary" role="status"></div>
        <p id="txt_loading" style="color: #393939 !important;">Cargando...</p>
    </div>
</div>
@endsection
@section('scripts')

<script>
    var StrRol          = '{{ Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE }}';
    var lstEdificios    = [];
    var lstDependencias = [];
    var lstTramites     = [];
    var _lstDependencias        = [];
    var lstEdificios_Acceso     = [];
    var lstDependencias_Acceso  = [];
    var lstTramites_Acceso      = [];
    var lstUnidad_Administrativa        = [];
    var lstUnidad_Administrativa_Acceso = [];


    _lstDependencias            = <?php echo json_encode($objUsuario->lstDependenciaPertenece) ?>;
    _lstUnidad_Administrativa   = <?php echo json_encode($objUsuario->lstUnidadPertence) ?>;
    _lstTramites                = <?php echo json_encode($objUsuario->lstTramitePertence) ?>;
    _lstEdificios               = <?php echo json_encode($objUsuario->lstEdificioPertence) ?>;
    _lstDependencias_Acceso     = <?php echo json_encode($objUsuario->lstDependenciaAcceso) ?>;
    _lstTramites_Acceso         = <?php echo json_encode($objUsuario->lstTramiteAcceso) ?>;
    _lstEdificios_Acceso        = <?php echo json_encode($objUsuario->lstEdificioAcceso) ?>;
    _lstUnidad_Administrativa_Acceso = <?php echo json_encode($objUsuario->lstUnidadAcceso) ?>;


    $(document).ajaxStart(function() {
        $('#loading_').show();
    });

    $(document).ajaxStop(function() {
        $('#loading_').hide();
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#txtCorreo_Electronico").blur(function() {
            $(this).attr('readonly', true);
        });
        $("#txtNombres").blur(function() {
            $(this).attr('readonly', true);
        });
        $("#txtPrimer_Apellido").blur(function() {
            $(this).attr('readonly', true);
        });

        $("#txtSegundo_Apellido").blur(function() {
            $(this).attr('readonly', true);
        });
        $("#txtTelefono").blur(function() {
            $(this).attr('readonly', true);
        });
        $("#txtExtension").blur(function() {
            $(this).attr('readonly', true);
        });

        $.validator.addMethod("passwordcheck", function(value) {
            return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value) // has a special character
        }, "La contraseña debe contener de 8 a 15 carácteres alfanuméricos (a-z A-Z), contener mínimo un dígito (0-9) y un carácter especial (_-=).");

        $.validator.addMethod('passwordMatch', function(value, element) {
            var password = $("#txtContrasenia").val();
            var confirmPassword = $("#txtConfirmarContrasenia").val();
            if (password != confirmPassword) {
                return false;
            } else {
                return true;
            }
        });

        //Consultamos dependencias, unidades, tramite y edificios que pertenece el usuario
        function TRAM_AJX_EDIFICIOS(id) {
            edificio = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getEdificios",
                type: "get",
                data: {"tipo":"multiple","unidad_id": id.toString() ?? '0' }

            });

            edificio.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbEdificios" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    let select = '';
                    _lstEdificios.forEach(element => {
                        if(element.EDIFUP_NIDEDIFICIO == value.iId){
                            select      =   'selected';
                            let option  =   `<div class="group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <span class="text-dark"> ${ value.Name } </span>
                                                    </div>
                                                </div>
                                            </div`;

                            $('#list_edificios').append(option);
                            lstEdificios.push(value.Id);
                        }
                    });
                    _lstEdificios = [];
                    html += `<option ${select} value="${ value.Id }"> ${ value.Name } </option>`;
                });
                html += '</select>';

                $("#Edificios").html(html);
                $('#cmbEdificios').selectpicker({
                    noneSelectedText: 'Búsqueda de edificios',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbEdificios').on('change', function(e) {
                    var selected = $('#cmbEdificios').val();
                    lstEdificios = [];
                    $('#list_edificios').html('');
                    $.each(selected, function(key, value) {
                        lstEdificios.push(value);
                        var text = $("#cmbEdificios option[value='" + value + "']")[0].innerText;
                        $('#list_edificios').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                });
            });
        }

        function TRAM_AJX_TRAMITES(id) {
            tramite = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getTramites",
                type: "get",
                data: {"tipo":"multiple","unidad_id": id.toString() ?? '0' }
            });

            tramite.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbTramites" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    let select = '';
                    _lstTramites.forEach(element => {
                        if(element.TRAMUP_NIDTRAMITE == value.iId){
                            select      =   'selected';
                            let option  =   `<div class="group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <span class="text-dark"> ${ value.Key } </span>
                                                    </div>
                                                </div>
                                            </div`;

                            $('#list_tramites').append(option);
                            lstTramites.push(value.Id);
                        }
                    });
                    _lstUnidad_Administrativa = [];
                    html += `<option ${select} value="${ value.Id }"> ${ value.Key } </option>`;
                });
                html += '</select>';
                _lstTramites = [];
                
                $("#Tramites").html(html);
                $('#cmbTramites').selectpicker({
                    noneSelectedText: 'Búsqueda de Trámites',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbTramites').on('change', function(e) {
                    var selected = $('#cmbTramites').val();
                    lstTramites = [];
                    $('#list_tramites').html('');
                    
                    $.each(selected, function(key, value) {
                        lstTramites.push(value);
                        var text = $("#cmbTramites option[value='" + value + "']")[0].innerText;
                        $('#list_tramites').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                });
            });
        }

        function TRAM_AJX_UNIDAD_ADMINISTRATIVA(id) {
            unidad = $.ajax({
                url: "/servidorespublicos/getUnity",
                type: "get",
                data: {"tipo":"multiple","dependencia_id": id.toString() ?? '0' }
            });

            unidad.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbUnidad_administrativa" class="selectpicker form-control"  data-live-search="true" multiple>';
                data.forEach(function(value) {
                    let select = '';
                    _lstUnidad_Administrativa.forEach(element => {
                        if(element.UNIDUP_NIDUNIDAD == value.iId){
                            select      =   'selected';
                            let option  =   `<div class="group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <span class="text-dark"> ${ value.Description } </span>
                                                    </div>
                                                </div>
                                            </div`;

                            $('#list_unidad_administrativa').append(option);
                            lstUnidad_Administrativa.push(value.Id);
                            TRAM_AJX_TRAMITES(value.Id);
                            TRAM_AJX_EDIFICIOS(value.Id);
                        }
                    });
                    _lstUnidad_Administrativa = [];
                    html += `<option ${select} value="${ value.Id }"> ${ value.Description } </option>`;
                });
                html += '</select>';

                $("#UnidadAdministrativa").html(html);
                $('#cmbUnidad_administrativa').selectpicker({
                    noneSelectedText: 'Búsqueda de Unidad Administrativa',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbUnidad_administrativa').on('change', function(e) {
                    var selected = $('#cmbUnidad_administrativa').val();
                    lstUnidad_Administrativa = [];
                    $('#list_unidad_administrativa').html('');
                    TRAM_AJX_TRAMITES(selected);
                    $.each(selected, function(key, value) {
                        lstUnidad_Administrativa.push(value);
                        var text = $("#cmbUnidad_administrativa option[value='" + value + "']")[0].innerText;
                        $('#list_unidad_administrativa').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                    TRAM_AJX_EDIFICIOS(selected);
                });
                _lstUnidad_Administrativa = [];
            });

            // Callback handler that will be called on failure
            unidad.fail(function (jqXHR, textStatus, errorThrown){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });
        };

        function TRAM_AJX_DEPENDENCIAS() {
            $.get('/servidorespublicos/getDepencencias', function(data) {

                var html = '<select id="cmbDependencias" class="selectpicker form-control" data-max-options="1" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    let select = '';
                    _lstDependencias.forEach(element => {
                        if(element.DEPUP_NIDDEPENCIA == value.iId){
                            select      =   'selected';
                            let option  =   `<div class="group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <span class="text-dark"> ${ value.Description } </span>
                                                    </div>
                                                </div>
                                            </div`;

                            $('#list_dependencias').append(option);
                            lstDependencias.push(value.Id);
                            TRAM_AJX_UNIDAD_ADMINISTRATIVA(value.Id)
                        }
                    });

                    html += `<option ${select} value="${ value.Id }"> ${ value.Description } </option>`;
                });
                html += '</select>';

                $("#Dependencias").html(html);
                $('#cmbDependencias').selectpicker({
                    noneSelectedText: 'Búsqueda de Dependencias',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbDependencias').on('change', function(e) { console.log("entro");
                    var selected = $('#cmbDependencias').val();
                    TRAM_AJX_UNIDAD_ADMINISTRATIVA(selected);
                    TRAM_AJX_DEPENDENCIAS_ACCESO(selected);
                    lstDependencias = [];

                    $('#list_dependencias').html('');
                    $.each(selected, function(key, value) {
                        lstDependencias.push(value);
                        var text =  $("#cmbDependencias option[value='" + value + "']")[0].innerText;
                        $('#list_dependencias').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                    

                    //Limpiamos unidades
                    lstUnidad_Administrativa = [];
                    $('#list_unidad_administrativa').html('');

                    //Limpiamos trámites
                    lstTramites = [];
                    $('#list_tramites').html('');

                    //Limpiamos edificios
                    lstEdificios = [];
                    $('#list_edificios').html('');
                });
            });
        }

        TRAM_AJX_DEPENDENCIAS();

        //acceso
        function TRAM_AJX_EDIFICIOS_ACCESO(id) {
            edificio = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getEdificios",
                type: "get",
                data: {"tipo":"multiple","unidad_id": id.toString() ?? '0' }

            });

            edificio.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbEdificios_acceso" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    let select = '';
                    _lstEdificios_Acceso.forEach(element => {
                        if(element.EDIFUA_NIDEDIFICIO == value.iId){
                            select      =   'selected';
                            let option  =   `<div class="group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <span class="text-dark"> ${ value.Name } </span>
                                                    </div>
                                                </div>
                                            </div`;

                            $('#list_edificios_acceso').append(option);
                            lstEdificios_Acceso.push(value.Id);
                        }
                    });
                    html += `<option ${select} value="${ value.Id }"> ${ value.Name } </option>`;
                });

                _lstEdificios_Acceso = [];
                html += '</select>';

                $("#EdificiosAcceso").html(html);
                $('#cmbEdificios_acceso').selectpicker({
                    noneSelectedText: 'Búsqueda de edificios',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbEdificios_acceso').on('change', function(e) {
                    var selected = $('#cmbEdificios_acceso').val();
                    lstEdificios_Acceso = [];
                    $('#list_edificios_acceso').html('');
                    $.each(selected, function(key, value) {
                        lstEdificios_Acceso.push(value);
                        var text = $("#cmbEdificios_acceso option[value='" + value + "']")[0].innerText;
                        $('#list_edificios_acceso').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                });
            });
        }

        function TRAM_AJX_TRAMITES_ACCESO(id) {
            tramite = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getTramites",
                type: "get",
                data: {"tipo":"multiple","unidad_id": id.toString() ?? '0' }
            });

            tramite.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbTramites_acceso" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    let select = '';
                    _lstTramites_Acceso.forEach(element => {
                        if(element.TRAMUA_NIDTRAMITE == value.iId){
                            select      =   'selected';
                            let option  =   `<div class="group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <span class="text-dark"> ${ value.Key } </span>
                                                    </div>
                                                </div>
                                            </div`;

                            $('#list_tramites_acceso').append(option);
                            lstTramites_Acceso.push(value.Id);
                        }
                    });
                    html += `<option ${select} value="${ value.Id }"> ${ value.Key } </option>`;
                });
                html += '</select>';
                _lstTramites_Acceso = [];
                
                $("#TramitesAcceso").html(html);
                $('#cmbTramites_acceso').selectpicker({
                    noneSelectedText: 'Búsqueda de Trámites',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbTramites_acceso').on('change', function(e) {
                    var selected = $('#cmbTramites_acceso').val();
                    lstTramites = [];
                    $('#list_tramites_acceso').html('');
                    
                    $.each(selected, function(key, value) {
                        lstTramites_Acceso.push(value);
                        var text = $("#cmbTramites_acceso option[value='" + value + "']")[0].innerText;
                        $('#list_tramites_acceso').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                });
            });
        }

        var list_temporal_tramite_acceso = [];

        function TRAM_AJX_UNIDAD_ADMINISTRATIVA_ACCESO(id) {
            unidad = $.ajax({
                url: "/servidorespublicos/getUnity",
                type: "get",
                data: {"tipo":"multiple","dependencia_id": id.toString() ?? '0' }
            });

            unidad.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbUnidad_administrativa_acceso" class="selectpicker form-control"  data-live-search="true" multiple>';
                data.forEach(function(value) {
                    let select = '';
                    _lstUnidad_Administrativa_Acceso.forEach(element => {
                        if(element.UNIDUA_NIDUNIDAD == value.iId){
                            select      =   'selected';
                            let option  =   `<div class="group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <span class="text-dark"> ${ value.Description } </span>
                                                    </div>
                                                </div>
                                            </div`;

                            $('#list_unidad_administrativa_acceso').append(option);
                            lstUnidad_Administrativa_Acceso.push(value.Id);
                            TRAM_AJX_TRAMITES_ACCESO(value.Id);
                            TRAM_AJX_EDIFICIOS_ACCESO(value.Id);
                        }
                    });

                    html += `<option ${select} value="${ value.Id }"> ${ value.Description } </option>`;
                });
                _lstUnidad_Administrativa_Acceso = [];
                html += '</select>';

                $("#UnidadAdministrativaAcceso").html(html);
                $('#cmbUnidad_administrativa_acceso').selectpicker({
                    noneSelectedText: 'Búsqueda de Unidad Administrativa',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbUnidad_administrativa_acceso').on('change', function(e) {
                    var selected = $('#cmbUnidad_administrativa_acceso').val();
                    _lstUnidad_Administrativa_Acceso = [];
                    $('#list_unidad_administrativa_acceso').html('');
                    TRAM_AJX_TRAMITES_ACCESO(selected);
                    $.each(selected, function(key, value) {
                        lstUnidad_Administrativa_Acceso.push(value);
                        var text = $("#cmbUnidad_administrativa_acceso option[value='" + value + "']")[0].innerText;
                        $('#list_unidad_administrativa_acceso').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                    TRAM_AJX_EDIFICIOS_ACCESO(selected);
                });
                _lstUnidad_Administrativa = [];
            });

            // Callback handler that will be called on failure
            unidad.fail(function (jqXHR, textStatus, errorThrown){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });
        }

        function TRAM_AJX_DEPENDENCIAS_ACCESO(select = null) {
            $.get('/servidorespublicos/getDepencencias', function(data) {

                var data_max = "";
                data_max = 'data-max-options="1"';
                var html = '<select id="cmbDependencias_acceso" class="selectpicker form-control" ' + data_max + ' data-live-search="true" multiple>';

                data.forEach(function(value) {
                    let select = '';
                    _lstDependencias_Acceso.forEach(element => {
                        if(element.DEPUA_NIDDEPENCIA == value.iId){
                            select      =   'selected';
                            let option  =   `<div class="group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <span class="text-dark"> ${ value.Description } </span>
                                                    </div>
                                                </div>
                                            </div`;

                            $('#list_dependencias_acceso').append(option);
                            lstDependencias_Acceso.push(value.Id);
                            TRAM_AJX_UNIDAD_ADMINISTRATIVA_ACCESO(value.Id)
                        }
                    });

                    html += `<option ${select} value="${ value.Id }"> ${ value.Description } </option>`;
                });
                html += '</select>';
                _lstDependencias_Acceso = [];

                $("#DependenciasAcceso").html(html);
                $('#cmbDependencias_acceso').selectpicker({
                    noneSelectedText: 'Búsqueda de Dependencias',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbDependencias_acceso').on('change', function(e) {

                    var selected = $('#cmbDependencias_acceso').val();

                    //Limpiamos dependencias
                    lstDependencias_Acceso = [];
                    $('#list_dependencias_acceso').html('');

                    //Limpiamos unidades
                    lstUnidad_Administrativa_Acceso = [];
                    $('#list_unidad_administrativa_acceso').html('');

                    //Limpiamos trámites
                    lstTramites_Acceso = [];
                    $('#list_tramites_acceso').html('');

                    //Limpiamos edificios
                    lstEdificios_Acceso = [];
                    $('#list_edificios_acceso').html('');

                    //Eliminamos opciones de select's de unidades, trámites y edificios
                    var cmbUnidad_administrativa = $('#cmbUnidad_administrativa_acceso');
                    var cmbTramites = $('#cmbTramites_acceso');
                    var cmbEdificios = $('#cmbEdificios_acceso');
                    cmbUnidad_administrativa.find('option').remove();
                    cmbTramites.find('option').remove();
                    cmbEdificios.find('option').remove();
                    $('#cmbUnidad_administrativa_acceso').selectpicker('refresh');
                    $('#cmbTramites_acceso').selectpicker('refresh');
                    $('#cmbEdificios_acceso').selectpicker('refresh');

                    if (selected === null || !(selected.length > 0)) {
                        return;
                    }

                    TRAM_AJX_UNIDAD_ADMINISTRATIVA_ACCESO(selected);

                    $.each(selected, function(key, value) {
                        lstDependencias_Acceso.push(value);
                        var text = $("#cmbDependencias_acceso option[value='" + value + "']")[0].innerText;
                        $('#list_dependencias_acceso').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">' + text + '</span></div></div></div>');
                    });
                });
            });
        }

        TRAM_AJX_DEPENDENCIAS_ACCESO();

        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "El nombre (s) solamente puede tener caracteres alfabéticos y espacios.");

        $("#frmForm").validate({
            focusInvalid: false,
            invalidHandler: function() {
                $(this).find(":input.error:first").focus();
            },
            rules: {
                txtNombres: {
                    minlength: 2,
                    maxlength: 100,
                    lettersonly: true,
                    required: true
                },
                txtPrimer_Apellido: {
                    minlength: 2,
                    maxlength: 100,
                    lettersonly: true,
                    required: true
                },
                txtSegundo_Apellido: {
                    minlength: 2,
                    maxlength: 100,
                    lettersonly: true,
                    required: false
                },
                txtCorreo_Electronico: {
                    email: true,
                    required: true
                },
                txtContrasenia: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck: true
                },
                txtConfirmarContrasenia: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck: true,
                    passwordMatch: true
                },
                txtTelefono: {
                    maxlength: 10
                },
                txtExtension: {
                    minlength: 2,
                    maxlength: 5,
                    lettersonly: false,
                }
            },
            messages: {
                txtNombres: {
                    minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    required: "El campo Nombres (s) es requerido.",
                    lettersonly: "El campo solo puede ser caracteres alfabéticos y espacios."
                },
                txtPrimer_Apellido: {
                    minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    required: "El campo Primer apellido es requerido.",
                    lettersonly: "El campo solo puede ser caracteres alfabéticos y espacios."
                },
                txtSegundo_Apellido: {
                    minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                    lettersonly: "El campo solo puede ser caracteres alfabéticos y espacios."
                },
                txtCorreo_Electronico: {
                    email: "El correo que se agregó no es válido, favor de verificar.",
                    required: "El campo Correo electrónico es requerido.",
                },
                txtContrasenia: {
                    passwordcheck: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    minlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    maxlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    required: ""
                },
                txtConfirmarContrasenia: {
                    passwordcheck: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    minlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    maxlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                    passwordMatch: "La contraseña no coincide, favor de verificar.",
                    required: ""
                },
                txtTelefono: {
                    maxlength: 'El "Teléfono" debe tener 10 dígitos.'
                },
                txtExtension: {
                    number: 'El campo solo puede contener caracteres numéricos.',
                    minlength: 'El tamaño del campo debe contener mínimo 2 caracteres y máximo 5 caracteres.',
                    maxlength: 'El tamaño del campo debe contener mínimo 2 caracteres y máximo 5 caracteres.'
                }

            }
        });
    });

    //agregar areas a la que pertenece
    function FN_AGREGAR_AREAS_PERTENECE(area) {
        switch (area) {
            case 0:
                $("#lblSelect").html("Búsqueda de dependencia o entidades");
                $("#cmbDependencias").show();
                $("#Dependencias").show();
                $("#AccionDependencias").show();

                //Ocultar edificios
                $("#cmbEdificios").hide();
                $("#Edificios").hide();
                $("#AccionEdificio").hide();

                //Ocultar unidades administrativas
                $("#cmbUnidad_administrativa").hide();
                $("#UnidadAdministrativa").hide();
                $("#AccionUnidadAdministrativa").hide();

                //Ocultar tramites
                $("#cmbTramites").hide();
                $("#Tramites").hide();
                $("#AccionTramites").hide();
                $("#ModalAreasPertence").modal("show");
                break;
            case 1:
                if (lstDependencias.length > 0) {
                    $("#lblSelect").html("Búsqueda de unidades administrativas");
                    $("#cmbUnidad_administrativa").show();
                    $("#UnidadAdministrativa").show();
                    $("#AccionUnidadAdministrativa").show();

                    //Ocultar dependencias
                    $("#cmbDependencias").hide();
                    $("#Dependencias").hide();
                    $("#AccionDependencias").hide();

                    //Ocultar edificios
                    $("#cmbEdificios").hide();
                    $("#Edificios").hide();
                    $("#AccionEdificio").hide();

                    //Ocultar tramites
                    $("#cmbTramites").hide();
                    $("#Tramites").hide();
                    $("#AccionTramites").hide();
                    $("#ModalAreasPertence").modal("show");
                } else {
                    Swal.fire({
                        title: '¡Aviso!',
                        text: 'Por favor, selecciona una dependencia o entidad.',
                        icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                }

                break;
            case 2:
                if (lstUnidad_Administrativa.length > 0) {
                    $("#lblSelect").html("Búsqueda de trámites");
                    $("#cmbTramites").show();
                    $("#Tramites").show();
                    $("#AccionTramites").show();

                    //Ocultar dependencias
                    $("#cmbDependencias").hide();
                    $("#Dependencias").hide();
                    $("#AccionDependencias").hide();

                    //Ocultar edificios
                    $("#cmbEdificios").hide();
                    $("#Edificios").hide();
                    $("#AccionEdificio").hide();

                    //Ocultar unidades administrativas
                    $("#cmbUnidad_administrativa").hide();
                    $("#UnidadAdministrativa").hide();
                    $("#AccionUnidadAdministrativa").hide();
                    $("#ModalAreasPertence").modal("show");
                } else {
                    Swal.fire({
                        title: '¡Aviso!',
                        text: 'Por favor, selecciona una unidad administrativa.',
                        icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                }
                break;
            case 3:

                if (lstTramites.length > 0) {

                    $("#lblSelect").html("Búsqueda de edificios");
                    $("#cmbEdificios").show();
                    $("#Edificios").show();
                    $("#AccionEdificio").show();

                    //Ocultar unidades administrativas
                    $("#cmbUnidad_administrativa").hide();
                    $("#UnidadAdministrativa").hide();
                    $("#AccionUnidadAdministrativa").hide();

                    //Ocultar tramites
                    $("#cmbTramites").hide();
                    $("#Tramites").hide();
                    $("#AccionTramites").hide();

                    //Ocultar dependencias
                    $("#cmbDependencias").hide();
                    $("#Dependencias").hide();
                    $("#AccionDependencias").hide();
                    $("#ModalAreasPertence").modal("show");

                } else {
                    Swal.fire({
                        title: '¡Aviso!',
                        text: 'Por favor, selecciona al menos un trámite.',
                        icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                }
                break;
        }

    };

    //limpiar areas a la que pertence
    function FN_LIMPIAR_PERTENECE(area) {

        switch (area) {
            case 0:

                //Deseleccionamos dependencias
                $('#cmbDependencias').selectpicker('deselectAll');
                $('#cmbDependencias').selectpicker('render');
                $('.chkTodos').prop('checked', false);
                $('#cmbDependencias').trigger('change');

                //Eliminamos opciones de select's de unidades, trámites y edificios
                var cmbUnidad_administrativa = $('#cmbUnidad_administrativa');
                var cmbTramites = $('#cmbTramites');
                var cmbEdificios = $('#cmbEdificios');
                cmbUnidad_administrativa.find('option').remove();
                cmbTramites.find('option').remove();
                cmbEdificios.find('option').remove();
                $('#cmbUnidad_administrativa').selectpicker('refresh');
                $('#cmbTramites').selectpicker('refresh');
                $('#cmbEdificios').selectpicker('refresh');
                break;
            case 1:

                //Deseleccionamos unidades administrativas
                $('#cmbUnidad_administrativa').selectpicker('deselectAll');
                $('#cmbUnidad_administrativa').selectpicker('render');
                $('.chkTodos').prop('checked', false);
                $('#cmbUnidad_administrativa').trigger('change');

                //Eliminamos opciones de select's trámites y edificios
                var cmbTramites = $('#cmbTramites');
                var cmbEdificios = $('#cmbEdificios');
                cmbTramites.find('option').remove();
                cmbEdificios.find('option').remove();
                $('#cmbTramites').selectpicker('refresh');
                $('#cmbEdificios').selectpicker('refresh');
                break;
            case 2:

                //Deseleccionamos trámites
                $('#cmbTramites').selectpicker('deselectAll');
                $('#cmbTramites').selectpicker('render');
                $('.chkTodos').prop('checked', false);
                $('#cmbTramites').trigger('change');

                //Eliminamos opciones de select's edificios
                var cmbEdificios = $('#cmbEdificios');
                cmbEdificios.find('option').remove();
                $('#cmbEdificios').selectpicker('refresh');
                break;
            case 3:

                //Deseleccionamos edificios
                $('#cmbEdificios').selectpicker('deselectAll');
                $('#cmbEdificios').selectpicker('render');
                $('.chkTodos').prop('checked', false);
                $('#cmbEdificios').trigger('change');
                break;
        }
    };

    //agregar areas a la que pertenece
    function FN_AGREGAR_AREAS_ACCESO(area) {
        switch (area) {
            case 0:
                $("#lblSelectAcceso").html("Búsqueda de dependencia o entidades");
                $("#cmbDependencias_acceso").show();
                $("#DependenciasAcceso").show();
                $("#AccionDependenciasAcceso").show();

                //Ocultar edificios
                $("#cmbEdificios_acceso").hide();
                $("#EdificiosAcceso").hide();
                $("#AccionEdificioAcceso").hide();

                //Ocultar unidades administrativas
                $("#cmbUnidad_administrativa_acceso").hide();
                $("#UnidadAdministrativaAcceso").hide();
                $("#AccionUnidadAdministrativaAcceso").hide();

                //Ocultar tramites
                $("#cmbTramites_acceso").hide();
                $("#TramitesAcceso").hide();
                $("#AccionTramitesAcceso").hide();

                $("#ModalAreasAcceso").modal("show");
                break;
            case 1:
                if (lstDependencias_Acceso.length > 0) {
                    $("#lblSelectAcceso").html("Búsqueda de unidades administrativas");
                    $("#cmbUnidad_administrativa_acceso").show();
                    $("#UnidadAdministrativaAcceso").show();
                    $("#AccionUnidadAdministrativaAcceso").show();

                    //Ocultar dependencias
                    $("#cmbDependencias_acceso").hide();
                    $("#DependenciasAcceso").hide();
                    $("#AccionDependenciasAcceso").hide();

                    //Ocultar edificios
                    $("#cmbEdificios_acceso").hide();
                    $("#EdificiosAcceso").hide();
                    $("#AccionEdificioAcceso").hide();

                    //Ocultar tramites
                    $("#cmbTramites_acceso").hide();
                    $("#TramitesAcceso").hide();
                    $("#AccionTramitesAcceso").hide();

                    $("#ModalAreasAcceso").modal("show");
                } else {
                    Swal.fire({
                        title: '¡Aviso!',
                        text: 'Por favor, selecciona una dependencia o entidad.',
                        icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                }
                break;
            case 2:
                if (lstUnidad_Administrativa_Acceso.length > 0) {
                    $("#lblSelectAcceso").html("Búsqueda de trámites");
                    $("#cmbTramites_acceso").show();
                    $("#TramitesAcceso").show();
                    $("#AccionTramitesAcceso").show();

                    //Ocultar dependencias
                    $("#cmbDependencias_acceso").hide();
                    $("#DependenciasAcceso").hide();
                    $("#AccionDependenciasAcceso").hide();

                    //Ocultar edificios
                    $("#cmbEdificios_acceso").hide();
                    $("#EdificiosAcceso").hide();
                    $("#AccionEdificioAcceso").hide();

                    //Ocultar unidades administrativas
                    $("#cmbUnidad_administrativa_acceso").hide();
                    $("#UnidadAdministrativaAcceso").hide();
                    $("#AccionUnidadAdministrativaAcceso").hide();
                    $("#ModalAreasAcceso").modal("show");
                } else {
                    Swal.fire({
                        title: '¡Aviso!',
                        text: 'Por favor, selecciona una unidad administrativa.',
                        icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                }
                break;
            case 3:
                $("#lblSelectAcceso").html("Búsqueda de edificios");
                $("#cmbEdificios_acceso").show();
                $("#EdificiosAcceso").show();
                $("#AccionEdificioAcceso").show();

                //Ocultar unidades administrativas
                $("#cmbUnidad_administrativa_acceso").hide();
                $("#UnidadAdministrativaAcceso").hide();
                $("#AccionUnidadAdministrativaAcceso").hide();

                //Ocultar tramites
                $("#cmbTramites_acceso").hide();
                $("#TramitesAcceso").hide();
                $("#AccionTramitesAcceso").hide();

                //Ocultar dependencias
                $("#cmbDependencias_acceso").hide();
                $("#DependenciasAcceso").hide();
                $("#AccionDependenciasAcceso").hide();
                $("#ModalAreasAcceso").modal("show");
                break;
        }

    };

    //Seleccionar todos
    function FN_SELECIONAR_TODOS_PERTECE(area) {
        switch (area) {
            case 0:
                $('#cmbDependencias').selectpicker('selectAll');
                break;
            case 1:
                $('#cmbUnidad_administrativa').selectpicker('selectAll');
                break;
            case 2:
                $('#cmbTramites').selectpicker('selectAll');
                break;
            case 3:
                $('#cmbEdificios').selectpicker('selectAll');
                break;
        }
    };

    //limpiar areas acceso
    function FN_LIMPIAR_ACCESO(area) {
        switch (area) {
            case 0:

                //Deseleccionamos dependencias
                $('#cmbDependencias_acceso').selectpicker('deselectAll');
                $('#cmbDependencias_acceso').selectpicker('render');
                $('.chkTodosAcceso').prop('checked', false);
                $('#cmbDependencias_acceso').trigger('change');

                //Eliminamos opciones de select's de unidades, trámites y edificios
                var cmbUnidad_administrativa = $('#cmbUnidad_administrativa_acceso');
                var cmbTramites = $('#cmbTramites_acceso');
                var cmbEdificios = $('#cmbEdificios_acceso');
                cmbUnidad_administrativa.find('option').remove();
                cmbTramites.find('option').remove();
                cmbEdificios.find('option').remove();
                $('#cmbUnidad_administrativa_acceso').selectpicker('refresh');
                $('#cmbTramites_acceso').selectpicker('refresh');
                $('#cmbEdificios_acceso').selectpicker('refresh');

                break;
            case 1:

                //Deseleccionamos unidades
                $('#cmbUnidad_administrativa_acceso').selectpicker('deselectAll');
                $('#cmbUnidad_administrativa_acceso').selectpicker('render');
                $('.chkTodosAcceso').prop('checked', false);
                $('#cmbUnidad_administrativa_acceso').trigger('change');

                //Eliminamos opciones de select's trámites y edificios
                var cmbTramites = $('#cmbTramites_acceso');
                var cmbEdificios = $('#cmbEdificios_acceso');
                cmbTramites.find('option').remove();
                cmbEdificios.find('option').remove();
                $('#cmbTramites_acceso').selectpicker('refresh');
                $('#cmbEdificios_acceso').selectpicker('refresh');

                break;
            case 2:

                //Deseleccionamos trámites
                $('#cmbTramites_acceso').selectpicker('deselectAll');
                $('#cmbTramites_acceso').selectpicker('render');
                $('.chkTodosAcceso').prop('checked', false);
                $('#cmbTramites_acceso').trigger('change');

                //Eliminamos opciones de select's edificios
                var cmbEdificios = $('#cmbEdificios_acceso');
                cmbEdificios.find('option').remove();
                $('#cmbEdificios_acceso').selectpicker('refresh');

                break;
            case 3:

                //Deseleccionamos edificios
                $('#cmbEdificios_acceso').selectpicker('deselectAll');
                $('#cmbEdificios_acceso').selectpicker('render');
                $('.chkTodosAcceso').prop('checked', false);
                $('#cmbEdificios_acceso').trigger('change');

                break;
        }
    };

    //Seleccionar areas acceso todos
    function FN_SELECIONAR_TODOS_ACCESO(area) {
        switch (area) {
            case 0:
                $('#cmbDependencias_acceso').selectpicker('selectAll');
                break;
            case 1:
                $('#cmbUnidad_administrativa_acceso').selectpicker('selectAll');
                break;
            case 2:
                $('#cmbTramites_acceso').selectpicker('selectAll');
                break;
            case 3:
                $('#cmbEdificios_acceso').selectpicker('selectAll');
                break;
        }
    };

    //Deshabilita/Habilita
    function TRAM_FN_ENABLE(StrInput, IntTipo) {

        var StrIdentificador = IntTipo == 1 ? "#" : ".";
        if ($(StrIdentificador + StrInput).is('[readonly]')) {
            $(StrIdentificador + StrInput).attr("readonly", false);
        } else {
            $(StrIdentificador + StrInput).attr("readonly", true);
        }
    };

    function TRAM_FN_DISABLED_INPUT() {
        $("input").each(function() {
            $(this).attr("readonly", true);
        });
        $("select").each(function() {
            $(this).attr("readonly", true);
        });
    };


    //guardar
    function TRAM_AJX_CONFIRMAR() {
        $("#frmForm").submit(function(e) {
            return false;
        });
        TRAM_AJX_GUARDAR();
    };

    function TRAM_AJX_GUARDAR() {
        //TRAM_FN_ENABLED_INPUT();
        var objData = {
            USUA_NIDUSUARIO : $("#txtIdUsuario").val(),
            USUA_CUSUARIO   : $("#txtUsuario").val(),
            USUA_NIDROL     : $("#cmbRol").val(),
            USUA_CNOMBRES   : $("#txtNombres").val(),
            USUA_NTELEFONO  : $("#txtTelefono").val(),
            USUA_NEXTENSION : $("#txtExtension").val(),
            USUA_CPRIMER_APELLIDO      : $("#txtPrimer_Apellido").val(),
            USUA_CSEGUNDO_APELLIDO     : $("#txtSegundo_Apellido").val(),
            USUA_CCORREO_ELECTRONICO   : $("#txtCorreo_Electronico").val(),
            lstDependenciaPertenece : lstDependencias,
            lstUnidadPertence       : lstUnidad_Administrativa,
            lstTramitePertence      : lstTramites,
            lstEdificioPertence     : lstEdificios,
            lstDependenciaAcceso    : lstDependencias_Acceso,
            lstUnidadAcceso         : lstUnidad_Administrativa_Acceso,
            lstTramiteAcceso        : lstTramites_Acceso,
            lstEdificioAcceso       : lstEdificios_Acceso
        };

        // $("#btnSubmit").prop("disabled", true);

        if (!$("#frmForm").valid()) {
            $('.listError').hide();
            var validator = $('#frmForm').validate();
            var htmlError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
            $.each(validator.errorList, function(index, value) {
                var campo = $("#" + value.element.id).attr('placeholder') == undefined ? $("#" + value.element.id).attr('title') : $("#" + value.element.id).attr('placeholder');
                if (value.method == "required") {
                    $('.listError').show();
                    htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                }
            });
            htmlError += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $(".listError").html(htmlError);
            $("#btnSubmit").prop("disabled", false);
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            TRAM_FN_DISABLED_INPUT();
            return;
        }

        $.ajax({
            data: objData,
            url: "/servidorespublicos/modificar",
            type: "POST",
            dataType: 'json',
            success: function(data) {

                $("#btnSubmit").prop("disabled", false);
                if (data.status == "success") {
                    $('#frmForm').trigger("reset");
                    $(".listError").html("");

                    Swal.fire({
                        title: '¡Éxito!',
                        text: "Acción realizada con éxito",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            TRAM_FN_BACK();
                        }
                    });
                } else {
                    Swal.fire({
                        title: '¡Aviso!',
                        text: data.message,
                        icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(data) {
                $("#btnSubmit").prop("disabled", false);
                Swal.fire({
                    title: '¡Aviso!',
                    text: data.message,
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    };

    //Redirige a lista de usuarios
    function TRAM_FN_BACK() {
        document.location.href = '/servidorespublicos';
    };
</script>

<style>
    .btnExport {
        background-color: #ffa000;
        border-color: #ffa000;
        color: #ffffff;
        margin-right: 4px;
    }

    .btnExport:hover {
        color: #ffffff;
    }

    .dropdown-menu {
        width: 100% !important;
    }

    .loadingFrame {
        background: rgb(255 255 255 / 50%);
        display: table;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 999;
    }

    .loadingFrame .inner {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }

    .loadingFrame .inner md-progress-circular {
        margin: auto;
        height: 460px;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        margin-top: -50px;
    }

    .loadingFrame .inner p {
        color: #fff;
        font-size: 22px;
    }
</style>
<script>
</script>

@endsection
