<?php

namespace App;

enum BookRequestsStatesType : string
{
    case pending = 'pending';
    case approved = 'approved';
    case canceled = 'canceled';
}
