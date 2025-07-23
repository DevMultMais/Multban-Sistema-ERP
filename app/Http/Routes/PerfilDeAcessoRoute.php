<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\PerfilDeAcesso\PerfilDeAcessoController;
use Illuminate\Support\Facades\Route;

class PerfilDeAcessoRoute
{
    public static function rotas()
    {

        Route::get('perfil-de-acesso', [PerfilDeAcessoController::class, 'index'])->middleware('permission:perfil-de-acesso.index')->name('perfil-de-acesso.index');
        Route::get('perfil-de-acesso/{id}/alterar', [PerfilDeAcessoController::class, 'edit'])->middleware('permission:perfil-de-acesso.edit')->name('perfil-de-acesso.edit');
        Route::patch('perfil-de-acesso/{id}/alterar', [PerfilDeAcessoController::class, 'update'])->middleware('permission:perfil-de-acesso.update')->name('perfil-de-acesso.update');
        Route::get('perfil-de-acesso/inserir', [PerfilDeAcessoController::class, 'create'])->middleware('permission:perfil-de-acesso.create')->name('perfil-de-acesso.create');
        Route::post('perfil-de-acesso/inserir', [PerfilDeAcessoController::class, 'store'])->middleware('permission:perfil-de-acesso.store')->name('perfil-de-acesso.store');
        Route::get('perfil-de-acesso/{id}/copiar', [PerfilDeAcessoController::class, 'copy'])->middleware('permission:perfil-de-acesso.copy')->name('perfil-de-acesso.copy');
        Route::get('perfil-de-acesso/{id}/visualizar', [PerfilDeAcessoController::class, 'show'])->middleware('permission:perfil-de-acesso.show')->name('perfil-de-acesso.show');
        Route::delete('perfil-de-acesso/{id}', [PerfilDeAcessoController::class, 'destroy'])->middleware('permission:perfil-de-acesso.destroy')->name('perfil-de-acesso.destroy');

        Route::get('perfil-de-acesso/obtergridpesquisa', [PerfilDeAcessoController::class, 'getObterGridPesquisa']);
    }
}
