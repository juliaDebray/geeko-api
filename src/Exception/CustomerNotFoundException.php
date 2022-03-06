<?php

namespace App\Exception;

use App\Constants\ErrorMessage;

class CustomerNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorMessage::CUSTOMER_NOT_FOUND);
    }
}
