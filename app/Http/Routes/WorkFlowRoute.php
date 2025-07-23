<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\WorkFlow\WorkFlowController;
use Illuminate\Support\Facades\Route;

class WorkFlowRoute
{
    public static function rotas()
    {
        Route::get('work-flow', [WorkFlowController::class, 'index'])->name('work-flow.index');
        Route::get('work-flow/{id}/alterar', [WorkFlowController::class, 'edit'])->name('work-flow.edit');
        Route::patch('work-flow/{id}/alterar', [WorkFlowController::class, 'update'])->name('work-flow.update');
        Route::get('work-flow/inserir', [WorkFlowController::class, 'create'])->name('work-flow.create');
        Route::post('work-flow/inserir', [WorkFlowController::class, 'store'])->name('work-flow.store');
        Route::get('work-flow/{id}/copiar', [WorkFlowController::class, 'copy'])->name('work-flow.copy');
        Route::get('work-flow/{id}/visualizar', [WorkFlowController::class, 'show'])->name('work-flow.show');
        Route::delete('work-flow/{id}', [WorkFlowController::class, 'destroy'])->name('work-flow.destroy');

        Route::get('work-flow/obtergridpesquisa', [WorkFlowController::class, 'getObterGridPesquisa']);
    }
}
