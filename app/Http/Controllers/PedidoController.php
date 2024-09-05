<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{

    public function listarPedidos()
    {
        try {
            // Obtenemos todos los pedidos con sus detalles y las relaciones de vendedor y repartidor
            $pedidos = Pedido::with(['detalles', 'vendedor', 'repartidor'])->get();

            return response()->json([
                'message' => 'Pedidos listados correctamente',
                'data' => $pedidos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al listar los pedidos',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function registrarPedido(Request $request)
    {
        // Validamos los datos de entrada
        $validator = Validator::make($request->all(), [
            'numero_pedido' => 'required|string|unique:pedidos,numero_pedido|max:255',
            'fecha_pedido' => 'required|date',
            'fecha_recepcion' => 'nullable|date',
            'fecha_despacho' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
            'vendedor_id' => 'required|exists:users,id',
            'repartidor_id' => 'required|exists:users,id',
            'estado' => 'required|in:por_atender,en_proceso,en_delivery,recibido',
            'detalles' => 'required|array',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Si la validación falla, devuelve un error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Usar transacciones para asegurar la consistencia de los datos
        DB::beginTransaction();

        try {
            // Crear el pedido
            $pedido = Pedido::create([
                'numero_pedido' => $request->numero_pedido,
                'fecha_pedido' => $request->fecha_pedido,
                'fecha_recepcion' => $request->fecha_recepcion,
                'fecha_despacho' => $request->fecha_despacho,
                'fecha_entrega' => $request->fecha_entrega,
                'vendedor_id' => $request->vendedor_id,
                'repartidor_id' => $request->repartidor_id,
                'estado' => $request->estado,
            ]);

            // Crear los detalles del pedido
            foreach ($request->detalles as $detalle) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                ]);
            }

            // Confirmar la transacción
            DB::commit();

            // Devolver la respuesta JSON exitosa
            return response()->json([
                'message' => 'Pedido y detalles creados con éxito',
                // 'pedido' => $pedido
                'pedido' => [
                    'id' => $pedido->id,
                    'numero_pedido' => $pedido->numero_pedido,
                    'fecha_pedido' => $pedido->fecha_pedido,
                    'fecha_recepcion' => $pedido->fecha_recepcion,
                    'fecha_despacho' => $pedido->fecha_despacho,
                    'fecha_entrega' => $pedido->fecha_entrega,
                    'vendedor_id' => $pedido->vendedor_id,
                    'repartidor_id' => $pedido->repartidor_id,
                    'estado' => $pedido->estado,
                    'detalles' => $request->detalles // Devuelve los detalles tal como se recibieron
                ]
            ], 201);
        } catch (\Exception $e) {
            // Deshacer la transacción si hay algún error
            DB::rollBack();

            // Devolver una respuesta de error
            return response()->json([
                'message' => 'Error al crear el pedido',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Definimos la jerarquía de estados como una propiedad de la clase
    private $estadoJerarquia = [
        'por_atender' => 1,
        'en_proceso' => 2,
        'en_delivery' => 3,
        'recibido' => 4,
    ];

    public function changeToPorAtender(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Valida que el nuevo estado no sea inferior al estado actual
        if ($this->estadoJerarquia[$pedido->estado] > $this->estadoJerarquia['por_atender']) {
            return response()->json(['error' => 'No se puede cambiar a por_atender desde un estado superior.'], 422);
        }

        // Valida la fecha de pedido 
        $validator = Validator::make($request->all(), [
            'fecha_pedido' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualiza el estado y la fecha
        $pedido->estado = 'por_atender';
        $pedido->fecha_pedido = $request->fecha_pedido;
        $pedido->save();

        return response()->json(['message' => 'El pedido ha sido actualizado a por_atender.', 'pedido' => $pedido], 200);
    }

    public function changeToEnProceso(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Valida que el estado actual no sea superior
        if ($this->estadoJerarquia[$pedido->estado] > $this->estadoJerarquia['en_proceso']) {
            return response()->json(['error' => 'No se puede cambiar a en_proceso desde el estado actual.'], 422);
        }

        // Valida la fecha de recepción 
        $validator = Validator::make($request->all(), [
            'fecha_recepcion' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pedido->estado = 'en_proceso';
        $pedido->fecha_recepcion = $request->fecha_recepcion;
        $pedido->save();

        return response()->json(['message' => 'El pedido ha sido actualizado a en_proceso.', 'pedido' => $pedido], 200);
    }

    public function changeToEnDelivery(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Valida que el estado actual no sea superior
        if ($this->estadoJerarquia[$pedido->estado] > $this->estadoJerarquia['en_delivery']) {
            return response()->json(['error' => 'No se puede cambiar a en_delivery desde el estado actual.'], 422);
        }

        // Valida la fecha de despacho
        $validator = Validator::make($request->all(), [
            'fecha_despacho' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pedido->estado = 'en_delivery';
        $pedido->fecha_despacho = $request->fecha_despacho;
        $pedido->save();

        return response()->json(['message' => 'El pedido ha sido actualizado a en_delivery.', 'pedido' => $pedido], 200);
    }

    public function changeToRecibido(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Valida que el estado actual no sea superior
        if ($this->estadoJerarquia[$pedido->estado] > $this->estadoJerarquia['recibido']) {
            return response()->json(['error' => 'No se puede cambiar a recibido desde el estado actual.'], 422);
        }

        // Validar la fecha de entrega
        $validator = Validator::make($request->all(), [
            'fecha_entrega' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pedido->estado = 'recibido';
        $pedido->fecha_entrega = $request->fecha_entrega;
        $pedido->save();

        return response()->json(['message' => 'El pedido ha sido actualizado a recibido.', 'pedido' => $pedido], 200);
    }
}
