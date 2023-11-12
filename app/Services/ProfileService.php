<?php

namespace App\Services;

use App\Repositories\Admin\ProfileRepository;
use Carbon\Carbon;


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

    public function getGraphic(int $user, int $day, Carbon $current_date): array
    {
        $end_date = $current_date->clone()->subDays($day);
        $start_date = $current_date->clone()->subDays(9 + $day);
        $result = $this->profileRepository->getGraphicData($end_date, $start_date, $user);
        $days = [];
        $reportData = [];

        for ($i = 0; $i < 9; $i++) {
            $month = $end_date->format('Y-m-d');
            $days[] = $month;
            $reportData[$month] = 0;
            $end_date->subDay();
        }
        foreach ($result as $item) {
            $day = $item->day;
            $reportData[$day] = $item->context_count;
        }
        foreach ($days as $day) {
            $finalReport[] = ['day' => $day, 'context_count' => $reportData[$day]];
        }

        return ['data' => array_reverse($finalReport)];
    }
}
