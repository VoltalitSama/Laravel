<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;

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



//Exercice 1
Route::get('/request', function (Request $request) {
    dd($request);
})
    ->name('redirect_request');
    //->middleware(\App\Http\Middleware\Redirect::class);

//Exercice 2
Route::get('/',function () {
    return "Welcome";
})
    ->name("welcome");

Route::permanentRedirect('/redirect', '/')->name("redirectToWelcome");

//Mettre a la fin du fichier de route
Route::get('/name/{prenom}', function (string $prenom){
    return 'Prenom: '.$prenom;
})
    ->name("queryName");

//Mettre a la fin du fichier de route
Route::get('/ressource/{id}', function (int $id){
    return 'Id est un numerique: '.$id;
})
    ->where('id', '[0-9]+')
    ->name("ressource");

//Exercice 3
Route::get('/test', function (){
    return view('welcome');
})
    ->name("test");

//Exercice 4
Route::post('/request', function(Request $request){
    dd($request);
    //dd($request->session()->token());
})
    ->name('request');

//Exercice 5
Route::get('/middleware', function (){
    return "Page middleware";
})
    ->middleware(\App\Http\Middleware\interuption::class)
    ->name("middleware");

//Exercice 6
Route::get('/ip',function(){
    return " IP correct";
})
    ->middleware(\App\Http\Middleware\WhiteList::class)
    ->name("IP");

