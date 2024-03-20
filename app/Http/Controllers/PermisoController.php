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
            //dd($request->input("nombre"));
            $record = Permiso::where("nombre", $nombre)->first();

            if($record){
                return response()->json(["status"=> 'conflict', "data"=> null,
            "message"=>'Ya existe un permiso con ese nombre'],409);
            }

            //creamos la instancia de permiso y llenamos el objeto
            $permiso = new Permiso();
            $permiso->nombre = $request->nombre;
            $permiso->ruta = $request->ruta;
            $permiso->agregar = $request->agregar;
            $permiso->editar = $request->editar;
            $permiso->listar = $request->listar;
            $permiso->eliminar = $request->eliminar;
            //$result = $permiso->save();            
                
            if($permiso->save() >0){
                return response()->json(["status"=> 'Created', 
                "data"=> $permiso, "message"=>'Permiso registrado'],201);
            }else{
                return response()->json(["status"=> 'fail',"data"=> null,
               "message"=>"Error al intentar guardar el permiso"],409);
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
            $permiso = Permiso::findOrFail($id);
            return response()->json($permiso);
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
            $record = Permiso::where("nombre", $nombre)->first();
            if($record){
                return response()->json(["status"=> 'conflict', "data"=> null,
                "message"=>'Ya existe una permiso con este nombre'],409);
            }else{
                $permiso = Permiso::findOrFail($id);
                $permiso->nombre = $request->nombre;
                if($permiso->update() >0){
                    return response()->json(["status"=> 'Updated',
                    "data"=> $permiso,"message"=>'Permiso actualizado...!'],202);
                }else{
                    return response()->json(["status"=> 'fail',"data"=> null,
                    "message"=>"Error al intentar guardar el permiso"],409);
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
            $permiso = Permiso::findOrFail($id);
            if($permiso->delete()>0){
                return response()->json(["status"=> 'Deleted',
                "data"=> null,"message"=>'Permiso eliminado...!'],205);
            }else{
                return response()->json(["status"=> 'Conflict',
                "data"=> null,"message"=>' No se puede eliminar este permiso'],409);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
