<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbdmClientesEmpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbdm_clientes_emp', function (Blueprint $table) {
            //PRIMARY KEY
            $table->foreignId('emp_id');
            $table->foreignId('cliente_id');
            $table->uuid('cliente_uuid');
            $table->string('cliente_doc')->length(14);
            $table->string('cliente_pasprt')->lenght(15);
            $table->string('cad_liberado', 1);
            //FIELDS
            $table->integer('criador');
            $table->timestamp('dthr_cr');
            $table->integer('modificador');
            $table->timestamp('dthr_ch')->useCurrent();;
            //KEYS
            $table->primary(['emp_id', 'cliente_id', 'cliente_uuid', 'cliente_doc', 'cliente_pasprt', 'cad_liberado']);
            //FOREIGN KEY
            $table->foreign('emp_id')->references('emp_id')->on('tbdm_empresa_geral');
            $table->foreign('cliente_id')->references('cliente_id')->on('tbdm_clientes_geral');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbdm_clientes_emp');
    }
}
