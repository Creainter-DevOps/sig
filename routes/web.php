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


Route::view('/', 'auth.login');
Route::view('identificacion', 'auth.login');
Route::post('identificacion', 'Auth\LoginController@loginPTV')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::match(['get', 'post'], '/dashboard', 'DashboardController@index')->name('dashboard');

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
//Route::get('/','DashboardController@dashboardEcommerce');
Route::get('/dashboard-ecommerce','DashboardController@dashboardEcommerce');
Route::get('/dashboard-analytics','DashboardController@dashboardAnalytics');

Route::get('/contable','ContableController@index');

Route::get('entregables/autocomplete', 'EntregableController@autocomplete');
Route::resource('entregables', 'EntregableController');

Route::get('pagos/autocomplete', 'PagoController@autocomplete');
Route::resource('pagos', 'PagoController');

Route::get('gastos/autocomplete', 'GastoController@autocomplete');
Route::resource('gastos', 'GastoController');

//Route::resource('proyectos', 'ProyectoController');
Route::get('proyectos/autocomplete', 'ProyectoController@autocomplete'); 
Route::post('proyectos/{proyecto}/observacion', 'ProyectoController@observacion'); 
Route::resource('proyectos', 'ProyectoController')->parameters([
    'proyectos' => 'proyecto'
  ]);

Route::get('empresas/fast','EmpresaController@fast');
Route::get('empresas/autocomplete', 'EmpresaController@autocomplete'); 
Route::resource('empresas','EmpresaController')->parameters([ 
  'empresas' => 'empresa'
]);

Route::get('usuarios/autocomplete', 'UsuarioController@autocomplete'); 
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

Route::get('actividades/kanban', 'ActividadController@kanban');
Route::get('actividades/kanban/json', 'ActividadController@kanban_data');

Route::get('actividades/calendario','ActividadController@calendario');
Route::get('actividades/calendario/json', 'ActividadController@calendario_data');
Route::get('actividades/calendario/proyectos/json', 'ActividadController@calendario_proyectos');

Route::post('actividades/{actividad}/observacion', 'ActividadController@observacion'); 
Route::resource('actividades', 'ActividadController')->parameters([
    'actividades' => 'actividad'
]);

#Route::get('empresas/autocomplete', 'EmpresaController@autocomplete');
#Route::post('empresas/getProvincias', 'EmpresaController@getProvincias');
#Route::post('empresas/getDistritos', 'EmpresaController@getDistritos');
#Route::resource('empresas', 'EmpresaController');

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

Route::get('cotizaciones/autocomplete', 'CotizacionController@autocomplete');
Route::post('cotizaciones/{cotizacion}/observacion', 'CotizacionController@observacion');
Route::get('cotizaciones/{cotizacion}/proyecto', 'CotizacionController@proyecto')->name('cotizaciones.proyecto');
Route::resource('cotizaciones', 'CotizacionController')->parameters([
  'cotizaciones' => 'cotizacion'
]);


Route::get('contactos/autocomplete', 'ContactoController@autocomplete');
Route::post('contactos/{contacto}/observacion', 'ContactoController@observacion');
Route::get('contactos/fast', 'ContactoController@fast');
Route::resource('contactos', 'ContactoController')->parameters([
    'contactos' => 'contacto'
]);


Route::get('productos/autocomplete', 'ProductoController@autocomplete');
Route::resource('productos', 'ProductoController')->parameters([
  'productos' => 'producto'
]);

Route::get('carta/autocomplete', 'CartaController@autocomplete');
Route::resource('cartas', 'CartaController')->parameters([
  'cartas' => 'carta'
]);


Route::get('actas/autocomplete', 'ActaController@autocomplete');
Route::resource('actas', 'ActaController')->parameters([
  'actas' => 'acta'
]);

Route::get('oportunidades/convertir/proyecto/{cotizacion}','OportunidadController@proyecto')->name( 'oportunidad.proyecto' );
Route::get('oportunidades/autocomplete', 'OportunidadController@autocomplete');
Route::get('oportunidades/{oportunidad}/cerrar', 'OportunidadController@cerrar')->name('oportunidades.cerrar');
Route::resource('oportunidades', 'OportunidadController')->parameters([
  'oportunidades' => 'oportunidad'
]);


Route::get('licitaciones/autocomplete','LicitacionController@autocomplete');
Route::post('licitaciones/actualizar/{oportunidad}','LicitacionController@update')->name("licitacion.update");
Route::get('licitaciones/calendario','LicitacionController@calendario');
Route::get('licitaciones/nuevas','LicitacionController@listNuevas');
Route::get('licitaciones/archivadas','LicitacionController@listArchivadas');
Route::get('licitaciones/eliminadas','LicitacionController@listEliminadas');
Route::get('licitaciones/aprobadas','LicitacionController@listAprobadas');
Route::resource('licitaciones', 'LicitacionController')->parameters([
  'licitaciones' => 'licitacion'
]);

Route::get('licitaciones/{licitacion}/detalles','LicitacionController@show');
Route::get('licitaciones/{licitacion}/actualizar','LicitacionController@actualizar')->name('licitacion.actualizar');
Route::get('licitaciones/{licitacion}/aprobar','LicitacionController@aprobar');
Route::get('licitaciones/{licitacion}/revisar','LicitacionController@revisar');
Route::get('licitaciones/{licitacion}/interes/{empresa}','LicitacionController@interes');
Route::get('licitaciones/{licitacion}/rechazar','LicitacionController@rechazar');
Route::get('licitaciones/{licitacion}/archivar','LicitacionController@archivar');
Route::post('licitaciones/{licitacion}/observacion','LicitacionController@observacion');
Route::get('licitaciones/{licitacion}/participar/{cotizacion}','LicitacionController@registrarParticipacion');
Route::get('licitaciones/{licitacion}/propuesta/{cotizacion}','LicitacionController@registrarPropuesta');


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

