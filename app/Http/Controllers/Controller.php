<?php

namespace App\Http\Controllers;

use App\Traits\HandleApiRequestException;

abstract class Controller
{
    use HandleApiRequestException;
}
