@extends('layout.Layout')

@section('body')
    <?php
    header('Access-Control-Allow-Origin: *');
    // dd($tramite);
    // dd($tramite['modulo']);
    ?>
    <!-- <%-- Contenido individual --%> -->
    <div class="container-fluid contentPage">
        <br>
        <div class="row">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <h2 class="titulo">{{ $tramite['nombre'] }}</h2>
                        <h6 class="text-warning">{{ $tramite['responsable'] }}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <h6><strong>Folio: </strong>{{ $tramite['folio'] }}</h6>
                        <h6><strong>Fecha de actualización: </strong>{{ $tramite['fechaactualizacion'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="row">
                    <div class="col-12">
                        <!-- <div class="bg-white rounded-lg p-5 shadow"> -->
                        <div>
                            @if($tramite['estatus'] != 1 && $tramite['estatus'] != 2)
                            <h2 class="h6 font-weight-bold text-center mb-4">Avance de Trámite</h2>
                            <!-- Progress bar 1 -->
                            
                            <div class="progress_circle mx-auto" data-value='0'>
                                <span class="progress_circle-left">
                                    <span class="progress_circle-bar border-primary"></span>
                                </span>
                                <span class="progress_circle-right">
                                    <span class="progress_circle-bar border-primary"></span>
                                </span>
                                <div
                                    class="progress_circle-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                    <div class="h2 font-weight-bold" style="color:#03A9F4 !important;">
                                        <span id="porcentaje">0</span>
                                        <sup class="small">%</sup>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label style="font-weight: bold; font-size:20px;">Por favor ingrese la información solicitada:</label>
            </div>
            @if($tramite['estatus'] == 4)
            <div class="col-md-12 alert alert-warning" role="alert">
                    Estimado usuario, su trámite tiene observaciones por parte de la dependencia, le recordamos que cuenta con un plazo de {{$tramite['dias_resolucion']}} días, a partir de recibir esta notificación, para poder atender las observaciones, le recordamos que en caso de no atender estas observaciones su trámite será cancelado.
                </div>
            @endif
            @if($tramite['estatus'] != 1 && $tramite['estatus'] != 8 && $tramite['estatus'] != 4)
                <div class="col-md-12 alert alert-warning" role="alert">
                    El trámite se encuentra en proceso de revisión por la dependencia, se notificará vía sistema cuando proceda la siguiente fase.
                </div>
            @endif
            <div id="estatusFormulario"> </div>
        </div>

        <div class="row">
            <div class="card" style="width: 100%; border-radius:20px;">
                <div class="card-header"
                    style="background-color: #ffffff; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <div class="arrow-steps clearfix">
                        <?php
                        $cont = 0;
                        $total = count($tramite['configuracion']['secciones']) - 1;
                        $aprobados = 0;
                        ?>
                        @if (count($tramite['configuracion']['secciones']) > 0)
                            @foreach ($tramite['configuracion']['secciones'] as $confsec)
                                @if ($confsec->CONF_NSECCION != 'Módulo de análisis interno del área')
                                    @if ($cont == 0)
                                        <div class="step step_seccion {{ $confsec->CONF_NESTATUS_SEGUIMIENTO == 1 ? 'seccion-disabled' : '' }}"
                                            id="seccionconfig_{{ $confsec->CONF_NIDCONFIGURACION }}"
                                            data-seccion="{{ $confsec->CONF_NIDCONFIGURACION }}"
                                            style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                                            <span>{{ $confsec->CONF_NSECCION }}</span>
                                            @if ($confsec->CONF_NESTATUS_SEGUIMIENTO == 2)
                                                <?php $aprobados++; ?>
                                                <span><img src="{{ asset('assets/template/img/check.png') }}" width="20"
                                                        height="20"></span>
                                            @elseif($confsec->CONF_NESTATUS_SEGUIMIENTO == 3)
                                                <span><img src="{{ asset('assets/template/img/error.png') }}" width="20"
                                                        height="20"></span>
                                            @endif
                                        </div>
                                    @elseif($cont == $total)
                                        <div class="step step_seccion {{ $tramite['configuracion']['secciones'][$cont - 1]->CONF_NESTATUS_SEGUIMIENTO == 2 ? '' : 'seccion-disabled' }}"
                                            id="seccionconfig_{{ $confsec->CONF_NIDCONFIGURACION }}"
                                            data-seccion="{{ $confsec->CONF_NIDCONFIGURACION }}"
                                            style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;">
                                            <span>{{ $confsec->CONF_NSECCION }}</span>
                                            @if ($confsec->CONF_NESTATUS_SEGUIMIENTO == 2)
                                                <?php $aprobados++; ?>
                                                <span><img src="{{ asset('assets/template/img/check.png') }}" width="20"
                                                        height="20"></span>
                                            @elseif($confsec->CONF_NESTATUS_SEGUIMIENTO == 3)
                                                <span><img src="{{ asset('assets/template/img/error.png') }}" width="20"
                                                        height="20"></span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="step step_seccion {{ $tramite['configuracion']['secciones'][$cont - 1]->CONF_NESTATUS_SEGUIMIENTO == 2 ? '' : 'seccion-disabled' }}"
                                            id="seccionconfig_{{ $confsec->CONF_NIDCONFIGURACION }}"
                                            data-seccion="{{ $confsec->CONF_NIDCONFIGURACION }}">
                                            <span>{{ $confsec->CONF_NSECCION }}</span>
                                            @if ($confsec->CONF_NESTATUS_SEGUIMIENTO == 2)
                                                <?php $aprobados++; ?>
                                                <span><img src="{{ asset('assets/template/img/check.png') }}" width="20"
                                                        height="20"></span>
                                            @elseif($confsec->CONF_NESTATUS_SEGUIMIENTO == 3)
                                                <span><img src="{{ asset('assets/template/img/error.png') }}" width="20"
                                                        height="20"></span>
                                            @endif
                                        </div>
                                    @endif
                                    <?php $cont++; ?>
                                @else
                                    <?php $total--; ?>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="card-body" style="color: #23468c;">
                    @if (count($tramite['configuracion']['secciones']) > 0)
                        @foreach ($tramite['configuracion']['secciones'] as $confsec)
                            <div id="contenedor_{{ $confsec->CONF_NIDCONFIGURACION }}" style="display: none">
                                @switch($confsec->CONF_NSECCION)
                                    @case('Formulario')
                                        <?php
                                        $cont_error = 0;
                                        $estatus_seguimiento = $confsec->CONF_NESTATUS_SEGUIMIENTO;
                                        ?>
                                        <div class="arrow-steps clearfix">
                                            @if (count($tramite['configuracion']['formularios']) > 0)
                                                @foreach ($tramite['configuracion']['formularios'] as $form)
                                                    @if ($form->secciones > 0)
                                                        <?php
                                                        $_cont = 0;
                                                        $_total = count($form->secciones) - 1;
                                                        $total_sec_form = 0;
                                                        ?>
                                                        @foreach ($form->secciones as $sec)
                                                            @if (count($sec->preguntas) > 0)
                                                                <?php
                                                                $estatus_tab = 0;
                                                                $total_sec_form++;
                                                                $estatusGuardado = 0;
                                                                $check = 0;
                                                                $tipo = '';
                                                                ?>
                                                                @foreach ($sec->preguntas as $preg)
                                                                    @if ($preg->estatus == 1)
                                                                        <?php $estatus_tab++; ?>
                                                                        <?php $cont_error++; ?>
                                                                    @endif

                                                                    @if ($preg->estatus == 9)
                                                                        <?php $estatusGuardado++; ?>
                                                                    @endif
                                                                    @if($preg->FORM_NID == 571)
                                                                        @if($preg->FORM_CTIPORESPUESTA == 'multiple')
                                                                            <?php $tipo = 'multiple' ?>
                                                                            @foreach($preg->respuestas as $resp)
                                                                                @if($resp->FORM_CVALOR_RESPUESTA == 'checked')
                                                                                    <?php $check++; ?>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                                @if ($_cont == 0)
                                                                    <div class="step step_form"
                                                                        id="seccion_{{ $sec->FORM_NID }}"
                                                                        data-seccion="{{ $sec->FORM_NID }}"
                                                                        style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                                                                        <span>{{ $sec->FORM_CNOMBRE }}</span>
                                                                        <span id="form_seccion_{{ $sec->FORM_NID }}">
                                                                            @if ($estatus_tab > 0)
                                                                                <span><img
                                                                                    src="{{ asset('assets/template/img/error.png') }}"
                                                                                    width="20" height="20"></span>
                                                                            @elseif($estatusGuardado > 0)
                                                                                <span><img
                                                                                        src="{{ asset('assets/template/img/error.png') }}"
                                                                                        width="20" height="20"></span>
                                                                            @else
                                                                                <span><img
                                                                                    src="{{ asset('assets/template/img/check.png') }}"
                                                                                    width="20" height="20"></span>
                                                                            @endif
                                                                        </span>
                                                                        <input class="full" type="hidden" value="{{$sec->FORM_NID}}">
                                                                    </div>
                                                                @elseif($_cont == $total_sec_form - 1)
                                                                    @if (count($tramite['configuracion']['documentos']) == 0)
                                                                        <div class="step step_form"
                                                                            id="seccion_{{ $sec->FORM_NID }}"
                                                                            data-seccion="{{ $sec->FORM_NID }}"
                                                                            style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;">
                                                                            <span>{{ $sec->FORM_CNOMBRE }}</span>
                                                                            <span id="form_seccion_{{ $sec->FORM_NID }}">
                                                                                @if ($estatus_tab > 0)
                                                                                    <span><img
                                                                                        src="{{ asset('assets/template/img/error.png') }}"
                                                                                        width="20" height="20"></span>
                                                                                @elseif($estatusGuardado > 0)
                                                                                    <span><img
                                                                                            src="{{ asset('assets/template/img/error.png') }}"
                                                                                            width="20" height="20"></span>
                                                                                @else
                                                                                    <span><img
                                                                                        src="{{ asset('assets/template/img/check.png') }}"
                                                                                        width="20" height="20"></span>
                                                                                @endif

                                                                            </span>
                                                                            <input class="full" type="hidden" value="{{$sec->FORM_NID}}">
                                                                        </div>
                                                                    @else
                                                                        <div class="step step_form"
                                                                            id="seccion_{{ $sec->FORM_NID }}"
                                                                            data-seccion="{{ $sec->FORM_NID }}">
                                                                            <span>{{ $sec->FORM_CNOMBRE }}</span>
                                                                            <span id="form_seccion_{{ $sec->FORM_NID }}">
                                                                                @if($tipo != '' && $tipo == 'multiple')
                                                                                    @if($check <= 0)
                                                                                        <span><img
                                                                                            src="{{ asset('assets/template/img/error.png') }}"
                                                                                            width="20" height="20"></span>
                                                                                    @else
                                                                                        <span><img
                                                                                            src="{{ asset('assets/template/img/check.png') }}"
                                                                                            width="20" height="20"></span>
                                                                                    @endif
                                                                                @else
                                                                                    @if ($estatus_tab > 0)
                                                                                        <span><img
                                                                                            src="{{ asset('assets/template/img/error.png') }}"
                                                                                            width="20" height="20"></span>
                                                                                    @elseif($estatusGuardado > 0)
                                                                                        <span><img
                                                                                                src="{{ asset('assets/template/img/error.png') }}"
                                                                                                width="20" height="20"></span>
                                                                                    @else
                                                                                        <span><img
                                                                                            src="{{ asset('assets/template/img/check.png') }}"
                                                                                            width="20" height="20"></span>
                                                                                    @endif
                                                                                @endif
                                                                            </span>
                                                                            <input class="full" type="hidden" value="{{$sec->FORM_NID}}">
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    <div class="step step_form"
                                                                        id="seccion_{{ $sec->FORM_NID }}"
                                                                        data-seccion="{{ $sec->FORM_NID }}">
                                                                        <span>{{ $sec->FORM_CNOMBRE }}</span>
                                                                        <span id="form_seccion_{{ $sec->FORM_NID }}">
                                                                            @if ($estatus_tab > 0)
                                                                                <span><img
                                                                                        src="{{ asset('assets/template/img/error.png') }}"
                                                                                        width="20" height="20"></span>
                                                                            @else
                                                                                <span><img
                                                                                        src="{{ asset('assets/template/img/check.png') }}"
                                                                                        width="20" height="20"></span>
                                                                            @endif
                                                                        </span>
                                                                        <input class="full" type="hidden" value="{{$sec->FORM_NID}}">
                                                                    </div>
                                                                @endif
                                                                <?php $_cont++; ?>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                            <?php $estatus_tab = 0; ?>
                                            @if (count($tramite['configuracion']['documentos']) > 0)
                                                @foreach ($tramite['configuracion']['documentos'] as $doc)
                                                    @if ($doc->TRAD_NESTATUS == 1 || $doc->TRAD_NESTATUS == 999999 )
                                                        <?php $estatus_tab++; ?>
                                                        <?php $cont_error++; ?>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if (count($tramite['configuracion']['documentos']) > 0)
                                                <div class="step step_form" id="seccion_0" data-seccion="0"
                                                    style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;">
                                                    <span>Documentos</span>
                                                    <span id="form_seccion_0">
                                                        @if ($estatus_tab > 0)
                                                            <span><img src="{{ asset('assets/template/img/error.png') }}"
                                                                    width="20" height="20"></span>
                                                        @else
                                                            <span><img src="{{ asset('assets/template/img/check.png') }}"
                                                                    width="20" height="20"></span>
                                                        @endif
                                                        <input class="full" type="hidden" value="0">
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <form enctype="multipart/form-data" id="frmForm">
                                            <input type="hidden" name="txtIdTramite" value="{{ $tramite['id'] }}">
                                            <input type="hidden" name="txtEstatus" value="{{ $tramite['estatus'] }}">
                                            <input type="hidden" name="txtFolio" value="{{ $tramite['folio'] }}">
                                            <input type="hidden" name="txtIdUsuario" value="{{ $tramite['idsuario'] }}">
                                            @if (count($tramite['configuracion']['secciones']) > 0)
                                                @foreach ($tramite['configuracion']['secciones'] as $confsec)
                                                    <input type="hidden" name="secc_{{ $confsec->CONF_NIDCONFIGURACION }}" value="{{ $confsec->CONF_NSECCION }}">
                                                @endforeach
                                            @endif
                                            @if (count($tramite['configuracion']['formularios']) > 0)
                                                @foreach ($tramite['configuracion']['formularios'] as $form)
                                                    @if ($form->secciones > 0)
                                                        @foreach ($form->secciones as $sec)
                                                            <div class="row form" id="form_{{ $sec->FORM_NID }}"
                                                                style="display: none">
                                                                @foreach ($sec->preguntas as $preg)
                                                                    @switch($preg->FORM_CTIPORESPUESTA)
                                                                        @case('abierta')
                                                                            <div class="col-md-4">
                                                                                <div class="form-group {{ $preg->estatus == 1 ? 'error-input' : '' }}">
                                                                                    <label for="resp_{{ $preg->FORM_NID }}">{{ $preg->FORM_CPREGUNTA }}</label>
                                                                                    @php  
                                                                                        $validacion = strpos(strtolower($preg->FORM_CPREGUNTA), 'interbancaria') !== false ? 'minlength=18 maxlength=18' : "";
                                                                                        $tipo       = $validacion ? "number" : "text"; 
                                                                                    @endphp 
                                                                                    @if ($preg->respuestas > 0)
                                                                                        @foreach ($preg->respuestas as $resp)
                                                                                            <input type="{{$tipo}}" class="form-control"
                                                                                                name="resp_{{ $preg->FORM_NID }}_0_{{ $resp->id }}"
                                                                                                id="resp_{{ $preg->FORM_NID }}_0"
                                                                                                placeholder="{{ $preg->FORM_CPREGUNTA }}"
                                                                                                value="{{ $resp->FORM_CVALOR_RESPUESTA }}"
                                                                                                {{-- {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }} --}}
                                                                                                required {{$validacion}}>
                                                                                        @endforeach
                                                                                    @endif
                                                                                    @if ($preg->estatus == 1)
                                                                                        <span class="text-danger">{{ $preg->observaciones }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @break
                                                                        @case('unica')
                                                                            <div class="col-md-4">
                                                                                <div class="form-group {{ $preg->estatus == 1 ? 'error-input' : '' }}">
                                                                                    <label for="resp_{{ $preg->FORM_NID }}">{{ $preg->FORM_CPREGUNTA }}</label>
                                                                                    @if ($preg->respuestas > 0)
                                                                                        @foreach ($preg->respuestas as $resp)
                                                                                            <div
                                                                                                class="custom-control custom-radio">
                                                                                                <input class="custom-control-input"
                                                                                                    type="radio"
                                                                                                    name="resp_{{ $preg->FORM_NID }}_0_{{ $resp->id }}"
                                                                                                    id="resp_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}"
                                                                                                    value="{{ $resp->FORM_NID }}"
                                                                                                    {{ $resp->FORM_CVALOR_RESPUESTA }}
                                                                                                    {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }}
                                                                                                    required>
                                                                                                    <br>
                                                                                                    <label class="custom-control-label"
                                                                                                        for="resp_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}">
                                                                                                        {{ $resp->FORM_CVALOR }}
                                                                                                    </label>

                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endif
                                                                                    @if ($preg->estatus == 1)
                                                                                        <span class="text-danger">{{ $preg->observaciones }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @break
                                                                        @case('multiple')
                                                                            <div class="col-md-4">
                                                                                <div class="form-group {{ $preg->estatus == 1 ? 'error-input' : '' }}">
                                                                                    <label for="resp_{{ $preg->FORM_NID }}">{{ $preg->FORM_CPREGUNTA }}</label>
                                                                                    @if ($preg->respuestas > 0)
                                                                                        <?php $cont_chk = 0; ?>
                                                                                        @foreach ($preg->respuestas as $resp)
                                                                                            <?php $required_chk =
                                                                                            $cont_chk == 0 ? 'required' : ''; ?>
                                                                                            <div class="custom-control custom-checkbox">
                                                                                                <input class="custom-control-input"
                                                                                                    type="checkbox"
                                                                                                    name="resp_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}_{{ $resp->id }}"
                                                                                                    id="resp_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}"
                                                                                                    value="{{ $resp->FORM_NID }}"
                                                                                                    {{ $resp->FORM_BBLOQUEAR == true ? 'disabled' : '' }}
                                                                                                    {{ $resp->FORM_CVALOR_RESPUESTA }}
                                                                                                    {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }}
                                                                                                    {{ $required_chk }}>
                                                                                                    <br>
                                                                                                    <label class="custom-control-label"
                                                                                                        for="resp_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}">
                                                                                                        {{ $resp->FORM_CVALOR }}
                                                                                                    </label>

                                                                                            </div>
                                                                                            <?php $cont_chk++; ?>
                                                                                        @endforeach
                                                                                    @endif
                                                                                    @if ($preg->estatus == 1)
                                                                                        <span class="text-danger">{{ $preg->observaciones }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @break
                                                                        @case('enriquecido')
                                                                            <div class="col-md-12">
                                                                                <div class="form-group {{ $preg->estatus == 1 ? 'error-input' : '' }}">
                                                                                    <label for="resp_{{ $preg->FORM_NID }}">{{ $preg->FORM_CPREGUNTA }}</label>
                                                                                    @if ($preg->respuestas > 0)
                                                                                        @foreach ($preg->respuestas as $resp)
                                                                                            <textarea class="txtEnriquecido"
                                                                                                name="resp_{{ $preg->FORM_NID }}_0_{{ $resp->id }}"
                                                                                                id="resp_{{ $preg->FORM_NID }}_0_{{ $resp->id }}"
                                                                                                rows="5"
                                                                                                style="display: block !important;"
                                                                                                required
                                                                                                {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }}
                                                                                                required>{{ $resp->FORM_CVALOR_RESPUESTA }}</textarea>
                                                                                            <label
                                                                                                id="error_resp_{{ $preg->FORM_NID }}_0_{{ $resp->id }}"></label>
                                                                                            <script>
                                                                                                CKEDITOR.replace(
                                                                                                    resp_{{ $preg->FORM_NID }}_0_{{ $resp->id }}
                                                                                                    );

                                                                                            </script>
                                                                                        @endforeach
                                                                                    @endif
                                                                                    @if ($preg->estatus == 1)
                                                                                        <span class="text-danger">{{ $preg->observaciones }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @break
                                                                        @case('especial')
                                                                            <div class="col-md-12">
                                                                                <div class="form-group {{ $preg->estatus == 1 ? 'error-input' : '' }}">
                                                                                    <label for="resp_{{ $preg->FORM_NID }}">{{ $preg->FORM_CPREGUNTA }}</label>
                                                                                    <table class="table table-striped table-bordered">
                                                                                        @if ($preg->respuestas > 0)
                                                                                            <tr>
                                                                                                @foreach ($preg->respuestas as $resp)
                                                                                                    <th>
                                                                                                        {{ $resp->FORM_CVALOR }}
                                                                                                    </th>
                                                                                                @endforeach
                                                                                            </tr>
                                                                                            <tr>
                                                                                                @foreach ($preg->respuestas as $resp)
                                                                                                    <td>
                                                                                                        @switch($resp->FORM_CTIPORESPUESTAESPECIAL)
                                                                                                            @case('simple')
                                                                                                                <div class="form-group">
                                                                                                                    @if ($resp->respuestas_especial > 0)
                                                                                                                        @foreach ($resp->respuestas_especial as $resp_esp)
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                class="form-control"
                                                                                                                                name="especial_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}_{{ $resp_esp->id }}"
                                                                                                                                id="especial_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}"
                                                                                                                                placeholder="{{ $resp->FORM_CVALOR }}"
                                                                                                                                value="{{ $resp_esp->FORM_CVALOR_RESPUESTA }}"
                                                                                                                                {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }}
                                                                                                                                required>
                                                                                                                        @endforeach
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            @break
                                                                                                            @case('numerico')
                                                                                                                <div class="form-group">
                                                                                                                    @if ($resp->respuestas_especial > 0)
                                                                                                                        @foreach ($resp->respuestas_especial as $resp_esp)
                                                                                                                            <input
                                                                                                                                type="number"
                                                                                                                                class="form-control"
                                                                                                                                name="especial_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}_{{ $resp_esp->id }}"
                                                                                                                                id="especial_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}"
                                                                                                                                placeholder="{{ $resp->FORM_CVALOR }}"
                                                                                                                                value="{{ $resp_esp->FORM_CVALOR_RESPUESTA }}"
                                                                                                                                {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }}
                                                                                                                                required>
                                                                                                                        @endforeach
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            @break
                                                                                                            @case('opciones')
                                                                                                                <div class="form-group">
                                                                                                                    @if ($resp->respuestas_especial > 0)

                                                                                                                        <select
                                                                                                                            class="form-control"
                                                                                                                            name="especial_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}_{{ $resp->respuestas_especial[0]->id }}"
                                                                                                                            id="especial_{{ $preg->FORM_NID }}_{{ $resp->FORM_NID }}"
                                                                                                                            {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }}
                                                                                                                            required>
                                                                                                                            @foreach ($resp->respuestas_especial as $resp_esp)
                                                                                                                                <option
                                                                                                                                    value="{{ $resp_esp->FORM_NID }}"
                                                                                                                                    {{ $resp_esp->FORM_CVALOR_RESPUESTA }}>
                                                                                                                                    {{ $resp_esp->FORM_CVALOR }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            @break
                                                                                                        @endswitch
                                                                                                    </td>
                                                                                                @endforeach
                                                                                            <tr>
                                                                                        @endif
                                                                                    </table>
                                                                                    @if ($preg->estatus == 1)
                                                                                        <span class="text-danger">{{ $preg->observaciones }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @break
                                                                        @case('catalogo')
                                                                            <div class="col-md-4">
                                                                                <div class="form-group {{ $preg->estatus == 1 ? 'error-input' : '' }}">
                                                                                    <label for="resp_{{$preg->FORM_NID}}">{{$preg->FORM_CPREGUNTA}}</label>
                                                                                    <?php
                                                                                        foreach($preg->respuestas as $resp){
                                                                                            $name       = $preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros' ? '' : 'name=resp_'.$preg->FORM_NID.'_0_'.$resp->id;
                                                                                        }

                                                                                        $multiple   = $preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros' ? 'multiple' : '';
                                                                                        $class      = $preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros' ? 'selectCatalogos' : '';
                                                                                    ?>

                                                                                    @foreach ($preg->respuestas as $resp)
                                                                                        @if ($preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros')
                                                                                            <input type="hidden" name="resp_{{$preg->FORM_NID}}_0_{{ $resp->id }}" id="resp_{{$preg->FORM_NID}}_0_input" value="{{$resp->respString}}">
                                                                                        @endif
                                                                                    @endforeach

                                                                                    <select {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }} id="resp_{{$preg->FORM_NID}}_0" class="selectpicker form-control {{$class}}" data-live-search="true" {{$multiple}} {{ $name }}  required>
                                                                                        @foreach ($preg->respuestas as $resp)
                                                                                            @foreach ($resp->catalogos as $cat)
                                                                                                <?php
                                                                                                    $antSel     = array();
                                                                                                    $selected   = "";
                                                                                                    if($resp->FORM_CVALOR == 'tram_cat_giros'){
                                                                                                        foreach($resp->respArray  as $respArray){
                                                                                                            array_push($antSel, $respArray->id);
                                                                                                            if($respArray->id == $cat->id){
                                                                                                                $selected = "selected";
                                                                                                                break;
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                    else{
                                                                                                        if($resp->respString == $cat->id){
                                                                                                            $selected = "selected";
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                                <option {{$selected}} value="{{$cat->id}}">{{$cat->clave}} - {{$cat->nombre}}</option>;
                                                                                            @endforeach
                                                                                        @endforeach
                                                                                    </select>

                                                                                    @if ($preg->estatus == 1)
                                                                                        <span class="text-danger">{{ $preg->observaciones }}</span>
                                                                                    @endif
                                                                                </div>

                                                                                <div {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }} id="inputGiro_resp_{{$preg->FORM_NID}}_0">
                                                                                    {{-- Se crean los input de tipo fecha para cada giro --}}
                                                                                    @foreach($resp->respArray  as $respArray)
                                                                                        <div id="inputGiro_">
                                                                                            <br />
                                                                                            <label id='label_{{$respArray->id}}'> {{$respArray->clave}}</label>
                                                                                            <input  {{ $preg->estatus == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }} type="date" id="fechaGiro_{{$respArray->id}}" name="fechaGiro_{{$respArray->id}}" class="form-control txt_abierta" placeholder="Fecha" value="{{$respArray->fecha}}" required/>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        @break
                                                                    @endswitch
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                            <div class="row form p-4" id="form_0" style="display: none;">
                                                <div class="table-responsive">
                                                    <table class="table table-sm" id="documentosP4">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Seleccionar</th>
                                                                <th scope="col"></th>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Tamaño</th>
                                                                <th scope="col" class="text-center">Estatus</th>
                                                                <th scope="col"></th>
                                                                <th scope="col">Observaciones</th>
                                                                <th scope="col"></th>
                                                                <th scope="col"></th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($tramite['configuracion']['documentos']) > 0)
                                                                @foreach ($tramite['configuracion']['documentos'] as $doc)
                                                                    <tr>
                                                                        <td>
                                                                            @switch($doc->TRAD_NESTATUS)
                                                                                @case(2)
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" disabled checked>
                                                                                    </div>
                                                                                @break
                                                                                @default
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" disabled>
                                                                                    </div>
                                                                                @break
                                                                            @endswitch
                                                                        
                                                                            <div class="md-6 ml-2" id="btnVer" style="margin-left:40% !important;">
                                                                                @if (!is_null($doc->id))
                                                                                    <a title="Ver archivo" class="btn btn-primary p-0 m-0"  style="width: 22px; height: 22px; " href="{{ asset('') }}{{$doc->TRAD_CRUTADOC}}" target="_blank">
                                                                                        <i class="fa fa-eye p-0 m-0" ></i>
                                                                                    </a>
                                                                                @endif
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div id="icon_file_{{ $doc->TRAD_NIDTRAMITEDOCUMENTO }}">
                                                                                @switch($doc->TRAD_CEXTENSION)
                                                                                    @case('jpg')
                                                                                        <img src="{{ asset('assets/template/img/jpg.png') }}"
                                                                                            width="25" height="25">
                                                                                    @break
                                                                                    @case('png')
                                                                                        <img src="{{ asset('assets/template/img/png.png') }}"
                                                                                            width="25" height="25">
                                                                                    @break
                                                                                    @case('pdf')
                                                                                        <img src="{{ asset('assets/template/img/pdf.png') }}"
                                                                                            width="25" height="25">
                                                                                    @break
                                                                                    @default
                                                                                        <img src="{{ asset('assets/template/img/doc.png') }}"
                                                                                            width="25" height="25">
                                                                                    @break
                                                                                @endswitch
                                                                            
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            {{ $doc->TRAD_CNOMBRE }}

                                                                            @if ($doc->TRAD_NOBLIGATORIO == 1)
                                                                                <span class="text-danger">*</span>
                                                                            @endif

                                                                        </td>
                                                                        <td>
                                                                            @if (!is_null($doc->id))
                                                                                <div id="size_file_{{ $doc->TRAD_NIDTRAMITEDOCUMENTO }}"> </div>
                                                                            @endif
                                                                        </td>
                                                                        
                                                                        <td class="text-center">
                                                                            @switch($doc->TRAD_NESTATUS)
                                                                                @case(0)  Pendiente revisión @break
                                                                                @case(1)  Con observaciones  @break
                                                                                @case(2)  Aceptado @break
                                                                                @default  @break
                                                                            @endswitch
                                                                        </td>
                                                                        <td class="text-center">
                                                                            @switch($doc->TRAD_NESTATUS)
                                                                                @case(0)
                                                                                    <img src="{{ asset('assets/template/img/pendiente.png') }}" width="20"
                                                                                        height="20">
                                                                                @break
                                                                                @case(1)
                                                                                    <img src="{{ asset('assets/template/img/warning.png') }}" width="20"
                                                                                        height="20">
                                                                                @break
                                                                                @case(2)
                                                                                    <img src="{{ asset('assets/template/img/check.png') }}" width="20"
                                                                                        height="20">
                                                                                @break
                                                                            @endswitch
                                                                        </td>
                                                                        <td>
                                                                            @if ($doc->TRAD_NESTATUS == 1)
                                                                                <span class="text-danger" style="font-size:10px;width:500px;">{{ $doc->TRAD_COBSERVACION }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td style="width: 100px;">
                                                                            <?php $disbledInputFile = $tramite['disabled'] == 'disabled' ?
                                                                            'btn-file-disabled btn-file-disabled-action' : ''; ?>
                                                                            <div id="documentos-add"></div>
                                                                            <input type="hidden"
                                                                                name="docs_file_{{ $doc->TRAD_NIDTRAMITEDOCUMENTO }}_{{ $doc->id }}"
                                                                                id="docs_file_{{ $doc->TRAD_NIDTRAMITEDOCUMENTO }}"
                                                                                value="{{ $doc->TRAD_CRUTADOC }}_{{ $doc->TRAD_CEXTENSION }}_{{ $doc->TRAD_NPESO }}_{{ $doc->TRAD_CNOMBRE }}">
                                                                            <?php $_required_file = $doc->TRAD_CRUTADOC == '' ? 'required' :
                                                                            ''; ?>
                                                                            <input
                                                                                class="file-select documentos {{ $doc->TRAD_NESTATUS == 1 && $tramite['atencion_formulario'] == 1 ? '' : $disbledInputFile }}"
                                                                                name="file_{{ $doc->TRAD_NIDTRAMITEDOCUMENTO }}"
                                                                                id="file_{{ $doc->TRAD_NIDTRAMITEDOCUMENTO }}"
                                                                                data-docname="{{ $doc->TRAD_CNOMBRE }}" type="file" accept="application/pdf"
                                                                                {{ $doc->TRAD_NESTATUS == 1 && $tramite['atencion_formulario'] == 1 ? '' : $tramite['disabled'] }}
                                                                                {{ $_required_file }}>
                                                                        </td>
                                                                        <td>
                                                                            @if ($doc->TRAD_NMULTIPLE == 1)
                                                                                <h5 class="font-weight-bold"><span
                                                                                        class="circle-multi {{ $doc->TRAD_NESTATUS == 1 && $tramite['atencion_formulario'] == 1 ? '' : $disbledInputFile }}"
                                                                                        onclick="TRAM_FN_AGREGAR_ROW('{{ $doc->TRAD_CNOMBRE }}')">+</span>
                                                                                </h5>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <h5 class="font-weight-bold"><span
                                                                                    class="circle-error-multi {{ $doc->TRAD_NESTATUS == 1 && $tramite['atencion_formulario'] == 1 ? '' : $disbledInputFile }}"
                                                                                    onclick="TRAM_FN_LIMPIARROW_DOCUMENTO('{{ $doc->TRAD_NIDTRAMITEDOCUMENTO }}','{{ $doc->TRAD_CNOMBRE }}')">x</span>
                                                                            </h5>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                        <div>
                                            @if ($tramite['estatus'] == 1)
                                                <!--Captura inicial-->
                                                <button type="submit" class="btn btn-warning float-right" onclick="TRAM_FN_VALIDAR()"
                                                    style="margin-right:10px;">Validar</button>
                                                <button type="submit" class="btn btn-primary float-right" style="margin-right:10px;"
                                                    onclick="TRAM_AJX_GUARDAR()">Guardar información</button>
                                                <button type="submit" class="btn btn-success float-right btnEnviar" style="margin-right:10px;"
                                                    onclick="TRAM_AJX_ENVIAR()">Enviar</button>
                                            @endif
                                            @if ($tramite['estatus'] == 4 && $tramite['atencion_formulario'] == 1)
                                                <!--se reenvia cuando la seccion de formulario se haya marcado como incompleto y se le haya dado seguimiento desde el detalle de la notificacion-->
                                                <button type="submit" class="btn btn-success float-right btnEnviar"
                                                    onclick="TRAM_AJX_ENVIAR_SEGUIMIENTO()">Enviar</button>
                                                <button type="submit" class="btn btn-warning float-right" onclick="TRAM_FN_VALIDAR()"
                                                    style="margin-right:10px;">Validar</button>
                                            @endif
                                        </div>
                                    @break
                                    @case('Revisión de documentación')
                                    @break
                                    @case('Citas en línea')
                                        <div class="col-md-12 sinCitaHide">
                                            <h3>Se requiere programar cita</h3>
                                        </div>
                                        <div class="col-md-12 sinCitaHide" style="border-bottom:1px solid rgb(173, 171, 171); margin-bottom:20px">
                                            @if (count($confsec->cita) > 0)
                                                <div style="">{!! $confsec->cita[0]->CONF_CDESCRIPCIONCITA !!}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-12 sinCitaHide">
                                            <div>
                                                <div class="row" id="concitareservada">
                                                    <div class="col-md-6">
                                                        <h6 style="font-size: 1rem; font-weight:bold;">Estatus de la Cita</h6>
                                                        <div style="border: 1px dashed black; padding:15px; width:100%">
                                                            <p style="color: #000;"><b style="font-weight: 600;">ESTATUS:</b> <span id="citaConfirmado">Agendado</span><label
                                                                    id="cita_status"></label></p>
                                                            <p style="color: #000;"><b style="font-weight: 600;">FOLIO:</b> <span id="citaFolio"></span><label
                                                                    id="cita_folio_cita"></label></p>
                                                            <p style="color: #000;"><b style="font-weight: 600;">FECHA:</b> <span id="citaFecha"></span><label
                                                                    id="cita_fecha"></label></p>
                                                            <p style="color: #000;"><b style="font-weight: 600;">HORA:</b> <span id="citaHora"></span><label
                                                                    id="cita_hora"></label></p>
                                                            <p style="color: #000;"><b style="font-weight: 600;">EDIFICIO:</b> <span id="citaEdificio"></span><label
                                                                    id="cita_edificio"></label></p>
                                                            <p style="color: #000;"><b style="font-weight: 600;">DIRECCIÓN:</b> <span id="citaDireccion"></span><label
                                                                    id="cita_edificio_direccion"></label></p>
                                                            <p style="color: #000;"><b style="font-weight: 600;">TRÁMITE:</b> <span id="citaTramite"></span><label
                                                                    id="cita_tramite"></label></p>
                                                        </div>
                                                        <button id="cancelarCita" class="btn btn-info btn-lg" style="margin-top: 10px;"><strong>Cancelar cita</strong></button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="cita_mapa" style="width: 100%; height:25rem;">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="sincitareservada">
                                                    <p>
                                                    <h6 style="font-size: 1rem; font-weight:bold;">Citas Disponibles</h6>
                                                    </p>
                                                    <br /><br />
                                                    <div class="col-md-12" style="margin-top: 15px">
                                                        <!-- CALENDARIO -->
                                                        <div class="col-lg-12">
                                                            <div class="card col-lg-12">
                                                                <div class="card-body col-lg-12 row">
                                                                    <div class="col-lg-9">
                                                                        <div id="calendario"></div>
                                                                    </div>
                                                                    <div id="rightContainer" class="col-lg-3" style="background-color: #f0f0f0; padding-top: 20px;">
                                                                        <h5 class="text-primary text-center"><i class="fas fa-clock text-info"></i>&nbspHorarios disponibles</h5>
                                                                        <hr class="text-primary">
                                                                        <div class="col-lg-12 text-center" style=" width: 100%">
                                                                            <p id="formRFecha">Fecha: </p>
                                                                            <div id="horariosContainer" class="col-lg-12 text-center" style="height: 400px; overflow-y: scroll;"></div>
                                                                            <button id="btnAgendarCita" disabled class="btn btn-primary" style="margin: 15px;">Agendar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- TOAST -->
                                                        <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
                                                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                                                <div class="toast-header">
                                                                    <i id="toastIcon" class="fas fa-search"></i>
                                                                    <strong class="mr-auto">&nbsp Notificación</strong>
                                                                    <small>Ahora</small>
                                                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="toast-body" id="toastMsj">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal de carga -->
                                                        <div class="modal fade bd-example-modal-lg" id="modalLoad" data-backdrop="static" data-keyboard="false" tabindex="-1">
                                                            <div class="modal-dialog modal-sm" style="display: table; position: relative; margin: 0 auto; top: calc(50% - 24px);">
                                                                <div class="modal-content" style="width: 48px; background-color: transparent; border: none;">
                                                                    <div class="spinner-border text-primary" style="width: 10rem; height: 10rem;" role="status">
                                                                        <span class="sr-only">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="citaInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">¡Tu cita ha sido agendada!</h5>
                                                                    <button id="finish" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-center center">
                                                                    <p id="citaFolio"></p>
                                                                    <p id="citaFecha"></p>
                                                                    <p id="citaHora"></p>
                                                                    <p id="citaMunicipio"></p>
                                                                    <p id="citaModulo"></p>

                                                                    <button id="btnPDF" class="btn btn-primary" style="margin: 15px;">Descargar PDF</button>

                                                                </div>
                                                                <div class="modal-footer">
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- FIN CALENDARIO -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @break
                                    @case('Ventanilla sin cita')
                                        <div class="col-md-12">
                                            <h3>Se requiere acudir a ventanilla</h3>
                                        </div>
                                        <div class="col-md-12" style="border-bottom:1px solid rgb(173, 171, 171); margin-bottom:20px">
                                            @if (count($confsec->sincita) > 0)
                                                <div style="">{!! $confsec->sincita[0]->CONF_CDESCRIPCIONVENTANILLA !!}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 style="font-size: 1rem; font-weight:bold;">Ubicaciones</h6>
                                                    @if (isset($tramite['ubicacion_ventanilla_sin_cita']))
                                                        <div class=" col-md-12">
                                                            <div class="alert alert-success" role="alert">
                                                                Se ha reservado tu visita en el módulo:
                                                                <br><b>{{ $tramite['ubicacion_ventanilla_sin_cita'] }}<b>.
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class=" col-md-12">
                                                            <div class="alert alert-warning" role="alert">
                                                                No ha seleccionado ninguna ubicación.
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-12" style="margin-top: 35px">
                                                        <select class="form-control" id="sincita_edificios" onchange="cargaEdificiosSinCita()">
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12" style="margin-top: 35px" id="infoSelectedEdificio">
                                                        <div class="row columna">
                                                            <div class="col-md-12">
                                                                <label class="font-weight-bolder text-dark"
                                                                    style="font-size: 0.9rem;">Nombre</label> <br>
                                                                <label class="text-dark" id="infoEdificioNombre">-----</label>
                                                            </div>
                                                        </div>
                                                        <div class="row columna">
                                                            <div class="col-md-12">
                                                                <label class="font-weight-bolder text-dark"
                                                                    style="font-size: 0.9rem;">Dirección</label> <br>
                                                                <label class="text-dark" id="infoEdificioDireccion">-----</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($tramite['ventanillaSinCitaFinalizado'] == 1)
                                                        <div class="col-md-12" style="margin-top: 35px">
                                                            <button type="submit" id="btnSaveUbication" class="btn btn-success float-right"
                                                                style="margin-top:10px;"
                                                                onclick="TRAM_AJX_ENVIAR_UBICACION_VENTANILLA_SIN_CITA()">Guardar</button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Mapa</label>
                                                    <div id="mapaEdificios" style="width:450px; height:25rem;">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @break
                                    @case('Resolutivo electrónico')

                                        <div class="col-md-12" style="color: black; font-weight:bold">
                                            <h3>Entrega de resolutivo</h3>
                                        </div>
                                        @foreach ($tramite['resolutivosConfig'] as $reso)
                                            <div class="row col-md-12" style="color: black;">
                                                <div class="col-md-2">
                                                    <h6 style="font-weight:bold;">Nombre: </h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>{{ $reso->RESO_CNOMBRE }}</h6>
                                                </div>

                                            </div>
                                            @if (count($confsec->resolutivos) == 0)
                                                <div class="row col-md-12" style="color: black;">
                                                    <div class="col-md-2">
                                                        <h6 style="font-weight:bold;">Estatus: </h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Pendiente</h6>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if (count($confsec->resolutivos) > 0)
                                                <div class="row col-md-12" style="color: black;">
                                                    <div class="col-md-2">
                                                        <h6 style="font-weight:bold;">Estatus: </h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Atendido</h6>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (count($confsec->resolutivos) > 0)
                                                @if(Auth::user()->TRAM_CAT_ROL->ROL_NIDROL != 2)
                                                    <div class="row col-md-12" style="color: black;">
                                                        <div class="col-md-2">
                                                            <h6 style="font-weight:bold;">Resolutivo Digital: </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a class="btn btn-success" target="_blank" href="{{route('generate_previo_resolutivo', ['resolutivoId' => $reso->RESO_NID, 'tramiteId' => $tramite['idusuariotramite'], 'tipo' => 1])}}">Generar</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            <hr />
                                        @endforeach
                                        @if (count($confsec->resolutivos) > 0)
                                            <div class="row col-md-12" style="color: black;">
                                                <div class="col-md-12">
                                                    <p>
                                                        La constancia ha sido acreditada y se podrá descargar en el botón que aparece a continuación; sin embargo, en caso de requerir  la constancia en físico, esta se podrá recoger e las oficinas de la Dirección de Adquisiciones.
                                                    </p>
                                                </div>
                                            </div>
                                            @foreach ($confsec->resolutivos as $index => $resu)
                                                <a style="display: none;" id="archivoReso" href="{{ asset($resu->USRE_CRUTADOC) }}" style="color:#fff !important;" download="RESOLUTIVO"></a>
                                                <input type="hidden" id="inputFormat" value="{{ asset('|dos') }}"> 
                                                <button  onclick="descargarResolutivo({{$index}})" class="btn btn-primary" style="margin-right:10px;">Descargar</button>
                                            @endforeach
                                        @endif
                                    @break
                                    @case('Pago en línea')
                                        <div class="col-md-12">
                                            <h3>Se requiere realizar pago</h3>
                                        </div>

                                        <div class="col-md-12" id="info_pago_{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}">
                                            <h6 style="font-size: 1rem; font-weight:bold;">Estatus de pago</h6>
                                            @if($confsec->SSEGTRA_PAGADO == 0)
                                                <div style="border: 1px dashed black; padding:15px; width:100%">
                                                    <p style="color: #000;"><b style="font-weight: 600;">ESTATUS: No Pagado</b> <label
                                                            id="txtEstatus_{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}"></label></p>
                                                <!--  <p style="color: #000;"><b style="font-weight: 600;">REFERENCIA PAGO:</b> <label
                                                            id="txtReferencia_{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}"></label></p> -->
                                                <!-- <p style="color: #000;"><b style="font-weight: 600;">REFERENCIA ACCEDE:</b> <label
                                                            id="txtIdReferencia_{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}"></label></p>
                                                        <p style="color: #000;"><b style="font-weight: 600;">MENSAJE:</b> <label
                                                            id="txtMensaje_{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}"></label></p> -->
                                                </div>
                                            @endif
                                            @if($confsec->SSEGTRA_PAGADO == 1)
                                                <div class="alert alert-success" role="alert" style="font-size: 16px;">
                                                    ¡Pago realizado!
                                                </div>
                                            @endif
                                        </div>
                                        <br />
                                        @if (count($confsec->conceptos) > 0)
                                            <table class="table secconceptos"
                                                id="secconceptos_{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Referencia</th>
                                                        <th scope="col">Concepto</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($confsec->conceptos as $con)
                                                        <tr>
                                                            <td>
                                                                <input type="hidden"
                                                                    name="iputconcepto_{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}[]"
                                                                    value="{{ $con->USCON_NREFERENCIA }}_{{ $con->USCON_NCANTIDAD }}">
                                                                {{ $con->USCON_NREFERENCIA }}
                                                            </td>
                                                            <td>{{ $con->USCON_CONCEPTO }}</td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- <a target="_blank" rel="noopener noreferrer"
                                                id="linkPago_{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}"
                                                class="btn btn-success float-right">Pagar</a> -->
                                            @if($confsec->SSEGTRA_PAGADO == 0)
                                                                                                    
                                                <div class="row" id="seccionOrdenPago">

                                                @if($tramite['tienePago'] == 0)

                                                    <button onClick="generar_orden_pago({{ $tramite['idusuariotramite'] }},{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }});" class="btn btn-primary">Generar Orden de Pago</button>
                                                @else
                                                <div class="col-12"> 
                                                <p style="color: #000;">
                                                <b style="font-weight: 600;">Folio Control Estado: </b>{{$tramite["datosPago"]["FolioControlEstado"]}} </br>
                                                <b style="font-weight: 600;">Linea de Captura: </b>{{$tramite["datosPago"]["LineaCaptura"]}} </br>
                                                <b style="font-weight: 600;">Fecha de Vencimiento: </b>{{$tramite["datosPago"]["FechaVencimiento"]}} </br> 
                                                </p>
                                                </div>
                                                <div class="col-12"> 
                                                <a href="{{$tramite["datosPago"]["UrlFormatoPago"]}}" target="_blank"  class="btn btn-primary">Ver Formato de Pago</a>
                                                <a href="http://serviciosweb.queretaro.gob.mx:8080/recaudanet/enviaBancos_1.jsp?tran={{$tramite['datosPago']['Folio']}}&periodo={{$tramite['datosPago']['Periodo']}}" target="_blank"  class="btn btn-primary">Pago Online</a>
                                                <button onClick="generar_orden_pago({{ $tramite['idusuariotramite'] }},{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }});" class="btn btn-primary">Generar Nueva Orden de Pago</button>
                                                <input type="hidden" id="idSeccionSeguimientoPago" value="{{ $confsec->SSEGTRA_NIDSECCION_SEGUIMIENTO }}"/>
                                                </div>
                                                   
                                                @endif
                                                </div>
                                                
                                                <br/>
                                                <br/>
                                              

                                                <div class="row" id="alertValidatePago"> </div>
                                            <!--  <iframe id="PagosIframe" name="PagosIframe" src="" width="100%" height="800"></iframe> -->
                                            @endif
                                            <br>
                                        @endif
                                        <!-- <iframe id="PagosIframe" src="" width="100%" height="300"></iframe> -->
                                    @break
                                @endswitch
                            </div>
                        @endforeach
                    @endif
                </div>
                <!-- /.card-body -->
                {{-- <div class="card-footer" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <button type="submit" class="btn btn-primary float-right">Guardar información</button>
                <button type="submit" class="btn btn-success float-right" style="margin-right:10px;">Siguiente</button>
            </div> --}}
            </div>
        </div>
        <br>

        <div class="row">
            <div class="card" style="width: 100%; border-radius:20px;">
                <div class="card-header"
                    style="background-color: #23468c; color: #ffffff; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h6 class="card-title">Notificaciones</h6>
                </div>
                <div class="card-body" style="color: #23468c;">
                    @if (count($tramite['configuracion']['notificaciones']) > 0)
                        @foreach ($tramite['configuracion']['notificaciones'] as $noti)
                            <div class="card text-left cardNotification">
                                <div class="card-header titleCard">
                                    {{ $noti->HNOTI_CEMISOR }} | {{ $noti->HNOTI_ROLEMISOR }} | Creado:
                                    {{ $noti->HNOTI_DFECHACREACION }} | Leído:
                                    {{ $noti->HNOTI_NLEIDO == 0 ? 'Pendiente' : $noti->HNOTI_DFECHALEIDO }}
                                    @if ($noti->HNOTI_NLEIDO == 0)
                                        <img src="{{ asset('assets/template/img/pendiente.png') }}" width="20" height="20">
                                    @else
                                        <img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20">
                                    @endif
                                </div>
                                <div class="card-body cardItemNotification">
                                    <div class="row" style="padding: 5px; background-color: #D3EDF9;">
                                        <div class="col-10">
                                            <strong style="font-size: 1rem;">{{ $noti->HNOTI_CITUTLO }}</strong>
                                            <p style="color:#212529">{{ $noti->HNOTI_CMENSAJECORTO }}</p>
                                        </div>
                                        <div class="col-2 btnCard">
                                            <a class="btn {{ $noti->HNOTI_NLEIDO == 1 ? 'btn-disabled' : '' }}"
                                                style="background-color: #E91E63; color:#ffffff; cursor: pointer;"
                                                onclick="TRAM_FN_DETALLE_NOTIFICACION({{ $noti->HNOTI_NIDNOTIFICACION }});">{{ $noti->HNOTI_NLEIDO == 1 ? 'Atendido' : 'Consultar' }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                        @endforeach
                    @else
                        <div class="row">
                            <label style="padding-left: 20px;">Por el momento, no existen observaciones.</label>
                        </div>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalEncuesta" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="ModalEncuesta" aria-hidden="true">
        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-radius-6">
                <div class="modal-header">
                    <h5 class="modal-title">Encuesta de satisfacción</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="listError"></div>
                            <form id="frmFormEncuesta" name="frmFormEncuesta">
                                <input type="hidden" name="txtIdUsuarioTramite"
                                    value="{{ $tramite['idusuariotramite'] }}">
                                <div class="form-group">
                                    <label for="dteFechaInicio">¿Cómo fue el servicio que recibió por parte de la persona
                                        que le atendió?</label>
                                    <input type="text" placeholder="" class="form-control" name="txtPregunta1"
                                        id="txtPregunta1"
                                        title="¿Cómo fue el servicio que recibió por parte de la persona que le atendió?"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="dteFechaInicio">De acuerdo a su visita, ¿se enfrentó con obstáculos,
                                        barreras o algún tipo de inconveniente?</label>
                                    <input type="text" placeholder="" class="form-control" name="txtPregunta2"
                                        id="txtPregunta2"
                                        title="De acuerdo a su visita, ¿se enfrentó con obstáculos, barreras o algún tipo de inconveniente?"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="dteFechaInicio">¿Qué tan satisfecho se encuentra con el tiempo de atención
                                        del trámite o servicio?</label>
                                    <input type="text" placeholder="" class="form-control" name="txtPregunta3"
                                        id="txtPregunta3"
                                        title="¿Qué tan satisfecho se encuentra con el tiempo de atención del trámite o servicio?"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="dteFechaInicio">¿Desea agregar algún comentario adicional?</label>
                                    <input type="text" placeholder="" class="form-control" name="txtPregunta4" id="txtPregunta4" title="¿Desea agregar algún comentario adicional?" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row justify-content-between">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary btn-md btnSubmit" id="btnSubmit" onclick="TRAM_AJX_ENVIAR_ENCUESTA_SATISFACCION();">Enviar</button>
                            <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="loading_save" class="loadingFrame" class="text-center" style="display: none !important;">
        <div class="inner">
            <div class="spinner-grow text-secondary" role="status"> </div>
            <p style="color: #393939 !important;"><span id="loading-text"></span></p>
        </div>
    </div>
    <br />

    <style>
        .error-input {
            border: 1px solid red;
            padding: 4px;
            border-radius: 4px;
        }

        .btn-file-disabled-action {
            background: #cacaca;
            pointer-events: none;
        }

        .btn-file-disabled::before {
            background: #cacaca !important;
        }

        .btn-disabled {
            background: #cacaca !important;
            pointer-events: none;
        }

        .seccion-disabled {
            pointer-events: none;
            color: #999999 !important;
        }

        .titleCard {
            text-align: left;
            background-color: transparent;
            border-bottom: none;
            font-weight: bold;
            color: #000 !important;
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

        .file-select {
            position: relative;
            display: inline-block;
        }

        .file-select::before {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 3px;
            content: 'Seleccionar';
            /* testo por defecto */
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        .file-select input[type="file"] {
            opacity: 0;
            width: 100%;
            height: 32px;
            display: inline-block;
        }

        .file-select::before {
            content: 'Subir documento';
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
            cursor: pointer !important;
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
        .selectCatalogos, .dropdown-item{
            white-space: break-spaces;
        }
    </style>
@endsection


@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/citas.js') }}"></script>
    <script>
        var catalogos   = <?php echo json_encode($tramite['giros']); ?>;
        var antSel      = <?php echo json_encode($antSel); ?>; 
        var catGiros    = [];
        var anios       = [];

        var id = "{{ $tramite['idusuariotramite'] }}";
        var encuesta_contestada = "{{ $tramite['encuesta_contestada'] }}";
        var estatus_tram = "{{ $tramite['estatus'] }}";
        var conceptos_pagos =  <?php echo json_encode($tramite['configuracion']['conceptos']); ?>;
        var ubicacion_ventanilla_sin_cita = {};

        //variables para validacion de pago 
        var tienePago = <?= $tramite['tienePago'] ?>;
        @if($tramite['tienePago'] == 1)
        var periodoPago = <?= $tramite['datosPago']['Periodo'] ?>;
        var noTransaccionPago = <?= $tramite['datosPago']['Folio'] ?>;
        @endif


        //Unicamente se muestra el modal cuando el tramite esta finalizado y cuando el usuario no haya respondido la encuesta de satisfaccion
        // if (estatus_tram == 8) {
        //     if (encuesta_contestada == null || encuesta_contestada == 0) {
        //         $("#ModalEncuesta").modal("show");
        //     }
        // }
        var idtramiteAccede = "{{ $tramite['idtramiteaccede'] }}";
        var selectedVentanilla = "{{ $tramite['ubicacion_ventanilla_sin_cita'] }}";

        if(selectedVentanilla != 0){
            //loadSelectedEdificio(idtramiteAccede, selectedVentanilla);
            loadModulos(idtramiteAccede, selectedVentanilla);
            cargaMapaEdificios(idtramiteAccede, selectedVentanilla, 'mapaEdificios');
        }
        function cargaEdificiosSinCita() {
            //idtramiteAccede = "{{ $tramite['idtramiteaccede'] }}";
            var selectedValue = $("#sincita_edificios").children("option:selected").val();

            //if (selectedValue != 0) {
                //loadSelectedEdificio(idtramiteAccede, selectedValue);
                loadModulos(idtramiteAccede, selectedVentanilla);
                cargarMapaModulos(idtramiteAccede, selectedValue, 'mapaEdificios');
            //}
        }

        //actualizar pago
        function generar_orden_pago(idUsuarioTramite,idSeccionPago){
            

            var jsonobject = {
                    USUARIO_TRAMITE_ID: idUsuarioTramite,
                    SECCION_PAGO_ID: idSeccionPago
            };

            $.ajax({
                    data: JSON.stringify(jsonobject),
                    url: "/generar_orden_pago",
                    type: "POST",
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(data) {
                        if(data.estatusPago == 1){
                            $("#alertValidatePago").html('<div class="alert alert-success" role="alert" style="font-size: 16px;">'+data.mensajePago+'</div>');
                            //location.reload(); 

                            $("#seccionOrdenPago").html(`
                            <div class="col-12"> 
                            <p style="color: #000;">
                            <b style="font-weight: 600;">Folio Control Estado: </b>`+data.folioControlEstado+` </br>
                            <b style="font-weight: 600;">Linea de Captura: </b>`+data.lineaCaptura+` </br>
                            <b style="font-weight: 600;">Fecha de Vencimiento: </b>`+data.fechaVencimiento+` </br> 
                            </p>
                            </div>
                            <div class="col-12"> 
                            <a href="`+data.urlFormatoPago+`" target="_blank"  class="btn btn-primary">Ver Formato de Pago</a>
                            <a href="http://serviciosweb.queretaro.gob.mx:8080/recaudanet/enviaBancos_1.jsp?tran=`+data.folio+`&periodo=`+data.periodo+`" target="_blank"  class="btn btn-primary">Pago Online</a>
                            </div>
                            `);
                            

                        }else{
                            $("#alertValidatePago").html('<div class="alert alert-warning" role="alert" style="font-size: 16px;">'+data.mensajePago+'</div>');
                            return;

                        }


                    },
                        error: function(data) {}

                });
        }

        //actualizar pago
        function actualizar_pago(){

            //console.log("actualizando pago");

            $("#alertValidatePago").html('<div class="alert alert-warning" role="alert" style="font-size: 16px;">Validando pago, no recargue la pagina</div>');

            var idSeccionSeguimientoPago = $('#idSeccionSeguimientoPago').val();
            
            var jsonobject = {
                    PERIODO: periodoPago,
                    NUMERO_TRANSACCION:noTransaccionPago,
                    TRAMITE_ID: idSeccionSeguimientoPago
            };

            $.ajax({
                    data: JSON.stringify(jsonobject),
                    url: "/validar_pago_queretaro",
                    type: "POST",
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(data) {
                        if(data.estatusPago == 1){
                            $("#alertValidatePago").html('<div class="alert alert-success" role="alert" style="font-size: 16px;">'+data.mensajePago+'</div>');
                            location.reload();

                        }else{
                            $("#alertValidatePago").html('<div class="alert alert-warning" role="alert" style="font-size: 16px;">'+data.mensajePago+'</div>');
                            return;

                        }


                    },
                        error: function(data) {

                            $("#alertValidatePago").html('<div class="alert alert-warning" role="alert" style="font-size: 16px;">Servicio de validacion no disponible, intente mas tarde</div>');
                            return;

                        }

                });
        }

        $(document).ready(function() {
            var idusuario = "{{ $tramite['idsuario'] }}";
            var idtramiteAccede = "{{ $tramite['idtramiteaccede'] }}";
            var seccion_active = "{{ $tramite['seccion_active'] }}";

            var moduloselected = "{{ $tramite['modulo'] }}";
            localStorage.setItem("IdModuloSelected", moduloselected);

            var estatusTram = "{{ $tramite['estatus'] }}";
            var rolUser = "{{Auth::user()->TRAM_CAT_ROL->ROL_NIDROL}}";
            if(estatusTram == 1 && rolUser == 2){
                setInterval(function () {
                    TRAM_AJX_AUTOGUARDAR()
                }, 30000);
            }
            // existeCita(idusuario, id, idtramiteAccede);

            if ($('#sincita_edificios') != undefined) {
                //obtenerEdificios(idtramiteAccede, false)
                obtenerModulos(idtramiteAccede, false)
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(".btnEnviar").hide();

            var porcentaje = 0;
            var total_seccion = '{{ $cont }}';
            var total_seccion_aprobados = '{{ $aprobados }}';
            porcentaje = Math.round((total_seccion_aprobados / total_seccion) * 100);

            $("#porcentaje").html(porcentaje);

            $(".progress_circle").each(function() {

                var value = porcentaje;
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


            function TRAM_FN_DESACTIVARMODULO() {
                $('#cmbModulo').prop('disabled', 'disabled');
            }

            function TRAM_FN_CALCULARPORCENTAJE(percentage) {
                return percentage / 100 * 360
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
                            cmbModulo.append('<option value="' + v.id + '">' + v.nombre +
                                '</option>');
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

            function TRAM_FN_OCULTAR_CONTENEDOR() {
                $('.contenedor').each(function() {
                    $("#" + this.id).hide();
                });
            };

            function TRAM_FN_OCULTAR_FORM() {
                $('.form').each(function() {
                    $("#" + this.id).hide();
                });
            };



            //Secciones del tramite configurado
            $(".step_seccion").click(function() {
                var seccion = $(this).data("seccion");
                $('.step_seccion').each(function() {
                    var id = this.id;
                    if (Number(id.split("_")[1]) == seccion) {
                        $("#" + this.id).addClass("current");
                        $("#contenedor_" + id.split("_")[1]).toggle('show');
                    } else {
                        $("#" + this.id).removeClass("current");
                        $("#contenedor_" + id.split("_")[1]).hide();
                    }
                });
            });

            //Activa seccion
            if (seccion_active > 0) {
                //seccionconfig_90
                $("#seccionconfig_" + seccion_active).addClass("current");
                $("#contenedor_" + seccion_active).toggle('show');
            }

            //Secciones del formulario
            $(".step_form").click(function() {
                var seccion = $(this).data("seccion");
                $('.step_form').each(function() {
                    var id = this.id;
                    if (Number(id.split("_")[1]) == seccion) {
                        $("#" + this.id).addClass("current");
                        $("#form_" + id.split("_")[1]).toggle('show');
                    } else {
                        $("#" + this.id).removeClass("current");
                        $("#form_" + id.split("_")[1]).hide();
                    }
                });
            });
            //TRAM_AJX_CONSULTARMUNICIPIO();
            TRAM_FN_DESACTIVARMODULO();
            TRAM_FN_OCULTAR_CONTENEDOR();
            TRAM_FN_OCULTAR_FORM();

            //Get html
            $(".txtEnriquecido").each(function() {
                var id = this.id;
                CKEDITOR.instances[id].on('change', function() {
                    $("#" + id).val(CKEDITOR.instances[id].getData());
                });
            });

            //Subir documento
            $("#documentosP4").on('change','.documentos', function() {
                var id = this.id;
                var doctype = $(this).data("doctype");
                var formData = new FormData();
                var files = $("#" + id)[0].files[0];
                var size = $("#" + id)[0].files[0].size;
                var kb = (size / 1024)
                var mb = (kb / 1024)
                const fileType = files ? files.type : "unknown";
    
                formData.append('file',files);
                formData.append('doctype',doctype);
                if(fileType != "application/pdf"){
                    document.getElementById(id).value = "";
                    return  Swal.fire({ 
                                title: 'Error!',
                                text: 'Solo se permite PDF',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                }
                if(mb.toFixed(3) > 5){
                    document.getElementById(id).value = "";
                    return  Swal.fire({ 
                                title: 'Error!',
                                text: 'El archivo debe de pesar menos de 5Mb',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                }
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: 'Cargando documento',
                    showConfirmButton: false,
                    timer: 1500
                })


                var name = $(this).data("docname");
                $.ajax({
                    url: '/tramite_servicio/subir_documento',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if(response.extension=="pdf"){
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Listo!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#docs_" + id).val(response.path + "_" + response.extension + "_" + response.size+"_"+response.typename);
                            $("#size_" + id).html('<span>' + TRAM_FN_CONVERTIR_SIZE(response.size) + '</span>');

                            switch (response.extension) {
                                case "jpg":
                                    $("#icon_" + id).html(
                                        '<img src="{{ asset('assets/template/img/jpg.png') }}" width="25" height="25">'
                                        );
                                    break;
                                case "png":
                                    $("#icon_" + id).html(
                                        '<img src="{{ asset('assets/template/img/png.png') }}" width="25" height="25">'
                                        );
                                    break;
                                case "pdf":
                                    $("#icon_" + id).html(
                                        '<img src="{{ asset('assets/template/img/pdf.png') }}" width="25" height="25">'
                                        );
                                    break;
                                default:
                                    $("#icon_" + id).html(
                                        '<img src="{{ asset('assets/template/img/doc.png') }}" width="25" height="25">'
                                        );
                                    break;
                            }
                        }
                        else{
                            document.getElementById(id).value = "";
                            Swal.fire({ 
                                title: 'Error!',
                                text: 'Solo se permite PDF',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    }
                });
            });

            //Agregar formato de peso
            $(".documentos").each(function() {
                var id = this.id;
                var input = $("#docs_" + id).val();
                var arr = input.split("_");
                $("#size_" + id).html('<span>' + TRAM_FN_CONVERTIR_SIZE(arr[2]) + '</span>');
            });

            //Validar
            var $form = $("#frmForm");
            $form.validate().settings.ignore = [];

            $("#frmForm").validate({
                focusInvalid: true,
                invalidHandler: function() {
                    $(this).find(":input.error:first").focus();
                },
            });

            jQuery.extend(jQuery.validator.messages, {
                required: "Es requerido",
                maxlength: "El valor agregado solo puede ser a 18 digitos.",
                minlength: "El valor agregado solo puede ser a 18 digitos.",
            });

            $('.secconceptos').each(function() {
                var id = this.id;
                var _arr = id.split("_");
                var _id_seccion = _arr[1];
                var _json = {
                    "data": {
                        "ID": Number(_id_seccion),
                        "Modulo": "PD",
                        "Conceptos": []
                    }
                };

                //Mostrar info de pago
                var estatus_pagos = null;
                $.ajax({
                    url: "/consultar_pago/" + _id_seccion,
                    method: 'GET',
                    success: function(data) {
                        estatus_pagos = data[0].NO_ERROR;
                        $("#txtEstatus_" + _id_seccion).html(data[0].MENSAJE_ERROR);
                        $("#txtReferencia_" + _id_seccion).html(data[0].REFERENCIA);
                        $("#txtIdReferencia_" + _id_seccion).html(data[0].ID_REFERENCIA);
                        $("#txtMensaje_" + _id_seccion).html(data[0].MENSAJE + " <br/>" + data[
                            0].MENSAJE_2);

                        //Se oculta el btn de pagar unicamente cuando el estatus sea 0 o 4, tomando en cuenta que 0 es Pagado correctamente y 4 es no conciliado
                        if (estatus_pagos == 0 || estatus_pagos == 4) {
                            $("#linkPago_" + _arr[1]).hide();
                        } else {
                            $("#linkPago_" + _arr[1]).show();
                        }

                        $('#secconceptos_' + _arr[1]).find('input').each(function() {
                            var _arr_input = $(this).val().split("_");
                            _json.data.Conceptos.push({
                                "concepto": _arr_input[0],
                                "cantidad": _arr_input[1]
                            });
                        });
                        var string_ = JSON.stringify(_json.data);

                        string_ = string_.replace(/"/g, "'");
                        string_ =
                            'https://ipagostest.chihuahua.gob.mx/PagosDiversos/?parametro=' +
                            string_;
                        $("#linkPago_" + _arr[1]).attr("href", string_);
                    },
                    error: function(data) {}
                });
            });

            function TRAM_AJX_PAGOS() {
                var _json = {
                    "data": {
                        "ID": 300,
                        "Modulo": "DR",
                        "Conceptos": []
                    }
                };

                for (var a = 0; a < conceptos_pagos.length; a++) {
                    _json.data.Conceptos.push({
                        "concepto": conceptos_pagos[a].USCON_NREFERENCIA,
                        "cantidad": conceptos_pagos[a].USCON_NCANTIDAD
                    });
                }

                var string_ = JSON.stringify(_json.data);

                string_ = string_.replace(/"/g, "'");

                $.ajax({
                    data: _json,
                    url: "/encrypt",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        string_ = 'https://ipagostest.chihuahua.gob.mx/PagosDiversos/?parametro=' +
                            string_;

                        $("#PagosIframe").attr("src", string_);
                        $("#linkPago").attr("href", string_);
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: 'error',
                            footer: ''
                        });
                        $('#loading_save').hide();
                    }
                });
            };
            //TRAM_AJX_PAGOS();
            //iframe pagos

            //Cargar mapa y ubicacion de oficina
            setTimeout(function() {
                var lat = 0;
                var lon = 0;
                if ("{{ $tramite['ventanilla_sin_cita_lat'] }}" &&
                    "{{ $tramite['ventanilla_sin_cita_lon'] }}") {
                    lat = parseFloat("{{ $tramite['ventanilla_sin_cita_lat'] }}");
                    lon = parseFloat("{{ $tramite['ventanilla_sin_cita_lon'] }}");
                }

                var latitud = lat != 0 ? lat : 20.5936069;
                var longitud = lon != 0 ? lon : -100.3902893;
                var map = new google.maps.Map(document.getElementById('mapaEdificios'), {
                    center: {
                        lat: latitud,
                        lng: longitud
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
                    position: new google.maps.LatLng(latitud, longitud),
                    map: map,
                    title: 'Ubicación'
                });
            }, 1000);


            TRAM_FN_VERIFICAR_LLENADO();
            $(".selectCatalogos").selectpicker({
                noneSelectedText: 'Seleccionar',
            });

            /**
             * Obtiene el catalogo de giros
            */
            function getGiros(){
                $.ajax({
                    url: "/giros/find",
                    type: "GET",
                    data: { paginate:false, activo: true},
                    success: function(data) {
                        catGiros = data.data;
                    },
                    error: function(data) {
                        mensajeError('error', data)
                    }
                });
            }
            getGiros();


            if(tienePago == 1){
                actualizar_pago();
            }
        });

        function TRAM_FN_SUBIR_DOCUMENTO_MULTIPLE(val) {
            var id = "file_" + val;
            var formData = new FormData();
            var files = $("#" + id)[0].files[0];
            formData.append('file', files);

            var name = $(this).data("docname");
            var resultado = id.split("_");
            var bla = $('#txt_' + resultado[1]).val();



            $.ajax({
                url: '/tramite_servicio/subir_documento',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Listo!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#docs_" + id).val(response.path + "_" + response.extension + "_" + response.size + "_" +
                        bla);

                    $("#size_file" + id).html('<span>' + TRAM_FN_CONVERTIR_SIZE(response.size) + '</span>');
                    switch (response.extension) {
                        case "jpg":
                            $("#icon_" + id).html(
                                '<img src="{{ asset('assets/template/img/jpg.png') }}" width="25" height="25">'
                                );
                            break;
                        case "png":
                            $("#icon_" + id).html(
                                '<img src="{{ asset('assets/template/img/png.png') }}" width="25" height="25">'
                                );
                            break;
                        case "pdf":
                            $("#icon_" + id).html(
                                '<img src="{{ asset('assets/template/img/pdf.png') }}" width="25" height="25">'
                                );
                            break;
                        default:
                            $("#icon_" + id).html(
                                '<img src="{{ asset('assets/template/img/doc.png') }}" width="25" height="25">'
                                );
                            break;
                    }
                }
            });
        }

        function TRAM_FN_CAMBIAR_NOMBRE(name, id) {
            var bla = $('#txt_' + id).val();

            $("#file_" + id).attr("data-docname", bla);
            var old = $("#docs_file_" + id).val();
            var resultado = old.split("_");
            var nombreNuevo = resultado[0] + "_" + resultado[1] + "_" + resultado[2] + "_" + bla;
            $("#docs_file_" + id).val(nombreNuevo);

        }

        function TRAM_FN_GENERATE(n) {
            var add = 1,
                max = 12 -
                add; // 12 is the min safe number Math.random() can generate without it starting to pad the end with zeros.

            if (n > max) {
                return generate(max) + generate(n - max);
            }

            max = Math.pow(10, n + add);
            var min = max / 10; // Math.pow(10, n) basically
            var number = Math.floor(Math.random() * (max - min + 1)) + min;

            return ("" + number).substring(add);
        }

        function TRAM_FN_AGREGAR_ROW(name) {
            var iddata = TRAM_FN_GENERATE(8);
            $("#documentosP4").append('<tr>' +
                '<td> ' +
                "<div  class='form-check'> <input class='form-check-input' type='checkbox' value='' id=defaultCheck2' disabled> </div>" +
                '</td>' +
                '<td>' +
                " <div id='icon_file_" + iddata + "'>" +
                " <img src='{{ asset('assets/template/img/doc.png') }}'' width='20' height='20'>" +
                "</div>" +
                '</td>' +
                '<td>' + " <input type='text' class='form-control'  value='" + name + "' id='txt_" + iddata +
                "'    onchange='TRAM_FN_CAMBIAR_NOMBRE(\"" + iddata + "\",\"" + iddata + "\")'>" + '</td>' +
                '<td> ' +
                " <div id='size_file_" + iddata + "'> 0 Bytes</div>" +
                '</td>' +
                '<td> Pendiente revisión</td>' +
                '<td>' +
                " <img src='{{ asset('assets/template/img/warning.png') }}'' width='20' height='20'>" +
                '</td>' +
                '<td></td>' +
                '<td>' +
                " <input type='hidden' name='docs_file_" + iddata + "' id='docs_file_" + iddata + "' value='0_0_0_" +
                name + "'>" +
                "<input class='file-select documentos nuevo' name='file_" + iddata + "' id='file_" + iddata +
                "' data-docname='" + name + "' type='file' onchange='TRAM_FN_SUBIR_DOCUMENTO_MULTIPLE(\"" + iddata +
                "\")'>" +
                '</td>' +
                '<td>' +
                "<h5 class='font-weight-bold'><span class='circle-error-multi'  onclick='TRAM_FN_LIMPIARROW_DOCUMENTO(\"" +
                iddata + "\",\"" + name + "\")' >X</span></h5>" + '</td>' +
                +'</tr>');
        }

        function TRAM_FN_LIMPIARROW_DOCUMENTO(id, nombre) {
            console.log("elim");
            $("#file_"+id).show();
            $("#docs_file_" + id).val("0_0_0_" + nombre);
            $("#size_file_" + id).html("0 Bytes");
            $("#icon_file_" + id).html(
            "<img src='{{ asset('assets/template/img/doc.png') }}'' width='20' height='20'>");
            $("#chck_file_" + id).prop("checked", false);
            $('#file_'+id).attr("required", "required");
            $("#btnEnviar").hide();
        }

        //____________________________________
        function TRAM_AJX_ENVIAR_DOCUMENTO() {
            $("#loading-text").html("Enviando documentos...");
            $('#loading_save').show();
            $.ajax({
                data: $('#frmFormDocumento').serialize(),
                url: "/tramite_servicio/enviar_documentos",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        icon: data.status,
                        title: '',
                        text: data.message,
                        footer: ''
                    });
                    $('#loading_save').hide();
                },
                error: function(data) {
                    Swal.fire({
                        icon: data.status,
                        title: '',
                        text: data.message,
                        footer: ''
                    });
                    $('#loading_save').hide();
                }
            });
        };

        function TRAM_FN_VALIDAR(showMessage=true) {
            $(".txtEnriquecido").each(function() {
                var id = this.id;
                var editor_val = CKEDITOR.instances[id].getData();
                

                if (editor_val == "" || editor_val == null) {
                    $("#error_" + id).html('<label><span style="color: red;">¡Error!</span> Es requerido</label>');
                } else {
                    $("#error_" + id).html("");
                }
            });
            if (!$("#frmForm").valid()) {
                const full  = document.getElementsByClassName('full');
                const arr   = [...full].map(input => input.value);
                var divVal = "";
                arr.forEach(function(idDiv) {
                    divVal = $('#form_'+idDiv+' :input').valid()
                    $("#form_seccion_"+idDiv).empty();
                    if(!divVal){
                        $("#form_seccion_"+idDiv).append('<span><img src="{{ asset('assets/template/img/error.png') }}" width="20" height="20"></span>');
                    }else{
                        $("#form_seccion_"+idDiv).append('<span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>');
                    }

                })

                $(".btnEnviar").hide();
                Swal.fire({
                    title: '¡Aviso!',
                    text: 'No has contestado completamente el formulario, sin embargo, puedes continuarlo más tarde.',
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
                return false;
            } else {

                const full  = document.getElementsByClassName('full');
                const arr   = [...full].map(input => input.value);
                console.log("arr " + arr)
                var divVal = "";
                arr.forEach(function(idDiv) {
                    console.log("idDiv " + idDiv)
                    divVal = $('#form_'+idDiv+' :input').valid()
                    $("#form_seccion_"+idDiv).empty();
                    if(!divVal){
                        $("#form_seccion_"+idDiv).append('<span><img src="{{ asset('assets/template/img/error.png') }}" width="20" height="20"></span>');
                    }else{
                        $("#form_seccion_"+idDiv).append('<span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>');
                    }

                })

                if(showMessage){
                    Swal.fire({
                        title: '',
                        text: 'El formulario ha sido completado, y está listo para enviar a revisión.',
                        icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                }
                
                $(".btnEnviar").show();

                return true;
            }
        };

        function TRAM_FN_VERIFICAR_LLENADO() {

            var descripcionllenada = 0
            var nombreTramite = '{{ $tramite['nombre'] }}';
            var cuerpo =
                "tiene preguntas sin responder, usted necesita terminar el formulario para poder continuar con el proceso. Ir al formulario del trámite " +
                '"' + nombreTramite + '".';

            $(".txtEnriquecido").each(function() {
                var id = this.id;
                var editor_val = CKEDITOR.instances[id].getData();

                if (editor_val == "" || editor_val == null) {
                    descripcionllenada = 1
                } else {
                    descripcionllenada = 0
                }
            });
            if (!$("#frmForm").valid()) {
                $("#estatusFormulario").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                    ' El formulario del trámite "' + nombreTramite + '"' + cuerpo + ' </div>');
            } else {
                $("#estatusFormulario" + id).html("");
            }
        };

        function TRAM_AJX_GUARDAR() {
            $("#loading-text").html("Guardando...");
            $('#loading_save').show();

            const full  = document.getElementsByClassName('full');
            const arr   = [...full].map(input => input.value);

            var divVal = "";
            arr.forEach(function(idDiv) {
                divVal = $('#form_'+idDiv+' :input').valid()
                $("#form_seccion_"+idDiv).empty();
                if(!divVal){
                    $("#form_seccion_"+idDiv).append('<span><img src="{{ asset('assets/template/img/error.png') }}" width="20" height="20"></span>');
                }else{
                    $("#form_seccion_"+idDiv).append('<span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>');
                }

            })

            catalogos.forEach(element => {
                let respuestas  = element.respuesta;
                let id          = element.pregunta;
                let valor       = [];

                respuestas.forEach(item => {
                    let obj = {"id": item, "clave": $('#label_'+item).text(), "fecha": $('#fechaGiro_'+item).val()};
                    valor.push(obj);
                });

                $("#"+ id + "_input").val(JSON.stringify(valor));
            });

            $.ajax({
                data: $('#frmForm').serialize(),
                url: "/tramite_servicio/guardar",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        icon: data.status,
                        title: '',
                        text: data.message,
                        footer: ''
                    });
                    $('#loading_save').hide();
                },
                error: function(data) {
                    Swal.fire({
                        icon: data.status,
                        title: '',
                        text: data.message,
                        footer: ''
                    });
                    $('#loading_save').hide();
                }
            });
        };

        function TRAM_AJX_AUTOGUARDAR() {
            //$("#loading-text").html("Guardando...");
            //$('#loading_save').show();

            catalogos.forEach(element => {
                let respuestas  = element.respuesta;
                let id          = element.pregunta;
                let valor       = [];

                respuestas.forEach(item => {
                    let obj = {"id": item, "clave": $('#label_'+item).text(), "fecha": $('#fechaGiro_'+item).val()};
                    valor.push(obj);
                });

                $("#"+ id + "_input").val(JSON.stringify(valor));
            });

            $.ajax({
                data: $('#frmForm').serialize(),
                url: "/tramite_servicio/guardar",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    //console.log("guardado");
                    //$('#loading_save').hide();
                },
                error: function(data) {
                    //console.log("error guardar");
                    //$('#loading_save').hide();
                }
            });
        };

        function TRAM_AJX_ENVIAR() {
            if(TRAM_FN_VALIDAR(false)){
                catalogos.forEach(element => {
                    let respuestas  = element.respuesta;
                    let id          = element.pregunta;
                    let valor       = [];

                    respuestas.forEach(item => {
                        let obj = {"id": item, "clave": $('#label_'+item).text(), "fecha": $('#fechaGiro_'+item).val()};
                    valor.push(obj);
                    });

                    $("#"+ id + "_input").val(JSON.stringify(valor));
                });

                Swal.fire({
                    title: '',
                    text: '¿Está seguro de enviar su trámite?',
                    icon: 'success',
                    showCancelButton: true,
                    cancelButtonText: 'No, cancelar',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Sí enviar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#loading-text").html("Enviando...");
                        $('#loading_save').show();
                        $.ajax({
                            data: $('#frmForm').serialize(),
                            url: "/tramite_servicio/enviar",
                            type: "POST",
                            dataType: 'json',
                            success: function(data) {
                                if (data.status == "success") {
                                    Swal.fire({
                                        title: '¡Éxito!',
                                        text: data.message,
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        allowEnterKey: false,
                                        willClose: (el) => {
                                            Swal.fire({
                                                title: 'Espere un momento porfavor...',
                                                text: "",
                                                showConfirmButton: false,
                                                showCancelButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                allowEnterKey: false,
                                            })
                                            return false;
                                        },
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            //location.reload();
                                            $(location).attr('href',
                                                '/tramite_servicio/seguimiento_tramite/' + id);
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
                                $('#loading_save').hide();
                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: data.status,
                                    title: '',
                                    text: 'Error',
                                    footer: ''
                                });
                                $('#loading_save').hide();
                            }
                        });
                    }
                });
            }
        };

        function TRAM_AJX_ENVIAR_SEGUIMIENTO() {
            catalogos.forEach(element => {
                let respuestas  = element.respuesta;
                let id          = element.pregunta;
                let valor       = [];

                respuestas.forEach(item => {
                    let obj = {"id": item, "clave": $('#label_'+item).text(), "fecha": $('#fechaGiro_'+item).val()};
                    valor.push(obj);
                });

                $("#"+ id + "_input").val(JSON.stringify(valor));
            });

            Swal.fire({
                title: '',
                text: '¿Está seguro de enviar su trámite?',
                icon: 'success',
                showCancelButton: true,
                cancelButtonText: 'No, cancelar',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Sí enviar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loading-text").html("Enviando...");
                    $('#loading_save').show();
                    $.ajax({
                        data: $('#frmForm').serialize(),
                        url: "/tramite_servicio/reenviar",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == "success") {
                                Swal.fire({
                                    title: '¡Éxito!',
                                    text: data.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    willClose: (el) => {
                                        Swal.fire({
                                            title: 'Espere un momento porfavor...',
                                            text: "",
                                            showConfirmButton: false,
                                            showCancelButton: false,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            allowEnterKey: false,
                                        })
                                        return false;
                                    },
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        //location.reload();
                                        $(location).attr('href','/tramite_servicio/seguimiento_tramite/' + id);
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
                            $('#loading_save').hide();
                        },
                        error: function(data) {
                            Swal.fire({
                                icon: data.status,
                                title: '',
                                text: data.message,
                                footer: ''
                            });
                            $('#loading_save').hide();
                        }
                    });
                }
            });
        };

        function TRAM_AJX_ENVIAR_ENCUESTA_SATISFACCION() {
            $("#btnSubmit").prop("disabled", true);
            if (!$("#frmFormEncuesta").valid()) {
                $('.listError').hide();
                var validator = $('#frmFormEncuesta').validate();
                var htmlError =
                    "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Los siguientes datos son obligatorios:</strong> <br/>";
                $.each(validator.errorList, function(index, value) {
                    var campo = $("#" + value.element.id).attr('title');
                    if (value.method == "required") {
                        $('.listError').show();
                        htmlError += 'El campo "' + campo + '" es requerido.<br/>';
                    }
                });
                htmlError +=
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $(".listError").html(htmlError);
                $("#btnSubmit").prop("disabled", false);
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                return;
            }
            $.ajax({
                data: $('#frmFormEncuesta').serialize(),
                url: "/tramite_servicio/enviar_encuesta",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $("#btnSubmit").prop("disabled", false);
                    if (data.status == "success") {
                        $('#frmFormEncuesta').trigger("reset");
                        $(".listError").html("");

                        Swal.fire({
                            title: '¡Éxito!',
                            text: "Acción realizada con éxito",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            willClose: (el) => {
                                Swal.fire({
                                    title: 'Espere un momento porfavor...',
                                    text: "",
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                })
                                return false;
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $(location).attr('href', '/tramite_servicio/seguimiento_tramite/' + id);
                            }
                        });
                    } else {
                        Swal.fire({
                            title: '¡Aviso!',
                            text: "",
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

        function TRAM_AJX_ENVIAR_UBICACION_VENTANILLA_SIN_CITA() {
            $("#btnSaveUbication").prop("disabled", true);
            var selectedValue = $("#sincita_edificios").children("option:selected").val();

            if (selectedValue != 0) {
                Swal.fire({
                    title: '',
                    text: '¿Está seguro de guardar la ubicación?',
                    icon: 'success',
                    showCancelButton: true,
                    cancelButtonText: 'No, cancelar',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Sí enviar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#loading-text").html("Guardando...");
                        $('#loading_save').show();
                        $.ajax({
                            data: {
                                'id': id,
                                'id_ubicacion': selectedValue,
                                'longitud': ubicacion_ventanilla_sin_cita.longitud,
                                'latitud': ubicacion_ventanilla_sin_cita.latitud,
                            },
                            url: "/tramite_servicio/ubicacion_ventanilla",
                            type: "PUT",
                            dataType: 'json',
                            success: function(data) {
                                if (data.status == "success") {
                                    Swal.fire({
                                        title: '¡Éxito!',
                                        text: "Acción realizada con éxito",
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        allowEnterKey: false,
                                        willClose: (el) => {
                                            Swal.fire({
                                                title: 'Espere un momento porfavor...',
                                                text: "",
                                                showConfirmButton: false,
                                                showCancelButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                allowEnterKey: false,
                                            })
                                            return false;
                                        },
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $(location).attr('href',
                                                '/tramite_servicio/seguimiento_tramite/' +
                                                id);
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
                                $("#btnSaveUbication").prop("disabled", false);
                                $('#loading_save').hide();
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: '¡Aviso!',
                                    text: data.message,
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    showConfirmButton: false,
                                });
                                $(location).attr('href', '/tramite_servicio/seguimiento_tramite/' + id);
                                $("#btnSaveUbication").prop("disabled", false);
                                $('#loading_save').hide();
                            }
                        });
                    } else {
                        $("#btnSaveUbication").prop("disabled", false);
                    }
                });
            } else {
                $("#btnSaveUbication").prop("disabled", false);
                Swal.fire({
                    title: '¡Aviso!',
                    text: 'No has seleccionado la Ubicación.',
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }

        };

        function TRAM_FN_DETALLE_NOTIFICACION(id) {
            $(location).attr('href', '/tramite_servicio/consultar_detalle_notificacion/' + id);
        };

        function descargarResolutivo(id){
            let input   = document.getElementById("inputFormat").value;
            let base    = input.split("|");

            $.ajax({
                type: 'GET',
                url: '/tramite_servicio/getResolutivo/' + 241,
                success: function(data) {
                    console.log(data);
                    let url = base[0] +  data.url;
                    let a = document.createElement('a');
                    /* let url = window.URL.createObjectURL(data); */
                    console.log("Manuel", url);
                    a.href = url;
                    a.download = "Formato";
                    a.click();
                    window.URL.revokeObjectURL(url);
                },
                error: function(resp) {
                    let error = JSON.parse(resp.responseText);
                    respuestaError(error);
                    document.getElementById("overlay").style.display = "none";
                }
            });

            document.getElementById("archivoReso").click();
        }

        //Convertir byte a (Kb, Mb, Gb, Tb)
        function TRAM_FN_CONVERTIR_SIZE(size) {
            if (isNaN(size))
                size = 0;

            if (size < 1024)
                return size + ' Bytes';

            size /= 1024;

            if (size < 1024)
                return size.toFixed(2) + ' KB';

            size /= 1024;

            if (size < 1024)
                return size.toFixed(2) + ' MB';

            size /= 1024;

            if (size < 1024)
                return size.toFixed(2) + ' GB';

            size /= 1024;

            return size.toFixed(2) + ' TB';
        }

        $('.selectCatalogos').on('change', function(e) {
            let select  = e.target.id;
            let items   = $("#"+select).val();
            let aplica  = true;
            let html    = '';
            let json    = null;
            let valor   = {"id": select, "valor": $("#"+select+"_input").val()} ;

            if(items.length > 4){
                $(".selectCatalogos option[value="+id+"]").attr("selected", false);
                $('.selectpicker').selectpicker('deselectAll');
                $('.selectpicker').selectpicker('val', antSel);
                $('.selectpicker').selectpicker('refresh');
                mensajeError("info", "Solo es posible seleccionar hasta 4 especialidades.");
                return;
            }
            else{
                antSel = items;
            }

            if(valor != ""){
                json = JSON.parse(valor.valor);
            }

            items.forEach(element => {
                let label       = "";
                let nombreGiro  = "";
                catGiros.forEach(giro => {
                    if(giro.id == parseInt(element)){
                        label       = giro.clave;
                        nombreGiro  = giro.nombre;
                    }
                });

                let fecha = '';
                if(json!=null){
                    json.forEach(aniosGuar => {
                        if(element == aniosGuar.id){
                            fecha = aniosGuar.fecha;
                        }
                    });
                }

                html += `<div>
                    <label id= 'label_${element}' for="">Giro-${label}, ${nombreGiro}</label>
                    <input type="date" id="fechaGiro_${element}" name="fechaGiro_${element}" class="form-control txt_abierta" placeholder="Fecha" value="${fecha}" required/> <br />
                </div>`;
            });
            $("#inputGiro_"+select).html(html);

            catalogos.forEach(element => {
                if(element.pregunta == select){
                    element.respuesta = items;
                    aplica = false;
                }
            });

            if(aplica){
                catalogos.push({pregunta: select,respuesta:items })
            }
        });

        function mensajeError(icon = 'error', message = ''){
            console.log(message);
            Swal.fire({
                icon: icon,
                title: '',
                text: message,
                footer: ''
            });
        }
    </script>


    <!-- JS CALENDARIO -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/locales-all.js"></script>

    <script> //Construccion del calendario
        function calendarInit() {
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendario');
                window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                    // right: 'dayGridMonth,timeGridWeek'
                },
                events: [],
                datesSet: cargarEventos,
                dateClick: function(info) {
                    dateClickEvent(info);
                }
                });
                window.calendar.render();
            });
        }
    </script>

    <script> //Carga de eventos en el calendario
        function cargarEventos(payload) {
            var tramite = "{{ $tramite['idtramiteaccede'] }}";
            var modulo = "{{ $tramite['infoModulo']['iId'] }}";
            if (tramite == 0 || tramite == undefined || tramite == null || modulo == 0 || modulo == undefined || modulo == null) {
                mostrarAlerta('Debe seleccionar un modulo para ver las citas disponibles.');
                return;
            }
            $('#modalLoad').modal('show');
            var URL_COMP = "";
            if (payload == null){
                const d = new Date();
                URL_COMP = '/' + d.getFullYear() + '/' + (d.getMonth() + 1)
            } else {
                URL_COMP = formatURLGet(payload.view.currentStart);
            }

            let fecha = URL_COMP.split("/");
            $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            request = $.ajax({
                url : '/api/citas',
                type: "GET",
                data: {"tramite_id": tramite, 'edificio_id': modulo, 'anio': fecha[1], 'mes':  parseInt(fecha[2]), 'tipo': 'usuario' }
            });
            //On success
            request.done(function (response, textStatus, jqXHR){
                $('#modalLoad').modal('hide');
                pintarDisponibilidad(response);
                mostrarAlerta("Se cargaron los horarios disponibles");
                window.resultadoMes = response;
            });
            //On failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                $('#modalLoad').modal('hide');
                mostrarAlerta("No se encontraron horarios");
            });
        }
        $('#formFiltrar').click(function () {
            cargarEventos();
        });
    </script>

    <script>// Interaccion UI
        //Mostrar alerta con el mensaje enviado
        function mostrarAlerta(txt) {
            $("#toastMsj").text(txt);
            $('.toast').toast({delay: 3000});
            $('.toast').toast('show');
        }
        // Colorea el calendario con segun los datos del mes
        function pintarDisponibilidad(data, payload) {
            var events = [];
            for(var row in data) {
                var color = (data[row].horario.porcentajeOcupacion < 40 // menos de 40 Verde
                    ? '#42E04C'
                    : ( 40 <= data[row].horario.porcentajeOcupacion // 40 - 80 Amarillo
                    && data[row].horario.porcentajeOcupacion < 80 ? '#FAE847' : '#F01919')); //Mayor a 80 Rojo
                color = (data[row].horario.length == 0 ? '#0A0A0A' : color);
                var colores = {
                    start: data[row].fecha,
                    end: data[row].fecha,
                    overlap: false,
                    display: 'background',
                    color: color
                };
                events.push(colores);
            }
            //Eliminar eventos del listado
            removeEvents = window.calendar.getEventSources();
            removeEvents.forEach(event => {
                event.remove();
            });
            window.calendar.setOption('height', document.querySelector('#rightContainer').offsetHeight);
            window.calendar.addEventSource(events) //agregar eventos de resultado de busqueda
            window.calendar.refetchEvents(); //Recolorear los eventos
        }
        //Construye la URL para la peticion de los datos del mes "Solo la parte de la fecha"
        function formatURLGet(text) {
            var texto = text;
            var array = texto.toString().split(' ');
            var month = "";
            switch (array[1]) {
                case 'Jan':
                    month = "1"
                    break;
                case 'Feb':
                    month = "2"
                    break;
                case 'Mar':
                    month = "3"
                    break;
                case 'Apr':
                    month = "4"
                    break;
                case 'May':
                    month = "5"
                    break;
                case 'Jun':
                    month = "6"
                    break;
                case 'Jul':
                    month = "7"
                    break;
                case 'Aug':
                    month = "8"
                    break;
                case 'Sep':
                    month = "9"
                    break;
                case 'Oct':
                    month = "10"
                    break;
                case 'Nov':
                    month = "11"
                    break;
                case 'Dec':
                    month = "12"
                    break;
            }

            url = "/" + array[3] + "/" + month;
            return url;
        }
        // Evento al click en la celda de la fecha
        //Carga los horarios disponibles para cita en el formulario
        function dateClickEvent(info) {
            $("#formRFecha").text("Fecha: ");
            $('#btnAgendarCita').attr('disabled', true);
            window.dateOnDisplay = null;
            $(".rowFecha").remove();
            if (window.resultadoMes.length == 0) {
                mostrarAlerta("Aún debe seleccionar los campos del filtro y agendar en la fecha: " + info.dateStr);
                return;
            }
            var arrFecha = info.dateStr.split('-');
            let fechaDFormat = arrFecha[2] + "/" + arrFecha[1] + "/" + arrFecha[0];
            $("#formRFecha").text("Fecha: " + fechaDFormat);
            var horarios = [];
            for(var row in window.resultadoMes){
                if (info.dateStr == window.resultadoMes[row]['fecha']) {
                    horarios = window.resultadoMes[row]['horario'];
                    window.dateOnDisplay = row;
                }
            }
            $(".rowFecha").remove();
            if (horarios == [] || horarios == undefined || horarios.length == 0) {
                mostrarAlerta("No hay horarios para la fecha seleccionada: " + info.dateStr);
                $("#formRFecha").text("Fecha: ");
                return;
            }
            let ventanillas = horarios.ventanillas;
            var container = document.getElementById("horariosContainer");
            for(var row in horarios.disponibles){
                if (horarios.disponibles[row].recervas < ventanillas) {
                    let element = '<div class="col-lg-12 row rowFecha"><div class="col-lg-9"><p style="margin-top: 6px; margin-bottom: 10px;">' +
                    horarios.disponibles[row].horario + '</p></div><div class="col-lg-3"><label class="containerL"><input value="' +
                    row +'" type="radio" name="radio"><span class="checkmark"></span></label></div></div>';
                    container.insertAdjacentHTML('beforeend', element);
                }
            }
            $('#btnAgendarCita').removeAttr('disabled');
        }
    </script>

    <script>//Funciones para el formulario lateral
        //Almacenar la cita con la hora seleccionada en el formulario
        $('#btnAgendarCita').click(function () {
            $('#btnAgendarCita').attr('disabled', true);
            var citaSeleccionada = $('input[name="radio"]:checked', '#horariosContainer').val();
            if (window.dateOnDisplay == null || window.dateOnDisplay == undefined ||
                window.dateOnDisplay == 0 || citaSeleccionada == null || citaSeleccionada == undefined) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Necesita seleccionar un horario para agendar una cita'
                });
                $("#btnAgendarCita").removeAttr('disabled');
                return;
            }
            $('#modalLoad').modal('show');
            let data    = {
                "CITA_IDUSUARIO": "{{ $tramite['idsuario'] }}",
                "CITA_FECHA": window.resultadoMes[window.dateOnDisplay].fecha,
                "CITA_HORA": window.resultadoMes[window.dateOnDisplay].horario.disponibles[citaSeleccionada].horario,
                "CITA_IDTRAMITE": "{{ $tramite['id'] }}",
                "CITA_IDMODULO":  "{{ $tramite['infoModulo']['iId'] }}",
                "CITA_FOLIO":  "{{ $tramite['folio'] }}"

            };
            $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            request = $.ajax({
                url : '/api/citas',
                type: "POST",
                data: data,
            });
            //On success
            request.done(function (response, textStatus, jqXHR){
                $('#modalLoad').modal('hide');
                if (response.codigo == 200) {
                    $("#citaFolio").text("Folio: " + response.cita.CITA_FOLIO);
                    $("#citaFecha").text("Fecha: " + response.cita.CITA_FECHA);
                    $("#citaHora").text("Hora: " + response.cita.CITA_HORA);
                    $("#citaMunicipio").text("Municipio: " + "{{ $tramite['infoModulo']['Municipality'] }}");
                    $("#citaModulo").text("Módulo: " + "{{ $tramite['infoModulo']['Name'] }}");
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Operación exitosa',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }, 400);
                    window.cita = response.cita;
                    window.cita.MUNICIPIO = "{{ $tramite['infoModulo']['Municipality'] }}";
                    window.cita.MODULO = "{{ $tramite['infoModulo']['Name'] }}";
                    $('#citaInfoModal').modal('show');
                } else {
                    setTimeout(() => {
                        Swal.fire({
                            icon: response.estatus,
                            title: 'Alerta',
                            text: response.mensaje,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }, 400);
                    $("#btnAgendarCita").removeAttr('disabled');
                }
            });
            //On failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                $('#modalLoad').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });
        });
        //Descarga el formulario
        $('#btnPDF').click(function () {
            $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            request = $.ajax({
                url : '/api/citas/descargar',
                type: "POST",
                data: window.cita,
                responseType: 'blob'
            });
            //On success
            request.done(function (response, textStatus, jqXHR){
                window.open(response.URL);
            });
            //On failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'se presento el siguiente error: ' + errorThrown
                });
            });
        });
    </script>

    //FUNCIONALIDAD DE LAS CITAS AGENDADAS
    <script>
        let estatus = "{{ $tramite['estatus'] }}";
        var countCita = "{{ count($tramite['cita']) }}";
        if (countCita > 0) {
            $("#concitareservada").show();
            $("#sincitareservada").remove();
            // Información de la cita

            // $("#citaConfirmado").text("{{ @($tramite['cita']['CONFIRMADO'] ? 'Confirmado' : 'Sin confirmar') }}");

            $("#citaConfirmado").text("{{ @($tramite['cita']['CONFIRMADO'] ? 'Aprobado' : 'Agendado') }}");

            $("#citaFolio").text("{{ @$tramite['cita']['FOLIO'] }}");
            $("#citaFecha").text("{{ @$tramite['cita']['FECHA'] }}");
            $("#citaHora").text("{{ @$tramite['cita']['HORA'] }}");
            $("#citaEdificio").text("{{ $tramite['infoModulo']['Name'] }}");
            $("#citaDireccion").text("{{ $tramite['infoModulo']['Street'] }}" + ", N° "
                + "{{ $tramite['infoModulo']['ExternalNumber'] }}" + ", CP: "
                + "{{ $tramite['infoModulo']['PostalCode'] }}"
            );
            $("#citaTramite").text("{{ $tramite['nombre'] }}");
        } else if (estatus != 9) {
            $("#sincitareservada").show();
            $("#concitareservada").remove();
            calendarInit();
        } else {
            $("#sincitareservada").remove();
            $("#concitareservada").remove();
            $(".sinCitaHide").attr("style", "display: none;");
        }

        function removeCita() {
            var countCita = "{{ count($tramite['cita']) }}";
            if (countCita > 0) {
                $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                request = $.ajax({
                    url : '/api/citas/'+"{{ @$tramite['cita']['ID'] }}",
                    type: "DELETE",
                });
                //On success
                request.done(function (response, textStatus, jqXHR){
                    setTimeout(() => {
                        Swal.fire({
                            icon: response.estatus,
                            title: 'Alerta',
                            text: response.mensaje,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }, 400);
                    window.location.reload();
                });
                //On failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'se presento el siguiente error: ' + errorThrown
                        });
                    }, 400);
                    $("#cancelarCita").removeAttr('disabled');
                    $('#modalLoad').modal('hide');
                });
            } else {
                mostrarAlerta("No hay citas agendadas");
            }
        }

        $("#cancelarCita").click(function () {
            $('#modalLoad').modal('show');
            $("#cancelarCita").attr('disabled', true);
            removeCita();
        });

        $("#finish").click(function () {
            $('#modalLoad').modal('show');
            window.location.reload();
        });


        document.addEventListener('DOMContentLoaded', function() {

            

        });

    </script>
    

@endsection
