<?php

namespace App\Exception;

use App\Constants\ErrorMessage;

class IngredientTypeNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorMessage::INGREDIENT_TYPE_NOT_FOUND);
    }
}
