<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\Produto\ProdutoController;
use Illuminate\Support\Facades\Route;

class ProdutoRoute
{
    public static function rotas()
    {
        Route::get('produtos', [ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('produtos/{id}/alterar', [ProdutoController::class, 'edit'])->name('produtos.edit');
        Route::patch('produtos/{id}/alterar', [ProdutoController::class, 'update'])->name('produtos.update');
        Route::get('produtos/inserir', [ProdutoController::class, 'create'])->name('produtos.create');
        Route::post('produtos/inserir', [ProdutoController::class, 'store'])->name('produtos.store');
        Route::get('produtos/{id}/copiar', [ProdutoController::class, 'copy'])->name('produtos.copy');
        Route::get('produtos/{id}/visualizar', [ProdutoController::class, 'show'])->name('produtos.show');
        Route::delete('produtos/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

        Route::get('produtos/obtergridpesquisa', [ProdutoController::class, 'getObterGridPesquisa']);
    }
}
