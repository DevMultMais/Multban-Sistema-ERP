<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\ProgramaPTS\ProgramaPTSController;
use Illuminate\Support\Facades\Route;

class ProgramaPTSRoute
{
    public static function rotas()
    {
        Route::get('programa-de-pontos', [ProgramaPTSController::class, 'index'])->name('programa-de-pontos.index');
        Route::get('programa-de-pontos/{id}/alterar', [ProgramaPTSController::class, 'edit'])->name('programa-de-pontos.edit');
        Route::patch('programa-de-pontos/{id}/alterar', [ProgramaPTSController::class, 'update'])->name('programa-de-pontos.update');
        Route::get('programa-de-pontos/inserir', [ProgramaPTSController::class, 'create'])->name('programa-de-pontos.create');
        Route::post('programa-de-pontos/inserir', [ProgramaPTSController::class, 'store'])->name('programa-de-pontos.store');
        Route::get('programa-de-pontos/{id}/copiar', [ProgramaPTSController::class, 'copy'])->name('programa-de-pontos.copy');
        Route::get('programa-de-pontos/{id}/visualizar', [ProgramaPTSController::class, 'show'])->name('programa-de-pontos.show');
        Route::delete('programa-de-pontos/{id}', [ProgramaPTSController::class, 'destroy'])->name('programa-de-pontos.destroy');

        Route::get('programa-de-pontos/obtergridpesquisa', [ProgramaPTSController::class, 'getObterGridPesquisa']);
    }
}
