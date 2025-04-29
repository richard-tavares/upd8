<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Resources\CityResource;
use App\Services\CityService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CitiesController extends Controller
{
    protected $service;

    public function __construct(CityService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'name',
            'state'
        ]);

        $cities = $this->service->search($filters);
        return response()->json(CityResource::collection($cities));
    }

    public function getStates(): JsonResponse
    {
        $states = $this->service->getStates();

        return response()->json($states);
    }

    public function getCitiesByState($state): JsonResponse
    {
        $cities = $this->service->getCitiesByState($state);
        return response()->json($cities);
    }

    public function store(StoreCityRequest $request): JsonResponse
    {
        $city = $this->service->create($request->validated());
        return response()->json(new CityResource($city), Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $city = $this->service->getById($id);
        return response()->json(new CityResource($city));
    }

    public function update(UpdateCityRequest $request, int $id): JsonResponse
    {
        $city = $this->service->update($id, $request->validated());
        return response()->json(new CityResource($city));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
