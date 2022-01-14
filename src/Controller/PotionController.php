<?php

namespace App\Controller;

use App\Entity\Potion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTime;

class PotionController extends AbstractController
{
    public function __invoke(Potion $data): Potion
    {
        $user = $this->getUser();
        $data->setCustomer($user);
        $data->setCreatedAt(new DateTime('now'));
        return $data;
    }
}
