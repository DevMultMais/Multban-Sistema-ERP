<?php

namespace App\Http\Controllers\Multban\Agendamento;

use App\Http\Controllers\Controller;
use App\Models\Multban\Agendamento\Agendamento;
use App\Models\Multban\Cliente\Cliente;
use App\Models\Multban\DadosMestre\TbDmAgendamentoStatus;
use App\Models\Multban\DadosMestre\TbDmAgendamentoTipo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Agendamento::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end', 'description']);

            return response()->json($data);
        }

        return view('Multban.agendamento.index');
    }

    public function getAgenda(Request $request)
    {
        $data = Agendamento::whereDate('start', '>=', $request->start)
            ->whereDate('end',   '<=', $request->end)
            ->get(['id', 'title', 'start', 'end', 'description']);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agendamento = new Agendamento();

        $status = TbDmAgendamentoStatus::all();
        $tipos = TbDmAgendamentoTipo::all();
        $users = User::whereIn('user_func', [
            '1',
            '2',
            '5',
            '6',
            '7',
            '9',
            '10',
            '12',
            '13',
            '14',
            '15',
            '21',
        ])->get();

        return view('Multban.agendamento.edit', compact('agendamento', 'status', 'tipos', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $agendamento = new Agendamento();

            dd($request->all());

            $validator = Validator::make($request->all(), $agendamento->rules(), $agendamento->messages(), $agendamento->attributes());

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors(),

                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }






            Session::flash('success', "Agendamento criado com sucesso.");

            Session::flash("idModeloInserido", $agendamento->id);

            return response()->json([
                'message' => 'Processando...',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return redirect()->route('agendamento.index')
                ->with('error', 'Agendamento não encontrado.');
        }

        $status = TbDmAgendamentoStatus::all();
        $tipos = TbDmAgendamentoTipo::all();
        $users = User::whereIn('user_func', [
            '1',
            '2',
            '5',
            '6',
            '7',
            '9',
            '10',
            '12',
            '13',
            '14',
            '15',
            '21',
        ])->get();

        $agendamento->date = Carbon::createFromFormat('Y-m-d', $agendamento->date)->format('d/m/Y');
        $agendamento->start = Carbon::createFromFormat('Y-m-d H:i:s', $agendamento->start)->format('H:i');
        $agendamento->end = Carbon::createFromFormat('Y-m-d H:i:s', $agendamento->end)->format('H:i');

        return view('Multban.agendamento.edit', compact('agendamento', 'status', 'tipos', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            DB::beginTransaction();

            $agendamento = Agendamento::find($id);
            //dd($request->all());

            $validator = Validator::make($request->all(), $agendamento->rules(), $agendamento->messages(), $agendamento->attributes());

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors(),
                    'message_type' => 'Verifique os campos obrigatórios e tente novamente.',

                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $agendamento->agendamento_tipo = $request->agendamento_tipo;
            $agendamento->cliente_id = $request->cliente_id;
            $agendamento->user_id = $request->user_id;
            $agendamento->description = $request->description;
            $agendamento->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');

            $agendamento->start = Carbon::createFromFormat('d/m/Y H:i', $request->date . ' ' . $request->start)->format('Y-m-d H:i:s');
            $agendamento->end = Carbon::createFromFormat('d/m/Y H:i', $request->date . ' ' . $request->end)->format('Y-m-d H:i:s');

            $agendamento->observacao = $request->observacao;
            // $agendamento->backgroundColor = $request->backgroundColor;
            // $agendamento->borderColor = $request->borderColor;
            // $agendamento->textColor = $request->textColor;
            $agendamento->status = $request->status;
            $agendamento->modificador = auth()->user()->user_id;
            $agendamento->dthr_ch = now();
            $agendamento->save();
            DB::commit();

            return response()->json([
                'message'   => "Agendamento atualizado com sucesso.",
            ]);
        } catch (Exception | \Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getCliente(Request $request)
    {
        $parametro = $request != null ? $request->all()['parametro'] : '';
        $campo = 'cliente_nome';

        if (empty($parametro)) {
            return [];
        }

        if (!empty($request->campo)) {
            $campo = $request->campo;
        }

        return Cliente::select(DB::raw('cliente_id as id, cliente_id,cliente_rg, cliente_dt_nasc, cliente_email,cliente_cel,cliente_telfixo, cliente_doc, UPPER(' . $campo . ') text'))
            ->whereRaw(DB::raw($campo . " LIKE '%" . $parametro . "%' OR cliente_id = '%" . $parametro . "%'"))
            ->get()
            ->toArray();
    }
}
