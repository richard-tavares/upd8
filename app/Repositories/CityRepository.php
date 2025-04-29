<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Support\Facades\DB;

class CityRepository
{
    protected $model;

    public function __construct(City $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->paginate(10);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function search(array $filters)
    {
        return City::query()
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', $filters['name'] . '%');
            })
            ->when(!empty($filters['state']), function ($query) use ($filters) {
                $query->where('state', $filters['state']);
            })
            ->orderBy('name')
            ->get();
    }

    public function getStates()
    {
        return DB::table('cities')->select('state')->distinct()->orderBy('state')->pluck('state');
    }

    public function getCitiesByState($state)
    {
        return $this->model->where('state', $state)->orderBy('name')->get(['id', 'name']);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $city = $this->model->findOrFail($id);
        $city->update($data);
        return $city;
    }

    public function delete(int $id)
    {
        $city = $this->model->findOrFail($id);
        return $city->delete();
    }
}
