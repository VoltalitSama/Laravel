<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SearchInvoice;
use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;
use App\Http\Controllers\ToolController;

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


//Exercice Unique MVC
/*
Route::get('/tools',function(){
    $tools = [
        (object) [
            "name" => "Marteau",
            "description" => "pour frapper et enfoncer des clous dans du bois ou d'autres matériaux.",
            "price" => "23.99",
        ],
        (object) [
            "name" => "Tournevis",
            "description" => "pour serrer ou desserrer les vis.",
            "price" => "15.99",
        ],
        (object) [
            "name" => "Scie",
            "description" => "pour couper le bois, le métal ou d'autres matériaux.",
            "price" => "56.33",
        ],
    ];
    dd($tools);
})
    ->name("tools");
*/

//Route::get('/tools', [ToolController::class, 'index'])->name("tools");

//Route::get('/tools/{id}', [ToolController::class, 'show'])->name("tools");

Route::resource('tools', ToolController::class)->only([
    'index', 'show'
]);

Route::get('/toolsedit', function () {
    $tools = \App\Models\Tool::all();

    foreach ($tools as $tool) {
        $tool->update(['price' => json_encode([
            'price' => $tool->price,
            'currency' => 'EUR',
            'currency_rate' => rand(0, 100) / 100,
        ])]);
    }
});

Route::controller(InvoiceController::class)->prefix('invoices')->as('invoices')->group(function () {
    Route::get('invoices/create50', 'create50')->name('invoices.create50');
    Route::get('createData', [InvoiceController::class, 'createData'])->name('createData');

});

//TD3
Route::resource('invoices', InvoiceController::class)->only([
    'index', 'show', 'create', 'store', 'destroy'
])->middleware('auth');

//TD4
/*Route::get('/search', function (Request $request){
    return view('searchs/search');
})
    ->name("search");*/

Route::controller(SearchInvoice::class)->group(function () {
    Route::get('/search', 'search')->name('search');
});

//TD Authentification
Route::controller(AuthenticationController::class)->prefix('auth')->as('auth.')->group(function (){
    Route::get('login', [AuthenticationController::class, 'showForm'])
        ->middleware('guest')
        ->name('login');
    Route::post('login', [AuthenticationController::class, 'login'])
        ->middleware('guest');
    Route::get('callback', [AuthenticationController::class, 'callback'])
        ->middleware('guest')
        ->name('authentication.callback');
    Route::get('logout', [AuthenticationController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});

//Authentication
Route::get('/home', \App\Http\Controllers\HomeController::class)
    ->middleware('auth')
    ->name('home');
