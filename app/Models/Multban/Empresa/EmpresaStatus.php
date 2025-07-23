<?php

namespace App\Models\Multban\Empresa;

use App\Models\Multban\Traits\DbSysClientTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaStatus extends Model
{
    use HasFactory, DbSysClientTrait;

    protected $table = "tbdm_empstatus";

    public $timestamps = false;

}
