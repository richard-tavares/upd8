<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ClientsController extends Controller
{
    protected $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'cpf',
            'name',
            'birth_date',
            'gender',
            'state',
            'city'
        ]);

        $clients = $this->service->search($filters);
        return response()->json(ClientResource::collection($clients));
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $city = $this->service->create($request->validated());
        return response()->json(new ClientResource($city), Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $city = $this->service->getById($id);
        return response()->json(new ClientResource($city));
    }

    public function update(UpdateClientRequest $request, int $id): JsonResponse
    {
        $city = $this->service->update($id, $request->validated());
        return response()->json(new ClientResource($city));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function getStatesFromClients(): JsonResponse
    {
        $states = $this->service->getStatesFromClients();
        return response()->json($states);
    }
}
