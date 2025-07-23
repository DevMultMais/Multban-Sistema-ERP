<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\Perfil\PerfilController;
use Illuminate\Support\Facades\Route;

class PerfilRoute
{
    public static function rotas()
    {
        Route::get('perfil', [PerfilController::class, 'index'])->name('perfil.index');
        Route::get('perfil/{id}/alterar', [PerfilController::class, 'edit'])->name('perfil.edit');
        Route::patch('perfil/{id}/alterar', [PerfilController::class, 'update'])->name('perfil.update');
        Route::get('perfil/inserir', [PerfilController::class, 'create'])->name('perfil.create');
        Route::post('perfil/inserir', [PerfilController::class, 'store'])->name('perfil.store');
        Route::get('perfil/{id}/copiar', [PerfilController::class, 'copy'])->name('perfil.copy');
        Route::get('perfil/{id}/visualizar', [PerfilController::class, 'show'])->name('perfil.show');
        Route::delete('perfil/{id}', [PerfilController::class, 'destroy'])->name('perfil.destroy');

        Route::get('perfil/obtergridpesquisa', [PerfilController::class, 'getObterGridPesquisa']);
    }
}
