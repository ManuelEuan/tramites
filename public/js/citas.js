var URL_BASE = '/api/';
var URL_BASE_SERVER = 'https://vucapacita.chihuahua.gob.mx/api/';
var URL_BASE_SEGUIMIENTO = 'https://vucapacita.chihuahua.gob.mx/tramite_servicio/seguimiento_tramite/';

function citasDisponibles(idtramite, idedificio,idusuario, nombre, apellidop, apellidom, correo, celular, tramitelocal){
    table = $('#citasdisponibles').DataTable({
        "language": {
            url: "/assets/template/plugins/DataTables/language/Spanish.json",
            "search": "Filtrar resultados:",
        },
        "ajax": {
            // "data": filtro,
            "url": URL_BASE + "citas_disponibles/"+idtramite+"/"+idedificio,
            "dataSrc": '',
            "type": "GET"
        },
        "columns": [
            {
                "data": "FECHA"
            },
            {
                "data": "HORA"
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `<span>
                                <button type="button" onclick="reservaCita(${idusuario}, '${nombre}', '${apellidop}', '${apellidom}', '${correo}', '${celular}', ${tramitelocal}, ${idtramite},${idedificio},'${ data.FECHA}', '${data.HORA }')" title="RESERVAR" class="btn btn-success btn-reserva"><i class="fas fa-edit" style="color: green"></i> RESERVAR</button>
                            </span>`;
                }
            },
        ],
        "lengthMenu": [10, 25, 50, 100],
        searching: true,
        ordering: true,
        paging: true,
        bLengthChange: true
    });
}

function existeCitaFuncionario(idusuario, tramitelocal){
    $.ajax({
        url: URL_BASE + 'consultar_citas/'+idusuario+'/'+tramitelocal,
        type: 'get',
        dataType: 'json',
        //contentType: 'application/json',
        success: function (data) {
            console.log(data);
            if(data.data.length > 0){
                $("#sincitareservada").hide();
                $("#concitareservada").show();
                
                obtenerStatusCita(data.data[0].CITA_FOLIO);
                obtenerCitaReservada(data.data[0].CITA_FOLIO, true);

                $("#cita_folio").text(data.data[0].CITA_FOLIO);
            }else{
                $("#concitareservada").hide();
                $("#sincitareservada").show();
            }
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function existeCita(idusuario, tramitelocal, tramiteaccede){
    $.ajax({
        url: URL_BASE + 'consultar_citas/'+idusuario+'/'+tramitelocal,
        type: 'get',
        dataType: 'json',
        //contentType: 'application/json',
        success: function (data) {
            console.log(data);
            if(data.data.length > 0){
                $("#sincitareservada").hide();
                $("#concitareservada").show();
                
                obtenerStatusCita(data.data[0].CITA_FOLIO);
                obtenerCitaReservada(data.data[0].CITA_FOLIO, false);
            }else{
                $("#concitareservada").hide();
                $("#sincitareservada").show();
                
                obtenerEdificios(tramiteaccede);
                //citasDisponibles(idtramite, idedificio, idusuario, nombre, apellidop, apellidom, correo, celular, tramitelocal);
            }
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function reservaCita(idusuario, nombre, apellidop, apellidom, correo, celular, tramitelocal, tramite, edificio, fecha, hora){

    $(".btn-reserva").attr('disabled', 'disabled');

   var jsonobject = {
        nombre:nombre,
        primerapellido: apellidop,
        segundoapellido: apellidom,
        correo: correo,
        celular: celular,
        tramite: tramite,
        edificio: edificio,
        hora: hora,
        fecha: fecha
   };

   $.ajax({
        url: URL_BASE_SERVER + 'sp_sici_guardar_cita',
        type: 'post',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(jsonobject),
        success: function (data) {
            if(data && data[0][0] == "ER"){
                alert(data[0][1]);
            }else{
                guarda_local(idusuario, tramitelocal, data[0][0]);
            }
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function guarda_local(idusuario, idtramite, folio){

    var jsonobject = {
        CITA_FOLIO: folio,
        CITA_STATUS: 1,
        CITA_IDUSUARIO: idusuario,
        CITA_IDTRAMITECONF: idtramite
   };
   
    $.ajax({
        url: URL_BASE + 'guardar_cita_local',
        type: 'post',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(jsonobject),
        success: function (data) {

            Swal.fire({
                title: '¡Éxito!',
                text: "Reservación completada con éxito",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
                }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function actualizaCita(escancelacion, motivo){
    
    var idcita = $("#cita_id").val();
    var folio = $("#cita_folio").text();

    var jsonobject = {
        idasisten: !escancelacion ? idcita : '',
        idcancelan: escancelacion ? idcita : '',
        idmotivocancelan: '',
        motivocancelan: motivo,
        usuario: 'ADMINISTRADORMR',
        hd: '192.168.1.1',
   };

   $.ajax({
        url: URL_BASE_SERVER + 'sp_sici_spu_agenda',
        type: 'post',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(jsonobject),
        success: function (data) {
            if(data && data[0][0] == "ER"){
                alert(data[0][1]);
            }else{
                actualiza_local(folio, escancelacion);
            }
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function actualiza_local(folio, escancelacion){

    var jsonobject = {
        CITA_FOLIO: folio,
        CITA_STATUS: escancelacion ? 3 : 2
   };
   
    $.ajax({
        url: URL_BASE + 'actualizar_cita',
        type: 'post',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(jsonobject),
        success: function (data) {

            console.log(data);
            console.log("COMPLETADO.");
            /*Swal.fire({
                title: '¡Éxito!',
                text: "Reservación completada con éxito",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
                }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });*/
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function obtenerStatusCita(folio){
    $.ajax({
        url: URL_BASE_SERVER + 'vw_sici_estatus_citas_filtro/'+folio+"/0/0",
        type: 'get',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $("#cita_status").text(data[0][6]);
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function obtenerCitaReservada(folio, esfuncionario){
    $.ajax({
        url: URL_BASE_SERVER + 'vw_sici_citas_reservadas_filtro/'+folio,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $("#cita_fecha").text(data[0].FECHA_CITA);
            $("#cita_hora").text(data[0].HORA_CITA);
            $("#cita_edificio").text(data[0].NOMBRE_EDIFICIO);
            $("#cita_edificio_direccion").text(data[0].CALLE_EDIFICIO + ", #" + data[0].NUM_EXT_EDIFICIO + ", " + data[0].COLONIA_EDIFICIO + ", " + data[0].MUNICIPIO_EDIFICIO);
            $("#cita_folio_cita").text(data[0].FOLIO_CITA);
            $("#cita_tramite").text(data[0].TRAMITE);

            if(esfuncionario){
                $("#cita_id").val(data[0][0]);
            }

            cargarMapa(parseFloat(data[0].LATITUD_EDIFICIO), parseFloat(data[0].LONGITUD_EDIFICIO), !esfuncionario ? 'cita_mapa' : 'mapa_cita');
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function obtenerEdificios(idtramite, esCita = true){

    var idModuloSelected = "";

    if(esCita){
        $("#cita_edificios").empty();
        $("#cita_edificios").append($("<option />").val(0).text("--Seleccione un edificio--"));
        idModuloSelected = localStorage.getItem("IdModuloSelected");
    }
    else{
        $("#sincita_edificios").empty();
        $("#sincita_edificios").append($("<option />").val(0).text("--Seleccione un edificio--"));
    }

    $.ajax({
        url: URL_BASE + 'tramite_edificios/'+idtramite,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            for(var i=0; data.oficinas.length > i; i++){
                if(esCita && idModuloSelected != "" && idModuloSelected == data.oficinas[i].id){
                    $("#cita_edificios").append($("<option selected=selected />").val(data.oficinas[i].id).text(data.oficinas[i].nombre));
                    loadCitas();
                    break;
                }
                else if(esCita){
                    $("#cita_edificios").append($("<option />").val(data.oficinas[i].id).text(data.oficinas[i].nombre));
                }
                else{
                    $("#sincita_edificios").append($("<option />").val(data.oficinas[i].id).text(data.oficinas[i].nombre));
                }
            }
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

//Metodo que permite traer la informacion del edificio para visualizar el detalle
function loadSelectedEdificio(idtramite, selectedValue){
    $('#infoEdificioNombre').text('----');
    $('#infoEdificioDireccion').text('----');
    $("#btnSaveUbication").prop("disabled", true);
    ubicacion_ventanilla_sin_cita = {};
    if(selectedValue != 0){
        $.ajax({
            url: URL_BASE + 'tramite_edificios/'+idtramite,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                for(var i=0; data.oficinas.length > i; i++){
                    if(selectedValue == data.oficinas[i].id){
                        $('#infoEdificioNombre').text(data.oficinas[i].nombre);
                        $('#infoEdificioDireccion').text(data.oficinas[i].direccion);
                        ubicacion_ventanilla_sin_cita = data.oficinas[i];
                        $("#btnSaveUbication").prop("disabled", false);
                    }
                }
            },
            error: function (xhr, error) {
                console.log(xhr.responseText);
            }
        });
    }
}

function cargaMapaEdificios(idtramite, idEdificio, idDiv){
    $.ajax({
        url: URL_BASE + 'tramite_edificios/'+idtramite,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            for(var i=0; data.oficinas.length > i; i++){
                if(idEdificio == data.oficinas[i].id && data.oficinas[i].latitud > 0){
                    cargarMapa(parseFloat(data.oficinas[i].latitud), parseFloat(data.oficinas[i].longitud), idDiv);
                    break;
                }
            }
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function cargarMapa(latitud, longitud, id){
    var lat = latitud != 0 ? latitud : 28.640157192843148;
    var lon = longitud != 0 ? longitud : -106.07436882706008;
    var  map = new google.maps.Map(document.getElementById(id), {
        center: {
            lat: lat,
            lng: lon
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
        position: new google.maps.LatLng(lat, lon),
        map: map,
        title: 'Ubicación'
    });
}

function validateCitasSync(elementid){
    var valueHasCitas = localStorage.getItem("HasCitas");
    if(valueHasCitas === "True"){
        $("#"+elementid).css("color", "green");
        $("#"+elementid).text("Sincronizado");
     }else{
        $("#"+elementid).css("color", "red");
        $("#"+elementid).text("No Sincronizado");
     }
}

function tramiteTieneCitas(tramite){
    $.ajax({
        url: URL_BASE_SERVER + 'vw_sici_citas_disponibles_filtro_tram/'+tramite,
        type: 'get',
        dataType: 'json',
        //contentType: 'application/json',
        success: function (data) {
            //console.log(data);
            if(data.length > 0){
               localStorage.setItem("HasCitas", "True");
            }else{
               localStorage.setItem("HasCitas", "False");
            }
        },
        error: function (xhr, error) {
            console.log(xhr.responseText);
        }
    });
}

function solicitudTramiteCita(tramite){

    var valueHasCitas = localStorage.getItem("HasCitas");
    if(valueHasCitas !== "True"){
        var jsonobject = {
            idtramite: tramite,
            tramitelinea:'1',
            tramitecita: '1',
            tramiteliga: URL_BASE_SEGUIMIENTO + tramite,
            tramiteedificio: '0',
        };

        $.ajax({
                url: URL_BASE_SERVER + 'sp_citalinea',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(jsonobject),
                success: function (data) {
                    if(data != undefined){
                        console.log("Completed: "+data);
                    }
                },
                error: function (xhr, error) {
                    console.log(xhr.responseText);
                }
        });
    }else{
        console.log("Si tiene citas, no necesita crear.");
    }
}