@extends('layout.Layout')

@section('body')

<script>

</script>

    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-md-8">
                <h2>Reportes</h2>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body text-body">
                <h3>Consulta de reportes</h3>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-date-input" class="form-control-label">Fecha inicial</label>
                                <input class="form-control" type="date" value="" id="datestart" onchange="validate(0)">
                                <em id="error_init_date" class="text-danger">Campo Obligatorio.</em>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-date-input" class="form-control-label">Fecha final</label>
                                <input class="form-control" type="date" value="" id="dateend" onchange="validate(0)">
                                <em id="error_finish_date" class="text-danger">Campo Obligatorio.</em>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="selectrubro" class="form-control-label">Rubro</label>
                                <select class="form-control" id="selectrubro" onchange="validate(0)">
                                    <option value="0" selected>Seleccione...</option>
                                    <option value="1">Tipos de trámites</option>
                                    <option value="2">Información sobre las características de los usuarios (Funcionarios)</option> 
                                    <option value="3">Información sobre las características de los usuarios (Ciudadanos)</option>
                                    <option value="4">Dependencias con trámites en ACCEDE</option>
                                    <option value="5">Seguimiento de trámites por módulos y estatus</option>
                                    <option value="6">Campos desplegables contenidos en cada trámite</option>
                                    <option value="7">Resultado de encuestas de satisfacción</option>
                                    <option value="8">Todos los rubros</option>
                                </select>
                                <em id="error_select" class="text-danger">Campo Obligatorio.</em>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <div class="text-right">
                        <div class="btn-group">
                            <button type="button" id="descarga" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                Descargar
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="genXLS();">XLS</a>
                                <a class="dropdown-item" href="#" onclick="genCSV()">CSV</a>
                                <a class="dropdown-item" href="#" onclick="genXML()">XML</a>
                            </div>
                        </div>
                        <p><label class="mr-3" for="">XLS, CSV, XML</label><p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Tipo_tramite.xlsx" id="descarga1"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Tipo_tramite.csv" id="descarga1_1"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>


    <a style="cursor:pointer; color:blue;display:none;" href="reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.xlsx" id="descarga2"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.csv" id="descarga2_1"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>

    <a style="cursor:pointer; color:blue;display:none;" href="reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.xlsx" id="descarga3"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.csv" id="descarga3_1"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>

    <a style="cursor:pointer; color:blue; display:none;" href="reps/Dependencias_con_tramites_en_SIGETYS.xlsx" id="descarga4"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Dependencias_con_tramites_en_SIGETYS.csv" id="descarga4_1"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>


    <a style="cursor:pointer; color:blue; display:none;" href="reps/Seguimiento_de_tramites_por_modulos_y_estatus.xlsx" id="descarga5"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Seguimiento_de_tramites_por_modulos_y_estatus.csv" id="descarga5_1"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>

    <a style="cursor:pointer; color:blue; display:none;" href="reps/Campos_desplegables_contenidos_en_cada_tramite.xlsx" id="descarga6"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Campos_desplegables_contenidos_en_cada_tramite.csv" id="descarga6_1"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Resultados_encuestas_de_satisfaccion.xlsx" id="descarga7"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Resultados_encuestas_de_satisfaccion.csv" id="descarga7_1"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>
    
    <a style="cursor:pointer; color:blue; display:none;" href="reps/Todos.xlsx" id="descarga8"><i class="m-r-10 mdi mdi-briefcase-download">Descargar</i></a>


    

    <script>
        function validate(type){
            var error = false;
            var init_date = $('#datestart').val();
            var finish_date = $('#dateend').val();
            var option = $('#selectrubro').val();

            console.log(init_date+' - '+finish_date+' - '+option);
            $("#error_select").empty();
            if( !validate_date(init_date, finish_date) && option > 0  ){
                $('#descarga').attr('disabled', false);
            }else{
                if (option == 0){ $("#error_select").append('Campo Obligatorio.'); }
                $('#descarga').attr('disabled', true);
                error = true;
            }

            if(type == 1){
                return error;
            }
        }
        function validate_date(init_date, finish_date){
            var error = false;
            $("#error_finish_date").empty();
            $("#error_init_date").empty();
            if(init_date && finish_date){//ambos valores existen
                var init = new Date(init_date);
                var finish = new Date(finish_date);

                if(init > finish){
                    error = true;
                    $("#error_init_date").append('Verificar Campo.');
                    $("#error_finish_date").append('Verificar Campo.');
                    /*Swal.fire({
                        icon: "warning",
                        title: 'Fecha Inicial Incorrecta!',
                        text: "La fecha inicial no puede ser mayor a la fecha final.",
                    });*/
                }
            }else{
                error = true;
                if(!init_date){ $("#error_init_date").append('Campo Obligatorio.'); }
                if(!finish_date){ $("#error_finish_date").append('Campo Obligatorio.'); }
            }
            
            return error;
        }

        function validarcamposalerta(){
            fechainic= document.getElementById("datestart").value;
            fechaended = document.getElementById("dateend").value;
            if(fechainic != ''){
                if(fechaended != ''){
                    document.getElementById("descarga").disabled=false;
                    return 'ok';
                }else{
                    
                    document.getElementById("descarga").disabled=true;
                    return 'MJV-003	¡Error! El campo <Fecha final> es requerido';
                }
            }else{
                if(fechaended == ''){
                    
                    document.getElementById("descarga").disabled=true;
                    return 'MJV-003 ¡Error! El campo <Fecha Inicial> es requerido \nMJV-003	¡Error! El campo <Fecha final> es requerido';
                }else{
                    
                    document.getElementById("descarga").disabled=true;
                    return 'MJV-003 ¡Error! El campo <Fecha inicial> es requerido';
                }
            }
        }

        function genXLS(){
            var alerta = validarcamposalerta();
            if(alerta == 'ok'){

                formato = 'XLS';
                treporte = document.getElementById("selectrubro").value;
                datestart = document.getElementById("datestart").value;;
                dateend = document.getElementById("dateend").value;

                var array = {
                    'treporte' : treporte,
                    'datestart' : datestart,
                    'dateend' : dateend,
                    'formato' : formato
                    }
                
                $.ajax({
                    type: "GET",
                    url:  "/generar",
                    data: array,
                    success: function(data)
                    {
                        switch(data){
                            //1. Tipos de trámites  
                            case 'reps/Tipo_tramite.xlsx':
                                document.getElementById("descarga1").click();
                                break;
                            
                            //2. Información sobre las características de los usuarios (Funcionarios)   
                            case 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.xlsx':
                                document.getElementById("descarga2").click();
                                break;
                            
                            //3. Información sobre las características de los usuarios (Ciudadanos)  
                            case 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.xlsx':
                                document.getElementById("descarga3").click();
                                break;
                            
                            //4. Dependencias con trámites en ACCEDE
                            case 'reps/Dependencias_con_tramites_en_SIGETYS.xlsx':
                                document.getElementById("descarga4").click();
                                break;

                            //5. Seguimiento de trámites por módulos y estatus
                            case 'reps/Seguimiento_de_tramites_por_modulos_y_estatus.xlsx':
                                document.getElementById("descarga5").click();
                                break;
                            
                            //6. Campos desplegables contenidos en cada trámite
                            case 'reps/Campos_desplegables_contenidos_en_cada_tramite.xlsx':
                                document.getElementById("descarga6").click();
                                break;

                            //7. Resultado de encuestas de satisfacción
                            case 'reps/Resultados_encuestas_de_satisfaccion.xlsx':
                                document.getElementById("descarga7").click();
                                break;

                            //8. Todos los rubros
                            case 'reps/Reportes.zip':
                                window.location = data;
                                break;
                        }
                    }
                });
                
            }else{
                alert(alerta);
            }
        }

        function genCSV(){
            var alerta = validarcamposalerta();
            if(alerta == 'ok'){

                formato = 'CSV';
                treporte = document.getElementById("selectrubro").value;
                datestart = document.getElementById("datestart").value;;
                dateend = document.getElementById("dateend").value;

                var array = {
                    'treporte' : treporte,
                    'datestart' : datestart,
                    'dateend' : dateend,
                    'formato' : formato
                    }
                
                $.ajax({
                    type: "GET",
                    url:  "/generar",
                    data: array,
                    success: function(data)
                    {
                        switch(data){
                            //1. Tipos de trámites  
                            case 'reps/Tipo_tramite.csv':
                                document.getElementById("descarga1_1").click();
                                break;
                            
                            //2. Información sobre las características de los usuarios (Funcionarios)   
                            case 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.csv':
                                document.getElementById("descarga2_1").click();
                                break;

                            //3. Información sobre las características de los usuarios (Ciudadanos)     
                            case 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.csv':
                                document.getElementById("descarga3_1").click();
                                break;

                            //4. Dependencias con trámites en ACCEDE
                            case 'reps/Dependencias_con_tramites_en_SIGETYS.csv':
                                document.getElementById("descarga4_1").click();
                                break;

                            //5. Seguimiento de trámites por módulos y estatus
                            case 'reps/Seguimiento_de_tramites_por_modulos_y_estatus.csv':
                                document.getElementById("descarga5_1").click();
                                break;
                            
                            //6. Campos desplegables contenidos en cada trámite
                            case 'reps/Campos_desplegables_contenidos_en_cada_tramite.csv':
                                document.getElementById("descarga6_1").click();
                                break;

                            //7. Resultado de encuestas de satisfacción
                            case 'reps/Resultados_encuestas_de_satisfaccion.csv':
                                document.getElementById("descarga7_1").click();
                                break;

                            //8. Todos los rubros
                            case 'reps/Reportes.zip':
                                window.location = data;
                                break;
                        }
                    }
                });
                
            }else{
                alert(alerta);
            }
        }

        function genXML(){
            var alerta = validarcamposalerta();
            if(alerta == 'ok'){

                formato = 'XML';
                treporte = document.getElementById("selectrubro").value;
                datestart = document.getElementById("datestart").value;;
                dateend = document.getElementById("dateend").value;

                var array = {
                    'treporte' : treporte,
                    'datestart' : datestart,
                    'dateend' : dateend,
                    'formato' : formato
                    }
                
                $.ajax({
                    type: "GET",
                    url:  "/generar",
                    data: array,
                    success: function(data)
                    {
                        if(data == 'reps/Reportes.zip'){ window.location = data; }
                        else { window.open(data , "Reporte XML" , "width=1000,height=550"); }
                    }
                });
                
            }else{
                alert(alerta);
            }
        }
    </script>

@endsection