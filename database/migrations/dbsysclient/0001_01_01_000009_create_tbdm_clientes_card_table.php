<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbdmClientesCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbdm_clientes_card', function (Blueprint $table) {
            //PRIMARY KEY
            $table->foreignId('emp_id');
            $table->foreignId('cliente_id');
            $table->string('cliente_doc', 14);
            $table->string('cliente_pasprt', 15)->nullable();
            $table->uuid('card_uuid');
            $table->string('cliente_cardn', 16);
            $table->string('cliente_cardcv', 3);
            //FIELDS
            $table->string('card_sts', 2);
            $table->string('card_tp', 4);
            $table->string('card_mod', 4);
            $table->string('card_categ', 4);
            $table->string('card_desc', 100);
            $table->decimal('card_saldo_vlr', 10, 2);
            $table->decimal('card_limite', 10, 2);
            $table->decimal('card_saldo_pts', 10, 2);
            $table->text('card_pass')->nullable();
            $table->integer('criador');
            $table->timestamp('dthr_cr');
            $table->integer('modificador');
            $table->timestamp('dthr_ch')->useCurrent();
            //KEYS
            $table->primary(['emp_id', 'cliente_id', 'cliente_doc', 'card_uuid', 'cliente_cardn', 'cliente_cardcv']);
            //FOREIGN KEY
            $table->foreign('emp_id')->references('emp_id')->on('tbdm_empresa_geral');
            $table->foreign('cliente_id')->references('cliente_id')->on('tbdm_clientes_geral');
        });

        Schema::create('tbdm_clientes_prt', function (Blueprint $table) {
        //PRIMARY KEY
            $table->foreignId('emp_id');
            $table->foreignId('cliente_id');
            $table->integer('cliente_doc')->length(14);
            $table->string('cliente_pasprt', 15)->nullable();
            $table->uuid('protocolo');
            $table->string('protocolo_tp')->length(2);
            //FIELDS
            $table->integer('user_id');
            $table->string('anexo', 1);
            $table->string('anexo_path', 255);
            $table->longtext('texto_prt');
            $table->integer('criador');
            $table->timestamp('dthr_cr');
            $table->integer('modificador');
            $table->timestamp('dthr_ch')->useCurrent();
            //KEYS
            $table->primary(['emp_id', 'cliente_id', 'cliente_doc', 'protocolo', 'protocolo_tp']);
            //FOREIGN KEY
            $table->foreign('emp_id')->references('emp_id')->on('tbdm_empresa_geral');
            $table->foreign('cliente_id')->references('cliente_id')->on('tbdm_clientes_geral');
        });

        Schema::create('tbdm_clientes_rec', function (Blueprint $table) {
            //PRIMARY KEY
            $table->foreignId('emp_id');
            $table->foreignId('cliente_id');
            $table->integer('cliente_doc')->length(14);
            $table->string('cliente_pasprt', 15)->nullable();
            $table->uuid('protocolo');
            $table->string('protocolo_tp')->length(2);
            //FIELDS
            $table->integer('user_id');
            $table->string('anexo', 1);
            $table->string('anexo_path', 255);
            $table->longtext('texto_rec');
            $table->integer('criador');
            $table->timestamp('dthr_cr');
            $table->integer('modificador');
            $table->timestamp('dthr_ch')->useCurrent();
            //KEYS
            $table->primary(['emp_id', 'cliente_id', 'cliente_doc', 'protocolo', 'protocolo_tp']);
            //FOREIGN KEY
            $table->foreign('emp_id')->references('emp_id')->on('tbdm_empresa_geral');
            $table->foreign('cliente_id')->references('cliente_id')->on('tbdm_clientes_geral');
        });

        Schema::create('tbdm_cartoes_pre', function (Blueprint $table) {
            //PRIMARY KEY
            $table->foreignid('emp_id');
            $table->id('prg_id');
            $table->string('card_mod', 4);
            $table->string('card_sts', 30);
            //FIELDS
            $table->string('prg_nome', 100)->nullable();
            $table->decimal('prg_valor', 10, 2)->nullable();
            $table->integer('criador')->length()->nullable();
            $table->timestamp('dthr_cr')->nullable();
            $table->integer('modificador')->length()->nullable();
            $table->timestamp('dthr_ch')->nullable();
            //KEYS
            $table->primary(['prg_id', 'emp_id', 'card_mod', 'card_sts']);
            //FOREIGN KEY
            $table->foreign('emp_id')->references('emp_id')->on('tbdm_empresa_geral');
        });

        Schema::create('tbdm_programa_pts', function (Blueprint $table) {
            //PRIMARY KEY
            $table->foreignid('emp_id');
            $table->id('prgpts_id');
            $table->string('card_categ', 4);
            $table->string('prgpts_sts', 30);
            //FIELDS
            $table->decimal('prgpts_eq', 10, 2)->nullable();
            $table->integer('criador')->length()->nullable();
            $table->timestamp('dthr_cr')->nullable();
            $table->integer('modificador')->length()->nullable();
            $table->timestamp('dthr_ch')->nullable();
            //KEYS
            $table->primary(['prgpts_id', 'emp_id', 'card_categ', 'prgpts_sts']);
            //FOREIGN KEY
            $table->foreign('emp_id')->references('emp_id')->on('tbdm_empresa_geral');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbdm_clientes_card');
        Schema::dropIfExists('tbdm_clientes_prt');
        Schema::dropIfExists('tbdm_clientes_rec');
        Schema::dropIfExists('tbdm_cartoes_pre');
        Schema::dropIfExists('tbdm_programa_pts');
    }
}
