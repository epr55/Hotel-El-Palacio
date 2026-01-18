<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PagoController extends Controller
{
    private $paymentApiUrl = 'https://tpv-backend-cbbg.onrender.com';
    
    private function getApiKey()
    {
        return env('TPV_API_KEY', 'sk_94b4d0da-252b-41d1-93ea-cfcad0140665');
    }
    
    public function initPayment(Request $request)
    {
        Log::info('Iniciando proceso de pago', ['user' => auth()->user()->correo ?? auth()->id()]);
        
        $request->validate([
            'reserva_id' => 'nullable|integer',
            'cliente_id' => 'nullable|integer|exists:users,id',
            'importe' => 'required|numeric|min:0',
            'habitacion_id' => 'required|integer',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'huespedes' => 'required|integer|min:1',
            'servicios' => 'nullable|string'
        ]);

        // Decodificar servicios si viene como JSON string
        $servicios = $request->input('servicios');
        if (is_string($servicios)) {
            $servicios = json_decode($servicios, true) ?? [];
        }

        $importe = $request->input('importe');
        $callbackUrl = route('pago.confirmado');
        
        Log::info('Datos del pago', ['importe' => $importe, 'callback' => $callbackUrl]);

        try {
            // Hacer la llamada POST a la API de pagos con X-API-KEY en el header
            $response = Http::withHeaders([
                'X-API-KEY' => $this->getApiKey(),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($this->paymentApiUrl . '/api/v1/payments/init', [
                'amount' => (float)$importe,
                'callbackUrl' => $callbackUrl,
                'externalReference' => 'RESERVA-' . time()
            ]);
            
            Log::info('Respuesta de TPV', ['status' => $response->status(), 'body' => $response->body()]);

            // Manejar respuesta 200 - Todo correcto
            if ($response->status() === 200) {
                $data = $response->json();
                
                // Validar que la respuesta tiene los datos necesarios
                if (!isset($data['paymentUrl']) || !isset($data['token'])) {
                    Log::error('Respuesta de API incompleta', ['data' => $data]);
                    return back()->with('error', 'Error en la respuesta del servicio de pagos.');
                }

                // Guardar los datos de la reserva en sesión para procesar después del pago
                session([
                    'reserva_pendiente' => [
                        'reserva_id' => $request->input('reserva_id'),
                        'cliente_id' => $request->input('cliente_id'),
                        'habitacion_id' => $request->input('habitacion_id'),
                        'checkin' => $request->input('checkin'),
                        'checkout' => $request->input('checkout'),
                        'huespedes' => $request->input('huespedes'),
                        'servicios' => $servicios,
                        'importe' => $importe,
                        'token' => $data['token']
                    ]
                ]);

                // Redirigir a la URL del TPV
                return redirect($data['paymentUrl']);
            }
            
            // Manejar respuesta 400 - Error en la API key
            if ($response->status() === 400) {
                Log::error('Error de API Key en TPV', [
                    'status' => 400,
                    'body' => $response->body()
                ]);
                return back()->with('error', 'Error de configuración. Contacte con el administrador.');
            }
            
            // Manejar respuesta 429 - Demasiadas peticiones
            if ($response->status() === 429) {
                Log::warning('Too many requests en TPV', ['status' => 429]);
                return back()->with('error', 'Servicio temporalmente saturado. Por favor, inténtalo en unos minutos.');
            }
            
            // Cualquier otro error
            Log::error('Error inesperado en la API de pagos', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return back()->with('error', 'No se pudo iniciar el proceso de pago. Por favor, inténtalo de nuevo.');
            
        } catch (\Exception $e) {
            Log::error('Excepción al iniciar pago: ' . $e->getMessage());
            
            return back()->with('error', 'Error al conectar con el servicio de pagos. Por favor, inténtalo más tarde.');
        }
    }

    public function pagoConfirmado(Request $request)
    {
        // Esta es la página a la que redirige el TPV después del pago
        $reservaPendiente = session('reserva_pendiente');
        
        if (!$reservaPendiente || !isset($reservaPendiente['token'])) {
            return redirect()->route('home')->with('error', 'No se encontró información de la reserva.');
        }

        $token = $reservaPendiente['token'];

        try {
            // Verificar el estado del pago con la API
            $response = Http::withHeaders([
                'X-API-KEY' => $this->getApiKey()
            ])->get($this->paymentApiUrl . '/api/v1/payments/verify/' . $token);

            // Error 403 - API Key incorrecta
            if ($response->status() === 403) {
                Log::error('Error de autenticación al verificar pago', ['token' => $token]);
                session()->forget('reserva_pendiente');
                return view('pago-resultado', [
                    'success' => false,
                    'mensaje' => 'Error de configuración. Contacte con el administrador.'
                ]);
            }

            // Respuesta 200 - Verificación exitosa
            if ($response->status() === 200) {
                $data = $response->json();
                
                // Verificar el estado del pago
                if ($data['status'] === 'COMPLETED') {
                    // Pago exitoso - Crear la reserva en la base de datos
                    if (!empty($reservaPendiente['reserva_id'])) {
                        $reserva = Reserva::find($reservaPendiente['reserva_id']);
                        if ($reserva) {
                            $reserva->update([
                                'fecha_inicio' => $reservaPendiente['checkin'],
                                'fecha_final' => $reservaPendiente['checkout'],
                                'precio_total' => $reservaPendiente['importe'],
                                'estado' => 'confirmada'
                            ]);
                        }
                    } else {
                        $reserva = Reserva::create([
                            'user_id' => $reservaPendiente['cliente_id'] ?? Auth::id(),
                            'habitacion_id' => $reservaPendiente['habitacion_id'],
                            'fecha_inicio' => $reservaPendiente['checkin'],
                            'fecha_final' => $reservaPendiente['checkout'],
                            'precio_total' => $reservaPendiente['importe'],
                            'estado' => 'confirmada',
                            'temporada_id' => 1
                        ]);
                    }

                    // Guardar los Servicios Extra
                    if ($reserva && !empty($reservaPendiente['servicios'])) {
                        $datosSync = [];
                        
                        foreach ($reservaPendiente['servicios'] as $s) {
                            $datosSync[$s['id']] = ['cantidad_personas' => $s['cantidad']];
                        }
                        
                        // Ahora sync guardará el ID del servicio Y la cantidad
                        $reserva->servicios()->sync($datosSync);
                    }
                    
                    session()->forget('reserva_pendiente');
                    
                    return view('pago-resultado', [
                        'success' => true,
                        'mensaje' => '¡Pago completado con éxito! Tu reserva ha sido confirmada.',
                        'reserva' => $reservaPendiente
                    ]);
                } 
                
                if ($data['status'] === 'FAILED') {
                    // Pago fallido
                    $failureReason = $data['failureReason'] ?? 'Error desconocido';
                    
                    Log::warning('Pago fallido', [
                        'token' => $token,
                        'reason' => $failureReason
                    ]);
                    
                    session()->forget('reserva_pendiente');
                    
                    return view('pago-resultado', [
                        'success' => false,
                        'mensaje' => 'El pago no se pudo completar: ' . $failureReason
                    ]);
                }
                
                // Estado desconocido
                Log::error('Estado de pago desconocido', ['data' => $data]);
                return view('pago-resultado', [
                    'success' => false,
                    'mensaje' => 'Estado del pago desconocido. Contacte con soporte.'
                ]);
            }

            // Cualquier otro código de respuesta
            Log::error('Error al verificar pago', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return view('pago-resultado', [
                'success' => false,
                'mensaje' => 'Error al verificar el estado del pago. Contacte con soporte.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Excepción al verificar pago: ' . $e->getMessage());
            
            return view('pago-resultado', [
                'success' => false,
                'mensaje' => 'Error al conectar con el servicio de pagos. Contacte con soporte.'
            ]);
        }
    }
}
