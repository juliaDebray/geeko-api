<?php

namespace App\Constants;

class InvalidMessage
{
    // donnée non nullable
    const NOT_BLANK = 'ce champ est recquis';
    const NOT_NULL = 'ce champ est recquis';

    // nombre de caractères
    const MAX_MESSAGE = '{{ limit }} caractères maximum autorisé.';
    const MIN_MESSAGE = '{{ limit }} caractères minimum exigé.';

    // nombre d'ingrédients dans une potion
    const INGREDIENT_MIN = "Il ne peut y avoir moins de {{ limit }} ingrédients";
    const INGREDIENT_MAX = "Il ne peut y avoir plus de {{ limit }}  ingrédients";

    // type de la valeur
    const BAD_TYPE = 'La valeur {{ value }} n\'est pas du type {{ type }}';

    // données déjà en base de données
    const NAME_ALREADY_EXIST = 'Ce nom existe déjà';
    const EMAIL_ALREADY_EXIST = 'Ce mail est déjà pris';
    const PSEUDO_ALREADY_EXIST = 'Ce pseudo est déjà pris';

    // format de la valeur
    const INVALID_EMAIL = 'Cet email est invalide';
    const REGEX ='"6 caractères minimum dont une lettre minuscule, une majuscule, un caractère spécial et un chiffre';
}
