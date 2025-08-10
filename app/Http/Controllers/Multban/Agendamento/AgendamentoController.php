<?php

namespace App\Http\Controllers\Multban\Agendamento;

use App\Http\Controllers\Controller;
use App\Models\Multban\Agendamento\Agendamento;
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
        return view('Multban.agendamento.edit', compact('agendamento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $agendamento = Agendamento::findOrFail($id);
        return view('Multban.agendamento.edit', compact('agendamento'));
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
