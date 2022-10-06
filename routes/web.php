<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'LoginController@index')->name("login");
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');
Route::post('/recuperar_contrasena', array('uses' => 'LoginController@recuperar_contrasena'));
Route::get('/recuperar_cuenta/{StrToken}', array('uses' => 'LoginController@recuperar_cuenta'));
Route::get('/recuperar/{StrToken}', array('uses' => 'LoginController@recuperar'));
Route::post('/cambiar_contrasena', array('uses' => 'LoginController@cambiar_contrasena'));

Route::get('/registrar', function () {
    return view('MST_REGISTRO.index');
});
Route::post('/registrar/agregar', array('uses' => 'RegistroController@agregar'));
Route::get('/registrar/validar_rfc/{StrRfc}', array('uses' => 'RegistroController@validar_rfc'));
Route::get('/registrar/validar_correo/{StrCorreo}', array('uses' => 'RegistroController@validar_correo'));
Route::get('/registrar/localidades/{Strlocalidad}', array('uses' => 'RegistroController@localidades'));
Route::get('/registrar/estados', array('uses' => 'RegistroController@estados'));
Route::get('/registrar/municipios', array('uses' => 'RegistroController@municipios'));


Route::get('/perfil', array('uses' => 'PerfilController@index'));
Route::post('/perfil/modificar', array('uses' => 'PerfilController@modificar'));
Route::post('/perfil/confirmar', array('uses' => 'PerfilController@confirmar'));
Route::post('/perfil/confirmarServidor', array('uses' => 'PerfilController@confirmarServidor'));
Route::post('/perfil/guardarDocs', array('uses' => 'PerfilController@guardarDocs'));
Route::post('/perfil/eliminarDoc', array('uses' => 'PerfilController@eliminarDoc'));
Route::get('/perfil/getHistory', array('uses' => 'PerfilController@getDocsHistory'));
Route::get('/perfil/getDocsHistoryExpediente/{id}', array('uses' => 'PerfilController@getDocsHistoryExpediente'));
Route::get('/perfil/listarDocs', array('uses' => 'PerfilController@listarDocs'));
Route::get('/perfil/listarResolutivos', array('uses' => 'PerfilController@listarResolutivos'));
Route::post('/perfil/setActual', array('uses' => 'PerfilController@setActual'));

Route::get('/bitacora', array('uses' => 'BitacoraController@index'));
Route::get('/bitacora/consultar', array('uses' => 'BitacoraController@consultar'));

Route::get('/permiso', array('uses' => 'PermisoController@index'))->middleware("permiso");
Route::get('/permiso/consultar', array('uses' => 'PermisoController@consultar'));
Route::get('/permiso/obtener/{id}', array('uses' => 'PermisoController@obtener'));
Route::post('/permiso/agregar', array('uses' => 'PermisoController@agregar'));
Route::post('/permiso/modificar', array('uses' => 'PermisoController@modificar'));
Route::post('/permiso/eliminar', array('uses' => 'PermisoController@eliminar'));

Route::get('/rol', array('uses' => 'RolController@index'))->middleware("permiso");
Route::get('/rol/consultar', array('uses' => 'RolController@consultar'));
Route::get('/rol/obtener/{id}', array('uses' => 'RolController@obtener'));
Route::post('/rol/agregar', array('uses' => 'RolController@agregar'));
Route::post('/rol/modificar', array('uses' => 'RolController@modificar'));
Route::post('/rol/eliminar', array('uses' => 'RolController@eliminar'));

Route::get('/permisorol/consultar/{id}', array('uses' => 'PermisoRolController@consultar'));
Route::get('/categoria_permiso/consultar/', array('uses' => 'CategoriaPermisoController@consultar'));
Route::get('/download_tramite_detalle/{id}', 'TramiteServicioController@download_tramite_detalle')->name('download_tramite_detalle');
Route::get('/consultar_pago/{id}', 'TramiteServicioController@consultar_pago')->name('consultar_pago');

Route::group(['prefix' => 'tramite_servicio'], function () {
    Route::get('/', array('uses' => 'TramiteServicioController@index'))->middleware("permiso");
    Route::post('/getTramites', 'TramiteServicioController@getTramites');
    Route::post('/consultar', 'TramiteServicioController@consultar')->name('consultar_tramites');;
    Route::get('/obtener_dependencias_unidad', 'TramiteServicioController@obtener_dependencias_unidad');
    Route::get('/obtener_modalidad', 'TramiteServicioController@obtener_modalidad');
    Route::get('/obtener_clasificacion', 'TramiteServicioController@obtener_clasificacion');
    Route::get('/obtener_audiencia', 'TramiteServicioController@obtener_audiencia');
    Route::get('/detalle_tramite/{id}','TramiteServicioController@obtener_detalle_tramite')->name('detalle_tramite');
    Route::get('/iniciar_tramite_servicio/{id}','TramiteServicioController@iniciar_tramite_servicio');
    Route::get('/obtener_municipio/{id}', 'TramiteServicioController@obtener_municipio')->name('//');
    Route::get('/obtener_modulo/{id}/{idaccede}', 'TramiteServicioController@obtener_modulo')->name('iniciar_tramite_obtener_modulo');
    Route::get('/obtener_modulo_detalle/{id}', 'TramiteServicioController@obtener_modulo_detalle')->name('obtener_modulo_detalle');
    Route::post('/guardar', 'TramiteServicioController@guardar')->name('guardar_tramites');
    Route::post('/enviar','TramiteServicioController@enviar')->name('enviar_tramites');
    Route::post('/subir_documento','TramiteServicioController@subir_documento')->name('subir_documento');
    Route::post('/enviar_documentos', 'TramiteServicioController@enviar_documentos')->name('enviar_documentos');
    Route::post('/reenviar', 'TramiteServicioController@reenviar')->name('reenviar_tramites');
    Route::get('/consultar_detalle_notificacion/{id}', 'TramiteServicioController@consultar_detalle_notificacion')->name('consultar_detalle_notificacion');
    Route::get('/atencion_notificacion_seguimiento/{id}/{noti}', 'TramiteServicioController@atencion_notificacion_seguimiento')->name('atencion_notificacion_seguimiento');
    Route::post('/enviar_encuesta', 'TramiteServicioController@enviar_encuesta')->name('enviar_encuesta');
    Route::get('/seguimiento_tramite/{id}', 'TramiteServicioController@seguimiento_tramite_servicio')->name('seguimiento_tramite');
    Route::put('/ubicacion_ventanilla', 'TramiteServicioController@ubicacion_ventanilla_sin_cita')->name('ubicacion_ventanilla_sin_cita');
    Route::post('/api/obtenerinfociudadano', 'TramiteServicioController@obtenerInformacionCiudadano');
});


Route::get('/seguimiento_solicitud', 'SeguimientoSolicitudController@index')->middleware("permiso");
Route::group(['prefix' => 'seguimiento'], function () {
    Route::post('/consultar', 'SeguimientoSolicitudController@consultar');
    Route::get('/obtener_dependencias_unidad', 'SeguimientoSolicitudController@obtener_dependencias_unidad');
    Route::get('/detalle_seguimiento/{id}', 'SeguimientoSolicitudController@obtener_detalle_seguimiento')->name('detalle_seguimiento');
    Route::get('/detalle_notificacion/{id}', 'SeguimientoSolicitudController@detalle_notificacion')->name("detalle_notificacion");
    Route::get('/consultar_ventanilla/{id}', 'SeguimientoSolicitudController@consultar_ventanilla')->name("consultar_ventanilla");
    Route::get('/consultar_cita/{id}', 'SeguimientoSolicitudController@consultar_cita')->name("consultar_cita");
    Route::get('/conexion', 'SeguimientoSolicitudController@conexion')->name("conexion");
});

Route::group(['prefix' => 'tramite_servicio_cemr'], function () {
    Route::get('/', 'TramitesController@listado');
    Route::post('/find', 'TramitesController@find');
    Route::get('/detalle/{id}', 'TramitesController@detalle');
    Route::get('/seguimiento/{id}', 'TramitesController@seguimiento')->name('seguimiento_tramite_servidor');
    Route::get('/generate_previo_resolutivo/{resolutivoId}/{tramiteId}/{tipo}', 'TramitesController@generatePrevioResolutivo')->name('generate_previo_resolutivo');
    Route::get('/obtener_tramite/{id}', 'TramitesController@obtener_tramite_seguimiento');
    Route::post('/seccion_formulario_incompleta', 'TramitesController@seccion_formulario_incompleta');
    Route::post('/seccion_formulario_aprobado', 'TramitesController@aprobar_seccion_formulario');
    Route::post('/seccion_revision_aprobado', 'TramitesController@aprobar_seccion_revision_documentos');
    Route::post('/seccion_revision_incompleta', 'TramitesController@seccion_revision_incompleta');
    Route::post('/seccion_cita_aprobado', 'TramitesController@aprobar_seccion_cita');
    Route::post('/seccion_cita_reprogramar', 'TramitesController@reprogramar_seccion_cita');
    Route::post('/seccion_ventanilla_aprobado', 'TramitesController@aprobar_seccion_ventanilla');
    Route::post('/seccion_pago_aprobado', 'TramitesController@aprobar_seccion_pago');
    Route::post('/seccion_analisis_interno_aprobado', 'TramitesController@aprobar_seccion_analisis_interno');
    Route::post('/seccion_emitir_resolutivo', 'TramitesController@emitir_resolutivo')->name("seccion_emitir_resolutivo"); //!emitir resolutivo
    Route::post('/seccion_rechazar_tramite', 'TramitesController@rechazar_tramite')->name("rechazar_tramite");
    Route::post('/guardar_conceptos', 'TramitesController@guardar_conceptos')->name("guardar_conceptos");
    Route::get('/download_tramite/{id}', 'TramitesController@download_tramite')->name('download_tramite');
    Route::get('/seccion_actualizar_pago/{id}', 'GestorController@actualizar_pago')->name('actualizar_pago');
    //vista de asignacion
    Route::post('/asignar_tramite', 'TramitesController@asignar_tramite')->name('asignar_tramite');;
});

Route::group(['prefix' => 'formulario'], function () {
    Route::get('/', 'FormularioController@list');
    Route::get('/secciones', 'FormularioController@secciones');
    Route::get('/find', 'FormularioController@find');
    Route::post('/store', 'FormularioController@store');
    Route::post('/status', 'FormularioController@status');
    Route::post('/update', 'FormularioController@update');
    Route::post('/delete', 'FormularioController@delete');
    Route::get('/detalle', 'FormularioController@detalle');
    Route::post('/preguntas', 'FormularioController@preguntas');
});

Route::group(['prefix' => 'gestores_solicitud'], function () {
    Route::get('/', 'GestoresController@index')->middleware("permiso");
    Route::get('/find', 'GestoresController@find');
    Route::get('/usuarios', 'GestoresController@usuarios');
    Route::post('/vincular', 'GestoresController@vincular');
    Route::post('/delete', 'GestoresController@delete');
    Route::post('/respuesta', 'GestoresController@respuesta');
});

Route::group(['prefix' => 'personasfsicasmorales'], function () {
    Route::get('/', 'PersonaController@index')->middleware("permiso");
    Route::get('/find', 'PersonaController@find');
    Route::get('/findAnalista', 'PersonaController@findAnalista');
    Route::post('/status', 'PersonaController@status');
    Route::post('/update', 'PersonaController@update');
});

Route::get('/ListaAnalistas', 'PersonaController@findAnalista');

Route::group(['prefix' => 'notificaciones'], function () {
    Route::post('/', 'NotificacionController@getNotificaciones');
});

Route::group(['prefix' => 'general'], function () {
    Route::get('/roles', 'GeneralController@roles');
    Route::post('/delete_usuario', 'GeneralController@deleteUsuario');
    Route::get('/obtenerTramites/{id}', 'GeneralController@obtener');
});


Route::group(['prefix' => 'gestores'], function () {
    Route::get('/', array('uses' => 'GestorController@index'))->name('gestor_index')->middleware("permiso");
    Route::post('/consultar', array('uses' => 'GestorController@consultar'))->name('gestor_consultar');
    Route::get('/configurar_tramite/{tramiteID}/{tramiteIDConfig}', array('uses' => 'GestorController@configurar_tramite'))->name("gestor_configurar_tramite");
    Route::get('/detalle_configuracion_tramite/{tramiteID}/{tramiteIDConfig}', array('uses' => 'GestorController@detalle_configuracion_tramite'))->name("detalle_configuracion_tramite");
    Route::get('/consultar_tramite/{tramiteID}/{tramiteIDConfig}', array('uses' => 'GestorController@consultar_tramite'))->name("gestor_consultar_tramite");

    Route::group(['prefix' => 'configuracion'], function () {
        Route::get('/seccion_formulario', array('uses' => 'GestorController@view_formulario'))->name("seccion_formulario");
        Route::get('/seccion_revision', array('uses' => 'GestorController@view_revision'))->name("seccion_revision");
        Route::get('/seccion_cita', array('uses' => 'GestorController@view_cita'))->name("seccion_cita");
        Route::get('/seccion_ventanilla', array('uses' => 'GestorController@view_ventanilla'))->name("seccion_ventanilla");
        Route::get('/seccion_pago', array('uses' => 'GestorController@view_pago'))->name("seccion_pago");
        Route::get('/seccion_analisis_interno', array('uses' => 'GestorController@view_analisis_modulo_interno'))->name("seccion_analisis_interno");
        Route::get('/seccion_resolutivo', array('uses' => 'GestorController@view_resolutivo'))->name("seccion_resolutivo");
    });

    Route::get('/consultar_formulario', array('uses' => 'GestorController@consultar_formulario'))->name("gestor_consultar_formulario");
    Route::get('/consultar_documento_tramite/{IntTramite}', array('uses' => 'GestorController@consultar_documento_tramite'))->name("gestor_consultar_documento_tramite");
    Route::post('/crear', array('uses' => 'GestorController@save'))->name('gestor_crear_configuracion');
    Route::get('/consultar_configuracion_tramite/{TRAM_NIDTRAMITE_CONFIG}', array('uses' => 'GestorController@consultar_configuracion_tramite'))->name("consultar_configuracion_tramite");
    Route::get('/implementar_tramite/{TRAM_NIDTRAMITE_CONFIG}/{TRAM_NIMPLEMENTADO}', array('uses' => 'GestorController@implementar_tramite'))->name("implementar_tramite");
    Route::get('/consultar_concepto_pago/{TRAM_NIDTRAMITE_ACCEDE}', array('uses' => 'GestorController@consultar_concepto_pago'))->name("consultar_concepto_pago");
    Route::get('/consultar_filtro', array('uses' => 'GestorController@obtener_filtro'))->name("consultar_filtro_gestores");
    Route::get('/consultar_resolutivo', array('uses' => 'GestorController@consultar_resolutivo'))->name("consultar_resolutivo");
    Route::get('/consultar_preguntas_formulario', array('uses' => 'GestorController@consultar_preguntas_formulario'))->name("consultar_preguntas_formulario");
    Route::get('/formulario', array('uses' => 'GestorController@formulario'))->name("formulario_gestor");

    Route::get('/detalleTramite/{id}', 'GestorController@detalleTramite');
});

Route::group(['prefix' => 'servidorespublicos'], function () {
    Route::get('/', array('uses' => 'ServidorPublicoController@index'))->middleware("permiso");
    Route::get('/listar', array('uses' => 'ServidorPublicoController@listar'));
    Route::get('/consultar', array('uses' => 'ServidorPublicoController@consultar'));
    Route::get('/crear', array('uses' => 'ServidorPublicoController@crear'));
    Route::post('/agregar', array('uses' => 'ServidorPublicoController@agregar'));
    Route::get('/editar/{id}', array('uses' => 'ServidorPublicoController@editar'));
    Route::post('/modificar', array('uses' => 'ServidorPublicoController@modificar'));
    Route::get('/detalle/{id}', array('uses' => 'ServidorPublicoController@detalle'));
    Route::get('/validar_correo/{StrCorreo}', array('uses' => 'ServidorPublicoController@validar_correo'));
    
    //Rutas Funcionarios
    Route::get('/getDepencencias', array('uses' => 'ServidorPublicoController@getDepencencias'));
    Route::get('/getUnity', array('uses' => 'ServidorPublicoController@getUnity'));
    Route::get('/getTramites', array('uses' => 'ServidorPublicoController@getTramites'));
    Route::get('/getEdificios', array('uses' => 'ServidorPublicoController@getEdificios'));
});

Route::get('/edificios', array('uses' => 'DatosDurosController@edificios'));
Route::get('/unidades_administrativas/{id}', array('uses' => 'DatosDurosController@unidades_administrativas'));
Route::get('/dependencias', array('uses' => 'DatosDurosController@dependencias'));
Route::get('/tramites/{id}', array('uses' => 'DatosDurosController@tramites'));


Route::post('/encrypt', array('uses' => 'DatosDurosController@encrypt'));
Route::get('/decrypt/{text}', array('uses' => 'DatosDurosController@decrypt'));

Route::get('/reportes', 'GenerarReportes@index')->middleware("permiso");
Route::get('/generar', 'GenerarReportes@gentreporte');

Route::post('/validar_pago_queretaro', 'TramiteServicioController@validarPagoQueretaro');


/**
 * Rutas Manuel Euan
 */
Route::group(['prefix' => 'citas'], function () {
    Route::get('/calendario', 'CitasController@calendario');
    Route::get('/agenda', 'CitasController@agenda');
    Route::get('/listado', 'CitasController@getListado');
});

Route::group(['prefix' => 'giros'], function () {
    Route::get('/find', 'GiroController@find');
    Route::get('/get', 'GiroController@get');
    Route::get('/', 'GiroController@index');
    Route::post('/', 'GiroController@store');
    Route::post('/estatus', 'GiroController@cambiaEstatus');
    Route::put('/', 'GiroController@update');
});

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
    /* Route::get('/', 'CatalogoController@index');
    Route::post('/', 'CatalogoController@store');
    Route::post('/estatus', 'CatalogoController@cambiaEstatus');
    Route::put('/', 'CatalogoController@update'); */
});