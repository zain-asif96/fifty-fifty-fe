<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ErrorsController extends Controller
{
    public function notSupported(): Response
    {
        return Inertia::render('Errors/CountryNotSupported');
    }
}
