<?php

namespace App\Models\Multban\Produto;

use App\Models\Multban\Traits\DbSysClientTrait;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use DbSysClientTrait;

    protected $table = "tbdm_produtos_geral";

    public $timestamps = false;

    public function getKeyName()
    {
        return "produto_id";
    }

    protected $primaryKey = 'produto_id';

    public function status()
    {
        return $this->belongsTo(ProdutoStatus::class, 'produto_sts', 'produto_sts');
    }

    public function tipo()
    {
        return $this->belongsTo(ProdutoTipo::class, 'produto_tipo', 'produto_tipo');
    }
}
