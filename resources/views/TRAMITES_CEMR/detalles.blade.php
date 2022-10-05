@extends('layout.Layout')
@section('body')
<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12" style="text-align: left;">
                    <h2 class="titulo">{{$tramite->USTR_CNOMBRE_TRAMITE}}</h2><br><br>
                    <h2 class="subtitulo">{{$tramite->USTR_CCENTRO}}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">
                                <div id="tab_formulario" class="tab-pane fade pestana active show">
                                    <div class="row columna">
                                        <div class="col-md-3">
                                            <label class="titulo_pequeno">Nombre</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CNOMBRE}}</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="titulo_pequeno">Primer Apellido</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CPRIMER_APELLIDO}}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="titulo_pequeno">Segundo Apellido</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CSEGUNDO_APELLIDO}}</label>
                                        </div>
                                        @if($tramite->USTR_NESTATUS != 10)
                                        <div class="col-md-3">
                                            <button id="btnRevision" disabled class="btn btn-primary btnLetras" 
                                            onclick="seguimiento()" type="button">Iniciar revisión</button>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row columna">
                                        <div class="col-md-3">
                                            <label class="titulo_pequeno">RFC</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CRFC}}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="titulo_pequeno">CURP</label> <br>
                                            <label class='respuesta_pequena'>{{$tramite->USTR_CCURP}}</label>
                                        </div>
                                    </div>
                                    {{-- Acoordion secciones de formulario y documentos--}}
                                    <div class="row columna">
                                        <div class="col-md-12">
                                            <div id="accordion">
                                            </div>
                                            <div id="accordion_documentos">
                                                <div class="card">
                                                    <div class="card-header" id="heading_documento">
                                                        <h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapse_documento" aria-controls="collapse_documento">Documentos</button></h5>
                                                    </div>
                                                    <div id="collapse_documento" class="collapse " aria-labelledby="heading_documento" data-parent="#accordion_documentos"></div>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                    {{-------------------}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />

<div id="loading_" class="loadingFrame" class="text-center" style="display: none !important;">
    <div class="inner">
        <div class="spinner-grow text-secondary" role="status">

        </div>
        <p style="color: #393939 !important;">Cargando Formulario...</p>
    </div>
</div>

<!-- Modal de ver documentos -->
<div class="modal fade" id="modalDocumento" tabindex="-1" role="dialog" aria-labelledby="modalDocumentoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="modalContentDocumento" class="modal-content" style="width: 720px; height: 720px;">
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    var list_documentos = [];
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function TRAM_AJX_RENDER_TRAMITE() {

            var id = "{{request()->route('id') }}";
            list_documentos = [];

            $.ajax({
                url: "/tramite_servicio_cemr/obtener_tramite/" + id + "",
                type: "GET",
                success: function(data) {

                    var tramite = data.tramite[0];

                    //Buton de habilitar trámite
                    if (tramite.USTR_NESTATUS <= 2) {
                        $("#btnRevision").text("Iniciar revisión");
                        $("#btnRevision").prop("disabled", false);
                    } else if (tramite.USTR_NESTATUS > 2) {
                        $("#btnRevision").text("Ir a revisón");
                        $("#btnRevision").prop("disabled", false);
                    }

                    var secciones_formularios = data.configuracion.formularios[0].secciones;

                    $('#accordion').html('');
                    var divSectionContainer = $('#accordion');

                    $.each(secciones_formularios, function(index, value) {

                        if (!(value.preguntas.length > 0)) {
                            return;
                        }

                        var show = index === 0 ? "show" : "";
                        var list_text_area = [];

                        var itemCollapse = '<div class="card">' +
                            '<div class="card-header" id="heading_' + value.FORM_NID + '">' +
                            '<h5 class="mb-0">' +
                            '<button class="btn btn-link" data-toggle="collapse" data-target="#collapse_' + value.FORM_NID + 
                            '" aria-controls="collapse_' + value.FORM_NID + '">' + '' + value.FORM_CNOMBRE + '' +
                            '</button>' +
                            '</h5>' +
                            '</div>';

                        var collapse_detalle = '<div id="collapse_' + value.FORM_NID + '" class="collapse ' + show + '" aria-labelledby="heading_' + value.FORM_NID + '" data-parent="#accordion">' +
                            '<div class="card-body">';

                        $.each(value.preguntas, function(index_preguntas, value_pregunta) {

                            switch (value_pregunta.FORM_CTIPORESPUESTA) {
                                case "abierta":

                                    collapse_detalle += '<p>' +
                                        '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>' +
                                        '<label class="respuesta_pequena">' + value_pregunta.respuestas[0].FORM_CVALOR_RESPUESTA + '</label>' +
                                        '</p>';

                                    break;
                                case "unica":

                                    collapse_detalle += '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>';
                                    $.each(value_pregunta.respuestas, function(index_respuesta, value_respuesta) {
                                        collapse_detalle += '<div class="form-check">' +
                                            '<input ' + value_respuesta.FORM_CVALOR_RESPUESTA + ' style="pointer-events:none; width: 20px; height: 20px;" class="form-check-input" type="radio" name="radion_respuesta_' + value_respuesta.FORM_NPREGUNTAID + '" id="radion_respuesta_' + value_respuesta.FORM_NID + '">' +
                                            '<label style="pointer-events:none; padding-top: 4px; padding-left: 8px; font-size: 14px;" class="form-check-label" for="radion_respuesta_' + value_respuesta.FORM_NID + '">' +
                                            value_respuesta.FORM_CVALOR +
                                            '</label>' +
                                            '</div>';
                                    });

                                    break;
                                case "especial":

                                    collapse_detalle += '<br>';
                                    collapse_detalle += '<div class="form-group">' +
                                        '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>' +
                                        '<table class="table table-striped table-bordered">' +
                                        '<tr>';

                                    $.each(value_pregunta.respuestas, function(index_respuesta, value_respuesta) {

                                        collapse_detalle += '<th>';
                                        collapse_detalle += '' + value_respuesta.FORM_CVALOR + '';
                                        collapse_detalle += '</th>';
                                    });
                                    collapse_detalle += '</tr>';

                                    collapse_detalle += '<tr>';
                                    $.each(value_pregunta.respuestas, function(index_respuesta, value_respuesta) {

                                        switch (value_respuesta.FORM_CTIPORESPUESTAESPECIAL) {
                                            case "numerico":
                                                collapse_detalle += '<th>';
                                                collapse_detalle += '' + value_respuesta.respuestas_especial[0].FORM_CVALOR_RESPUESTA + '';
                                                collapse_detalle += '</th>';
                                                break;

                                            case "opciones":
                                                var selected = value_respuesta.respuestas_especial.find(x => x.FORM_CVALOR_RESPUESTA === "selected");
                                                collapse_detalle += '<th>';
                                                collapse_detalle += '' + selected.FORM_CVALOR + '';
                                                collapse_detalle += '</th>';
                                                break;
                                            default:

                                                if (value_respuesta.respuestas_especial.length > 0) {
                                                    collapse_detalle += '<th>';
                                                    collapse_detalle += '' + value_respuesta.respuestas_especial[0].FORM_CVALOR_RESPUESTA + '';
                                                    collapse_detalle += '</th>';
                                                } else {
                                                    collapse_detalle += '<th>';
                                                    collapse_detalle += '';
                                                    collapse_detalle += '</th>';
                                                }
                                                break;
                                        }

                                    });
                                    collapse_detalle += '</tr>';
                                    collapse_detalle += '</table>' +
                                        '</div>';
                                    break;

                                case 'enriquecido':
                                    collapse_detalle += '<br>' +
                                        '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>' +
                                        '<div class="form-group">' +
                                        '<textarea disabled class="txtEnriquecido" name="resp_' + value_pregunta.FORM_NID + '_0"  id="resp_' + value_pregunta.FORM_NID + '_0" rows="5" style="display: block !important;"></textarea>' +
                                        '</div>';

                                    list_text_area.push({
                                        id: 'resp_' + value_pregunta.FORM_NID + '_0',
                                        valor: value_pregunta.respuestas[0].FORM_CVALOR_RESPUESTA
                                    });
                                    break;

                                case 'multiple':
                                    collapse_detalle += '<br>' +
                                        '<label class="titulo_pequeno">' + value_pregunta.FORM_CPREGUNTA + '</label> <br>' +
                                        '<div class="form-group">';

                                    $.each(value_pregunta.respuestas, function(index_respuesta, value_respuesta) {

                                        collapse_detalle += '<div class="form-check">' +
                                            '<input ' + value_respuesta.FORM_CVALOR_RESPUESTA + ' style="pointer-events:none; width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="" id="check_' + value_respuesta.FORM_NID + '">' +
                                            '<label style="pointer-events:none; padding-top: 4px; padding-left: 8px; font-size: 14px;" class="form-check-label" for="check_' + value_respuesta.FORM_NID + '">' +
                                            '' + value_respuesta.FORM_CVALOR + '' +
                                            '</label>' +
                                            '</div>';
                                    });

                                    collapse_detalle += '</div>';
                                    break;

                                default:
                            }

                        });

                        collapse_detalle += '</div>' +
                            '</div>';

                        itemCollapse += collapse_detalle;

                        //Cierre de card
                        itemCollapse += '</div>';
                        divSectionContainer.append(itemCollapse);

                        //Cambiar texto enrequicido
                        if (list_text_area.length > 0) {

                            $.each(list_text_area, function(index_area, value_area) {
                                CKEDITOR.replace(value_area.id);
                                CKEDITOR.instances[value_area.id].setData(value_area.valor);
                            });
                        }
                    });

                    //Agregar documentos
                    $('#collapse_documento').html('');
                    var divSectionContainer_documento = $('#collapse_documento');
                    var lista_documentos = data.configuracion.documentos;
                    var filter = data.configuracion.documentos.filter(x => x.existe === 1);
                    var itemDocumento = "";
                    itemDocumento += '<div class="card-body">';
                    var rfc = '{{ $tramite->USTR_CRFC }}';
                    $.each(lista_documentos, function(index, value) {
                        console.log(rfc)
                        var documento_add = {
                            documento_id: parseInt(value.TRAD_NIDTRAMITEDOCUMENTO),
                            estatus: parseInt(value.TRAD_NESTATUS),
                            observaciones: value.TRAD_COBSERVACION === null ? "" : value.TRAD_COBSERVACION,
                            ruta: value.TRAD_CRUTADOC === null ? "" : value.TRAD_CRUTADOC,
                            nombre: value.TRAD_CNOMBRE,
                            extension: value.TRAD_CEXTENSION
                        };

                        list_documentos.push(documento_add);
                        var icon = "";
                        switch (value.TRAD_CEXTENSION) {
                            case "jpg":
                                icon = "{{ asset('assets/template/img/jpg.png') }}";
                                break;
                            case "png":
                                icon = "{{ asset('assets/template/img/png.png') }}";
                                break;
                            case "pdf":
                                icon = "{{ asset('assets/template/img/pdf.png') }}";
                                break;
                            default:
                                icon = "{{ asset('assets/template/img/doc.png') }}";
                        }

                        //Marcar documentos y indicar observaciones
                        var checkAceptado = "";
                        var checkRechazado = "";
                        var displayTextArea = "none";
                        if (documento_add.estatus === 2) {
                            var checkAceptado = "checked";
                            var checkRechazado = "";
                        } else if (documento_add.estatus === 1) {
                            var checkAceptado = "";
                            var checkRechazado = "checked";
                            displayTextArea = "block";
                        }

                        var rutaDocumento = value.TRAD_CRUTADOC !== null && value.TRAD_CRUTADOC !== "" ? value.TRAD_CRUTADOC : "";

                        itemDocumento += '<div class="row">' +
                            '<div class="col-md-5">' +
                            '<div class="row">' +
                            '<div class="col-2">' +
                            '<img src="' + icon + '" width="25" height="25">' +
                            '</div>' +
                            '<div class="col-8">' +
                            '<p><label class="titulo_pequeno">' + value.TRAD_CNOMBRE + '</label></p>' +
                            '</div>';

                        itemDocumento += '<div class="col-2">';
                        if (value.existe > 0 && rutaDocumento != "") {
                            itemDocumento += '<span style="padding-right: 15px;font-size: 20px;"><i title="Ver documento" style="cursor:pointer;" onclick="TRAM_FN_VER_DOCUMENTO(' + value.TRAD_NIDTRAMITEDOCUMENTO + ')" class="fas fa-eye"></i></span>' +
                                "<a href='{{ asset('') }}" + rutaDocumento + "' style='padding-right: 15px;font-size: 20px;' download='" + documento_add.nombre + '_' + rfc +"'><i title='Descargar documento' class='fas fa-download'></i></a>";
                        }
                        itemDocumento += '</div>'; //col-2
                        itemDocumento += '</div>' + //row
                            '</div>'; //col-md-5

                        // itemDocumento += '<div class="col-md-3 validatePregunta" style="display: block;">' +
                        //     '<div class="form-check form-check-inline">' +
                        //     '<input ' + checkAceptado + ' onchange="TRAM_FN_ACEPTAR_DOCUMENTO(' + value.TRAD_NIDTRAMITEDOCUMENTO + ');" class="form-check-input" type="radio" name="radio_documento_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" id="radio_aceptar_d_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" value="2">' +
                        //     '<label class="form-check-label respuesta_pequena " for="radio_aceptar_d_' + value.TRAD_NIDTRAMITEDOCUMENTO + '">Aceptar</label>' +
                        //     '</div>' +
                        //     '<div class="form-check form-check-inline">' +
                        //     '<input ' + checkRechazado + ' onchange="TRAM_FN_RECHAZAR_DOCUMENTO(' + value.TRAD_NIDTRAMITEDOCUMENTO + ');" class="form-check-input" type="radio" name="radio_documento_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" id="radio_rechazar_d_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" value="1">' +
                        //     '<label class="form-check-label respuesta_pequena" for="radio_rechazar_d_' + value.TRAD_NIDTRAMITEDOCUMENTO + '">Rechazar</label>' +
                        //     '</div>' +
                        //     '</div>' +
                        //     '<div class="col-md-4 validatePregunta" style="display: block;">' +
                        //     '<div class="form-group"><textarea style="display: ' + displayTextArea + ';" onchange="TRAM_FN_JUSTIFICACION_DOCUMENTO(' + value.TRAD_NIDTRAMITEDOCUMENTO + ')" class="form-control txtJustificacion" id="txt_justificacion_documento_' + value.TRAD_NIDTRAMITEDOCUMENTO + '" rows="3" placeholder="Justificacion">' + documento_add.observaciones + '</textarea></div>' +
                        //     '</div>';

                        itemDocumento += ' </div>'; //row
                    });
                    itemDocumento += '</div>'; //card-body
                    divSectionContainer_documento.append(itemDocumento);
                    //--Fin agregar documentos

                    $('#loading_').hide();
                },
                error: function(data) {

                    $('#loading_').hide();
                    Swal.fire({
                        icon: "error",
                        title: 'Error',
                        text: "Ocurrió un error al obtener el trámite.",
                        footer: ''
                    });
                }
            });
        }

        TRAM_AJX_RENDER_TRAMITE();
        $('#loading_').show();
    });

    function seguimiento() {
        let id = "{{request()->route('id') }}";
        location.href = "/tramite_servicio_cemr/seguimiento/" + id;
    }

    function TRAM_FN_VER_DOCUMENTO(id) {

        var doc = list_documentos.find(x => x.documento_id === parseInt(id));
        var host = window.location.origin;
        var rutaa = host + "/" + doc.ruta;

        $("#modalContentDocumento").html("");
        var content = $("#modalContentDocumento");

        if (doc.extension === "png" || doc.extension === "jpg") {

            var documentView = '<div class="modal-header">' +
                '<h5 class="modal-title" id="exampleModalLongTitle">' + doc.nombre + '</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<img id="imgDoc" class="modal-body" src="' + rutaa + '" alt="" style="object-fit: contain; width: 720px; height: 650px;">';
            content.append(documentView);

        } else if (doc.extension === "pdf") {

            var documentView = '<div class="modal-header">' +
                '<h5 class="modal-title" id="exampleModalLongTitle">' + doc.nombre + '</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<iframe class="modal-body" id="pdfDoc" title="' + doc.nombre + '" src="' + rutaa + '">' +
                '</iframe>';

            content.append(documentView);
        }

        $("#modalDocumento").modal('show');
    }
</script>

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

    /* CSS Manuel Euan */
    .titulo {
        width: 100%;
        height: 40px;
        border-top-right-radius: 60px;
        border-bottom-right-radius: 60px;
        margin-top: 2%;
        display: flex;
        align-items: center;
        z-index: -1;
        color: #575654;
        font-size: 32px;
    }

    .subtitulo {
        color: #F8B30A;
        font-size: 22px;
    }

    .pestana {
        min-height: 700px;
    }

    .btnLetras {
        color: #fff;
        font-weight: 900;
        margin-left: 20px;
        min-width: 180px;
    }

    .titulo_pequeno {
        color: #000000;
        font-weight: bold;
        font-size: 18px;
    }

    .respuesta_pequena {
        color: #000000;
        font-size: 18px;
    }

    .columna {
        margin-top: 2%;
        margin-left: 2%;
        "

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
@endsection
