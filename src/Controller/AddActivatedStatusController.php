<?php

namespace App\Controller;

use App\Constants\Constant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddActivatedStatusController extends AbstractController
{
    public function __invoke($data)
    {
        return $data->setStatus(Constant::STATUS_ACTIVATED);
    }
}
