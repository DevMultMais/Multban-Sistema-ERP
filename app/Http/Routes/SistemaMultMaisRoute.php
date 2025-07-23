<?php

namespace App\Http\Routes;

use App\Http\Controllers\Multban\MultMais\SistemaMultMaisController;
use Illuminate\Support\Facades\Route;

class SistemaMultMaisRoute
{
    public static function rotas()
    {
        Route::get('config-sistema-multmais', [SistemaMultMaisController::class, 'index'])->name('config-sistema-multmais.index');
        Route::get('config-sistema-multmais/{id}/alterar', [SistemaMultMaisController::class, 'edit'])->name('config-sistema-multmais.edit');
        Route::patch('config-sistema-multmais/{id}/alterar', [SistemaMultMaisController::class, 'update'])->name('config-sistema-multmais.update');
        Route::get('config-sistema-multmais/inserir', [SistemaMultMaisController::class, 'create'])->name('config-sistema-multmais.create');
        Route::post('config-sistema-multmais/inserir', [SistemaMultMaisController::class, 'store'])->name('config-sistema-multmais.store');
        Route::get('config-sistema-multmais/{id}/copiar', [SistemaMultMaisController::class, 'copy'])->name('config-sistema-multmais.copy');
        Route::get('config-sistema-multmais/{id}/visualizar', [SistemaMultMaisController::class, 'show'])->name('config-sistema-multmais.show');
        Route::delete('config-sistema-multmais/{id}', [SistemaMultMaisController::class, 'destroy'])->name('config-sistema-multmais.destroy');

        Route::get('config-sistema-multmais/obter-empresas', [SistemaMultMaisController::class, 'getObterEmpresas']);
        Route::get('config-sistema-multmais/obter-tabelas', [SistemaMultMaisController::class, 'getObterTabelas']);
        Route::post('config-sistema-multmais/obtergridpesquisa', [SistemaMultMaisController::class, 'getObterGridPesquisa']);
        Route::get('config-sistema-multmais/edit-conexoes-bc-emp/{emp_id}', [SistemaMultMaisController::class, 'editConexoesBcEmp']);
        Route::post('config-sistema-multmais/update-conexoes-bc-emp', [SistemaMultMaisController::class, 'updateConexoesBcEmp']);
        Route::post('config-sistema-multmais/store-conexoes-bc-emp', [SistemaMultMaisController::class, 'storeConexoesBcEmp']);

        //Alias
        Route::post('config-sistema-multmais/obtergridpesquisa-alias', [SistemaMultMaisController::class, 'getObterGridPesquisaAlias']);
        Route::get('config-sistema-multmais/edit-alias/{emp_id}', [SistemaMultMaisController::class, 'editAlias']);
        Route::post('config-sistema-multmais/store-alias', [SistemaMultMaisController::class, 'storeAlias']);
        Route::post('config-sistema-multmais/update-alias', [SistemaMultMaisController::class, 'updateAlias']);
        Route::delete('config-sistema-multmais/destroy-alias/{emp_id}', [SistemaMultMaisController::class, 'destroyAlias']);

        //API
        Route::post('config-sistema-multmais/obtergridpesquisa-apis', [SistemaMultMaisController::class, 'getObterGridPesquisaApis']);
        Route::get('config-sistema-multmais/edit-apis/{emp_id}', [SistemaMultMaisController::class, 'editApis']);
        Route::post('config-sistema-multmais/store-apis', [SistemaMultMaisController::class, 'storeApis']);
        Route::post('config-sistema-multmais/update-apis', [SistemaMultMaisController::class, 'updateApis']);
        Route::delete('config-sistema-multmais/destroy-apis/{emp_id}', [SistemaMultMaisController::class, 'destroyApis']);

        //Padrões dos Planos
        Route::post('config-sistema-multmais/obtergridpesquisa-padroes-de-planos', [SistemaMultMaisController::class, 'getObterGridPesquisaPdPlan']);
        Route::get('config-sistema-multmais/edit-padroes-de-planos/{emp_id}', [SistemaMultMaisController::class, 'editPdPlan']);
        Route::post('config-sistema-multmais/store-padroes-de-planos', [SistemaMultMaisController::class, 'storePdPlan']);
        Route::post('config-sistema-multmais/update-padroes-de-planos', [SistemaMultMaisController::class, 'updatePdPlan']);
        Route::delete('config-sistema-multmais/destroy-padroes-de-planos/{emp_id}', [SistemaMultMaisController::class, 'destroyPdPlan']);

        //White Label
        Route::post('config-sistema-multmais/obtergridpesquisa-white-label', [SistemaMultMaisController::class, 'getObterGridPesquisaWhiteLabel']);
        Route::get('config-sistema-multmais/edit-white-label/{emp_id}', [SistemaMultMaisController::class, 'editWhiteLabel']);
        Route::post('config-sistema-multmais/store-white-label', [SistemaMultMaisController::class, 'storeWhiteLabel']);
        Route::post('config-sistema-multmais/update-white-label', [SistemaMultMaisController::class, 'updateWhiteLabel']);
        Route::delete('config-sistema-multmais/destroy-white-label/{emp_id}', [SistemaMultMaisController::class, 'destroyWhiteLabel']);

        //Padrões de Mensagens
        Route::post('config-sistema-multmais/obtergridpesquisa-padroes-de-mensagens', [SistemaMultMaisController::class, 'getObterGridPesquisaPdMsg']);
        Route::get('config-sistema-multmais/edit-padroes-de-mensagens/{emp_id}', [SistemaMultMaisController::class, 'editPdMsg']);
        Route::post('config-sistema-multmais/store-padroes-de-mensagens', [SistemaMultMaisController::class, 'storePdMsg']);
        Route::post('config-sistema-multmais/update-padroes-de-mensagens', [SistemaMultMaisController::class, 'updatePdMsg']);
        Route::delete('config-sistema-multmais/destroy-padroes-de-mensagens/{emp_id}', [SistemaMultMaisController::class, 'destroyPdMsg']);

        //Work Flow
        Route::post('config-sistema-multmais/obtergridpesquisa-work-flow', [SistemaMultMaisController::class, 'getObterGridPesquisaWf']);
        Route::get('config-sistema-multmais/get-columns-from-table/{table}', [SistemaMultMaisController::class, 'getColumnsFromTable']);
        Route::get('config-sistema-multmais/edit-work-flow/{emp_id}', [SistemaMultMaisController::class, 'editWf']);
        Route::post('config-sistema-multmais/store-work-flow', [SistemaMultMaisController::class, 'storeWf']);
        Route::post('config-sistema-multmais/update-work-flow', [SistemaMultMaisController::class, 'updateWf']);
        Route::delete('config-sistema-multmais/destroy-work-flow/{emp_id}', [SistemaMultMaisController::class, 'destroyWf']);

        //Dados Mestre
        Route::post('config-sistema-multmais/obtergridpesquisa-dados-mestre', [SistemaMultMaisController::class, 'getObterGridPesquisaDm']);
        Route::get('config-sistema-multmais/edit-dados-mestre', [SistemaMultMaisController::class, 'editDm']);
        Route::get('config-sistema-multmais/create-dados-mestre', [SistemaMultMaisController::class, 'createDm']);
        Route::post('config-sistema-multmais/store-dados-mestre', [SistemaMultMaisController::class, 'storeDm']);
        Route::post('config-sistema-multmais/update-dados-mestre', [SistemaMultMaisController::class, 'updateDm']);
        Route::delete('config-sistema-multmais/destroy-dados-mestre/{tabela}', [SistemaMultMaisController::class, 'destroyDm']);
    }
}
