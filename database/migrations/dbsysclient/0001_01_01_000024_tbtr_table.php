<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbtr_h_titulos', function (Blueprint $table) {
            $table->foreignId('emp_id');
            $table->foreignId('user_id');
            $table->integer('titulo');
            $table->uuid('nid_titulo');
            $table->integer('qtd_parc');
            $table->integer('primeira_para');
            $table->integer('cnd_pag', 2);
            $table->foreignId('cliente_id');
            $table->string('meio_pag', 2);
            $table->foreignId('card_uuid');
            $table->date('data_mov');
            $table->string('check_reemb', 1);
            $table->decimal('vlr_brt', 10, 2);
            $table->float('tax_adm');
            $table->float('tax_rebate');
            $table->float('tax_royalties');
            $table->float('tax_comissao');
            $table->integer('qtd_pts_utlz');
            $table->float('perc_pts_utlz');
            $table->decimal('vlr_btot', 10, 2);
            $table->float('perc_desc');
            $table->decimal('vlr_dec', 10, 2);
            $table->decimal('vlr_btot_split', 10, 2);
            $table->float('perc_juros');
            $table->decimal('vlr_juros', 10, 2);
            $table->decimal('vlr_btot_cj', 10, 2);
        });
        Schema::create('tbtr_p_titulos_ab', function (Blueprint $table) {
            $table->foreignId('emp_id');
            $table->foreignId('user_id');
            $table->foreignId('titulo');
            $table->uuid('nid_titulo');
            $table->integer('qtd_parc');
            $table->integer('primeira_para');
            $table->integer('cnd_pag', 2);
            $table->foreignId('cliente_id');
            $table->string('meio_pag_v', 2);
            $table->foreignId('card_uuid');
            $table->date('data_mov');
            $table->integer('parcela');
            $table->uuid('nid_parcela');
            $table->foreignId('id_fatura');
            $table->uuid('integ_bc');
            $table->date('data_venc');
            $table->date('data_pgto');
            $table->string('meio_pag_t', 2);
            $table->string('parcela_sts', 3);
            $table->string('destvlr', 4);
            $table->integer('qtd_pts_utlz');
            $table->decimal('tax_bacen', 10, 2);
            $table->decimal('vlr_dec', 10, 2);
            $table->decimal('vlr_bpar_split', 10, 2);
            $table->decimal('vlr_jurosp', 10, 2);
            $table->decimal('vlr_bpar_cj', 10, 2);
            $table->decimal('vlr_atr_m', 10, 2);
            $table->decimal('vlr_atr_j', 10, 2);
            $table->string('isent_mj', 1);
            $table->decimal('pgt_vlr', 10, 2);
            $table->decimal('vlr_rec', 10, 2);
        });
        Schema::create('tbtr_p_titulos_cp', function (Blueprint $table) {
            $table->foreignId('emp_id');
            $table->foreignId('user_id');
            $table->foreignId('titulo');
            $table->uuid('nid_titulo');
            $table->integer('qtd_parc');
            $table->integer('primeira_para');
            $table->integer('cnd_pag', 2);
            $table->foreignId('cliente_id');
            $table->string('meio_pag_v', 2);
            $table->foreignId('card_uuid');
            $table->date('data_mov');
            $table->integer('parcela');
            $table->uuid('nid_parcela');
            $table->foreignId('id_fatura');
            $table->uuid('integ_bc');
            $table->date('data_venc');
            $table->date('data_pgto');
            $table->string('meio_pag_t', 2);
            $table->string('parcela_sts', 3);
            $table->string('destvlr', 4);
            $table->integer('qtd_pts_utlz');
            $table->decimal('tax_bacen', 10, 2);
            $table->decimal('vlr_dec', 10, 2);
            $table->decimal('vlr_bpar_split', 10, 2);
            $table->decimal('vlr_jurosp', 10, 2);
            $table->decimal('vlr_bpar_cj', 10, 2);
            $table->decimal('vlr_atr_m', 10, 2);
            $table->decimal('vlr_atr_j', 10, 2);
            $table->string('isent_mj', 1);
            $table->decimal('pgt_vlr', 10, 2);
            $table->decimal('vlr_rec', 10, 2);
        });
        Schema::create('tbtr_i_titulos', function (Blueprint $table) {
            $table->foreignId('emp_id');
            $table->foreignId('user_id');
            $table->foreignId('titulo');
            $table->integer('qtd_parc');
            $table->integer('parcela');
            $table->integer('produto_tipo', 2);
            $table->foreignId('produto_id');
            $table->integer('qtd_item');
            $table->decimal('vlr_unit_item', 10, 2);
            $table->decimal('vlr_brt_item', 10, 2);
            $table->float('perc_toti');
            $table->integer('qtd_pts_utlz_item');
            $table->decimal('tax_bacen', 10, 2);
            $table->decimal('vlr_base_item', 10, 2);
            $table->decimal('vlr_dec_item', 10, 2);
            $table->decimal('vlr_bpar_split_item', 10, 2);
            $table->decimal('vlr_jpar_item', 10, 2);
            $table->decimal('vlr_bpar_cj_item', 10, 2);
            $table->decimal('vlr_atrm_item', 10, 2);
            $table->decimal('vlr_atrj_item', 10, 2);
            $table->float('perc_ant');
            $table->decimal('ant_desc', 10, 2);
            $table->decimal('pgt_vlr', 10, 2);
            $table->decimal('pgt_desc', 10, 2);
            $table->decimal('pgt_mtjr', 10, 2);
            $table->decimal('vlr_rec', 10, 2);
            $table->integer('pts_disp');
        });
        Schema::create('tbtr_s_titulos', function (Blueprint $table) {
            $table->foreignId('emp_id');
            $table->foreignId('user_id');
            $table->foreignId('titulo');
            $table->integer('parcela');
            $table->foreignId('produto_id');
            $table->string('lanc_tp', 10);
            $table->foreignId('recebedor');
            $table->float('tax_adm');
            $table->decimal('vlr_plan', 10, 2);
            $table->float('perc_real');
            $table->decimal('vlr_real', 10, 2);
        });
        Schema::create('tbtr_f_titulos', function (Blueprint $table) {
            $table->foreignId('emp_id');
            $table->foreignId('user_id');
            $table->foreignId('titulo');
            $table->uuid('nid_titulo');
            $table->foreignId('cliente_id');
            $table->foreignId('card_uuid');
            $table->uuid('id_fatura');
            $table->uuid('integ_bc');
            $table->integer('fatura_sts', 2);
            $table->date('data_fech');
            $table->date('data_venc');
            $table->date('data_pgto');
            $table->decimal('vlr_tot', 10, 2);
            $table->decimal('vlr_pgto', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbtr_h_titulos');
        Schema::dropIfExists('tbtr_p_titulos_ab');
        Schema::dropIfExists('tbtr_p_titulos_cp');
        Schema::dropIfExists('tbtr_i_titulos');
        Schema::dropIfExists('tbtr_s_titulos');
        Schema::dropIfExists('tbtr_f_titulos');
    }
};
