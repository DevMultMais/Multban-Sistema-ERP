<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\Agendamento\AgendamentoController;
use Illuminate\Support\Facades\Route;

class AgendamentoRoute
{
    public static function rotas()
    {
        Route::get('agendamento', [AgendamentoController::class, 'index'])->name('agendamentomento.index');
        Route::get('get-agendamento', [AgendamentoController::class, 'getAgenda']);
        Route::get('agendamento/{id}/alterar', [AgendamentoController::class, 'edit'])->name('agendamento.edit');
        Route::patch('agendamento/{id}/alterar', [AgendamentoController::class, 'update'])->name('agendamento.update');
        Route::get('agendamento/inserir', [AgendamentoController::class, 'create'])->name('agendamento.create');
        Route::post('agendamento/inserir', [AgendamentoController::class, 'store'])->name('agendamento.store');
        Route::get('agendamento/{id}/copiar', [AgendamentoController::class, 'copy'])->name('agendamento.copy');
        Route::get('agendamento/{id}/visualizar', [AgendamentoController::class, 'show'])->name('agendamento.show');
        Route::delete('agendamento/{id}', [AgendamentoController::class, 'destroy'])->name('agendamento.destroy');

        Route::get('agendamento/obtergridpesquisa', [AgendamentoController::class, 'getObterGridPesquisa']);
    }
}
