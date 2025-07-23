<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\Auditoria\AuditoriaController;
use Illuminate\Support\Facades\Route;

class AuditoriaRoute
{
    public static function rotas()
    {
        Route::get('auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');
        Route::get('auditoria/{id}/alterar', [AuditoriaController::class, 'edit'])->name('auditoria.edit');
        Route::patch('auditoria/{id}/alterar', [AuditoriaController::class, 'update'])->name('auditoria.update');
        Route::get('auditoria/inserir', [AuditoriaController::class, 'create'])->name('auditoria.create');
        Route::post('auditoria/inserir', [AuditoriaController::class, 'store'])->name('auditoria.store');
        Route::get('auditoria/{id}/copiar', [AuditoriaController::class, 'copy'])->name('auditoria.copy');
        Route::get('auditoria/{id}/visualizar', [AuditoriaController::class, 'show'])->name('auditoria.show');
        Route::delete('auditoria/{id}', [AuditoriaController::class, 'destroy'])->name('auditoria.destroy');

        Route::get('auditoria/obtergridpesquisa', [AuditoriaController::class, 'getObterGridPesquisa']);
    }
}
