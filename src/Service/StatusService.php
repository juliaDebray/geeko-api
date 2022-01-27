<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatusService extends AbstractController
{


    public function addActivatedStatus($data)
    {
        $data->setStatus('activated');

        return $data;
    }

    public function addPendingStatus($data)
    {
        $data->setStatus('pending');

        return $data;
    }

    public function addDisabledStatus($data)
    {
        $data->setStatus('disabled');

        return $data;
    }
}
