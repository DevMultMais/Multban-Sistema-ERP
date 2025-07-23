<?php

namespace App\Models\Multban\Cliente;

use App\Models\Multban\Endereco\Cidade;
use App\Models\Multban\Endereco\Estados;
use App\Models\Multban\Endereco\Pais;
use App\Models\Multban\Traits\DbSysClientTrait;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use DbSysClientTrait;

    protected $table = "tbdm_clientes_geral";

    public $timestamps = false;

    public function getKeyName()
    {
        return "cliente_id";
    }

    protected $primaryKey = 'cliente_id';

    public function status()
    {
        return $this->belongsTo(ClienteStatus::class, 'cliente_sts', 'cliente_sts');
    }

    public function tipo()
    {
        return $this->belongsTo(ClienteTipo::class, 'cliente_tipo', 'cliente_tipo');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'cliente_endpais', 'pais');
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'cliente_endest', 'estado');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cliente_endcid', 'cidade');
    }

    public function paisS()
    {
        return $this->belongsTo(Pais::class, 'cliente_endpais_s', 'pais');
    }

    public function estadoS()
    {
        return $this->belongsTo(Estados::class, 'cliente_endest_s', 'estado');
    }

    public function cidadeS()
    {
        return $this->belongsTo(Cidade::class, 'cliente_endcid_s', 'cidade');
    }


    public function rules($id = '')
    {
        return [
            'cliente_tipo' => 'required',
            'cliente_doc' => 'min:11|max:14|string|required|unique:tbdm_clientes_geral,cliente_doc, ' . $id . ',cliente_id',
            'cliente_sts' => 'required',
            'cliente_nome' => 'required|max:80',
            'cliente_email' => 'required|email',
            'cliente_cel' => 'required',
            'cliente_rendam' => 'required',
            'cliente_dt_fech' => 'required',
            'cliente_cep' => 'required',
            'cliente_end' => 'required',
            'cliente_endnum' => 'required',
            'cliente_endbair' => 'required',
            'cliente_endcid' => 'required',
            'cliente_endest' => 'required',
            'cliente_endpais' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'cliente_tipo' => 'Tipo de Cliente',
            'cliente_doc' => 'CPF/CNPJ',
            'cliente_sts' => 'Status do Cliente',
            //Endereço
            'cliente_cep' => 'CEP',
            'cliente_end' => 'Endereço',
            'cliente_endnum' => 'Número',
            'cliente_endcmp' => 'Complemento',
            'cliente_endbair' => 'Bairro',
            'cliente_endcid' => 'Cidade',
            'cliente_endest' => 'Estado',
            'cliente_endpais' => 'País',
        ];
    }

    public function messages()
    {
        return [
            'cliente_tipo.required' => 'Campo obrigatório.',
            'cliente_doc.max' => 'O campo deve conter no máximo 14 caracteres.',
            'cliente_doc.required' => 'Campo obrigatório.',
            'cliente_doc.unique' => 'Já existe um Cliente cadastrado com esse CPF/CNPJ.',
            'cliente_doc.min' => 'O campo deve conter no mínimo 14 caracteres.',
            'cliente_doc.max' => 'O campo deve conter no máximo 14 caracteres.',
            'cliente_sts.required' => 'Campo obrigatório.',

            //Endereço
            'cliente_cep.required' => 'Campo obrigatório.',
            'cliente_cep.min' => 'O campo deve conter no mínimo 8 caracteres.',
            'cliente_cep.max' => 'O campo deve conter no máximo 8 caracteres.',
            'cliente_end.max' => 'O campo deve conter no máximo 60 caracteres.',
            'cliente_end.required' => 'Campo obrigatório.',
            'cliente_endbair.required' => 'Campo obrigatório.',
            'cliente_endpais.required' => 'Campo obrigatório.',
            'cliente_endest.required' => 'Campo obrigatório.',
            'cliente_endcid.required' => 'Campo obrigatório.',

        ];
    }

}
