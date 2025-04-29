<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepresentativeRequest;
use App\Http\Requests\UpdateRepresentativeRequest;
use App\Http\Resources\RepresentativeResource;
use App\Services\RepresentativeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class RepresentativesController extends Controller
{
    protected $service;

    public function __construct(RepresentativeService $service)
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

        $representatives = $this->service->search($filters);
        return response()->json(RepresentativeResource::collection($representatives));
    }

    public function store(StoreRepresentativeRequest $request): JsonResponse
    {
        $city = $this->service->create($request->validated());
        return response()->json(new RepresentativeResource($city), Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $city = $this->service->getById($id);
        return response()->json(new RepresentativeResource($city));
    }

    public function update(UpdateRepresentativeRequest $request, int $id): JsonResponse
    {
        $city = $this->service->update($id, $request->validated());
        return response()->json(new RepresentativeResource($city));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function getStatesFromRepresentatives(): JsonResponse
    {
        $states = $this->service->getStatesFromRepresentatives();
        return response()->json($states);
    }
}
