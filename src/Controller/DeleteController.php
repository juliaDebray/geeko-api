<?php

namespace App\Controller;

use App\Constants\Constant;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteController extends AbstractController
{
    private ManagerRegistry $entityManager;

    public function __construct(ManagerRegistry $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($data)
    {
        $data->setStatus(Constant::STATUS_DISABLED);

        $entityManager = $this->entityManager->getManager();
        $entityManager->flush($data);
    }
}
