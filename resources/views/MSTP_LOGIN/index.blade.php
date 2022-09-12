<!doctype hQtml>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Queretaro</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <!-- Font Awesome -->
    <link href="{{ asset('assets/template/img/login.png') }}" rel="shortcut icon">
     <link href="{{ asset('assets/template/plugins/mdb/css/mdb.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/fonts.css') }}" rel="stylesheet">
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <style>
        .white {
            color: #fff !important;
        }
        .Texto-menu{
            font-size: 16px !important;
        }
        .card {
            background-color: #333
        }

        .card {
            border: none;
        }

        /* .navbar-gris {
            display: none;
        } */

        .EnUsencuesta {
            z-index: 99;
        }

        footer {
            position: relative !important;
            height: 260px !important;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    @yield('body')
    <div class="container align-items-center">
        <br /><br/><br/>
        <div class="row  justify-content-center">
            <div class="col-md-4">
                <!-- Card -->
                <div class="card" style="background-color: white">
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- Material form register -->
                        <form action="{{url('/login')}}" method="POST" id="frmLogin">
                            {{ csrf_field() }}
                            <p class="h4 medium text-center pt-4 pb-2">
                                <img src="assets/template/img/login.png" height="80px" /><br>
                                <span class="pt-3">Trámites en Línea</span>
                            </p>
                            
                            @if($errors->has('bloqueado'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $errors->first('bloqueado') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <br/>
                            @endif

                            <div class="md-form">
                                <i class="fa fa-user prefix grey-text"></i>
                                <input type="text" name="txtUsuario" id="txtUsuario" class="form-control" autocomplete="off" />
                                <label for="txtUsuario" class="font-weight-light">Usuario</label>
                                @if ($errors->has('txtUsuario'))
                                    <span class="error-constant">¡Error! </span> <span class="error-valid"> {{ $errors->first('txtUsuario') }}</span>
                                    <br/><br/>
                                @endif
                                @if ($errors->has('credenciales'))
                                    <span class="error-constant">¡Error! </span> <span class="error-valid"> {{ $errors->first('credenciales') }}</span>
                                    <br/><br/>
                                @endif    
                            </div>
                            <div class="md-form">
                                <i class="fa fa-lock prefix grey-text "></i>
                                <input type="password" name="txtContrasenia" id="txtContrasenia" class="form-control" autocomplete="off" />
                                <label for="txtContrasenia" class="font-weight-light">Contraseña</label>
                                @if ($errors->has('txtContrasenia'))
                                    <span class="error-constant">¡Error! </span> <span class="error-valid"> {{ $errors->first('txtContrasenia') }}</span>
                                    <br/><br/>
                                @endif
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LfWCPUZAAAAABCAtHf4MNujfOja4VwnypQYY8NW"></div>
                            @if ($errors->has('recaptcha'))
                                <span class="error-constant">¡Error! </span> <span class="error-valid"> {{ $errors->first('recaptcha') }}</span>
                            @endif 
                            @if (Request::has('previous'))
                                <input type="hidden" name="previous_url" value="{{ Request::get('previous_url') }}">
                            @else
                                <input type="hidden" name="previous_url" value="{{ URL::previous() }}">
                            @endif
                            <div class="text-center mt-3">
                                <button class="btn btn-primary" type="submit">Iniciar sesión</button>
                                {{-- <div id="btnEntrar" type="submit" class="btn btn-primary">Iniciar sesión</div> --}}
                            </div>
                            <div class="text-center">
                                <a href="/registrar" class="waves-effect btn-sm">Crear usuario</a>
                            </div>
                            <div class="text-center">
                                <a onclick="javascript:TRAM_FN_RCUPERAR_CONTRASENA();" class=" waves-effect btn-sm">Recuperar
                                    contraseña</a>
                            </div>
                            <div class="text-center">
                                <div class="alert alert-dismissible alert-danger text-left" id="divMensajePassword"
                                    style="display: none">
                                    <strong>Usuario o password incorrecto</strong>
                                </div>
                            </div>
                        </form>
                        <!-- Material form register -->

                    </div>
                    <!-- Card body -->
                </div>
                <!-- Card -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalRecuperarContrasena" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ModalRecuperarContrasena" aria-hidden="true">
        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-radius-6">
                <div class="modal-header not-border-bottom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-5 not-padding-top not-padding-bottom">
                    <h5 class="modal-title" id="ModalRecuperarContrasenaTitle">Recuperar contraseña</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="listError"></div>
                            <p>Por favor, capture el correo para recuperar su contraseña.</p>
                            <form id="frmFormRecuperar_Contrasena" name="frmFormRecuperar_Contrasena">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="txtCorreo_Electronico" id="txtCorreo_Electronico"
                                        placeholder="Correo electrónico o correo electrónico alternativo" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mx-auto not-border-top not-padding-top">
                    <button type="button" class="btn btn-primary btn-md border-radius-6" id="btnEnviar" onclick="TRAM_AJX_ENVIAR()">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/template/js/jquery.js') }}"></script>
    {{-- <script type="text/javascript" src="js/popper.min.js"></script> --}}
    <script src="{{ asset('assets/template/plugins/mdb/js/mdb.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/sweet-alert.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script>(function(d){var s = d.createElement("script");s.setAttribute("data-account", "DEMJ3A5AsR");s.setAttribute("src", "https://cdn.userway.org/widget.js");(d.body || d.head).appendChild(s);})(document)</script><noscript>Please ensure Javascript is enabled for purposes of <a href="https://userway.org">website accessibility</a></noscript>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.validator.addMethod("passwordcheck", function(value) {
                return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value)// has a special character
                },"La contraseña debe contener de 8 a 15 carácteres alfanuméricos (a-z A-Z), contener mínimo un dígito (0-9) y un carácter especial (_-=)."  
            );
                
            $("#frmLogin").validate({
                focusInvalid: false,
                invalidHandler: function() {
                    $(this).find(":input.error:first").focus();
                },
                rules: {
                    txtUsuario: {
                        email: true
                    },
                    txtContrasenia: {
                        minlength: 6,
                        maxlength: 20,
                        passwordcheck:true
                    }
                },
                messages: {
                    txtUsuario: {
                        email: "El correo que se agregó no es válido, favor de verificar."
                    },
                    txtContrasenia: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. Favor de verificar."
                }
            });

            $("#frmFormRecuperar_Contrasena").validate({
                focusInvalid: false,
                invalidHandler: function() {
                    $(this).find(":input.error:first").focus();
                },
                rules: {
                    txtCorreo_Electronico: {
                        email: true
                    }
                },
                messages: {
                    txtCorreo_Electronico: {
                        email: "El correo que se agregó no es válido, favor de verificar.",
                        required: ""
                    },
                }
            });
        });

        function TRAM_FN_RCUPERAR_CONTRASENA(){
            $("#ModalRecuperarContrasena").modal('show');
        };

        function TRAM_AJX_ENVIAR(){
            $("#btnEnviar").prop("disabled", true);
            if (!$("#frmFormRecuperar_Contrasena").valid()){
                var validator = $('#frmFormRecuperar_Contrasena').validate();
                var htmlError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><b>Los siguientes datos son obligatorios:</b> <br/>";
                $.each(validator.errorList, function (index, value) {
                    var campo = $("#"+ value.element.id).attr('placeholder');
                    if(value.method == "required"){
                        htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                    }
                });
                htmlError += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $(".listError").html(htmlError);
                $("#btnEnviar").prop("disabled", false);
                return;
            }
            Swal.fire({
                title: '¡Confirmar!',
                text: "Se enviará un correo con las instrucciones para la restauración de la contraseña ¿Desea continuar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        data: $('#frmFormRecuperar_Contrasena').serialize(),
                        url: "/recuperar_contrasena",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $("#btnEnviar").prop("disabled", false);
                            if(data.status == "success"){
                                $('#frmFormRecuperar_Contrasena').trigger("reset");
                                Swal.fire({
                                    title: '¡Éxito!',
                                    text: data.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar'
                                }).then((result2) => {
                                    if (result2.isConfirmed) {
                                        $("#ModalRecuperarContrasena").modal('hide');
                                        $(".listError").html("");
                                    }
                                });
                            }else {
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
                            $("#btnEnviar").prop("disabled", false);
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
            });
        };
    </script>
</body>
</html>
