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
                        <div class="progress_circle mx-auto" data-value='0'>
                            <span class="progress_circle-left">
                                <span class="progress_circle-bar border-primary"></span>
                            </span>
                            <span class="progress_circle-right">
                                <span class="progress_circle-bar border-primary"></span>
                            </span>
                            <div class="progress_circle-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                <div class="h2 font-weight-bold" style="color:#03A9F4 !important;">0<sup class="small">%</sup></div>
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
                    @if(count($tramite['configuracion']['formularios'])> 0)
                        @foreach($tramite['configuracion']['formularios'] as $form)
                            @if($form->secciones > 0)
                                <?php $cont = 0; ?>
                                @foreach($form->secciones as $sec)
                                    @if($cont == 0)
                                        <div class="step" id="seccion_{{$sec->FORM_NID}}" data-seccion="{{$sec->FORM_NID}}" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;"> <span>{{$sec->FORM_CNOMBRE}}</span> </div>
                                    @else
                                        <div class="step" id="seccion_{{$sec->FORM_NID}}" data-seccion="{{$sec->FORM_NID}}"> <span>{{$sec->FORM_CNOMBRE}}</span> </div>
                                    @endif
                                    <?php $cont++; ?>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                    <div class="step" id="seccion_0" data-seccion="0" style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;"> <span>Documentos</span> </div>
                </div>
            </div>
            <div class="card-body" style="color: #23468c;">
                <form enctype="multipart/form-data" id="frmForm">
                    <input type="hidden" name="txtIdTramite" value="{{$tramite['id']}}">
                    <input type="hidden" name="txtEstatus" value="{{$tramite['estatus']}}">
                    @if(count($tramite['configuracion']['secciones'])> 0)
                        @foreach($tramite['configuracion']['secciones'] as $confsec)
                            <input type="hidden" name="secc_{{$confsec->CONF_NIDCONFIGURACION}}" value="{{$confsec->CONF_NSECCION}}">
                        @endforeach
                    @endif
                    @if(count($tramite['configuracion']['formularios'])> 0)
                        @foreach($tramite['configuracion']['formularios'] as $form)
                            @if($form->secciones > 0)
                                @foreach($form->secciones as $sec)
                                    <div class="row form" id="form_{{$sec->FORM_NID}}" style="display: none">
                                        @foreach($sec->preguntas as $preg)
                                            @switch($preg->FORM_CTIPORESPUESTA)
                                                @case('abierta')
                                                    <div class="col-md-4">
                                                        <div class="form-group {{$preg->estatus == 1 ? 'error-input' : ''}}">
                                                            <label for="resp_{{$preg->FORM_NID}}">{{$preg->FORM_CPREGUNTA}}</label>
                                                            @if($preg->respuestas > 0)
                                                                @foreach($preg->respuestas as $resp)
                                                                    <input type="text" class="form-control" name="resp_{{$preg->FORM_NID}}_0" id="resp_{{$preg->FORM_NID}}_0" placeholder="{{$preg->FORM_CPREGUNTA}}" value="{{$resp->FORM_CVALOR_RESPUESTA}}" {{$preg->estatus == 1 ? "" : $tramite['disabled'] }}>
                                                                @endforeach
                                                            @endif
                                                            @if($preg->estatus == 1)
                                                                <span class="text-danger">{{$preg->observaciones}}</span>
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
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="resp_{{$preg->FORM_NID}}_0" id="resp_{{$preg->FORM_NID}}_0" value="{{$resp->FORM_NID}}" {{$resp->FORM_CVALOR_RESPUESTA}} {{$tramite['disabled']}}>
                                                                        <label class="form-check-label">
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
                                                                @foreach($preg->respuestas as $resp)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="resp_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="resp_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" value="{{$resp->FORM_NID}}" {{$resp->FORM_BBLOQUEAR == true ? 'disabled' : ''}} {{$resp->FORM_CVALOR_RESPUESTA}} {{$tramite['disabled']}}>
                                                                        <label class="form-check-label">
                                                                            {{$resp->FORM_CVALOR}}
                                                                        </label>
                                                                    </div>
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
                                                                        <textarea class="txtEnriquecido" name="resp_{{$preg->FORM_NID}}_0"  id="resp_{{$preg->FORM_NID}}_0" rows="5" style="display: block !important;" {{$tramite['disabled']}}>{{$resp->FORM_CVALOR_RESPUESTA}}</textarea>
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
                                                                                                    <input type="text" class="form-control" name="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" placeholder="{{$resp->FORM_CVALOR}}" value="{{$resp_esp->FORM_CVALOR_RESPUESTA}}" {{$tramite['disabled']}}>
                                                                                                @endforeach
                                                                                            @endif 
                                                                                        </div>
                                                                                        @break
                                                                                    @case('numerico')
                                                                                        <div class="form-group">
                                                                                            @if($resp->respuestas_especial > 0)
                                                                                                @foreach($resp->respuestas_especial as $resp_esp)
                                                                                                    <input type="number" class="form-control" name="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" placeholder="{{$resp->FORM_CVALOR}}" value="{{$resp_esp->FORM_CVALOR_RESPUESTA}}" {{$tramite['disabled']}}>
                                                                                                @endforeach
                                                                                            @endif 
                                                                                        </div>
                                                                                        @break
                                                                                    @case('opciones')
                                                                                        <div class="form-group">
                                                                                            @if($resp->respuestas_especial > 0)
                                                                                                <select class="form-control" name="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" id="especial_{{$preg->FORM_NID}}_{{$resp->FORM_NID}}" {{$tramite['disabled']}}>
                                                                                                    @foreach($resp->respuestas_especial as $resp_esp)
                                                                                                        <option value="{{$resp_esp->FORM_NID}}" {{$resp_esp->FORM_CVALOR_RESPUESTA}}>{{$resp_esp->FORM_CVALOR}}</option>
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
                                            @endswitch
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                    <div class="row form p-4" id="form_0">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Seleccionar</th>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tamaño</th>
                                <th scope="col" class="text-center">Estatus</th>
                                <th scope="col"></th>
                                <th style="width: 100px;"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @if(count($tramite['configuracion']['documentos'])> 0)
                                    @foreach($tramite['configuracion']['documentos'] as $doc)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" disabled>
                                                </div>
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
                                            <td>{{$doc->TRAD_CNOMBRE}}</td>
                                            <td>
                                                <div id="size_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}">
                                                </div>
                                            </td>
                                            <td class="text-center">Pendiente revisión</td>
                                            <td class="text-center"><img src="{{ asset('assets/template/img/warning.png') }}" width="20" height="20"></td>
                                            <td style="width: 100px;"><input type="hidden" name="docs_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" id="docs_file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" value="{{$doc->TRAD_CRUTADOC}}_{{$doc->TRAD_CEXTENSION}}_{{$doc->TRAD_NPESO}}"><input class="file-select documentos" name="file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" id="file_{{$doc->TRAD_NIDTRAMITEDOCUMENTO}}" type="file"></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{-- <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Seleccionar</th>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tamaño</th>
                                <th scope="col" class="text-center">Estatus</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" disabled>
                                        </div>
                                    </td>
                                    <td><img src="{{ asset('assets/template/img/pdf.png') }}" width="25" height="25"></td>
                                    <td>Acta de nacimiento</td>
                                    <td>1.3 MB</td>
                                    <td class="text-center">Pendiente revisión</td>
                                    <td class="text-center"><img src="{{ asset('assets/template/img/warning.png') }}" width="20" height="20"></td>
                                    <td><button type="button" class="btn btn-success btn-sm">Cargar documento</button></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" checked disabled>
                                        </div>
                                    </td>
                                    <td><img src="{{ asset('assets/template/img/pdf.png') }}" width="25" height="25"></td>
                                    <td>Acta de nacimiento</td>
                                    <td>1.3 MB</td>
                                    <td class="text-center">Aceptado</td>
                                    <td class="text-center"><img src="{{ asset('assets/template/img/check.png') }}" width="20" height="20"></td>
                                    <td><button type="button" class="btn btn-secondary btn-sm" disabled>Cargar documento</button></td>
                                </tr>
                            </tbody>
                        </table> --}}
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                @if($tramite['estatus'] == 1)
                    <button type="submit" class="btn btn-success float-right" onclick="TRAM_AJX_ENVIAR()">Enviar</button>
                    <button type="submit" class="btn btn-primary float-right" style="margin-right:10px;" onclick="TRAM_AJX_GUARDAR()">Guardar información</button>
                @endif
                {{-- @if($tramite['estatus'] == 2)
                    <button type="submit" class="btn btn-primary float-right" style="margin-right:10px;">Validar</button>
                @endif --}}
            </div>
        </div>
    </div>
    <br>
    <div class="row">
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
    .error-input {
        border: 1px solid red;
        border-radius: 5px;
        padding: 5px;
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
                    lat: 28.6389324,
                    lng: -106.075353
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
                position: new google.maps.LatLng(28.6389324, -106.075353),
                map: map,
                title: 'Ubicación'
            });
        }, 1000);


        function TRAM_FN_DESACTIVARMODULO() {
            $('#cmbModulo').prop('disabled', 'disabled');
        }

        function TRAM_FN_CALCULARPORCENTAJE(percentage) {
            //return percentage / 100 * 360
            return 0;
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

        //Subir documento
        $(".documentos").on('change', function() {
            var id = this.id;
            var formData = new FormData();
            var files = $("#" + id)[0].files[0];
            formData.append('file',files);
            $.ajax({
                url: '/tramite_servicio/subir_documento',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#docs_" + id).val(response.path + "_" + response.extension + "_" + response.size);
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
        return false;
        });

        //Agregar formato de peso
        $(".documentos").each(function() {
            var id = this.id;
            var input = $("#docs_" + id).val();
            var arr = input.split("_");
            $("#size_" + id).html('<span>' + TRAM_FN_CONVERTIR_SIZE(arr[2]) + '</span>');
        });
    });

    function TRAM_AJX_GUARDAR(){
        $("#loading-text").html("Guardando...");
        $('#loading_save').show();
        $.ajax({
            data: $('#frmForm').serialize(),
            url: "/tramite_servicio/guardar",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                Swal.fire({
                    icon: data.status,
                    title: '',
                    text: data.message,
                    footer: ''
                });
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
    };

    function TRAM_AJX_ENVIAR(){
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
                        confirmButtonText: 'Aceptar'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
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
    
</script>
@endsection
