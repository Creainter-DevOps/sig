<?php
use App\Http\Controllers\LanguageController;
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

Route::get('/', 'Auth\LoginController@index');
Route::get('identificacion', 'Auth\LoginController@login');
Route::post('identificacion', 'Auth\LoginController@login_check')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::match(['get', 'post'], '/', 'DashboardController@index')->name('dashboard');

/* Permissions */
Route::any('permissions', 'PermissionController@index');
Route::match(['get', 'post'], 'permissions/usuario/{aclusuario}/permisos', 'PermissionController@UsuarioPermisos');
Route::match(['get', 'post'], 'permissions/controlador/{controlador}/edit', 'PermissionController@ControladorEdit');
Route::match(['get', 'post'], 'permissions/controlador', 'PermissionController@crearControlador');
Route::match(['get', 'post'], 'permissions/grupo/{grupo}/edit', 'PermissionController@GrupoEdit');
Route::match(['get', 'post'], 'permissions/grupo/{aclgrupo}/permisos', 'PermissionController@GrupoPermisos');
Route::match(['get', 'post'], 'permissions/grupo', 'PermissionController@crearGrupo');
Route::get('permissions/autocomplete_modulo', 'PermissionController@autocomplete_modulo');

// dashboard Routes
Route::post('/dashboard/part/competencias', 'DashboardController@part_competencias');
Route::get('/dashboard-ecommerce','DashboardController@dashboardEcommerce');
Route::get('/dashboard-analytics','DashboardController@dashboardAnalytics');


Route::get('/static/seace2/{hash}','StaticController@seace');

Route::get('/contable','ContableController@index');
Route::get('/contable/pdf/facturas_por_cobrar','ContableController@facturas_por_cobrar');
Route::get('/contable/pdf/licitaciones_semanal','ContableController@licitaciones_semanal');
Route::get('/contable/pdf/proyectos_activos','ContableController@proyectos_activos');
Route::get('/contable/pdf/licitaciones_fechas','ContableController@licitaciones_fechas');

Route::get('entregables/autocomplete', 'EntregableController@autocomplete');
Route::resource('entregables', 'EntregableController');

Route::get('pagos/autocomplete', 'PagoController@autocomplete');
Route::resource('pagos', 'PagoController');

Route::get('ordenes/autocomplete', 'OrdenController@autocomplete');
Route::resource('ordenes', 'OrdenController')->parameters([
  'ordenes' => 'orden'
]);

//Route::resource('proyectos', 'ProyectoController');
Route::get('proyectos/autocomplete', 'ProyectoController@autocomplete'); 
Route::get('proyectos/porCliente/{cliente}', 'ProyectoController@porCliente')->name('proyecto.porCliente');
Route::post('proyectos/{proyecto}/observacion', 'ProyectoController@observacion'); 
Route::get('proyectos/{proyecto}/financiero', 'ProyectoController@financiero');
Route::get('proyectos/{proyecto}/pdf/situacion', 'ProyectoController@pdf_situacion');
Route::resource('proyectos', 'ProyectoController')->parameters([
    'proyectos' => 'proyecto'
  ]);

Route::get('empresas/fast','EmpresaController@fast');
Route::get('misempresas','EmpresaController@mis_empresas');
Route::get('misempresas/{empresa}','EmpresaController@datos');
Route::get('empresas/autocomplete', 'EmpresaController@autocomplete'); 
Route::get('empresas/tags','EmpresaController@tags');

Route::get('empresas/{empresa}/contactos','EmpresaController@contactos');
Route::post('empresas/{empresa}/imagen', 'EmpresaController@actualizar_imagen'); 
Route::get('empresas/{empresa}/tags','EmpresaController@tags_empresa');
Route::post('empresas/tag/nuevo','EmpresaController@tagCreate');
Route::get('empresas/{empresa}/firmas/eliminar','EmpresaController@firmas_eliminar');
Route::get('empresas/{empresa}/sellos/eliminar','EmpresaController@sellos_eliminar');
Route::post('empresas/tag/eliminar','EmpresaController@tagDelete');
Route::post('empresas/{empresa}/firmas/procesar','EmpresaController@firmas_sellos_procesar');
Route::post('empresas/{empresa}/sellos/procesar','EmpresaController@firmas_sellos_procesar');
Route::resource('empresas','EmpresaController')->parameters([ 
  'empresas' => 'empresa'
]);

Route::get('usuarios/autocomplete', 'UsuarioController@autocomplete'); 


Route::get('usuarios/perfil/crear','UsuarioController@crear_perfil');
Route::get('usuarios/perfil/{perfil}/editar','UsuarioController@editar_perfil');
Route::delete('usuarios/perfil/{perfil}/eliminar','UsuarioController@eliminar_perfil');
Route::post('usuarios/perfil','UsuarioController@perfil_store')->name('perfil_store');
Route::resource('usuarios','UsuarioController')->parameters([ 
  'usuarios' => 'usuario'
]);

Route::get('bloques/autocomplete', 'BloqueController@autocomplete');


Route::resource('bloques', 'BloqueController')->parameters([ 
  'bloques' => 'bloque'
]);

Route::get('callerids/autocomplete', 'CalleridController@autocomplete');
Route::resource('callerids', 'CalleridController')->parameters([ 
  'callerids' => 'callerid'
]);

Route::get('/kanban', 'KanbanController@index');
Route::get('/kanban/actividades', 'KanbanController@actividades');
Route::post('actividades/timeline', 'ActividadController@timeline');
Route::get('actividades/autocomplete', 'ActividadController@autocomplete');
Route::post('actividades/proxy/calls', 'ActividadController@proxy_calls');


Route::get('actividades/json/pendiente/get', 'ActividadController@pendiente_get');
Route::post('actividades/json/pendiente/accion', 'ActividadController@pendiente_accion');

Route::get('actividades/kanban', 'ActividadController@kanban');
Route::post('actividades/kanban/create', 'ActividadController@kanban_create');
Route::post('actividades/kanban/:actividad', 'ActividadController@kanban_edit');
Route::get('actividades/kanban/json', 'ActividadController@kanban_data');

Route::get('actividades/calendario','ActividadController@calendario');
Route::post('actividades/calendario/json', 'ActividadController@calendario_data');
Route::post('actividades/calendario/proyectos/json', 'ActividadController@calendario_proyectos');

Route::post('actividades/listado_ajax', 'ActividadController@listado_ajax');
Route::post('actividades/{actividad}/observacion', 'ActividadController@observacion'); 
Route::resource('actividades', 'ActividadController')->parameters([
    'actividades' => 'actividad'
]);

Route::get('clientes/autocomplete', 'ClienteController@autocomplete');
Route::post('clientes/{cliente}/observacion', 'ClienteController@observacion');
Route::resource('clientes', 'ClienteController');
Route::post('clientes/{cliente}/add-representante', 'ClienteController@addRepresentante');
Route::get('clientes/{cliente}/del-representante/{contacto}', 'ClienteController@delRepresentante');
Route::post('clientes/{cliente}/add-producto', 'ClienteController@addProducto');
Route::get('clientes/{cliente}/del-producto/{producto}', 'ClienteController@delProducto');
Route::get('clientes/{cliente}/registrar-producto', 'ClienteController@registarProducto');
Route::post('clientes/getProvincias', 'ClienteController@getProvincias');
Route::post('clientes/getDistritos', 'ClienteController@getDistritos');



Route::post('proveedor/save/producto', 'ProveedorController@saveproducto')->name('proveedor.saveproducto');
Route::get('proveedores/{proveedor}/productos','ProveedorController@productos')->name('proveedores.productos');
Route::resource('proveedores', 'ProveedorController')->parameters([
  'proveedores' => 'proveedor'
]);

Route::post('contactos/call_autocomplete', 'ContactoController@call_autocomplete');
Route::get('contactos/autocomplete', 'ContactoController@autocomplete');
Route::post('contactos/{contacto}/observacion', 'ContactoController@observacion');
Route::resource('contactos', 'ContactoController')->parameters([
    'contactos' => 'contacto'
]);

Route::get('productos/autocomplete', 'ProductoController@autocomplete');
Route::resource('productos', 'ProductoController')->parameters([
  'productos' => 'producto'
]);

Route::get('cartas/{carta}/expediente', 'CartaController@expediente')->name('cartas.expediente');
Route::get('carta/autocomplete', 'CartaController@autocomplete');
Route::resource('cartas', 'CartaController')->parameters([
  'cartas' => 'carta'
]);

Route::get('reportes', 'ReporteController@index');
Route::post('reportes/actividad/pdf/listado', 'ReporteController@pdf_actividad_listado')->name('reporte.actividad.listado');
Route::get('reportes/licitacion/participaciones', 'ReporteController@licitacion_participaciones');
Route::get('reportes/usuarios', 'ReporteController@usuarios');
Route::get('reportes/usuarios/descargar', 'ReporteController@descargar_reporte');
//Route::get('reportes/usuarios', 'ReporteController@index');

Route::get('actas/autocomplete', 'ActaController@autocomplete');
Route::resource('actas', 'ActaController')->parameters([
  'actas' => 'acta'
]);

Route::get('movil', 'LicitacionController@movil');


Route::get('expediente/{cotizacion}/generar','ExpedienteController@generar');
Route::post('expediente/{cotizacion}/ordenar','ExpedienteController@actualizar_orden');

Route::get('expediente/{cotizacion}/paso01','ExpedienteController@paso01');
Route::post('expediente/{cotizacion}/paso01','ExpedienteController@paso01_store')->name('expediente.paso01');

Route::get('expediente/{cotizacion}/paso02','ExpedienteController@paso02');
Route::post('expediente/{cotizacion}/paso02','ExpedienteController@paso02_store')->name('expediente.paso02');

Route::get('expediente/{cotizacion}/paso03','ExpedienteController@paso03');
Route::post('expediente/{cotizacion}/paso03','ExpedienteController@paso03_store')->name('expediente.paso03');

Route::get('expediente/{cotizacion}/paso04','ExpedienteController@paso04');

Route::post('expediente/{cotizacion}/paso04','ExpedienteController@paso04_store')->name('expediente.paso04');
Route::get('expediente/{cotizacion}/cancelar_proceso','ExpedienteController@cancelar_proceso');

Route::get('expediente/{cotizacion}/visualizar', 'ExpedienteController@visualizar_documento');

Route::get('expediente/{cotizacion}/temporal', 'ExpedienteController@descargarTemporal');
Route::get('expediente/{cotizacion}/temporal/uri/{file}', 'ExpedienteController@descargarTemporal2');
Route::post('expediente/{cotizacion}/estampar', 'ExpedienteController@estamparDocumento');
Route::post('expediente/{cotizacion}/parallelStatus','ExpedienteController@parallelStatus');
Route::post('expediente/{cotizacion}/actualizar','ExpedienteController@actualizar');
Route::get('expediente/{cotizacion}/generarImagen','ExpedienteController@generarImagen');
Route::post('expediente/{cotizacion}/custom','ExpedienteController@custom_store')->name('expediente.custom');
Route::post('expediente/{cotizacion}/eliminarDocumento','ExpedienteController@eliminarDocumento')->name('expediente.eliminarDocumento');

Route::get('documentos/{documento}/visualizar', 'DocumentoController@visualizar_documento');
Route::get('expediente/{cotizacion}/inicio','ExpedienteController@inicio')->name('expediente.inicio');
Route::post('expediente/{cotizacion}/inicio','ExpedienteController@inicio_store');
Route::post('expediente/{cotizacion}/busquedaDocumentos','ExpedienteController@busquedaDocumentos')->name('expediente.busquedaDocumentos');

Route::resource('expediente', 'ExpedienteController')->parameters([
  'expediente' => 'expediente'
]);

Route::get('etiquetas/{etiqueta}/aprobar','EtiquetaController@aprobar')->name('etiqueta.aprobar');
Route::get('etiquetas/{etiqueta}/rechazar','EtiquetaController@rechazar')->name('etiqueta.rechazar');

Route::resource('etiquetas', 'EtiquetaController')->parameters([
  'etiquetas' => 'etiqueta'
]);

Route::get('callcenter/llamadas','VoipController@llamadas');
Route::get('callcenter/llamadas/audios','VoipController@audios');
Route::post('callcenter/llamadas/render_audios','VoipController@render_audios');

Route::get('documentos/explorer','DocumentoController@explorer');
Route::post('documentos/{documento}/parallelStatus','DocumentoController@parallelStatus');
Route::post('documentos/{documento}/agregarDocumento/{doc}','DocumentoController@agregarDocumento');
Route::get('documentos/nuevo','DocumentoController@form_nuevo');
//Route::get('documentos/{documento}/generarImagen/{$cotizacion}','DocumentoController@generarImagen');

//Route::get('documentos/{documento}/expediente/inicio','DocumentoController@expediente_inicio');
//Route::post('documentos/{documento}/expediente/inicio','DocumentoController@expediente_inicio')->name("documento.expediente_inicio");
Route::get('documentos/{documento}/expediente/inicio','DocumentoController@expediente_inicio')->name("documento.expediente_inicio");
Route::post('documentos/{documento}/expediente/inicio','DocumentoController@expediente_inicio_store')->name("documento.expediente_inicio_store");
Route::get('documentos/{documento}/expediente/paso01','DocumentoController@expediente_paso01')->name("documento.expediente_paso01");
Route::post('documentos/{documento}/expediente/paso01','DocumentoController@expediente_paso01_store')->name("documento.expediente_paso01_store");
Route::get('documentos/{documento}/expediente/paso02','DocumentoController@expediente_paso02')->name("documento.expediente_paso02");
Route::post('documentos/{documento}/expediente/paso02','DocumentoController@expediente_paso02_store')->name("documento.expediente_paso02_store");
Route::get('documentos/{documento}/expediente/paso03','DocumentoController@expediente_paso03')->name("documento.expediente_paso03");
Route::post('documentos/{documento}/expediente/paso03','DocumentoController@expediente_paso03_store')->name("documento.expediente_paso03_store");
Route::post('documentos/{documento}/expediente/paso03/revisar','DocumentoController@expediente_paso03_revisar')->name("documento.expediente_paso03_revisar");
Route::get('documentos/{documento}/expediente/paso04','DocumentoController@expediente_paso04')->name("documento.expediente_paso04");
Route::post('documentos/{documento}/expediente/paso04','DocumentoController@expediente_paso04_store')->name("documento.expediente_paso04_store");
Route::get('documentos/{documento}/expediente/pendiente','DocumentoController@expediente_pendiente')->name("documento.expediente_pendiente");
Route::post('documentos/{documento}/expediente/respaldar','DocumentoController@expediente_respaldar')->name("documento.expediente_respaldar");
Route::post('documentos/{documento}/expediente/restaurar','DocumentoController@expediente_restaurar')->name("documento.expediente_restaurar");

Route::post('documentos/{documento}/expediente/observar','DocumentoController@expediente_observar')->name("documento.expediente_observar");
Route::post('documentos/{documento}/expediente/aprobar','DocumentoController@expediente_aprobar')->name("documento.expediente_aprobar");
Route::post('documentos/{documento}/expediente/reanudar','DocumentoController@expediente_reanudar')->name("documento.expediente_reanudar");

Route::get('documentos/{documento}/expediente/cancelar_proceso','DocumentoController@expediente_cancelar_proceso')->name("documento.expediente_cancelar_proceso");
Route::post('documentos/{documento}/expediente/upload', 'DocumentoController@expediente_upload')->name('documentos.expediente_upload');
Route::post('documentos/{documento}/expediente/actualizar','DocumentoController@expediente_actualizar');

Route::get('documentos/{documento}/generarImagenTemporal','DocumentoController@generarImagenTemporal');
Route::get('documentos/{documento}/generarImagen','DocumentoController@generarImagen');
Route::get('documentos/{documento}/descargarParte','DocumentoController@descargarParte');


Route::get('documentos/{documento}/downloadDirectory','DocumentoController@downloadDirectory');
Route::post('documentos/{documento}/ordenar','DocumentoController@actualizar_orden');
Route::post('documentos/{documento}/estampar', 'DocumentoController@estamparDocumento');
Route::post('documentos/{documento}/eliminarEstampa', 'DocumentoController@eliminarFirmas');
Route::post('documentos/{documento}/eliminarDocumento','DocumentoController@eliminarDocumento')->name('documento.eliminarDocumento');
Route::post('documentos/{documento}/regenerarDocumento','DocumentoController@regenerarDocumento')->name('documento.regenerarDocumento');
Route::get('documentos/filestore', 'DocumentoController@filestore')->name('documentos.filestore');
Route::post('documentos/crearExpediente', 'DocumentoController@crearExpediente')->name('documentos.crearExpediente');
Route::get('documentos/{documento}/expediente', 'DocumentoController@expediente')->name('documentos.expediente');
Route::get('documentos/visor', 'DocumentoController@visor')->name('documentos.visor');
Route::post('documentos/ajax/get', 'DocumentoController@ajax_get')->name('documentos.ajax_get');
Route::post('documentos/ajax/upload', 'DocumentoController@ajax_upload')->name('documentos.ajax_upload');
Route::post('documentos/{documento}/buscar', 'DocumentoController@buscar')->name('documentos.buscar');
Route::resource('documentos', 'DocumentoController')->parameters([
  'documentos' => 'documento'
]);

Route::get('personales/autocomplete','PersonalController@autocomplete');
Route::resource('personales', 'PersonalController')->parameters([
  'personales' => 'personal'
]);

Route::post('cotizaciones/{cotizacion}/registrar', 'CotizacionController@registrar_store')->name('cotizacion.registrar_store');
Route::get('cotizaciones/{cotizacion}/registrar', 'CotizacionController@registrar')->name('cotizacion.registrar');

Route::get('cotizaciones/autocomplete', 'CotizacionController@autocomplete');
Route::post('cotizaciones/{cotizacion}/registrarParticipacion','CotizacionController@registrarParticipacion');
Route::post('cotizaciones/{cotizacion}/registrarPropuesta','CotizacionController@registrarPropuesta');
Route::post('cotizaciones/{cotizacion}/registrarSubsanacion','CotizacionController@registrarSubsanacion');
Route::get('cotizaciones/{cotizacion}/expediente', 'CotizacionController@expediente')->name('cotizacion.expediente');
Route::get('cotizaciones/{cotizacion}/expediente_subsanacion', 'CotizacionController@expediente_subsanacion')->name('cotizacion.expediente_subsanacion');
Route::get('cotizaciones/{cotizacion}/subsanaciones', 'CotizacionController@subsanaciones')->name('cotizacion.subsanaciones');
Route::get('cotizaciones/{cotizacion}/proyecto','CotizacionController@proyecto')->name( 'oportunidad.proyecto' );
Route::post('cotizaciones/{cotizacion}/observacion', 'CotizacionController@observacion');
Route::post('cotizaciones/{cotizacion}/proyecto', 'CotizacionController@proyecto')->name('cotizaciones.proyecto');
Route::get('cotizaciones/{cotizacion}/exportar', 'CotizacionController@exportar')->name('cotizacion.exportar');
Route::post('cotizaciones/{cotizacion}/exportar_repositorio', 'CotizacionController@exportar_repositorio')->name('cotizacion.exportar_repositorio');
Route::get('cotizaciones/{cotizacion}/detalle', 'CotizacionController@detalle')->name('cotizacion.detalle');
Route::post('cotizaciones/{cotizacion}/detalle', 'CotizacionController@detallesave');
Route::post('cotizaciones/{cotizacion}/enviarPorCorreo', 'CotizacionController@enviarPorCorreo')->name('cotizacion.enviarPorCorreo');
Route::resource('cotizaciones', 'CotizacionController')->parameters([
  'cotizaciones' => 'cotizacion'
]);


Route::get('subsanaciones/{subsanacion}/expediente', 'SubsanacionController@expediente')->name('subsanacion.expediente');
Route::resource('subsanaciones', 'SubsanacionController')->parameters([
  'subsanaciones' => 'subsanacion',
]);



Route::get('oportunidades/porEmpresa/{empresa}', 'OportunidadController@porEmpresa')->name('oportunidad.porEmpresa');
Route::post('oportunidades/{oportunidad}/part/licitaciones_similares','OportunidadController@part_licitaciones_similares');
Route::post('oportunidades/{oportunidad}/part/oportunidades_similares','OportunidadController@part_oportunidades_similares');
Route::post('oportunidades/{oportunidad}/favorito','OportunidadController@favorito');
Route::post('oportunidades/{oportunidad}/aprobar','OportunidadController@aprobar');
Route::post('oportunidades/{oportunidad}/rechazar','OportunidadController@rechazar');
Route::post('oportunidades/{oportunidad}/archivar','OportunidadController@archivar');
Route::post('oportunidades/{oportunidad}/revisar','OportunidadController@revisar');
Route::post('oportunidades/{oportunidad}/interes/{empresa}','OportunidadController@interes');
Route::get('oportunidades/autocomplete','OportunidadController@autocomplete');
Route::get('oportunidades/autocomplete_codigo','OportunidadController@search_codigo');
Route::get('oportunidades/{oportunidad}/cerrar','OportunidadController@cerrar')->name('oportunidades.cerrar');

Route::resource('oportunidades', 'OportunidadController')->parameters([
  'oportunidades' => 'oportunidad'
]);

Route::get('licitaciones/autocomplete','LicitacionController@autocomplete');
Route::post('licitaciones/actualizar/{oportunidad}','LicitacionController@update')->name("licitacion.update");
Route::get('licitaciones/calendario','LicitacionController@calendario');
Route::post('licitaciones/nuevas/mas','LicitacionController@listNuevasMas');
Route::get('licitaciones/workspace','LicitacionController@workspace');
Route::get('licitaciones/participaciones','LicitacionController@participaciones');
Route::get('licitaciones/resultados','LicitacionController@resultados');
Route::get('licitaciones/nuevas','LicitacionController@listNuevas');
Route::get('licitaciones/archivadas','LicitacionController@listArchivadas');
Route::get('licitaciones/eliminadas','LicitacionController@listEliminadas');
Route::get('licitaciones/aprobadas','LicitacionController@listAprobadas');
Route::post('licitaciones/part/avance_expedientes','LicitacionController@part_avance_expedientes');
Route::get('licitaciones/{licitacion}/detalles','LicitacionController@show');
Route::get('licitaciones/{licitacion}/actualizar','LicitacionController@actualizar')->name('licitacion.actualizar');
Route::post('licitaciones/{licitacion}/aprobar/{empresa}','LicitacionController@aprobar_interes');
Route::post('licitaciones/{licitacion}/aprobar','LicitacionController@aprobar');
Route::post('licitaciones/{licitacion}/rechazar','LicitacionController@rechazar');
Route::post('licitaciones/{licitacion}/observacion','LicitacionController@observacion');
Route::resource('licitaciones', 'LicitacionController')->parameters([
  'licitaciones' => 'licitacion'
]);

Route::get('mini','MiniController@index');
Route::get('mini/licitaciones','MiniController@licitaciones');
Route::get('mini/etiquetas/nuevas','MiniController@etiquetas_nuevas');
Route::get('mini/etiquetas/solicitadas','MiniController@etiquetas_solicitadas');
Route::get('mini/oportunidades','MiniController@oportunidades');

Route::get('correos/{correo}/ver','CorreoController@ver')->name('correos.ver');
Route::resource('correos', 'CorreoController')->parameters([
  'correos' => 'correo'
]);

//Application Routes
Route::get('/app-email','ApplicationController@emailApplication');
Route::get('/app-chat','ApplicationController@chatApplication');
Route::get('/app-todo','ApplicationController@todoApplication');
Route::get('/app-calendar','ApplicationController@calendarApplication');
Route::get('/app-kanban','ApplicationController@kanbanApplication');
Route::get('/app-invoice-view','ApplicationController@invoiceApplication');
Route::get('/app-invoice-list','ApplicationController@invoiceListApplication');
Route::get('/app-invoice-edit','ApplicationController@invoiceEditApplication');
Route::get('/app-invoice-add','ApplicationController@invoiceAddApplication');
Route::get('/app-file-manager','ApplicationController@fileManagerApplication');

// Content Page Routes
Route::get('/content-grid','ContentController@gridContent');
Route::get('/content-typography','ContentController@typographyContent');
Route::get('/content-text-utilities','ContentController@textUtilitiesContent');
Route::get('/content-syntax-highlighter','ContentController@contentSyntaxHighlighter');
Route::get('/content-helper-classes','ContentController@contentHelperClasses');
Route::get('/colors','ContentController@colorContent');
// icons
Route::get('/icons-livicons','IconsController@liveIcons');
Route::get('/icons-boxicons','IconsController@boxIcons');
// card
Route::get('/card-basic','CardController@basicCard');
Route::get('/card-actions','CardController@actionCard');
Route::get('/widgets','CardController@widgets');
// component route
Route::get('/component-alerts','ComponentController@alertComponenet');
Route::get('/component-buttons-basic','ComponentController@buttonComponenet');
Route::get('/component-breadcrumbs','ComponentController@breadcrumbsComponenet');
Route::get('/component-carousel','ComponentController@carouselComponenet');
Route::get('/component-collapse','ComponentController@collapseComponenet');
Route::get('/component-dropdowns','ComponentController@dropdownComponenet');
Route::get('/component-list-group','ComponentController@listGroupComponenet');
Route::get('/component-modals','ComponentController@modalComponenet');
Route::get('/component-pagination','ComponentController@paginationComponenet');
Route::get('/component-navbar','ComponentController@navbarComponenet');
Route::get('/component-tabs-component','ComponentController@tabsComponenet');
Route::get('/component-pills-component','ComponentController@pillComponenet');
Route::get('/component-tooltips','ComponentController@tooltipsComponenet');
Route::get('/component-popovers','ComponentController@popoversComponenet');
Route::get('/component-badges','ComponentController@badgesComponenet');
Route::get('/component-pill-badges','ComponentController@pillBadgesComponenet');
Route::get('/component-progress','ComponentController@progressComponenet');
Route::get('/component-media-objects','ComponentController@mediaObjectComponenet');
Route::get('/component-spinner','ComponentController@spinnerComponenet');
Route::get('/component-bs-toast','ComponentController@toastsComponenet');
// extra component
Route::get('/ex-component-avatar','ExComponentController@avatarComponent');
Route::get('/ex-component-chips','ExComponentController@chipsComponent');
Route::get('/ex-component-divider','ExComponentController@dividerComponent');
// form elements
Route::get('/form-inputs','FormController@inputForm');
Route::get('/form-input-groups','FormController@inputGroupForm');
Route::get('/form-number-input','FormController@numberInputForm');
Route::get('/form-select','FormController@selectForm');
Route::get('/form-radio','FormController@radioForm');
Route::get('/form-checkbox','FormController@checkboxForm');
Route::get('/form-switch','FormController@switchForm');
Route::get('/form-textarea','FormController@textareaForm');
Route::get('/form-quill-editor','FormController@quillEditorForm');
Route::get('/form-file-uploader','FormController@fileUploaderForm');
Route::get('/form-date-time-picker','FormController@datePickerForm');
Route::get('/form-layout','FormController@formLayout');
Route::get('/form-wizard','FormController@formWizard');
Route::get('/form-validation','FormController@formValidation');
Route::get('/form-repeater','FormController@formRepeater');
// table route
Route::get('/table','TableController@basicTable');
Route::get('/extended','TableController@extendedTable');
Route::get('/datatable','TableController@dataTable');
// page Route
Route::get('/page-user-profile','PageController@userProfilePage');
Route::get('/page-faq','PageController@faqPage');
Route::get('/page-knowledge-base','PageController@knowledgeBasePage');
Route::get('/page-knowledge-base/categories','PageController@knowledgeCatPage');
Route::get('/page-knowledge-base/categories/question','PageController@knowledgeQuestionPage');
Route::get('/page-search','PageController@searchPage');
Route::get('/page-account-settings','PageController@accountSettingPage');
// User Route 
Route::get('/page-users-list','UsersController@listUser');
Route::get('/page-users-view','UsersController@viewUser');
Route::get('/page-users-edit','UsersController@editUser');
// Authentication  Route
Route::get('/auth-login','AuthenticationController@loginPage');
Route::get('/auth-register','AuthenticationController@registerPage');
Route::get('/auth-forgot-password','AuthenticationController@forgetPasswordPage');
Route::get('/auth-reset-password','AuthenticationController@resetPasswordPage');
Route::get('/auth-lock-screen','AuthenticationController@authLockPage');
// Miscellaneous
Route::get('/page-coming-soon','MiscellaneousController@comingSoonPage');
Route::get('/error-404','MiscellaneousController@error404Page');
Route::get('/error-500','MiscellaneousController@error500Page');
Route::get('/page-not-authorized','MiscellaneousController@notAuthPage');
Route::get('/page-maintenance','MiscellaneousController@maintenancePage');
// Charts Route
Route::get('/chart-apex','ChartController@apexChart');
Route::get('/chart-chartjs','ChartController@chartJs');
Route::get('/chart-chartist','ChartController@chartist');
Route::get('/maps-google','ChartController@googleMap');
// extension route
Route::get('/ext-component-sweet-alerts','ExtensionsController@sweetAlert');
Route::get('/ext-component-toastr','ExtensionsController@toastr');
Route::get('/ext-component-noui-slider','ExtensionsController@noUiSlider');
Route::get('/ext-component-drag-drop','ExtensionsController@dragComponent');
Route::get('/ext-component-tour','ExtensionsController@tourComponent');
Route::get('/ext-component-swiper','ExtensionsController@swiperComponent');
Route::get('/ext-component-treeview','ExtensionsController@treeviewComponent');
Route::get('/ext-component-block-ui','ExtensionsController@blockUIComponent');
Route::get('/ext-component-media-player','ExtensionsController@mediaComponent');
Route::get('/ext-component-miscellaneous','ExtensionsController@miscellaneous');
Route::get('/ext-component-i18n','ExtensionsController@i18n');
// locale Route
Route::get('lang/{locale}',[LanguageController::class,'swap']);

// acess controller
Route::get('/access-control', 'AccessController@index');
Route::get('/access-control/{roles}', 'AccessController@roles');
Route::get('/ecommerce', 'AccessController@home')->middleware('role:Admin');

//Auth::routes();

