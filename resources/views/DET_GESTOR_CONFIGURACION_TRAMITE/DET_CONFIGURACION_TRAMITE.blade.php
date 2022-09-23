@extends('layout.Layout')
@section('body')
<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12" style="text-align: left;">
                    <h2 class="titulo">Ver configuración de trámite</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header titleCard">
                    <div class="row">
                        <div class="col-md-12" style="text-align: left;">
                            <h2 style="color: #007bff;" class="titulo">{{$tramite['ACCE_NOMBRE_TRAMITE']}}</h2>
                            <h6 style="color:#33c1ff; font-weight:bold;">{{$tramite['ACCE_CLAVE_INTERNA']}}</h6>
                        </div>
                    </div>
                    <br>
                    <h6 class="subtitulo">Por favor, agregue las secciones que confirman el trámite en el orden en que las deberá visualizar el usuario</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <h4>Configuración del tramite</h4>
                                <hr class="division" />
                            </div>
                            <div style="max-height: 860px; overflow-y: auto; overflow-x: hidden;">
                                <ul id="section_formulario" style="list-style: none; margin: 0px !important; padding: 0px !important;">
                                </ul>
                                <ul id="section_list" class="sortable-list" style="list-style: none; margin: 0px !important; padding: 0px !important;">
                                </ul>
                            </div>
                            <div style="text-align: center; margin-top:15px; margin-bottom:15px;">
                                <a href="javascript:TRAM_FN_MOSTRARMODALSECCION()" class="btn btn-sm btnAzul btnAgregar">Agregar</a>
                            </div>
                            <!-- <div style="text-align: center;">
                                <a href="javascript:TRAM_FN_MOSTRARMODALSECCION()" class="btn btnAzul btnAgregar">Agregar </a>
                            </div> -->
                        </div>
                        <div class="col-md-7 col_derecho">
                            <div id="detalle_seccion">
                            </div>
                        </div>
                    </div>
                    <div class="row div_plazos">
                        <div class="col-md-4">
                            <label class="plazos">Plazo máximo de resolución en días hábiles </label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="0" id="txtPlazo_diasResolucion" class="input_plazas">
                        </div>
                        <div class="col-md-4">
                            <label class="plazos">Plazo máximo en días hábiles para que solicitante atienda notificaciones de trámite</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="0" id="txtPlazo_diasNotificacion" class="input_plazas">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="text-right botones">
                <a href="{{route('gestor_index')}}" class="btn btn-danger border" style="color: #fff; font-weight: 900;">Cancelar</a>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>
<br />

<div id="loading_save" class="loadingFrame" class="text-center" style="display: none !important;">
    <div class="inner">
        <div class="spinner-grow text-secondary" role="status">

        </div>
        <p style="color: #393939 !important;">Guardando Configuración...</p>
    </div>
</div>


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

    #searchDocumento {
        background-image: url("{{ asset('assets/template/img/searchicon.png') }}");
        background-position: 10px 12px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }

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
        padding-right: 1rem;
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
        padding-right: 1.4rem;
    }

    .parrafo_formulario {
        padding-left: 28px;
        padding-bottom: 20px;
        padding-right: 1.4rem;
        height: 600px;
        overflow-y: scroll;
        overflow-x: hidden;
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
        font-size: 20px;
        margin-left: 1rem;
        margin-top: 10px;
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

<script>
    var tramite_ = null;
    var nombre_tramite = "{{$tramite['ACCE_NOMBRE_TRAMITE']}}";
    var section_formulario_default = {
        value: 1,
        name: "Formulario",
        icon: "far fa-folder",
        view: "TRAM_FN_VIEWFORMULARIO();"
    };

    var sections_default = [{
        value: 2,
        name: "Revisión de documentación",
        icon: "far fa-folder-open",
        view: "TRAM_FN_VIEWREVISION();"
    }, {
        value: 3,
        name: "Citas en línea",
        icon: "far fa-calendar-alt",
        view: "TRAM_FN_VIEWCITA();"
    }, {
        value: 4,
        name: "Ventanilla sin cita",
        icon: "fas fa-male",
        view: "TRAM_FN_VIEWVENTANILLA();"
    }, {
        value: 5,
        name: "Pago en línea",
        icon: "far fa-credit-card",
        view: "TRAM_FN_VIEWPAGO();"
    }, {
        value: 6,
        name: "Módulo de análisis interno del área",
        icon: "fas fa-cogs",
        view: "TRAM_FN_VIEWANALISISINTERNO();"
    }, {
        value: 7,
        name: "Resolutivo electrónico",
        icon: "far fa-copy",
        view: "TRAM_FN_VIEWRESOLUTIVO();"
    }];

    /**** Variables Globales *****/
    var list_default_documentos = [];
    var list_formularios = [];
    var list_conceptos_tramite = [];
    var list_conceptos_temporal = [];

    //Variables de configuracion
    var list_sections = [];
    var order_section = [];
    var edificios = [];
    var resolutivos = [];
    var list_conceptos = [];

    var id_formulario = 0;
    var list_documentos = [];
    var dias_habiles = 0;
    var textVentanilla = "";
    var textCita = "";

    //Index Seccion
    var _index = 0;

    var objTramite = {
        TRAM_NIDTRAMITE_ACCEDE: 0,
        TRAM_NIDTRAMITE_CONFIG: 0,
        TRAM_NDIASHABILESRESOLUCION: 0,
        TRAM_NDIASHABILESNOTIFICACION: 0,
        TRAM_NIMPLEMENTADO: 0,
        TRAM_NENLACEOFICIAL: 0,
        TRAM_LIST_SECCION: [], //
        TRAM_LIST_FORMULARIO: [],
        TRAM_LIST_DOCUMENTO: [],
        TRAM_LIST_EDIFICIO: [],
        TRAM_LIST_RESOLUTIVO: [],
        TRAM_LIST_CONCEPTOS_PAGO: [], //
        TRAM_LIST_SECCIONES: []
    };

    var objSeccion = {
        CONF_NID: 0,
        CONF_NIDTRAMITE: 0,
        CONF_NSECCION: 'Formulario',
        CONF_CNOMBRESECCION: "",
        CONF_ESTATUSSECCION: true,
        CONF_NDIASHABILES: null,
        CONF_CDESCRIPCIONCITA: null,
        CONF_CDESCRIPCIONVENTANILLA: null,
        CONF_NORDEN: 1,
        CONF_LIST_EDIFICIO: [],
        CONF_LIST_PAGO: [],
        CONF_LIST_RESOLUTIVO: []
    };

    $(document).ready(function() {

        $(".btnAgregar").hide();
        $("#txtPlazo_diasResolucion").prop("disabled", true);
        $("#txtPlazo_diasNotificacion").prop("disabled", true);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Funcion para reordenar lista de secciones
        /* $('.sortable-list').sortable({
            connectWith: '.sortable-list',
            update: function(event, ui) {

                var changedList = this.id;
                var order = $(this).sortable('toArray');
                var positions = order.join(';');

                order_section = [];
                var list_sections_tem = [];
                list_sections_tem.push(list_sections[0]);

                $.when($.each(order, function(i, val) {
                    var item = val.split('_');
                    // order_section.push(parseInt(item[1]));
                    list_sections[parseInt(item[1])].orden = i + 1;
                    list_sections_tem.push(list_sections[parseInt(item[1])]);
                })).then(function() {
                    list_sections = list_sections_tem;
                    TRAM_FN_RENDERSECCIONES();
                });
            }
        }); */

        //Funcion para llenar select de secciones
        function TRAM_FN_LLENARSELECTSECTION() {

            var cmbSection = $('#cmbSection');
            cmbSection.find('option').remove();
            cmbSection.append('<option disabled selected>Seleccione</option>');
            $(sections_default).each(function(i, v) {
                cmbSection.append('<option value="' + v.value + '">' + v.name + '</option>');
            })
        }

        //Funcion para agregar la seccion de formulario
        function TRAM_FN_AGREGARFORMULARIO() {

            var formulario = {
                "id": 1,
                "name": "Formulario",
                'icon': "far fa-folder",
                "orden": 1,
                "active": true,
                "view": "TRAM_FN_VIEWFORMULARIO();",
                "dias_habiles": 0,
                "descripcion_cita": "",
                "descripcion_ventanilla": "",
                "list_formulario": [],
                "list_documento": [],
                "list_edificios": [],
                "list_pago": [],
                "list_resolutivo": [],
            };

            list_sections.push(formulario);

            $('#section_formulario').html('');
            var divSectionContainer = $('#section_formulario');

            var cardSection = '<li id="sectionItem_0">' +
                '<div class="card_titulo_izquierda">' +
                '<span class="circulo_peq cr_activo">' +
                '<i class="' + formulario.icon + '" aria-hidden="true"></i>' +
                '</span>' +
                '<div class="titulo_izquierda tit_activo">' +
                '<span class="subtitulo_izquierda">' + formulario.name + '</span>' +
                '<div>' +
                '<i onclick="' + formulario.view + ' TRAM_FN_SELECCIONARSECCION(0);" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</li>';

            divSectionContainer.append(cardSection);
        }

        //Funcion ajax para obtener documentos necesarios de tramite
        function TRAM_AJX_OBTENER_DOCUMENTO_TRAMITE(list_document_select) {

            var IntTramite = "{{request()->route('tramiteID') }}";

            $.ajax({
                dataType: 'json',
                url: "/gestores/consultar_documento_tramite/" + IntTramite + "",
                type: "GET",
                success: function(response) {

                    var list_temporal_documentos = [];

                    //Guardar y marcar documentos en variable temporal
                    $.each(response.data, function(i, v) {

                        var document = list_document_select.find(x => x.TRAD_NIDDOCUMENTO === v.ACCE_NIDDOCUMENTO);
                        var item;

                        if (typeof document !== "undefined") {

                            item = {
                                TRAD_NIDTRAMITE: 0,
                                TRAD_NIDDOCUMENTO: document.TRAD_NIDDOCUMENTO,
                                TRAD_CNOMBRE: document.TRAD_CNOMBRE,
                                TRAD_CDESCRIPCION: document.TRAD_CDESCRIPCION,
                                TRAD_CEXTENSION: document.TRAD_CEXTENSION,
                                TRAD_NOBLIGATORIO: document.TRAD_NOBLIGATORIO == 1 ? true : false,
                                TRAD_NMULTIPLE: document.TRAD_NMULTIPLE == 1 ? true : false,
                                TRAD_SELECT: true,
                            };
                        } else {
                            item = {
                                TRAD_NIDTRAMITE: 0,
                                TRAD_NIDDOCUMENTO: v.ACCE_NIDDOCUMENTO,
                                TRAD_CNOMBRE: v.ACCE_CNOMBRE,
                                TRAD_CDESCRIPCION: v.ACCE_CDESCRIPCION,
                                TRAD_CEXTENSION: v.ACCE_CEXTENSION,
                                TRAD_NOBLIGATORIO: true,
                                TRAD_NMULTIPLE: false,
                                TRAD_SELECT: false,
                            };
                        }
                        list_temporal_documentos.push(item);
                    });

                    ///////////////////////////////

                    //Almacenar en variable global los documentos ya seleccionados
                    if (list_temporal_documentos.length > 0) {

                        $.each(list_temporal_documentos, function(i, v) {
                            if (v.TRAD_SELECT === true) {
                                list_default_documentos.push(v);
                            }
                        });
                    }
                },
                error: function(data) {

                }
            });
        }

        //Funcion para obtener conceptos del pago del tramite
        function TRAM_AJX_OBTENER_CONCEPTO_PAGO_TRAMITE() {

            var TRAM_NIDTRAMITE_ACCEDE = "{{request()->route('tramiteID') }}";
            $.ajax({
                dataType: 'json',
                url: "/gestores/consultar_concepto_pago/" + TRAM_NIDTRAMITE_ACCEDE,
                type: "GET",
                success: function(data) {

                    list_conceptos_tramite = [];

                    if (data.codigo === 200) {
                        list_conceptos_tramite = data.data;
                        // if (list_conceptos_temporal.length > 0) {
                        //     $.each(list_conceptos_temporal, function(key, value) {
                        //         var item = list_conceptos_tramite.find(x => parseInt(x.ID) === parseInt(value.CONC_NIDCONCEPTO));
                        //         if (typeof item !== 'undefined') {
                        //             list_conceptos.push(item);
                        //         }
                        //     });
                        // }
                    }
                },
                error: function(data) {}
            });
        }

        //Funcion para mostrar vista configuracion formulario
        function TRAM_FN_VIEWFORMULARIO() {
            $.ajax({
                dataType: 'json',
                url: "/gestores/configuracion/seccion_formulario",
                type: "GET",
                success: function(data) {

                    $('#detalle_seccion').html(data);

                    //Ocultar barra busqueda y agregar formulario. Cambiamos texto de btn de documentos
                    $("#boxSearchAddFormulario").hide();
                    $("#divSearchDocumento").hide();
                    $("#btnAddDocumento").html("Ver documentos");

                    setTimeout(function() {

                        $('#listFormulario').html('');
                        var divSectionContainer = $('#listFormulario');

                        //Agregar el formulario ya seleccionado
                        if (list_formularios.length > 0) {

                            var formularioSelect = list_formularios.find(x => x.FORM_NIDFORMULARIO === id_formulario);

                            if (typeof formularioSelect !== 'undefined') {

                                var activo_ = formularioSelect.total > 0 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-secondary">Inactivo</span>';
                                var check = "checked";

                                var itemFormulario = '<div class="row">' +
                                    '<div class="col-10">' +
                                    '<p>' +
                                    '<h6 class="negritas">' + formularioSelect.FORM_CNOMBRE + '</h6>' +
                                    '<h6>' + activo_ + '</h6>' +
                                    '' + formularioSelect.FORM_CDESCRIPCION + '' +
                                    '</p>' +
                                    '<p style="margin-bottom: 0px; color:#6f6d6d;">Última edición: ' + formularioSelect.FORM_DFECHA + '</p>' +
                                    '</div>' +
                                    '<div class="col-2" style="align-items: center; display: flex; justify-content: center;">' +
                                    '<div class="form-group">' +
                                    '<div class="form-check">' +
                                    '<input ' + check + ' data-formulario="' + formularioSelect.FORM_NIDFORMULARIO + '" style="width: 1.4rem; height: 1.4rem;" class="form-check-input checkItemFormulario" type="checkbox">' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<hr class="division_2" />';

                                divSectionContainer.append(itemFormulario);
                            }
                        }
                    }, 100);
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

        //Funcion ajax para obtener formularios activos
        function TRAM_AJX_OBTENER_FORMULARIOS() {

            $.ajax({
                dataType: 'json',
                url: "/gestores/consultar_formulario",
                type: "GET",
                success: function(response) {

                    list_formularios = response.data;

                    //Cargar formulario
                    setTimeout(function() {
                        TRAM_FN_VIEWFORMULARIO();
                    }, 250);
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

        /***** Cargar Configuración de Tramite Guardado *****/

        //Agregar secciones de tramite guardado y su configuraciones
        function TRAM_FN_AGREGAR_SECCION(list_section_tramite) {

            $.each(list_section_tramite, function(index, value) {

                if (value.CONF_NSECCION === "Formulario") {

                    var formulario = {
                        "id": 1,
                        "name": "Formulario",
                        'icon': "far fa-folder",
                        "orden": 1,
                        "active": true,
                        "view": "TRAM_FN_VIEWFORMULARIO();",
                        "dias_habiles": 0,
                        "descripcion_cita": "",
                        "descripcion_ventanilla": "",
                        "list_formulario": tramite_.formularios,
                        "list_documento": tramite_.documentos,
                        "list_edificios": [],
                        "list_pago": [],
                        "list_resolutivo": [],
                    };
                    list_sections.push(formulario);

                } else {

                    var sectionNew = sections_default.find(x => x.name === value.CONF_NSECCION);

                    var _edificios = sectionNew.value === 4 ? tramite_.edificios.filter(x => x.EDIF_NIDSECCION === null || parseInt(x.EDIF_NIDSECCION) === parseInt(value.CONF_NIDCONFIGURACION)) : [];
                    var _pago = sectionNew.value === 5 ? tramite_.conceptos_pago.filter(x => x.CONC_NIDSECCION === null || parseInt(x.CONC_NIDSECCION) === parseInt(value.CONF_NIDCONFIGURACION)) : [];
                    var _resolutivo = sectionNew.value === 7 ? tramite_.resolutivos.filter(x => x.RESO_NIDSECCION === null || parseInt(x.RESO_NIDSECCION) === parseInt(value.CONF_NIDCONFIGURACION)) : [];

                    list_sections.push({
                        id: sectionNew.value,
                        name: sectionNew.name,
                        icon: sectionNew.icon,
                        orden: index + 1,
                        active: false,
                        view: sectionNew.view,
                        dias_habiles: value.CONF_NDIASHABILES,
                        descripcion_cita: value.CONF_CDESCRIPCIONCITA,
                        descripcion_ventanilla: value.CONF_CDESCRIPCIONVENTANILLA,
                        list_formulario: [],
                        list_documento: [],
                        list_edificios: _edificios,
                        list_pago: _pago,
                        list_resolutivo: _resolutivo,
                    });
                }
            });

            //Contenedor de lista Sortable
            $('#section_list').html('');
            var divSectionContainer = $('#section_list');

            $(list_sections).each(function(i, v) {

                var cr_active = v.active === true ? "cr_activo" : "cr_inactivo";
                var tit_active = v.active === true ? "tit_activo" : "tit_inactivo";

                //switch secciones
                var click_view = "";
                switch (parseInt(v.id)) {
                    case 1:
                        click_view = "TRAM_FN_VIEWFORMULARIO(" + i + ");";
                        break;
                    case 2:
                        click_view = "TRAM_FN_VIEWREVISION(" + i + ");";
                        break;
                    case 3:
                        click_view = "TRAM_FN_VIEWCITA(" + i + ");";
                        break;
                    case 4:
                        click_view = "TRAM_FN_VIEWVENTANILLA(" + i + ");";
                        break;
                    case 5:
                        click_view = "TRAM_FN_VIEWPAGO(" + i + ");";
                        break;
                    case 6:
                        click_view = "TRAM_FN_VIEWANALISISINTERNO(" + i + ");";
                        break;
                    case 7:
                        click_view = "TRAM_FN_VIEWRESOLUTIVO(" + i + ");";
                        break;
                    default:
                        click_view = "";
                        break;
                }

                //Agregamos formulario a su contenedor en la lista
                if (i === 0) {

                    $('#section_formulario').html('');
                    var divSectionContainerFormulario = $('#section_formulario');

                    var cardSection = '<li id="sectionItem_' + i + '">' +
                        '<div class="card_titulo_izquierda">' +
                        '<span class="circulo_peq ' + cr_active + '">' +
                        '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                        '</span>' +
                        '<div class="titulo_izquierda ' + tit_active + '">' +
                        '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                        '<div>' +
                        '<i onclick="' + click_view + ' TRAM_FN_SELECCIONARSECCION(' + i + ');" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</li>';

                    divSectionContainerFormulario.append(cardSection);
                    return true;
                }

                //Agregamos resto de secciones
                var cardSection = '<li id="sectionItem_' + i + '">' +
                    '<div class="card_titulo_izquierda">' +
                    '<span class="circulo_peq ' + cr_active + '">' +
                    '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                    '</span>' +
                    '<div class="titulo_izquierda ' + tit_active + '">' +
                    '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                    '<div>' +
                    '<i onclick="' + click_view + ' TRAM_FN_SELECCIONARSECCION(' + i + ');" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>';

                divSectionContainer.append(cardSection);
            });
        }

        //Funcion ajax para obtener datos de tramite en caso de haber
        function TRAM_AJX_OBTENER_TRAMITE() {

            var id_tramite_config = "{{request()->route('tramiteIDConfig') }}";

            if (id_tramite_config > 0) {

                $.ajax({
                    dataType: 'json',
                    url: "/gestores/consultar_configuracion_tramite/" + id_tramite_config + "",
                    type: "GET",
                    success: function(response) {

                        // list_conceptos = [];
                        // list_conceptos_temporal = [];

                        // if (response.conceptos_pago.length > 0) {
                        //     list_conceptos_temporal = response.conceptos_pago;
                        // }

                        tramite_ = response;
                        id_formulario = tramite_.formularios[0].FORM_NIDFORMULARIO;
                        TRAM_FN_AGREGAR_SECCION(tramite_.secciones);
                        TRAM_AJX_OBTENER_DOCUMENTO_TRAMITE(tramite_.documentos);

                        $('#txtPlazo_diasResolucion').val(tramite_.tramite[0].TRAM_NDIASHABILESRESOLUCION);
                        $('#txtPlazo_diasNotificacion').val(tramite_.tramite[0].TRAM_NDIASHABILESNOTIFICACION);
                    },
                    error: function(data) {

                    }
                });

            } else {
                var list_tramites_documentos_temp = [];
                TRAM_FN_AGREGARFORMULARIO();
                TRAM_AJX_OBTENER_DOCUMENTO_TRAMITE(list_tramites_documentos_temp);
            }
        }

        //Nuevo
        TRAM_AJX_OBTENER_TRAMITE();
        TRAM_FN_LLENARSELECTSECTION();
        TRAM_AJX_OBTENER_FORMULARIOS();
        TRAM_AJX_OBTENER_CONCEPTO_PAGO_TRAMITE();

        //Funcion para guardar el ID del formulario seleccionado
        $(document).on('click', '.checkItemFormulario', function() {

            if ($(this).is(":checked")) {

                var FormularioIDCheck = $(this).data("formulario");

                $(".checkItemFormulario").each(function() {

                    if ($(this).data("formulario") === FormularioIDCheck) {
                        id_formulario = FormularioIDCheck;
                    } else {
                        $(this).prop('checked', false);
                    }
                });
            } else {
                var FormularioIDCheck = $(this).data("formulario");
                if (FormularioIDCheck === id_formulario) {
                    id_formulario = 0;
                }
            }
        });

        //Funcion para marcar los documentos seleccionados
        $(document).on('click', '.checkDocumento', function() {

            if ($(this).is(":checked")) {
                var DocumentoIDCheck = $(this).data("documento");
                var documento = list_default_documentos.find(x => x.TRAD_NIDDOCUMENTO === DocumentoIDCheck);
                documento.TRAD_SELECT = true;
            } else {
                var DocumentoIDCheck = $(this).data("documento");
                var documento = list_default_documentos.find(x => x.TRAD_NIDDOCUMENTO === DocumentoIDCheck);
                documento.TRAD_SELECT = false;
            }
        });

        //Funcion para marcar los documentos obligatorios
        $(document).on('click', '.checkDocumentoObligatorio', function() {

            if ($(this).is(":checked")) {
                var DocumentoIDCheck = $(this).data("documento");
                var documento = list_default_documentos.find(x => x.TRAD_NIDDOCUMENTO === DocumentoIDCheck);
                documento.TRAD_NOBLIGATORIO = true;
            } else {
                var DocumentoIDCheck = $(this).data("documento");
                var documento = list_default_documentos.find(x => x.TRAD_NIDDOCUMENTO === DocumentoIDCheck);
                documento.TRAD_NOBLIGATORIO = false;
            }
        });

        //Funcion para marcar los documentos subida multiple
        $(document).on('click', '.checkDocumentoMultiple', function() {

            if ($(this).is(":checked")) {
                var DocumentoIDCheck = $(this).data("documento");
                var documento = list_default_documentos.find(x => x.TRAD_NIDDOCUMENTO === DocumentoIDCheck);
                documento.TRAD_NMULTIPLE = true;
            } else {
                var DocumentoIDCheck = $(this).data("documento");
                var documento = list_default_documentos.find(x => x.TRAD_NIDDOCUMENTO === DocumentoIDCheck);
                documento.TRAD_NMULTIPLE = false;
            }
        });

        //Funcion para cambiar valor de días habiles - Revision de documentacion
        $(document).on('change paste', '.numDiasHabiles', function() {

            var section = list_sections[_index];
            if ($(this).val() > 0) {
                dias_habiles = parseInt($(this).val());
                $(this).val(parseInt($(this).val()));
                section.dias_habiles = dias_habiles;
            } else {
                dias_habiles = 0;
                $(this).val(0)
                section.dias_habiles = dias_habiles;
            }
        });
    });

    function TRAM_FN_MOSTRARMODALSECCION() {
        $('#modalAddSection').modal('show');
    }

    //Agregar seccion a lista de secciones
    function TRAM_FN_AGREGARSECCIONLISTA() {

        var itemValSeleccionado = $('#cmbSection').val();
        var item = list_sections.find(x => x.id === parseInt(itemValSeleccionado));

        if (true) {

            var sectionNew = sections_default.find(x => x.value === parseInt(itemValSeleccionado));
            list_sections.push({
                id: sectionNew.value,
                name: sectionNew.name,
                icon: sectionNew.icon,
                orden: list_sections.length,
                active: false,
                view: sectionNew.view,
                dias_habiles: 0,
                descripcion_cita: "",
                descripcion_ventanilla: "",
                list_formulario: [],
                list_documento: [],
                list_edificios: [],
                list_pago: [],
                list_resolutivo: []
            });

            //Contenedor de lista Sortable
            $('#section_list').html('');
            var divSectionContainer = $('#section_list');

            $(list_sections).each(function(i, v) {

                var cr_active = v.active === true ? "cr_activo" : "cr_inactivo";
                var tit_active = v.active === true ? "tit_activo" : "tit_inactivo";

                //switch secciones
                var click_view = "";
                switch (parseInt(v.id)) {
                    case 1:
                        click_view = "TRAM_FN_VIEWFORMULARIO(" + i + ");";
                        break;
                    case 2:
                        click_view = "TRAM_FN_VIEWREVISION(" + i + ");";
                        break;
                    case 3:
                        click_view = "TRAM_FN_VIEWCITA(" + i + ");";
                        break;
                    case 4:
                        click_view = "TRAM_FN_VIEWVENTANILLA(" + i + ");";
                        break;
                    case 5:
                        click_view = "TRAM_FN_VIEWPAGO(" + i + ");";
                        break;
                    case 6:
                        click_view = "TRAM_FN_VIEWANALISISINTERNO(" + i + ");";
                        break;
                    case 7:
                        click_view = "TRAM_FN_VIEWRESOLUTIVO(" + i + ");";
                        break;
                    default:
                        click_view = "";
                        break;
                }

                //Agregamos formulario a su contenedor en la lista
                if (i === 0) {

                    $('#section_formulario').html('');
                    var divSectionContainerFormulario = $('#section_formulario');

                    var cardSection = '<li id="sectionItem_' + i + '">' +
                        '<div class="card_titulo_izquierda">' +
                        '<span class="circulo_peq ' + cr_active + '">' +
                        '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                        '</span>' +
                        '<div class="titulo_izquierda ' + tit_active + '">' +
                        '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                        '<div>' +
                        '<i onclick="' + click_view + ' TRAM_FN_SELECCIONARSECCION(' + i + ');" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</li>';

                    divSectionContainerFormulario.append(cardSection);
                    return;
                }

                //Agregamos resto de secciones
                var cardSection = '<li id="sectionItem_' + i + '">' +
                    '<div class="card_titulo_izquierda">' +
                    '<span class="circulo_peq ' + cr_active + '">' +
                    '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                    '</span>' +
                    '<div class="titulo_izquierda ' + tit_active + '">' +
                    '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                    '<div>' +
                    '<i onclick="' + click_view + ' TRAM_FN_SELECCIONARSECCION(' + i + ');" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                    '<i onclick="TRAM_FN_ELIMINARSECCIONLISTA(' + i + ');" class="fa fa-times fa-1x cerrar cursor" aria-hidden="true"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
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

    //Funcion eliminar lista  de seccion
    function TRAM_FN_ELIMINARSECCIONLISTA(index) {

        list_sections.splice(index, 1);
        TRAM_FN_RENDERSECCIONES();
    }

    //Renderizar listado de secciones
    function TRAM_FN_RENDERSECCIONES() {

        //Contenedor de lista Sortable
        $('#section_list').html('');
        var divSectionContainer = $('#section_list');

        $(list_sections).each(function(i, v) {

            var cr_active = v.active === true ? "cr_activo" : "cr_inactivo";
            var tit_active = v.active === true ? "tit_activo" : "tit_inactivo";

            //switch secciones
            var click_view = "";
            switch (parseInt(v.id)) {
                case 1:
                    click_view = "TRAM_FN_VIEWFORMULARIO(" + i + ");";
                    break;
                case 2:
                    click_view = "TRAM_FN_VIEWREVISION(" + i + ");";
                    break;
                case 3:
                    click_view = "TRAM_FN_VIEWCITA(" + i + ");";
                    break;
                case 4:
                    click_view = "TRAM_FN_VIEWVENTANILLA(" + i + ");";
                    break;
                case 5:
                    click_view = "TRAM_FN_VIEWPAGO(" + i + ");";
                    break;
                case 6:
                    click_view = "TRAM_FN_VIEWANALISISINTERNO(" + i + ");";
                    break;
                case 7:
                    click_view = "TRAM_FN_VIEWRESOLUTIVO(" + i + ");";
                    break;
                default:
                    click_view = "";
                    break;
            }

            //Agregamos formulario a su contenedor en la lista
            if (i === 0) {

                $('#section_formulario').html('');
                var divSectionContainerFormulario = $('#section_formulario');

                var cardSection = '<li id="sectionItem_' + i + '">' +
                    '<div class="card_titulo_izquierda">' +
                    '<span class="circulo_peq ' + cr_active + '">' +
                    '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                    '</span>' +
                    '<div class="titulo_izquierda ' + tit_active + '">' +
                    '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                    '<div>' +
                    '<i onclick="' + click_view + ' TRAM_FN_SELECCIONARSECCION(' + i + ');" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>';

                divSectionContainerFormulario.append(cardSection);
                return true;
            }

            //Agregamos resto de secciones
            var cardSection = '<li id="sectionItem_' + i + '">' +
                '<div class="card_titulo_izquierda">' +
                '<span class="circulo_peq ' + cr_active + '">' +
                '<i class="' + v.icon + '" aria-hidden="true"></i>' +
                '</span>' +
                '<div class="titulo_izquierda ' + tit_active + '">' +
                '<span class="subtitulo_izquierda">' + v.name + '</span>' +
                '<div>' +
                '<i onclick="' + click_view + ' TRAM_FN_SELECCIONARSECCION(' + i + ');" class="fa fa-cog fa-2x engrane cursor" aria-hidden="true"></i>' +
                '<i onclick="TRAM_FN_ELIMINARSECCIONLISTA(' + i + ');" class="fa fa-times fa-1x cerrar cursor" aria-hidden="true"></i>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</li>';

            divSectionContainer.append(cardSection);
        });
    }

    //Mostrar vista formulario
    function TRAM_FN_VIEWFORMULARIO(index) {

        _index = index;

        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_formulario",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);

                setTimeout(function() {

                    $('#listFormulario').html('');
                    var divSectionContainer = $('#listFormulario');

                    //Agregar el formulario ya seleccionado
                    if (list_formularios.length > 0) {

                        var formularioSelect = list_formularios.find(x => x.FORM_NIDFORMULARIO === id_formulario);

                        if (typeof formularioSelect !== 'undefined') {

                            var activo_ = formularioSelect.total > 0 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-secondary">Inactivo</span>';
                            var check = "checked";

                            var itemFormulario = '<div class="row">' +
                                '<div class="col-10">' +
                                '<p>' +
                                '<h6 class="negritas">' + formularioSelect.FORM_CNOMBRE + '</h6>' +
                                '<h6>' + activo_ + '</h6>' +
                                '' + formularioSelect.FORM_CDESCRIPCION + '' +
                                '</p>' +
                                '<p style="margin-bottom: 0px; color:#6f6d6d;">Última edición: ' + formularioSelect.FORM_DFECHA + '</p>' +
                                '</div>' +
                                '<div class="col-2" style="align-items: center; display: flex; justify-content: center;">' +
                                '<div class="form-group">' +
                                '<div class="form-check">' +
                                '<input ' + check + ' data-formulario="' + formularioSelect.FORM_NIDFORMULARIO + '" style="width: 1.4rem; height: 1.4rem;" class="form-check-input checkItemFormulario" type="checkbox">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<hr class="division_2" />';

                            divSectionContainer.append(itemFormulario);
                        }
                    }

                    $.each(list_formularios, function(i, v) {

                        if (v.FORM_NIDFORMULARIO === id_formulario) {
                            return true;
                        }

                        var activo_ = v.total > 0 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-secondary">Inactivo</span>';
                        var check = v.FORM_NIDFORMULARIO === id_formulario ? "checked" : "";

                        var itemFormulario = '<div class="row">' +
                            '<div class="col-10">' +
                            '<p>' +
                            '<h6 class="negritas">' + v.FORM_CNOMBRE + '</h6>' +
                            '<h6>' + activo_ + '</h6>' +
                            '' + v.FORM_CDESCRIPCION + '' +
                            '</p>' +
                            '<p style="margin-bottom: 0px; color:#6f6d6d;">Última edición: ' + v.FORM_DFECHA + '</p>' +
                            '</div>' +
                            '<div class="col-2" style="align-items: center; display: flex; justify-content: center;">' +
                            '<div class="form-group">' +
                            '<div class="form-check">' +
                            '<input ' + check + ' data-formulario="' + v.FORM_NIDFORMULARIO + '" style="width: 1.4rem; height: 1.4rem;" class="form-check-input checkItemFormulario" type="checkbox">' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<hr class="division_2" />';

                        divSectionContainer.append(itemFormulario);
                    });
                }, 100);
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

    //Mostrar vista revision
    function TRAM_FN_VIEWREVISION(index) {

        _index = index;

        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_revision",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);
                var section = list_sections[index];
                dias_habiles = section.dias_habiles;

                setTimeout(function() {

                    if (dias_habiles > 0) {
                        $("#numDiasHabiles").val(dias_habiles);
                    } else {
                        $("#numDiasHabiles").val(0);
                    }
                }, 200);
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

    //Mostrar vista cita
    function TRAM_FN_VIEWCITA(index) {

        _index = index;
        var nombre_tramite = "{{$tramite['ACCE_NOMBRE_TRAMITE']}}";
        var id_accede = "{{request()->route('tramiteID') }}";
        textCita = list_sections[_index].descripcion_cita;

        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_cita",
            type: "GET",
            success: function(data) {

                var res = data.replace("{id_accede_cita}", id_accede);
                res = res.replace("{nombre_tramite_cita}", nombre_tramite);
                $('#detalle_seccion').html(res);
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

    //Mostrar vista ventanilla
    function TRAM_FN_VIEWVENTANILLA(index) {

        var edificios_default = @json($edificios);

        _index = index;
        edificios = [];
        textVentanilla = list_sections[_index].descripcion_ventanilla;
        list_sections[_index].list_edificios.forEach(x => edificios.push(x.EDIF_CNOMBRE));

        $.ajax({
            // data: filtro,
            dataType: 'json',
            url: "/gestores/configuracion/seccion_ventanilla",
            type: "GET",
            success: function(data) {

                $('#detalle_seccion').html(data);

                setTimeout(function() {

                    var options = [],
                        _options;

                    $(edificios_default).each(function(i, v) {
                        var option = '<option value="' + v.id + '">' + v.nombre + '</option>';
                        options.push(option);
                    });
                    _options = options.join('');

                    $('#cmbEdificios').selectpicker({
                        noneSelectedText: 'Seleccione edificios',
                        noneResultsText: 'Edificios no encontrados',
                    });

                    $('#cmbEdificios').html(_options).selectpicker('refresh');

                    ////


                    $('#cmbEdificios').on('change', function() {
                        var selected = $('#cmbEdificios').val();
                        TRAM_FN_AGREGAREDIFICIO(selected);
                    });

                    $('#list_edificios').html('');
                    if (list_sections[_index].list_edificios.length > 0) {

                        var ids = [];
                        $.each(list_sections[_index].list_edificios, function(key, value) {
                            ids.push(value.EDIF_NIDEDIFICIO);
                        });

                        $('#list_edificios').html('');
                        $('#cmbEdificios').selectpicker('val', ids);

                        $.each(list_sections[_index].list_edificios, function(key, value) {
                            $('#list_edificios').append('<li class="list-group-item d-flex justify-content-between align-items-center">' + value.EDIF_CNOMBRE + '  <span class="deleteItemEdificio" onclick="TRAM_FN_ELIMINAR_EDIFICIOS(' + key + ');" style="cursor:pointer;" title="Eliminar edificio" class="badge badge-pill"><i style="font-size:16px;" class="fas fa-times"></i></span></li>');
                        });
                    }
                    ////

                }, 200);
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

    //Mostrar vista de seccion de pago
    function TRAM_FN_VIEWPAGO(index) {

        _index = index;
        list_conceptos = [];

        $.each(list_sections[_index].list_pago, function(key, value) {
            var item = list_conceptos_tramite.find(x => parseInt(x.ID) === parseInt(value.CONC_NIDCONCEPTO));
            if (typeof item !== 'undefined') {
                list_conceptos.push(item);
            }
        });

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

    //Mostrar vista de analisis interno
    function TRAM_FN_VIEWANALISISINTERNO(index) {

        _index = index;

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

    //Mostrar vista de resolutivo
    function TRAM_FN_VIEWRESOLUTIVO(index) {
        alert("entre");

        _index = index;
        resolutivos = [];
        list_sections[_index].list_resolutivo.forEach(x => resolutivos.push(x.RESO_CNOMBRE));

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

    //Funcion para marcar seccion seleccionada
    function TRAM_FN_SELECCIONARSECCION(indexSelected) {

        if (list_sections.length > 0) {
            $.each(list_sections, function(key, value) {

                if (indexSelected === key) {
                    value.active = true;
                    $('#sectionItem_' + key + ' > div > div').removeClass("tit_inactivo").addClass("tit_activo");
                    $('#sectionItem_' + key + ' > div > span').removeClass("cr_inactivo").addClass("cr_activo");
                } else {
                    value.active = false;
                    $('#sectionItem_' + key + ' > div > div').removeClass("tit_activo").addClass("tit_inactivo");
                    $('#sectionItem_' + key + ' > div > span').removeClass("cr_activo").addClass("cr_inactivo");
                }
            });
        }
    }

    var tramite = {
        edificios: [],
        resolutivos: []
    };

    //Funcion agregar conceptos de pago
    function TRAM_FN_AGREGA_CONCEPTO_PAGO(values) {

        list_conceptos = [];
        list_sections[_index].list_pago = [];

        if (values !== null && values.length > 0) {
            $.each(values, function(key, value) {
                var item = list_conceptos_tramite.find(x => parseInt(x.ID) === parseInt(value));
                if (typeof item !== 'undefined') {
                    list_conceptos.push(item);
                    list_sections[_index].list_pago.push({
                        "CONC_NID": 0,
                        "CONC_NIDCONCEPTO": item.ID,
                        "CONC_NIDTRAMITE": 0,
                        "CONC_NIDTRAMITE_ACCEDE": item.Id_Accede,
                        "CONC_NREFERENCIA": item.Referencia,
                        "CONC_CONCEPTO": item.Concepto,
                        "CONC_CTRAMITE": item.Tramite,
                        "CONC_CENTE_PUBLICO": item.Ente_Publico,
                        "CONC_CENTE": item.Ente,
                        "CONC_NIDSECCION": 0
                    });
                }
            });
        }
    }

    //Funcion agregar edificios seccion ventanilla sin cita
    function TRAM_FN_AGREGAREDIFICIO(values) {

        list_sections[_index].list_edificios = [];
        $('#list_edificios').html('');

        var listDefault = @json($edificios);

        $.each(values, function(key, value) {

            var item = listDefault.find(x => x.id === value);

            var itemTemEdif = {
                "EDIF_NIDEDIFICIO": item.id,
                "EDIF_NIDTRAMITE": 0,
                "EDIF_CNOMBRE": item.nombre,
                "EDIF_CCALLE": item.direccion,
                "EDIF_NNUMERO_INTERIOR": null,
                "EDIF_NNUMERO_EXTERIOR": null,
                "EDIF_NCP": null,
                "EDIF_CCOLONIA": null,
                "EDIF_NCVECOLONIA": null,
                "EDIF_CMUNICIPIO": null,
                "EDIF_CESTADO": null,
                "EDIF_CDIASATENCION": null,
                "EDIF_CHORARIOS": null,
                "EDIF_CLATITUD": item.latitud,
                "EDIF_CLONGITUD": item.longitud,
                "EDIF_NIDSECCION": null
            };
            list_sections[_index].list_edificios.push(itemTemEdif);

            $('#list_edificios').append('<li class="list-group-item d-flex justify-content-between align-items-center">' + item.nombre + '  <span onclick="TRAM_FN_ELIMINAR_EDIFICIOS(' + key + ');" style="cursor:pointer;" title="Eliminar edificio" class="badge badge-pill"><i style="font-size:16px;" class="fas fa-times"></i></span></li>');
        });
    }

    //Funcion para eliminar edificios de la lista seccion ventanilla sin cita
    function TRAM_FN_ELIMINAR_EDIFICIOS(index) {

        list_sections[_index].list_edificios.splice(index, 1);

        var ids = [];
        $.each(list_sections[_index].list_edificios, function(key, value) {
            ids.push(value.EDIF_NIDEDIFICIO);
        });

        $('#list_edificios').html('');
        $('#cmbEdificios').selectpicker('val', ids);

        $.each(list_sections[_index].list_edificios, function(key, value) {
            $('#list_edificios').append('<li class="list-group-item d-flex justify-content-between align-items-center">' + value.EDIF_CNOMBRE + '  <span onclick="TRAM_FN_ELIMINAR_EDIFICIOS(' + key + ');" style="cursor:pointer;" title="Eliminar edificio" class="badge badge-pill"><i style="font-size:16px;" class="fas fa-times"></i></span></li>');
        });
    }

    //Funcion agregar resolutivo seccion resolutivos electronicos
    function TRAM_FN_AGREGAR_RESOLUTIVO(values) {

        resolutivos = [];
        list_sections[_index].list_resolutivo = [];
        $('#list_resolutivos').html('');

        $.each(values, function(key, value) {
            resolutivos.push(value);
            list_sections[_index].list_resolutivo.push({
                "RESO_NID": 0,
                "RESO_NIDTRAMITE": 0,
                "RESO_NIDRESOLUTIVO": 0,
                "RESO_CNOMBRE": value,
                "RESO_NIDSECCION": 0
            });
            $('#list_resolutivos').append('<li class="list-group-item d-flex justify-content-between align-items-center">' + value + '  <span onclick="TRAM_FN_ELIMINAR_RESOLUTIVO(' + key + ');" style="cursor:pointer;" title="Eliminar resolutivo" class="badge badge-pill"><i style="font-size:16px;" class="fas fa-times"></i></span></li>');
        });
    }

    //Funcion para eliminar resolutivo de la lista seccion resolutivo electronico
    function TRAM_FN_ELIMINAR_RESOLUTIVO(index) {

        resolutivos.splice(index, 1);
        list_sections[_index].list_resolutivo.splice(index, 1);

        $('#list_resolutivos').html('');
        $('#cmbResolutivo').selectpicker('val', resolutivos);

        $.each(resolutivos, function(key, value) {
            $('#list_resolutivos').append('<li class="list-group-item d-flex justify-content-between align-items-center">' + value + '  <span onclick="TRAM_FN_ELIMINAR_RESOLUTIVO(' + key + ');" style="cursor:pointer;" title="Eliminar resolutivo" class="badge badge-pill"><i style="font-size:16px;" class="fas fa-times"></i></span></li>');
        });
    }

    /*** Funciones para configuracion de formulario ***/

    //Funcion para buscar y mostrar formularios
    function TRAM_FN_BUSCAR_FORMULARIO_RENDER(txtSearch) {

        $('#listFormulario').html('');
        var divSectionContainer = $('#listFormulario');

        //Agregar el formulario ya seleccionado
        if (list_formularios.length > 0) {

            var formularioSelect = list_formularios.find(x => x.FORM_NIDFORMULARIO === id_formulario);

            if (typeof formularioSelect !== 'undefined') {

                var activo_ = formularioSelect.total > 0 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-secondary">Inactivo</span>';
                var check = "checked";

                var itemFormulario = '<div class="row">' +
                    '<div class="col-10">' +
                    '<p>' +
                    '<h6 class="negritas">' + formularioSelect.FORM_CNOMBRE + '</h6>' +
                    '<h6>' + activo_ + '</h6>' +
                    '' + formularioSelect.FORM_CDESCRIPCION + '' +
                    '</p>' +
                    '<p style="margin-bottom: 0px; color:#6f6d6d;">Última edición: ' + formularioSelect.FORM_DFECHA + '</p>' +
                    '</div>' +
                    '<div class="col-2" style="align-items: center; display: flex; justify-content: center;">' +
                    '<div class="form-group">' +
                    '<div class="form-check">' +
                    '<input ' + check + ' data-formulario="' + formularioSelect.FORM_NIDFORMULARIO + '" style="width: 1.4rem; height: 1.4rem;" class="form-check-input checkItemFormulario" type="checkbox">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<hr class="division_2" />';

                divSectionContainer.append(itemFormulario);
            }
        }

        //Agregar formularios que coincidan con la busqueda
        $.each(list_formularios, function(i, v) {

            if (v.FORM_NIDFORMULARIO === id_formulario) {
                return true;
            }

            if (v.FORM_CNOMBRE.toLowerCase().indexOf(txtSearch) > -1) {

                var activo_ = v.total > 0 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-secondary">Inactivo</span>';
                var check = v.FORM_NIDFORMULARIO === id_formulario ? "checked" : "";

                var itemFormulario = '<div class="row">' +
                    '<div class="col-10">' +
                    '<p>' +
                    '<h6 class="negritas">' + v.FORM_CNOMBRE + '</h6>' +
                    '<h6>' + activo_ + '</h6>' +
                    '' + v.FORM_CDESCRIPCION + '' +
                    '</p>' +
                    '<p style="margin-bottom: 0px; color:#6f6d6d;">Última edición: ' + v.FORM_DFECHA + '</p>' +
                    '</div>' +
                    '<div class="col-2" style="align-items: center; display: flex; justify-content: center;">' +
                    '<div class="form-group">' +
                    '<div class="form-check">' +
                    '<input ' + check + ' data-formulario="' + v.FORM_NIDFORMULARIO + '" style="width: 1.4rem; height: 1.4rem;" class="form-check-input checkItemFormulario" type="checkbox">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<hr class="division_2" />';

                divSectionContainer.append(itemFormulario);
            }
        });
    }

    //Funcion de evento buscar formulario
    function TRAM_FN_BUSCAR_FORMULARIO() {

        var input = document.getElementById("search");
        var searchFormulario = input.value.toLowerCase();

        if (searchFormulario.length > 2) {
            TRAM_FN_BUSCAR_FORMULARIO_RENDER(searchFormulario);
        } else {
            searchFormulario = "";
            TRAM_FN_BUSCAR_FORMULARIO_RENDER(searchFormulario);
        }
    }


    /*** Funcion para configurar documentos ***/

    //Funcion de evento asignar documentos
    function TRAM_FN_ASIGNAR_DOCUMENTOS() {

        $('#documentosModal').modal('show');
        $('#searchDocumento').val('');

        $('#listDocumentos').html('');
        var divSectionContainer = $('#listDocumentos');

        $.each(list_default_documentos, function(i, v) {

            var check = "";
            if (v.TRAD_SELECT === true) {
                check = "checked";
            }

            var checkObligatorio = "";
            if (v.TRAD_NOBLIGATORIO === true) {
                checkObligatorio = "checked";
            }

            var checkMultiple = "";
            if (v.TRAD_NMULTIPLE === true) {
                checkMultiple = "checked";
            }

            var item = '<div class="row">' +
                '<div class="col-6">' +
                '<h6 class="negritas">' + v.TRAD_CNOMBRE + '</h6>' +
                '<strong style="user-select:none;">Descripción ' +
                '</strong>' +
                '<p>' +
                '<small id="textDescripcionDocumento_' + v.TRAD_NIDDOCUMENTO + '" style="font-weight: bold;">' + v.TRAD_CDESCRIPCION + '</small>' +
                '</p>' +
                '<textarea id="textAreaDocumento_' + v.TRAD_NIDDOCUMENTO + '" style="display:none;" class="form-control" rows="3" maxlength="50"></textarea>' +
                '</div>' +
                '<div class="col-4" style="align-self: center;">' +
                '<div class="form-check">' +
                '<input ' + checkObligatorio + ' data-documento="' + v.TRAD_NIDDOCUMENTO + '" class="form-check-input checkDocumentoObligatorio" type="checkbox" value="" >' +
                '<label class="form-check-label">' +
                '¿Es obligatorio?' +
                '</label>' +
                '</div>' +
                '<br>' +
                '<div class="form-check">' +
                '<input ' + checkMultiple + ' data-documento="' + v.TRAD_NIDDOCUMENTO + '" class="form-check-input checkDocumentoMultiple" type="checkbox" value="">' +
                '<label class="form-check-label">' +
                '¿Requiere más de un archivo para el documento?' +
                '</label>' +
                '</div>' +
                '</div>' +
                '<div class="col-2" style="align-items: center; display: flex; justify-content: center;">' +
                '<div class="form-group">' +
                '<div class="form-check">' +
                '<input ' + check + ' data-documento="' + v.TRAD_NIDDOCUMENTO + '" style="width: 1.4rem; height: 1.4rem;" class="form-check-input checkDocumento" type="checkbox">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<hr class="division_2" style="background:#999 !important;"/>';

            divSectionContainer.append(item);
        });
    }

    //Funcion para buscar y mostrar documentos
    function TRAM_FN_BUSCAR_DOCUMENTOS_RENDER(txtSearch) {

        $('#listDocumentos').html('');
        var divSectionContainer = $('#listDocumentos');

        //Agregar los documentos ya seleccionados
        if (list_default_documentos.length > 0) {

            $.each(list_default_documentos, function(i, v) {

                if (v.TRAD_SELECT === true) {

                    var checkObligatorio = "";
                    if (v.TRAD_NOBLIGATORIO === true) {
                        checkObligatorio = "checked";
                    }

                    var checkMultiple = "";
                    if (v.TRAD_NMULTIPLE === true) {
                        checkMultiple = "checked";
                    }

                    var item = '<div class="row">' +
                        '<div class="col-6">' +
                        '<h6 class="negritas">' + v.TRAD_CNOMBRE + '</h6>' +
                        '<strong style="user-select:none;">Descripción ' +
                        '<i onclick="TRAM_FN_EDITAR_DOCUMENTO(' + v.TRAD_NIDDOCUMENTO + ')" id="EditDocument_' + v.TRAD_NIDDOCUMENTO + '" class="fas fa-pencil-alt" style="font-size: 18px; padding: 5px; cursor: pointer;"></i>' +
                        '<i onclick="TRAM_FN_EDITAR_DOCUMENTO_CANCEL(' + v.TRAD_NIDDOCUMENTO + ')" id="EditDocumentCancel_' + v.TRAD_NIDDOCUMENTO + '" class="far fa-window-close" style="display:none; font-size: 18px; padding: 5px; cursor: pointer;"></i>' +
                        '</strong>' +
                        '<p>' +
                        '<small id="textDescripcionDocumento_' + v.TRAD_NIDDOCUMENTO + '" style="font-weight: bold;">' + v.TRAD_CDESCRIPCION + '</small>' +
                        '</p>' +
                        '<textarea id="textAreaDocumento_' + v.TRAD_NIDDOCUMENTO + '" style="display:none;" class="form-control" rows="3" maxlength="50"></textarea>' +
                        '</div>' +
                        '<div class="col-4" style="align-self: center;">' +
                        '<div class="form-check">' +
                        '<input ' + checkObligatorio + ' data-documento="' + v.TRAD_NIDDOCUMENTO + '" class="form-check-input checkDocumentoObligatorio" type="checkbox" value="" >' +
                        '<label class="form-check-label" >' +
                        '¿Es obligatorio?' +
                        '</label>' +
                        '</div>' +
                        '<br>' +
                        '<div class="form-check">' +
                        '<input ' + checkMultiple + ' data-documento="' + v.TRAD_NIDDOCUMENTO + '" class="form-check-input checkDocumentoMultiple" type="checkbox" value="">' +
                        '<label class="form-check-label">' +
                        '¿Requiere más de un archivo para el documento?' +
                        '</label>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-2" style="align-items: center; display: flex; justify-content: center;">' +
                        '<div class="form-group">' +
                        '<div class="form-check">' +
                        '<input data-documento="' + v.TRAD_NIDDOCUMENTO + '" checked style="width: 1.4rem; height: 1.4rem;" class="form-check-input checkDocumento" type="checkbox">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<hr class="division_2" style="background:#999 !important;"/>';

                    divSectionContainer.append(item);
                }
            });
        }

        //Agregar formularios que coincidan con la busqueda
        $.each(list_default_documentos, function(i, v) {

            if (v.TRAD_SELECT === true) {
                return true;
            }

            var checkObligatorio = "";
            if (v.TRAD_NOBLIGATORIO === true) {
                checkObligatorio = "checked";
            }

            var checkMultiple = "";
            if (v.TRAD_NMULTIPLE === true) {
                checkMultiple = "checked";
            }

            if (v.TRAD_CNOMBRE.toLowerCase().indexOf(txtSearch) > -1) {

                var item = '<div class="row">' +
                    '<div class="col-6">' +
                    '<h6 class="negritas">' + v.TRAD_CNOMBRE + '</h6>' +
                    '<strong style="user-select:none;">Descripción ' +
                    '<i onclick="TRAM_FN_EDITAR_DOCUMENTO(' + v.TRAD_NIDDOCUMENTO + ')" id="EditDocument_' + v.TRAD_NIDDOCUMENTO + '" class="fas fa-pencil-alt" style="font-size: 18px; padding: 5px; cursor: pointer;"></i>' +
                    '<i onclick="TRAM_FN_EDITAR_DOCUMENTO_CANCEL(' + v.TRAD_NIDDOCUMENTO + ')" id="EditDocumentCancel_' + v.TRAD_NIDDOCUMENTO + '" class="far fa-window-close" style="display:none; font-size: 18px; padding: 5px; cursor: pointer;"></i>' +
                    '</strong>' +
                    '<p>' +
                    '<small id="textDescripcionDocumento_' + v.TRAD_NIDDOCUMENTO + '" style="font-weight: bold;">' + v.TRAD_CDESCRIPCION + '</small>' +
                    '</p>' +
                    '<textarea id="textAreaDocumento_' + v.TRAD_NIDDOCUMENTO + '" style="display:none;" class="form-control" rows="3" maxlength="50"></textarea>' +
                    '</div>' +
                    '<div class="col-4" style="align-self: center;">' +
                    '<div class="form-check">' +
                    '<input ' + checkObligatorio + ' data-documento="' + v.TRAD_NIDDOCUMENTO + '" class="form-check-input checkDocumentoObligatorio" type="checkbox" value="">' +
                    '<label class="form-check-label">' +
                    '¿Es obligatorio?' +
                    '</label>' +
                    '</div>' +
                    '<br>' +
                    '<div class="form-check">' +
                    '<input ' + checkMultiple + ' data-documento="' + v.TRAD_NIDDOCUMENTO + '" class="form-check-input checkDocumentoMultiple" type="checkbox" value="">' +
                    '<label class="form-check-label">' +
                    '¿Requiere más de un archivo para el documento?' +
                    '</label>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-2" style="align-items: center; display: flex; justify-content: center;">' +
                    '<div class="form-group">' +
                    '<div class="form-check">' +
                    '<input data-documento="' + v.TRAD_NIDDOCUMENTO + '" style="width: 1.4rem; height: 1.4rem;" class="form-check-input checkDocumento" type="checkbox">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<hr class="division_2" style="background:#999 !important;"/>';

                divSectionContainer.append(item);
            }
        });
    }

    //Funcion de evento buscar documento
    function TRAM_FN_BUSCAR_DOCUMENTOS() {

        var input = document.getElementById("searchDocumento");
        var searchDocumento = input.value.toLowerCase();

        if (searchDocumento.length > 2) {
            TRAM_FN_BUSCAR_DOCUMENTOS_RENDER(searchDocumento);
        } else {
            searchDocumento = "";
            TRAM_FN_BUSCAR_DOCUMENTOS_RENDER(searchDocumento);
        }
    }

    //Funcion editar descripcion de documento
    function TRAM_FN_EDITAR_DOCUMENTO(DocumentoID) {

        var documento = list_default_documentos.find(x => x.TRAD_NIDDOCUMENTO === DocumentoID);

        if (typeof documento === 'undefined') {
            return true;
        }

        $('#EditDocument_' + DocumentoID + '').hide();
        $('#EditDocumentCancel_' + DocumentoID + '').show();
        $('#textAreaDocumento_' + DocumentoID + '').show();
        $('#textAreaDocumento_' + DocumentoID + '').val(documento.TRAD_CDESCRIPCION);
    }

    //Funcion para cancelar edicion de documento
    function TRAM_FN_EDITAR_DOCUMENTO_CANCEL(DocumentoID) {

        var documento = list_default_documentos.find(x => x.TRAD_NIDDOCUMENTO === DocumentoID);

        if (typeof documento === 'undefined') {
            return true;
        }

        documento.TRAD_CDESCRIPCION = $('#textAreaDocumento_' + DocumentoID + '').val();

        $('#EditDocument_' + DocumentoID + '').show();
        $('#EditDocumentCancel_' + DocumentoID + '').hide();
        $('#textAreaDocumento_' + DocumentoID + '').hide();
        $('#textDescripcionDocumento_' + DocumentoID + '').html(documento.TRAD_CDESCRIPCION);
    }


    /*** Funciones de Guardado ***/

    function TRAM_FN_VALIDAR_FORMULARIO() {
        if (id_formulario > 0) {
            var formularioSelect = list_formularios.find(x => x.FORM_NIDFORMULARIO === id_formulario);
            if (typeof formularioSelect !== 'undefined') {

                var documentos_filter = list_default_documentos.filter(x => x.TRAD_SELECT === true);
                var documentos = [];
                documentos_filter.forEach(x => documentos.push(x));

                if (documentos.length > 0) {

                    $.each(documentos, function(index, value) {
                        value.TRAD_NOBLIGATORIO = value.TRAD_NOBLIGATORIO === true ? 1 : 0;
                        value.TRAD_NMULTIPLE = value.TRAD_NMULTIPLE === true ? 1 : 0;
                    });

                    return {
                        title: '¡Sección completa!',
                        mensaje: "Formulario y documentos seleccionados completo",
                        valido: true,
                        formulario: formularioSelect,
                        documentos: documentos
                    };
                } else {
                    return {
                        title: '¡Documentos no seleccionados!',
                        mensaje: "Seleccione documentos necesarios para realizar el trámite",
                        valido: false,
                        formulario: null
                    };
                }
            } else {
                id_formulario = 0;
                return {
                    title: '¡Formulario no seleccionado!',
                    mensaje: "No se encontro el formulario seleccionado, intente seleccionando de nuevo.",
                    valido: false,
                    formulario: null
                };
            }
        } else {
            return {
                title: '¡Formulario no seleccionado!',
                mensaje: "Es necesario seleccionar un formulario, consulte la lista de formularios.",
                valido: false,
                formulario: null
            };
        }
    }

    function TRAM_FN_VALIDAR_REVISION(index) {




        /*
        var existeRevision = list_sections.find(x => x.id === 2);

        if (typeof existeRevision === 'undefined') {
            return {
                seleccionado: false,
                mensaje: "No se selecciono la sección de Revisión de documentación",
                valido: true,
                data: null
            };
        } else {
            if (!(dias_habiles > 0)) {
                return {
                    seleccionado: true,
                    mensaje: "Indique el número de días hábiles que tendrá el solicitante para que atienda las observaciones",
                    valido: false,
                    data: null,
                    orden: existeRevision.orden
                };
            } else {

                var section = {
                    CONF_NIDTRAMITE: 0,
                    CONF_NSECCION: 'Revisión de documentación',
                    CONF_CNOMBRESECCION: 'Revisión de documentación',
                    CONF_ESTATUSSECCION: true,
                    CONF_NDIASHABILES: dias_habiles,
                    CONF_CDESCRIPCIONCITA: null,
                    CONF_CDESCRIPCIONVENTANILLA: null,
                    CONF_NORDEN: existeRevision.orden + 1
                }

                return {
                    seleccionado: true,
                    mensaje: "Revisión de documentación completa",
                    valido: true,
                    data: section
                };
            }
        }*/
    }

    function TRAM_FN_VALIDAR_CITA() {

        var existeCita = list_sections.find(x => x.id === 3);

        if (typeof existeCita === 'undefined') {
            return {
                seleccionado: false,
                mensaje: "No se selecciono la sección de Cita en Línea",
                valido: true,
                data: null
            };
        } else {

            var section = {
                CONF_NIDTRAMITE: 0,
                CONF_NSECCION: 'Citas en línea',
                CONF_CNOMBRESECCION: 'Citas en línea',
                CONF_ESTATUSSECCION: true,
                CONF_NDIASHABILES: null,
                CONF_CDESCRIPCIONCITA: textCita,
                CONF_CDESCRIPCIONVENTANILLA: null,
                CONF_NORDEN: existeCita.orden + 1
            }

            return {
                seleccionado: true,
                mensaje: "Citas en línea completa",
                valido: true,
                data: section
            };
        }
    }

    function TRAM_FN_VALIDAR_VENTANILLA() {

        var existeVentanilla = list_sections.find(x => x.id === 4);

        if (typeof existeVentanilla === 'undefined') {
            return {
                seleccionado: false,
                mensaje: "No se selecciono la sección de Ventanilla sin cita",
                valido: true,
                data: null
            };
        } else {

            var section = {
                CONF_NIDTRAMITE: 0,
                CONF_NSECCION: 'Ventanilla sin cita',
                CONF_CNOMBRESECCION: 'Ventanilla sin cita',
                CONF_ESTATUSSECCION: true,
                CONF_NDIASHABILES: null,
                CONF_CDESCRIPCIONCITA: null,
                CONF_CDESCRIPCIONVENTANILLA: textVentanilla,
                CONF_NORDEN: existeVentanilla.orden + 1
            }

            var list_edificios = [];

            if (edificios.length > 0) {

                $.each(edificios, function(index, value) {

                    var objEdificio = {
                        EDIF_NIDEDIFICIO: index + 1,
                        EDIF_NIDTRAMITE: 0,
                        EDIF_CNOMBRE: value,
                        EDIF_CCALLE: null,
                        EDIF_NNUMERO_INTERIOR: null,
                        EDIF_NNUMERO_EXTERIOR: null,
                        EDIF_NCP: null,
                        EDIF_CCOLONIA: null,
                        EDIF_NCVECOLONIA: null,
                        EDIF_CMUNICIPIO: null,
                        EDIF_CESTADO: null,
                        EDIF_CDIASATENCION: null,
                        EDIF_CHORARIOS: null,
                        EDIF_CLATITUD: null,
                        EDIF_CLONGITUD: null,
                    };

                    list_edificios.push(objEdificio);
                });

                return {
                    seleccionado: true,
                    mensaje: "Ventanilla sin cita completa",
                    valido: true,
                    data: section,
                    edificios: list_edificios
                };

            } else {
                return {
                    seleccionado: true,
                    mensaje: "Es necesario seleccionar al menos un edificio",
                    valido: false,
                    data: null,
                    orden: existeVentanilla.orden
                };
            }
        }
    }

    function TRAM_FN_VALIDAR_PAGO() {

        var existePago = list_sections.find(x => x.id === 5);
        if (typeof existePago === 'undefined') {
            return {
                seleccionado: false,
                mensaje: "No se selecciono la sección de Pago en línea",
                valido: true,
                data: null
            };
        } else {

            var section = {
                CONF_NIDTRAMITE: 0,
                CONF_NSECCION: 'Pago en línea',
                CONF_CNOMBRESECCION: 'Pago en línea',
                CONF_ESTATUSSECCION: true,
                CONF_NDIASHABILES: null,
                CONF_CDESCRIPCIONCITA: null,
                CONF_CDESCRIPCIONVENTANILLA: null,
                CONF_NORDEN: existePago.orden + 1
            }

            if (list_conceptos.length > 0) {
                return {
                    seleccionado: true,
                    mensaje: "Pago en línea completa",
                    valido: true,
                    data: section
                };
            } else {
                return {
                    seleccionado: true,
                    mensaje: "Debe seleccionar al menos un concepto de pago",
                    valido: false,
                    data: section
                };
            }
        }
    }

    function TRAM_FN_VALIDAR_ANALISIS() {

        var existeAnalisis = list_sections.find(x => x.id === 6);

        if (typeof existeAnalisis === 'undefined') {
            return {
                seleccionado: false,
                mensaje: "No se selecciono la sección de Módulo de análisis interno del área",
                valido: true,
                data: null
            };
        } else {

            var section = {
                CONF_NIDTRAMITE: 0,
                CONF_NSECCION: 'Módulo de análisis interno del área',
                CONF_CNOMBRESECCION: 'Módulo de análisis interno del área',
                CONF_ESTATUSSECCION: true,
                CONF_NDIASHABILES: null,
                CONF_CDESCRIPCIONCITA: null,
                CONF_CDESCRIPCIONVENTANILLA: null,
                CONF_NORDEN: existeAnalisis.orden + 1
            }

            return {
                seleccionado: true,
                mensaje: "Módulo de análisis interno del área completa",
                valido: true,
                data: section
            };
        }

    }

    function TRAM_FN_VALIDAR_RESOLUTIVO() {

        var existeResolutivo = list_sections.find(x => x.id === 7);

        if (typeof existeResolutivo === 'undefined') {
            return {
                seleccionado: false,
                mensaje: "No se selecciono la sección de Resolutivo electrónico",
                valido: true,
                data: null
            };
        } else {

            var section = {
                CONF_NIDTRAMITE: 0,
                CONF_NSECCION: 'Resolutivo electrónico',
                CONF_CNOMBRESECCION: 'Resolutivo electrónico',
                CONF_ESTATUSSECCION: true,
                CONF_NDIASHABILES: null,
                CONF_CDESCRIPCIONCITA: null,
                CONF_CDESCRIPCIONVENTANILLA: null,
                CONF_NORDEN: existeResolutivo.orden + 1
            }

            var list_resolutivo = [];

            if (resolutivos.length > 0) {

                $.each(resolutivos, function(index, value) {

                    var objResolutivo = {
                        RESO_NID: 0,
                        RESO_NIDTRAMITE: 0,
                        RESO_NIDRESOLUTIVO: index + 1,
                        RESO_CNOMBRE: value,
                    };

                    list_resolutivo.push(objResolutivo);
                });

                return {
                    seleccionado: true,
                    mensaje: "Resolutivo electrónico completa",
                    valido: true,
                    data: section,
                    resolutivos: list_resolutivo
                };

            } else {
                return {
                    seleccionado: true,
                    mensaje: "Es necesario seleccionar al menos un resolutivo electrónico",
                    valido: false,
                    data: null,
                    orden: existeResolutivo.orden
                };
            }
        }
    }

    function TRAM_FN_SAVE_T() {

        var IntTramite = "{{request()->route('tramiteID') }}";
        var IntTramiteConfig = "{{request()->route('tramiteIDConfig') }}";

        var tramite = {
            TRAM_NIDTRAMITE_ACCEDE: IntTramite,
            TRAM_NIDTRAMITE_CONFIG: IntTramiteConfig,
            TRAM_NDIASHABILESRESOLUCION: 0,
            TRAM_NDIASHABILESNOTIFICACION: 0,
            TRAM_NIMPLEMENTADO: 0,
            TRAM_NENLACEOFICIAL: 0,
            TRAM_LIST_SECCION: [],
            TRAM_LIST_FORMULARIO: [],
            TRAM_LIST_DOCUMENTO: [],
            TRAM_LIST_EDIFICIO: [],
            TRAM_LIST_RESOLUTIVO: [],
            TRAM_LIST_CONCEPTOS_PAGO: []
        };

        var validateFormulario = TRAM_FN_VALIDAR_FORMULARIO();

        if (validateFormulario.valido === false) {
            TRAM_FN_VIEWFORMULARIO();
            TRAM_FN_SELECCIONARSECCION(0);
            Swal.fire({
                icon: 'warning',
                title: "Formulario",
                text: validateFormulario.mensaje,
                footer: ''
            });
            return;
        } else {

            // 'Formulario',
            // 'Revisión de documentación',
            // 'Citas en línea',
            // 'Ventanilla sin cita',
            // 'Pago en línea',
            // 'Módulo de análisis interno del área',
            // 'Resolutivo electrónico'

            var sec = list_sections.find(x => x.id === 1);

            var section = {
                CONF_NIDTRAMITE: 0,
                CONF_NSECCION: 'Formulario',
                CONF_CNOMBRESECCION: sec.name,
                CONF_ESTATUSSECCION: true,
                CONF_NDIASHABILES: null,
                CONF_CDESCRIPCIONCITA: null,
                CONF_CDESCRIPCIONVENTANILLA: null,
                CONF_NORDEN: 1
            }

            tramite.TRAM_LIST_SECCION.push(section);
            tramite.TRAM_LIST_FORMULARIO.push({
                TRAM_NIDFORMULARIO: id_formulario,
                TRAM_NIDTRAMITE: 0,
            });
            tramite.TRAM_LIST_DOCUMENTO = validateFormulario.documentos;
        }

        //Validacion de revision
        var validateRevision = TRAM_FN_VALIDAR_REVISION(IntTramite);

        if (validateRevision.seleccionado === true) {
            if (validateRevision.valido === true) {
                tramite.TRAM_LIST_SECCION.push(validateRevision.data);
            } else {
                TRAM_FN_VIEWREVISION();
                TRAM_FN_SELECCIONARSECCION(validateRevision.orden);
                Swal.fire({
                    icon: 'warning',
                    title: 'Revisión de documentación',
                    text: validateRevision.mensaje,
                    footer: ''
                });
                return;
            }
        }

        //Validacion de cita
        var validateCita = TRAM_FN_VALIDAR_CITA();
        if (validateCita.seleccionado === true) {
            if (validateCita.valido === true) {
                tramite.TRAM_LIST_SECCION.push(validateCita.data);
            } else {
                TRAM_FN_VIEWCITA();
                TRAM_FN_SELECCIONARSECCION(validateCita.orden);
                Swal.fire({
                    icon: 'warning',
                    title: 'Cita en línea',
                    text: validateCita.mensaje,
                    footer: ''
                });
                return;
            }
        }

        //Validacion de ventanilla sin cita
        var validateVentanilla = TRAM_FN_VALIDAR_VENTANILLA();

        if (validateVentanilla.seleccionado === true) {
            if (validateVentanilla.valido === true) {
                tramite.TRAM_LIST_SECCION.push(validateVentanilla.data);
                tramite.TRAM_LIST_EDIFICIO = validateVentanilla.edificios;
            } else {
                TRAM_FN_VIEWVENTANILLA();
                TRAM_FN_SELECCIONARSECCION(validateVentanilla.orden);
                Swal.fire({
                    icon: 'warning',
                    title: 'Ventanilla sin cita',
                    text: validateVentanilla.mensaje,
                    footer: ''
                });
                return;
            }
        }

        //Validacion pago
        var validatePago = TRAM_FN_VALIDAR_PAGO();

        if (validatePago.seleccionado === true) {
            if (validatePago.valido === true) {
                tramite.TRAM_LIST_SECCION.push(validatePago.data);
                tramite.TRAM_LIST_CONCEPTOS_PAGO = list_conceptos;
            } else {
                TRAM_FN_VIEWPAGO();
                TRAM_FN_SELECCIONARSECCION(validatePago.orden);
                Swal.fire({
                    icon: 'warning',
                    title: 'Pago',
                    text: validatePago.mensaje,
                    footer: ''
                });
                return;
            }
        }

        //Validacion modulo de analisis interno
        var validateAnalisis = TRAM_FN_VALIDAR_ANALISIS();

        if (validateAnalisis.seleccionado === true) {
            if (validateAnalisis.valido === true) {
                tramite.TRAM_LIST_SECCION.push(validateAnalisis.data);
            } else {
                TRAM_FN_VIEWANALISISINTERNO();
                TRAM_FN_SELECCIONARSECCION(validateAnalisis.orden);
                Swal.fire({
                    icon: 'warning',
                    title: 'Módulo de análisis interno del área',
                    text: validateAnalisis.mensaje,
                    footer: ''
                });
                return;
            }
        }

        //Validacion de resolutivo electrónico
        var validateResolutivo = TRAM_FN_VALIDAR_RESOLUTIVO();

        if (validateResolutivo.seleccionado === true) {
            if (validateResolutivo.valido === true) {
                tramite.TRAM_LIST_SECCION.push(validateResolutivo.data);
                tramite.TRAM_LIST_RESOLUTIVO = validateResolutivo.resolutivos;
            } else {
                TRAM_FN_VIEWRESOLUTIVO();
                TRAM_FN_SELECCIONARSECCION(validateResolutivo.orden);
                Swal.fire({
                    icon: 'warning',
                    title: 'Resolutivo electrónico',
                    text: validateResolutivo.mensaje,
                    footer: ''
                });
                return;
            }
        }

        //Plazo días habiles resolutivo y notificacion de trámite
        var txtPlazo_diasResolucion = 0;
        var txtPlazo_diasNotificacion = 0;

        if (parseInt($('#txtPlazo_diasResolucion').val()) > 0) {
            txtPlazo_diasResolucion = parseInt($('#txtPlazo_diasResolucion').val());
        }

        if (parseInt($('#txtPlazo_diasNotificacion').val()) > 0) {
            txtPlazo_diasNotificacion = parseInt($('#txtPlazo_diasNotificacion').val());
        }

        tramite.TRAM_NDIASHABILESRESOLUCION = txtPlazo_diasResolucion;
        tramite.TRAM_NDIASHABILESNOTIFICACION = txtPlazo_diasNotificacion;

        $('#loading_save').show();
        $.ajax({
            data: tramite,
            dataType: 'json',
            url: "/gestores/crear",
            type: "POST",
            success: function(response) {

                if (response.codigo === 200) {
                    window.location.replace(response.ruta)
                } else {
                    $('#loading_save').hide();
                }
            },
            error: function(data) {

                $('#loading_save').hide();

                // Swal.fire({
                //     icon: data.status,
                //     title: '',
                //     text: data.message,
                //     footer: ''
                // });
            }
        });

        return;

        if (list_sections.length >= 2) {

            var existeCitaResolutivo = list_sections.find(x => x.id === 3 || x.id === 7);

            if (typeof existeCitaResolutivo === 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Aviso!',
                    text: 'Es necesario tener al menos dos elementos en el tablero y que la última acción corresponda a "Cita" o "Resolutivo electrónico".',
                    footer: ''
                });
            }

        } else {
            Swal.fire({
                icon: 'warning',
                title: '¡Aviso!',
                text: 'Es necesario tener al menos dos elementos en el tablero y que la última acción corresponda a "Cita" o "Resolutivo electrónico".',
                footer: ''
            });
        }
    }

    function TRAM_FN_SAVE() {

        //Validacion tablero
        if (list_sections.length >= 2) {
            var existeCitaResolutivo = list_sections.find(x => x.id === 3 || x.id === 7);
            if (typeof existeCitaResolutivo === 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Aviso!',
                    text: 'Es necesario tener al menos dos elementos en el tablero y que la última acción corresponda a "Cita" o "Resolutivo electrónico".',
                    footer: ''
                });
                return;
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: '¡Aviso!',
                text: 'Es necesario tener al menos dos elementos en el tablero y que la última acción corresponda a "Cita" o "Resolutivo electrónico".',
                footer: ''
            });
            return;
        }

        var IntTramite = "{{request()->route('tramiteID') }}";
        var IntTramiteConfig = "{{request()->route('tramiteIDConfig') }}";

        var tramite = {
            TRAM_NIDTRAMITE_ACCEDE: IntTramite,
            TRAM_NIDTRAMITE_CONFIG: IntTramiteConfig,
            TRAM_NDIASHABILESRESOLUCION: 0,
            TRAM_NDIASHABILESNOTIFICACION: 0,
            TRAM_NIMPLEMENTADO: 0,
            TRAM_NENLACEOFICIAL: 0,
            TRAM_LIST_SECCION: []
        };

        var cancel_forEach = false;
        var BreakException = {};

        try {
            list_sections.forEach(function(x, index) {

                switch (x.id) {
                    case 1:

                        var validateFormulario = TRAM_FN_VALIDAR_FORMULARIO();

                        if (validateFormulario.valido === false) {
                            TRAM_FN_VIEWFORMULARIO();
                            TRAM_FN_SELECCIONARSECCION(0);
                            Swal.fire({
                                icon: 'warning',
                                title: "Formulario",
                                text: validateFormulario.mensaje,
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {

                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Formulario',
                                CONF_CNOMBRESECCION: x.name,
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };

                            section.CONF_LIST_FORMULARIO.push({
                                TRAM_NIDFORMULARIO: id_formulario,
                                TRAM_NIDTRAMITE: 0,
                            });

                            section.CONF_LIST_DOCUMENTO = validateFormulario.documentos;

                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 2:

                        if (!(x.dias_habiles > 0)) {
                            TRAM_FN_VIEWREVISION(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Indique el número de días hábiles que tendrá el solicitante para que atienda las observaciones",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {

                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Revisión de documentación',
                                CONF_CNOMBRESECCION: 'Revisión de documentación',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: x.dias_habiles,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 3:
                        if (x.descripcion_cita === null || x.descripcion_cita === "") {
                            TRAM_FN_VIEWCITA(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario ingresar los motivos para acudir a la cita",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Citas en línea',
                                CONF_CNOMBRESECCION: 'Citas en línea',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: x.descripcion_cita,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 4:
                        if (x.descripcion_ventanilla === null || x.descripcion_ventanilla === "") {
                            TRAM_FN_VIEWVENTANILLA(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario ingresar los motivos para acudir a la ventanilla",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            if (!(x.list_edificios.length > 0)) {
                                TRAM_FN_VIEWVENTANILLA(index);
                                TRAM_FN_SELECCIONARSECCION(index);
                                Swal.fire({
                                    icon: 'warning',
                                    title: x.name,
                                    text: "Es necesario seleccionar al menos un edificio",
                                    footer: ''
                                });
                                cancel_forEach = true;
                            } else {
                                var section = {
                                    CONF_NID: 0,
                                    CONF_NIDTRAMITE: 0,
                                    CONF_NSECCION: 'Ventanilla sin cita',
                                    CONF_CNOMBRESECCION: 'Ventanilla sin cita',
                                    CONF_ESTATUSSECCION: true,
                                    CONF_NDIASHABILES: null,
                                    CONF_CDESCRIPCIONCITA: null,
                                    CONF_CDESCRIPCIONVENTANILLA: x.descripcion_ventanilla,
                                    CONF_NORDEN: index + 1,
                                    CONF_LIST_FORMULARIO: [],
                                    CONF_LIST_DOCUMENTO: [],
                                    CONF_LIST_EDIFICIO: x.list_edificios,
                                    CONF_LIST_PAGO: [],
                                    CONF_LIST_RESOLUTIVO: []
                                };
                                tramite.TRAM_LIST_SECCION.push(section);
                            }
                        }
                        break;
                    case 5:
                        if (!(x.list_pago.length > 0)) {
                            TRAM_FN_VIEWPAGO(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario seleccionar al menos un concepto de pago",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Pago en línea',
                                CONF_CNOMBRESECCION: 'Pago en línea',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: x.list_pago,
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 6:
                        var section = {
                            CONF_NID: 0,
                            CONF_NIDTRAMITE: 0,
                            CONF_NSECCION: 'Módulo de análisis interno del área',
                            CONF_CNOMBRESECCION: 'Módulo de análisis interno del área',
                            CONF_ESTATUSSECCION: true,
                            CONF_NDIASHABILES: null,
                            CONF_CDESCRIPCIONCITA: null,
                            CONF_CDESCRIPCIONVENTANILLA: null,
                            CONF_NORDEN: index + 1,
                            CONF_LIST_FORMULARIO: [],
                            CONF_LIST_DOCUMENTO: [],
                            CONF_LIST_EDIFICIO: [],
                            CONF_LIST_PAGO: [],
                            CONF_LIST_RESOLUTIVO: []
                        };
                        tramite.TRAM_LIST_SECCION.push(section);
                        break;
                    case 7:
                        if (!(x.list_resolutivo.length > 0)) {
                            TRAM_FN_VIEWRESOLUTIVO(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario seleccionar el resolutivo",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Resolutivo electrónico',
                                CONF_CNOMBRESECCION: 'Resolutivo electrónico',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: x.list_resolutivo
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    default:
                        break;
                }

                if (cancel_forEach) throw BreakException;
            });

        } catch (e) {
            if (e !== BreakException) {
                Swal.fire({
                    icon: 'error',
                    title: "Error al validar",
                    text: "Ocurrío un error al validar: " + e,
                    footer: ''
                });
            }
            return;
        }

        //Plazo días habiles resolutivo y notificacion de trámite
        var txtPlazo_diasResolucion = 0;
        var txtPlazo_diasNotificacion = 0;

        if (parseInt($('#txtPlazo_diasResolucion').val()) > 0) {
            txtPlazo_diasResolucion = parseInt($('#txtPlazo_diasResolucion').val());
        }

        if (parseInt($('#txtPlazo_diasNotificacion').val()) > 0) {
            txtPlazo_diasNotificacion = parseInt($('#txtPlazo_diasNotificacion').val());
        }

        tramite.TRAM_NDIASHABILESRESOLUCION = txtPlazo_diasResolucion;
        tramite.TRAM_NDIASHABILESNOTIFICACION = txtPlazo_diasNotificacion;

        $('#loading_save').show();
        $.ajax({
            data: tramite,
            dataType: 'json',
            url: "/gestores/crear",
            type: "POST",
            success: function(response) {

                if (response.codigo === 200) {
                    window.location.replace(response.ruta)
                } else {
                    $('#loading_save').hide();
                    Swal.fire({
                        icon: "error",
                        title: 'ERROR',
                        text: "Ocurrió un error al guardar la información, contacte al administrador.",
                        footer: ''
                    });
                }
            },
            error: function(data) {

                $('#loading_save').hide();

                Swal.fire({
                    icon: "error",
                    title: 'ERROR',
                    text: "Ocurrió un error al guardar la información, contacte al administrador.",
                    footer: ''
                });
            }
        });
    }

    function TRAM_FN_ENVIAR_ENLACE() {

        //Validacion tablero
        if (list_sections.length >= 2) {
            var existeCitaResolutivo = list_sections.find(x => x.id === 3 || x.id === 7);
            if (typeof existeCitaResolutivo === 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Aviso!',
                    text: 'Es necesario tener al menos dos elementos en el tablero y que la última acción corresponda a "Cita" o "Resolutivo electrónico".',
                    footer: ''
                });
                return;
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: '¡Aviso!',
                text: 'Es necesario tener al menos dos elementos en el tablero y que la última acción corresponda a "Cita" o "Resolutivo electrónico".',
                footer: ''
            });
            return;
        }

        var IntTramite = "{{request()->route('tramiteID') }}";
        var IntTramiteConfig = "{{request()->route('tramiteIDConfig') }}";

        var tramite = {
            TRAM_NIDTRAMITE_ACCEDE: IntTramite,
            TRAM_NIDTRAMITE_CONFIG: IntTramiteConfig,
            TRAM_NDIASHABILESRESOLUCION: 0,
            TRAM_NDIASHABILESNOTIFICACION: 0,
            TRAM_NIMPLEMENTADO: 0,
            TRAM_NENLACEOFICIAL: 1,
            TRAM_LIST_SECCION: []
        };

        var cancel_forEach = false;
        var BreakException = {};

        try {
            list_sections.forEach(function(x, index) {

                switch (x.id) {
                    case 1:

                        var validateFormulario = TRAM_FN_VALIDAR_FORMULARIO();

                        if (validateFormulario.valido === false) {
                            TRAM_FN_VIEWFORMULARIO();
                            TRAM_FN_SELECCIONARSECCION(0);
                            Swal.fire({
                                icon: 'warning',
                                title: "Formulario",
                                text: validateFormulario.mensaje,
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {

                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Formulario',
                                CONF_CNOMBRESECCION: x.name,
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };

                            section.CONF_LIST_FORMULARIO.push({
                                TRAM_NIDFORMULARIO: id_formulario,
                                TRAM_NIDTRAMITE: 0,
                            });

                            section.CONF_LIST_DOCUMENTO = validateFormulario.documentos;

                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 2:

                        if (!(x.dias_habiles > 0)) {
                            TRAM_FN_VIEWREVISION(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Indique el número de días hábiles que tendrá el solicitante para que atienda las observaciones",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {

                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Revisión de documentación',
                                CONF_CNOMBRESECCION: 'Revisión de documentación',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: x.dias_habiles,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 3:
                        if (x.descripcion_cita === null || x.descripcion_cita === "") {
                            TRAM_FN_VIEWCITA(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario ingresar los motivos para acudir a la cita",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Citas en línea',
                                CONF_CNOMBRESECCION: 'Citas en línea',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: x.descripcion_cita,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 4:
                        if (x.descripcion_ventanilla === null || x.descripcion_ventanilla === "") {
                            TRAM_FN_VIEWVENTANILLA(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario ingresar los motivos para acudir a la ventanilla",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            if (!(x.list_edificios.length > 0)) {
                                TRAM_FN_VIEWVENTANILLA(index);
                                TRAM_FN_SELECCIONARSECCION(index);
                                Swal.fire({
                                    icon: 'warning',
                                    title: x.name,
                                    text: "Es necesario seleccionar al menos un edificio",
                                    footer: ''
                                });
                                cancel_forEach = true;
                            } else {
                                var section = {
                                    CONF_NID: 0,
                                    CONF_NIDTRAMITE: 0,
                                    CONF_NSECCION: 'Ventanilla sin cita',
                                    CONF_CNOMBRESECCION: 'Ventanilla sin cita',
                                    CONF_ESTATUSSECCION: true,
                                    CONF_NDIASHABILES: null,
                                    CONF_CDESCRIPCIONCITA: null,
                                    CONF_CDESCRIPCIONVENTANILLA: x.descripcion_ventanilla,
                                    CONF_NORDEN: index + 1,
                                    CONF_LIST_FORMULARIO: [],
                                    CONF_LIST_DOCUMENTO: [],
                                    CONF_LIST_EDIFICIO: x.list_edificios,
                                    CONF_LIST_PAGO: [],
                                    CONF_LIST_RESOLUTIVO: []
                                };
                                tramite.TRAM_LIST_SECCION.push(section);
                            }
                        }
                        break;
                    case 5:
                        if (!(x.list_pago.length > 0)) {
                            TRAM_FN_VIEWPAGO(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario seleccionar al menos un concepto de pago",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Pago en línea',
                                CONF_CNOMBRESECCION: 'Pago en línea',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: x.list_pago,
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 6:
                        var section = {
                            CONF_NID: 0,
                            CONF_NIDTRAMITE: 0,
                            CONF_NSECCION: 'Módulo de análisis interno del área',
                            CONF_CNOMBRESECCION: 'Módulo de análisis interno del área',
                            CONF_ESTATUSSECCION: true,
                            CONF_NDIASHABILES: null,
                            CONF_CDESCRIPCIONCITA: null,
                            CONF_CDESCRIPCIONVENTANILLA: null,
                            CONF_NORDEN: index + 1,
                            CONF_LIST_FORMULARIO: [],
                            CONF_LIST_DOCUMENTO: [],
                            CONF_LIST_EDIFICIO: [],
                            CONF_LIST_PAGO: [],
                            CONF_LIST_RESOLUTIVO: []
                        };
                        tramite.TRAM_LIST_SECCION.push(section);
                        break;
                    case 7:
                        if (!(x.list_resolutivo.length > 0)) {
                            TRAM_FN_VIEWRESOLUTIVO(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario seleccionar el resolutivo",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Resolutivo electrónico',
                                CONF_CNOMBRESECCION: 'Resolutivo electrónico',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: x.list_resolutivo
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    default:
                        break;
                }

                if (cancel_forEach) throw BreakException;
            });

        } catch (e) {
            if (e !== BreakException) {
                Swal.fire({
                    icon: 'error',
                    title: "Error al validar",
                    text: "Ocurrío un error al validar: " + e,
                    footer: ''
                });
            }
            return;
        }

        //Plazo días habiles resolutivo y notificacion de trámite
        var txtPlazo_diasResolucion = 0;
        var txtPlazo_diasNotificacion = 0;

        if (parseInt($('#txtPlazo_diasResolucion').val()) > 0) {
            txtPlazo_diasResolucion = parseInt($('#txtPlazo_diasResolucion').val());
        }

        if (parseInt($('#txtPlazo_diasNotificacion').val()) > 0) {
            txtPlazo_diasNotificacion = parseInt($('#txtPlazo_diasNotificacion').val());
        }

        tramite.TRAM_NDIASHABILESRESOLUCION = txtPlazo_diasResolucion;
        tramite.TRAM_NDIASHABILESNOTIFICACION = txtPlazo_diasNotificacion;

        $('#loading_save').show();
        $.ajax({
            data: tramite,
            dataType: 'json',
            url: "/gestores/crear",
            type: "POST",
            success: function(response) {

                if (response.codigo === 200) {
                    window.location.replace(response.ruta)
                } else {
                    $('#loading_save').hide();
                    Swal.fire({
                        icon: "error",
                        title: 'ERROR',
                        text: "Ocurrió un error al guardar la información, contacte al administrador.",
                        footer: ''
                    });
                }
            },
            error: function(data) {

                $('#loading_save').hide();

                Swal.fire({
                    icon: "error",
                    title: 'ERROR',
                    text: "Ocurrió un error al guardar la información, contacte al administrador.",
                    footer: ''
                });
            }
        });
    }

    function TRAM_FN_IMPLEMENTAR() {

        //Validacion tablero
        if (list_sections.length >= 2) {
            var existeCitaResolutivo = list_sections.find(x => x.id === 3 || x.id === 7);
            if (typeof existeCitaResolutivo === 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Aviso!',
                    text: 'Es necesario tener al menos dos elementos en el tablero y que la última acción corresponda a "Cita" o "Resolutivo electrónico".',
                    footer: ''
                });
                return;
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: '¡Aviso!',
                text: 'Es necesario tener al menos dos elementos en el tablero y que la última acción corresponda a "Cita" o "Resolutivo electrónico".',
                footer: ''
            });
            return;
        }

        var IntTramite = "{{request()->route('tramiteID') }}";
        var IntTramiteConfig = "{{request()->route('tramiteIDConfig') }}";

        var tramite = {
            TRAM_NIDTRAMITE_ACCEDE: IntTramite,
            TRAM_NIDTRAMITE_CONFIG: IntTramiteConfig,
            TRAM_NDIASHABILESRESOLUCION: 0,
            TRAM_NDIASHABILESNOTIFICACION: 0,
            TRAM_NIMPLEMENTADO: 1,
            TRAM_NENLACEOFICIAL: 1,
            TRAM_LIST_SECCION: []
        };

        var cancel_forEach = false;
        var BreakException = {};

        try {
            list_sections.forEach(function(x, index) {

                switch (x.id) {
                    case 1:

                        var validateFormulario = TRAM_FN_VALIDAR_FORMULARIO();

                        if (validateFormulario.valido === false) {
                            TRAM_FN_VIEWFORMULARIO();
                            TRAM_FN_SELECCIONARSECCION(0);
                            Swal.fire({
                                icon: 'warning',
                                title: "Formulario",
                                text: validateFormulario.mensaje,
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {

                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Formulario',
                                CONF_CNOMBRESECCION: x.name,
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };

                            section.CONF_LIST_FORMULARIO.push({
                                TRAM_NIDFORMULARIO: id_formulario,
                                TRAM_NIDTRAMITE: 0,
                            });

                            section.CONF_LIST_DOCUMENTO = validateFormulario.documentos;

                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 2:

                        if (!(x.dias_habiles > 0)) {
                            TRAM_FN_VIEWREVISION(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Indique el número de días hábiles que tendrá el solicitante para que atienda las observaciones",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {

                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Revisión de documentación',
                                CONF_CNOMBRESECCION: 'Revisión de documentación',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: x.dias_habiles,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 3:
                        if (x.descripcion_cita === null || x.descripcion_cita === "") {
                            TRAM_FN_VIEWCITA(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario ingresar los motivos para acudir a la cita",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Citas en línea',
                                CONF_CNOMBRESECCION: 'Citas en línea',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: x.descripcion_cita,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 4:
                        if (x.descripcion_ventanilla === null || x.descripcion_ventanilla === "") {
                            TRAM_FN_VIEWVENTANILLA(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario ingresar los motivos para acudir a la ventanilla",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            if (!(x.list_edificios.length > 0)) {
                                TRAM_FN_VIEWVENTANILLA(index);
                                TRAM_FN_SELECCIONARSECCION(index);
                                Swal.fire({
                                    icon: 'warning',
                                    title: x.name,
                                    text: "Es necesario seleccionar al menos un edificio",
                                    footer: ''
                                });
                                cancel_forEach = true;
                            } else {
                                var section = {
                                    CONF_NID: 0,
                                    CONF_NIDTRAMITE: 0,
                                    CONF_NSECCION: 'Ventanilla sin cita',
                                    CONF_CNOMBRESECCION: 'Ventanilla sin cita',
                                    CONF_ESTATUSSECCION: true,
                                    CONF_NDIASHABILES: null,
                                    CONF_CDESCRIPCIONCITA: null,
                                    CONF_CDESCRIPCIONVENTANILLA: x.descripcion_ventanilla,
                                    CONF_NORDEN: index + 1,
                                    CONF_LIST_FORMULARIO: [],
                                    CONF_LIST_DOCUMENTO: [],
                                    CONF_LIST_EDIFICIO: x.list_edificios,
                                    CONF_LIST_PAGO: [],
                                    CONF_LIST_RESOLUTIVO: []
                                };
                                tramite.TRAM_LIST_SECCION.push(section);
                            }
                        }
                        break;
                    case 5:
                        if (!(x.list_pago.length > 0)) {
                            TRAM_FN_VIEWPAGO(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario seleccionar al menos un concepto de pago",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Pago en línea',
                                CONF_CNOMBRESECCION: 'Pago en línea',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: x.list_pago,
                                CONF_LIST_RESOLUTIVO: []
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    case 6:
                        var section = {
                            CONF_NID: 0,
                            CONF_NIDTRAMITE: 0,
                            CONF_NSECCION: 'Módulo de análisis interno del área',
                            CONF_CNOMBRESECCION: 'Módulo de análisis interno del área',
                            CONF_ESTATUSSECCION: true,
                            CONF_NDIASHABILES: null,
                            CONF_CDESCRIPCIONCITA: null,
                            CONF_CDESCRIPCIONVENTANILLA: null,
                            CONF_NORDEN: index + 1,
                            CONF_LIST_FORMULARIO: [],
                            CONF_LIST_DOCUMENTO: [],
                            CONF_LIST_EDIFICIO: [],
                            CONF_LIST_PAGO: [],
                            CONF_LIST_RESOLUTIVO: []
                        };
                        tramite.TRAM_LIST_SECCION.push(section);
                        break;
                    case 7:
                        if (!(x.list_resolutivo.length > 0)) {
                            TRAM_FN_VIEWRESOLUTIVO(index);
                            TRAM_FN_SELECCIONARSECCION(index);
                            Swal.fire({
                                icon: 'warning',
                                title: x.name,
                                text: "Es necesario seleccionar el resolutivo",
                                footer: ''
                            });
                            cancel_forEach = true;
                        } else {
                            var section = {
                                CONF_NID: 0,
                                CONF_NIDTRAMITE: 0,
                                CONF_NSECCION: 'Resolutivo electrónico',
                                CONF_CNOMBRESECCION: 'Resolutivo electrónico',
                                CONF_ESTATUSSECCION: true,
                                CONF_NDIASHABILES: null,
                                CONF_CDESCRIPCIONCITA: null,
                                CONF_CDESCRIPCIONVENTANILLA: null,
                                CONF_NORDEN: index + 1,
                                CONF_LIST_FORMULARIO: [],
                                CONF_LIST_DOCUMENTO: [],
                                CONF_LIST_EDIFICIO: [],
                                CONF_LIST_PAGO: [],
                                CONF_LIST_RESOLUTIVO: x.list_resolutivo
                            };
                            tramite.TRAM_LIST_SECCION.push(section);
                        }
                        break;
                    default:
                        break;
                }

                if (cancel_forEach) throw BreakException;
            });

        } catch (e) {
            if (e !== BreakException) {
                Swal.fire({
                    icon: 'error',
                    title: "Error al validar",
                    text: "Ocurrío un error al validar: " + e,
                    footer: ''
                });
            }
            return;
        }

        //Plazo días habiles resolutivo y notificacion de trámite
        var txtPlazo_diasResolucion = 0;
        var txtPlazo_diasNotificacion = 0;

        if (parseInt($('#txtPlazo_diasResolucion').val()) > 0) {
            txtPlazo_diasResolucion = parseInt($('#txtPlazo_diasResolucion').val());
        }

        if (parseInt($('#txtPlazo_diasNotificacion').val()) > 0) {
            txtPlazo_diasNotificacion = parseInt($('#txtPlazo_diasNotificacion').val());
        }

        tramite.TRAM_NDIASHABILESRESOLUCION = txtPlazo_diasResolucion;
        tramite.TRAM_NDIASHABILESNOTIFICACION = txtPlazo_diasNotificacion;

        $('#loading_save').show();
        $.ajax({
            data: tramite,
            dataType: 'json',
            url: "/gestores/crear",
            type: "POST",
            success: function(response) {

                if (response.codigo === 200) {
                    window.location.replace(response.ruta)
                } else {
                    $('#loading_save').hide();
                    Swal.fire({
                        icon: "error",
                        title: 'ERROR',
                        text: "Ocurrió un error al guardar la información, contacte al administrador.",
                        footer: ''
                    });
                }
            },
            error: function(data) {

                $('#loading_save').hide();

                Swal.fire({
                    icon: "error",
                    title: 'ERROR',
                    text: "Ocurrió un error al guardar la información, contacte al administrador.",
                    footer: ''
                });
            }
        });
    }
</script>
@endsection