<?php

namespace App\Services;

use App\Repositories\Admin\ProfileRepository;

class ProfileService
{
    protected ProfileRepository $profileRepository;
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getDiagram(): array
    {
        return ['data' => $this->profileRepository->getDiagramData()];
    }
}
