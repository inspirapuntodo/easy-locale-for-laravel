<?php

namespace InspiraPuntoDo\EasyLocale\Enums;

enum FileCreationStatusEnum: string
{
    case CREATED        = 'created';
    case ALREADY_EXISTS = 'already_exists';
    case ERROR          = 'error';
}
