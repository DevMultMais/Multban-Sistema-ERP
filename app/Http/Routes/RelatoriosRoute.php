<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\Relatorios\RelatoriosController;
use Illuminate\Support\Facades\Route;

class RelatoriosRoute
{
    public static function rotas()
    {
        Route::get('bi-relatorios', [RelatoriosController::class, 'index'])->name('bi-relatorios.index');
        Route::get('bi-relatorios/{id}/alterar', [RelatoriosController::class, 'edit'])->name('bi-relatorios.edit');
        Route::patch('bi-relatorios/{id}/alterar', [RelatoriosController::class, 'update'])->name('bi-relatorios.update');
        Route::get('bi-relatorios/inserir', [RelatoriosController::class, 'create'])->name('bi-relatorios.create');
        Route::post('bi-relatorios/inserir', [RelatoriosController::class, 'store'])->name('bi-relatorios.store');
        Route::get('bi-relatorios/{id}/copiar', [RelatoriosController::class, 'copy'])->name('bi-relatorios.copy');
        Route::get('bi-relatorios/{id}/visualizar', [RelatoriosController::class, 'show'])->name('bi-relatorios.show');
        Route::delete('bi-relatorios/{id}', [RelatoriosController::class, 'destroy'])->name('bi-relatorios.destroy');

        Route::get('bi-relatorios/obtergridpesquisa', [RelatoriosController::class, 'getObterGridPesquisa']);
    }
}
