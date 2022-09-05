@extends('layout.Layout')

@section('body')

<!-- <%-- Contenido individual --%> -->
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2>Crear usuario</h2>
            {{-- @if(Auth::user() != null)
                {{Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE}}
            @endif --}}
        </div>
    </div>
    <div class="card">
        <div class="card-body text-body">
            <div class="listError"></div>
            <div class="MensajeSuccess"></div>
            <form id="frmForm" name="frmForm" class="form-horizontal m-4 needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="font-weight-bold">Por favor, Ingrese los datos solicitados.</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="dteFechaInicio">Usuario <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Usuario" class="form-control" name="txtUsuario" id="txtUsuario">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="dteFechaInicio">Rol <span class="text-danger">*</span></label>
                            <select class="combobox form-control" name="cmbRol" id="cmbRol" placeholder="Rol">
                                <option value="0">Selecccionar</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dteFechaInicio">Nombre (s) <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Nombre (s)" class="form-control" name="txtNombres" id="txtNombres" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtNombre">Primer apellido <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Primer apellido" class="form-control" name="txtPrimer_Apellido" id="txtPrimer_Apellido" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbDependenciaEntidad">Segundo apellido</label>
                            <input type="text" placeholder="Segundo apellido" class="form-control" name="txtSegundo_Apellido" id="txtSegundo_Apellido">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dteFechaInicio">Teléfono</label>
                            <input type="number" placeholder="Teléfono" class="form-control" name="txtTelefono" id="txtTelefono">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dteFechaInicio">Extensión</label>
                            <input type="number" placeholder="Extensión" class="form-control" name="txtExtension" id="txtExtension">
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="font-weight-bold">Área a la que pertenece</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p class="font-weight-bold text-dark text-right">Dependencia o entidad <span class="circle-sm" onclick="FN_AGREGAR_AREAS_PERTENECE(0)">+</span></p>
                        <div class="group-list">
                            <div id="list_dependencias" ></div>
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
                <br/><br/>
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
                                    <span class="circle-sm" onclick="FN_AGREGAR_AREAS_ACCESO(0)">+</span></p>
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
                <br/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bus-txt-centro-trabajo">Correo electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="txtCorreo_Electronico" id="txtCorreo_Electronico"
                                placeholder="Correo electrónico" required>
                            <span id="resultadoExistCorreo" style="font-size: 12px;"></span>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bus-txt-centro-trabajo">Contraseña <span class="text-danger">*</span> <span class="text-primary">Debe tener mínimo 6 y máximo 20 caracteres</span></label>
                            <input type="password" class="form-control" name="txtContrasenia" id="txtContrasenia"
                                placeholder="Contraseña" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bus-txt-centro-trabajo">Confirmación de contraseña <span class="text-danger">*</span> <span class="text-primary">Debe tener mínimo 6 y máximo 20 caracteres</span></label>
                            <input type="password" class="form-control" name="txtConfirmarContrasenia" id="txtConfirmarContrasenia"
                                placeholder="Confirmación de contraseña" required>
                        </div>
                    </div>
                </div>
                <br/>
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
                        <label style="font-size: 1rem; font-weight: bold;"><span id="lblSelect" ></span></label>
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
                            <div class="col-md-6 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_PERTENECE(2);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-6  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodos" type="checkbox" id="chkTodos" onclick="FN_SELECIONAR_TODOS_PERTECE(2)">
                                        <label class="form-check-label" for="chkTodos">
                                            Seleccionar todos
                                        </label>
                                  </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="AccionEdificio">
                            <div class="col-md-6 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_PERTENECE(3);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-6  row align-items-center">
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
                        <label style="font-size: 1rem; font-weight: bold;"><span id="lblSelectAcceso" ></span></label>
                        <div id="DependenciasAcceso"></div>
                        <div id="UnidadAdministrativaAcceso"></div>
                        <div id="TramitesAcceso"></div>
                        <div id="EdificiosAcceso"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="row align-items-center" id="AccionDependenciasAcceso">
                            <div class="col-md-6 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_ACCESO(0);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-6  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodosAcceso" type="checkbox" id="chkTodosAcceso" onclick="FN_SELECIONAR_TODOS_ACCESO(0)">
                                        <label class="form-check-label" for="chkTodosAcceso">
                                            Seleccionar todos
                                        </label>
                                  </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="AccionUnidadAdministrativaAcceso">
                            <div class="col-md-6 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_ACCESO(1);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-6  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodosAcceso" type="checkbox" id="chkTodosAcceso" onclick="FN_SELECIONAR_TODOS_ACCESO(1)">
                                        <label class="form-check-label" for="chkTodosAcceso">
                                            Seleccionar todos
                                        </label>
                                  </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="AccionTramitesAcceso">
                            <div class="col-md-6 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_ACCESO(2);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-6  row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input chkTodosAcceso" type="checkbox" id="chkTodosAcceso" onclick="FN_SELECIONAR_TODOS_ACCESO(2)">
                                        <label class="form-check-label" for="chkTodosAcceso">
                                            Seleccionar todos
                                        </label>
                                  </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="AccionEdificioAcceso">
                            <div class="col-md-6 text-right">
                                <div style="cursor: pointer;" onclick="FN_LIMPIAR_ACCESO(3);"><span class="text-danger" style="font-size: 18px;">x</span> <span>Limpiar</span></div>
                            </div>
                            <div class="col-md-6  row align-items-center">
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

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        request = $.ajax({
                url: "/general/roles",
                type: "get",
                data: {"paginate":true, 'estatus':'Activos'}
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
                var $select = $('#cmbRol');

               // $select.find('option').remove();
               response.forEach(element => {
                    $select.append('<option value=' + element.ROL_NIDROL + '>' + element.ROL_CNOMBRE + '</option>'); // return empty
               });

            });

            // Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });

        $.validator.addMethod("passwordcheck", function(value) {
            return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value)// has a special character
            },"La contraseña debe contener de 8 a 15 carácteres alfanuméricos (a-z A-Z), contener mínimo un dígito (0-9) y un carácter especial (_-=)."
        );

        $.validator.addMethod( 'passwordMatch', function(value, element) {
            var password = $("#txtContrasenia").val();
            var confirmPassword = $("#txtConfirmarContrasenia").val();
            if (password != confirmPassword ) {
                return false;
            } else {
                return true;
            }
        });


        //Correo
        $('#txtCorreo_Electronico').change(function(){
            var value = $( this ).val();
            TRAM_AJX_VALIDAR_CORREO(value);
        });


        //Validar si el correo existe
        function TRAM_AJX_VALIDAR_CORREO(StrCorreo){
            $.get('/servidorespublicos/validar_correo/' + StrCorreo, function (data) {
                //Validamos si existe un usuario con el correo capturado
                if(data.status == "success"){
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", true);
                    }, 1000);
                    $("#txtRfc").attr("aria-invalid", "true");
                    $("#txtRfc").addClass("error");
                    $("#resultadoExistCorreo").html("<span style='color: red;'>"+ data.message +"</span>");
                }else {
                    setTimeout(function(){
                        $(".btnSubmit").prop("disabled", false);
                    }, 1000);
                    $("#txtRfc").attr("aria-invalid", "false");
                    $("#txtRfc").removeClass("error");
                    $("#resultadoExistCorreo").html("");
                }
            });
        };


        function TRAM_AJX_TRAMITES(id){
            console.log(id.toString())
            //$.get('/general/tramites?unidad_id=' + id.toString(), function (data) {
            // $.get('/general/obtenerTramites/' + id.toString(), function (data) {

                unidad = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getTramites",
                // url:"/general/unidades_administrativas",
                    type: "get",
                    data: {"tipo":"multiple","unidad_id": id.toString() ?? '0' }

                });

                unidad.done(function (data, textStatus, jqXHR){

                var html = '<select id="cmbTramites" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    html += '<option value="'+ value.iId +'">' + value.Key + '</option>';
                });
                html += '</select>';

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

                TRAM_AJX_EDIFICIOS(id);
            });
        }

        function TRAM_AJX_UNIDAD_ADMINISTRATIVA(id){
            console.log(id.toString())
            unidad = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getUnity",
                // url:"/general/unidades_administrativas",
                type: "get",
                data: {"tipo":"multiple","dependencia_id": id.toString() ?? '0' }

            });

            // Callback handler that will be called on success
            unidad.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbUnidad_administrativa" class="selectpicker form-control"  data-live-search="true" multiple>';
                data.forEach(function(value) {
                    html += '<option value="'+ value.ID_CENTRO +'">' + value.DESCRIPCION + '</option>';
                    // $("#cmbEdificios option[value='" + value + "']").prop("selected", true);
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
                });
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


        function TRAM_AJX_DEPENDENCIAS(){
            //Estos llaman al nuevo remapeo del retys
            $.get('/servidorespublicos/getDep', function (data) {
                // $.get('/general/dependencias', function (data) {

                var html = '<select id="cmbDependencias" class="selectpicker form-control"  data-live-search="true" multiple>';

                data.forEach(function(value) {
                    html += '<option value="'+ value.ID_CENTRO +'">' + value.DESCRIPCION + '</option>';

                });
                html += '</select>';

                $("#Dependencias").html(html);
                $('#cmbDependencias').selectpicker({
                    noneSelectedText: 'Búsqueda de Dependencias',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbDependencias').on('change', function(e) {
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
                });
            });
        }

        TRAM_AJX_DEPENDENCIAS();


        function TRAM_AJX_EDIFICIOS(id){
            // var myJSON = JSON.stringify(tramites);
            unidad = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getEdificios",
                // url:"/general/unidades_administrativas",
                    type: "get",
                    data: {"tipo":"multiple","tramite_id": id.toString() ?? '0' }

                });

                unidad.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbEdificios" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    html += '<option value="'+ value.ID_EDIFICIO +'">' + value.EDIFICIO + '</option>';
                    // $("#cmbEdificios option[value='" + value + "']").prop("selected", true);
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

        //acceso
        function TRAM_AJX_TRAMITES_ACCESO(id){
                unidad = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getTramites",
                // url:"/general/unidades_administrativas",
                    type: "get",
                    data: {"tipo":"multiple","unidad_id": id.toString() ?? '0' }

                });

                unidad.done(function (data, textStatus, jqXHR) {

                var html = '<select id="cmbTramites_acceso" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    html += '<option value="'+ value.iId +'">' + value.Key + '</option>';
                    // $("#cmbEdificios option[value='" + value + "']").prop("selected", true);
                });
                html += '</select>';

                $("#TramitesAcceso").html(html);
                $('#cmbTramites_acceso').selectpicker({
                    noneSelectedText: 'Búsqueda de Trámites',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbTramites_acceso').on('change', function(e) {
                    var selected = $('#cmbTramites_acceso').val();
                    lstTramites_Acceso = [];
                    $('#list_tramites_acceso').html('');
                    $.each(selected, function(key, value) {
                        lstTramites_Acceso.push(value);
                        var text = $("#cmbTramites_acceso option[value='" + value + "']")[0].innerText;
                        $('#list_tramites_acceso').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                });

                TRAM_AJX_EDIFICIOS_ACCESO(id);
            });
        }

        function TRAM_AJX_UNIDAD_ADMINISTRATIVA_ACCESO(id){

            unidad = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getUnity",
                // url:"/general/unidades_administrativas",
                type: "get",
                data: {"tipo":"multiple","dependencia_id": id.toString() ?? '0' }

            });

            // Callback handler that will be called on success
            unidad.done(function (data, textStatus, jqXHR){
                var html = '<select id="cmbUnidad_administrativa_acceso" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    html += '<option value="'+ value.ID_CENTRO +'">' + value.DESCRIPCION + '</option>';
                    // $("#cmbEdificios option[value='" + value + "']").prop("selected", true);
                });
                html += '</select>';

                $("#UnidadAdministrativaAcceso").html(html);
                $('#cmbUnidad_administrativa_acceso').selectpicker({
                    noneSelectedText: 'Búsqueda de Unidad Administrativa',
                    noneResultsText: 'No se encontraron resultados',
                });

                $('#cmbUnidad_administrativa_acceso').on('change', function(e) {
                    var selected = $('#cmbUnidad_administrativa_acceso').val();
                    lstUnidad_Administrativa_Acceso = [];
                    $('#list_unidad_administrativa_acceso').html('');
                    TRAM_AJX_TRAMITES_ACCESO(selected);
                    $.each(selected, function(key, value) {
                        lstUnidad_Administrativa_Acceso.push(value);
                        var text = $("#cmbUnidad_administrativa_acceso option[value='" + value + "']")[0].innerText;
                        $('#list_unidad_administrativa_acceso').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                });
            });
        }

        function TRAM_AJX_DEPENDENCIAS_ACCESO(selected){
            // $.get('/general/dependencias', function (data) {
            $.get('/servidorespublicos/getDep', function (data) {

                var data_max = "";
                if(StrRol == "ENLOF" || StrRol == "ADMCT"){
                    data_max = 'data-max-options="1"';
                }
                var html = '<select id="cmbDependencias_acceso" class="selectpicker form-control" '+ data_max +' data-live-search="true" multiple>';
                data.forEach(function(value) {
                    html += '<option value="'+ value.ID_CENTRO +'">' + value.DESCRIPCION + '</option>';
                    // $("#cmbEdificios option[value='" + value + "']").prop("selected", true);
                });
                html += '</select>';

                $("#DependenciasAcceso").html(html);
                $('#cmbDependencias_acceso').selectpicker({
                    noneSelectedText: 'Búsqueda de Dependencias',
                    noneResultsText: 'No se encontraron resultados',
                });


                if(StrRol == "ENLOF" || StrRol == "ADMCT"){
                    $("#cmbDependencias_acceso option[value='" + selected + "']").prop("selected", true);
                    var text = $("#cmbDependencias_acceso option[value='" + value + "']")[0].innerText;
                    $('#list_dependencias_acceso').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    lstDependencias_Acceso.push(selected);
                }

                $('#cmbDependencias_acceso').on('change', function(e) {
                    var selected = $('#cmbDependencias_acceso').val();
                    TRAM_AJX_UNIDAD_ADMINISTRATIVA_ACCESO(selected);
                    lstDependencias_Acceso = [];
                    $('#list_dependencias_acceso').html('');
                    $.each(selected, function(key, value) {
                        lstDependencias_Acceso.push(value);
                        var text = $("#cmbDependencias_acceso option[value='" + value + "']")[0].innerText;
                        $('#list_dependencias_acceso').append('<div class="group-item"><div class="row align-items-center"><div class="col-md-12 text-center"><span class="text-dark">'+text+'</span></div></div></div>');
                    });
                });
            });
        }

        function TRAM_AJX_EDIFICIOS_ACCESO(id){
            unidad = $.ajax({
                //Estos llaman al nuevo remapeo del retys
                url: "/servidorespublicos/getEdificios",
                // url:"/general/unidades_administrativas",
                    type: "get",
                    data: {"tipo":"multiple","tramite_id": id.toString() ?? '0' }

                });

                unidad.done(function (data, textStatus, jqXHR) {

                var html = '<select id="cmbEdificios_acceso" class="selectpicker form-control" data-live-search="true" multiple>';
                data.forEach(function(value) {
                    html += '<option value="'+ value.ID_EDIFICIO +'">' + value.EDIFICIO + '</option>';
                    // $("#cmbEdificios option[value='" + value + "']").prop("selected", true);
                });
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


        $.validator.addMethod("lettersonly", function(value, element)  {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
            }, "El nombre (s) solamente puede tener caracteres alfabéticos y espacios."
        );


        $("#frmForm").validate({
            focusInvalid: false,
            invalidHandler: function() {
                $(this).find(":input.error:first").focus();
            },
            rules: {
                txtNombres: {
                        minlength: 2,
                        maxlength: 100,
                        lettersonly: true
                },
                txtPrimer_Apellido: {
                        minlength: 2,
                        maxlength: 100
                },
                txtCorreo_Electronico: {
                    email: true
                },
                txtContrasenia: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck:true
                },
                txtConfirmarContrasenia: {
                    minlength: 6,
                    maxlength: 20,
                    passwordcheck:true,
                    passwordMatch: true
                },
                txtTelefono: {
                    maxlength: 10
                }
            },
            messages: {
                txtNombres: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: "",
                        lettersonly: "El nombre (s) solamente puede tener caracteres alfabéticos y espacios."
                },
                txtPrimer_Apellido: {
                        minlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        maxlength: "El tamaño del campo no puede ser menor de 2 caracteres ni mayor de 100 caracteres.",
                        required: ""
                },
                txtCorreo_Electronico: {
                    email: "El correo que se agregó no es válido, favor de verificar.",
                    required: ""
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
                }
            }
        });
    });

    //agregar areas a la que pertenece
    function FN_AGREGAR_AREAS_PERTENECE(area){
        switch(area){
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
                if(lstDependencias.length > 0){
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
                }else {
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
                if(lstUnidad_Administrativa.length > 0){
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
                }else {
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
                break;
        }

    };

    //agregar areas a la que pertenece
    function FN_AGREGAR_AREAS_ACCESO(area){
        switch(area){
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
                if(lstDependencias_Acceso.length > 0){
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
                }else {
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
                if(lstUnidad_Administrativa_Acceso.length > 0){
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
                }else {
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

    //limpiar areas a la que pertence
    function FN_LIMPIAR_PERTENECE(area){
        switch(area){
            case 0:
                $('#cmbDependencias').selectpicker('deselectAll');
                $('.chkTodos').prop('checked',false);
                break;
            case 1:
                $('#cmbUnidad_administrativa').selectpicker('deselectAll');
                $('.chkTodos').prop('checked',false);
                break;
            case 2:
                $('#cmbTramites').selectpicker('deselectAll');
                $('.chkTodos').prop('checked',false);
                break;
            case 3:
                $('#cmbEdificios').selectpicker('deselectAll');
                $('.chkTodos').prop('checked',false);
                break;
        }
    };

    //Seleccionar todos
    function FN_SELECIONAR_TODOS_PERTECE(area){
        switch(area){
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
    function FN_LIMPIAR_ACCESO(area){
        switch(area){
            case 0:
                $('#cmbDependencias_acceso').selectpicker('deselectAll');
                $('.chkTodosAcceso').prop('checked',false);
                break;
            case 1:
                $('#cmbUnidad_administrativa_acceso').selectpicker('deselectAll');
                $('.chkTodosAcceso').prop('checked',false);
                break;
            case 2:
                $('#cmbTramites_acceso').selectpicker('deselectAll');
                $('.chkTodosAcceso').prop('checked',false);
                break;
            case 3:
                $('#cmbEdificios_acceso').selectpicker('deselectAll');
                $('.chkTodosAcceso').prop('checked',false);
                break;
        }
    };

    //Seleccionar areas acceso todos
    function FN_SELECIONAR_TODOS_ACCESO(area){
        switch(area){
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

    //guardar
    var clickGuardar = 0;
    function TRAM_AJX_CONFIRMAR(){
        TRAM_AJX_GUARDAR();
    };

    function TRAM_AJX_GUARDAR(){
        var objData = {
            txtUsuario: $("#txtUsuario").val(),
            cmbRol: $("#cmbRol").val(),
            txtNombres: $("#txtNombres").val(),
            txtPrimer_Apellido: $("#txtPrimer_Apellido").val(),
            txtSegundo_Apellido: $("#txtSegundo_Apellido").val(),
            txtTelefono: $("#txtTelefono").val(),
            txtExtension: $("#txtExtension").val(),
            txtCorreo_Electronico: $("#txtCorreo_Electronico").val(),
            txtContrasenia: $("#txtContrasenia").val(),
            lstDependenciaPertenece: lstDependencias,
            lstUnidadPertence: lstUnidad_Administrativa,
            lstTramitePertence: lstTramites,
            lstEdificioPertence: lstEdificios,
            lstDependenciaAcceso: lstDependencias_Acceso,
            lstUnidadAcceso: lstUnidad_Administrativa_Acceso,
            lstTramiteAcceso: lstTramites_Acceso,
            lstEdificioAcceso: lstEdificios_Acceso
        };

        $("#btnSubmit").prop("disabled", true);
        if (!$("#frmForm").valid()){

            $(".listError").html('');
            var validator = $('#frmForm').validate();
            var htmlError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";

            $.each(validator.errorList, function (index, value) {
                var campo = $("#"+ value.element.id).attr('placeholder') == undefined ? $("#"+ value.element.id).attr('title') : $("#"+ value.element.id).attr('placeholder');
                if(value.method == "required"){
                    $('.listError').show();
                    htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                }
            });

            if(lstDependencias.length == 0){
                var campo = "Dependencia o entidad";
                htmlError += 'El campo "' + campo + '" es requerido.<br/>';
            }

            if(lstUnidad_Administrativa.length == 0){
                var campo = "Unidad Administrativa";
                htmlError += 'El campo "' + campo + '" es requerido.<br/>';
            }


            if(lstTramites.length == 0){
                var campo = "Trámites";
                htmlError += 'El campo "' + campo + '" es requerido.<br/>';
            }


            if(lstEdificios.length == 0){
                var campo = "Edificios";
                htmlError += 'El campo "' + campo + '" es requerido.<br/>';
            }

            htmlError += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $(".listError").html(htmlError);
            $("#btnSubmit").prop("disabled", false);
            $("html, body").animate({ scrollTop: 0 }, "slow");
            clickGuardar = 0;
            return;
        }


        if(lstDependencias.length == 0 ||lstUnidad_Administrativa.length == 0 || lstTramites.length == 0 || lstEdificios.length == 0){
            var htmlError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";


            if(lstDependencias.length == 0){
                var campo = "Dependencia o entidad";
                htmlError += 'El campo "' + campo + '" es requerido.<br/>';
            }

            if(lstUnidad_Administrativa.length == 0){
                var campo = "Unidad Administrativa";
                htmlError += 'El campo "' + campo + '" es requerido.<br/>';
            }


            if(lstTramites.length == 0){
                var campo = "Trámites que pertenece";
                htmlError += 'El campo "' + campo + '" es requerido.<br/>';
            }


            if(lstEdificios.length == 0){
                var campo = "Edificios que pertenece";
                htmlError += 'El campo "' + campo + '" es requerido.<br/>';
            }

            htmlError += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $(".listError").html(htmlError);
            $("#btnSubmit").prop("disabled", false);
            $("html, body").animate({ scrollTop: 0 }, "slow");
            clickGuardar = 0;

        }else{
            console.log("guardando",objData);


            $.ajax({
                data: objData,
                url: "/servidorespublicos/agregar",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $("#btnSubmit").prop("disabled", false);
                    if(data.status == "success"){
                        $('#frmForm').trigger("reset");
                        $(".listError").html("");

                        clickGuardar = 0;

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
                    }else {

                        clickGuardar = 0;
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
                error: function (data) {
                    clickGuardar = 0;
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
        }


    };

    //Redirige a lista de usuarios
    function TRAM_FN_BACK(){
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
    .dropdown-menu{
        width: 100% !important;
    }
</style>
<script>
</script>

@endsection
