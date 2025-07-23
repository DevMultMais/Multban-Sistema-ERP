<?php

namespace App\Http\Controllers\Multban\Cliente;

use App\Enums\EmpresaStatusEnum;
use App\Enums\EstoqramEnum;
use App\Enums\FiltrosEnum;
use App\Http\Controllers\Controller;
use App\Models\Multban\Auditoria\LogAuditoria;
use App\Models\Multban\Cliente\Cliente;
use App\Models\Multban\Cliente\ClienteStatus;
use App\Models\Multban\Cliente\ClienteTipo;
use App\Models\Multban\Cliente\Endereco\Cadasest;
use App\Models\Multban\Cliente\Endereco\Cadasmun;
use App\Models\Multban\Cliente\Endereco\CadasPais;
use App\Models\Multban\Empresa\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
        $cliente = new Cliente();
        $status = ClienteStatus::all();
        $tipos = ClienteTipo::all();

        return response()->view('Multban.cliente.edit', compact(
            'cliente',
            'status',
            'tipos',
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
        try {

            $emp_id = Auth::user()->emp_id;

            $cliente = new Cliente();
            $input = $request->all();

            $input['cliente_nome'] = rtrim($request->cliente_nome);
            $input['cliente_doc'] = removerCNPJ($request->cliente_doc);

            $validator = Validator::make($input, $cliente->rules(), $cliente->messages(), $cliente->attributes());

            if ($validator->fails()) {
                return response()->json([
                    'message'   => $validator->errors(),

                ], 422);
            }

            $cliente->cliente_tipo       = $request->cliente_tipo;
            $cliente->cliente_doc        = removerCNPJ($request->cliente_doc);
            $cliente->cliente_pasprt     = $request->cliente_pasprt;
            $cliente->cliente_sts        = 'NA'; /*Cliente nasce com o status "Em Análise"*/
            $cliente->cliente_uuid       = $request->cliente_uuid;
            $cliente->cliente_nome       = mb_strtoupper(rtrim($request->cliente_nome), 'UTF-8');
            $cliente->cliente_nm_alt     = mb_strtoupper(rtrim($request->cliente_nm_alt), 'UTF-8');
            $cliente->cliente_nm_card    = $request->cliente_nm_card;
            $cliente->cliente_email      = $request->cliente_email;
            $cliente->cliente_email_s    = $request->cliente_email_s;
            $cliente->cliente_cel        = $request->cliente_cel;
            $cliente->cliente_cel_s      = $request->cliente_cel_s;
            $cliente->cliente_telfixo    = $request->cliente_telfixo;
            $cliente->cliente_rendam     = $request->cliente_rendam;
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
            $cliente->dthr_cr            = Carbon::now();
            $cliente->dthr_ch            = Carbon::now();


            $cliente->save();
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

            // Session::flash("idModeloInserido", $cliente->cliente_id);

            // Session::flash('success', "Cliente " . str_pad($cliente->cliente_id, 5, "0", STR_PAD_LEFT) . " adicionado com sucesso.");

            return response()->json([
                'message'   => "Cliente " . str_pad($cliente->cliente_id, 5, "0", STR_PAD_LEFT) . " adicionado com sucesso.",
            ]);
        } catch (\Throwable $e) {
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

        $status = ClienteStatus::all();
        $tipos = ClienteTipo::all();

        $cliente = Cliente::findOrFail($id);

        return response()->view('Multban.cliente.edit', compact(
            'cliente',
            'status',
            'tipos'
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

            $idempresafilial = Auth::user()->idempresafilial;

            $cliente = Cliente::where('idempresafilial', $idempresafilial)->find($id);
            $input = $request->all();

            $input['clicgc'] = removerCNPJ($request->clicgc);
            $input['clicep'] = removerMascaraCEP($request->clicep);

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
                            $logAuditoria->idempresafilial = $idempresafilial;

                            $logAuditoria->save();
                        }
                    }
                }
            }

            $cliente->clides = mb_strtoupper(rtrim($request->clides), 'UTF-8');
            $cliente->clicgc = removerCNPJ($request->clicgc);
            $cliente->cliies = rtrim($request->cliies);
            // $cliente->clifan = $request->clifan;
            $cliente->clisig = $request->clisig;
            $cliente->cliram = $request->cliram;
            $cliente->clite1 = $request->clite1;
            $cliente->clite2 = $request->clite2;
            $cliente->clict1 = mb_strtoupper(rtrim($request->clict1), 'UTF-8');
            $cliente->clihpg = rtrim($request->clihpg);
            $cliente->clieml = rtrim($request->clieml);
            $cliente->clinfe = rtrim($request->clinfe);
            $cliente->clicep = removerMascaraCEP($request->clicep);
            $cliente->cliend = mb_strtoupper(rtrim($request->cliend), 'UTF-8');
            $cliente->clinro = mb_strtoupper(rtrim($request->clinro), 'UTF-8');
            $cliente->clicmp = mb_strtoupper(rtrim($request->clicmp), 'UTF-8');
            $cliente->clibai = mb_strtoupper(rtrim($request->clibai), 'UTF-8');
            $cliente->clipai = $request->clipai;
            $cliente->cliufe = $request->cliufe;
            $cliente->climun = $request->climun;
            $cliente->clicic = $request->clicic;
            //$cliente->clired = $request->clired;
            //$cliente->clisbr = $request->clisbr;
            $cliente->clifpg = $request->clifpg;
            $cliente->cliprz = $request->cliprz;
            $cliente->clicap = $request->clicap;
            $cliente->clinap = $request->clinap;
            //$cliente->cliadm = $request->cliadm;
            $cliente->clipdi = $request->clipdi;
            $cliente->clipac = $request->clipac;
            $cliente->clifre = $request->clifre;
            $cliente->cliobs = mb_strtoupper(rtrim($request->cliobs), 'UTF-8');

            $cliente->idempresafilial = $idempresafilial;

            $cliente->save();

            Session::flash("idModeloInserido", $cliente->id);

            Session::flash('success', "Cliente " . str_pad($cliente->id, 5, "0", STR_PAD_LEFT) . " atualizado com sucesso.");

            return response()->json([
                'message'   => 'Processando...',
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
                'title' => 'Erro',
                'text' => $e->getMessage(),
                'type' => 'error'
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
            if(is_numeric($request->cliente_id)){
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
            $data = Cliente::
            join('tbdm_clientes_emp', 'tbdm_clientes_geral.cliente_id', '=', 'tbdm_clientes_emp.cliente_id')
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
                $id = str_pad($row->cliente_id, 5, "0", STR_PAD_LEFT);
                return $id;
            })
            ->rawColumns(['action', 'cliente_doc', 'cliente_sts', 'cliente_tipo'])
            ->make(true);
    }
}
