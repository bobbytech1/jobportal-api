<?php

namespace App\Services;

use App\Repositories\ApplicationRepository;

class ApplicationService
{
    protected $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function getAllApplications()
    {
        return $this->applicationRepository->all();
    }

    public function getApplicationById($id)
    {
        return $this->applicationRepository->find($id);
    }

    public function createApplication(array $data)
    {
        return $this->applicationRepository->create($data);
    }

    public function updateApplication($id, array $data)
    {
        return $this->applicationRepository->update($id, $data);
    }

    public function deleteApplication($id)
    {
        return $this->applicationRepository->delete($id);
    }
}