<?php

use App\Solicitudes;
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


Route::group(['prefix' => 'auth'], function() {
    Route::post('login', 'AuthController@login' );
    Route::post('signup', 'AuthController@signup' );

    Route::group(['middleware' => 'auth:api'], function() {
          Route::get('logout', 'AuthController@logout');
          Route::get('user', 'AuthController@user');
      });
});

Route::group(["middleware" => "apikey.token"], function () {
    Route::any('api1', "Api1Controller@store");
    Route::apiResource("permisos", "PermisosController");
});

Route::any('pdf', "PDFController@PDF");
Route::any("xml", "XMLController@XML");

Route::get('/xml/{no_solicitud}', function($no_solicitud){
    $permisos = App\Solicitudes::all()->where('no_solicitud','=',$no_solicitud);
    return response()->xml(['permisos'=>$permisos->toArray()]);
});