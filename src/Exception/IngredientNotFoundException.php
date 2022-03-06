<?php

namespace App\Exception;

use App\Constants\ErrorMessage;

class IngredientNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorMessage::INGREDIENT_NOT_FOUND);
    }
}
