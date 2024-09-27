<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\User;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['analysis']=Analysis::all();
        return view('analysis',$datos);
    }

    public function edit(analysis $analysis)
    {
        return view('edit_analysis', compact('analysis'));
    }

    public function store(Request $request)
    {
        // return $request['productor'];
        // Validar los campos según tus necesidades
        $validatedData = $request->validate([
            'municipio' => 'required',
            'productor' => 'required',
            'ciclo' => 'required',
            'adjunto' => 'required',
        ]);
        // return $validatedData['productor'];


        $analysis = new Analysis([
            'municipio' => $validatedData['municipio'],
            'productor' => $validatedData['productor'],
            'ciclo' => $validatedData['ciclo'],
            'adjunto' => $validatedData['adjunto'],
        ]);

        $analysis->save();


        $datos['analysis']=Analysis::all();

        return view('analysis', $datos);
    }

    public function update(Request $request, Analysis $analysis)
    {
        $analysis->update($request->all());

        $datos['analysis']=Analysis::all();

        return view('analysis', $datos)->with('success', 'Análisis actualizado exitosamente.');
    }

    public function create()
    {
        return view('create_analysis');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Analysis  $analysis
     * @return \Illuminate\Http\Response
     */
    public function show(Analysis $analysis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Analysis  $analysis
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Analysis $analysis)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Analysis  $analysis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Analysis $analysis)
    {
        //
    }
}
