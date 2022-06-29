@extends('layout.Layout')

@section('body')
<!-- <%-- Contenido individual --%> -->
<div class="container-fluid contentPage">
    <br>
    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12" style="text-align: left;">
                    <h2 class="titulo">{{$tramite['nombre']}}</h2>
                    <h6 class="text-warning">{{$tramite['responsable']}}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: left;">
                    <h6><strong>Folio: </strong>ASX-08648</h6>
                    <h6><strong>Fecha de actualización: </strong>20/09/2020</h6>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-12">
                    <!-- <div class="bg-white rounded-lg p-5 shadow"> -->
                    <div>
                        <h2 class="h6 font-weight-bold text-center mb-4">Avance de Trámite</h2>
                        <!-- Progress bar 1 -->
                        <div class="progress_circle mx-auto" data-value='33'>
                            <span class="progress_circle-left">
                                <span class="progress_circle-bar border-primary"></span>
                            </span>
                            <span class="progress_circle-right">
                                <span class="progress_circle-bar border-primary"></span>
                            </span>
                            <div class="progress_circle-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                <div class="h2 font-weight-bold" style="color:#03A9F4 !important;">33<sup class="small">%</sup></div>
                            </div>
                        </div>
                        <!-- END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label style="font-weight: bold; font-size:20px;">Indique el módulo en el cuál prefiere que se lleve a cabo el trámite</label>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <!-- <div class="col-md-4"> -->
                        <div class="form-group row col-md-12">
                            <label class="col-sm-2 col-form-label" for="cmbMunicipio">Municipio</label>
                            <div class="col-sm-10">
                                <select class="combobox form-control" name="cmbMunicipio" id="cmbMunicipio">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- <div class="col-md-4"> -->
                        <div class="form-group row col-md-12">
                            <label class="col-sm-2 col-form-label" for="cmbModulo">Módulo</label>
                            <div class="col-sm-10">
                                <select class="combobox form-control" name="cmbModulo" id="cmbModulo">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-5">
                            <label style="font-weight: bold; font-size:20px;">Ubicación</label>
                            <label style="font-size: 12px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore nisi sit quo eligendi sequi eius temporibus rerum, dicta, architecto possimus, fugiat nam suscipit amet natus? Sequi alias beatae facere dolore.</small>
                        </div>
                        <div class="col-7">
                            <div id="mapa" style="height:170px;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card" style="width: 100%; border-radius:20px;">
            <div class="card-header" style="background-color: #ffffff; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <div class="arrow-steps clearfix">
                    <div class="step" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;"> <span>Identificación</span> </div>
                    <div class="step current"> <span>Contacto</span> </div>
                    <div class="step"> <span>Laboral</span> </div>
                    <div class="step"> <span>Carácteristicas Físicas</span> </div>
                    <div class="step"> <span>Académicos</span> </div>
                    <div class="step"> <span>Financieros</span> </div>
                    <div class="step"> <span>Otros</span> </div>
                    <div class="step" style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;"> <span>Documentos</span> </div>
                </div>
            </div>
            <div class="card-body" style="color: #23468c;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtNombre">Nombres(s)</label>
                            <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre (s)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtPrimerApellido">Primer apellido</label>
                            <input type="text" class="form-control" name="txtPrimerApellido" id="txtPrimerApellido" placeholder="Primer apellido">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtSegundoApellido">Segundo apellido</label>
                            <input type="text" class="form-control" name="txtSegundoApellido" id="txtSegundoApellido" placeholder="Segundo apellido">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <button type="submit" class="btn btn-primary float-right">Guardar información</button>
                <button type="submit" class="btn btn-success float-right" style="margin-right:10px;">Siguiente</button>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card" style="width: 100% !important; border-radius:20px;">
            <div class="card-header" style="background-color: #23468c; color: #ffffff; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h6 class="card-title">Notificaciones</h6>
            </div>
            <div class="card-body" style="color: #212529;">

                <div class="row">
                    <div class="card text-left cardNotification">
                        <div class="card-header titleCard">
                            Marton Sanchez | Secretaría de Gobierno | Creado: 27/12/2020 15:23 hras | Leído: Pendiente
                        </div>
                        <div class="card-body cardItemNotification">

                            <div class="row" style="padding: 5px; background-color: #D3EDF9;">
                                <div class="col-10">
                                    <strong style="font-size: 1rem;">Observaciones</strong>
                                    <p style="color:#212529">Descripcion de la notificacion que se le hizo al usuario</p>
                                </div>
                                <div class="col-2 btnCard">
                                    <a href="{{route('detalle_notificacion', 1)}}" class="btn" style="background-color: #E91E63; color:#ffffff">Consultar </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <label style="padding-left: 20px;">Por el momento, no existen observaciones.</label> -->
                </div>
                <br>
                <div class="row">
                    <div class="card text-left cardNotification">
                        <div class="card-header titleCard">
                            Marton Sanchez | Secretaría de Gobierno | Creado: 27/12/2020 15:23 hras | Leído: Pendiente
                        </div>
                        <div class="card-body cardItemNotification">

                            <div class="row" style="padding: 5px; background-color: #D3EDF9;">
                                <div class="col-10">
                                    <strong style="font-size: 1rem;">Observaciones</strong>
                                    <p style="color:#212529">Descripcion de la notificacion que se le hizo al usuario</p>
                                </div>
                                <div class="col-2 btnCard">
                                    <a href="{{route('detalle_notificacion', 1)}}" class="btn" style="background-color: #E91E63; color:#ffffff">Consultar </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <label style="padding-left: 20px;">Por el momento, no existen observaciones.</label> -->
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="divider"></div>
    </div>
</div>
<br />
<style>
    .titleCard {
        text-align: left;
        background-color: transparent;
        border-bottom: none;
        font-weight: bold;
    }

    .cardItemNotification {
        padding-top: .5rem;
        margin-left: 1rem;
        border: 1px solid #393939;
        background-color: #d3edf9;
        margin-right: 1rem;
        padding-bottom: .5rem;
    }

    .cardNotification {
        width: 100% !important;
        border: none;
        border-top: dotted;
        border-radius: initial;
    }

    .btnCard {
        display: flex;
        justify-content: center;
        align-items: center;
    }


    /* Porcentaje */
    .border-primary {
        border-color: #03A9F4 !important;
    }

    .progress_circle {
        width: 150px;
        height: 150px;
        background: none;
        position: relative;
    }

    .progress_circle::after {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 12px solid #03BAFF;
        position: absolute;
        top: 0;
        left: 0;
    }

    .progress_circle>span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .progress_circle .progress_circle-left {
        left: 0;
    }

    .progress_circle .progress_circle-bar {
        width: 100%;
        height: 100%;
        background: none;
        border-width: 12px;
        border-style: solid;
        position: absolute;
        top: 0;
    }

    .progress_circle .progress_circle-left .progress_circle-bar {
        left: 100%;
        border-top-right-radius: 80px;
        border-bottom-right-radius: 80px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }

    .progress_circle .progress_circle-right {
        right: 0;
    }

    .progress_circle .progress_circle-right .progress_circle-bar {
        left: -100%;
        border-top-left-radius: 80px;
        border-bottom-left-radius: 80px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
    }

    .progress_circle .progress_circle-value {
        position: absolute;
        top: 0;
        left: 0;
    }

    /* ----------*/
    /* ----------*/
    .clearfix:after {
        clear: both;
        content: "";
        display: block;
        height: 0;
    }

    .container {
        font-family: 'Lato', sans-serif;
        width: 1000px;
        margin: 0 auto;
    }

    .wrapper {
        display: table-cell;
        /* height: 400px; */
        vertical-align: middle;
    }

    .nav {
        margin-top: 40px;
    }

    .pull-right {
        float: right;
    }

    a,
    a:active {
        color: #333;
        text-decoration: none;
    }

    a:hover {
        color: #999;
    }

    /* Breadcrups CSS */

    .arrow-steps .step {
        font-size: 14px;
        text-align: center;
        color: #666;
        cursor: default;
        margin: 0 3px;
        padding: 10px 10px 10px 30px;
        min-width: 180px;
        float: left;
        position: relative;
        background-color: #d9e3f7;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        transition: background-color 0.2s ease;
    }

    .arrow-steps .step:after,
    .arrow-steps .step:before {
        content: " ";
        position: absolute;
        top: 0;
        right: -17px;
        width: 0;
        height: 0;
        border-top: 19px solid transparent;
        border-bottom: 17px solid transparent;
        border-left: 17px solid #d9e3f7;
        z-index: 2;
        transition: border-color 0.2s ease;
    }

    .arrow-steps .step:before {
        right: auto;
        left: 0;
        border-left: 17px solid #fff;
        z-index: 0;
    }

    .arrow-steps .step:first-child:before {
        border-radius: 10px;
        border: none;
    }

    .arrow-steps .step:last-child:after {
        border-radius: 10px;
        border: none;
    }

    .arrow-steps .step:first-child {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .arrow-steps .step span {
        position: relative;
    }

    .arrow-steps .step span:before {
        opacity: 0;
        content: "✔";
        position: absolute;
        top: -2px;
        left: -20px;
    }

    .arrow-steps .step.done span:before {
        opacity: 1;
        -webkit-transition: opacity 0.3s ease 0.5s;
        -moz-transition: opacity 0.3s ease 0.5s;
        -ms-transition: opacity 0.3s ease 0.5s;
        transition: opacity 0.3s ease 0.5s;
    }

    .arrow-steps .step.current {
        color: #fff;
        background-color: #23468c;
    }

    .arrow-steps .step.current:after {
        border-left: 17px solid #23468c;
    }

    .step {
        height: 36px;
        margin-top: 5px !important;
        margin-bottom: 5px !important;
    }

    /* ----------*/
    /* ----------*/






    .contentPage {
        background-color: #ffffff;
        height: calc(100% - 104px);
        margin-bottom: 5px;
        position: absolute;
        width: calc(100% - 25px) !important;
        margin-left: 15px !important;
        margin-right: 10px !important;
    }

    .titulo {
        font-weight: bold;
    }

    .sizeBtnArrow {
        width: 65px !important;
    }

    [data-toggle="collapse"] .fa:before {
        content: "\f107";
        font-size: 1.5rem;
        vertical-align: middle;
        color: #7F7F7F;
    }

    [data-toggle="collapse"].collapsed .fa:before {
        content: "\f105";
        font-size: 1.5rem;
        vertical-align: middle;
        color: #7F7F7F;
    }
</style>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".progress_circle").each(function() {

            var value = $(this).attr('data-value');
            var left = $(this).find('.progress_circle-left .progress_circle-bar');
            var right = $(this).find('.progress_circle-right .progress_circle-bar');

            if (value > 0) {
                if (value <= 50) {
                    right.css('transform', 'rotate(' + TRAM_FN_CALCULARPORCENTAJE(value) + 'deg)')
                } else {
                    right.css('transform', 'rotate(180deg)')
                    left.css('transform', 'rotate(' + TRAM_FN_CALCULARPORCENTAJE(value - 50) + 'deg)')
                }
            }
        })

        $("#cmbMunicipio").change(function() {

            var id_municipio = $(this).val();

            if (id_municipio > 0) {

                $('#cmbModulo').prop('disabled', false);
                TRAM_AJX_CONSULTARMODULO(id_municipio);

            } else {
                $('#cmbModulo').prop('disabled', 'disabled');
            }
        });

        //Cargar mapa y ubicacion de oficina
        setTimeout(function() {

            map = new google.maps.Map(document.getElementById('mapa'), {
                center: {
                    lat: -34.5862088,
                    lng: -58.415677500000015
                },
                zoom: 15,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_CENTER,
                },
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.BOTTOM_RIGHT,
                },
            });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(-34.5862088, -58.415677500000015),
                map: map,
                title: 'Ubicación'
            });
        }, 1000);


        function TRAM_FN_DESACTIVARMODULO() {
            $('#cmbModulo').prop('disabled', 'disabled');
        }

        function TRAM_FN_CALCULARPORCENTAJE(percentage) {
            return percentage / 100 * 360
        }

        function TRAM_AJX_CONSULTARMUNICIPIO() {
            var cmbMunicipio = $("#cmbMunicipio");

            $.ajax({
                url: " {{ route('iniciar_tramite_obtener_municipio') }}",
                type: "GET",
                success: function(data) {

                    // Limpiamos el select
                    cmbMunicipio.find('option').remove();

                    //Opcion por defecto
                    cmbMunicipio.append('<option disabled selected>Seleccione</option>');

                    $(data).each(function(i, v) { // indice, valor
                        cmbMunicipio.append('<option value="' + v.id + '">' + v.nombre + '</option>');
                    })
                },
                error: function(data) {
                    Swal.fire({
                        icon: data.status,
                        title: '',
                        text: data.message,
                        footer: ''
                    });
                }
            });
        }

        function TRAM_AJX_CONSULTARMODULO(id_municipio) {
            var cmbModulo = $("#cmbModulo");

            $.ajax({
                url: "/tramite_servicio/obtener_modulo/" + id_municipio + "",
                type: "GET",
                success: function(data) {

                    // Limpiamos el select
                    cmbModulo.find('option').remove();

                    //Opcion por defecto
                    cmbModulo.append('<option disabled selected>Seleccione</option>');

                    $(data).each(function(i, v) { // indice, valor
                        cmbModulo.append('<option value="' + v.id + '">' + v.nombre + '</option>');
                    })
                },
                error: function(data) {
                    Swal.fire({
                        icon: data.status,
                        title: '',
                        text: data.message,
                        footer: ''
                    });
                }
            });
        }


        TRAM_AJX_CONSULTARMUNICIPIO();
        TRAM_FN_DESACTIVARMODULO();
    });
</script>
@endsection
