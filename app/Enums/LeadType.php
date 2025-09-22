<?php

namespace App\Enums;

enum LeadType: string
{
    case General = 'general';
    case CarInquiry = 'car_inquiry';
    case Contact = 'contact';
}