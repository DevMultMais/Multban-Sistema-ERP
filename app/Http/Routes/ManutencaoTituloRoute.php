<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\ManutencaoTitulo\ManutencaoTituloController;
use Illuminate\Support\Facades\Route;

class ManutencaoTituloRoute
{
    public static function rotas()
    {
        Route::get('manutencao-titulo', [ManutencaoTituloController::class, 'index'])->name('manutencao-titulo.index');
        Route::get('manutencao-titulo/{id}/alterar', [ManutencaoTituloController::class, 'edit'])->name('manutencao-titulo.edit');
        Route::patch('manutencao-titulo/{id}/alterar', [ManutencaoTituloController::class, 'update'])->name('manutencao-titulo.update');
        Route::get('manutencao-titulo/inserir', [ManutencaoTituloController::class, 'create'])->name('manutencao-titulo.create');
        Route::post('manutencao-titulo/inserir', [ManutencaoTituloController::class, 'store'])->name('manutencao-titulo.store');
        Route::get('manutencao-titulo/{id}/copiar', [ManutencaoTituloController::class, 'copy'])->name('manutencao-titulo.copy');
        Route::get('manutencao-titulo/{id}/visualizar', [ManutencaoTituloController::class, 'show'])->name('manutencao-titulo.show');
        Route::delete('manutencao-titulo/{id}', [ManutencaoTituloController::class, 'destroy'])->name('manutencao-titulo.destroy');

        Route::get('produtos/obtergridpesquisa', [ManutencaoTituloController::class, 'getObterGridPesquisa']);
    }
}
