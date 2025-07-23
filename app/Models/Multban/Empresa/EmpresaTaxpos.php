<?php

namespace App\Models\Multban\Empresa;

use App\Models\Multban\Traits\DbSysClientTrait;
use Illuminate\Database\Eloquent\Model;

class EmpresaTaxpos extends Model
{
    use DbSysClientTrait;

    protected $table = "tbdm_empresa_taxpos";

    public $timestamps = false;

    public function getKeyName()
    {
        return "tax_id";
    }

    protected $primaryKey = 'tax_id';

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'emp_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "emp_id",
        "tax_id",
        "tax_categ",
        "parc_de",
        "parc_ate",
        "taxa",
        "criador",
        "dthr_cr",
        "dthr_ch",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
    ];

}
