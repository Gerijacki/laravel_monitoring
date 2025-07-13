<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Laravel Monitoring API",
 *     version="1.0.0",
 *     description="Documentació per una api de monitorització d'errors feta amb Laravel",
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor local"
 * )
 */
class EventController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/events",
     *     summary="Registrar un nou error",
     *     tags={"Events"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"type", "occurred_at"},
     *             @OA\Property(property="type", type="string", example="error"),
     *             @OA\Property(property="title", type="string", example="Error al guardar"),
     *             @OA\Property(property="payload", type="object", example={"error_code": 123}),
     *             @OA\Property(property="occurred_at", type="string", format="date-time", example="2025-07-12T12:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event creat amb èxit",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validació fallida",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autoritzat"
     *     )
     * )
     */
    public function storeEvent(StoreEventRequest $request)
    {
        $project = $request->get('project');

        $validated = $request->validated();

        $project->events()->create([
            'type' => $validated['type'],
            'title' => $validated['title'] ?? null,
            'payload' => $validated['payload'] ?? null,
            'occurred_at' => $validated['occurred_at'],
        ]);

        return response()->json(['status' => 'ok']);
    }
}
