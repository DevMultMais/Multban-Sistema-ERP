<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\Venda\PdvWebController;
use Illuminate\Support\Facades\Route;

class VendasRoute
{
    public static function rotas()
    {
        //Pedido de venda
        Route::get('pdv-web', [PdvWebController::class, 'index'])->middleware('permission:pdv-web.index')->name('pdv-web.index');
    }
}
