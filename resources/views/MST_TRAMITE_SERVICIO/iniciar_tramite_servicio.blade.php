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
                    <!-- <h6><strong>Folio: </strong>{{$tramite['idtramiteaccede']}}</h6> -->
                    <h6><strong>Fecha de actualización: </strong>{{$tramite['fechaactualizacion']}}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-12">
                    <!-- <div class="bg-white rounded-lg p-5 shadow"> -->
                    <div>
                        <!--<h2 class="h6 font-weight-bold text-center mb-4">Avance de Trámite</h2>-->
                        <!-- Progress bar 1 -->
                        <!--<div class="progress_circle mx-auto" data-value='0'>
                            <span class="progress_circle-left">
                                <span class="progress_circle-bar border-primary"></span>
                            </span>
                            <span class="progress_circle-right">
                                <span class="progress_circle-bar border-primary"></span>
                            </span>
                            <div class="progress_circle-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                <div class="h2 font-weight-bold" style="color:#03A9F4 !important;">0<sup class="small">%</sup></div>
                            </div>
                        </div>-->
                        <!-- END -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row seccion-representar" style="display: none !important;">
        <div class="col-md-12">
            <label style="font-weight: bold; font-size:20px;">Por favor ingrese la información solicitada:</label>
        </div>
    </div><br/>

    <div class="row seccion-representar" style="display: none !important;">
        <div class="col-md-6 text-right">
            <label style="font-weight: bold; font-size:16px;">¿El trámite se realizará en representación de otra persona?</label>
        </div>
        <div class="col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input rdbRepresentacion" type="radio" name="rdbRepresentacion" id="rdbRepresentacion1" value="0" onclick="TRAM_FN_REPRESENTAR(this);">
                <label class="form-check-label" for="rdbRepresentacion1">Si</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input rdbRepresentacion" type="radio" name="rdbRepresentacion" id="rdbRepresentacion2" value="1" onclick="TRAM_FN_REPRESENTAR(this);">
                <label class="form-check-label" for="rdbRepresentacion2">No</label>
            </div>
        </div>
    </div>

    <div class="row seccion-representar" style="display: none !important;">
        <div class="col-md-6 text-right seccion-tipopersona" style="display: none !important;">
            <label style="font-weight: bold; font-size:16px;">Por favor, selecciona una opción.</label>
        </div>
        <div class="col-md-6 seccion-tipopersona" style="display: none !important;">
            <div class="form-check form-check-inline">
                <input class="form-check-input rdbTipoPersona" type="radio" name="rdbTipoPersona" id="rdbTipoPersona1" value="0" onclick="TRAM_FN_SELECCIONAR_TIPO_PERSONA(this);">
                <label class="form-check-label" for="rdbTipoPersona1">Física</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input rdbTipoPersona" type="radio" name="rdbTipoPersona" id="rdbTipoPersona2" value="1" onclick="TRAM_FN_SELECCIONAR_TIPO_PERSONA(this);">
                <label class="form-check-label" for="rdbTipoPersona2">Moral</label>
            </div>
        </div>
    </div>

    <div class="row seccion-representar" style="display: none !important;">
        <div class="col-md-6 cmb-tipopersona-fisica" style="display: none !important;">
            <div class="form-group">
                <label>Por favor, selecciona una opción.</label>
                @if(count($tramite['gestores_fisica']) > 0)
                    <select class="form-control cmbUsuario" name="cmbUsuario">
                        <option value="0">Selecciona una opción</option>
                        @foreach($tramite['gestores_fisica'] as $opt)
                            <option value="{{$opt->USUA_NIDUSUARIO}}" data-rfc="{{$opt->USUA_CRFC}}" data-curp="{{$opt->USUA_CCURP}}" data-nombre="{{$opt->USUA_CNOMBRES}} {{$opt->USUA_CPRIMER_APELLIDO}} {{$opt->USUA_CSEGUNDO_APELLIDO}}">{{$opt->USUA_CNOMBRES}} {{$opt->USUA_CPRIMER_APELLIDO}} {{$opt->USUA_CSEGUNDO_APELLIDO}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div style="border: 1px dashed black; padding:15px; width:100%">
                        <p style="color: #000;"><b style="font-weight: 600;">NOMBRE:</b> <label class="dato-nombre-razonsocial"></label></p>
                        <p style="color: #000;"><b style="font-weight: 600;">RFC:</b> <label class="dato-rfc"></label></p>
                        <p style="color: #000;"><b style="font-weight: 600;">CURP:</b> <label class="dato-curp"></label></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 cmb-tipopersona-moral" style="display: none !important;">
            <div class="form-group">
                <label>Por favor, selecciona una opción.</label>
                @if(count($tramite['gestores_moral']) > 0)
                    <select class="form-control cmbUsuario" name="cmbUsuario">
                        <option value="0">Selecciona una opción</option>
                        @foreach($tramite['gestores_moral'] as $opt)
                            <option value="{{$opt->USUA_NIDUSUARIO}}" data-rfc="{{$opt->USUA_CRFC}}" data-curp="{{$opt->USUA_CCURP}}" data-nombre="{{$opt->USUA_CRAZON_SOCIAL}}">{{$opt->USUA_CRAZON_SOCIAL}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div style="border: 1px dashed black; padding:15px; width:100%">
                        <p style="color: #000;"><b style="font-weight: 600;">RAZÓN SOCIAL:</b> <label class="dato-nombre-razonsocial"></label></p>
                        <p style="color: #000;"><b style="font-weight: 600;">RFC:</b> <label class="dato-rfc"></label></p>
                        <p style="color: #000;"><b style="font-weight: 600;">CURP:</b> <label class="dato-curp"></label></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row seccion-representar" style="display: none !important;">
        <div class="col-md-12">
            <hr/>
        </div>
    </div>

    <div class="row seccion-tramite" style="display: none !important;">
        <div class="col-md-12">
            <label style="font-weight: bold; font-size:20px;">Indique el módulo en el cuál prefiere que se lleve a cabo el trámite</label>
        </div>
        <div class="col-md-12" style=" padding-top: 20px; ">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
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
                            <label style="font-size: 12px;" id="UbicacioModulo"></small>
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
    <?php $arrayClabe = array('Clabe', 'interbancaria', '18', 'clabe', 'clave'); ?>
    <div class="row seccion-tramite" style="display: none !important;">
        <div class="card" style="width: 100%; border-radius:20px;" id="sec_form">
            <div class="card-header" style="background-color: #ffffff; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <div class="arrow-steps clearfix">
                    @if(count($tramite['configuracion']['formularios'])> 0)
                        @foreach($tramite['configuracion']['formularios'] as $form)
                            @if($form->secciones > 0)
                                <?php $cont = 0; $total = 0;?>
                                @foreach($form->secciones as $sec)
                                    @if(count($sec->preguntas) > 0)
                                        <?php $total++;?>
                                        @if($cont == 0)
                                            <div class="step" id="seccion_{{$sec->FORM_NID}}" data-seccion="{{$sec->FORM_NID}}" 
                                            style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;"> 
                                            <span>{{$sec->FORM_CNOMBRE}} </span> <span id="span_{{$sec->FORM_NID}}"></span> </div>
                                            <input class="full" type="hidden" value="{{$sec->FORM_NID}}">
                                        @elseif($cont == $total - 1)
                                            @if(count($tramite['configuracion']['documentos']) == 0)
                                                <div class="step" id="seccion_{{$sec->FORM_NID}}" data-seccion="{{$sec->FORM_NID}}" 
                                                style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;"> 
                                                <span>{{$sec->FORM_CNOMBRE}}</span> <span id="span_{{$sec->FORM_NID}}"></span> </div>
                                                <input class="full" type="hidden" value="{{$sec->FORM_NID}}">
                                            @else
                                                <div class="step" id="seccion_{{$sec->FORM_NID}}" data-seccion="{{$sec->FORM_NID}}"> 
                                                    <span>{{$sec->FORM_CNOMBRE}}</span> <span id="span_{{$sec->FORM_NID}}"></span> </div>
                                                    <input class="full" type="hidden" value="{{$sec->FORM_NID}}">
                                            @endif
                                        @else
                                            <div class="step" id="seccion_{{$sec->FORM_NID}}" data-seccion="{{$sec->FORM_NID}}"> <span>{{$sec->FORM_CNOMBRE}}</span> <span id="span_{{$sec->FORM_NID}}"></span> </div>
                                            <input class="full" type="hidden" value="{{$sec->FORM_NID}}">
                                        @endif
                                        <?php $cont++; ?>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                    @if(count($tramite['configuracion']['documentos'])> 0)
                        <div class="step" id="seccion_0" data-seccion="0" style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;"> <span>Documentos</span> <span id="span_0"></span> </div>
                        <input class="full" type="hidden" value="0">
                    @endif
                </div>
            </div>
            <div class="card-body" style="color: #23468c;">
                <form enctype="multipart/form-data" id="frmForm">
                    <input type="hidden" name="txtIdTramite" value="{{$tramite['id']}}">
                    <input type="hidden" name="txtEstatus" value="{{$tramite['estatus']}}">
                    <input type="hidden" name="txtFolio" value="{{$tramite['folio']}}">
                    <input type="hidden" name="txtIdUsuario" id="txtIdUsuario" value="{{$tramite['idsuario']}}">
                    <input type="hidden" name="txtLatitud" id="txtLatitud" value="0">
                    <input type="hidden" name="txtLongitud" id="txtLongitud" value="0">
                    <input type='hidden' name='txtModulo' id="txtModulo" value='0'/>
                    @if(count($tramite['configuracion']['secciones'])> 0)
                        @foreach($tramite['configuracion']['secciones'] as $confsec)
                            <input type="hidden" name="secc_{{$confsec->CONF_NIDCONFIGURACION}}" value="{{$confsec->CONF_NSECCION}}">
                        @endforeach
                    @endif
                    <?php $resARR = [];?>
                    @if(count($tramite['configuracion']['formularios'])> 0)
                        @foreach($tramite['configuracion']['formularios'] as $form)
                            @if($form->secciones > 0)
                                @foreach($form->secciones as $sec)
                                    @if(count($sec->preguntas) > 0)
                                        <div class="row form" id="form_{{$sec->FORM_NID}}" style="display: none">
                                            @foreach($sec->preguntas as $preg)
                                                @switch($preg->FORM_CTIPORESPUESTA)
                                                    @case('abierta')
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="resp_{{$preg->FORM_NID}}">{{$preg->FORM_CPREGUNTA}} </label>
                                                                @php  
                                                                    $validacion = strpos(strtolower($preg->FORM_CPREGUNTA), 'interbancaria') !== false ? 'minlength=18 maxlength=18' : "";
                                                                    $tipo       = $validacion ? "number" : "text";
                                                                    $clase      = $validacion ? "" : "txt_abierta";
                                                                @endphp 

                                                                @if($preg->respuestas > 0)
                                                                    @foreach($preg->respuestas as $resp)
                                                                    <?php 
                                                                    if (in_array($preg->FORM_NID, $resARR)) {
                                                                        //echo 'si esta';
                                                                    }else{
                                                                    $resARR[] = $preg->FORM_NID;
                                                                    ?>
                                                                        <input type="{{$tipo}}" class="form-control {{$clase}}" 
                                                                        name="resp_{{$preg->FORM_NID}}_0" 
                                                                        id="resp_{{$preg->FORM_NID}}_0" 
                                                                        placeholder="{{$preg->FORM_CPREGUNTA}}" vinculacion="<?php echo(isset($preg->FORM_CVALORASIGNACION)? ($preg->FORM_CVALORASIGNACION):"" )?>"
                                                                        required {{$validacion}}> 
                                                                    <?php };    ?>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('unica')
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="resp_{{$preg->FORM_NID}}">{{$preg->FORM_CPREGUNTA}}</label>
                                                                @if($preg->respuestas > 0)
                                                                    @foreach($preg->respuestas as $resp)
                                                                        <div class="custom-control custom-radio">
                                                                            <input class="custom-control-input" type="radio" name="resp_{{$preg->FORM_NID}}_0" id="resp_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" value="{{$resp->FORM_NID}}" checked required>
                                                                            <label class="custom-control-label" for="resp_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}">
                                                                                {{$resp->FORM_CVALOR}}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('multiple')
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="resp_{{$preg->FORM_NID}}">{{$preg->FORM_CPREGUNTA}}</label>
                                                                @if($preg->respuestas > 0)
                                                                    <?php $cont_chk = 0; $cont_validar = 0;  ?>
                                                                  @foreach($preg->respuestas as $resp)
                                                                        <?php $required_chk = ""; /*$cont_chk == 0 ? "required" : ""*/ ?>
                                                                        <div class="custom-control custom-checkbox ">
                                                                            <input class="custom-control-input multiple-disabled_{{$preg->FORM_NID}}" data-valuechk="{{$resp->FORM_NID}}" data-disabledchk="{{$resp->FORM_BBLOQUEAR == 1 ? 1 : 0}}" onChange="TRAM_FN_VALIDAR_DISABLED({{$preg->FORM_NID}},{{$resp->FORM_BBLOQUEAR == 1 ? 1 : 0}}, {{$resp->FORM_NID}})" type="checkbox" name="resp_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="resp_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" value="{{$resp->FORM_NID}}"  {{$required_chk}}>
                                                                            <label class="custom-control-label" for="resp_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}">
                                                                                {{$resp->FORM_CVALOR}}
                                                                            </label>
                                                                        </div>
                                                                        <?php $cont_chk++;  ?>
                                                                    @endforeach

                                                                @endif
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('enriquecido')
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="resp_{{$preg->FORM_NID}}">{{$preg->FORM_CPREGUNTA}}</label>
                                                                @if($preg->respuestas > 0)
                                                                    @foreach($preg->respuestas as $resp)
                                                                        <div class="form-group">
                                                                            <textarea class="txtEnriquecido" name="resp_{{$preg->FORM_NID}}_0" id="resp_{{$preg->FORM_NID}}_0" rows="5" style="display: block !important;" required>
                                                                                {{$resp->FORM_CVALOR}}
                                                                            </textarea>
                                                                            <label id="error_resp_{{$preg->FORM_NID}}_0"></label>
                                                                        </div>
                                                                        <script>
                                                                            CKEDITOR.replace(resp_{{$preg->FORM_NID}}_0);
                                                                        </script>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('especial')
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="resp_{{$preg->FORM_NID}}">{{$preg->FORM_CPREGUNTA}}</label>
                                                                <table class="table table-striped table-bordered">
                                                                    @if($preg->respuestas > 0)
                                                                        <tr>
                                                                            @foreach($preg->respuestas as $resp)
                                                                                <th>
                                                                                    {{$resp->FORM_CVALOR}}
                                                                                </th>
                                                                            @endforeach
                                                                        </tr>
                                                                        <tr>
                                                                            @foreach($preg->respuestas as $resp)
                                                                                <td>
                                                                                    @switch($resp->FORM_CTIPORESPUESTAESPECIAL)
                                                                                        @case('simple')
                                                                                            <div class="form-group">
                                                                                                @if($resp->respuestas_especial > 0)
                                                                                                    @foreach($resp->respuestas_especial as $resp_esp)
                                                                                                        <input type="text" class="form-control txt_abierta" name="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" placeholder="{{$resp->FORM_CVALOR}}" required>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </div>
                                                                                            @break
                                                                                        @case('numerico')
                                                                                            <div class="form-group">
                                                                                                @if($resp->respuestas_especial > 0)
                                                                                                    @foreach($resp->respuestas_especial as $resp_esp)
                                                                                                    <?php $division = explode(" ", $resp->FORM_CVALOR); ?>
                                                                                                        @if(in_array('Clabe', $division) || in_array('interbancaria', $division) || in_array('clabe', $division) || in_array('clave', $division))
                                                                                                        <input type="text" pattern="\d*" class="form-control" name="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" placeholder="{{$resp->FORM_CVALOR}}" maxlength="18" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required>
                                                                                                        @else
                                                                                                        <input type="number" class="form-control" name="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" placeholder="{{$resp->FORM_CVALOR}}" required>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </div>
                                                                                            @break
                                                                                        @case('opciones')
                                                                                            <div class="form-group">
                                                                                                @if($resp->respuestas_especial > 0)
                                                                                                    <select class="form-control" name="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" required>
                                                                                                        @foreach($resp->respuestas_especial as $resp_esp)
                                                                                                            <option value="{{$resp_esp->FORM_NID}}">{{$resp_esp->FORM_CVALOR}}</option>
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
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('catalogo')

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="resp_{{$preg->FORM_NID}}">{{$preg->FORM_CPREGUNTA}}</label>
                                                                @if ($preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros')
                                                                    <input type="hidden" name="resp_{{$preg->FORM_NID}}_0" id="resp_{{$preg->FORM_NID}}_0_input">
                                                                @endif
                                                                <?php 
                                                                    $multiple   = $preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros' ? 'multiple' : '';
                                                                    $class      = $preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros' ? 'selectCatalogos' : '';
                                                                    $name       = $preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros' ? '' : 'name=resp_'.$preg->FORM_NID.'_0';
                                                                ?>
                                                                <select id="resp_{{$preg->FORM_NID}}_0" class="selectpicker form-control {{$class}}" data-live-search="true" {{$multiple}} {{ $name }} required>
                                                                    @foreach ($preg->respuestas as $resp)
                                                                        @foreach ($resp->catalogos as $cat)
                                                                            <option value="{{$cat->id}}">{{$cat->clave}} - {{$cat->nombre}}</option>;
                                                                        @endforeach
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        @if ($preg->respuestas[0]->FORM_CVALOR == 'tram_cat_giros')
                                                            <div id="inputGiro_resp_{{$preg->FORM_NID}}_0"></div>
                                                        @endif
                                                        
                                                        @break
                                                @endswitch
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                    <div class="row form p-4" id="form_0" style="display: none">
                        <table class="table" id="documentosP4">
                            <thead>
                              <tr>

                                <th scope="col">Existente</th>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Tamaño</th>
                                <th scope="col" class="text-center">Estatus</th>
                                <th scope="col"></th>
                                <th style="width: 70px;"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @if(count($tramite['configuracion']['documentos'])> 0)
                                    @foreach($tramite['configuracion']['documentos'] as $key => $doc)
                                        <tr>
                                            
                                        <?php   $otrotest = '';$RowDocConf='';$P_NESTATUS='';
                                            $TXT_STAT='';$DOCsolicitudes='';$TIPO_DOC='0';

                                            //////////////////////////////////////////COLOCA EL NOMBRE CORRECTO
                                            // Verificar existe el campo "TRAD_NID_CONFIGDOCUMENTO" en tram_mdv_documento_tramite
                                            
                                            //if(method_exists($doc,'TRAD_NID_CONFIGDOCUMENTO')){
                                                //SI EXISTE EL CAMPO
                                                $id_CONF = $doc->TRAD_NID_CONFIGDOCUMENTO;
                                                //Comprobar si existe algun dato en TRAD_NID_CONFIGDOCUMENTO
                                                if($id_CONF>0){
                                                    //comprobar si existe el id en el array de tipos de documentos
                                                    if (array_key_exists($id_CONF, $ARR_DOC_CON)) {
                                                        $doc->TRAD_CNOMBRE = $ARR_DOC_CON[$id_CONF];
                                                        $TIPO_DOC = $id_CONF;

                                                    };
                                                }
                                            //}else{
                                                // NO existe el campo "TRAD_NID_CONFIGDOCUMENTO" en tram_mdv_documento_tramite
                                            //};//*/
                                            ///////////////////////////////////////////////////////////////////

                                            $nmbres = $doc->TRAD_CNOMBRE; 
                                            $ARCH_RUTA = '0';
                                            $ARCH_PESO = '0';
                                            $ARCH_EXTENCION = '0';$VIGENCIA_FIN = '';
                                            //VERIFICO SI EXISTE ALGUN ARCHIVO
                                            foreach($tramite['repositorio'] as $rep){
                                                if($rep->USDO_CDOCNOMBRE == $doc->TRAD_CNOMBRE){ 
                                                    $DOCsolicitudes = 'si';
                                                    $ARCH_RUTA = $rep->USDO_CRUTADOC;
                                                    $ARCH_PESO = $rep->USDO_NPESO;
                                                    $ARCH_EXTENCION = $rep->USDO_CEXTENSION;
                                                    $VIGENCIA_FIN = $rep->VIGENCIA_FIN;
                                                };
                                            }

                                            $VIG_TXT='';
                                            if($DOCsolicitudes=='si'){
                                                if (array_key_exists($nmbres, $tramite['DOCS_BASE'])) {                                                    
                                                    $P_NESTATUS = $tramite['DOCS_BASE'][$nmbres][3];
                                                    $VIGENCIA_FIN = $tramite['DOCS_BASE'][$nmbres][5];
                                                    $HOY = date("Y-m-d");
                                                    if($VIGENCIA_FIN != '' &&$VIGENCIA_FIN < $HOY ){$VIG_TXT='VENCIDO';};
                                                }; 
                                            }; 
                                                 
                                            //echo $P_NESTATUS;
                                            if($P_NESTATUS==NULL&&$DOCsolicitudes!='si'){$TXT_STAT='';
                                            }elseif($P_NESTATUS==0){$TXT_STAT='Pendiente revisión';
                                                if($VIG_TXT!=''){$TXT_STAT = $VIG_TXT;};
                                            }elseif($P_NESTATUS==1){$TXT_STAT='Rechazado';
                                            }elseif($P_NESTATUS==2){
                                                $TXT_STAT='';
                                                if($VIG_TXT!=''){$TXT_STAT = $VIG_TXT;};
                                            };
                                            //$TXT_STAT=''.$VIG_TXT.'..v: '.$VIGENCIA_FIN.'..va: '.$tramite['DOCS_BASE'][$nmbres][5].'..id: '.$tramite['DOCS_BASE'][$nmbres][6];
                                            
                                            ?>

                                            <td>
                                            @foreach($tramite['repositorio'] as $rep)
                                                @if($rep->USDO_CDOCNOMBRE == $nmbres)
                                                    <div class="custom-control custom-checkbox">
                                                        <div class="row">
                                                            <div class="md-6">   
                                                                <input class="form-check-input chckdfiles" type="checkbox" 
                                                                    onchange="seleccionarExistente('{{$rep->USDO_CDOCNOMBRE}}','{{$rep->USDO_CEXTENSION}}','{{$rep->USDO_CRUTADOC}}','{{$rep->USDO_NPESO}}','file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}')" 
                                                                    value="" id="chck_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" 
                                                                    title="Elegir archivo existente" checked>                                                     
                                                                    <a href="{{ asset('') }}{{$rep->USDO_CRUTADOC}}" target="_blank"  id="link_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}"  >
                                                                        <i title='Descargar documento' class='fas fa-download'></i>
                                                                    </a>
                                                            </div>
                                                            <div class="md-6 ml-2" >
                                                                <a title="Ver archivo" class="btn btn-primary p-0 m-0"  style="width: 22px; height: 22px; " href="{{ asset('') }}{{$rep->USDO_CRUTADOC}}" target="_blank">
                                                                    <i class="fa fa-eye p-0 m-0" ></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @break;
                                                @endif
                                            @endforeach
                                            </td>


                                            <td>
                                                <div id="icon_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}">
                                                    @switch($doc->TRAD_CEXTENSION)
                                                        @case('jpg')
                                                            <img src="{{ asset('assets/template/img/jpg.png') }}" width="25" height="25">
                                                            @break
                                                        @case('png')
                                                            <img src="{{ asset('assets/template/img/png.png') }}" width="25" height="25">
                                                            @break
                                                        @case('pdf')
                                                            <img src="{{ asset('assets/template/img/pdf.png') }}" width="25" height="25">
                                                            @break
                                                        @default
                                                            <img src="{{ asset('assets/template/img/doc.png') }}" width="25" height="25">
                                                            @break
                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                            
                                            <?php echo $otrotest;?>
                                            {{$doc->TRAD_CNOMBRE}}

                                            @if($doc->TRAD_NOBLIGATORIO == 1 )
                                                <span class="text-danger">*</span>
                                            @endif
                                            <br>
                                            <p style="font-size: 12px;color: red;"><b>5Mb máximo</b></p>
                                            </td>
                                            <!-- Aqui -->
                                                @if(count($descripcion)> 0)
                                                    <?php $siEncontro = false ?>
                                                    @foreach($descripcion as $d)
                                                        @if($d[1] == $doc->TRAD_CNOMBRE)
                                                        <td>
                                                            {{$d[0]}}
                                                            <?php $siEncontro = true ?>
                                                        </td>
                                                        @break
                                                        @endif
                                                    @endforeach
                                                    @if(!$siEncontro)
                                                        <td></td>
                                                    @endif
                                                @else
                                                    <td></td>
                                                @endif
                                            
                                            <td>
                                                <div id="size_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}">
                                                </div>
                                            </td>
                                            <td class="text-center">{{$TXT_STAT}}</td>
                                            <td class="text-center">
                                            @if($P_NESTATUS==1||$VIG_TXT=='VENCIDO')                                            
                                                <img src="{{ asset('assets/template/img/warning.png') }}" width="20" height="20">
                                            @endif
                                            </td>
                                            <td style="width: 70px;">
                                                <input type="hidden" name="docs_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" 
                                                    id="docs_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" value="0_0_0_{{$doc->TRAD_CNOMBRE}}">

                                                <input type="hidden" value="{{$doc->TRAD_NOBLIGATORIO}}" id="valida_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}">
                                                <input class="file-select documentos" name="file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" 
                                                    id="file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" type="file"  accept="application/pdf"
                                                    data-doctype="{{$doc->TRAD_CNOMBRE}}" {{$doc->TRAD_NOBLIGATORIO == 1 ? 'required' : '' }}>
                                            </td>
                                            <td>
                                            @if($doc->TRAD_NMULTIPLE == 1)
                                                <h5 class="font-weight-bold"><span class="circle-multi"  
                                                onclick="TRAM_FN_AGREGAR_ROW('{{$doc->TRAD_CNOMBRE}}')" >+</span></h5>
                                            @endif
                                            </td>

                                            <td>
                                                <h5 class="font-weight-bold">
                                                    <span class="circle-error-multi"  
                                                    onclick="TRAM_FN_LIMPIARROW_DOCUMENTO('{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}','{{$doc->TRAD_CNOMBRE}}', '{{$doc->TRAD_NOBLIGATORIO}}')" >x</span>
                                                </h5>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <button type="submit" class="btn btn-success float-right" onclick="TRAM_AJX_ENVIAR()" id="btnEnviar">Enviar</button>
                <button type="submit" class="btn btn-warning float-right" onclick="TRAM_FN_VALIDAR()" style="margin-right:10px;">Validar</button>
                <button type="submit" class="btn btn-primary float-right" style="margin-right:10px;" onclick="TRAM_AJX_GUARDAR()">Guardar información</button>
            </div>
        </div>
    </div>
    <br>

    <div class="row seccion-tramite" style="display: none !important;">
        <div class="card" style="width: 100%; border-radius:20px;">
            <div class="card-header" style="background-color: #23468c; color: #ffffff; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h6 class="card-title">Notificaciones</h6>
            </div>
            <div class="card-body" style="color: #23468c;">
                <div class="row">
                    <label style="padding-left: 20px;">Por el momento, no existen observaciones.</label>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<div id="loading_save" class="loadingFrame" class="text-center" style="display: none !important;">
    <div class="inner">
        <div class="spinner-grow text-secondary" role="status">
        </div>
        <p style="color: #393939 !important;"><span id="loading-text"></span></p>
    </div>
</div>
<br />
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
        content: 'Seleccionar'; /* testo por defecto */
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
<script>
    var id_accede   = "{{$tramite['idtramiteaccede']}}";
    var es_gestor   = "{{$tramite['es_gestor']}}";
    var id_usuario  = "{{$tramite['idsuario']}}";//Usuario logeado
    var catalogos   = [];
    var catGiros    = [];
    var catBancos   = [];
    var antSel      = [];

    //0 no es gestor
    if(es_gestor == 0){
        $(".seccion-tramite").toggle('show');
        $(".seccion-representar").hide();
    }else {
        $(".seccion-tramite").hide();
        $(".seccion-representar").toggle('show');
    }

    //Seleccionar representacion
    function TRAM_FN_REPRESENTAR(params) {
        //Si = 0 y No = 1
        if(params.value == 0){
            $(".seccion-tramite").hide();
            $(".seccion-tipopersona").toggle('show');
        }else {
            //Se permite iniciar el tramite obteniendo el id del usuario logeado
            $(".seccion-tramite").show();
            $(".seccion-tipopersona").hide();
            $(".cmb-tipopersona-fisica").hide();
            $(".cmb-tipopersona-moral").hide();
            $('#txtIdUsuario').val(id_usuario);
        }
    };

    //Seleccionar tipo de persona a representar
    function TRAM_FN_SELECCIONAR_TIPO_PERSONA(params){
        //Fisica = 0 y Moral = 1
        if(params.value == 0){
            $(".cmb-tipopersona-fisica").toggle('show');
            $(".cmb-tipopersona-moral").hide();
        }else {
            $(".cmb-tipopersona-moral").toggle('show');
            $(".cmb-tipopersona-fisica").hide();
        }
    };

    //Seleccionar persona
    $('.cmbUsuario').change(function(){
        var id = this.value;
        var nombre = $(this).find(':selected').attr('data-nombre');
        var rfc = $(this).find(':selected').attr('data-rfc');
        var curp = $(this).find(':selected').attr('data-curp');
        if(id > 0){
            $(".seccion-tramite").show();
            $('.dato-nombre-razonsocial').html(nombre);
            $('.dato-rfc').html(rfc);
            $('.dato-curp').html(curp);
            $('#txtIdUsuario').val(id);
        }else {
            $(".seccion-tramite").hide();
            $('.dato-nombre-razonsocial').html("");
            $('.dato-rfc').html("");
            $('.dato-curp').html("");
            $('#txtIdUsuario').val(id_usuario);
        }
    });

    function seleccionarExistente(nombre, extension, ruta, peso, id){
        var ischecked = $('#chck_'+id).is(':checked');
        if(ischecked){
            $("#docs_" + id).val(ruta + "_" + extension + "_" + peso+"_"+nombre);
            $('#'+id).hide();
            $('#'+id).removeAttr("required");
            $("#link_"+id).show();
            $('#chck_'+id).attr("title", "Quitar para elegir uno nuevo.")
            setDocData(nombre, extension, peso, id);
        }else{
            $("#docs_" + id).val("0_0_0_"+nombre);
            $('#chck_'+id).attr("title", "Elegir archivo existente.")
            $('#'+id).show();
            /* $('#'+id).attr("required", "required"); */
            $("#link_"+id).hide();
            setDocData(nombre, "", "", id);

            if($("#valida_"+id).val() == 1){
                $('#'+id).attr("required", "required");
            }
        }
    }

    function setDocData(nombre, extension, peso, id){

            $("#size_" + id).html('<span>' + peso + ' Bytes</span>');
            switch(extension){
                case "jpg":
                    $("#icon_" + id).html('<img src="{{ asset('assets/template/img/jpg.png') }}" width="25" height="25">');
                    break;
                case "png":
                    $("#icon_" + id).html('<img src="{{ asset('assets/template/img/png.png') }}" width="25" height="25">');
                    break;
                case "pdf":
                    $("#icon_" + id).html('<img src="{{ asset('assets/template/img/pdf.png') }}" width="25" height="25">');
                    break;
                default:
                    $("#icon_" + id).html('<img src="{{ asset('assets/template/img/doc.png') }}" width="25" height="25">');
                    break;
            }
    }
    
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        consultaInformacionCiudadano();
        //$('#cmbModulo').prop('disabled', false);
        TRAM_AJX_CONSULTARMODULO(0, id_accede);

        $(".chckdfiles").change();
        $("#btnEnviar").hide();

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
        });

        $("#frmForm").validate({
            focusInvalid: false,
            invalidHandler: function() {
                $(this).find(":input.error:first").focus();
            }
        });

        //Validar el tamaño del campo y mostrar el mensaje MJN-036.
        $(".txt_abierta").each(function() {
            $(this).rules('add', {
                minlength: 1,
                maxlength: 1000,
                messages: {
                    minlength: "El tamaño del campo no puede ser menor de 1 carácter ni mayor de 1000 caracteres.",
                    maxlength: "El tamaño del campo no puede ser menor de 1 carácter ni mayor de 1000 caracteres.",
                }
            });
        });

        $("#cmbMunicipio").change(function() {
            var id_municipio = $(this).val();
            /*if (id_municipio != "") {
                $('#cmbModulo').prop('disabled', false);
                TRAM_AJX_CONSULTARMODULO(id_municipio, id_accede);
            } else {
                $('#cmbModulo').prop('disabled', 'disabled');
            }*/
        });

        //obtener detalle
        $("#cmbModulo").change(function() {
            var id_modulo = $(this).val();
            var lat = $(this).find(':selected').data('lat');
            var lon = $(this).find(':selected').data('long');
            var direc = $(this).find(':selected').data('direc');

            localStorage.setItem("IdModuloSelected", id_modulo);
            $("#txtModulo").val($(this).val());

            if (id_modulo != "") {
                TRAM_AJX_CONSULTARMODULO_DETALLE(id_modulo, lat, lon, direc);
            }
        });

        function consultaInformacionCiudadano() {

            data={
                NIDEUSUARIO : $("#txtIdUsuario").val()
            }
            $.ajax({
                url: "/tramite_servicio/api/obtenerinfociudadano" ,
                type: "POST",
                data: data,
                success: function(data) {
                    let nombre = "";
                    let apePat = "";
                    let apeMat = "" ;
                    for(const clave in data[0]){
                        if($(`[vinculacion=${clave}]`) && clave != "USUA_CNOMBRES"){
                            $(`[vinculacion=${clave}]`).val(data[0][clave]);
                        }
                        if(clave == "USUA_CNOMBRES"){
                            nombre = data[0][clave];
                        }
                        if(clave == "USUA_CPRIMER_APELLIDO" ){
                            apePat = data[0][clave];
                        }
                        if(clave == "USUA_CSEGUNDO_APELLIDO"){
                            apeMat = data[0][clave];
                        }
                    }
                    if($(`[vinculacion=USUA_CNOMBRES]`)){
                        $(`[vinculacion=USUA_CNOMBRES]`).val(apePat + " " + apeMat + " " + nombre);
                    }
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

        function TRAM_AJX_CONSULTARMODULO_DETALLE(id_modulo, lat, lon, direc){
            // $.ajax({
            //     url: "/tramite_servicio/obtener_modulo_detalle/" + id_modulo,
            //     type: "GET",
            //     success: function(data) {
                    $("#UbicacioModulo").html(direc);
                    var lat2 = lat == null || lat == "" ? 20.5887932 : lat;
                    var lon2 = lon == null || lon == "" ? -100.3898881 : lon;
                    $("#txtLatitud").val(lat2);
                    $("#txtLongitud").val(lon2);
                    TRAM_FN_MAPA(lat2, lon2);
            //     },
            //     error: function(data) {
            //         Swal.fire({
            //             icon: data.status,
            //             title: '',
            //             text: data.message,
            //             footer: ''
            //         });
            //     }
            // });
        };

        //Cargar mapa y ubicacion de oficina
        function TRAM_FN_MAPA(latitud, longitud){
            setTimeout(function() {
                var lat = latitud == null || latitud == 0 ? 20.5887932 : Number(latitud);
                var long = longitud == null || longitud == 0 ? -100.3898881 : Number(longitud);
                map = new google.maps.Map(document.getElementById('mapa'), {
                    center: {
                        lat: lat,
                        lng: long
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
                    position: new google.maps.LatLng(lat, long),
                    map: map,
                    title: 'Ubicación'
                });
            }, 1000);
        }
        TRAM_FN_MAPA(null, null);

        function TRAM_FN_DESACTIVARMODULO() {
            //$('#cmbModulo').prop('disabled', 'disabled');
        }

        function TRAM_FN_CALCULARPORCENTAJE(percentage) {
            //return percentage / 100 * 360
            return 0;
        }

        function TRAM_AJX_CONSULTARMODULO(id_municipio, id_accede) {
            var cmbModulo = $("#cmbModulo");

            $.ajax({
                url: "/tramite_servicio/obtener_modulo/" + id_municipio + "/" + id_accede,
                type: "GET",
                success: function(data) {

                    // Limpiamos el select
                    cmbModulo.find('option').remove();

                    //Opcion por defecto
                    cmbModulo.append('<option disabled selected>Seleccione</option>');

                    $(data).each(function(i, v) { // indice, valor
                        cmbModulo.append('<option value="' + v.id + '" data-lat="'+v.latitud+'" data-long="'+v.longitud+'" data-direc="'+v.direccion+'">' + v.nombre + '</option>');
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

        function TRAM_FN_OCULTAR_FORM(){
            $('.form').each(function() {
                $("#" + this.id).hide();
            });
        };

        //Tabs secciones
        $(".step").click(function() {
            var seccion = $(this).data("seccion");
            $('.step').each(function() {
                var id = this.id;
                if(Number(id.split("_")[1]) == seccion){
                    $("#" + this.id).addClass("current");
                    $("#form_" + id.split("_")[1]).toggle('show');
                }else {
                    $("#" + this.id).removeClass("current");
                    $("#form_" + id.split("_")[1]).hide();
                }
            });
        });

        TRAM_AJX_CONSULTARMUNICIPIO();
        TRAM_FN_DESACTIVARMODULO();
        TRAM_FN_OCULTAR_FORM();

        //Get html
        $(".txtEnriquecido").each(function() {
            var id = this.id;
            CKEDITOR.instances[id].on('change', function() {
                $("#" + id).val(CKEDITOR.instances[id].getData());

            });
        });

        function validateEnriquesido(){
            $(".txtEnriquecido").each(function() {
                var id = this.id;
                CKEDITOR.instances[id].on('change', function() {
                    $("#" + id).val(CKEDITOR.instances[id].getData());

                    var editor_val = CKEDITOR.instances.editor.document.getBody().getChild(0).getText().trim();
                });
            });
        };


        //Subir documento
        $(".documentos").on('change', function() {
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

            $.ajax({
                url: '/tramite_servicio/subir_documento',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response.extension=="pdf"){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Listo!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#docs_" + id).val(response.path + "_" + response.extension + "_" + response.size+"_"+response.typename);
                        $("#size_" + id).html('<span>' + TRAM_FN_CONVERTIR_SIZE(response.size) + '</span>');
                        
                        switch(response.extension){
                            case "jpg":
                                $("#icon_" + id).html('<img src="{{ asset('assets/template/img/jpg.png') }}" width="25" height="25">');
                                break;
                            case "png":
                                $("#icon_" + id).html('<img src="{{ asset('assets/template/img/png.png') }}" width="25" height="25">');
                                break;
                            case "pdf":
                                $("#icon_" + id).html('<img src="{{ asset('assets/template/img/pdf.png') }}" width="25" height="25">');
                                break;
                            default:
                                $("#icon_" + id).html('<img src="{{ asset('assets/template/img/doc.png') }}" width="25" height="25">');
                                break;
                        }
                    }else{
                        document.getElementById(id).value = "";
                        Swal.fire({ 
                            title: 'Error!',
                            text: 'Solo se permite PDF',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    };
                }
            });
        return false;
        });

        //Agregar formato de peso
        $(".documentos").each(function() {
            var id = this.id;
            var input = $("#docs_" + id).val();
            var arr = input.split("_");
            $("#size_" + id).html('<span>' + TRAM_FN_CONVERTIR_SIZE(arr[2]) + '</span>');
        });

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

        $(".selectCatalogos").selectpicker({
            noneSelectedText: 'Seleccionar',
        });

        getGiros();
    });

    function TRAM_FN_VALIDAR_DISABLED(id, estatus, val) {
        var name = $("#resp_" + id + "_" + val).data("valuechk");
        $(".multiple-disabled_"+id).each(function() {
            var _id = this.id;
            var _data_name =  $(this).data("valuechk");
            var _disabled =  $(this).data("disabledchk");

            if(estatus == 1){
                if(_disabled == 1){
                    if($(this).prop("checked") == true){
                        $(this).prop("disabled", false);
                    }
                    else if($(this).prop("checked") == false){
                        $(this).prop("disabled", false);
                    }
                }else {
                    if(_disabled == 0){
                        if($("#resp_" + id + "_" + val).prop("checked") == true){
                            $(this).prop("disabled", true);
                        }else if($("#resp_" + id + "_" + val).prop("checked") == false){
                            $(this).prop("disabled", false);
                        }
                    }
                }
            }

        });
    }

    function TRAM_FN_SUBIR_DOCUMENTO_MULTIPLE(val){
            var id = "file_"+val;
            var formData = new FormData();
            var files = $("#" + id)[0].files[0];
            formData.append('file',files);

            var name = $(this).data("docname");
            var resultado = id.split("_");
            var bla = $('#txt_'+resultado[1]).val();



            $.ajax({
                url: '/tramite_servicio/subir_documento',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#docs_" + id).val(response.path + "_" + response.extension + "_" + response.size + "_" + bla);

                    $("#size_" + id).html('<span>' + TRAM_FN_CONVERTIR_SIZE(response.size) + '</span>');
                    switch(response.extension){
                        case "jpg":
                            $("#icon_" + id).html('<img src="{{ asset('assets/template/img/jpg.png') }}" width="25" height="25">');
                            break;
                        case "png":
                            $("#icon_" + id).html('<img src="{{ asset('assets/template/img/png.png') }}" width="25" height="25">');
                            break;
                        case "pdf":
                            $("#icon_" + id).html('<img src="{{ asset('assets/template/img/pdf.png') }}" width="25" height="25">');
                            break;
                        default:
                            $("#icon_" + id).html('<img src="{{ asset('assets/template/img/doc.png') }}" width="25" height="25">');
                            break;
                    }
                }
            });
    }

    function TRAM_FN_CAMBIAR_NOMBRE(name,id){
        var bla = $('#txt_'+id).val();

        $("#file_" + id).attr("data-docname",bla);
        var old = $("#docs_file_" + id).val();
        var resultado = old.split("_");
        var nombreNuevo = resultado[0]+"_"+resultado[1]+"_"+resultado[2] + "_"+bla;
        $("#docs_file_" + id).val(nombreNuevo);

    }

    function TRAM_FN_GENERATE(n) {
        var add = 1, max = 12 - add;   // 12 is the min safe number Math.random() can generate without it starting to pad the end with zeros.

        if ( n > max ) {
                return generate(max) + generate(n - max);
        }

        max        = Math.pow(10, n+add);
        var min    = max/10; // Math.pow(10, n) basically
        var number = Math.floor( Math.random() * (max - min + 1) ) + min;

        return ("" + number).substring(add);
    }

    function TRAM_FN_AGREGAR_ROW(name){
        var iddata = TRAM_FN_GENERATE(8);
        $("#documentosP4").append('<tr>'+
        '<td> '+ "<div  class='form-check'> <input class='form-check-input' type='checkbox' value='' id=defaultCheck2' disabled> </div>"+'</td>' +
        '<td>'+
            " <div id='icon_file_"+iddata+"'>"+
            " <img src='{{ asset('assets/template/img/doc.png') }}'' width='20' height='20'>"+
            "</div>"
        +'</td>' +
        '<td>'+" <input type='text' class='form-control'  value='"+name+"' id='txt_"+iddata+"'    onchange='TRAM_FN_CAMBIAR_NOMBRE(\""+iddata+"\",\""+iddata+"\")'>"+'</td>' +
        '<td> '+
        " <div id='size_file_"+iddata+"'> 0 Bytes</div>"
        +'</td>' +
        '<td> Pendiente revisión</td>' +
        '<td>'+
            " <img src='{{ asset('assets/template/img/warning.png') }}'' width='20' height='20'>"
        +'</td>' +
        '<td>'+
            " <input type='hidden' name='docs_file_"+iddata+"' id='docs_file_"+iddata+"' value='0_0_0_"+name+"'>"+
            "<input class='file-select documentos nuevo' name='file_"+iddata+"' id='file_"+iddata+"' data-docname='"+name+"' type='file' onchange='TRAM_FN_SUBIR_DOCUMENTO_MULTIPLE(\""+iddata+"\")'>"


        +'</td><td></td>' +
        '<td>'+ "<h5 class='font-weight-bold'><span class='circle-error-multi'  onclick='TRAM_FN_LIMPIARROW_DOCUMENTO(\""+iddata+"\",\""+name+"\")' >X</span></h5>"+'</td>' +
        +'</tr>');
    }

    function TRAM_FN_LIMPIARROW_DOCUMENTO(id, nombre, requerido = false){
        $("#file_"+id).show();
        $("#file_"+id).val("");
        $("#docs_file_" + id).val("0_0_0_"+nombre);
        $("#size_file_" + id).html("0 Bytes");
        $("#icon_file_" + id).html("<img src='{{ asset('assets/template/img/doc.png') }}'' width='20' height='20'>");
        $("#chck_file_" + id).prop("checked", false);
        if(requerido){
            $('#file_'+id).attr("required", "required");
        }
        $("#btnEnviar").hide();
    }

    function TRAM_FN_VALIDAR(){
        $(".txtEnriquecido").each(function() {
            var id = this.id;
            var editor_val = CKEDITOR.instances[id].getData();

            if(editor_val == "" || editor_val == null){
                $("#error_" + id).html('<label><span style="color: red;">¡Error!</span> Es requerido</label>');
            }else {
                $("#error_" + id).html("");
            }
        });
        if (!$("#frmForm").valid()){
            const full  = document.getElementsByClassName('full');
            const arr   = [...full].map(input => input.value);

            var divVal = "";
            arr.forEach(function(idDiv) {
                divVal = $('#form_'+idDiv+' :input').valid()
                $("#span_"+idDiv).empty();
                if(!divVal){
                    $("#span_"+idDiv).append('<span><img src="{{ asset('assets/template/img/error.png') }}" width="20" height="20"></span>');
                }else{
                    $("#span_"+idDiv).append('<span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>');
                }

            })

            $("#btnEnviar").hide();
            Swal.fire({
                title: '¡Aviso!',
                text: 'No has contestado completamente el formulario, sin embargo, puedes continuarlo más tarde.',
                icon: 'info',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
            return;
        }else {
            const full  = document.getElementsByClassName('full');
            const arr   = [...full].map(input => input.value);

            var divVal = "";
            arr.forEach(function(idDiv) {
                divVal = $('#form_'+idDiv+' :input').valid()
                $("#span_"+idDiv).empty();
                if(!divVal){
                    $("#span_"+idDiv).append('<span><img src="{{ asset('assets/template/img/error.png') }}" width="20" height="20"></span>');
                }else{
                    $("#span_"+idDiv).append('<span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>');
                }

            })
            Swal.fire({
                title: '',
                text: 'El formulario ha sido completado, y está listo para enviar a revisión.',
                icon: 'info',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
            $("#btnEnviar").show();
        }
    }

    function TRAM_AJX_GUARDAR(){
        if($("#cmbModulo").val() == null){
            Swal.fire({
                        title: '¡Aviso!',
                        text: "Favor de seleccionar un módulo.",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
        }
        else {
            $("#loading-text").html("Guardando...");
            $('#loading_save').show();
            $('#frmForm').append("<input type='hidden' name='txtMunicipio' value='"+ $('#cmbMunicipio').val() +"'/>");
            const full  = document.getElementsByClassName('full');
                const arr   = [...full].map(input => input.value);

                var divVal = "";
                arr.forEach(function(idDiv) {
                    divVal = $('#form_'+idDiv+' :input').valid()
                    $("#span_"+idDiv).empty();
                    if(!divVal){
                        $("#span_"+idDiv).append('<span><img src="{{ asset('assets/template/img/error.png') }}" width="20" height="20"></span>');
                    }else{
                        $("#span_"+idDiv).append('<span><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></span>');
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
                success: function (data) {
                    if(data.status == "success"){
                        Swal.fire({
                            title: '¡Éxito!',
                            text: data.message,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                document.location.href = '/tramite_servicio/seguimiento_tramite/' + data.data;
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
                    $('#loading_save').hide();
                },
                error: function (data) {
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
    }

    function TRAM_AJX_ENVIAR(){
        if($("#cmbModulo").val() == null){
            Swal.fire({
                        title: '¡Aviso!',
                        text: "Favor de seleccionar un módulo.",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
        }
        else {
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
                        success: function (data) {
                            if(data.status == "success"){
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
                                        document.location.href = '/tramite_servicio/seguimiento_tramite/' + data.data;
                                        //location.reload();
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
                            $('#loading_save').hide();
                        },
                        error: function (data) {
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
        }
    };

    //Convertir byte a (Kb, Mb, Gb, Tb)
    function TRAM_FN_CONVERTIR_SIZE (size) {
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
    };

    /**
    * Funcion para obtener los municipios
    */
    function TRAM_AJX_CONSULTARMUNICIPIO() {
        var cmbMunicipio = $("#cmbMunicipio");
        cmbMunicipio.find('option').remove();

        $.ajax({
            url: "/tramite_servicio/obtener_municipio/" + id_accede,
            type: "GET",
            success: function(data) {
                cmbMunicipio.append('<option disabled selected>Seleccione</option>');

                $(data).each(function(i, v) {
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

        $.ajax({
            url: "/bancos/find",
            type: "GET",
            data: { paginate:false, activo: true},
            success: function(data) {
                catBancos = data.data;
            },
            error: function(data) {
                mensajeError('error', data)
            }
        });
    }

    function mensajeError(icon = 'error', message = ''){
        console.log(message);
        Swal.fire({
            icon: icon,
            title: '',
            text: message,
            footer: ''
        });
    }

    $('.selectCatalogos').on('change', function(e) {
        let select  = e.target.id;
        let items   = $("#"+select).val();
        let aplica  = true;
        let html = '';
        
        if(items.length > 4){
            $('.selectpicker').selectpicker('deselectAll');
            $('.selectpicker').selectpicker('val', antSel);
            $('.selectpicker').selectpicker('refresh');

            mensajeError("info", "Solo es posible seleccionar hasta 4 especialidades.");
            return;
        }
        else{
            antSel = items;
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

            html += `<div>
                <label id='label_${element}' for="">Giro-${label}, ${nombreGiro}</label>
                <input type="date" id="fechaGiro_${element}" name="fechaGiro_${element}" class="form-control txt_abierta" placeholder="Fecha" required/> <br />
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

</script>
@endsection
