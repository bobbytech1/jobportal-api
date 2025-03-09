<?php 
namespace App\Repositories;

use App\Models\Job;
use App\Repositories\BaseRepositoryInterface;

class JobRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Job $model)
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
        $job = $this->find($id);
        $job->update($data);
        return $job;
    }

    public function delete($id)
    {
        $job = $this->find($id);
        $job->delete();
        return true;
    }
}