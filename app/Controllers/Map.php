<?php

namespace App\Controllers;

use App\Models\GejalaModel;

class Map extends BaseController
{

    public function index(): string
    {
        return view('map');
    }
}
