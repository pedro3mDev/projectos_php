<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::get('/teste', function () {
    return response()->json(['message' => 'API Laravel funcionando!']);
});

Route::apiResource('produtos', ProdutoController::class);
