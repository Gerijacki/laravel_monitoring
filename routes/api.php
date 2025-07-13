<?php

use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.project')->post('/events', function (StoreEventRequest $request) {
    $project = $request->get('project');

    $validated = $request->validated();

    $project->events()->create([
        'type' => $validated['type'],
        'title' => $validated['title'] ?? null,
        'payload' => $validated['payload'] ?? null,
        'occurred_at' => $validated['occurred_at'],
    ]);


    return response()->json(['status' => 'ok']);
});

