<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Rol::all();
            return response()->json($roles);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.roles");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $nombre = $request->input("nombre");
            $record = Rol::where("nombre", $nombre)->first();

            if ($record) {
                return response()->json([
                    "status" => 'conflict', "data" => null,
                    "message" => 'Ya existe un rol con este nombre'], 409);
            }

            $rol = new Rol();
            $rol->nombre = $request->nombre;
            if ($rol->save() > 0) {
                return response()->json(["status" => 'Created',
                    "data" => $rol, "message" => 'Rol registrado'], 201);
            } else {
                return response()->json([
                    "status" => 'fail', "data" => null,
                    "message" => "Error al intentar guardar el rol"], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $rol = Rol::findOrFail($id);
            return response()->json($rol);
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
            $record = Rol::where("nombre", $nombre)->first();
            if($record){
                return response()->json(["status"=> 'conflict', "data"=> null,
                "message"=>'Ya existe una rol con este nombre'],409);
            }else{
                $rol = Rol::findOrFail($id);
                $rol->nombre = $request->nombre;
                if($rol->update() >0){
                    return response()->json(["status"=> 'Updated',
                    "data"=> $rol,"message"=>'Rol actualizado...!'],202);
                }else{
                    return response()->json(["status"=> 'fail',"data"=> null,
                    "message"=>"Error al intentar guardar el rol"],409);
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
            $rol = Rol::findOrFail($id);
            if($rol->delete()>0){
                return response()->json(["status"=> 'Deleted',
                "data"=> null,"message"=>'Rol eliminado...!'],205);
            }else{
                return response()->json(["status"=> 'Conflict',
                "data"=> null,"message"=>' No se puede eliminar este rol'],205);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
