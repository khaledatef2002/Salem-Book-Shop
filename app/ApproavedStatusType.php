<?php

namespace App;

enum ApproavedStatusType: string
{
    case pending = 'pending';
    case approaved = 'approaved';
    case canceled = 'canceled';
}