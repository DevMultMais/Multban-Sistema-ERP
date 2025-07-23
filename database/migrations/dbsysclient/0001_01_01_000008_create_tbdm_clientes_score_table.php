<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbdmClientesScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbdm_clientes_score', function (Blueprint $table) {
            //PRIMARY KEY
            $table->foreignId('cliente_id');
            $table->uuid('cliente_uuid');
            $table->string('cliente_doc')->length(14);
            $table->string('cliente_pasprt')->lenght(15);
            $table->string('cliente_proc_num', 25);
            $table->string('cliente_proc_tipo', 255);
            //FIELDS
            $table->string('cliente_proc_desc', 255);
            $table->string('cliente_proc_sts', 255);
            $table->string('cliente_proc_dtc', 255);
            $table->string('cliente_proc_dti', 255);
            $table->string('cliente_proc_dtf', 255);
            $table->string('cliente_proc_vlr', 255);
            $table->integer('criador');
            $table->timestamp('dthr_cr');
            $table->integer('modificador');
            $table->timestamp('dthr_ch')->useCurrent();;
            //KEYS
            $table->primary(['cliente_id', 'cliente_uuid', 'cliente_doc', 'cliente_pasprt', 'cliente_proc_num', 'cliente_proc_tipo']);
            //FOREIGN KEY
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
        Schema::dropIfExists('tbdm_clientes_score');
    }
}
