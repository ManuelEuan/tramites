<!-- <div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="txtNombre">Nombres(s)</label>
            <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre (s)">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="txtPrimerApellido">Primer apellido</label>
            <input type="text" class="form-control" name="txtPrimerApellido" id="txtPrimerApellido" placeholder="Primer apellido">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="txtSegundoApellido">Segundo apellido</label>
            <input type="text" class="form-control" name="txtSegundoApellido" id="txtSegundoApellido" placeholder="Segundo apellido">
        </div>
    </div>
</div> -->

<!-- o	Datos de identificación
o	Datos de contacto
o	Datos laborales
o	Datos sobre características físicas
o	Datos académicos
o	Datos patrimoniales o financieros
o	Otros datos
o	Listado de Documentos anexos -->


<div class="row">
    <div class="col-4">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="pill_tab_1" data-toggle="pill" href="#pill_identificacion" role="tab" aria-controls="pill_identificacion" aria-selected="true">Datos de identificación</a>
            <a class="nav-link" id="pill_tab_2" data-toggle="pill" href="#pill_contacto" role="tab" aria-controls="pill_contacto" aria-selected="false">Datos de contacto</a>
            <a class="nav-link" id="pill_tab_3" data-toggle="pill" href="#pill_laboral" role="tab" aria-controls="pill_laboral" aria-selected="false">Datos laborales</a>
            <a class="nav-link" id="pill_tab_4" data-toggle="pill" href="#pill_caracteristica" role="tab" aria-controls="pill_caracteristica" aria-selected="false">Datos sobre características físicas</a>
        </div>
    </div>
    <div class="col-8">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="pill_identificacion" role="tabpanel" aria-labelledby="pill_tab_1">
                Identificacion
            </div>
            <div class="tab-pane fade" id="pill_contacto" role="tabpanel" aria-labelledby="pill_tab_2">
                Contacto

            </div>
            <div class="tab-pane fade" id="pill_laboral" role="tabpanel" aria-labelledby="pill_tab_3">
                Laborales

            </div>
            <div class="tab-pane fade" id="pill_caracteristica" role="tabpanel" aria-labelledby="pill_tab_4">
                Caracteriticas

            </div>
        </div>
    </div>
</div>
