<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Incidente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidenteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try{
            $incidentes = Incidente::with(['imagenes','seguimientos','usuario'])->get();
            return response()->json($incidentes);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function create()
    {
        return view('admin.crearIncidente');
    }
    /* public function dash(){
        return view('admin.index');
    } */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $descripcion = $request->descripcion;


            $incidente = new Incidente();
            $incidente->descripcion = $descripcion;
            $incidente->usuario_id = 1; // Dato quedamo por el momento
            $incidente->tecnico_id = 1; // Dato quedamo por el momento
            $incidente->estado = 1;
            $incidente->fecha_registro = Carbon::now();



            $imageUrls = []; // Inicializamos un array para almacenar las URL de las imágenes


                // Iteramos sobre cada archivo recibido
                foreach ( $request->file("imagenes") as $file ) {
                    // Obtener el nombre original del archivo
                    $name = $file->getClientOriginalName();
                    // Generar un nombre único para el archivo
                    $currentTimestamp = time();
                    $nameFile = date('Y-m-d His', $currentTimestamp). '.' . $file->getClientOriginalExtension();
                    // Almacenar el archivo en el directorio 'imagenes' dentro del disco 'public'
                    $file->storeAs('imagenes', $name, 'public');
                    // Generar la URL completa para el archivo almacenado
                    $imageUrl = asset('storage/imagenes/'.$name); // Asegúrate de que la ruta sea correcta según la configuración de tu sistema de archivos
                    // Agregar la URL al array de URLs de imágenes
                    $imageUrls[] = $imageUrl;
                }


            if ($incidente->save() > 0) {
                $incidenteId = $incidente->id; // Aquí obtenemos el ID insertado

                // Iteramos sobre cada URL de imagen
                foreach ( $imageUrls as $imageUrl ) {
                    $imagen = new Imagen();
                    $imagen->url = $imageUrl;
                    $imagen->incidente_id = $incidenteId;
                    $imagen->save();
                }

                return response()->json([
                    "status"    => 'Created',
                    "data"      => $incidenteId,
                    "PRUEBA" => $imageUrls,
                    "message"   => 'Incidente registrado'
                ], 201);
            } else {
                return response()->json([
                    "status"  => 'fail',
                    "data"    => null,
                    "message" => "Error al intentar guardar el departamento"
                ], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
