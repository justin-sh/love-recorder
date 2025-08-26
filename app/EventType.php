<?php

namespace App;

enum EventType : string
{
    case BreastFeeding = 'breast_feeding';
    case BottleFeeding = 'bottle_feeding';
    case Wee = 'wee';
    case Poo = 'poo';
    case Bath = 'bath';
    case Others = 'others';
}
