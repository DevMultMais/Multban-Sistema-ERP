<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\FaturamentoServico\FaturamentoServicoController;
use Illuminate\Support\Facades\Route;

class FaturamentoServicoRoute
{
    public static function rotas()
    {
        Route::get('faturamento-servico', [FaturamentoServicoController::class, 'index'])->name('faturamento-servico.index');
        Route::get('faturamento-servico/{id}/alterar', [FaturamentoServicoController::class, 'edit'])->name('faturamento-servico.edit');
        Route::patch('faturamento-servico/{id}/alterar', [FaturamentoServicoController::class, 'update'])->name('faturamento-servico.update');
        Route::get('faturamento-servico/inserir', [FaturamentoServicoController::class, 'create'])->name('faturamento-servico.create');
        Route::post('faturamento-servico/inserir', [FaturamentoServicoController::class, 'store'])->name('faturamento-servico.store');
        Route::get('faturamento-servico/{id}/copiar', [FaturamentoServicoController::class, 'copy'])->name('faturamento-servico.copy');
        Route::get('faturamento-servico/{id}/visualizar', [FaturamentoServicoController::class, 'show'])->name('faturamento-servico.show');
        Route::delete('faturamento-servico/{id}', [FaturamentoServicoController::class, 'destroy'])->name('faturamento-servico.destroy');

        Route::get('faturamento-servico/obtergridpesquisa', [FaturamentoServicoController::class, 'getObterGridPesquisa']);
    }
}
