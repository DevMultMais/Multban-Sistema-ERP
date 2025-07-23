<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\Cliente\ClienteController;
use Illuminate\Support\Facades\Route;

class ClienteRoute
{
    public static function rotas()
    {
        Route::post('cliente/inserir', [ClienteController::class, 'store'])->middleware('permission:cliente.store')->name('cliente.store');
        Route::get('cliente/inserir', [ClienteController::class, 'create'])->middleware('permission:cliente.create')->name('cliente.create');
        Route::get('cliente/{id}/alterar', [ClienteController::class, 'edit'])->middleware('permission:cliente.edit')->name('cliente.edit');
        Route::patch('cliente/{id}/alterar', [ClienteController::class, 'update'])->middleware('permission:cliente.update')->name('cliente.update');
        Route::get('cliente', [ClienteController::class, 'index'])->middleware('permission:cliente.index')->name('cliente.index');
        Route::get('cliente/{id}/visualizar', [ClienteController::class, 'show'])->middleware('permission:cliente.show')->name('cliente.show');
        Route::delete('cliente/{id}', [ClienteController::class, 'destroy'])->middleware('permission:empresa.destroy')->name('cliente.destroy');
        Route::post('cliente/active/{id}', [ClienteController::class, 'active']);//->middleware('permission:empresa.active')->name('empresa.active');
        Route::post('cliente/inactive/{id}', [ClienteController::class, 'inactive']);//->middleware('permission:empresa.inactive')->name('empresa.inactive');

        Route::get('cliente/get-client', [ClienteController::class, 'getClient']);

        Route::post('cliente/obtergridpesquisa', [ClienteController::class, 'postObterGridPesquisa']);
    }
}
