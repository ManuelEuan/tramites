<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


###################### Manuel Euan ######################

Route::post('/perfil/guardarDocs', 'PerfilController@guardarDocs');
Route::get('/perfil', 'PerfilController@index');
Route::get('/perfil/listarDocs', 'PerfilController@listarDocs');
Route::post('/perfil/eliminarDoc', 'PerfilController@eliminarDoc');
Route::post('/gestores/consultar', 'GestorController@consultar');

Route::post('/servidorespublicos/agregar', 'ServidorPublicoController@agregar');
Route::get('/servidorespublicos/editar/{id}', 'ServidorPublicoController@editar');
Route::post('/servidorespublicos/modificar', 'ServidorPublicoController@modificar');
Route::post('/perfil/modificar', 'PerfilController@modificar');

Route::group(['prefix' => 'rol'], function () {
    Route::get('/','RolController@index');
    Route::get('/consultar', 'RolController@consultar');
    Route::get('/obtener/{id}', 'RolController@obtener');
    Route::post('/agregar', 'RolController@agregar');
    Route::post('/modificar', 'RolController@modificar');
    Route::post('/eliminar', 'RolController@eliminar');
});

Route::group(['prefix' => 'permiso'], function (){
    Route::get('/', 'PermisoController@index');
    Route::get('/consultar', 'PermisoController@consultar');
    Route::get('/obtener/{id}', 'PermisoController@obtener');
    Route::post('/agregar', 'PermisoController@agregar');
    Route::post('/modificar', 'PermisoController@modificar');
    Route::post('/eliminar', 'PermisoController@eliminar');
});


/* Route::get('/getFiltros', 'GestorController@obtener_filtro');
Route::get('/tramite_servicio/iniciar_tramite_servicio/{id}', 'TramiteServicioController@iniciar_tramite_servicio');

Route::get('/generate_previo_resolutivo/{resolutivoId}/{tramiteId}/{tipo}', 'TramitesController@generatePrevioResolutivo');
Route::get('/seguimiento_tramite/{id}', 'TramiteServicioController@seguimiento_tramite_servicio');
Route::get('/tramite_servicio_cemr/obtener_tramite/{id}', 'TramitesController@obtener_tramite_seguimiento');
Route::get('/tramite_servicio_cemr/download_tramite/{id}', 'TramitesController@download_tramite');
Route::post('/tramite_servicio/guardar', 'TramiteServicioController@guardar');
Route::get('/getFiltros', 'DiaInhabilController@calendario');
Route::get('/tramite_servicio/seguimiento/{id}', 'TramitesController@seguimiento');


Route::group(['prefix' => 'dias_inhabiles'], function () {
    Route::get('/', 'DiaInhabilController@calendario');
    Route::get('/find', 'DiaInhabilController@find');
    Route::post('/store', 'DiaInhabilController@store');
    Route::post('/update', 'DiaInhabilController@update');
    Route::post('/delete', 'DiaInhabilController@delete');
});

Route::group(['prefix' => 'catalogos'], function () {
    Route::get('/find', 'CatalogoController@find');
    Route::get('/get', 'CatalogoController@get');
    Route::get('/', 'CatalogoController@index');
    Route::post('/', 'CatalogoController@store');
    Route::post('/estatus', 'CatalogoController@cambiaEstatus');
    Route::put('/', 'CatalogoController@update');
});

Route::get('/configurarTramite/{tramiteID}/{tramiteIDConfig}','GestorController@configurar_tramite');
Route::get('/tramite_servicio/{id}','TramiteServicioController@obtener_detalle_tramite');

Route::get('/tramite_servicio_cemr/detalle/{id}', 'TramitesController@detalle');
Route::post('/gestores/crear', 'GestorController@save');
Route::get('/obtener_municipio/{id}','TramiteServicioController@obtener_municipio');
Route::get('/obtener_modulo/{id}/{idaccede}', 'TramiteServicioController@obtener_modulo');
Route::post('/subir_documento', 'TramiteServicioController@subir_documento');
Route::get('/getCitasAgendadas', 'TramitesController@getCitasAgendadas'); */

Route::post('/tramite_servicio/consultar', 'TramiteServicioController@consultar');
Route::post('/recuperar_contrasena','LoginController@recuperar_contrasena');
Route::post('/citas/disponibilidad', 'CitasController@disponibilidad');
Route::post('/citas/update', 'CitasController@update');
Route::post('/general/validaDuplicidad', 'GeneralController@validaDuplicidad');
Route::post('/registrar/agregar', 'RegistroController@agregar');

###################### Manuel Euan ######################





Route::post('/agregar_permiso', array('uses' => 'PermisoController@agregar'));
Route::post('/modificar_permiso', array('uses' => 'PermisoController@modificar'));
Route::post('/eliminar_permiso', array('uses' => 'PermisoController@eliminar'));

Route::group(['prefix' => 'personasfsicasmorales'], function () {
    Route::get('/', 'PersonaController@index');
    Route::get('/find', 'PersonaController@find');
    Route::post('/status', 'PersonaController@status');
    Route::post('/update', 'PersonaController@update');
});

//001_Interoperabilidad con Sistema de Administraci??n de Tr??mites y Servicios (ACCEDE)
//Permite identificar que tr??mites se encuentran disponibles en el Sistema de Administraci??n de Tr??mites y Servicios (ACCEDE) para la gesti??n por parte del ciudadano a trav??s del Sistema de Gesti??n de Tr??mites y Servicios (SIGETyS).
Route::get('/vw_accede_tramite', array('uses' => 'VistaAccedeController@vw_accede_tramite'));
//Permite identificar que tr??mites se encuentran disponibles en el Sistema de Administraci??n de Tr??mites y Servicios (ACCEDE) para la gesti??n por parte del ciudadano a trav??s del Sistema de Gesti??n de Tr??mites y Servicios (SIGETyS).
Route::get('/vw_accede_tramite_id/{id}', array('uses' => 'VistaAccedeController@vw_accede_tramite_id'));
//vw_accede_tramite_id_unidad
Route::get('/vw_accede_tramite_id_unidad/{id}', array('uses' => 'VistaAccedeController@vw_accede_tramite_id_unidad'));
//Permite identificar en que edificios se puede realizar cada tr??mite.
Route::get('/vw_accede_tramite_edificio', array('uses' => 'VistaAccedeController@vw_accede_tramite_edificio'));
//Permite identificar que documentos son necesarios para realizar cada tr??mite.
Route::get('/vw_accede_edificios', array('uses' => 'VistaAccedeController@vw_accede_edificios'));
//vw_accede_edificios_ids
Route::get('/vw_accede_edificios_id/{id}', array('uses' => 'VistaAccedeController@vw_accede_edificios_id'));
//Permite identificar que documentos son necesarios para realizar cada tr??mite.
Route::get('/vw_accede_tramite_documento', array('uses' => 'VistaAccedeController@vw_accede_tramite_documento'));
//vw_accede_tramite_documento_tram_id
Route::get('/vw_accede_tramite_documento_tram_id/{id}', array('uses' => 'VistaAccedeController@vw_accede_tramite_documento_tram_id'));
//Permite consultar el cat??logo de documentos que son necesarios para realizar cada tr??mite.
Route::get('/vw_accede_documentos', array('uses' => 'VistaAccedeController@vw_accede_documentos'));
//Permite identificar los fundamentos legales de los tr??mites y servicios.
Route::get('/vw_accede_tramite_legal/{id}', array('uses' => 'VistaAccedeController@vw_accede_tramite_legal'));
//Permite consultar el cat??logo de centros de trabajo activos del Gobierno del Estado.
Route::get('/vw_accede_centro_trabajo', array('uses' => 'VistaAccedeController@vw_accede_centro_trabajo'));
//Permite consultar el cat??logo de unidades administrativas de los centros de trabajo activos del Gobierno del Estado.
Route::get('/vw_accede_unidad_administrativa', array('uses' => 'VistaAccedeController@vw_accede_unidad_administrativa'));
//vw_accede_unidad_administrativa_centro_id
Route::get('/vw_accede_unidad_administrativa_centro_id/{id}', array('uses' => 'VistaAccedeController@vw_accede_unidad_administrativa_centro_id'));
//Sirve utiliza para consultar el cat??logo de pa??ses.
Route::get('/vw_accede_paises', array('uses' => 'VistaAccedeController@vw_accede_paises'));
//Permite consultar el cat??logo de entidades federativas para especificar el origen de la persona usuaria.
Route::get('/vw_accede_estados', array('uses' => 'VistaAccedeController@vw_accede_estados'));
//Permite consultar el cat??logo de municipios de las entidades federativas para especificar el origen de la persona usuaria.
Route::get('/vw_accede_municipios', array('uses' => 'VistaAccedeController@vw_accede_municipios'));
//Permite consultar el cat??logo de localidades de los municipios para especificar el origen de la persona usuaria.
Route::get('/vw_accede_localidades', array('uses' => 'VistaAccedeController@vw_accede_localidades'));
Route::get('/vw_accede_localidades_municipio/{municipio}', array('uses' => 'VistaAccedeController@vw_accede_localidades_municipio'));


//003_Interoperabilidad con Sistema de Administraci??n de Citas
//Permite ideritificar las citas disponibles en el Sistema de Admiristracion de Citas, para la gestion por parte del ciudadano a traves del Sistema de Gestiori de Tramites y Servicios (SIGETyS).
Route::get('/vw_sici_citas_disponibles', array('uses' => 'VistaAccedeController@vw_sici_citas_disponibles'));
Route::get('/vw_sici_citas_disponibles_filtro/{idtramite}/{idedificio}', array('uses' => 'VistaAccedeController@vw_sici_citas_disponibles_filtro'));
//Permite identificar los estatus de as citas programadas reservadas par el ciudadano (asistida, cancelada par el usuario a cancelada desde el sistema).
Route::get('/vw_sici_estatus_citas', array('uses' => 'VistaAccedeController@vw_sici_estatus_citas'));
Route::get('/vw_sici_estatus_citas_filtro/{edificio}/{tramite}/{agenda}', array('uses' => 'VistaAccedeController@vw_sici_estatus_citas_filtro'));
//Permite identificar los tramites y los edificios que cuentan con citas disponibles en ei Sistema de Admnistracion de Citas.
Route::get('/vw_sici_tramite_edificio_con_citas', array('uses' => 'VistaAccedeController@vw_sici_tramite_edificio_con_citas'));
//Permite identificar las citas programadas o reservadas en el Sisterna de Administration de Citas.
Route::get('/vw_sici_citas_reservadas', array('uses' => 'VistaAccedeController@vw_sici_citas_reservadas'));
Route::get('/vw_sici_citas_reservadas_filtro/{idcita}', array('uses' => 'VistaAccedeController@vw_sici_citas_reservadas_filtro'));
//Permite programar o reservar citas.
Route::post('/sp_sici_guardar_cita', array('uses' => 'VistaAccedeController@sp_sici_guardar_cita'));
//Permite cancelar o asistir a citas.
Route::post('/sp_sici_spu_agenda', array('uses' => 'VistaAccedeController@sp_sici_spu_agenda'));

//CITAS
Route::get('/consultar_citas/{idusuario}/{idtramiteconf}', array('uses' => 'CitasController@consultar_citas'));
Route::get('/citas_disponibles/{idtramite}/{idedificio}', array('uses' => 'CitasController@citas_disponibles'));
Route::get('/tramite_edificios/{id}', array('uses' => 'TramiteServicioController@tramite_edificios'));
//Permite programar o reservar citas.
Route::post('/guardar_cita', array('uses' => 'CitasController@guardar_cita'));
Route::post('/guardar_cita_local', array('uses' => 'CitasController@guardar_cita_local'));
//Permite cancelar o asistir a citas.
Route::post('/actualizar_cita', array('uses' => 'CitasController@actualizar_cita'));

//Citas nuevos
Route::post('/sp_citalinea', array('uses' => 'VistaAccedeController@sp_citalinea'));
Route::get('/vw_sici_citas_disponibles_filtro_tram/{idtramite}', array('uses' => 'VistaAccedeController@vw_sici_citas_disponibles_filtro_tram'));

//Obtiene tramites por filtro
Route::post('/vw_accede_tramite_filtro', array('uses' => 'VistaAccedeController@vw_accede_tramite_filtro'));

//CITAS Angel Ruiz
Route::group(['prefix' => 'citas'], function () {
    Route::get('/index', 'CitasController@getCitas');
    Route::get('/', 'CitasController@getCitasFiltro');
    Route::post('/', 'CitasController@saveCita');
    Route::post('/descargar', 'CitasController@descargaPDFCita');
    Route::post('/delete', 'CitasController@delete');
    Route::delete('/{id}', 'CitasController@deleteCita');
});

Route::post('/webhook/pago_status', 'WebHookController@PagoEstatus');