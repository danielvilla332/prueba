<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controllers;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\TarifaFormRequest;
use App\Tarifa;

class TarifaController extends Controller
{


    protected $redirectTo = '/tarifa';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        //
        $tarifa =Tarifa::all();
        return view('Tarifa.index')->with('tarifa',$tarifa);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tarifa=DB::table('tipo_vehiculos')->select('tipo_vehiculos.nombre', 'tipo_vehiculos.id')->get();
        return view('Tarifa.create')->with('tipo_vehiculo',$tarifa);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TarifaFormRequest $request)
    {
        //
        $tarifa=new Tarifa;
        $tarifa->tipo_vehiculo_id=$request->get('role_id');
        $tarifa->valor=$request->get('valor');
        $tarifa->estado=$request->get('estado');
        $tarifa->save();
        return Redirect::to('tarifa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $tarifa = Tarifa::find($id);
        return view('Tarifa.show', compact('Tarifa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tarifa = Tarifa::find($id);
        return view('Tarifa.edit', compact('tarifa')); 
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
        //
        $this->validate($request, ['role_id' => 'required', 'valor' => 'required', 'estado' => 'required']);
        Tarifa::find($id)->update($request->all());
        return redirect()->route('tarifa.index')->with('success', 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Tarifa::find($id)->delete();
        return redirect()->route('tarifa.index')->with('success', 'Registro Eliminado');
    }
}
