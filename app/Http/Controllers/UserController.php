<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::with(['rol','departamento'])->get(); //Cargamos las relaciones usuario-rol y usuario-departamento
            return response()->json($users);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create()
    {
        return view("admin.usuarios");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rol = $request->input("rol");
            $departamento = $request->input("departamento");
            $name = $request->input("name");
            $email = $request->input("email");

            $record = User::where("name", $name)->orWhere("email", $email)->first();

            if ($record) {
                return response()->json([
                    "status" => 'error',
                    "message" => 'Ya existe un usuario con este nombre de usuario o email.'
                ], 409);
            }

            $user = new User();
            $user->name = $name;
            $user->nombres = $request->input("nombres");
            $user->apellidos = $request->input("apellidos");
            $user->email = $request->input("email");
            $user->rol_id = $rol['id'];
            $user->departamento_id = $departamento['id'];
            $user->estado = "A";
            $user->password = Hash::make($request->input("password"));

            $user->save();

            return response()->json([
                "message" => 'Usuario registrado'
            ], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        try {
            $rol = $request->input("rol");
            $departamento = $request->input("departamento");
            $name = $request->input("name");
            $email = $request->input("email");

            $record = User::where("name", $name)->orWhere("email", $email)->first();

            if ($record && $record->id != $id) {
                return response()->json([
                    "status" => 'error',
                    "message" => 'Ya existe un usuario con este nombre de usuario o email.'
                ], 409);
            }

            $user = User::findOrFail($id);
            $user->name = $name;
            $user->nombres = $request->input("nombres");
            $user->apellidos = $request->input("apellidos");
            $user->email = $request->input("email");
            $user->rol_id = $rol['id'];
            $user->departamento_id = $departamento['id'];

            $user->update();

            return response()->json([
                "message" => 'Usuario actualizado.'
            ], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $user = User::findOrFail($id);
            if($user->delete() > 0){
                return response()->json(["status" => 'Deleted',
                "message"=>'Usuario eliminado...!'],201);
            }else{
                return response()->json(["status"=> 'Conflict',
                "message"=>' No se puede eliminar este usuario'],409);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
