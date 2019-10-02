<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CurrencyConverter;
class ExampleController extends Controller
{
    use CurrencyConverter;
}
