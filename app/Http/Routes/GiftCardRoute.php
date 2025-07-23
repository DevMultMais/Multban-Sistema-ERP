<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\GiftCard\FidelidadeGiftCardController;
use Illuminate\Support\Facades\Route;

class GiftCardRoute
{
    public static function rotas()
    {
        Route::get('cartao-fidelidade-gift', [FidelidadeGiftCardController::class, 'index'])->name('cartao-fidelidade-gift.index');
        Route::get('cartao-fidelidade-gift/{id}/alterar', [FidelidadeGiftCardController::class, 'edit'])->name('cartao-fidelidade-gift.edit');
        Route::patch('cartao-fidelidade-gift/{id}/alterar', [FidelidadeGiftCardController::class, 'update'])->name('cartao-fidelidade-gift.update');
        Route::get('cartao-fidelidade-gift/inserir', [FidelidadeGiftCardController::class, 'create'])->name('cartao-fidelidade-gift.create');
        Route::post('cartao-fidelidade-gift/inserir', [FidelidadeGiftCardController::class, 'store'])->name('cartao-fidelidade-gift.store');
        Route::get('cartao-fidelidade-gift/{id}/copiar', [FidelidadeGiftCardController::class, 'copy'])->name('cartao-fidelidade-gift.copy');
        Route::get('cartao-fidelidade-gift/{id}/visualizar', [FidelidadeGiftCardController::class, 'show'])->name('cartao-fidelidade-gift.show');
        Route::delete('cartao-fidelidade-gift/{id}', [FidelidadeGiftCardController::class, 'destroy'])->name('cartao-fidelidade-gift.destroy');

        Route::get('cartao-fidelidade-gift/obtergridpesquisa', [FidelidadeGiftCardController::class, 'getObterGridPesquisa']);
    }
}
