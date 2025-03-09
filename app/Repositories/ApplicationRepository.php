<?php

namespace App\Repositories;

use App\Models\Application;
use App\Repositories\BaseRepositoryInterface;

class ApplicationRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Application $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $application = $this->find($id);
        $application->update($data);
        return $application;
    }

    public function delete($id)
    {
        $application = $this->find($id);
        $application->delete();
        return true;
    }
}