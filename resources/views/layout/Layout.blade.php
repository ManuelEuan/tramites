<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Querétaro</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/template/img/favicon_queretaro/android-chrome.png') }}" rel="shortcut icon">
    <link href="{{ asset('assets/template/css/bootstrap.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/template/plugins/Datepicker/css/bootstrap-datepicker.standalone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/template/plugins/Fullcalendar/main.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/template/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="{{ asset('assets/template/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/template/css/formvalidation.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/bootstrap-combobox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/fcradio.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/fonts/fontawesome-5.0.6/css/fontawesome-all.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.js"></script>

    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCt4ojZ4Cm-gaHsBxN9fL7Urw9XbowMs9o&libraries=places,drawing" async defer></script>
    <script src="{{ asset('assets/template/plugins/ckeditor/ckeditor.js ') }}"></script>
</head>

<body>

    <div class="wrapper">
        @if(Auth::user() != null)
        @include('layout.Navbar')

        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light lighten-4 ">
                <div class="float-left" id="sidebarCollapse">
                    <a class="button-collapse" href="#!" data-activates="slide-out"><i class="fas fa-bars fa-lg"></i></a>
                </div>

                <!-- Breadcrumb-->
                <div class="mr-auto">
                    <!-- <nav aria-label="breadcrumb ">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item"><a href="#!">Inicio</a></li>

                        </ol>
                    </nav> -->
                </div>


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="far fa-bell"></i>
                                <span id="spanNotificacion" class="badge badge-warning navbar-badge" style="font-size: .6rem; font-weight: 300; padding: 2px 4px; position: absolute; left: 16px; top: 9px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="max-width: 480px; min-width: 480px; padding: 0;">
                                <div style="max-height: 420px; overflow: auto;">
                                    <div id="seccionNotificacion" style="margin-top: 50px; margin-bottom:50px;text-align: center"> Sin Notificaciones </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-user-circle"></i>
                                @if(Auth::user() != null)
                                {{Auth::user()->USUA_CNOMBRES}} {{Auth::user()->USUA_CPRIMER_APELLIDO}}
                                @endif
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <!-- <%--<a class="dropdown-item" href="#">Ayuda</a>--%> -->
                                {{-- <a class="dropdown-item" download="ManualCitas.pdf" href="docs/ManualCitas.pdf">Manual</a>
                                <a class="dropdown-item" data-toggle="modal" data-target="#mdlPrivacidad" href="#">Aviso
                                    de privacidad</a> --}}
                                <div class="dropdown-divider"></div>
                                <input type="hidden" id="usuarioLogueado" value="{{Auth::user()->USUA_NIDUSUARIO}}">
                                <a class="dropdown-item" href="/perfil">Mi Expediente</a>
                                <a class="dropdown-item" href="/bitacora">Bitácora</a>
                                <a class="dropdown-item" href="/logout">Cerrar sesión</a>

                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('body')

            <div id="" app></div>

            <!-- Modal de aviso de provacidad -->
            {{-- <div class="modal fade" id="mdlPrivacidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body" style="font-size: 12px">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="bold">AVISO DE PRIVACIDAD INTEGRAL</h4>
                                <h4 class="bold">SISTEMA DE GESTIÓN CIUDADANA DE TRÁMITES Y SERVICIOS</h4>
                            </div>
                        </div>
                        <hr style="background:#f7af00; height: 3px;" />
                        <h6 class="bold">ACERCA DE LA SECRETARÍA DE LA FUNCIÓN PÚBLICA </h6>
                        La Secretaría de la Función Pública es la Dependencia del Poder Ejecutivo del Estado de
                        Chihuahua, responsable de diseñar, dirigir y coordinar la implementación de la política
                        pública de mejora regulatoria con las dependencias y entidades de la Administración Pública
                        Estatal, enfocándose en la reducción de cargas administrativas en los trámites y servicios
                        del Estado.
                        <br />
                        <br />
                        Asimismo, le compete coordinar la estrategia de digitalización de los trámites y servicios
                        de la Administración Pública Estatal, así como consolidar el uso y aprovechamiento de las
                        tecnologías de la información para fomentar canales directos de vinculación con la
                        ciudadanía.
                        <br />
                        <br />
                        Esta Dependencia es la responsable del uso y protección de sus datos personales, y se
                        localiza en la Calle Victoria número 310, Colonia Centro, Código Postal 31000, Edificio Lic.
                        Oscar Flores, en la Ciudad de Chihuahua, Chihuahua.
                        <br />
                        <br />
                        <h6 class="bold">LOS DATOS PERSONALES QUE SERÁN RECABADOS DE USTED EN EL SISTEMA DE GESTIÓN
                            CIUDADANA DE TRÁMITES Y SERVICIOS, SERÁN UTILIZADOS PARA LAS SIGUIENTES FINALIDADES:
                        </h6>

                        1. Contar con un registro de las personas servidoras públicas que brindan atención a la
                        ciudadanía por medio de citas en línea.<br />
                        2. Contactarle en caso de algún problema relacionado con las citas en línea.<br />
                        <br />

                        La información proporcionada a través de este sistema puede ser incluida en los informes que
                        se elaboran para el seguimiento de avances institucionales, los cuales serán meramente
                        estadísticos y no incluirán información que permita identificarle en lo individual.
                        <br />
                        <br />
                        <h6 class="bold">¿QUÉ DATOS PERSONALES UTILIZAREMOS EN EL SISTEMA DE GESTIÓN CIUDADANA DE
                            TRÁMITES Y SERVICIOS? </h6>

                        Para llevar a cabo las finalidades descritas en el presente aviso de privacidad,
                        utilizaremos los siguientes datos personales:
                        <br />

                        • Nombre<br />
                        • Correo electrónico<br />
                        • Número de contacto<br />
                        <br />
                        Es preciso señalar que se le podrá solicitar algún dato adicional, a fin de llevar a cabo
                        las finalidades establecidas.
                        <br />
                        <br />
                        <h6 class="bold">¿CON QUIÉN COMPARTIMOS SU INFORMACIÓN PERSONAL Y PARA QUÉ FINES?</h6>

                        Los datos personales que se ingresen en el Sistema de Gestión Ciudadana de Trámites y
                        Servicios, podrán ser transferidos únicamente a personal de su Dependencia o Entidad de
                        adscripción.
                        <br />
                        <br />
                        No serán difundidos, distribuidos o comercializados con terceros. Únicamente podrán ser
                        proporcionados a terceros previa autorización del titular de los mismos y bajo alguno de los
                        supuestos que contempla el artículo 20 de la Ley de Protección de Datos Personales del
                        Estado de Chihuahua.
                        <br />
                        <br />
                        <h6 class="bold">FUNDAMENTO JURÍDICO</h6>

                        En cumplimiento a lo establecido por los artículos 6, apartado A, de la Constitución
                        Política de los Estados Unidos Mexicanos, 4, fracción III, de la Constitución Política del
                        Estado de Chihuahua, 3 fracción II, 16, 18, 20 fracción III, 21, 26, 27, 28 y 69 de la Ley
                        General de Protección de Datos Personales en Posesión de Sujetos Obligados, 11, fracciones
                        I, II, XVI, 16, fracción II, 17, fracción III, 63, 65, 67, 91, fracción II, apartado a), de
                        la Ley de Protección de Datos Personales del Estado de Chihuahua y demás legislación
                        relativa y aplicable en la materia.
                        <br />
                        <br />
                        <h6 class="bold">¿CÓMO PUEDE ACCEDER, RECTIFICAR O CANCELAR SUS DATOS PERSONALES, U OPONERSE
                            A SU USO?</h6>

                        La persona usuaria del Sistema de Gestión Ciudadana de Trámites y Servicios, tiene derecho a
                        conocer cuáles de sus datos personales se encuentran registrados, para qué los utilizamos y
                        las condiciones del uso que les damos (Acceso). Asimismo, es su derecho solicitar la
                        corrección de su información personal en caso de que esté desactualizada, sea inexacta o
                        incompleta (Rectificación); que la eliminemos de nuestros registros o bases de datos cuando
                        considere que la misma no está siendo utilizada conforme a los principios, deberes y
                        obligaciones previstas en la normativa (Cancelación); así como oponerse al uso de sus datos
                        personales para fines específicos (Oposición). Estos derechos se conocen como derechos ARCO.
                        <br />
                        <br />
                        La persona usuaria podrá ejercer sus Derechos de Acceso, Rectificación, Cancelación,
                        Oposición (ARCO), así como negativa al tratamiento de los mismos, ante la Unidad de
                        Transparencia de la Secretaría de la Función Pública, ubicada en Calle Victoria número 310
                        segundo piso, Colonia Centro, Código Postal 31000, Edificio Lic. Oscar Flores, en la Ciudad
                        de Chihuahua, Chih., con teléfono 614 429 3300 extensión 20382, de lunes a viernes, de 8:00
                        horas a las 16:00 horas, o por el correo electrónico
                        unidadtransparencia.sfp@chihuahua.gob.mx y a través de la Plataforma Nacional de
                        Transparencia
                        <a href="http://www.plataformadetransparencia.org.mx/" target="_blank">http://www.plataformadetransparencia.org.mx/</a>

                        <br />
                        <br />
                        <h6 class="bold">¿CÓMO PUEDE CONOCER LOS CAMBIOS A ESTE AVISO DE PRIVACIDAD?</h6>

                        El presente aviso de privacidad puede sufrir modificaciones, cambios o actualizaciones
                        derivadas de nuevos requerimientos legales, por mejoras en el Sistema de Gestión Ciudadana
                        de Trámites y Servicios o por otras causas.
                        <br />
                        <br />
                        Nos comprometemos a mantenerlo informado sobre los cambios que pueda sufrir el presente
                        aviso de privacidad a través del Sistema de Gestión Ciudadana de Trámites y Servicios.

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> --}}
        </div>
        @else
        <div class="col-md-12 mt-5">
            <div class="card text-center">
                <div class="card-header">
                    <h5>Aviso.</h5>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Sesión Expirada</h4>
                    <p class="card-text">Vuelva a introducir sus credenciales.</p>
                    <form action="{{ '/' }}" method="GET">
                        <button type="submit" class="btn btn-success">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>


    {{-- <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script> --}}

    <script src="{{ asset('assets/template/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/template/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/framework/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/sweet-alert.init.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/bootstrap-combobox.js') }}"></script>
    <script src="{{ asset('assets/template/js/Moment.js') }}"></script>

    <script src="{{ asset('assets/template/plugins/Datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/Datepicker/js/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/Fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/Fullcalendar/locales-all.min.js') }}"></script>

    <script src="{{ asset('assets/template/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    @yield('scripts')
</body>
    <script>
            (function(d){var s = d.createElement("script");s.setAttribute("data-account", "DEMJ3A5AsR");s.setAttribute("src", "https://cdn.userway.org/widget.js");(d.body || d.head).appendChild(s);})(document)
    </script>
        <noscript>
            Please ensure Javascript is enabled for purposes of <a href="https://userway.org">website accessibility</a>
        </noscript>
            
    <script>
        $(function() {
            getNotificaciones();
        });

        function formateo(date) {
            let array = date.split(" ");
            let arraySeg = array[1].split(":");
            let seg = arraySeg[0] + ":" + arraySeg[1];
            return array[0].replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1') + " " + seg;
        }

        function getNotificaciones() {
            let data = {
                "usuario_id": $("#usuarioLogueado").val()
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            request = $.ajax({
                url: '/notificaciones',
                type: "post",
                data: data
            });

            // Callback handler that will be called on success
            request.done(function(dataResponse, textStatus, jqXHR) {

                var response = dataResponse.notificaciones;
                var notificaciones_tramite = dataResponse.notificaciones_tramite;
                let html = '<div id="seccionNotificacion">';

                //Notificaciones tramite
                notificaciones_tramite.forEach(element => {
                    let fecha = element.HNOTI_DFECHACREACION == null ? '' : formateo(element.HNOTI_DFECHACREACION);
                    html += `<div class="card text-left" style="margin: .2rem;">
                            <div class="card-header" style="text-align: left; background-color: transparent; border-bottom: none; font-weight: bold;">
                                <div class="row">
                                    <div class="col-8" style="font-size: 16px;">${element.HNOTI_CITUTLO}</div>
                                    <div class="col-4" style="padding-left: 0px !important; padding-right: 0px !important;">
                                        <small>${ fecha } </small><i class="far fa-bell" style="font-size: 1.5rem; vertical-align: bottom;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="font-size: 14px;">
                                ${element.HNOTI_CMENSAJECORTO}
                                <div style="text-align: right; margin-top:25px">
                                    <button type="button" class="btn btn-success btnModal" onclick="FN_AJX_ATENDER_TRAMITE(${element.HNOTI_NIDUSUARIOTRAMITE});">Consultar</button>
                                </div>
                            </div>
                        </div>`;
                });

                //Notificaciones gestor
                response.forEach(element => {
                    let fecha = element.NOTI_DFECHACREAACION == null ? '' : formateo(element.NOTI_DFECHACREAACION);

                    html += `<div class="card text-left" style="margin: .2rem;">
                            <div class="card-header" style="text-align: left; background-color: transparent; border-bottom: none; font-weight: bold;">
                                <div class="row">
                                    <div class="col-8" style="font-size: 16px;">${element.NOTI_CTITULO}</div>
                                    <div class="col-4" style="padding-left: 0px !important; padding-right: 0px !important;">
                                        <small>${ fecha } </small><i class="far fa-bell" style="font-size: 1.5rem; vertical-align: bottom;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="font-size: 14px;">
                                ${element.NOTI_CMENSAJE}
                                <div style="text-align: right; margin-top:25px">
                                    <button type="button" class="btn btn-success btnModal" onclick="vincularGestor(${element.NOTI_NID},'Autorizado','${element.NOTI_CMENSAJE}' )" id="btnAceptarVinculacion">Aceptar</button>
                                    <button type="button" class="btn btn-danger btnModal"  onclick="vincularGestor(${element.NOTI_NID},'Rechazado','${element.NOTI_CMENSAJE}' )" id="btnCancelarVinculacion">Rechazar</button>
                                </div>
                            </div>
                        </div>`;
                });
                html += `</div>`;

                let cantidad = (parseInt(response.length) + parseInt(notificaciones_tramite.length)) > 9 ? '+9' : (parseInt(response.length) + parseInt(notificaciones_tramite.length));

                if (cantidad > 0) {
                    $("#seccionNotificacion").replaceWith(html);
                }

                if (cantidad != 0) {
                    $("#spanNotificacion").text(cantidad);
                }
            });
        }

        function vincularGestor(id, accion, nombre) {
            let data = {
                "id": id,
                "respuesta": accion
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let resta = nombre.split("te agregó");

            request = $.ajax({
                url: '/gestores_solicitud/respuesta',
                type: "post",
                data: data
            });

            let operacion = accion == 'Autorizado' ? 'autorizar' : 'rechazar';
            Swal.fire({
                title: '¿Esta seguro de ' + operacion + " la solicitud?",
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Callback handler that will be called on success
                    request.done(function(response, textStatus, jqXHR) {

                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito! ya puede realizar trámites o servicios en representación de ' + resta[0],
                                showConfirmButton: false,
                                timer: 1500
                            });
                            getNotificaciones();

                            
                            location.reload();
                        }, 400);
                    });

                    // Callback handler that will be called on failure
                    request.fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'se presento el siguiente error: ' + errorThrown
                        });
                        getNotificaciones();
                    });
                }
            });
        }

        function FN_AJX_ATENDER_TRAMITE(HNOTI_NIDUSUARIOTRAMITE) {
            location.href = "/tramite_servicio/seguimiento_tramite/" + HNOTI_NIDUSUARIOTRAMITE;
        }
    </script>

</html>
