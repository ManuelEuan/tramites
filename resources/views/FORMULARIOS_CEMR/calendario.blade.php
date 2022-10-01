
@extends('layout.Layout')
@section('body')

<!-- <%-- Contenido individual --%> -->
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-md-12">
                <h2>Días Inhábiles</h2>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card col-md-12">
                <div class="card-body col-md-12 row">
                    <div class="col-md-12">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Día Inhábil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_dias" class="needs-validation" novalidate>
                            <input type="text" style="display: none;" id="id">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha">Fecha Inicial</label>
                                    <input type="date" class="form-control" id="fechaInicial" name='fechaInicial' placeholder="Inicio" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha">Fecha Final</label>
                                    <input type="date" class="form-control" id="fechaFinal" name='fechaInicial' placeholder="Final" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" required autocomplete="off">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="color">Color</label>
                                    <select id="color" class="form-control">
                                        <option value="#1FBEF2" selected>Azul</option>
                                        <option value="#F7391B" >Rojo</option>
                                        <option value="#11EE0A">Verde</option>
                                        <option value="#F79D22">Naranja</option>
                                        <option value="#FC08E2">Morado</option>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="color">Dependencias</label>
                                    <select id="dependencias" class="selectpicker form-control selectCatalogos" data-live-search="true" multiple>
                                        @foreach ($filtros['dependencias'] as $dependencia)
                                            <option value="{{$dependencia->iId}}"> {{$dependencia->name}}</option>;
                                        @endforeach
                                     </select>
                                     <br><br>
                                    <input type="checkbox" name="allDependencia" id="allDependencia"> <label for="">Seleccionar todo</label>
                                </div>
                            </div>
                            <button style="display: none;" id="btnSubmit" type="submit">Submit form</button>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btnModal" onclick="eliminar();" data-dismiss="modal" id="btnCerrarModal">Cancelar</button>
                        <button type="button" class="btn btn-success btnModal" onclick="guardarFormulario();" id="btnGuardarModal">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/locales-all.js"></script>

    <script>
        var validacion  = false;
        var accionGuar  = 'add';
        var calendar    = null;

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    right: 'prev,next',
                    center: 'title',
                    left: 'Miboton'
                },
                customButtons:{
                    Miboton:{
                        text: "Nuevo",
                        click:function(){
                            $('#exampleModalCenter').modal('toggle');
                            limpiaCampos();
                        }
                    }
                },
                locale: 'es',
                navLinks: false, // can click day/week names to navigate views
                selectable: false,
                selectMirror: true,
                dateClick: function(arg) {
                    abreModal( arg, 'add');
                    return;
                },
                eventClick: function(arg) {
                    abreModal( arg, 'update');
                },
                editable: false,
                dayMaxEvents: true, // allow "more" link when too many events
                events: "{{ url('/dias_inhabiles/find')}}"
            });

            calendar.render();

            $(".selectCatalogos").selectpicker({
                noneSelectedText: 'Seleccionar',
            });
        });

        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    else{
                        event.preventDefault();
                        validacion = true;
                        /* $("#btnGuardarModal").text("");
                        $("#btnGuardarModal").append(`
                            <div id="spinnerGuardar" class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div> `);
                        $("#btnCerrarModal").prop('disabled', true);
                        $("#btnGuardarModal").prop('disabled', true); */
                    }
                    form.classList.add('was-validated');
                }, false);
                });
            }, false);
        })();

        function abreModal(data, accion = 'add') {
            limpiaCampos();
            accionGuar = accion;

            if(accion == 'add' ){
                $('#fechaInicial').val(data.dateStr);
                $('#fechaFinal').val(data.dateStr);
            }
            else{
                let color = data.event.extendedProps.colores;
                console.log(data.event.extendedProps.colores);
                $('#exampleModalCenter').modal('toggle');
                $("#id").val(data.event.id);
                $("#nombre").val(data.event.title);
                $("#color option[value="+color+"]").attr('selected', 'selected');
                $("#fechaInicial").val(data.event._def.extendedProps.starStr);
                $("#fechaFinal").val(data.event._def.extendedProps.endStr);
                $("#btnGuardarModal").text("Actualizar");
                $("#btnCerrarModal").text("Eliminar");

                //Selecciono las opciones anteriores
                let ids     = data.event.extendedProps.dependencias;
                let array   = ids.split(",");
                let nombres = [];

                array.forEach(element => {
                    $("#dependencias option[value="+ element +"]").attr("selected", true);
                });

                $('select').selectpicker('render');
            }
            console.log(accion);
            $('#exampleModalCenter').modal('toggle');
        }

        function messageError(mensaje='') {
            Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                });
        }

        function guardarFormulario(){
            $("#btnSubmit").click();
            console.log(accionGuar);
            if(validacion == false){
                return;
            }

            //Valido que las fechas sean correctas
            let init = new Date($("#fechaInicial").val());
            let finish = new Date($("#fechaFinal").val());
            if(init > finish){
                messageError("La fecha inicial no puede ser mayor a la final.");
                return;
            }

            //Valido las dependencias
            let all = $("#allDependencia").prop('checked');
            let dependencias = $("#dependencias").val();

            if( dependencias == null &&  all == false){
                messageError("Es requerido seleccionar mínimo una dependencia.");
                return;
            }

            dependencias    = dependencias == null ? null : dependencias.toString();
            let url         = "/dias_inhabiles/store";
            let data        = {
                    "id"        : $("#id").val(),
                    "nombre"    : $("#nombre").val(),
                    "color"     : $("#color option:selected").val(),
                    "all"       : all,
                    "fecha_inicio"  : $("#fechaInicial").val(),
                    "fecha_final"   : $("#fechaFinal").val(),
                    "dependencias"  : dependencias
            };

            if(accionGuar == 'update'){
                url = "/dias_inhabiles/update";
            }

            $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            request = $.ajax({
                url : url,
                type: "post",
                data: data
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
                limpiaCampos();
                setTimeout(() => {
                    $("#btnCerrarModal").click();
                    calendar.refetchEvents();

                    Swal.fire({
                        icon: 'success',
                        title: 'Operación exitosa',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }, 300);
            });

            // Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                messageError('se presento el siguiente error: ' + errorThrown);
                limpiaCampos();
            });
        }

        function eliminar(){
            if(accionGuar != 'update'){
                return;
            }

            Swal.fire({
                title: '¿Esta seguro de realizar la operación?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed){
                    let url = "/dias_inhabiles/delete";
                    $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    request = $.ajax({
                        url: url,
                        type: "post",
                        data: {"id": $("#id").val()}
                    });

                    request.done(function (response, textStatus, jqXHR){
                        limpiaCampos();
                        calendar.refetchEvents();

                        Swal.fire({
                            icon: 'success',
                            title: 'Operación exitosa',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'se presento el siguiente error: ' + errorThrown
                        });
                    });
                }
            });
        }

        function limpiaCampos(){
            validacion  = false;
            accionGuar  = "add";

            $("#frm_dias").removeClass("was-validated");
            $("#formulario").removeClass("was-validated");
            $("#id").val("");
            $("#nombre").val("");
            $("#fechaInicial").val("");
            $("#fechaFinal").val("");
            $("#color option[value='#1FBEF2']").attr('selected', 'selected');
            /* $("#dependencias").val(""); */
            $('#dependencias').selectpicker('deselectAll');
            $("#btnCerrarModal").prop('disabled', false);
            $("#btnGuardarModal").prop('disabled', false);
            $('#myCheckbox').prop('checked', false);
            $("#btnGuardarModal").text("Guardar");
            $("#btnCerrarModal").text("Cancelar");
            $("#spinnerGuardar").remove();

        }
    </script>
@endsection

<style>

    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }
    .fc-event-title-container{
        font-size: 12px;
        text-transform: uppercase;
        font-family: Arial, Helvetica, sans-serif;
    }







    /* CSS Buscador */
    .container-1{
        text-align: center;
    }

    .container-1 input#search{
        width: 87%;
        height: 50px;
        font-size: 10pt;
        float: center;
        color: #63717f;
        padding-left: 5%;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 60px;
    }
    .container-1 .icon{
        position: absolute;
        top: 20%;
        font-size: 20px;
        margin-left: 17px;
        margin-top: 17px;
        z-index: 1;
        color: #4f5b66;
    }

    .container-1 input#search:hover, .container-1 input#search:focus, .container-1 input#search:active{
        outline:none;
        background: #ffffff;
    }

</style>
