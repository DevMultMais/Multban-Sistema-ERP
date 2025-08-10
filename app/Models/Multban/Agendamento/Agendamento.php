<?php

namespace App\Models\Multban\Agendamento;

use App\Models\Multban\Cliente\Cliente;
use App\Models\Multban\Traits\DbSysClientTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use DbSysClientTrait;
    protected $table = "tbtr_agendamento";

    public $timestamps = false;

     public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'cliente_id');
    }

    public function user()
    {
        return $this->setConnection('mysql')->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function rules($id = '')
    {
        return [
            'cliente_tipo' => 'required',
            'cliente_doc' => 'min:11|max:14|string|required|unique:dbsysclient.tbdm_clientes_geral,cliente_doc, ' . $id . ',cliente_id',
            'cliente_sts' => 'required',
            'cliente_pasprt' => 'max:15',
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
            'cliente_tipo' =>    '"Dados Gerais"Tipo de Cliente',
            'cliente_sts' =>     '"Dados Gerais"Status do Cliente',
            'cliente_doc' =>     '"Dados Gerais"CPF/CNPJ',
            'cliente_pasprt' =>  '"Dados Gerais"Número do Passaporte',
            'cliente_nome' =>    '"Dados Gerais"Nome',
            'cliente_email' =>   '"Dados Gerais"E-mail',
            'cliente_cel' =>     '"Dados Gerais"Celular',
            'cliente_rendam' =>  '"Dados Gerais"Renda Mensal Aprox.',
            'cliente_dt_fech' => '"Dados Gerais"Dia para Fech.',
            //Endereço
            'cliente_cep' =>     '"Endereço"CEP',
            'cliente_end' =>     '"Endereço"Endereço',
            'cliente_endnum' =>  '"Endereço"Número',
            'cliente_endcmp' =>  '"Endereço"Complemento',
            'cliente_endbair' => '"Endereço"Bairro',
            'cliente_endcid' =>  '"Endereço"Cidade',
            'cliente_endest' =>  '"Endereço"Estado',
            'cliente_endpais' => '"Endereço"País',
        ];
    }

    public function messages()
    {
        return [
            // 'cliente_tipo.required' => 'Campo obrigatório.',
            // 'cliente_doc.max' => 'O campo deve conter no máximo 14 caracteres.',
            // 'cliente_doc.required' => 'Campo obrigatório.',
             'cliente_doc.unique' => '"Dados Gerais"Já existe um Cliente cadastrado com esse CPF/CNPJ.',
            // 'cliente_doc.min' => 'O campo deve conter no mínimo 14 caracteres.',
            // 'cliente_doc.max' => 'O campo deve conter no máximo 14 caracteres.',
            // 'cliente_sts.required' => 'Campo obrigatório.',

            // //Endereço
            // 'cliente_cep.required' => 'Campo obrigatório.',
            // 'cliente_cep.min' => 'O campo deve conter no mínimo 8 caracteres.',
            // 'cliente_cep.max' => 'O campo deve conter no máximo 8 caracteres.',
            // 'cliente_end.max' => 'O campo deve conter no máximo 60 caracteres.',
            // 'cliente_end.required' => 'Campo obrigatório.',
            // 'cliente_endbair.required' => 'Campo obrigatório.',
            // 'cliente_endpais.required' => 'Campo obrigatório.',
            // 'cliente_endest.required' => 'Campo obrigatório.',
            // 'cliente_endcid.required' => 'Campo obrigatório.',

        ];
    }


}
