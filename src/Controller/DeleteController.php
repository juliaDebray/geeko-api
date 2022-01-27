<?php

namespace App\Controller;

use App\Service\StatusService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteController extends AbstractController
{
    private StatusService $statusService;
    private ManagerRegistry $entityManager;

    public function __construct(StatusService $statusService, ManagerRegistry $entityManager)
    {
        $this->statusService = $statusService;
        $this->entityManager = $entityManager;
    }

    public function __invoke($data)
    {
        $data = $this->statusService->addDisabledStatus($data);

        $entityManager = $this->entityManager->getManager();
        $entityManager->flush($data);
    }
}
