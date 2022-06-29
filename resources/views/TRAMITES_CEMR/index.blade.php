@extends('layout.Layout')
@section('body')
<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12" style="text-align: left;">
                    <h2 class="titulo">Configurar trámite</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header titleCard">
                    <h6 class="subtitulo">Por favor, agregue las secciones que confirman el trámite en el orden en que las deberá visualizar el usuario</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <h4>Configuración del tramite</h4>
                                <hr class="division" />
                            </div>
                            <ul id="section_list" class="sortable-list" style="list-style: none; margin: 0px !important; padding: 0px !important;">
                                <!-- <li id="section_1">
                                    <div class="card_titulo_izquierda">
                                        <span class="circulo_peq cr_activo">
                                            <i class="far fa-folder" aria-hidden="true"></i>
                                        </span>
                                        <div class="titulo_izquierda tit_activo">
                                            <span class="subtitulo_izquierda">Configurar Formulario</span>
                                            <div>
                                                <i class="fa fa-cog fa-2x engrane" aria-hidden="true"></i>
                                                <i class="fa fa-times fa-1x cerrar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li id="section_2">
                                    <div class="card_titulo_izquierda">
                                        <span class="circulo_peq cr_activo">
                                            <i class="far fa-folder" aria-hidden="true"></i>
                                        </span>
                                        <div class="titulo_izquierda tit_activo">
                                            <span class="subtitulo_izquierda">Configurar Formulario</span>
                                            <div>
                                                <i class="fa fa-cog fa-2x engrane" aria-hidden="true"></i>
                                                <i class="fa fa-times fa-1x cerrar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li id="section_3">
                                    <div class="card_titulo_izquierda">
                                        <span class="circulo_peq cr_activo">
                                            <i class="far fa-folder" aria-hidden="true"></i>
                                        </span>
                                        <div class="titulo_izquierda tit_activo">
                                            <span class="subtitulo_izquierda">Configurar Formulario</span>
                                            <div>
                                                <i class="fa fa-cog fa-2x engrane" aria-hidden="true"></i>
                                                <i class="fa fa-times fa-1x cerrar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li> -->
                            </ul>

                            <!-- <div id="section_container">

                                <div class="card_titulo_izquierda">
                                    <span class="circulo_peq cr_activo">
                                        <i class="far fa-folder" aria-hidden="true"></i>
                                    </span>
                                    <div class="titulo_izquierda tit_activo">
                                        <span class="subtitulo_izquierda">Configurar Formulario</span>
                                        <div>
                                            <i class="fa fa-cog fa-2x engrane" aria-hidden="true"></i>
                                            <i class="fa fa-times fa-1x cerrar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="card_titulo_izquierda">
                                    <span class="circulo_peq cr_inactivo">
                                        <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                    </span>
                                    <div class="titulo_izquierda tit_inactivo">
                                        <span class="subtitulo_izquierda">Cita</span>
                                        <div>
                                            <i class="fa fa-cog fa-2x engrane" aria-hidden="true"></i>
                                            <i class="fa fa-times fa-1x cerrar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="card_titulo_izquierda">
                                    <span class="circulo_peq cr_inactivo">
                                        <i class="fas fa-male"></i>
                                    </span>
                                    <div class="titulo_izquierda tit_inactivo">
                                        <span class="subtitulo_izquierda">Ventanilla sin cita</span>
                                        <div>
                                            <i class="fa fa-cog fa-2x engrane" aria-hidden="true"></i>
                                            <i class="fa fa-times fa-1x cerrar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="card_titulo_izquierda">
                                    <span class="circulo_peq cr_inactivo">
                                        <i class="far fa-credit-card" aria-hidden="true"></i>
                                    </span>
                                    <div class="titulo_izquierda tit_inactivo">
                                        <span class="subtitulo_izquierda">Pago</span>
                                        <div>
                                            <i class="fa fa-cog fa-2x engrane" aria-hidden="true"></i>
                                            <i class="fa fa-times fa-1x cerrar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="card_titulo_izquierda">
                                    <span class="circulo_peq cr_inactivo">
                                        <i class="far fa-copy" aria-hidden="true"></i>
                                    </span>
                                    <div class="titulo_izquierda tit_inactivo">
                                        <span class="subtitulo_izquierda">Resolutivo electrónico</span>
                                        <div>
                                            <i class="fa fa-cog fa-2x engrane" aria-hidden="true"></i>
                                            <i class="fa fa-times fa-1x cerrar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> -->




                            <div style="text-align: center;">
                                <a href="javascript:TRAM_FN_MOSTRARMODALSECCION()" class="btn btnAzul btnAgregar">Agregar </a>
                            </div>
                        </div>

                        <div class="col-md-7 col_derecho">

                            <div id="detalle_seccion">



                                <!-- <div class="card_titulo">
                                    <span class="circulo" style="height: 80px;width: 80px;">
                                        <i class="fa fa-calculator"></i>
                                    </span>
                                    <div class="titulo_derecha">
                                        <span class="">Configurar Formulario</span>
                                    </div>
                                </div>

                                {{-- Buscador --}}
                                <div class="box">
                                    <div class="container-1">
                                        <span class="icon"><i class="fa fa-search"></i></span>
                                        <input type="search" id="search" placeholder="Buscar..." />
                                    </div>
                                </div>
                                {{-- Buscador --}}

                                <div class="parrafo">
                                    <p>
                                        <h6 class="negritas">Item 1</h6>
                                        <h6>Pseudo</h6>
                                        Demer message
                                    </p>
                                    <hr class="division_2" />
                                </div>
                                <div class="parrafo">
                                    <p>
                                        <h6 class="negritas">Item 1</h6>
                                        <h6>Pseudo</h6>
                                        Demer message
                                    </p>
                                    <hr class="division_2" />
                                </div>
                                <div class="parrafo">
                                    <p>
                                        <h6 class="negritas">Item 1</h6>
                                        <h6>Pseudo</h6>
                                        Demer message
                                    </p>
                                    <hr class="division_2" />
                                </div> -->

                            </div>

                        </div>
                    </div>

                    <div class="row div_plazos">
                        <div class="col-md-4">
                            <label class="plazos">Plazo máximo de resolucion en días hábiles </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="input_plazas">
                        </div>

                        <div class="col-md-4">
                            <label class="plazos">Plazo máximo en días hábiles para que solicitante atienda notificaciones de tramite</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="input_plazas">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="text-right botones">
                <a href="javascript:void()" class="btn btn-danger border" style="color: #fff; font-weight: 900;">Cancelar </a>
                <a href="#" class="btn btnAzul border">Guardar </a>
                <a href="#" class="btn btnAzul border">Enviar a Enlace Oficial</a>
            </div>
        </div>
    </div>

    <br>
    <br>
</div>
<br />

<!-- Modal -->
<div class="modal fade" id="modalAddSection" tabindex="-1" role="dialog" aria-labelledby="modalAddSectionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddSectionLabel">Agregar Sección</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group" style="width: 100%; margin: 12px;">
                        <label for="cmbSection">Seleccione la sección a agregar</label>
                        <select class="form-control" id="cmbSection">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="TRAM_FN_AGREGARSECCIONLISTA()" type="button" class="btn btnAzul">Agregar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<style>
    .cursor {
        cursor: pointer;
    }

    /* CSS Manuel Euan */
    .titleCard {
        text-align: left;
        background-color: transparent;
        border-bottom: none;
        font-weight: bold;
    }

    .circulo_peq {
        border-radius: 50%;
        -ms-flex-align: center;
        align-items: center;
        display: -ms-flexbox;
        display: flex;
        font-size: 1.875rem;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 70px;
        color: #fff !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24) !important;
    }

    .cr_activo {
        background-color: #33C1FF !important;
    }

    .cr_inactivo {
        background-color: #92D7D7 !important;
    }

    .titulo_izquierda {
        width: 100%;
        height: 40px;
        border-top-right-radius: 60px;
        border-bottom-right-radius: 60px;
        margin-top: 0.7rem;
        margin-left: -2%;
        display: flex;
        align-items: center;
        z-index: -1;
    }

    .tit_activo {
        background-color: #33C1FF;
    }

    .tit_inactivo {
        background-color: #B0B1B1;
    }

    .card_titulo_izquierda {
        border-radius: .25rem;
        background: #fff;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        z-index: 0;
    }

    .subtitulo_izquierda {
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        padding-left: 5%;
        margin-right: auto;
    }

    .engrane {
        color: #E6F1F1;
        margin-left: -80%;
        margin-right: 10px;
    }

    .cerrar {
        font-size: 16px;
        font-weight: bold;
        padding-left: 5%;
        margin-right: auto;
    }

    .division {
        border-width: 2px;
        background: black;
    }

    .col_derecho {
        background-color: #E2E2E2;
        min-height: 700px;
        left: 5%;
    }

    .btnAzul {
        background-color: #37BFFA;
        color: #fff;
        font-weight: 900;
    }

    .btnAgregar {
        width: 30%;
    }

    .botones {
        margin-right: 4%;
    }

    .card_titulo {
        border-radius: .25rem;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 105px;
        padding: .5rem;
        position: relative;
        margin-left: 5%;
        margin-top: 2%;
    }

    .circulo {
        border-radius: 50%;
        -ms-flex-align: center;
        align-items: center;
        display: -ms-flexbox;
        display: flex;
        font-size: 2.875rem;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 70px;
        color: #fff !important;
        background-color: #33C1FF !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24) !important;
    }

    .titulo_derecha {
        margin-top: 1.5% !important;
        font-weight: 700 !important;
        margin-left: 4% !important;
        font-size: 22px;
        font-weight: bold;
    }

    .div_plazos {
        margin-top: 3%;
        padding-left: 50px;
    }

    .blue {
        background-color: #33C1FF;
    }

    .subtitulo {
        color: #212529;
        font-weight: bold;
    }

    .plazos {
        font-weight: bold;
        font-size: 20px;
    }

    .border {
        border-radius: 25px;
    }

    .logo_derecho {
        height: 80px;
        width: 80px;
    }

    .input_plazas {
        width: 80px;
        height: 30px;
        margin-bottom: 16px;
    }

    .parrafo {
        padding-left: 28px;
        padding-bottom: 20px;
    }

    .negritas {
        font-weight: bold;
    }

    .division_2 {
        border-width: 2px;
        background: black;
    }


    /* CSS Buscador */
    .container-1 {
        text-align: center;
    }

    .container-1 input#search {
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

    .container-1 .icon {
        position: absolute;
        top: 20%;
        font-size: 20px;
        margin-left: 17px;
        margin-top: 17px;
        z-index: 1;
        color: #4f5b66;
    }

    .container-1 input#search:hover,
    .container-1 input#search:focus,
    .container-1 input#search:active {
        outline: none;
        background: #ffffff;
    }
</style>

<script type="text/javascript" src="{{ URL::asset('js/citas.js') }}"></script>
<script>
    var sections_default = [{
        value: 1,
        name: "Formulario",
        icon: "far fa-folder",
        view: "TRAM_FN_VIEWFORMULARIO()"
    }, {
        value: 2,
        name: "Revisión de documentación",
        icon: "far fa-folder-open",
        view: "TRAM_FN_VIEWREVISION()"
    }, {
        value: 3,
        name: "Citas en línea",
        icon: "far fa-calendar-alt",
        view: "TRAM_FN_VIEWCITA()"
    }, {
        value: 4,
        name: "Ventanilla sin cita",
        icon: "fas fa-male",
        view: "TRAM_FN_VIEWVENTANILLA()"
    }, {
        value: 5,
        name: "Pago en línea",
        icon: "far fa-credit-card",
        view: "TRAM_FN_VIEWPAGO()"
    }, {
        value: 6,
        name: "Módulo de análisis interno del área",
        icon: "fas fa-cogs",
        view: "TRAM_FN_VIEWANALISISINTERNO()"
    }, {
        value: 7,
        name: "Resolutivo electrónico",
        icon: "far fa-copy",
        view: "TRAM_FN_VIEWRESOLUTIVO()"
    }];

    var list_sections = [];
    var order_section = [];

    $(document).ready(function() {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.sortable-list').sortable({
            connectWith: '.sortable-list',
            update: function(event, ui) {

                var changedList = this.id;
                var order = $(this).sortable('toArray');
                var positions = order.join(';');

                order_section = [];
                var list_sections_tem = [];

                $.when($.each(order, function(i, val) {
                    var item = val.split('_');
                    // order_section.push(parseInt(item[1]));
                    list_sections_tem.push(list_sections[parseInt(item[1])]);
                })).then(function() {
                    list_sections = list_sections_tem;
                    TRAM_FN_RENDERSECCIONES();
                });
            }
        });

        function TRAM_FN_LLENARSELECTSECTION() {

            var cmbSection = $('#cmbSection');

            // Limpiamos el select
            cmbSection.find('option').remove();

            //Opcion por defecto
            cmbSection.append('<option disabled selected>Seleccione</option>');

            $(sections_default).each(function(i, v) { // indice, valor
                cmbSection.append('<option value="' + v.value + '">' + v.name + '</option>');
            })
        }

        function TRAM_FN_AGREGARFORMULARIO() {

            var formulario = {
                "id": 1,
                // "index": 0,
                "name": "Formulario",
                'icon': "far fa-folder",
                "orden": 1,
                "active": true,
                "view": "TRAM_FN_VIEWFORMULARIO()"
            };

            list_sections.push(formulario);

            $('#section_list').html('');
            var divSectionContainer = $('#section_list');

            $(list_sections).each(function(i, v) { // indice, valor
                var cardSection = '<li id="sectionItem_' + i + '">' +
                    '<div class="card_titulo_izquierda">' +
                    '<span class="circulo_peq cr_activo">' +
                    '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                    '</span>' +
                    '<div class="titulo_izquierda tit_activo">' +
                    '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                    '<div>' +
                    '<i onclick="' + v.view + '" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                    '<i onclick="TRAM_FN_ELIMINARSECCIONLISTA(0)" class="fa fa-times fa-1x cerrar cursor" aria-hidden="true"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>';

                divSectionContainer.append(cardSection);
            });
        }

        function TRAM_FN_VIEWFORMULARIO() {
            $.ajax({
                //data: filtro,
                dataType: 'json',
                url: "/gestores/configuracion/seccion_formulario",
                type: "GET",
                success: function(data) {
                    $('#detalle_seccion').html(data);
                },
                error: function(data) {
                    // Swal.fire({
                    //     icon: data.status,
                    //     title: '',
                    //     text: data.message,
                    //     footer: ''
                    // });
                }
            });
        }

        TRAM_FN_LLENARSELECTSECTION();
        TRAM_FN_AGREGARFORMULARIO();
        TRAM_FN_VIEWFORMULARIO();
    });

    function TRAM_FN_MOSTRARMODALSECCION() {
        $('#modalAddSection').modal('show');
    }

    function TRAM_FN_AGREGARSECCIONLISTA() {

        var itemValSeleccionado = $('#cmbSection').val();
        var item = list_sections.find(x => x.id === parseInt(itemValSeleccionado));

        if (typeof item === 'undefined') {

            var sectionNew = sections_default.find(x => x.value === parseInt(itemValSeleccionado));

            list_sections.push({
                id: sectionNew.value,
                // index: list_sections.length,
                name: sectionNew.name,
                icon: sectionNew.icon,
                orden: list_sections.length + 1,
                active: false,
                view: sectionNew.view
            });

            $('#section_list').html('');
            var divSectionContainer = $('#section_list');

            $(list_sections).each(function(i, v) {

                var cr_active = v.active === true ? "cr_activo" : "cr_inactivo";
                var tit_active = v.active === true ? "tit_activo" : "tit_inactivo";

                var cardSection = '<li id="sectionItem_' + i + '">' +
                    '<div class="card_titulo_izquierda">' +
                    '<span class="circulo_peq ' + cr_active + '">' +
                    '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                    '</span>' +
                    '<div class="titulo_izquierda ' + tit_active + '">' +
                    '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                    '<div>' +
                    '<i onclick="' + v.view + '" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                    '<i onclick="TRAM_FN_ELIMINARSECCIONLISTA(' + i + ')" class="fa fa-times fa-1x cerrar cursor" aria-hidden="true"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                '</li>';
                divSectionContainer.append(cardSection);
            });

            $('#modalAddSection').modal('hide');

        } else {
            Swal.fire({
                icon: 'warning',
                title: '¡Sección ya registrada!',
                text: 'Ya se encuentra registrada la sección a la lista, intente con otra sección',
                footer: ''
            });
        }
    }

    function TRAM_FN_ELIMINARSECCIONLISTA(index) {

        list_sections.splice(index, 1);
        TRAM_FN_RENDERSECCIONES();
    }

    function TRAM_FN_RENDERSECCIONES() {

        $('#section_list').html('');
        var divSectionContainer = $('#section_list');

        $(list_sections).each(function(i, v) {

            var cr_active = v.active === true ? "cr_activo" : "cr_inactivo";
            var tit_active = v.active === true ? "tit_activo" : "tit_inactivo";

            var cardSection = '<li id="sectionItem_' + i + '">' +
                '<div class="card_titulo_izquierda">' +
                '<span class="circulo_peq ' + cr_active + '">' +
                '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                '</span>' +
                '<div class="titulo_izquierda ' + tit_active + '">' +
                '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                '<div>' +
                '<i onclick="' + v.view + '" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                '<i onclick="TRAM_FN_ELIMINARSECCIONLISTA(' + i + ')" class="fa fa-times fa-1x cerrar cursor" aria-hidden="true"></i>' +
                '</div>' +
                '</div>' +
                '</div>';
            '</li>';

            divSectionContainer.append(cardSection);
        });
    }

    function TRAM_FN_VIEWFORMULARIO() {
        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_formulario",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);
            },
            error: function(data) {
                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });
    }

    function TRAM_FN_VIEWREVISION() {
        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_revision",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);
            },
            error: function(data) {
                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });
    }

    function TRAM_FN_VIEWCITA() {
        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_cita",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);
            },
            error: function(data) {
                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });
    }

    function TRAM_FN_VIEWVENTANILLA() {
        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_ventanilla",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);
            },
            error: function(data) {
                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });
    }

    function TRAM_FN_VIEWPAGO() {
        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_pago",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);
            },
            error: function(data) {
                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });
    }

    function TRAM_FN_VIEWANALISISINTERNO() {
        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_analisis_interno",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);
            },
            error: function(data) {
                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });
    }

    function TRAM_FN_VIEWRESOLUTIVO() {
        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_resolutivo",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);
            },
            error: function(data) {
                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });
    }

    var tramite = {
        edificios: []
    };

    function TRAM_FN_AGREGAREDIFICIO(values) {

        tramite.edificios = [];
        $('#list_edificios').html('');

        $.each(values, function(key, value) {
            tramite.edificios.push(value);
            $('#list_edificios').append('<li class="list-group-item">' + value + '</li>');
        });
    }
</script>
@endsection
