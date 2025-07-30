<?php

namespace App\Http\Controllers\Multban\Cliente;

use App\Enums\EmpresaStatusEnum;
use App\Enums\EstoqramEnum;
use App\Enums\FiltrosEnum;
use App\Http\Controllers\Controller;
use App\Models\Multban\Auditoria\LogAuditoria;
use App\Models\Multban\Cliente\CardCateg;
use App\Models\Multban\Cliente\CardMod;
use App\Models\Multban\Cliente\CardTipo;
use App\Models\Multban\Cliente\Cliente;
use App\Models\Multban\Cliente\ClienteStatus;
use App\Models\Multban\Cliente\ClienteTipo;
use App\Models\Multban\Cliente\Endereco\Cadasest;
use App\Models\Multban\Cliente\Endereco\Cadasmun;
use App\Models\Multban\Cliente\Endereco\CadasPais;
use App\Models\Multban\Empresa\Empresa;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ClienteController extends Controller
{
    private $permissions;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = ClienteStatus::all();
        $tipos = ClienteTipo::all();
        return response()->view('Multban.cliente.index', compact('status', 'tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $emp_id = Auth::user()->emp_id;
        $userRole = Auth::user()->roles->pluck('name', 'name')->all();
        $canChangeStatus = false;
        foreach ($userRole as $key => $value) {

            if ($value == 'admin') {
                $canChangeStatus = true; //Se for usuário Admin, pode mudar o Status
            }
        }

        $status = ClienteStatus::all();
        $tipos = ClienteTipo::all();
        $cardTipos = CardTipo::all();
        $cardMod = CardMod::all();
        $cardCateg = CardCateg::all();

        $cliente = new Cliente();

        return response()->view('Multban.cliente.edit', compact(
            'cliente',
            'status',
            'tipos',
            'cardTipos',
            'cardMod',
            'cardCateg',
            'canChangeStatus'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {


            $emp_id = Auth::user()->emp_id;

            $userRole = Auth::user()->roles->pluck('name', 'name')->all();
            $canChangeStatus = false;
            foreach ($userRole as $key => $value) {

                if ($value == 'admin') {
                    $canChangeStatus = true; //Se for usuário Admin, pode mudar o Status
                }
            }

            $cliente = new Cliente();
            $input = $request->all();

            $input['cliente_nome'] = rtrim($request->cliente_nome);
            $input['cliente_doc'] = removerCNPJ($request->cliente_doc);
            $input['cliente_rendam'] = formatarTextoParaDecimal($request->cliente_rendam);

            $validator = Validator::make($input, $cliente->rules(), $cliente->messages(), $cliente->attributes());

            if ($validator->fails()) {
                return response()->json([
                    'message'   => $validator->errors(),

                ], 422);
            }

            $cliente->cliente_tipo       = $request->cliente_tipo;
            $cliente->cliente_doc        = removerCNPJ($request->cliente_doc);
            $cliente->cliente_pasprt     = $request->cliente_pasprt;
            $cliente->cliente_sts        = !$canChangeStatus ? 'NA' : $request->cliente_sts; /*Cliente nasce com o status "Em Análise"*/
            $cliente->cliente_uuid       = Str::uuid()->toString();
            $cliente->cliente_nome       = mb_strtoupper(rtrim($request->cliente_nome), 'UTF-8');
            $cliente->cliente_nm_alt     = mb_strtoupper(rtrim($request->cliente_nm_alt), 'UTF-8');
            $cliente->cliente_nm_card    = $request->cliente_nm_card;
            $cliente->cliente_email      = $request->cliente_email;
            $cliente->cliente_email_s    = $request->cliente_email_s;
            $cliente->cliente_cel        = $request->cliente_cel;
            $cliente->cliente_cel_s      = $request->cliente_cel_s;
            $cliente->cliente_telfixo    = $request->cliente_telfixo;
            $cliente->cliente_rendam     = $input['cliente_rendam'];
            $cliente->cliente_rdam_s     = $request->cliente_rdam_s;
            $cliente->cliente_dt_fech    = $request->cliente_dt_fech;
            $cliente->cliente_cep        = removerMascaraCEP($request->cliente_cep);
            $cliente->cliente_end        = mb_strtoupper(rtrim($request->cliente_end), 'UTF-8');
            $cliente->cliente_endnum     = $request->cliente_endnum;
            $cliente->cliente_endcmp     = mb_strtoupper(rtrim($request->cliente_endcmp), 'UTF-8');
            $cliente->cliente_endbair    = mb_strtoupper(rtrim($request->cliente_endbair), 'UTF-8');
            $cliente->cliente_endcid     = $request->cliente_endcid;
            $cliente->cliente_endest     = $request->cliente_endest;
            $cliente->cliente_endpais    = $request->cliente_endpais;
            $cliente->cliente_cep_s      = removerMascaraCEP($request->cliente_cep_s);
            $cliente->cliente_end_s      = mb_strtoupper(rtrim($request->cliente_end_s), 'UTF-8');
            $cliente->cliente_endnum_s   = $request->cliente_endnum_s;
            $cliente->cliente_endcmp_s   = mb_strtoupper(rtrim($request->cliente_endcmp_s), 'UTF-8');
            $cliente->cliente_endbair_s  = mb_strtoupper(rtrim($request->cliente_endbair_s), 'UTF-8');
            $cliente->cliente_endcid_s   = $request->cliente_endcid_s;
            $cliente->cliente_endest_s   = $request->cliente_endest_s;
            $cliente->cliente_endpais_s  = $request->cliente_endpais_s;
            $cliente->cliente_score      = $request->cliente_score;
            $cliente->cliente_lmt_sg     = $request->cliente_lmt_sg;
            $cliente->criador            = Auth::user()->user_id;
            $cliente->modificador            = Auth::user()->user_id;
            $cliente->dthr_cr            = Carbon::now();
            $cliente->dthr_ch            = Carbon::now();

            $cliente->save();

            $tbdm_clientes_emp = DB::connection('dbsysclient')->table('tbdm_clientes_emp')->insert([
                'emp_id' => $emp_id,
                'cliente_id' => $cliente->cliente_id,
                'cliente_uuid' => Str::uuid()->toString(),
                'cliente_doc' => removerCNPJ($cliente->cliente_doc),
                'cliente_pasprt' => $cliente->cliente_pasprt,
                'cad_liberado' => '',
                'criador' => Auth::user()->user_id,
                'dthr_cr' => Carbon::now(),
                'modificador' => Auth::user()->user_id,
                'dthr_ch' => Carbon::now(),
            ]);

            //Auditoria

            $logAuditoria         = new LogAuditoria();
            $logAuditoria->auddat = date('Y-m-d H:i:s');
            $logAuditoria->audusu = Auth::user()->user_id;
            $logAuditoria->audtar = 'Adicionou o cliente';
            $logAuditoria->audarq = $cliente->getTable();
            $logAuditoria->audlan = $cliente->id;
            $logAuditoria->audant = '';
            $logAuditoria->auddep = $cliente->cliente_nome;
            $logAuditoria->audnip = request()->ip();
            $logAuditoria->save();


            DB::commit();
            // Session::flash("idModeloInserido", $cliente->cliente_id);

            // Session::flash('success', "Cliente " . str_pad($cliente->cliente_id, 5, "0", STR_PAD_LEFT) . " adicionado com sucesso.");

            return response()->json([
                'message'   => "Cliente " . str_pad($cliente->cliente_id, 5, "0", STR_PAD_LEFT) . " adicionado com sucesso.",
            ]);
        } catch (Exception | \Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);

        return response()->view('Multban.cliente.edit', compact(
            'cliente',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emp_id = Auth::user()->emp_id;
        $userRole = Auth::user()->roles->pluck('name', 'name')->all();

        $status = ClienteStatus::all();
        $tipos = ClienteTipo::all();
        $cardTipos = CardTipo::all();
        $cardMod = CardMod::all();
        $cardCateg = CardCateg::all();
        $cliente = Cliente::findOrFail($id);

        $canChangeStatus = false;
        foreach ($userRole as $key => $value) {

            if ($value == 'admin') {
                $canChangeStatus = true; //Se for usuário Admin, pode mudar o Status
            }
        }

        return response()->view('Multban.cliente.edit', compact(
            'cliente',
            'status',
            'tipos',
            'cardTipos',
            'cardMod',
            'cardCateg',
            'canChangeStatus'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $cliente = Cliente::find($id);
            $input = $request->all();

            $input['cliente_doc'] = removerCNPJ($request->clicgc);
            $input['cliente_cel'] = removerMascaraTelefone($request->clicep);
            $input['cliente_telfixo'] = removerMascaraTelefone($request->clicep);
            $input['cliente_cel_s'] = removerMascaraTelefone($request->clicep);
            $input['cliente_cep'] = removerMascaraCEP($request->clicep);

            $validator = Validator::make($input, $cliente->rules($id), $cliente->messages(), $cliente->attributes());

            if ($validator->fails()) {
                return response()->json([
                    'message'   => $validator->errors(),

                ], 422);
            }

            //Verifica se ouve mudanças nos campos, se sim grava na auditoria
            foreach ($input as $key => $value) {
                if (Arr::exists($cliente->toArray(), $key)) {
                    if ($cliente->$key != $value) {
                        if ($key == 'updated_at' || $key == 'created_at') {
                        } else {

                            $logAuditoria = new LogAuditoria();
                            $logAuditoria->auddat = date('Y-m-d H:i:s');
                            $logAuditoria->audusu = Auth::user()->username;
                            $logAuditoria->audtar = 'Alterou o campo ' . $key;
                            $logAuditoria->audarq = $cliente->getTable();
                            $logAuditoria->audlan = $cliente->id;
                            $logAuditoria->audant = $cliente->$key;
                            $logAuditoria->auddep = $value;
                            $logAuditoria->audnip = request()->ip();

                            $logAuditoria->save();
                        }
                    }
                }
            }

            $cliente->save();

            return response()->json([
                'message'   => 'Cliente atualizado com sucesso.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message'   => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $cliente = Cliente::find($id);
            if ($cliente) {
                $cliente->cliente_sts = EmpresaStatusEnum::EXCLUIDO;
                $cliente->save();
                return response()->json([
                    'title' => 'Sucesso',
                    'text' => 'Registro Excluído com sucesso!',
                    'type' => 'success'
                ]);
            }

            return response()->json([
                'title' => 'Erro',
                'text' => 'Registro não encontrado!',
                'type' => 'error'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message'   => $e->getMessage(),
            ], 500);
        }
    }

    public function inactive($id)
    {
        try {

            $cliente = Cliente::find($id);
            if ($cliente) {
                $cliente->cliente_sts = EmpresaStatusEnum::INATIVO;
                $cliente->save();
                return response()->json([
                    'title' => 'Sucesso',
                    'text' => 'Registro Inativado com sucesso!',
                    'type' => 'success'
                ]);
            }

            return response()->json([
                'title' => 'Erro',
                'text' => 'Registro não encontrado!',
                'type' => 'error'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'title' => 'Erro',
                'text' => $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    public function active($id)
    {
        try {

            $cliente = Cliente::find($id);

            if ($cliente) {
                $cliente->cliente_sts = EmpresaStatusEnum::ATIVO;
                $cliente->save();
                return response()->json([
                    'title' => 'Sucesso',
                    'text' => 'Registro Ativado com sucesso!',
                    'type' => 'success'
                ]);
            }

            return response()->json([
                'title' => 'Erro',
                'text' => 'Registro não encontrado!',
                'type' => 'error'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'title' => 'Erro',
                'text' => $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    public function getClient(Request $request)
    {
        $parametro = $request != null ? $request->all()['parametro'] : '';

        if (empty($parametro)) {
            return [];
        }

        return Cliente::select(DB::raw('cliente_id as id, cliente_id, cliente_doc, UPPER(cliente_nome) text'))
            ->whereRaw(DB::raw("cliente_nome LIKE '%" . $parametro . "%' OR cliente_id = '%" . $parametro . "%'"))
            ->get()
            ->toArray();
    }

    public function postObterGridPesquisa(Request $request)
    {
        if (!Auth::check()) {
            abort(Response::HTTP_UNAUTHORIZED, "Usuário não autenticado...");
        }

        $data = new Collection();

        $query = "";

        if (!empty($request->cliente_sts)) {
            $query .= "cliente_sts = " . quotedstr($request->cliente_sts) . " AND ";
        }
        if (!empty($request->cliente_tipo)) {
            $query .= "cliente_tipo = " . quotedstr($request->cliente_tipo) . " AND ";
        }
        if (!empty($request->cliente_id)) {
            if (is_numeric($request->cliente_id)) {
                $query .= "tbdm_clientes_geral.cliente_id = " . quotedstr($request->cliente_id) . " AND ";
            } else {
                $query .= "tbdm_clientes_geral.cliente_nome like '%" . $request->cliente_id . "%' AND ";
            }
        }

        if (!empty($request->cliente_doc)) {

            $query .= "tbdm_clientes_geral.cliente_doc = " . quotedstr(removerCNPJ($request->cliente_doc)) . " AND ";
        }

        if (!empty($request->empresa_id)) {
            if (is_numeric($request->empresa_id)) {

                $query .= "emp_id = " . $request->empresa_id;
            } else {

                $empresasGeral = Empresa::where('emp_nmult', 'like', '%' . $request->empresa_id . '%')->get(['emp_id'])->pluck('emp_id')->toArray();

                if ($empresasGeral) {
                    $query .= selectItens($empresasGeral, 'tbdm_clientes_emp.emp_id');
                }
            }
        }

        $query = rtrim($query, "AND ");

        if (!empty($query)) {
            $data = Cliente::join('tbdm_clientes_emp', 'tbdm_clientes_geral.cliente_id', '=', 'tbdm_clientes_emp.cliente_id')
                ->select(
                    'tbdm_clientes_geral.*',
                    'tbdm_clientes_emp.emp_id',
                )
                ->whereRaw(DB::raw($query))->get();
        }

        $this->permissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if (in_array('cliente.edit', $this->permissions)) {
                    $btn .= '<a href="cliente/' . $row->cliente_id . '/alterar" class="btn btn-primary btn-sm mr-1" title="Editar"><i class="fas fa-edit"></i></a>';
                }

                $disabled = "";
                if ($row->status->cliente_sts == EmpresaStatusEnum::ATIVO)
                    $disabled = "disabled";

                $btn .= '<button href="#" class="btn btn-primary btn-sm mr-1" ' . $disabled . ' id="active_grid_id" data-url="cliente" data-id="' . $row->cliente_id . '" title="Ativar"><i class="far fa-check-circle"></i></button>';

                $disabled = "";
                if ($row->status->cliente_sts == EmpresaStatusEnum::INATIVO)
                    $disabled = "disabled";

                $btn .= '<button href="#" class="btn btn-primary btn-sm mr-1" ' . $disabled . ' id="inactive_grid_id" data-url="cliente" data-id="' . $row->cliente_id . '" title="Inativar"><i class="fas fa-ban"></i></button>';

                if (in_array('cliente.destroy', $this->permissions)) {
                    $disabled = "";
                    if ($row->status->cliente_sts == EmpresaStatusEnum::EXCLUIDO)
                        $disabled = "disabled";
                    $btn .= '<button href="#" class="btn btn-sm btn-primary mr-1" ' . $disabled . ' id="delete_grid_id" data-url="cliente" data-id="' . $row->cliente_id . '" title="Excluir"><i class="far fa-trash-alt"></i></button>';
                }
                $btn .= '';

                return $btn;
            })->editColumn('cliente_cel', function ($row) {
                $badge = formatarTelefone($row->cliente_cel);
                return $badge;
            })->editColumn('cliente_doc', function ($row) {
                $badge = strlen($row->cliente_doc) == 18 ? formatarCNPJ($row->cliente_doc) : formatarCPF($row->cliente_doc);
                return $badge;
            })->editColumn('cliente_tipo', function ($row) {
                $badge = '';
                if (!empty($row->tipo)) {

                    switch ($row->tipo->cliente_tipo) {
                        case 1:
                            $badge = '<span class="badge badge-info">' . $row->tipo->cliente_tipo_desc . '</span>';
                            break;
                        case 2:
                        case 3:
                        case 4:
                            $badge = '<span class="badge badge-success">' . $row->tipo->cliente_tipo_desc . '</span>';
                            break;
                    }
                }

                return $badge;
            })->editColumn('cliente_sts', function ($row) {
                $badge = '';
                if (!empty($row->status)) {

                    switch ($row->status->cliente_sts) {

                        case 'AT':
                            $badge = '<span class="badge badge-success">' . $row->status->cliente_sts_desc . '</span>';
                            break;
                        case 'NA':
                            $badge = '<span class="badge badge-warning">' . $row->status->cliente_sts_desc . '</span>';
                            break;
                        case 'IN':
                        case 'EX':
                        case 'BL':
                            $badge = '<span class="badge badge-danger">' . $row->status->cliente_sts_desc . '</span>';
                            break;
                    }
                }

                return $badge;
            })->editColumn('cliente_id', function ($row) {
                //$id = str_pad($row->cliente_id, 5, "0", STR_PAD_LEFT);
                return $row->cliente_id;
            })
            ->rawColumns(['action', 'cliente_doc', 'cliente_sts', 'cliente_tipo'])
            ->make(true);
    }

    //Cartão
    public function storeCard(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'emp_id' => 'required',
                'card_tp' => 'required',
                'card_mod' => 'required',
                'card_categ' => 'required',
                'card_desc' => 'required',
                'card_limite' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors(),

                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();

            $data = DB::connection('dbsysclient')->table('tbdm_clientes_card')->insert([
                'emp_id' => $request->emp_id,
                'cliente_id' => $request->cliente_id,
                'cliente_doc' => removerCNPJ($request->cliente_doc),
                'cliente_pasprt' => $request->cliente_pasprt,
                'card_uuid' => Str::uuid()->toString(),
                'card_tp' => $request->card_tp,
                'card_mod' => $request->card_mod,
                'card_categ' => $request->card_categ,
                'card_desc' => mb_strtoupper(rtrim($request->card_desc), 'UTF-8'),
                'criador' => Auth::user()->user_id,
                'dthr_cr' => Carbon::now(),
                'modificador' => Auth::user()->user_id,
                'dthr_ch' => Carbon::now(),
            ]);

            if ($data) {
                DB::commit();
                return response()->json([
                    'title' => 'Sucesso',
                    'text' => 'Registro criado com sucesso!',
                    'type' => 'success',
                    'data' => $data
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'title' => 'Erro',
                'text' => $th->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    public function updateCard(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'tabela' => 'required',
                'campo' => 'required',
                'emp_id' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors(),

                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $data = DB::connection('dbsysclient')->table('tbcf_config_wf')
                ->where('tabela', '=', $request->tabela)
                ->where('campo', '=', $request->campo)
                ->where('user_id', '=', $request->user_id)
                ->where('emp_id', '=', $request->emp_id)->update([
                    "tabela" => $request->tabela,
                    "campo" => $request->campo,
                    "user_id" => $request->user_id,
                    "emp_id" => $request->emp_id,
                ]);

            return response()->json([
                'title' => 'Sucesso',
                'text' => 'Work Flow atualizado com sucesso!',
                'type' => 'success',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'title' => 'Erro',
                'text' => $th->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    public function editCard(Request $request, $emp_id)
    {
        try {

            $data = DB::connection('dbsysclient')->table('tbcf_config_wf')
                ->where('tabela', '=', $request->tabela)
                ->where('campo', '=', $request->campo)
                ->where('emp_id', '=', $request->emp_id)->first();

            $columnsList = DB::connection('dbsysclient')->getSchemaBuilder()->getColumnListing($request->tabela);
            $columns = [];

            foreach ($columnsList as $key => $col) {
                $columns[] = ['id' => $col, 'text' => $col];
            }

            if ($data) {
                return response()->json([
                    'title' => 'Sucesso',
                    'text' => 'Resposta obtida com sucesso!',
                    'type' => 'success',
                    'data' => $data,
                    'columns' => $columns,
                ]);
            }

            return response()->json([
                'title' => 'Erro',
                'text' => 'Registro não encontrado!',
                'type' => 'error'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json([
                'title' => 'Erro',
                'text' => $th->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    public function destroyCard(Request $request, $emp_id)
    {
        try {

            $data = DB::connection('dbsysclient')->table('tbcf_config_wf')
                ->where('tabela', '=', $request->tabela)
                ->where('campo', '=', $request->campo)
                ->where('emp_id', '=', $request->emp_id)->delete();

            if ($data) {
                return response()->json([
                    'title' => 'Sucesso',
                    'text' => 'Registro deletado com sucesso!',
                    'type' => 'success',
                    'btnPesquisar' => 'btnPesquisarWf'
                ]);
            }

            return response()->json([
                'title' => 'Erro',
                'text' => 'Registro não encontrado!',
                'type' => 'error'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'title' => 'Erro',
                'text' => $th->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    public function getObterGridPesquisaCard(Request $request)
    {

        if (!Auth::check()) {
            abort(Response::HTTP_UNAUTHORIZED, "Usuário não autenticado...");
        }

        $data = new Collection();

        $query = "";

        if (!empty($request->tabela_filtro)) {

            $query .= "tabela = " . quotedstr($request->tabela_filtro) . " AND ";
        }

        if (!empty($request->emp_id)) {

            if (is_numeric($request->emp_id)) {

                $query .= "emp_id = " . $request->emp_id;
                $data = TbCfWorkFlow::whereRaw(DB::raw($query))->get();
            } else {

                $empresasGeral = Empresa::where('emp_nmult', 'like', '%' . $request->emp_id . '%')->get(['emp_id'])->pluck('emp_id')->toArray();
                if ($empresasGeral) {
                    $query .= selectItens($empresasGeral, 'emp_id');
                    $data = TbCfWorkFlow::whereRaw(DB::raw($query))->get();
                }
            }
        }

        $this->permissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';

                if (in_array('config-sistema-multmais.edit', $this->permissions)) {

                    $btn .= '<button type="button" ';
                    $btn .= 'data-emp-id="' . $row->emp_id . '" ';
                    $btn .= 'data-tabela="' . $row->tabela . '" ';
                    $btn .= 'data-campo="' . $row->campo . '" ';
                    $btn .= 'class="btn btn-primary btn-sm mr-1 btn-edit" title="Editar"><i class="fas fa-edit"></i></a>';
                }

                if (in_array('config-sistema-multmais.destroy', $this->permissions)) {

                    $btn .= '<button href="#" class="btn btn-sm btn-primary mr-1 delete_id " ';
                    $btn .= 'data-emp-id="' . $row->emp_id . '" ';
                    $btn .= 'data-tabela="' . $row->tabela . '" ';
                    $btn .= 'data-campo="' . $row->campo . '" ';
                    $btn .= 'data-url="destroy-card" ';
                    $btn .= 'title="Excluir"><i class="far fa-trash-alt"></i></button>';
                }

                return $btn;
            })->editColumn('user', function ($row) {
                $user = User::find($row->user_id);
                $userName = "";
                if ($user) {
                    $userName = $user->user_name;
                }
                return $userName;
            })->editColumn('empresa', function ($row) {
                $emp_rzsoc = "";
                if ($row->empresa) {
                    $emp_rzsoc = $row->empresa->emp_rzsoc;
                }
                return $emp_rzsoc;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
