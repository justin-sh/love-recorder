<?php

namespace App\Enums;

enum EventType : string
{
    case BreastFeeding = 'breast_feeding';
    case BottleFeeding = 'bottle_feeding';
    case Wee = 'wee';
    case Poo = 'poo';
    case Weight = 'weight';
    case Bath = 'bath';
    case Others = 'others';
}
