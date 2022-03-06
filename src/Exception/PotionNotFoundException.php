<?php

namespace App\Exception;

use App\Constants\ErrorMessage;

class PotionNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorMessage::POTION_NOT_FOUND);
    }
}
