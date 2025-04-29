<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Representative;

class RepresentativeRepository
{
    protected $model;

    public function __construct(Representative $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('city')->paginate(10);
    }

    public function find(int $id)
    {
        return $this->model->with('city')->findOrFail($id);
    }

    public function search(array $filters)
    {
        return Representative::with('city')
            ->when(!empty($filters['cpf']), function ($query) use ($filters) {
                $query->where('cpf', $filters['cpf']);
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['birth_date']), function ($query) use ($filters) {
                $query->whereDate('birth_date', $filters['birth_date']);
            })
            ->when(!empty($filters['gender']), function ($query) use ($filters) {
                $query->where('gender', $filters['gender']);
            })
            ->when(!empty($filters['state']), function ($query) use ($filters) {
                $query->whereHas('city', function ($q) use ($filters) {
                    $q->where('state', $filters['state']);
                });
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where('city_id', $filters['city']);
            })
            ->get();
    }

    public function getStatesFromRepresentatives()
    {
        return DB::table('representatives')
            ->join('cities', 'representatives.city_id', '=', 'cities.id')
            ->select('cities.state')
            ->distinct()
            ->orderBy('cities.state')
            ->pluck('cities.state')
            ->toArray();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $representative = $this->model->findOrFail($id);
        $representative->update($data);
        return $representative;
    }

    public function delete(int $id)
    {
        $representative = $this->model->findOrFail($id);
        return $representative->delete();
    }
}
