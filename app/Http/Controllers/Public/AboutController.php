<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Core\SchoolClass;

class AboutController extends Controller
{
    public function profile()
    {
        $class = SchoolClass::with('members')->where('status', 'ACTIVE')->first();
        return view('pages.public.about', compact('class'));
    }
}