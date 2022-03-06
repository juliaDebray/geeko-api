<?php

namespace App\Exception;

use App\Constants\ErrorMessage;

class PotionTypeNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorMessage::POTION_TYPE_NOT_FOUND);
    }
}
