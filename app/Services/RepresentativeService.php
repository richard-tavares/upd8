<?php

namespace App\Services;

use App\Repositories\RepresentativeRepository;

class RepresentativeService
{
    protected $repository;

    public function __construct(RepresentativeRepository $repository)
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

    public function getStatesFromRepresentatives()
    {
        return $this->repository->getStatesFromRepresentatives();
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
