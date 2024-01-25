<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaracteristicaRequest;
use App\Http\Requests\UpdatePresentacioneRequest;
use App\Models\Caracteristica;
use App\Models\Presentacione;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class presentacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentaciones = Presentacione::with('caracteristica')->latest()->get();

        return view('presentacione.index', ['presentaciones' => $presentaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentacione.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaracteristicaRequest $request)
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentaciones()->create([
                'presentacione_id' => $caracteristica->id
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('presentaciones.index')->with('success', 'Presentaciones Registrada');
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
    public function edit(Presentacione $presentacione)
    {
        return view('presentacione.edit', ['presentacione' => $presentacione]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentacioneRequest $request, Presentacione $presentacione)
    {
        Caracteristica::where('id', $presentacione->caracteristica->id)
            ->update($request->validated());

        return redirect()->route('presentaciones.index')->with('success', 'Presentación editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $presentacione = Presentacione::find($id);
        if ($presentacione->caracteristica->estado == 1) {
            Caracteristica::where('id', $presentacione->caracteristica->id)
                ->update([
                    'estado' => 0
                ]);
            $message = 'Presentación Eliminada';
        } else {
            Caracteristica::where('id', $presentacione->caracteristica->id)
                ->update([
                    'estado' => 1
                ]);
            $message = 'Presentación Restaurada';
        }

        return redirect()->route('presentaciones.index')->with('success', $message);
    }
}
