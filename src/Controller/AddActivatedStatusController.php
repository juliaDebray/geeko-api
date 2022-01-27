<?php

namespace App\Controller;

use App\Service\StatusService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddActivatedStatusController extends AbstractController
{
    private StatusService $statusService;

    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    public function __invoke($data)
    {
        return $this->statusService->addActivatedStatus($data);
    }
}
