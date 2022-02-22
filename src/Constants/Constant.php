<?php

namespace App\Constants;

class Constant
{
    // Défini le statut
    const STATUS_ACTIVATED = 'activated';
    const STATUS_PENDING = 'pending';
    const STATUS_DISABLED = "disabled";

    // Défini les roles
    const ROLE_ADMIN = ["ROLE_ADMIN"];
    const ROLE_CUSTOMER = ["ROLE_CUSTOMER"];

    // Défini le nombre d'ingrédients minimum et maximum dans une potion
    const NUMBER_INGREDIENT_MAX = 5;
    const NUMBER_INGREDIENT_MIN = 4;
}
