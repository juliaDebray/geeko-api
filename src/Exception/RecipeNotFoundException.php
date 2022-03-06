<?php

namespace App\Exception;

use App\Constants\ErrorMessage;

class RecipeNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorMessage::RECIPE_NOT_FOUND);
    }
}
