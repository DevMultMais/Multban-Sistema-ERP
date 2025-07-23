<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\PainelCobranca\PainelCobrancaController;
use Illuminate\Support\Facades\Route;

class PainelCobrancaRoute
{
    public static function rotas()
    {
        Route::get('painel-cobranca', [PainelCobrancaController::class, 'index'])->name('painel-cobranca.index');
        Route::get('painel-cobranca/{id}/alterar', [PainelCobrancaController::class, 'edit'])->name('painel-cobranca.edit');
        Route::patch('painel-cobranca/{id}/alterar', [PainelCobrancaController::class, 'update'])->name('painel-cobranca.update');
        Route::get('painel-cobranca/inserir', [PainelCobrancaController::class, 'create'])->name('painel-cobranca.create');
        Route::post('painel-cobranca/inserir', [PainelCobrancaController::class, 'store'])->name('painel-cobranca.store');
        Route::get('painel-cobranca/{id}/copiar', [PainelCobrancaController::class, 'copy'])->name('painel-cobranca.copy');
        Route::get('painel-cobranca/{id}/visualizar', [PainelCobrancaController::class, 'show'])->name('painel-cobranca.show');
        Route::delete('painel-cobranca/{id}', [PainelCobrancaController::class, 'destroy'])->name('painel-cobranca.destroy');

        Route::get('painel-cobranca/obtergridpesquisa', [PainelCobrancaController::class, 'getObterGridPesquisa']);
    }
}
