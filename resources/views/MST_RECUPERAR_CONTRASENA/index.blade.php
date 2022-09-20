<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/template/img/favicon_queretaro/android-chrome.png') }}" rel="shortcut icon">
    <link href="{{ asset('assets/template/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/fonts/fontawesome-5.0.6/css/fontawesome-all.css') }}" rel="stylesheet">
</head>

<body oncopy="return false" oncut="return false" onpaste="return false">
    <div class="container-sm">
        <!-- <%-- Contenido individual --%> -->
        <br><br>
        <br><br>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card p-4">
                        <div class="card-body text-body text-center">
                            <h5 id="ModalRecuperarContrasenaTitle">Recuperar contraseña</h5>
                            <div class="listError"></div>
                            <div class="MensajeSuccess"></div>
                            <p>La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial.</p>
                            <form id="frmFormRecuperar_Contrasena" name="frmFormRecuperar_Contrasena">
                                <input type="hidden" name="txtIntIdUsuario" value="{{$IntIdUsuario}}">
                                <input type="hidden" name="txtStrToken" value="{{$StrToken}}">
                                <input type="hidden" name="txtIntTipo" value="{{$IntTipo}}">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="txtContrasena_Nueva" id="txtContrasena_Nueva"
                                        placeholder="Contraseña nueva" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="txtConformacion_Contrasena" id="txtConformacion_Contrasena"
                                        placeholder="Confirmación de contraseña nueva" required>
                                </div>
                            </form>
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary btnSubmit" id="btnEnviar" onclick="TRAM_AJX_ENVIAR();">Aceptar</button>
                                    <button class="btn btn-danger" onclick="TRAM_FN_LOGIN();">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('assets/template/js/jquery.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="js/popper.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script src="{{ asset('assets/template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/mdb/js/mdb.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/jquery.validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert2/sweet-alert.init.js') }}"></script>

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

            $.validator.addMethod( 'passwordMatch', function(value, element) {
                var password = $("#txtContrasena_Nueva").val();
                var confirmPassword = $("#txtConformacion_Contrasena").val();
                if (password != confirmPassword ) {
                    return false;
                } else {
                    return true;
                }
            });
                
            $("#frmFormRecuperar_Contrasena").validate({
                focusInvalid: false,
                invalidHandler: function() {
                    $(this).find(":input.error:first").focus();
                },
                rules: {
                    txtContrasena_Nueva: {
                        minlength: 6,
                        maxlength: 20,
                        passwordcheck:true
                    },
                    txtConformacion_Contrasena: {
                        minlength: 6,
                        maxlength: 20,
                        passwordcheck:true,
                        passwordMatch: true
                    }
                },
                messages: {
                    txtContrasena_Nueva: {
                        passwordcheck: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                        minlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                        maxlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                        required: ""
                    },
                    txtConformacion_Contrasena: {
                        passwordcheck: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                        minlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                        maxlength: "La contraseña debe tener mínimo 6 y máximo 20 caracteres, incluir al menos un número, una letra mayúscula, una letra minúscula y un carácter especial. favor de verificar.",
                        passwordMatch: "La contraseña no coincide, favor de verificar.",
                        required: ""
                    }
                }
            });
        });

        function TRAM_AJX_ENVIAR(){
            $("#btnEnviar").prop("disabled", true);
            if (!$("#frmFormRecuperar_Contrasena").valid()){
                $('.listError').hide();
                var validator = $('#frmFormRecuperar_Contrasena').validate();
                var htmlError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
                $.each(validator.errorList, function (index, value) {
                    var campo = $("#"+ value.element.id).attr('placeholder');
                    if(value.method == "required"){
                        $('.listError').show();
                        htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                    }
                });
                htmlError += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $(".listError").html(htmlError);
                $("#btnEnviar").prop("disabled", false);
                return;
            }
            $.ajax({
                data: $('#frmFormRecuperar_Contrasena').serialize(),
                url: "/cambiar_contrasena",
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
                                $(".listError").html("");
                                TRAM_FN_LOGIN();
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
        };

        //Redirige a login
        function TRAM_FN_LOGIN(){
            document.location.href = '/';
        };
    </script>
    @yield('scripts')
</body>
</html>