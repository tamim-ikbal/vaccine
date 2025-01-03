<?php

namespace App\Enums;

enum VerificationMethod: string
{
    case MAIL = 'mail';
    case SMS = 'sms';
}
