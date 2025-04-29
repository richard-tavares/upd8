<?php

namespace App\Services;

use App\Repositories\CityRepository;

class CityService
{
    protected $repository;

    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getById(int $id)
    {
        return $this->repository->find($id);
    }

    public function search(array $filters)
    {
        return $this->repository->search($filters);
    }

    public function getStates()
    {
        return $this->repository->getStates();
    }

    public function getCitiesByState($state)
    {
        return $this->repository->getCitiesByState($state);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
