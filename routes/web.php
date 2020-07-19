<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel; 

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

Route::get('/', 'HomeController@index')->name('home');


Route::get('/IniciarSesion', 'Auth\LoginController@index')->name('IniciarSesion');
Route::post('/verificaLogin', 'Auth\LoginController@verificaLogin')->name('verificaLogin');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');;

//Mail
Route::post('/recuperarPassword','MailController@recuperarPassword')->name('mailRecuperar')->middleware('guest');
Route::post('/recuperarPasswordIn','MailController@recuperarPasswordIn')->name('mailRecuperarIn')->middleware('auth');
Route::get('/changePassword/{clave}','MailController@changePassword')->name('cambiarPassword');
Route::post('/putChangePassword','MailController@putChangePassword')->name('putChangePassword');

//user
Route::get('/user', 'UserController@index')->name('usuarioIndex')->middleware('auth', 'role:Administrador');
//Route::get('/user/_list', 'UserController@filter')->name('usuarioFilter')->middleware('auth', 'role:Administrador');
Route::get('/user/create', 'UserController@create')->name('usuarioCreate')->middleware('auth', 'role:Administrador');
Route::post('/user/store', 'UserController@store')->name('usuarioStore')->middleware('auth', 'role:Administrador');
Route::get('/user/edit/{id}', 'UserController@edit')->name('usuarioEdit')->middleware('auth', 'role:Administrador');
Route::post('/user/update', 'UserController@update')->name('usuarioUpdate')->middleware('auth', 'role:Administrador');
Route::get('/user/detail/{id}', 'UserController@show')->name('usuarioDetail')->middleware('auth', 'role:Administrador');
Route::get('/user/crateProfile/{id}', 'UserController@createProfile')->name('usuarioCreateProfile')->middleware('auth', 'role:Administrador');
Route::post('/user/crateProfileStore', 'UserController@createProfileStore')->name('usuarioPerfilStore')->middleware('auth', 'role:Administrador');

//materia
Route::get('/materia', 'MateriaController@index')->name('materiaIndex')->middleware('auth', 'role:Administrador');
//Route::get('/user/_list', 'UserController@filter')->name('usuarioFilter')->middleware('auth', 'role:Administrador');
Route::get('/materia/create', 'MateriaController@create')->name('materiaCreate')->middleware('auth', 'role:Administrador');
Route::post('/materia/store', 'MateriaController@store')->name('materiaStore')->middleware('auth', 'role:Administrador');
Route::get('/materia/edit/{id}', 'MateriaController@edit')->name('materiaEdit')->middleware('auth', 'role:Administrador');
Route::post('/materia/update', 'MateriaController@update')->name('materiaUpdate')->middleware('auth', 'role:Administrador');
Route::get('/materia/detail/{id}', 'MateriaController@show')->name('materiaDetail')->middleware('auth', 'role:Administrador');

//Tema
Route::get('/tema', 'TemaController@index')->name('temaIndex')->middleware('auth', 'role:Administrador');
//Route::get('/user/_list', 'UserController@filter')->name('usuarioFilter')->middleware('auth', 'role:Administrador');
Route::get('/tema/create', 'TemaController@create')->name('temaCreate')->middleware('auth', 'role:Administrador');
Route::post('/tema/store', 'TemaController@store')->name('temaStore')->middleware('auth', 'role:Administrador');
Route::get('/tema/edit/{id}', 'TemaController@edit')->name('temaEdit')->middleware('auth', 'role:Administrador');
Route::post('/tema/update', 'TemaController@update')->name('temaUpdate')->middleware('auth', 'role:Administrador');
Route::get('/tema/detail/{id}', 'TemaController@show')->name('temaDetail')->middleware('auth', 'role:Administrador');

//subTema
Route::get('/subTema', 'SubTemaController@index')->name('subTemaIndex')->middleware('auth', 'role:Administrador');
//Route::get('/user/_list', 'UserController@filter')->name('usuarioFilter')->middleware('auth', 'role:Administrador');
Route::get('/subTema/create', 'SubTemaController@create')->name('subTemaCreate')->middleware('auth', 'role:Administrador');
Route::post('/subTema/store', 'SubTemaController@store')->name('subTemaStore')->middleware('auth', 'role:Administrador');
Route::get('/subTema/edit/{id}', 'SubTemaController@edit')->name('subTemaEdit')->middleware('auth', 'role:Administrador');
Route::post('/subTema/update', 'SubTemaController@update')->name('subTemaUpdate')->middleware('auth', 'role:Administrador');
Route::get('/subTema/detail/{id}', 'SubTemaController@show')->name('subTemaDetail')->middleware('auth', 'role:Administrador');

//cicloEscolar
Route::get('/cicloEscolar', 'CicloEscolarController@index')->name('cicloEscolarIndex')->middleware('auth', 'role:Administrador');
Route::get('/cicloEscolar/create', 'CicloEscolarController@create')->name('cicloEscolarCreate')->middleware('auth', 'role:Administrador');
Route::post('/cicloEscolar/store', 'CicloEscolarController@store')->name('cicloEscolarStore')->middleware('auth', 'role:Administrador');
Route::get('/cicloEscolar/edit/{id}', 'CicloEscolarController@edit')->name('cicloEscolarEdit')->middleware('auth', 'role:Administrador');
Route::post('/cicloEscolar/update', 'CicloEscolarController@update')->name('cicloEscolarUpdate')->middleware('auth', 'role:Administrador');
Route::get('/cicloEscolar/detail/{id}', 'CicloEscolarController@show')->name('cicloEscolarDetail')->middleware('auth', 'role:Administrador');

//grado
Route::get('/grado', 'GradoController@index')->name('gradoIndex')->middleware('auth', 'role:Administrador');
Route::get('/grado/create', 'GradoController@create')->name('gradoCreate')->middleware('auth', 'role:Administrador');
Route::post('/grado/store', 'GradoController@store')->name('gradoStore')->middleware('auth', 'role:Administrador');
Route::get('/grado/edit/{id}', 'GradoController@edit')->name('gradoEdit')->middleware('auth', 'role:Administrador');
Route::post('/grado/update', 'GradoController@update')->name('gradoUpdate')->middleware('auth', 'role:Administrador');
Route::get('/grado/detail/{id}', 'GradoController@show')->name('gradoDetail')->middleware('auth', 'role:Administrador');

//Grupo
Route::get('/grupo', 'GrupoController@index')->name('grupoIndex')->middleware('auth', 'role:Administrador');
Route::get('/grupo/create', 'GrupoController@create')->name('grupoCreate')->middleware('auth', 'role:Administrador');
Route::post('/grupo/store', 'GrupoController@store')->name('grupoStore')->middleware('auth', 'role:Administrador');
Route::get('/grupo/edit/{id}', 'GrupoController@edit')->name('grupoEdit')->middleware('auth', 'role:Administrador');
Route::post('/grupo/update', 'GrupoController@update')->name('grupoUpdate')->middleware('auth', 'role:Administrador');
Route::get('/grupo/detail/{id}', 'GrupoController@show')->name('grupoDetail')->middleware('auth', 'role:Administrador');

//Turno
Route::get('/turno', 'TurnoController@index')->name('turnoIndex')->middleware('auth', 'role:Administrador');
Route::get('/turno/create', 'TurnoController@create')->name('turnoCreate')->middleware('auth', 'role:Administrador');
Route::post('/turno/store', 'TurnoController@store')->name('turnoStore')->middleware('auth', 'role:Administrador');
Route::get('/turno/edit/{id}', 'TurnoController@edit')->name('turnoEdit')->middleware('auth', 'role:Administrador');
Route::post('/turno/update', 'TurnoController@update')->name('turnoUpdate')->middleware('auth', 'role:Administrador');
Route::get('/turno/detail/{id}', 'TurnoController@show')->name('turnoDetail')->middleware('auth', 'role:Administrador');

//Alumno
Route::get('/alumno', 'AlumnoController@index')->name('alumnoIndex')->middleware('auth', 'role:Administrador');
Route::get('/alumno/create', 'AlumnoController@create')->name('alumnoCreate')->middleware('auth', 'role:Administrador');
Route::post('/alumno/store', 'AlumnoController@store')->name('alumnoStore')->middleware('auth', 'role:Administrador');
Route::get('/alumno/edit/{id}', 'AlumnoController@edit')->name('alumnoEdit')->middleware('auth', 'role:Administrador');
Route::post('/alumno/update', 'AlumnoController@update')->name('alumnoUpdate')->middleware('auth', 'role:Administrador');
Route::get('/alumno/detail/{id}', 'AlumnoController@show')->name('alumnoDetail')->middleware('auth', 'role:Administrador');

//Maestro
Route::get('/maestro', 'MaestroController@index')->name('maestroIndex')->middleware('auth', 'role:Administrador');
Route::get('/maestro/create', 'MaestroController@create')->name('maestroCreate')->middleware('auth', 'role:Administrador');
Route::post('/maestro/store', 'MaestroController@store')->name('maestroStore')->middleware('auth', 'role:Administrador');
Route::get('/maestro/edit/{id}', 'MaestroController@edit')->name('maestroEdit')->middleware('auth', 'role:Administrador');
Route::post('/maestro/update', 'MaestroController@update')->name('maestroUpdate')->middleware('auth', 'role:Administrador');
Route::get('/maestro/detail/{id}', 'MaestroController@show')->name('maestroDetail')->middleware('auth', 'role:Administrador');

//Bitacora
Route::get('/bitacora', 'BitacoraController@index')->name('bitacoraIndex')->middleware('auth', 'role:Administrador');
Route::get('/maestro/create', 'MaestroController@create')->name('maestroCreate')->middleware('auth', 'role:Administrador');
Route::post('/maestro/store', 'MaestroController@store')->name('maestroStore')->middleware('auth', 'role:Administrador');
Route::get('/maestro/edit/{id}', 'MaestroController@edit')->name('maestroEdit')->middleware('auth', 'role:Administrador');
Route::post('/maestro/update', 'MaestroController@update')->name('maestroUpdate')->middleware('auth', 'role:Administrador');
Route::get('/maestro/detail/{id}', 'MaestroController@show')->name('maestroDetail')->middleware('auth', 'role:Administrador');


Route::get('/Excel', 'ExcelController@index')->name('excelIndex')->middleware('auth', 'role:Administrador');;
Route::get('/Excel/GetTemplate/{id}', 'ExcelController@getTemplate')->name('excelTemplate')->middleware('auth', 'role:Administrador');
Route::post('/Excel/Import', 'ExcelController@import')->name('excelImport')->middleware('auth', 'role:Administrador');
