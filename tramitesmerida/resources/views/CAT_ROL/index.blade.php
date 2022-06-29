@extends('layout.Layout')

@section('body')
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-md-8">
                <h2>Roles</h2>
            </div>
            <div class="col-md-4">
                <div class="row justify-content-between">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary" onclick="TRAM_FN_CREAR();">Crear</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body text-body">
                <div class="row">
                    <div class="col-12">
                        <table id="example" class="table table-bordered" style="width: 100%">
                            <thead class="bg-gob">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="frmForm" name="form" class="form-horizontal needs-validation" novalidate>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="permiso-tab" data-toggle="tab" href="#permiso" role="tab" aria-controls="permiso" aria-selected="false">Permisos</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <input type="hidden" name="IntId" id="IntId">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Nombre</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="StrNommbre" name="StrNommbre" placeholder="Nombre" value="" maxlength="50" required>
                                            <div class="invalid-feedback">
                                                requerido
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Descripción</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="StrDescripcion" name="StrDescripcion" placeholder="Descripción" value="" maxlength="50" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="permiso" role="tabpanel" aria-labelledby="permiso-tab">
                                    <div id="ListPermiso">
                                    </div>
                                </div>
                          </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!--<div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Guardar
                        </button>
                    </div>-->
                    <div class="row justify-content-between">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary" id="BtnGuardar" onclick="TRAM_AJX_GUARDAR();">Guardar</button>
                            <button class="btn btn-primary" id="BtnModificar" onclick="TRAM_AJX_MODIFICAR();">Modificar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var table = null;
    var SITEURL = '{{URL::to('')}}';
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function TRAM_AJX_CONSULTAR(){
            table = $('#example').DataTable({
                "language": {
                    url: "assets/template/plugins/DataTables/language/Spanish.json",
                    "search":			"Filtrar resultados:",
                },
                "ajax": "/rol/consultar",
                "columns": [
                    { "data": "ROL_CNOMBRE" },
                    { "data": "ROL_CDESCRIPCION" },
                    { 
                        
                        data: null, render: function ( data, type, row ) {
                            console.log(data.ROL_CCLAVE);

                            /*if(data.ROL_CCLAVE  == "ADM" || 
                             data.ROL_CCLAVE    == "CDNS" || 
                             data.ROL_CCLAVE    == "ENLOF" || 
                             data.ROL_CCLAVE    == "ADMCT" ||
                             data.ROL_CCLAVE    == "SERP" ||
                             data.ROL_CCLAVE    == "CONSR" ||
                             
                             
                             ){

                                return '<span class="icon-accion" onclick="TRAM_FN_EDITAR('+ data.ROL_NIDROL +');"><i class="fas fa-edit"></i></span>' ;
            
                       
                             } else{

                                return '<span class="icon-accion" onclick="TRAM_FN_EDITAR('+ data.ROL_NIDROL +');"><i class="fas fa-edit"></i></span>'
                                + '<span class="icon-accion" onclick="TRAM_AJX_ELIMINAR('+ data.ROL_NIDROL +');"><i class="fas fa-trash"></i></span>';
                       
                             }*/

                             if(data.ROL_CCLAVE  == "ADM" || 
                             data.ROL_CCLAVE    == "CDNS" || 
                             data.ROL_CCLAVE    == "ENLOF" || 
                             data.ROL_CCLAVE    == "ADMCT" ||
                             data.ROL_CCLAVE    == "SERP" ||
                             data.ROL_CCLAVE    == "CONSR"
                             ){
                                return '<span class="icon-accion" onclick="TRAM_FN_EDITAR('+ data.ROL_NIDROL +');"><i class="fas fa-edit"></i></span>';
                              
                             }else{
                                return '<span class="icon-accion" onclick="TRAM_FN_EDITAR('+ data.ROL_NIDROL +');"><i class="fas fa-edit"></i></span>'
                                + '<span class="icon-accion" onclick="TRAM_AJX_ELIMINAR('+ data.ROL_NIDROL +');"><i class="fas fa-trash"></i></span>';
                             }
                           
                          
                        } 
                    },
                ],
                searching: true,
                ordering: true,
                paging: true,
                bLengthChange: false,
            });
        }
        TRAM_AJX_CONSULTAR();    
    });

    function TRAM_AJX_CONSULTARPERMISO(){
        var _html = '';
        $.get('/permiso/consultar', function (data) {
            data.data.forEach(item => {
                _html += '<div class="form-check">';
                _html += '<input class="form-check-input" type="checkbox" name="dLstPermisos[]" value="'+ item.PERMI_NIDPERMISO +'" id="permiso'+ item.PERMI_NIDPERMISO +'">';
                _html += '<label class="form-check-label" for="permiso'+ item.PERMI_NIDPERMISO +'" style="color: #000 !important;"><b>' + item.PERMI_CNOMBRE + '</b><br/><span>' + item.PERMI_CDESCRIPCION + '</span>';
                _html += '</label>';
                _html += '</div><hr/>';
                $("#ListPermiso").html(_html);
            });
        });
    }

    function TRAM_AJX_CONSULTARPERMISOROL(id){
        TRAM_AJX_CONSULTARPERMISO();
        setTimeout(function(){
            $.get('/permisorol/consultar/'+ id, function (data) {
                $('#ListPermiso input[type=checkbox]').each(function () {
                    data.forEach(item => {
                        if(this.value == item.PROL_NIDPERMISO){
                            this.checked = true;
                        }
                    });
                });
            });
        }, 2000);
    }
    
    function TRAM_FN_CREAR(){
        $('#IntId').val('');
        $('#frmForm').trigger("reset");
        $('#modal-title').html("Agregar");
        $('#modal').modal('show');
        $('#BtnGuardar').show();
        $('#BtnModificar').hide();
        TRAM_AJX_CONSULTARPERMISO();
    }

    function TRAM_AJX_GUARDAR(){
        var forms = document.getElementsByClassName('needs-validation');

		// Validar
        var validation = Array.prototype.filter.call(forms, function(form) {
	   		if (form.checkValidity() === false) {
	     		event.preventDefault();
	     		event.stopPropagation();
	   		}else {
	   			//Create
	   			$.ajax({
                    data: $('#frmForm').serialize(),
                    url: "/rol/agregar",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        Swal.fire({
                            icon: data.status,
                            title: '',
                            text: data.message,
                            footer: ''
                        });

                        $('#frmForm').trigger("reset");
                        $('#modal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: data.status,
                            title: '',
                            text: data.message,
                            footer: ''
                        });
                    }
                });
	   		}
	   		form.classList.add('was-validated');
	    });
    }

    function TRAM_FN_EDITAR(id){
        $('#BtnGuardar').hide();
        $('#BtnModificar').show();
        $.get('/rol/obtener/' + id, function (data) {
            $('#modal-title').html("Modificar");

            $('#IntId').val(data.ROL_NIDROL);
            $('#StrNommbre').val(data.ROL_CNOMBRE);
            $('#StrDescripcion').val(data.ROL_CDESCRIPCION);
            $('#modal').modal('show');
        });
        TRAM_AJX_CONSULTARPERMISOROL(id);
    }

    function TRAM_AJX_MODIFICAR(){
        var forms = document.getElementsByClassName('needs-validation');

		// Validar
        var validation = Array.prototype.filter.call(forms, function(form) {
	   		if (form.checkValidity() === false) {
	     		event.preventDefault();
	     		event.stopPropagation();
	   		}else {
	   			//Update
	   			$.ajax({
                    data: $('#frmForm').serialize(),
                    url: "/rol/modificar",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        Swal.fire({
                            icon: data.status,
                            title: '',
                            text: data.message,
                            footer: ''
                        });

                        $('#frmForm').trigger("reset");
                        $('#modal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: data.status,
                            title: '',
                            text: data.message,
                            footer: ''
                        });
                    }
                });
	   		}
	   		form.classList.add('was-validated');
	    });
    }

    function TRAM_AJX_ELIMINAR(id){
        Swal.fire({
            title: '',
            text: "¿Desea eliminar los datos?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
            }).then((result) => {
            if (result.isConfirmed) {

               
                $.ajax({
                    data: { IntId: id },
                    url: "/rol/eliminar",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        Swal.fire({
                            icon: data.status,
                            title: '',
                            text: data.message,
                            footer: ''
                        });
                        table.ajax.reload();
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: data.status,
                            title: '',
                            text: data.message,
                            footer: ''
                        });
                    }
                });
            }
        });
    }
</script>
@endsection