@extends('layout.Layout')

@section('body')
    <div class="container-fluid">
        <!-- <%-- Contenido individual --%> -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Plantilla general</h2>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Datos de búsqueda</h2>
                        </div>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bus-txt-centro-trabajo">Nombre:</label>
                                    <input type="text" class="form-control" id="bus-txt-centro-trabajo"
                                        placeholder="Ingresa un nombre">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bus-cmb-centro-trabajo">Centro de trabajo:</label>
                                    <select class="combobox form-control" name="bus-cmb-centro-trabajo"
                                        id="bus-cmb-centro-trabajo">
                                        <option></option>
                                        <option>Spiderman</option>
                                        <option>Thor</option>
                                        <option>Capitan America</option>
                                        <option>Visión</option>
                                        <option>Iron Man</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bus-cmb-unidad-adm">Unidad administrativa:</label>
                                    <select class="combobox form-control" name="bus-cmb-unidad-adm"
                                        id="bus-cmb-unidad-adm">
                                        <option></option>
                                        <option>Spiderman</option>
                                        <option>Thor</option>
                                        <option>Capitan America</option>
                                        <option>Visión</option>
                                        <option>Iron Man</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                            value="option1">
                                        <label class="form-check-label" for="inlineCheckbox1">Capturado</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                            value="option2">
                                        <label class="form-check-label" for="inlineCheckbox2">En
                                            seguimiento</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                            value="option3">
                                        <label class="form-check-label" for="inlineCheckbox3">Terminado</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                            value="option3">
                                        <label class="form-check-label" for="inlineCheckbox3">cancelado</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="rd-option1" value="1"
                                            name="rd-opciones">
                                        <label class="form-check-label" for="rd-option1">Capturado</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="rd-option2" value="2"
                                            name="rd-opciones">
                                        <label class="form-check-label" for="rd-option2">En seguimiento</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <button class="btn btn-sm btn-primary">Buscar</button>
                            </div>
                            <div class="col-md-6 text-right">
                                <button class="btn btn-sm btn-warning">Limpiar</button>
                                <button class="btn btn-sm btn-primary">Exportar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body text-body">
                    <!-- <div class="row ">
                        <div class="col-md-12">
                            <h2>Resultados de búsqueda</h2>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-12">
                            <table id="example" class="table table-bordered" style="width: 100%">
                                <thead class="bg-gob">
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <br />
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "language": {
                url: "plugins/DataTables/language/Spanish.json",
                "search":			"Filtrar resultados:",
            },
            searching: true,
            ordering: true,
            paging: true,
            bLengthChange: false,
        });
    });
</script>
@endsection