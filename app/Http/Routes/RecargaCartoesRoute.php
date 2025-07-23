<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\RecargaCartoes\RecargaCartoesController;
use Illuminate\Support\Facades\Route;

class RecargaCartoesRoute
{
    public static function rotas()
    {
        Route::get('recarga-cartoes', [RecargaCartoesController::class, 'index'])->name('recarga-cartoes.index');
        Route::get('recarga-cartoes/{id}/alterar', [RecargaCartoesController::class, 'edit'])->name('recarga-cartoes.edit');
        Route::patch('recarga-cartoes/{id}/alterar', [RecargaCartoesController::class, 'update'])->name('recarga-cartoes.update');
        Route::get('recarga-cartoes/inserir', [RecargaCartoesController::class, 'create'])->name('recarga-cartoes.create');
        Route::post('recarga-cartoes/inserir', [RecargaCartoesController::class, 'store'])->name('recarga-cartoes.store');
        Route::get('recarga-cartoes/{id}/copiar', [RecargaCartoesController::class, 'copy'])->name('recarga-cartoes.copy');
        Route::get('recarga-cartoes/{id}/visualizar', [RecargaCartoesController::class, 'show'])->name('recarga-cartoes.show');
        Route::delete('recarga-cartoes/{id}', [RecargaCartoesController::class, 'destroy'])->name('recarga-cartoes.destroy');

        Route::get('recarga-cartoes/obtergridpesquisa', [RecargaCartoesController::class, 'getObterGridPesquisa']);
    }
}
