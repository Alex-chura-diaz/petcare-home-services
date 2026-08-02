<?php
namespace App\Domains\Reservas\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Reservas\Models\Reserva;
use App\Domains\Mascotas\Models\Mascota;
use App\Domains\Servicios\Models\Servicio;
use App\Domains\Proveedores\Models\Proveedor;
use App\Services\ReservaService;
use App\Http\Controllers\Controller;
use Exception;

class ReservaViewController extends Controller
{
    protected ReservaService $reservaService;

    public function __construct(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }

    public function index()
    {
        $reservas = Reserva::with(['mascota', 'servicio', 'proveedor'])
            ->where('user_id', auth()->id())
            ->orderByDesc('fecha_hora')
            ->get();

        return view('reservas.index', compact('reservas'));
    }

    public function create()
    {
        $mascotas = Mascota::where('user_id', auth()->id())->get();
        $servicios = Servicio::where('estado', 'activo')->get();
        $proveedores = Proveedor::where('estado', 'activo')->get();

        return view('reservas.create', compact('mascotas', 'servicios', 'proveedores'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'modalidad' => 'required|in:recogida_entrega,visita_domicilio,en_local',
            'direccion_visita' => 'nullable|string',
            'fecha_hora' => 'required|date',
            'metodo_pago' => 'required|in:en_linea,en_lugar',
            'notas' => 'nullable|string',
        ]);

        $datos['user_id'] = auth()->id();
        $datos['estado'] = 'pendiente';

        try {
            $this->reservaService->crear($datos);
            return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['vacuna' => $e->getMessage()]);
        }
    }
}