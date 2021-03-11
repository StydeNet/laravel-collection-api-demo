<?php

use App\Api\Contracts\GetPlaylistsWithVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API interna (de nuestro proyecto)
|--------------------------------------------------------------------------
|
| Éste es un ejemplo de una API interna que se comunicará con el API de
| otro proyecto para obtener datos, procesarlos y retornarlos en otro
| formato, por ejemplo, para ser usados por el frontend de la app.
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('videos', function (GetPlaylistsWithVideos $gateway) {
    return $gateway->get();
});

/*
|--------------------------------------------------------------------------
| Simulación de un API externa (de otro proyecto)
|--------------------------------------------------------------------------
|
| Estas rutas y este código estarían en un proyecto aparte; al cual,
| quizá, no tendrías acceso ni a su código ni a su base de datos;
| por lo tanto deberías interactuar con éste través del API.
|
*/
Route::get('external-videos/{limit?}', function ($take = 20) {
    return \App\Vendor\FakeVideoLibrary::make()->latest($take);
});
