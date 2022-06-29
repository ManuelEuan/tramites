<?php

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
Route::get('/registrar/validar_curp/{StrCurp}', array('uses' => 'RegistroController@validar_curp'));
Route::get('/registrar/validar_correo/{StrCorreo}', array('uses' => 'RegistroController@validar_correo'));
Route::get('/registrar/localidades/{Strlocalidad}',array('uses' => 'RegistroController@localidades'));
Route::get('/registrar/estados',array('uses' => 'RegistroController@estados'));
Route::get('/registrar/municipios',array('uses' => 'RegistroController@municipios'));


Route::get('/perfil', array('uses' => 'PerfilController@index'));
Route::post('/perfil/modificar', array('uses' => 'PerfilController@modificar'));
Route::post('/perfil/confirmar', array('uses' => 'PerfilController@confirmar'));
Route::post('/perfil/confirmarServidor', array('uses' => 'PerfilController@confirmarServidor'));

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

Route::get('/tramite_servicio', array('uses' => 'TramiteServicioController@index'))->middleware("permiso");
Route::post('/tramite_servicio/consultar', array('uses' => 'TramiteServicioController@consultar'))->name('consultar_tramites');;
Route::get('/tramite_servicio/obtener_dependencias_unidad', array('uses' => 'TramiteServicioController@obtener_dependencias_unidad'));
Route::get('/tramite_servicio/obtener_modalidad', array('uses' => 'TramiteServicioController@obtener_modalidad'));
Route::get('/tramite_servicio/obtener_clasificacion', array('uses' => 'TramiteServicioController@obtener_clasificacion'));
Route::get('/tramite_servicio/obtener_audiencia', array('uses' => 'TramiteServicioController@obtener_audiencia'));
Route::get('/tramite_servicio/detalle_tramite/{id}', array('uses' => 'TramiteServicioController@obtener_detalle_tramite'))->name('detalle_tramite');
Route::get('/tramite_servicio/iniciar_tramite_servicio/{id}', array('uses' => 'TramiteServicioController@iniciar_tramite_servicio'));
Route::get('/tramite_servicio/obtener_municipio/{id}', array('uses' => 'TramiteServicioController@obtener_municipio'))->name('//');
Route::get('/tramite_servicio/obtener_modulo/{id}/{idaccede}', array('uses' => 'TramiteServicioController@obtener_modulo'))->name('iniciar_tramite_obtener_modulo');
Route::get('/tramite_servicio/obtener_modulo_detalle/{id}', array('uses' => 'TramiteServicioController@obtener_modulo_detalle'))->name('obtener_modulo_detalle');
Route::post('/tramite_servicio/guardar', array('uses' => 'TramiteServicioController@guardar'))->name('guardar_tramites');
Route::post('/tramite_servicio/enviar', array('uses' => 'TramiteServicioController@enviar'))->name('enviar_tramites');
Route::post('/tramite_servicio/subir_documento', array('uses' => 'TramiteServicioController@subir_documento'))->name('subir_documento');
Route::post('/tramite_servicio/enviar_documentos', array('uses' => 'TramiteServicioController@enviar_documentos'))->name('enviar_documentos');
Route::post('/tramite_servicio/reenviar', array('uses' => 'TramiteServicioController@reenviar'))->name('reenviar_tramites');
Route::get('/tramite_servicio/consultar_detalle_notificacion/{id}', array('uses' => 'TramiteServicioController@consultar_detalle_notificacion'))->name('consultar_detalle_notificacion');
Route::get('/tramite_servicio/atencion_notificacion_seguimiento/{id}/{noti}', array('uses' => 'TramiteServicioController@atencion_notificacion_seguimiento'))->name('atencion_notificacion_seguimiento');
Route::post('/tramite_servicio/enviar_encuesta', array('uses' => 'TramiteServicioController@enviar_encuesta'))->name('enviar_encuesta');
Route::get('/download_tramite_detalle/{id}', 'TramiteServicioController@download_tramite_detalle')->name('download_tramite_detalle');
Route::get('/consultar_pago/{id}', 'TramiteServicioController@consultar_pago')->name('consultar_pago');


Route::get('/seguimiento_solicitud', array('uses' => 'SeguimientoSolicitudController@index'))->middleware("permiso");
Route::post('/seguimiento/consultar', array('uses' => 'SeguimientoSolicitudController@consultar'));
Route::get('/seguimiento/obtener_dependencias_unidad', array('uses' => 'SeguimientoSolicitudController@obtener_dependencias_unidad'));
Route::get('/seguimiento/detalle_seguimiento/{id}', array('uses' => 'SeguimientoSolicitudController@obtener_detalle_seguimiento'))->name('detalle_seguimiento');
Route::get('/seguimiento/detalle_notificacion/{id}', array('uses' => 'SeguimientoSolicitudController@detalle_notificacion'))->name("detalle_notificacion");
Route::get('/seguimiento/consultar_ventanilla/{id}', array('uses' => 'SeguimientoSolicitudController@consultar_ventanilla'))->name("consultar_ventanilla");
Route::get('/seguimiento/consultar_cita/{id}', array('uses' => 'SeguimientoSolicitudController@consultar_cita'))->name("consultar_cita");
Route::get('/seguimiento/conexion', array('uses' => 'SeguimientoSolicitudController@conexion'))->name("conexion");
Route::get('/tramite_servicio/seguimiento_tramite/{id}', array('uses' => 'TramiteServicioController@seguimiento_tramite_servicio'))->name('seguimiento_tramite');
Route::put('/tramite_servicio/ubicacion_ventanilla', array('uses' => 'TramiteServicioController@ubicacion_ventanilla_sin_cita'))->name('ubicacion_ventanilla_sin_cita');

Route::group(['prefix' => 'tramite_servicio_cemr'], function () {
    Route::get('/', 'TramitesController@listado');
    Route::post('/find', 'TramitesController@find');
    Route::get('/detalle/{id}', 'TramitesController@detalle');
    Route::get('/seguimiento/{id}', 'TramitesController@seguimiento')->name('seguimiento_tramite_servidor');
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
    Route::post('/seccion_emitir_resolutivo', 'TramitesController@emitir_resolutivo')->name("seccion_emitir_resolutivo");
    Route::post('/seccion_rechazar_tramite', 'TramitesController@rechazar_tramite')->name("rechazar_tramite");
    Route::post('/guardar_conceptos', 'TramitesController@guardar_conceptos')->name("guardar_conceptos");
    Route::get('/download_tramite/{id}', 'TramitesController@download_tramite')->name('download_tramite');
    Route::get('/seccion_actualizar_pago/{id}', 'GestorController@actualizar_pago')->name('actualizar_pago');
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

Route::group(['prefix' => 'dias_inhabiles'], function () {
    Route::get('/', 'DiaInhabilController@calendario');
    Route::get('/find', 'DiaInhabilController@find');
    Route::post('/store', 'DiaInhabilController@store');
    Route::post('/update', 'DiaInhabilController@update');
    Route::post('/delete', 'DiaInhabilController@delete');
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
    Route::post('/status', 'PersonaController@status');
    Route::post('/update', 'PersonaController@update');
});

Route::group(['prefix' => 'notificaciones'], function () {
    Route::post('/', 'NotificacionController@getNotificaciones');
});

Route::group(['prefix' => 'general'], function () {
    Route::get('/roles', 'GeneralController@roles');
    Route::get('/dependencias', 'GeneralController@dependencias');
    Route::get('/tramites', 'GeneralController@tramites');
    Route::get('/edificios', 'GeneralController@edificios');
    Route::get('/unidades_administrativas', 'GeneralController@unidades_administrativas');

    Route::get('/usuarios', 'GeneralController@usuarios');
    Route::post('/delete_usuario', 'GeneralController@deleteUsuario');
    Route::get('/obtenerTramites/{id}', 'GeneralController@obtener');
});






Route::get('/gestores', array('uses' => 'GestorController@index'))->name('gestor_index')->middleware("permiso");
Route::post('/gestores/consultar', array('uses' => 'GestorController@consultar'))->name('gestor_consultar');
Route::get('/gestores/configurar_tramite/{tramiteID}/{tramiteIDConfig}', array('uses' => 'GestorController@configurar_tramite'))->name("gestor_configurar_tramite");
Route::get('/gestores/detalle_configuracion_tramite/{tramiteID}/{tramiteIDConfig}', array('uses' => 'GestorController@detalle_configuracion_tramite'))->name("detalle_configuracion_tramite");
Route::get('/gestores/consultar_tramite/{tramiteID}/{tramiteIDConfig}', array('uses' => 'GestorController@consultar_tramite'))->name("gestor_consultar_tramite");
Route::get('/gestores/configuracion/seccion_formulario', array('uses' => 'GestorController@view_formulario'))->name("seccion_formulario");
Route::get('/gestores/configuracion/seccion_revision', array('uses' => 'GestorController@view_revision'))->name("seccion_revision");
Route::get('/gestores/configuracion/seccion_cita', array('uses' => 'GestorController@view_cita'))->name("seccion_cita");
Route::get('/gestores/configuracion/seccion_ventanilla', array('uses' => 'GestorController@view_ventanilla'))->name("seccion_ventanilla");
Route::get('/gestores/configuracion/seccion_pago', array('uses' => 'GestorController@view_pago'))->name("seccion_pago");
Route::get('/gestores/configuracion/seccion_analisis_interno', array('uses' => 'GestorController@view_analisis_modulo_interno'))->name("seccion_analisis_interno");
Route::get('/gestores/configuracion/seccion_resolutivo', array('uses' => 'GestorController@view_resolutivo'))->name("seccion_resolutivo");
Route::get('/gestores/consultar_formulario', array('uses' => 'GestorController@consultar_formulario'))->name("gestor_consultar_formulario");
Route::get('/gestores/consultar_documento_tramite/{IntTramite}', array('uses' => 'GestorController@consultar_documento_tramite'))->name("gestor_consultar_documento_tramite");
Route::post('/gestores/crear', array('uses' => 'GestorController@save'))->name('gestor_crear_configuracion');
Route::get('/gestores/consultar_configuracion_tramite/{TRAM_NIDTRAMITE_CONFIG}', array('uses' => 'GestorController@consultar_configuracion_tramite'))->name("consultar_configuracion_tramite");
Route::get('/gestores/implementar_tramite/{TRAM_NIDTRAMITE_CONFIG}/{TRAM_NIMPLEMENTADO}', array('uses' => 'GestorController@implementar_tramite'))->name("implementar_tramite");
Route::get('/gestores/consultar_concepto_pago/{TRAM_NIDTRAMITE_ACCEDE}', array('uses' => 'GestorController@consultar_concepto_pago'))->name("consultar_concepto_pago");
Route::get('/gestores/consultar_filtro', array('uses' => 'GestorController@obtener_filtro'))->name("consultar_filtro_gestores");
Route::get('/gestores/set_json_value_tramite', array('uses' => 'GestorController@set_json_value_tramite'))->name("set_json_value_tramite");
Route::get('/gestores/consultar_resolutivo', array('uses' => 'GestorController@consultar_resolutivo'))->name("consultar_resolutivo");
Route::get('/gestores/unidad_administrativa/{id}', array('uses' => 'GestorController@unidad_administrativa'))->name("consultar_unidad_administrativa");
Route::get('/gestores/formulario', array('uses' => 'GestorController@formulario'))->name("formulario_gestor");


Route::get('/servidorespublicos', array('uses' => 'ServidorPublicoController@index'))->middleware("permiso");
Route::get('/servidorespublicos/consultar', array('uses' => 'ServidorPublicoController@consultar'));
Route::get('/servidorespublicos/crear', array('uses' => 'ServidorPublicoController@crear'));
Route::post('/servidorespublicos/agregar', array('uses' => 'ServidorPublicoController@agregar'));
Route::get('/servidorespublicos/editar/{id}', array('uses' => 'ServidorPublicoController@editar'));
Route::post('/servidorespublicos/modificar', array('uses' => 'ServidorPublicoController@modificar'));
Route::get('/servidorespublicos/detalle/{id}', array('uses' => 'ServidorPublicoController@detalle'));
Route::get('/servidorespublicos/validar_correo/{StrCorreo}', array('uses' => 'ServidorPublicoController@validar_correo'));

Route::get('/edificios', array('uses' => 'DatosDurosController@edificios'));
Route::get('/unidades_administrativas/{id}', array('uses' => 'DatosDurosController@unidades_administrativas'));
Route::get('/dependencias', array('uses' => 'DatosDurosController@dependencias'));
Route::get('/tramites/{id}', array('uses' => 'DatosDurosController@tramites'));


Route::post('/encrypt', array('uses' => 'DatosDurosController@encrypt'));
Route::get('/decrypt/{text}', array('uses' => 'DatosDurosController@decrypt'));

Route::get('/reportes', 'GenerarReportes@index')->middleware("permiso");
Route::get('/generar', 'GenerarReportes@gentreporte');
