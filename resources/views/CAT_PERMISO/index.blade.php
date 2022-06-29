@extends('layout.Layout')

@section('body')
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-md-8">
                <h2>Permisos</h2>
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

    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="frmForm" name="form" class="form-horizontal needs-validation" novalidate>
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
                                <input type="text" class="form-control" id="StrDescripcion" name="StrDescripcion" placeholder="Descripción" value="" maxlength="50">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Icono</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="StrIcono" name="StrIcono" placeholder="Icono" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ruta</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="StrRuta" name="StrRuta" placeholder="Ruta" value="" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Grupo</label>
                            <div class="col-sm-12">
                                <div id="cmbCategoriaPermiso">
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
        function TRAM_AJX_CONSULTARPERMISO(){
            table = $('#example').DataTable({
                "language": {
                    url: "assets/template/plugins/DataTables/language/Spanish.json",
                    "search":			"Filtrar resultados:",
                },
                "ajax": "/permiso/consultar",
                "columns": [
                    { "data": "PERMI_CNOMBRE" },
                    { "data": "PERMI_CDESCRIPCION" },
                    { 
                        data: null, render: function ( data, type, row ) {
                            return '<span class="icon-accion" onclick="TRAM_FN_EDITAR('+ data.PERMI_NIDPERMISO +');"><i class="fas fa-edit"></i></span>'
                            + '<span class="icon-accion" onclick="TRAM_AJX_ELIMINAR('+ data.PERMI_NIDPERMISO +');"><i class="fas fa-trash"></i></span>';
                        } 
                    },
                ],
                searching: true,
                ordering: true,
                paging: true,
                bLengthChange: false,
            });
        }
        TRAM_AJX_CONSULTARPERMISO();    
    });

    function TRAM_FN_CREAR(){
        $('#IntId').val('');
        $('#frmForm').trigger("reset");
        $('#modal-title').html("Agregar");
        $('#modal').modal('show');
        $('#BtnGuardar').show();
        $('#BtnModificar').hide();
        TRAM_AJX_CONSULTARCATEGORIA_PERMISO();
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
                    url: "/permiso/agregar",
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

    function TRAM_AJX_CONSULTARCATEGORIA_PERMISO(){
        var _html = '';
        $.get('/categoria_permiso/consultar', function (data) {
            console.log(data);

            _html += '<select class="form-control" name="IntCategoria" id="IntCategoria"><option>selecionar...</option>';
            data.forEach(item => {
                _html += '<option value="'+ item.CPERMI_NIDCATEGORIA_PERMISO +'">'+ item.CPERMI_CNOMBRE +'</option>';
            });
            _html += '</select>';
            $("#cmbCategoriaPermiso").html(_html);
        });
    };

    function TRAM_FN_EDITAR(id){
        $('#BtnGuardar').hide();
        $('#BtnModificar').show();
        TRAM_AJX_CONSULTARCATEGORIA_PERMISO();
        $.get('/permiso/obtener/' + id, function (data) {
            $('#modal-title').html("Modificar");

            $('#IntId').val(data.PERMI_NIDPERMISO);
            $('#StrNommbre').val(data.PERMI_CNOMBRE);
            $('#StrDescripcion').val(data.PERMI_CDESCRIPCION);
            $('#StrIcono').val(data.PERMI_CICONO);
            $('#StrRuta').val(data.PERMI_CRUTA);
            $('#IntCategoria').val(data.PERMI_NIDCATEGORIA_PERMISO);
            $('#modal').modal('show');
        });
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
                    url: "/permiso/modificar",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        console.log('ver respuesta');
                        console.log(data);
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
                    url: "/permiso/eliminar",
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