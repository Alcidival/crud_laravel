<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::all();

        //dd($cursos);
        return view('curso.index', ['cursos' => $cursos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('curso.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoRequest $request)
    {
        $curso = Curso::create([
            'name' => $request['name'],
            'description' => $request['description'],
        ]);

        if ($curso) {
            return redirect()
                ->route('curso.index')
                ->with('success', 'Curso criado com sucesso!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Não foi possível cadastrar o curso!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        return view('curso.update', ['curso' => $curso]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CursoRequest $request, Curso $curso)
    {
        $atualizou = $curso->update([
            'name' => $request['name'],
            'description' => $request['description'],
        ]);

        if ($atualizou) {
            return redirect()
                ->route('curso.index')
                ->with('success', 'Curso atualizado com sucesso!');
        } else {
            return redirect()
                ->route('curso.index')
                ->with('error', 'Não foi possível atualizar o curso!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
