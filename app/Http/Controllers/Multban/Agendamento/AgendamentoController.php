<?php

namespace App\Http\Controllers\Multban\Agendamento;

use App\Http\Controllers\Controller;
use App\Models\Multban\Agendamento\Agendamento;
use App\Models\Multban\DadosMestre\TbDmAgendamentoStatus;
use App\Models\Multban\DadosMestre\TbDmAgendamentoTipo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $agendamento = new Agendamento();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
