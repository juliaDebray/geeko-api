<?php

namespace App\Constants;

class InvalidMessage
{
    // donnée non nullable
    const NOT_BLANK = 'Ce champ est requis.';
    const NOT_NULL = 'Ce champ est requis.';

    // nombre de caractères
    const MAX_MESSAGE = '{{ limit }} caractères maximum autorisés.';
    const MIN_MESSAGE = '{{ limit }} caractères minimum exigés.';

    // nombre d'ingrédients dans une potion
    const INGREDIENT_MIN = '{{ limit }} ingrédients minimum requis.';
    const INGREDIENT_MAX = '{{ limit }} ingrédients maximum requis.';

    // type de la valeur
    const BAD_TYPE = 'La valeur "{{ value }}" n\'est pas du type "{{ type }}".';

    // données déjà en base de données
    const NAME_ALREADY_EXIST = 'Ce nom existe déjà.';
    const EMAIL_ALREADY_EXIST = 'Cet email est déjà pris.';
    const PSEUDO_ALREADY_EXIST = 'Ce pseudo est déjà pris.';

    // format de la valeur
    const INVALID_EMAIL = 'Cet email est invalide.';
    const INVALID_PASSWORD = '6 caractères minimum dont une lettre minuscule, une majuscule, un caractère spécial et un chiffre.';
}
