<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $permisos = Permiso::all();
            return response()->json($permisos); 
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.permisos");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $nombre = $request->input("nombre");
            $record = Departamento::where("nombre", $nombre)->first();

            if($record){
                return response()->json(["status"=> 'conflict', "data"=> null,
            "message"=>'Ya existe un departamento con este nombre'],409);
            }
                
            $departamento = new Departamento();
            $departamento->nombre = $request->nombre;
            if($departamento->save() >0){
                return response()->json(["status"=> 'Created', 
                "data"=> $departamento, "message"=>'Departamento registrado'],201);
            }else{
                return response()->json(["status"=> 'fail',"data"=> null,
               "message"=>"Error al intentar guardar el departamento"],409);
            }            
        }catch(\Exception $e){
            return $e->getMessage();
        }        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $departamento = Departamento::findOrFail($id);
            return response()->json($departamento);
        }catch(\Exception $e) {
            return $e->getMessage();
        }
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
        try{
            $nombre = $request->input("nombre");
            $record = Departamento::where("nombre", $nombre)->first();
            if($record){
                return response()->json(["status"=> 'conflict', "data"=> null,
                "message"=>'Ya existe una departamento con este nombre'],409);
            }else{
                $departamento = Departamento::findOrFail($id);
                $departamento->nombre = $request->nombre;
                if($departamento->update() >0){
                    return response()->json(["status"=> 'Updated',
                    "data"=> $departamento,"message"=>'Departamento actualizado...!'],202);
                }else{
                    return response()->json(["status"=> 'fail',"data"=> null,
                    "message"=>"Error al intentar guardar el departamento"],409);
                }
            }           
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $departamento = Departamento::findOrFail($id);
            if($departamento->delete()>0){
                return response()->json(["status"=> 'Deleted',
                "data"=> null,"message"=>'Departamento eliminado...!'],205);
            }else{
                return response()->json(["status"=> 'Conflict',
                "data"=> null,"message"=>' No se puede eliminar este departamento'],409);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
