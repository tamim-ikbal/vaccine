<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Index');
    }
}
