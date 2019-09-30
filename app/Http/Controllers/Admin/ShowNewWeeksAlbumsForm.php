<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;

class ShowNewWeeksAlbumsForm extends Controller
{
    public function __invoke()
    {
        return view("weeks-albums");
    }
}
