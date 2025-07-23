<?php

namespace App\Http\Controllers\Multban\Produto;

use App\Http\Controllers\Controller;
use App\Models\Multban\Produto\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Multban.produto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produto = new Produto();
        return view('Multban.produto.edit', compact('produto'));
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
        //
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
