<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\CargaDados\CargaDadosController;
use Illuminate\Support\Facades\Route;

class CargaDadosRoute
{
    public static function rotas()
    {
        Route::get('carga-dados', [CargaDadosController::class, 'index'])->name('carga-dados.index');
        Route::get('carga-dados/{id}/alterar', [CargaDadosController::class, 'edit'])->name('carga-dados.edit');
        Route::patch('carga-dados/{id}/alterar', [CargaDadosController::class, 'update'])->name('carga-dados.update');
        Route::get('carga-dados/inserir', [CargaDadosController::class, 'create'])->name('carga-dados.create');
        Route::post('carga-dados/inserir', [CargaDadosController::class, 'store'])->name('carga-dados.store');
        Route::get('carga-dados/{id}/copiar', [CargaDadosController::class, 'copy'])->name('carga-dados.copy');
        Route::get('carga-dados/{id}/visualizar', [CargaDadosController::class, 'show'])->name('carga-dados.show');
        Route::delete('carga-dados/{id}', [CargaDadosController::class, 'destroy'])->name('carga-dados.destroy');

        Route::get('carga-dados/obtergridpesquisa', [CargaDadosController::class, 'getObterGridPesquisa']);
    }
}
